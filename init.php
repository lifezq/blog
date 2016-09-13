<?php
/**
 * 全局项加载
 * @copyright (c) Emlog All Rights Reserved
 */

error_reporting(E_ALL);
//error_reporting(E_ALL);

// ob_gzip 压缩页面用，压缩机函数
function ob_gzip($content) // $content 就是要压缩的页面内容，或者说饼干原料
{
	// 如果页面头部信息还没有输出 // 而且zlib扩展已经加载到PHP中 //而且浏览器说它可以接受GZIP的页面
	if (!headers_sent() && extension_loaded("zlib") && strstr($_SERVER["HTTP_ACCEPT_ENCODING"], "gzip")) {
		$content = gzencode($content . " \n//此页已压缩", 9); //为准备压缩的内容贴上“//此页已压缩”的注释标签，然后用zlib提供的gzencode()函数执行级别为9的压缩，这个参数值范围是0-9，0表示无压缩，9表示最大压缩，当然压缩程度越高越费CPU。
		//然后用header()函数给浏览器发送一些头部信息，告诉浏览器这个页面已经用GZIP压缩过了！
		header("Content-Encoding: gzip");
		header("Vary: Accept-Encoding");
		header("Content-Length: " . strlen($content));
	}
	return $content; //返回压缩的内容，或者说把压缩好的饼干送回工作台。
}

//启用GIP
// if (function_exists('ob_gzip') && extension_loaded("zlib") && strstr($_SERVER["HTTP_ACCEPT_ENCODING"], "gzip")) {
// 	ob_start('ob_gzip');
// 	printf("gzip#01\n");
// } else
if (function_exists('ob_gzhandler')) {
	ob_start('ob_gzhandler');
} else {
	ob_start();
}

header('Content-Type: text/html; charset=UTF-8');

define('EMLOG_ROOT', dirname(__FILE__));

require_once EMLOG_ROOT . '/config.php';
require_once EMLOG_ROOT . '/include/lib/function.base.php';

doStripslashes();

$CACHE = Cache::getInstance();

$userData = array();

define('ISLOGIN', LoginAuth::isLogin());
//用户组: admin管理员, writer联合撰写人, visitor访客
define('ROLE', ISLOGIN === true ? $userData['role'] : 'visitor');
//用户ID
define('UID', ISLOGIN === true ? $userData['uid'] : '');
//站点固定地址
define('BLOG_URL', Option::get('blogurl'));
//站点标题
define('SITE_TITLE', Option::get('site_title'));
//模板库地址
define('TPLS_URL', BLOG_URL . 'content/templates/');
//模板库路径
define('TPLS_PATH', EMLOG_ROOT . '/content/templates/');
//解决前台多域名ajax跨域
define('DYNAMIC_BLOGURL', getBlogUrl());
//前台模板URL
define('TEMPLATE_URL', TPLS_URL . Option::get('nonce_templet') . '/');

$active_plugins = Option::get('active_plugins');
$emHooks = array();
if ($active_plugins && is_array($active_plugins)) {
	foreach ($active_plugins as $plugin) {
		if (true === checkPlugin($plugin)) {
			include_once EMLOG_ROOT . '/content/plugins/' . $plugin;
		}
	}
}
