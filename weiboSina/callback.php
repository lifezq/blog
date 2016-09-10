<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);

if (isset($_REQUEST['code'])) {
    $keys = array();
    $keys['code'] = $_REQUEST['code'];
    $keys['redirect_uri'] = WB_CALLBACK_URL;
    try {
        $token = $o->getAccessToken('code', $keys);
    } catch (OAuthException $e) {
        
    }
}

    //载入读取存入用户数据
define('EMLOG_ROOT', dirname(dirname(__FILE__)));

require_once EMLOG_ROOT.'/config.php';
require_once EMLOG_ROOT.'/include/lib/function.base.php';

if ($token) {
    $_SESSION['token'] = $token;
//    setcookie('weibojs_' . $o->client_id, http_build_query($token));
    $_SESSION['weibo_client_id']=$o->client_id;
    
    
    $user_model= new User_Model();
    $username=$user_model->zqAppLogin($o->client_id,'sina');
    if($username){
        //设置cookie
        LoginAuth::setAuthCookie($username, 1);
    }else{
    setcookie('ZQ_BIND_OPENID',$o->client_id,time()+3600*12,'/', WEB_COOKIE_DOMAIN);
    $c = new SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['token']['access_token']);
    $uid_get = $c->get_uid();
    $uid = $uid_get['uid'];
    $user_message = $c->show_user_by_id($uid); //根据ID获取用户等基本信息

    setcookie('sina-username',addslashes(trim($user_message['screen_name'])),time()+3600*24*30,'/', WEB_COOKIE_DOMAIN);
    }

    emMsg('登录成功，正在为您跳转...', BLOG_URL, 1,1);
    ?>
    授权完成,<a href="weibolist.php">进入你的微博列表页面</a><br />
    <?php
} else {
    emMsg('登录失败，系统返回...', BLOG_URL, 1);
    ?>
    授权失败。
    <?php
}
?>
