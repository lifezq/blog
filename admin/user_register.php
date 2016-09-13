<?php

require_once '../init.php';

define('TEMPLATE_PATH', EMLOG_ROOT . '/admin/views/'); //后台当前模板路径

$sta_cache = $CACHE->readCache('sta');
$user_cache = $CACHE->readCache('user');
$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';
$error = isset($_GET['error']) ? addslashes($_GET['error']) : '';
$User_Model = new User_Model();
//再次发送激活邮件
if (isset($_GET['reSendMail'])) {
    //获取站点信息配置
    echo "<script> function _jswrite(obj,str){ if(obj.innerHTML){ obj.innerHTML=str;}else{obj.innerTEXT=str;}}</script>";
    $webConfig = $User_Model->getSiteConf();
    $site_desc = $webConfig['site_description'];
    if (!isset($_COOKIE['zq_sendmail'])) {
        setcookie('zq_sendmail', 1, time() + 180);
        $first = true;
    } else {
        $_COOKIE['zq_sendmail'] = $_COOKIE['zq_sendmail'] + 1;
    }
    $emailcode=authcode($_GET['reSendMail'], "ENCODE");
    $webRoot=BLOG_URL;
    $message = <<<str
    欢迎您注册  之晴博客 ， 点击以下链接激活您的帐号：
        $webRoot/?emailcheck=$emailcode
$site_desc
str;
    $subject = " 之晴博客邮箱验证激活帐号，激活后即可在这里与大家分享WEB技术知识";
    if(isset($_GET['comacc']) && $_GET['comacc']){
        $message = <<<str
    恭喜您已经完善 之晴博客 帐户信息 ， 点击以下链接激活您的帐号：
        $webRoot/?comacc=1&emailcheck=$emailcode
$site_desc
str;
    }
    
    if ($_COOKIE['zq_sendmail'] < 3)
        sendmail($_GET['reSendMail'], $subject, $message, '', $webConfig['site_title'], $webConfig['blogurl']);
    //记录还可以发送激活邮件次数
    $remainNum = ($_COOKIE['zq_sendmail'] == 1 || isset($first)) ? 1 : 0;

    $message = <<<msg
<div style='margin:25px;line-height:30px;text-indent:2em;'>恭喜您，激活邮件已经成功再次发送到您的邮箱，请注意查收，当您收到激活邮件点击进入，激活后便可登录 之晴博客，发文章，发碎语啦。如果长时间未收到邮箱，请点击这里再次<a href='javascript:void(0)' onClick= window.top.document.getElementById('registeriframe').src='$webRoot/admin/user_register.php?reSendMail={$_GET['reSendMail']}'; >发送激活邮件</a>,亲爱的用户，一共可以发送三次激活邮件，当前您还可以发送($remainNum)次</div>
msg;

    if (!$remainNum) {
        $message = <<<msg
<div style='margin:25px;line-height:30px;text-indent:2em;'>亲爱的用户，激活邮件已经成功发送了三封到您的邮箱，如果您还没有收到邮件，请联系管理员。系统将在10秒后，自动为您跳转...</div>
msg;
        echo "<script>setTimeout(\"window.top.location.href='https://" . $webRoot . "';\",10000);</script>";
    }
    echo "<script>var register_box=window.top.document.getElementById('register_box'); _jswrite(register_box,\"&nbsp;&nbsp;" . $message . "\");</script>";
    exit;
}
if ($action == 'register') {
    $DB = Database::getInstance();
    if (isset($_GET['op']) && $_GET['op'] == 'bindAccount') {//如果是绑定帐户信息
        $login = isset($_POST['login']) ? addslashes(trim($_POST['login'])) : '';
        $email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
        $uid = isset($_POST['uid']) ? addslashes(trim($_POST['uid'])) : '';
        $bindType = $_POST['bindType'];


        switch ($bindType) {
            case '1':
                $sql = "select uid from " . DB_PREFIX . "user where username='" . $login . "'";
                break;
            case '2':
                $sql = "select uid from " . DB_PREFIX . "user where uid='" . $uid . "'";
                break;
            case '3':
                $sql = "select uid from " . DB_PREFIX . "user where email='" . $email . "'";
                break;
        }
        $uid = $DB->once_fetch_array($sql);

        $uid = $uid['uid'];

        echo "<script> function _jswrite(obj,str){ if(obj.innerHTML){ obj.innerHTML=str;}else{obj.innerTEXT=str;}}</script>";
        $err_id = '';
        switch ($bindType) {
            case '1':
                $err_id = 'login_notice';
                break;
            case '2':
                $err_id = 'uid_bind_notice';
                break;
            case '3':
                $err_id = 'email_notice';
                break;
        }

        if (!$uid) {//用户输入的绑定信息没有找到
            echo "<script>var verify_c=window.top.document.getElementById('" . $err_id . "');  _jswrite(verify_c,'该用户不存在!');</script>";
            exit;
        }

        $username = $DB->once_fetch_array("select username from " . DB_PREFIX . "user where uid='" . $uid . "'");
        $username = $username['username'];

        //判断帐户有木有被绑定过
        if (isset($_COOKIE['qq-username'])) {
            $is_binded = $DB->once_fetch_array("select qq_bind_id from " . DB_PREFIX . "user  where uid=" . $uid);
            $is_binded = $is_binded['qq_bind_id'];
            if ($is_binded) {
                echo "<script>var verify_c=window.top.document.getElementById('" . $err_id . "');  _jswrite(verify_c,'该帐户已经被绑定，请选择其它帐户!');</script>";
                exit;
            }
            $DB->query("update " . DB_PREFIX . "user set qq_bind_id='" . $_COOKIE['ZQ_BIND_OPENID'] . "' where uid=" . $uid);
        } elseif (isset($_COOKIE['sina-username'])) {
            $is_binded = $DB->once_fetch_array("select sina_bind_id from " . DB_PREFIX . "user  where uid=" . $uid);
            $is_binded = $is_binded['sina_bind_id'];
            if ($is_binded) {
                echo "<script>var verify_c=window.top.document.getElementById('" . $err_id . "');  _jswrite(verify_c,'该帐户已经被绑定，请选择其它帐户!');</script>";
                exit;
            }
            $DB->query("update " . DB_PREFIX . "user set sina_bind_id='" . $_COOKIE['ZQ_BIND_OPENID'] . "' where uid=" . $uid);
        }

        setcookie('qq-username', 0, time() - 31536000, '/', WEB_COOKIE_DOMAIN);
        setcookie('sina-username', 0, time() - 31536000, '/', WEB_COOKIE_DOMAIN);
        setcookie('ZQ_BIND_OPENID', 0, time() - 31536000, '/', WEB_COOKIE_DOMAIN);
        LoginAuth::setAuthCookie($username, 1);
        $message = <<<msg
 <div style='margin:25px;line-height:30px;text-indent:2em;'>您已经成功绑定到帐户: {$username}，系统即将为您自动跳转...<br/> 如果没有跳转，请点击<a href='javascript:;' onClick='window.top.location.href=\"$webRoot\";'>跳转</a></div>
msg;

        echo "<script>var register_box=window.top.document.getElementById('register_box'); _jswrite(register_box,\"&nbsp;&nbsp;" . $message . "\");</script>";
        echo "<script>setTimeout(window.top.location.href='" . BLOG_URL . "',8000);</script>";
        exit;
    }
    //如果有注册检测
    if (isset($_GET['op']) && $_GET['op'] == 'check') {

        $error = 1;
        if ($_GET['type'] == 1) {//检测用户名
            if (strlen($_GET['data']) < 4) {
                $error = -4;
            } else {
                $isok = $DB->once_fetch_array("select uid  from " . DB_PREFIX . "user where username='" . $_GET['data'] . "'");
                if ($isok)
                    $error = -1;
            }
        }elseif ($_GET['type'] == 2) {//检测邮箱
            if (!checkMail($_GET['data'])) {
                $error = -2;
            } else {
                $isok = $DB->once_fetch_array("select uid  from " . DB_PREFIX . "user where email='" . $_GET['data'] . "'");
                if ($isok)
                    $error = -8;
            }
            //判断帐户有木有被绑定过
            if (isset($_COOKIE['qq-username'])) {

                $is_binded = $DB->once_fetch_array("select qq_bind_id from " . DB_PREFIX . "user  where email='" . $_GET['data'] . "'");
                $is_binded = $is_binded['qq_bind_id'];
                if ($is_binded) {
                    $error = -15;
                }
            } elseif (isset($_COOKIE['sina-username'])) {

                $is_binded = $DB->once_fetch_array("select sina_bind_id from " . DB_PREFIX . "user  where  email='" . $_GET['data'] . "'");
                $is_binded = $is_binded['sina_bind_id'];
                if ($is_binded) {
                    $error = -15;
                }
            }
        } elseif ($_GET['type'] == 3) {//检测验证码
            session_start();
            $sessionCode = isset($_SESSION['code']) ? $_SESSION['code'] : '';
            if (strtoupper($_GET['data']) !== $sessionCode)
                $error = -3;
        }elseif ($_GET['type'] == 4) {//检测密码
            if (strlen($_GET['data']) < 6)
                $error = -5;
        }elseif ($_GET['type'] == 5) {//检测密码
            $arr = explode('-', $_GET['data']);
            $pwd1 = $arr[0];
            $pwd2 = $arr[1];
            if (strlen($arr[0]) < 6 || strlen($arr[1]) < 6) {
                $error = -6;
            } elseif ($pwd1 != $pwd2) {
                $error = -7;
            }
        } elseif ($_GET['type'] == 6) {
            if (!is_numeric($_GET['data'])) {
                $error = -10;
            } else {
                $isok = $DB->once_fetch_array("select uid  from " . DB_PREFIX . "user where uid='" . $_GET['data'] . "'");
                if (!$isok)
                    $error = -9;
            }
            //判断帐户有木有被绑定过
            if (isset($_COOKIE['qq-username'])) {

                $is_binded = $DB->once_fetch_array("select qq_bind_id from " . DB_PREFIX . "user  where uid='" . $_GET['data'] . "'");
                $is_binded = $is_binded['qq_bind_id'];
                if ($is_binded) {
                    $error = -14;
                }
            } elseif (isset($_COOKIE['sina-username'])) {

                $is_binded = $DB->once_fetch_array("select sina_bind_id from " . DB_PREFIX . "user  where  uid='" . $_GET['data'] . "'");
                $is_binded = $is_binded['sina_bind_id'];
                if ($is_binded) {
                    $error = -14;
                }
            }
        } elseif ($_GET['type'] == 7) {
            if (strlen($_GET['data']) < 4) {
                $error = -11;
            } else {
                $isok = $DB->once_fetch_array("select uid  from " . DB_PREFIX . "user where username='" . $_GET['data'] . "'");
                if (!$isok)
                    $error = -12;
            }
            //判断帐户有木有被绑定过
            if (isset($_COOKIE['qq-username'])) {
                $is_binded = $DB->once_fetch_array("select qq_bind_id from " . DB_PREFIX . "user  where username='" . $_GET['data'] . "'");
                $is_binded = $is_binded['qq_bind_id'];
                if ($is_binded) {
                    $error = -13;
                }
            } elseif (isset($_COOKIE['sina-username'])) {

                $is_binded = $DB->once_fetch_array("select sina_bind_id from " . DB_PREFIX . "user  where  username='" . $_GET['data'] . "'");
                $is_binded = $is_binded['sina_bind_id'];
                if ($is_binded) {
                    $error = -13;
                }
            }
        }
        echo $error;
        exit;
    }
    session_start();
    $sessionCode = isset($_SESSION['code']) ? $_SESSION['code'] : '';
    echo "<script> function _jswrite(obj,str){ if(obj.innerHTML){ obj.innerHTML=str;}else{obj.innerTEXT=str;}}</script>";
    //检查用户是否同意之晴使用协议
    echo "<script>var agree_n=window.top.document.getElementById('agree_notice');  _jswrite(agree_n,'&nbsp;&nbsp;');</script>";
    if ($_POST['agree'] != 1) {
        $str = '注册';
        if (isset($_GET['op']) && $_GET['op'] == 'comAccount')
            $str = '完善帐户';
        echo "<script>var agree_n=window.top.document.getElementById('agree_notice');  _jswrite(agree_n,'&nbsp;&nbsp;您必须认真阅读之晴使用协议后并确认才能{$str}!');</script>";
        exit;
    }


    echo "<script>var verify_c=window.top.document.getElementById('verify_notice');  _jswrite(verify_c,'&nbsp;&nbsp;');</script>";
    //验证码不正确
    if ($sessionCode != strtoupper($_POST['verifycode'])) {
        echo "<script>var verify_c=window.top.document.getElementById('verify_notice');  _jswrite(verify_c,'&nbsp;&nbsp;验证码错误!');</script>";
        exit;
    }

    $login = isset($_POST['login']) ? addslashes(trim($_POST['login'])) : '';
    $password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
    $password2 = isset($_POST['password2']) ? addslashes(trim($_POST['password2'])) : '';
    $role = isset($_POST['role']) ? addslashes(trim($_POST['role'])) : 'writer';
    $email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
    echo "<script>var login_n=window.top.document.getElementById('login_notice'); _jswrite(login_n,'&nbsp;&nbsp;');</script>";
    if ($login == '') {
        echo "<script>var login_n=window.top.document.getElementById('login_notice'); _jswrite(login_n,'&nbsp;&nbsp;用户名不能为空!');</script>";
        exit;
    } elseif (strlen($login) < 4) {
        echo "<script>var login_n=window.top.document.getElementById('login_notice'); _jswrite(login_n,'&nbsp;&nbsp;用户名不能小于两个字符!');</script>";
        exit;
    }
    if ($User_Model->isUserExist($login)) {
        echo "<script>var login_n=window.top.document.getElementById('login_notice'); _jswrite(login_n,'&nbsp;&nbsp;用户名已经存在!');</script>";
        exit;
    }
    echo "<script>var passwd_n=window.top.document.getElementById('password_notice'); _jswrite(passwd_n,'&nbsp;&nbsp;');</script>";
    echo "<script>var passwd_n=window.top.document.getElementById('password2_notice'); _jswrite(passwd_n,'&nbsp;&nbsp;');</script>";
    if (strlen($password) < 6) {
        echo "<script>var passwd_n=window.top.document.getElementById('password_notice'); _jswrite(passwd_n,'&nbsp;&nbsp;密码不能小于6位!');</script>";
        exit;
    }
    if ($password != $password2) {
        echo "<script>var passwd_n=window.top.document.getElementById('password2_notice'); _jswrite(passwd_n,'&nbsp;&nbsp;再次密码不一致!');</script>";
        exit;
    }
    echo "<script>var email_n=window.top.document.getElementById('email_notice'); _jswrite(email_n,'&nbsp;&nbsp;请认真填写一个常用的邮箱，该邮箱将自动绑定该帐号');</script>";
    //验证邮箱
    if (!checkMail($email)) {
        echo "<script>var email_n=window.top.document.getElementById('email_notice'); _jswrite(email_n,'&nbsp;&nbsp;邮箱格式不正确!');</script>";
        exit;
    } elseif ($User_Model->checkEmail($email)) {
        echo "<script>var email_n=window.top.document.getElementById('email_notice'); _jswrite(email_n,'&nbsp;&nbsp;邮箱已经存在!');</script>";
        exit;
    }

    $PHPASS = new PasswordHash(8, true);
    $password = $PHPASS->HashPassword($password);

    $User_Model->addUser($login, $password, $role, $email);
    
    
    $emailcode = authcode($email, "ENCODE");
    //获取站点信息配置

    $webConfig = $User_Model->getSiteConf();
    $site_desc = $webConfig['site_description'];
    
    if (isset($_GET['op']) && $_GET['op'] == 'comAccount') {//如果是完善帐户信息
        if (isset($_COOKIE['qq-username'])) {
            $photo = "../content/uploadfile/com/connect_qq.gif";
            $DB->query("update " . DB_PREFIX . "user set nickname='{$_COOKIE['qq-username']}',photo='$photo',qq_bind_id='" . $_COOKIE['ZQ_BIND_OPENID'] . "' where username='" . $login . "'");
        } elseif (isset($_COOKIE['sina-username'])) {
            $photo = "../content/uploadfile/com/connect_sina.png";
            $DB->query("update " . DB_PREFIX . "user set nickname='{$_COOKIE['sina-username']}',photo='$photo',sina_bind_id='" . $_COOKIE['ZQ_BIND_OPENID'] . "' where  username='" . $login . "'");
        }
        
        $CACHE->updateCache(array('sta', 'user'));//更新用户缓存信息
        
        setcookie('qq-username', 0, time() - 31536000, '/', WEB_COOKIE_DOMAIN);
        setcookie('sina-username', 0, time() - 31536000, '/', WEB_COOKIE_DOMAIN);
        setcookie('ZQ_BIND_OPENID', 0, time() - 31536000, '/', WEB_COOKIE_DOMAIN);
       
        /*
          LoginAuth::setAuthCookie($login, 1);
          $message=<<<msg
          <div style='margin:25px;line-height:30px;text-indent:2em;'>您已经成功完善了身份信息，系统3秒后将自动为您跳转...<br/> 如果没有跳转，请点击<a href='javascript:;' onClick='window.top.location.href=\"<?php echo BLOG_URL; ?>\";'>跳转</a></div>
          msg;

          echo "<script>var register_box=window.top.document.getElementById('register_box'); _jswrite(register_box,\"&nbsp;&nbsp;".$message."\");</script>";
          echo "<script>setTimeout(window.top.location.href='<?php echo BLOG_URL; ?>',5000);</script>";
         */
        $message = <<<str
    恭喜您已经完善 之晴博客 帐户信息， 请点击以下链接激活您的帐号：
        $webRoot/?emailcheck=$emailcode  <br/>
$site_desc
str;
        $subject = "之晴博客邮箱验证激活帐号，激活后即可在这里与大家分享WEB技术知识";

        sendmail($email, $subject, $message, '', $webConfig['site_title'], $webConfig['blogurl']);

        $message = <<<msg
 <div style='margin:25px;line-height:30px;text-indent:2em;'>恭喜您已经完善 之晴博客 帐户信息,1-3分钟内您将会收到系统给您发的激活邮件,点击进入,激活后便可登录之晴博客,发文章,发碎语啦.如果长时间未收到邮箱,请点击这里再次<a href='javascript:void(0)' onClick= window.top.document.getElementById('registeriframe').src='$webRoot/admin/user_register.php?reSendMail=$email&comacc=1'; >发送激活邮件</a></div>
msg;

        echo "<script>var register_box=window.top.document.getElementById('register_box'); _jswrite(register_box,\"&nbsp;&nbsp;" . $message . "\");</script>";
        exit;
    }
    
    $CACHE->updateCache(array('sta', 'user'));//更新用户缓存信息
    $message = <<<str
    欢迎您注册 之晴博客 ， 请点击以下链接激活您的帐号：
        $webRoot/?emailcheck=$emailcode  <br/>
$site_desc
str;
    $subject = "之晴博客邮箱验证激活帐号，激活后即可在这里与大家分享WEB技术知识";

    sendmail($email, $subject, $message, '', $webConfig['site_title'], $webConfig['blogurl']);

    $message = <<<msg
 <div style='margin:25px;line-height:30px;text-indent:2em;'>恭喜您已经注册成功,1-3分钟内您将会收到系统给您发的激活邮件,点击进入,激活后便可登录之晴博客,发文章,发碎语啦.如果长时间未收到邮箱,请点击这里再次<a href='javascript:void(0)' onClick= window.top.document.getElementById('registeriframe').src='$webRoot/admin/user_register.php?reSendMail=$email'; >发送激活邮件</a></div>
msg;

    echo "<script>var register_box=window.top.document.getElementById('register_box'); _jswrite(register_box,\"&nbsp;&nbsp;" . $message . "\");</script>";
}
?>