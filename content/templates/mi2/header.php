<?php
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
require_once View::getView('module');
include 'includes/opinion.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta property="qc:admins" content="321772626764165216375" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="x-ua-compatible" content="IE=7"/>
        <title><?php

if (strlen($site_title) < 42 && strlen($site_title) >= 39) {
	echo '碎碎念 ' . $site_title;
} else {
	echo $site_title;
}
?></title>
        <!-- <meta id="viewport" name="viewport" content="width=device-width; initial-scale=1.0;maximum-scale=1.0; user-scalable=no;"/> -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="keywords" content="<?php echo $site_key; ?>" />
        <meta name="description" content="<?php echo $site_description; ?>" />
        <meta name="generator" content="之晴" />
        <link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo BLOG_URL; ?>xmlrpc.php?rsd" />
        <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo BLOG_URL; ?>wlwmanifest.xml" />
        <link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />
        <link href="<?php echo TEMPLATE_URL; ?>css/main.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo TEMPLATE_URL; ?>css/style.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL; ?>css/thickbox.css"/>
        <?php doAction('index_head');?>
        <script type="text/javascript">
        //获取浏览器宽度方法,以及下面是根据用户浏览器宽度自适应页面宽度
        function getBrowserWidth(){
        var  _clientWidth;
        if(document.documentElement && document.documentElement.clientWidth){
        _clientWidth = document.documentElement.clientWidth; //获取浏览器当前宽度
        }else if(document.body && document.body.clientWidth){
        _clientWidth = document.body.clientWidth ;   //主要是在ie获取浏览器当前宽度
        }else if(document.documentElement && document.documentElement.offsetWidth){
        _clientWidth = document.documentElement.offsetWidth; //网页可见区域宽,包括边线的宽)
        }else if(document.body && document.body.offsetWidth){
        _clientWidth = document.body.offsetWidth; //网页可见区域宽,包括边线的宽)
        }else if(window.screen.availWidth){
        _clientWidth = window.screen.availWidth;//获取屏幕分辨率有效宽度
        }else{
        _clientWidth = 1024;//默认宽度为1024
        }
        return _clientWidth;
        }
        //写cookies
        function setCookie(name,value)
        {
        var Days = 30;
        var exp = new Date();
        exp.setTime(exp.getTime() + Days*24*60*60*1000);
        document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
        }
        //读取cookies
        function getCookie(name)
        {
        var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
        if(arr=document.cookie.match(reg)) return unescape(arr[2]);
        else return null;
        }
        if(!getCookie('_bodyW')){
        var _bodyW=getBrowserWidth()-48;//浏览器两边空白
        setCookie('_bodyW',_bodyW);
        window.location.reload();
        }
        //当用户窗口大小改变时，清除cookie并重新加载，以达到页面自动适应浏览器
        function resizeReload(){
        //清除cookie
        document.cookie = "_bodyW=''; expires=Thu, 01-Jan-70 00:00:01 GMT";
        window.location.reload();
        }
        // window.onresize=resizeReload;//当用户窗口大小发生变化时触发
        </script>
        <?php if (isset($_COOKIE['_bodyW']) && $_COOKIE['_bodyW'] > 1310): ?>
        <style type="text/css">
        .zq_top,.wp{width:<?php echo $_COOKIE['_bodyW']; ?>px;}
        .content,.page .content{width:955px;}
        #echolog .content{width:915px;}
        .lists_m{width:940px;}
        .sidebar{width:345px;}
        .side_box{width:343px;}
        #qqwb_share__{margin-left:40px;}
        #tw .top{width:850px;}
        #tw ul{width:820px;}
        #tw ul li  .post1,#tw ul li .bttome  .post{width:750px;}
        </style>
        <?php elseif (isset($_COOKIE['_bodyW']) && $_COOKIE['_bodyW'] > 1200): ?>
        <style type="text/css">
        .zq_top,.wp{width:<?php echo $_COOKIE['_bodyW']; ?>px;}
        .content,.page .content{width:955px;}
        #echolog .content{width:915px;}
        .lists_m{width:940px;}
        #tw .top{width:850px;}
        #tw ul{width:820px;}
        #tw ul li  .post1,#tw ul li .bttome .post{width:750px;}
        </style>
        <?php endif;?>
        <!--<script src="http://mat1.gtimg.com/app/openjs/openjs.js#autoboot=no&debug=no"></script>-->
    </head>
    <body>
        <div class="zq_top">
            <div class="cl" id="toptb">
                <div class="wp">
                    <div class="z">
                        <a href="javascript:void(0);" onClick="SetHome(this,'<?php echo BLOG_URL; ?>');">设为首页</a>
                        <a href="javascript:void(0);" onClick="AddFavorite('<?php echo BLOG_URL; ?>',document.title)">收藏本站</a>
                        <?php echo $toptb_left_url; ?>
                    </div>
                    <div class="y">
                        <?php
global $CACHE;
$user_cache = $CACHE->readCache('user');
?>
                        <?php if (!empty($user_cache[UID]['photo']['src'])): ?>
                        <a href="<?php echo BLOG_URL; ?>admin">
                            <img style="vertical-align: top;" src="<?php echo BLOG_URL . $user_cache[UID]['photo']['src']; ?>" id="login_img" title="<?php echo $user_cache[UID]['name']; ?>" alt="<?php echo $user_cache[UID]['name']; ?>" >
                        </a>
                        <a href="javascript:;" style="cursor: none;text-decoration:none;">您好， </a> <a href="<?php echo BLOG_URL; ?>admin" title="<?php echo $user_cache[UID]['name']; ?>"><?php echo $user_cache[UID]['name']; ?></a>
                        <?php elseif (!empty($user_cache[UID]['name'])): ?>
                        <a href="javascript:;" style="cursor: none;text-decoration:none;">您好， </a> <a href="<?php echo BLOG_URL; ?>admin" title="<?php echo $user_cache[UID]['name']; ?>"><?php echo $user_cache[UID]['name']; ?></a>
                        <?php elseif (isset($_COOKIE['qq-username'])): ?>
                        <a href="<?php echo BLOG_URL; ?>admin">
                            <img style="width:15px;height:16px;vertical-align: top;" src="<?php echo BLOG_URL . 'content/uploadfile/com/connect_qq.gif'; ?>" id="login_img" title="<?php echo $_COOKIE['qq-username']; ?>" alt="<?php echo $_COOKIE['qq-username']; ?>">
                        </a>
                        <a href="javascript:;" style="cursor: none;text-decoration:none;">您好， </a> <a href="<?php echo BLOG_URL; ?>admin" title="<?php echo $_COOKIE['qq-username']; ?>"><?php echo $_COOKIE['qq-username']; ?></a>
                        <a href="javascript:;" title="完善帐户信息"  onClick="this.href='comAccount'" class="thickbox" >完善帐户信息</a>
                        <a href="javascript:;" title="绑定已有帐号" onClick="this.href='bindAccount'" class="thickbox" >绑定已有帐号</a>
                        <a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a>
                        <?php elseif (isset($_COOKIE['sina-username'])): ?>
                        <a href="<?php echo BLOG_URL; ?>admin">
                            <img style="width:22px;height:21px;vertical-align: top;" src="<?php echo BLOG_URL . 'content/uploadfile/com/connect_sina.png'; ?>" id="login_img" title="<?php echo $_COOKIE['sina-username']; ?>" alt="<?php echo $_COOKIE['sina-username']; ?>">
                        </a>
                        <a href="javascript:;" style="cursor: none;text-decoration:none;">您好， </a> <a href="<?php echo BLOG_URL; ?>admin" title="<?php echo $_COOKIE['sina-username']; ?>"><?php echo $_COOKIE['sina-username']; ?></a>
                        <a href="javascript:;" title="完善帐号信息"  onClick="this.href='comAccount'" class="thickbox" >完善帐号信息</a>
                        <a href="javascript:;" title="绑定已有帐号" onClick="this.href='bindAccount'" class="thickbox" >绑定已有帐号</a>
                        <a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a>
                        <?php endif;?>
                        <?php if ((ROLE == 'admin' || ROLE == 'writer') && (!isset($_COOKIE['qq-username']) && !isset($_COOKIE['sina-username']))): ?>
                        <a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a>
                        <a href="<?php echo BLOG_URL; ?>admin/">管理中心</a>
                        <a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a>
                        <?php elseif (!isset($_COOKIE['qq-username']) && !isset($_COOKIE['sina-username'])): ?>
                        <a href="javascript:;"  onClick="this.href='<?php echo BLOG_URL; ?>/QQLogin/oauth/qq_login.php';" title="使用腾讯QQ登录"><img src="<?php echo BLOG_URL; ?>/QQLogin/img/qq_login.png" alt="使用腾讯QQ登录" width="120" height="24"/></a>
                        <!--                                        <a href="javascript:void(0);" onClick="this.href='<?php echo BLOG_URL; ?>weiboSina/';"><img src="<?php echo BLOG_URL; ?>weiboSina/loginButton_24.png" width="102" height="24" alt="用新浪微博登录" title="用新浪微博登录"/></a>-->
                        <a href="javascript:void(0);" onClick="this.href='login'" class="thickbox">登录</a>
                        <a href="javascript:void(0);" onClick="this.href='register'" class="thickbox" id="register_button">注册</a>
                        <?php endif;?>
                        <a title="碎碎念" href="<?php echo BLOG_URL; ?>self-talking">碎碎念</a>
                        <?php echo $toptb_right_url; ?>
                        <a title="RSS订阅" href="<?php echo BLOG_URL; ?>rss.php">订阅本站</a>
                    </div>
                </div>
            </div>
            <div class="space"></div>
            <div id="hd">
                <div class="wp">
                    <div class="hdc cl">
                        <h1 class="logo"><a id="zq_logo" href="<?php echo BLOG_URL; ?>" class="zq_logo"></a></h1>
                        <div id="weather">&nbsp;</div>
                        <div class="login">
                            <div id="serch" class="serch">
                                <div style="height:auto;overflow: hidden;">
                                    <form name="keyform" id="searchform" method="get" action="<?php echo BLOG_URL; ?>index.php">
                                        <input name="keyword" id="s" class="text" type="text" value="输入关键词" onfocus="if(this.value=='输入关键词') this.value=''" onblur="if(this.value=='') this.value='输入关键词'">
                                        <input name="keyword" class="submit" type="submit" value="&nbsp;">
                                    </form>
                                </div>
                                <div style="clear:both;margin-top:-7px;">
                                    &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;热门搜索词:
                                    <?php
foreach ($keyhot as $v):
	echo "<a href='index.php?keyword=$v'>" . $v . '</a>&nbsp;';
endforeach;
?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space"></div>
                    <div class="nv"><?php blog_navi();?></div>
                    <!--        <div id="banner">
                        <a href="<?php echo $bannerUrl; ?>" target="_blank">
                            <img src="<?php echo BLOG_URL . Option::get('topimg'); ?>"width="960px" border="0"/>
                        </a>
                    </div>end banner-->
                    </div><!--end wp-->
                    </div><!--end hd-->
                </div>
                <div id="wp" class="wp">
