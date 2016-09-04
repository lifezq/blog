<?php
/*
Plugin Name: 读者墙
Version: 4.2.3
Plugin URL: http://xiaosong.org/share/emlog-readers-wall-plug-reloaded
Description: 页面或文章正文,侧边栏显示读者墙
ForEmlog: 4.1.0以上
Author: 小松
Author Email: sahala_2007@126.com
Author URL: http://xiaosong.org
*/
!defined('EMLOG_ROOT') && exit('access deined!');
require_once('reader_wall_config.php');
function reader_wall(){
	global $imgnum_week,$imgnum_month,$imgnum_all,$imgsize_week,$imgsize_month,$imgsize_all,$tip;
	$CACHE = Cache::getInstance();
	$user_cache = $CACHE->readCache('user');
	$content = ob_get_clean();
	if (Option::get('isgzipenable') == 'y' && function_exists('ob_gzhandler')){
		ob_start('ob_gzhandler');
	} else {
		ob_start();
	}

	$content = explode("<body",$content);
    if (count($content)<=1){
        return;
    }

	$log_content = $content[1];
	if(strpos($log_content, '[READERWALL-WEEK]') > -1) {
		$cur_time_span = strtotime('last Monday',strtotime('Sunday'));
		$option = 0;
		$imgnums = $imgnum_week;
		$imgsize = $imgsize_week;
	}
	elseif(strpos($log_content, '[READERWALL-MONTH]') > -1){
		$cur_time_span = strtotime('this month',strtotime(date('m/01/y')));
		$option = 1;
    $imgnums = $imgnum_month;
		$imgsize = $imgsize_month;
	}

	else{$cur_time_span = 0;$option = 2;$imgnums = $imgnum_all;$imgsize = $imgsize_all;}
	if(empty($imgsize)){$imgsize = 32;}
	$DB = Database::getInstance();
	$userName = $user_cache[1]['name'];
	$userMail = $user_cache[1]['mail'];
	$sql = "SELECT count(1) AS comment_nums,poster,mail,url FROM ".DB_PREFIX."comment where date > $cur_time_span and mail != '' and mail != '$userMail' and poster != '$userName' and hide = 'n' group by mail order by comment_nums DESC limit 0,$imgnums";
	$result = $DB->query($sql);
	while($row = $DB->fetch_array($result)){
		$img = "<img width='".$imgsize."' height='".$imgsize."' title='".$row['poster']." (".$row['comment_nums'].")' alt='' src='".getGravatar($row['mail'],$imgsize)."'  rel='nofollow'/>";
		if($row['url']){
		$tmp = "<a href='".$row['url']."' target='_blank' rel='nofollow'>".$img."</a>";
		}else{$tmp = "<a href='javascript:;'>".$img."</a>";}
		$output .= $tmp;
	  }
	  if(empty($output)){
	    $output = "<p style='text-align:center'>".$tip."</p>";
	  }else{
	    $output = "<div style='text-align:center'><div id='readerswall'>".$output."</div></div>";}
	if($option == 0)
		$log_content = preg_replace("'\[READERWALL-WEEK\]'i", $output, $log_content, 1);
	elseif($option == 1)
		$log_content = preg_replace("'\[READERWALL-MONTH\]'i", $output, $log_content, 1);
	else
		$log_content = preg_replace("'\[READERWALL\]'i", $output, $log_content, 1);
	echo $content[0].'<body'.$log_content;
	unset($content);
	unset($log_content);
}
addAction('index_footer', 'reader_wall');
function reader_wall_side(){
	global $imgsize_side,$imgnum_side,$type_wall,$tip,$open;
	$CACHE = Cache::getInstance();
	$user_cache = $CACHE->readCache('user');
	if($type_wall == 'week'){
		$time_side = strtotime('last Monday',strtotime('Sunday'));
	}elseif($type_wall == 'month'){
		$time_side = strtotime('this month',strtotime(date('m/01/y')));
	}else{
		$time_side = 0;
	}
	if(empty($imgsize_side)){
		$imgsize_side = 32;
	}
	$DB = Database::getInstance();
	$userName = $user_cache[1]['name'];
	$sql_side = "SELECT count(1) AS comment_nums,poster,mail,url FROM ".DB_PREFIX."comment where date > $time_side and mail != '' and poster != '$userName' and hide ='n' group by mail order by comment_nums DESC limit 0,$imgnum_side";
	$result_side = $DB->query($sql_side);
	while($row_side = $DB->fetch_array($result_side)){
		$img_side = "<img width='".$imgsize_side."' height='".$imgsize_side."' title='".$row_side['poster']." (".$row_side['comment_nums'].")' alt=''  src='".getGravatar($row_side['mail'],$imgsize_side)."' />";
		if($row_side['url']){
		$tmp_side = "<a href='".$row_side['url']."' target='_blank'>".$img_side."</a>";
		}else{
			$tmp_side = $img_side;
		}
		$output_side .= $tmp_side;
	}
	if(empty($output_side)){
		$output_side = "<p style='text-align:center'>".$tip."</p>";
	}else{
		$output_side = "<div id='readerswall_side'>".$output_side."</div>";
	}
	return $output_side;
}
if(isset($_GET['reader_wall_widgets'])){
	echo 'document.write("'.reader_wall_side().'")';
	exit;
}
function reader_wall_menu(){
	echo '<div class="sidebarsubmenu" id="reader_wall"><a href="./plugin.php?plugin=reader_wall">读者墙设置</a></div>';
}
addAction('adm_sidebar_ext', 'reader_wall_menu');
?>
