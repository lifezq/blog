<?php
/**
 * 后台全局项加载
 * @copyright (c) Emlog All Rights Reserved
 */

require_once '../init.php';

define('TEMPLATE_PATH', EMLOG_ROOT.'/admin/views/');//后台当前模板路径

$sta_cache = $CACHE->readCache('sta');
$user_cache = $CACHE->readCache('user');
$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';

//登录验证
if ($action == 'login') {
	$username = isset($_POST['user']) ? addslashes(trim($_POST['user'])) : '';
	$password = isset($_POST['pw']) ? addslashes(trim($_POST['pw'])) : '';
	$ispersis = isset($_POST['ispersis']) ? intval($_POST['ispersis']) : false;
	$img_code = Option::get('login_code') == 'y' && isset($_POST['imgcode']) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';

    $loginAuthRet = LoginAuth::checkUser($username, $password, $img_code);
   
	if ($loginAuthRet === true) {
		LoginAuth::setAuthCookie($username, $ispersis);

        echo "<script>window.top.location.href='".BLOG_URL."/admin';</script>";
        exit();
//		emDirect("./");
	}else{
		LoginAuth::loginPage($loginAuthRet);
	}
}elseif($action == 'register'){
        LoginAuth::registerPage();
}

//退出
if ($action == 'logout') {

		setcookie(AUTH_COOKIE_NAME, ' ', time() - 31536000, '/', WEB_COOKIE_DOMAIN);
        session_start();
        $_SESSION['zq_qqlogin']=false;
        setcookie('qq-username',0, time() - 31536000,'/', WEB_COOKIE_DOMAIN);
        setcookie('sina-username',0, time() - 31536000,'/', WEB_COOKIE_DOMAIN);
        setcookie('ZQ_BIND_OPENID',0, time() - 31536000,'/', WEB_COOKIE_DOMAIN);
		emDirect("../");
}

if (ISLOGIN === false) {
	LoginAuth::loginPage();
}

$request_uri = strtolower(substr(basename($_SERVER['SCRIPT_NAME']), 0, -4));
if (ROLE == 'writer' && !in_array($request_uri, array('write_log','admin_log','twitter','attachment','blogger','comment','index','save_log','trackback'))) {
	emMsg('权限不足！','./');
}
