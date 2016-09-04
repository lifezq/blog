<?php
/*
Plugin Name: Qzone插件
Version: 2.0
Description: 基于Qzone API，可以将在emlog内发布的碎语、日志同步到指定的Qzone账号。
Author:wangshangyou
Author Email: wangshangyou3000@163.com
Author URL: http://www.wangshangyou.com/
*/

!defined('EMLOG_ROOT') && exit('access deined!');

require_once 'comm/config.php';
require_once 'comm/utils.php';
require_once 'emlog_qzone_profile.php';

if (file_exists(EMLOG_ROOT.'/content/plugins/emlog_qzone/emlog_qzone_token_conf.php') &&
	isset($_GET['do']) && $_GET['do'] == 'chg') {
	if (!unlink(EMLOG_ROOT.'/content/plugins/emlog_qzone/emlog_qzone_token_conf.php')) {
		emMsg('操作失败，请确保插件目录(/content/plugins/emlog_qzone/)可写');
	}
}

if (file_exists(EMLOG_ROOT.'/content/plugins/emlog_qzone/emlog_qzone_token_conf.php')) {
    if(isset($_SESSION['zq_qqlogin']) && $_SESSION['zq_qqlogin']){//如果是QQ登录，载入自己的身份标识
        define('QZONE_ACCESS_TOKEN', $_SESSION["access_token"]); 
        define('QZONE_OPEN_ID', $_SESSION["openid"]);
    }else{
       include_once( 'emlog_qzone_token_conf.php' ); 
    }
	
}

function postBlog2Qzone($blogid) {

	if (!defined('QZONE_ACCESS_TOKEN')) {
		return false;
	}

    global $title, $ishide, $action;

    if('y' == $ishide) {//忽略写日志时自动保存
        return false;
    }
    if('edit' == $action) {//忽略编辑日志
        return false;
    }
    if('autosave' == $action && 'n' == $ishide) {//忽略编辑日志时移步保存
        return false;
    }

    $t = stripcslashes(trim($title));
    add_share($t, Url::log($blogid));

    if(QZONE_TBLOG == 6) {
	$Log_Model = new Log_Model();
	$logData = $Log_Model->getOneLogForHome($blogid);
	$rs = add_blog($t, $logData['log_content']);
    }
}

if (QZONE_SYNC == '3' || QZONE_SYNC == '1') {
    addAction('save_log', 'postBlog2Qzone');
}

function postTwitter2Qzone($t) {
	if (!defined('QZONE_ACCESS_TOKEN')) {
		return false;
	}
	global $img;
    $postData = stripcslashes($t);
    if (QZONE_TFROM == '4') {
        $postData = stripcslashes(subString($t, 0, 300)) . ' - 来自博客 ';
    }
	add_share($postData, BLOG_URL, null, null, BLOG_URL . str_replace('../','',$img));
}

if (QZONE_SYNC == '2' || QZONE_SYNC == '1') {
    addAction('post_twitter', 'postTwitter2Qzone');
}

function add_share($title, $url, $comment=null, $summary=null, $images=null) {
    //发布一条动态的接口地址, 不要更改!!
    $url = "https://graph.qq.com/share/add_share?"
        ."access_token=".QZONE_ACCESS_TOKEN
        ."&oauth_consumer_key=".$_SESSION["appid"]
        ."&openid=".QZONE_OPEN_ID
        ."&format=json"
        ."&title=".urlencode($title)
        ."&url=".urlencode($url)
        ."&comment=".urlencode($comment)
        ."&summary=".urlencode($summary)
        ."&images=".urlencode($images);

    return get_url_contents($url);
}

function add_blog($title, $content) {
    $url  = "https://graph.qq.com/blog/add_one_blog";
    $data = "access_token=".QZONE_ACCESS_TOKEN
        ."&oauth_consumer_key=".$_SESSION["appid"]
        ."&openid=".QZONE_OPEN_ID
        ."&format=json"
        ."&title=".$title
        ."&content=".$content;

    return do_post($url, $data); 
}

function emlog_qzone_menu() {
    echo '<div class="sidebarsubmenu" id="emlog_qzone"><a href="./plugin.php?plugin=emlog_qzone">Qzone设置</a></div>';
}

addAction('adm_sidebar_ext', 'emlog_qzone_menu');
