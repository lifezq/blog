<?php
/**
 * Plugin Name: 文章分页(JA_Page)
 * Version: Beta 1.3
 * Plugin URL: http://www.gouji.org/?post=224
 * Description: 文章分页 1.3 测试版!&nbsp; 1. 新增 Ajax 无刷翻页 功能&nbsp; 2. 新增  翻页后弹性返回顶部 功能<br><script>tip_();</script>
 * Author: 简爱
 * Author Email: sc.419@qq.com
 * Author URL: http://www.gouji.org/
 * 时间: 20130618
 * 使用方法:
 *   1. 安装本插件
 *
 *   2. 修改模板 echo_log.php 文件
 *        找到 echo $log_content;
 *        修改为 if(function_exists("JA_Page")) echo JA_Page($log_content, $logid); else echo $log_content;
 *
 *   3. 在文章需要分页的位置 [ 插入分页符 ]
 *
 *   4. beta 1.3 新增 Ajax无刷翻页、翻页后弹性返回顶部 功能
 *
 *   更新、帮助地址 http://www.gouji.org/?post=224
***/

if(isset($_GET['JA_Page_lib']) && function_exists("JA_Page_lib_".$_GET['JA_Page_lib'])){
  call_user_func("JA_Page_lib_".$_GET['JA_Page_lib']);
  exit;
}
if(isset($_POST['JA_Page_sum']) && isset($_POST['JA_Page_id'])){
  require_once '../../../init.php';
  $JA_Page_Log_Model = new Log_Model();
  $JA_Page_Log_arr = $JA_Page_Log_Model->getOneLogForHome($_POST['JA_Page_id']);
  echo JA_Page($JA_Page_Log_arr['log_content'], $JA_Page_Log_arr['logid']);
  exit;
}
!defined('EMLOG_ROOT') && exit('access deined!');
addAction('adm_writelog_head', 'JA_Page_write');

function JA_Page($log_content, $logid){
  $JA_Page_Mark = "<hr style=\"page-break-after:always;\" id=\"JA_Page\" class=\"ke-pagebreak\" />";
  if(!strpos($log_content, $JA_Page_Mark)) $N = "N";

  $JA_Page_config = array(
    'Page'     => true,  // 是否启用 Ajax 无刷 翻页 true / false (视情况而定 默认 启用：true)

    'Position' => "c",
    /* 设置 分页导航条位置
       相对于文章的位置
          A：上下  显示 两 个
          B: 上    显示 一 个
          C: 下    显示 一 个  (默认选项)    */
  );
  if(isset($N)){
    $page_code = "<!-- JA_Page Start -->\r\n<div class=\"JA_Page\">\r\n  <span id=\"文章分页 By 简爱's Blog http://www.gouji.org/\"><b>简爱提示： &nbsp; 本文无分页</b></span>\r\n</div>\r\n<!-- JA_Page End -->";
  }else{
    $JA_url = ".".strrchr(Url::log($logid), "/"); // 获取文章地址 最后部分
    if(strpos($JA_url, "?")) $JA_url .= "&page="; else $JA_url .= "?page="; // 组合新网址
    $JA_content_list = explode($JA_Page_Mark, $log_content); // 分割 文章
    $JA_page_count = count($JA_content_list); // 页数计算
    if(isset($_POST['JA_Page_sum']) && isset($_POST['JA_Page_id'])){
      $JA_page = !empty($_POST['JA_Page_sum']) ? intval($_POST['JA_Page_sum']) : 1;
    }else{
      $JA_page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
    }
    $JA_page = ($JA_page > $JA_page_count && $JA_page_count>0) ? $JA_page_count : $JA_page;
    $log_content = stripslashes($JA_content_list[$JA_page -1]);
    if($JA_Page_config['Page'] === true){
      $page_code = JA_Page_s($JA_page_count, $JA_page, "javascript:JA_Page_Ajax({$logid},", ');');
      $JA_Page_Ajax = "<script src=\"".BLOG_URL."/content/plugins/JA_Page/JA_Page.php?JA_Page_lib=js1\" type=\"text/javascript\"></script>\r\n";
    }else{
      $page_code = pagination($JA_page_count, 1, $JA_page, $JA_url);
      $JA_Page_Ajax = '';
    }
    $page_code = "\r\n<!-- JA_Page Start -->\r\n<div class=\"JA_Page\">\r\n  <span id=\"文章分页 By 简爱's Blog http://www.gouji.org/\"><b>文章分页：</b></span>".$page_code."\r\n</div>\r\n<!-- JA_Page End -->";
  }
  $JA_log_content = "\r\n<link href=\"".BLOG_URL."/content/plugins/JA_Page/JA_Page.php?JA_Page_lib=css1\" rel=\"stylesheet\" type=\"text/css\" />\r\n{$JA_Page_Ajax}<div id=\"JA_Page\">";
  $W = strtoupper($JA_Page_config['Position']);
  $JA_log_content_ = '';
  if($W=="A"){
    $JA_log_content_ .= "\r\n".$page_code."<br />\r\n\r\n\r\n";
    $JA_log_content_ .= $log_content;
    $JA_log_content_ .= "<br /><br />\r\n".$page_code."\r\n\r\n\r\n";
  }elseif($W=="B"){
    $JA_log_content_ .= "\r\n".$page_code."<br />\r\n\r\n\r\n";
    $JA_log_content_ .= $log_content;
  }else{
    $JA_log_content_ .= $log_content;
    $JA_log_content_ .= "<br /><br />\r\n".$page_code."\r\n\r\n\r\n";
  }
  $JA_log_content .= $JA_log_content_;
  $JA_log_content .= "</div>\r\n";
  if(isset($_POST['JA_Page_sum']) && isset($_POST['JA_Page_id'])) return $JA_log_content_;
  return $JA_log_content;
}

// 分页函数 由 EM 内核 改编而来
function JA_Page_s($pnums, $page, $url, $anchor=''){
  $re = '';
  for($i = $page - 5; $i <= $page + 5 && $i <= $pnums; $i++){
    if($i > 0){if($i == $page) $re .= " <span>$i</span> "; else $re .= " <a href=\"$url$i$anchor\">$i</a> ";}
  }
  if($page > 6) $re = "<a href=\"$url$i$anchor\" title=\"首页\">&laquo;</a><em>...</em>$re";
  if($page + 5 < $pnums) $re .= "<em>...</em> <a href=\"$url$pnums$anchor\" title=\"尾页\">&raquo;</a>";
  if($pnums <= 1) $re = '';
  return $re;
}

function JA_Page_lib_img1(){
  header("Content-type: image/png");
  echo base64_decode(
    "iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/".
    "9hAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0A".
    "AHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5".
    "JfxUYAAAELSURBVHjalFItrsMwGPP39EDCkrKWlY0H".
    "jfYIoztfYctGd4NeodNIxtawhvmhVenf22bJSmJ9sR".
    "w5IImmaUgSfd+TAAnQez8xPafzJPGDBEopPLxPJeRF".
    "gYf3yIsCW/hdDodhAABorWf6UnthliCOI4y1UxpjLe".
    "I4TjTWAiL7CZTWkuxn6x6EJK7XK0MI+BTGGFRVJVOC".
    "sizxfD4/NsiybP6EGCPu9/vbi6fTSVbistc9DsPArb".
    "lZC7fbjUsCQF3XNMbI8XhE27bcrVEpteILIQTmeb4y".
    "mdWodyo7HA64XC4AwPP5LAC2DbYQY6RzTpxz779yGn".
    "lpkszIfwaCLyEk0XUdv73onBMA+BsA3TjDQAA5ZHAA".
    "AAAASUVORK5CYII="
  );
}

function JA_Page_lib_js1(){
  header("Content-type: text/javascript");
  echo 'function Ajax_(e,t){this.url=e,this.data=t,this.browser=function(){return navigator.userAgent.indexOf("MSIE")>0?"MSIE":"other"}()}function JA_Page_Ajax(e,t){var n=\'<div class="JA_Page">\r\n  <span id="文章分页 By 简爱 http://www.gouji.org/"><b> &nbsp; &nbsp; 文章加载中... &nbsp; &nbsp; </b></span>\r\n</div>\';document.getElementById("JA_Page").innerHTML=n;var r="JA_Page_sum="+t+"&JA_Page_id="+e,i=new Ajax_("'.BLOG_URL.'/content/plugins/JA_Page/JA_Page.php",r),n=i.post();document.getElementById("JA_Page").innerHTML=n,g_Top()}function g_Top(){function t(){setScrollTop(getScrollTop()/1.1),getScrollTop()<1&&clearInterval(e)}var e=setInterval(t,10)}Ajax_.prototype={post:function(){var e,t;return this.browser=="MSIE"?t=new ActiveXObject("microsoft.xmlhttp"):t=new XMLHttpRequest,t.onreadystatechange=function(){e=t.responseText},t.open("POST",this.url,!1),t.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),t.send(this.data),e}}';
}

function JA_Page_lib_css1(){
  header("Content-type: text/css");
  echo '.JA_Page {width:100%;font-size:12px;} .JA_Page a{box-shadow:0px 1px 5px #ddd; background:#fff; border:1px solid #ccc; border-radius:3px; padding:2px 5px;} .JA_Page a:hover{text-decoration: none; background:#08d; color:#fff;} .JA_Page span{background:#f00; color:#fff; line-height:23px; padding:2px 5px; margin-left:0px; border:1px solid #ccc; border-radius:3px;} .JA_Page span:hover{text-decoration: none; background:#f00; color:#fff;}';
}

function JA_Page_lib_js2(){
  header("Content-type: text/javascript");
  echo "function tip_(){tips_();getData_();}function getData_(){var e=document.getElementById('JA_weather'),t=new Ajax_('http://www.gouji.org/api/weather/7.php','');txt=t.post(),e.innerHTML='loading ...';var n=new Array;n=txt.split(','),text='&nbsp; ['+n[0]+'] '+n[1]+'&nbsp; 更新于: '+n[8],n[9]&&(text+='&nbsp; '+n[9]),e.innerHTML=text}function tips_(){var e=new Date,t=new Array('日','一','二','三','四','五','六'),n=navigator.userAgent.indexOf('MSIE');n!=-1?year=e.getFullYear():year=e.getYear()+1900,tdate=year+'年'+(e.getMonth()+1)+'月'+e.getDate()+'日'+' 星期'+t[e.getDay()];var r=(new Date).getHours();r<6?hello='  凌晨好! ':r<9?hello='新的一天，新的开始! ':r<12?hello='上午您过的咋样呢？ ':r<14?hello='下午您还有工作吗？ ':r<17?hello='下午过的咋样呢？':r<19?hello='傍晚了， 您吃晚饭了吗？':r<22?hello='现在您在做什么呢？':hello='夜深了。 亲，该休息了！',document.write(' '+hello+tdate+'<span id=\"JA_weather\"></span>')}";
}

addAction('adm_head','JA_Page_lib_js');
function JA_Page_lib_js(){
  echo '<script type="text/javascript" src="'.BLOG_URL.'/content/plugins/JA_Page/JA_Page.php?JA_Page_lib=js1"></script>';
  echo '<script type="text/javascript" src="'.BLOG_URL.'/content/plugins/JA_Page/JA_Page.php?JA_Page_lib=js2"></script>';
}
function JA_Page_write(){
  if(Option::EMLOG_VERSION <= '5.1.0'){
    $add_JA_Page = "
    if (parent.KE.g['content'].wyswygMode == false){
      alert('请先切换到所见所得模式');
    }else{
      parent.KE.insertHtml('content','<hr style=\"page-break-after:always;\" id=\"JA_Page\" class=\"ke-pagebreak\" />');
    }";
  }else{
    $add_JA_Page = "
    if(parent.editorMap['content'].designMode === false){
      alert('请先切换到所见所得模式');
    }else{
      parent.editorMap['content'].insertHtml('<hr style=\"page-break-after:always;\" id=\"JA_Page\" class=\"ke-pagebreak\" />');
    }";
  }
  echo "<script type=\"text/javascript\">
  function add_JA_Page(){".$add_JA_Page."
  }
  </script> &nbsp;
  <a href=\"javascript: add_JA_Page();\" title=\"为文章插入分页标示符\" class=\"thickbox\"><img src=\"".BLOG_URL."/content/plugins/JA_Page/JA_Page.php?JA_Page_lib=img1\" align=\"absbottom\" title=\"为文章插入分页标示符\" border=\"0\" />[ 插入分页符 ]</a> &nbsp;";
}
