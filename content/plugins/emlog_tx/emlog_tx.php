<?php
/*
Plugin Name: 腾讯微博插件
Version: 2.0
Plugin URL:http://www.emlog.net/plugins/plugin-emlog_tx
Description: 基于腾讯微博API，可以将在emlog内发布的碎语、日志同步到指定的腾讯微博账号。
Author:wangshangyou
Author Email: wangshangyou3000@163.com
Author URL: http://wangshangyou.com/
*/

!defined('EMLOG_ROOT') && exit('access deined!');

require_once 'config.php';
require_once 'emlog_tx_profile.php';
require_once 'lib/Weibo.php';

session_start();
OpenSDK_Tencent_Weibo::init(MB_AKEY, MB_SKEY);

if (file_exists(EMLOG_ROOT.'/content/plugins/emlog_tx/emlog_tx_token_conf.php') &&
	isset($_GET['do']) && $_GET['do'] == 'chg') {
	if (!unlink(EMLOG_ROOT.'/content/plugins/emlog_tx/emlog_tx_token_conf.php')) {
		emMsg('操作失败，请确保插件目录(/content/plugins/emlog_tx/)可写');
	}
}

if (file_exists(EMLOG_ROOT.'/content/plugins/emlog_tx/emlog_tx_token_conf.php')) {
	include_once( 'emlog_tx_token_conf.php' );

	$_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN] = TX_ACCESS_TOKEN;
	$_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET] = TX_ACCESS_SECRET;

	OpenSDK_Tencent_Weibo::setParam(OpenSDK_Tencent_Weibo::ACCESS_TOKEN, TX_ACCESS_TOKEN);
	OpenSDK_Tencent_Weibo::setParam(OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET, TX_ACCESS_SECRET);
}

function postBlog2Tx($blogid) {

	if(!defined('TX_ACCESS_TOKEN')) {
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

	$t = stripcslashes(trim($title)) . ' ' . Url::log($blogid);

	$api_name = 't/add';
	$params = array(
		'format'	=> MB_RETURN_FORMAT,
		'content'	=> $t,
		'clientip'	=> $_SERVER['REMOTE_ADDR'],
		'longitude'	=> '',
		'latitude'	=> '',
	);
	$call_result = OpenSDK_Tencent_Weibo::call($api_name, $params, 'POST');
}

if (TX_SYNC == '3' || TX_SYNC == '1') {
	addAction('save_log', 'postBlog2Tx');
}

function postTwitter2Tx($t) {
	if(!defined('TX_ACCESS_TOKEN')) {
		return false;
	}

	$postData = stripcslashes($t);

	if(TX_TFROM == '4') {
		$postData = stripcslashes(subString($t, 0, 300)) . ' - 来自博客：' . BLOG_URL;
	}

	global $img;
	if(empty($img)) {
		$api_name = 't/add';
		$params = array(
			'format'        => MB_RETURN_FORMAT,
			'content'       => $postData,
                	'clientip'      => $_SERVER['REMOTE_ADDR'],
                	'longitude'     => '',
                	'latitude'      => '',
        	);
        	$call_result = OpenSDK_Tencent_Weibo::call($api_name, $params, 'POST', false);
	} else {
		$api_name = 't/add_pic';
		$params = array(
			'content' => $postData,
			'clientip' => $_SERVER['REMOTE_ADDR'],
		);
		$call_result = OpenSDK_Tencent_Weibo::call($api_name, $params, 'POST', array('pic' => EMLOG_ROOT . str_replace('../', '/', $img),));
	}
}

if (TX_SYNC == '2' || TX_SYNC == '1') {
    addAction('post_twitter', 'postTwitter2Tx');
}


function emlog_tx_menu() {
    echo '<div class="sidebarsubmenu" id="emlog_tx"><a href="./plugin.php?plugin=emlog_tx">腾讯微博设置</a></div>';
}

addAction('adm_sidebar_ext', 'emlog_tx_menu');
