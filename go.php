<?php
include_once "./init.php";
$directGo = false; //是否直接跳转
$errorPage = BLOG_URL . '/404.html';
$home = BLOG_URL; //这里定义你的博客的访问地址，请注意修改为你自己的
$refer = empty($_SERVER['HTTP_REFERER']) ? BLOG_URL : $_SERVER['HTTP_REFERER'];
function printPic($pic) {
	header('Content-Type: image/gif');
	switch ($pic) {
	case 'fav':
		echo base64_decode('R0lGODlhEAAQAMQfAMrJuFSX3cjk/7TU96TM8/H+/3Ss5+Xkz63R+Gik49fWw5K+7MXb6F2UzE+T2Z/I83qw6MDe+5fE8pvC5lGNypLF+s/q/0iO1ZfL/Xu18U6LzZDA8Vma3JnL/Wec0f///yH5BAEAAB8ALAAAAAAQABAAAAWD4CeOH8OQKFphaYsVRdeqcDWXRGbtVkacogUksSEILJGIRUDYJCCbQSKJQAyqWEFk+iEkEJKN5CEJPxDf0dDANkDaT9QiEeAE7oHEIrW4BBx3gBcTKQYXFxwODokXECmAiRSSHIkpGhQNhB8TDRQaKQ0eACQAAA0jBwqlAAoHrq6rrCEAOw==');
		break;
	case 'nt':
		echo base64_decode('R0lGODlhEAAQAOZ/AADOy8vxudPzuFTVgqfguXXs4HLMdTHDa+j5y5T6xnbqmQDA2ACz1wDb0Ry+yND22bbop4TUxQDvX8/6ywC2yrz01ZL12gDEV3rWfADI6gCkzQDf4T7o4qzpnkr0xQDuxMbytGW/bACaJAClRIjpjQDydADeYQDUzU2wYDa0bPb89v3+/e337wCmN9j33l/miADM2sHorITqn23ikWzajVDGfADVbkbTdxjdb6fmlwDK4ADtggDK1wDK5ADtoZbr3SXJ0pHfzXf+uY/8uQDXUgDN2gDeZQCpUJ/ozZrmrZzkxbHevnjynwDgvwDlsQDsZwDF7QDKgQC4jwDC1ADEhgDG4wCeLwDDvgDG2aDZjgDseADCqY3XpQng5ACwTGT8zgDYyADcvwDwrrrqzADnuHbjyXPj2t/2w3Pu04nt1mr+tQDg1bLuqgDR2/f9+ADplgDeigDzfZTShwDL1ADYXLvkx8301Q/fbwD8oAC4QgDC3gDC6JPhlxLjdHvfhP///yH5BAEAAH8ALAAAAAAQABAAAAf5gH+Cfy4KfUYmdwoPg4MrMiZsAWNISkl0M26OLyQID3ZpP2ZmQTQ3KoIyJGcTDxUFBV0bDUoYA4QmCENCCRYcHEVzTUwgeWMKHQFqXxUbGzAnPnFxfFk1fQJMeBYVbTBrJRISTzcxXkZnOyUeaAsnH2JaEkQHAS0mZ31vHgs6DCdkwlyhkiKAFRwBXnxooCdDBgYaNFDYEgLCiBk5OsBxskAPlD0QKUjBICeFnQsCbNgAsADKwy1RUMQQsWQFDQw5BoCZ0qMKhQMo5IRIIUjFAQMgygDhgcWBHwghjrAYpKJGCy4RshKQIyLF1EZ/6hwYYcXKiBRLGgUCADs=');
		break;
	default:
		echo base64_decode('R0lGODlhGAAYANUAAEuM9yZfvDBqy8TExPr6+v7+/tHR0e3t7e7u7uDg4Cxmxru7uyljwc3Nzenp6fv7++Xl5fLy8tjY2N7e3vDw8O/v7y1drNTU1MbT6Obm5sjIyMXFxb3M5b+/vzBfrfT09Ly8vBlPpjl22vHx8eTk5EhytuHh4eLi4iRct/n5+f39/RpQqPf39zNu0Dt43CFYsxxSqx5Vr97d3UOD6/z8/Pb29hdMo////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAYABgAAAb/wJtwSCwajZiSbclsLkuY480iAlivWKvIUiwIbbOweDy2Cb031dfFbt/acHNaSPu27nchfi+neQlfAoICQ4OGcgReKV8KjVKNCnIpaixfDJcymZqZlwxyLJRfAaMBmqSnn3U1XyitrZmusXI1ql8vt7gyuLuztTc2McHCw8O9N6u/MMrLzMzGNWoeISvU1dbUIR5ptMeLHBZO4TYWHDcp3DUID1JSDwjcLAgkI4DsQgQjJAgsdSwUEBIaDOgAYoHBgyA6DGggAQIFUOYiOJhwoYGGDQMyatygocGFCQ4iTLpBoEaFDBMkXDDAsiXLCxImZKhQI9ENGik+VHAA4YSJNQRAg5o4AcFBhQ8p/KR5cC4CBQQHokqNioBChBopHqi5UUAFDQIpWLCoQbYsWbEpCNBQgSYIADs=');
	}
}
if (!empty($_GET['pic'])) {
	printPic($_GET['pic']);
}
if (empty($_GET['url']) && empty($_GET['pic'])) {
	show_404_page();
} else {
	$url = $_GET['url'];
	$url = htmlspecialchars($url);
	$url = (!preg_match("/^https?\:\/\//i", $url)) ? "https://" . $url : $url;
	if ($directGo) //若設定了直接跳转
	{
		header('Location:' . $url); //直接跳转
		exit();
	}
	if (strpos($_SERVER['HTTP_REFERER'], $home) === false) //非本站引用
	{
		show_404_page();
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>之晴网 - </title>
        <meta name="keywords" content="之晴网,之晴的博客,之晴,php,mysql,linux">
        <meta name="description" content="之晴网,提供个人参考学习的资料文档，php建站经验交流，在这里与大家分享WEB互联网PHP建站技术与经验，WEB开发中所需要的资料及技术知识分享平台。可以相互学习和分享php应用,Apache,Linux服务器管理等WEB开发知识与经验。">
        <script language="javascript" type="text/javascript" >
        var userAgent = navigator.userAgent.toLowerCase();
        var is_opera = userAgent.indexOf('opera') != -1 && opera.version();
        var is_moz = (navigator.product == 'Gecko') && userAgent.substr(userAgent.indexOf('firefox') + 8, 3);
        var is_ie = (userAgent.indexOf('msie') != -1 && !is_opera) && userAgent.substr(userAgent.indexOf('msie') + 5, 3);
        var is_safari = (userAgent.indexOf('webkit') != -1 || userAgent.indexOf('safari') != -1);
        //iframe包含
        if (top.location != location) {
        top.location.href = location.href;
        }
        //复制URL地址
        function setCopy(_sTxt){
        if(is_ie) {
        clipboardData.setData('Text',_sTxt);
        alert ("网址“"+_sTxt+"”\n已经复制到您的剪贴板中\n您可以使用Ctrl+V快捷键粘贴到需要的地方");
        } else {
        prompt("请复制网站地址:",_sTxt);
        }
        }
        ﻿function mybookmark(title,url){
        var title=title?title:document.title;
        var url=url?url:document.location.href;
        if(document.all)
        window.external.AddFavorite( url, title);
        else if (window.sidebar)
        window.sidebar.addPanel(title, url,"");
        else if( window.opera && window.print )
        {
        var mbm = document.createElement('a');
        mbm.setAttribute('rel','sidebar');
        mbm.setAttribute('href',url);
        mbm.setAttribute('title',title);
        mbm.click();
        }
        }
        </script>
        <style type="text/css">
        * { word-break: break-all; word-wrap: break-word; }
        body, th, td, input, select, textarea, button { font: 12px/1.5em Verdana, "Lucida Grande",Arial, Helvetica,sans-serif; }
        body, h1, h2, h3, h4, h5, h6, p, ul, dl, dt, dd, form, fieldset { margin: 0; padding: 0; }
        h1, h2, h3, h4, h5, h6 { font-size: 1em; }
        ul li { list-style: none; }
        a {color: #2C629E; text-decoration: none; }
        a:hover { text-decoration: underline; }
        a img { border: none; }
        .link_td { text-align:right;width: 100%; height: 26px; border-bottom: 1px solid #DDD; background: #EEE; padding-left:1em; font-size:12px; }
        .link_td a { color: #333; }
        textarea { border: 1px solid #ddd; overflow: auto; }
        .t_input { padding: 3px 2px; border: 1px solid #ddd; line-height: 16px; }
        </style>
    </head>
    <body scroll="no">
        <div id="append_parent"><iframe id="ajaxframe" name="ajaxframe" width="0" height="0" marginwidth="0" frameborder="0" src="about:blank"></iframe></div>
        <div id="ajaxwaitid"></div>
        <table border="0" cellPadding="0" cellSpacing="0" height="100%" width="100%">
            <tr>
                <td height="26" class="link_td">
                    您正在浏览的网站是：<img src="go.php?pic=nt" align="absmiddle"> <a target="_blank" href="<?php echo $url; ?> "><?php echo $url; ?></a> <span class="pipe">&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;之晴对以下内容不负责&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <img src="go.php?pic=back" align="absmiddle"> <a href="<?php echo $refer; ?>"> 返回</a>
                </td>
            </tr>
            <tr>
                <td>
                    <iframe id="url_mainframe" frameborder="0" scrolling="yes" name="main" src="<?php echo $url; ?> " style="height: 100%; visibility: inherit; width: 100%; z-index: 1;overflow: visible;"></iframe>
                </td>
            </tr>
        </table>
    </body>
</html>
<?php echo ob_get_clean(); ?>