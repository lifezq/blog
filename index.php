<?php

/**
 * 前端页面加载
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'init.php';

//前台模板路径
define('TEMPLATE_PATH', TPLS_PATH . Option::get('nonce_templet') . '/');

//如果用户用手机登录，那么就跳转到手机版
/*
if (!isset($_COOKIE['isMobile'])) {
$is_mobile = isMobile() ? 1 : 0;
setcookie('isMobile', $is_mobile, time() + 3600, '/',  str_replace('http://', '', BLOG_URL));
if ($is_mobile) {
header("location:" . BLOG_URL . "/m");
exit;
}
}
if ($_COOKIE['isMobile']) {
header("location:" . BLOG_URL . "/m");
exit;
}
 */
/*
//如果用户从localhost访问，则跳转到localhost
if (!isset($_COOKIE['isLifezq'])) {
$preg = '/^(www|lifezq.com)/';
$isLifezq = preg_match($preg, $_SERVER['HTTP_HOST']) ? 1 : 0;
setcookie('isLifezq', $isLifezq, time() + 600, '/',str_replace('http://', '', BLOG_URL));
if ($isLifezq) {
header("location:" . BLOG_URL . "");
exit;
}
}
 */

//邮箱验证
if (isset($_GET['emailcheck'])) {
//   echo authcode("yangqianleizq@gmail.com","ENCODE");

	$_GET['emailcheck'] = str_replace(' ', '+', $_GET['emailcheck']);
	$email = authcode($_GET['emailcheck']);

	$User_Model = new User_Model();
	$is_ok = $User_Model->checkEmail($email, 'check');
	if ($is_ok) {
		$msg = '恭喜您，您的帐号已经成功激活，现在就去登录吧';
		if (isset($_GET['comacc']) && $_GET['comacc']) {
			$msg = '恭喜您，您的帐号已经成功激活，系统正在为您跳转...';
		}

		emMsg($msg, BLOG_URL, 1);
	} elseif ($is_ok == '-1') {
		emMsg('您的帐号已经激活，亲，如果有什么问题您可以联系管理员，或是重新注册哦', BLOG_URL, 1);
	} elseif ($is_ok == '-2') {
		emMsg('您所要激活的帐号不存在，亲，如果有什么问题您可以联系管理员，或是重新注册哦', BLOG_URL, 1);
	} else {
		emMsg('非常抱歉，您的帐号激活失败，亲，如果有什么问题您可以联系管理员，或是重新注册哦', BLOG_URL, 1);
	}
	exit;
}

$emDispatcher = Dispatcher::getInstance();

$emDispatcher->dispatch();

View::output();
