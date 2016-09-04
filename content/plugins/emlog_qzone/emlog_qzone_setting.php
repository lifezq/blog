<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}

include_once( 'emlog_qzone_profile.php' );
include_once( 'comm/config.php' );
include_once( 'comm/utils.php' );

if(!file_exists(EMLOG_ROOT.'/content/plugins/emlog_qzone/emlog_qzone_token_conf.php')) {
	if (isset($_GET['state'])) {
		qq_callback();
		get_openid();
		if(isset($_SESSION['zq_qqlogin']) && $_SESSION['zq_qqlogin']){//如果是QQ登录，载入自己的身份标识
        define('QZONE_ACCESS_TOKEN', $_SESSION["access_token"]); 
        define('QZONE_OPEN_ID', $_SESSION["openid"]);
    }else{
       include_once( 'emlog_qzone_token_conf.php' ); 
    }
	} else {
		//$o = new MBOpenTOAuth(MB_AKEY, MB_SKEY);
		//$keys = $o->getRequestToken(BLOG_URL.'admin/plugin.php?plugin=emlog_qzone');
		//$aurl = $o->getAuthorizeURL($keys['oauth_token'], false, '');
		//$_SESSION['keys'] = $keys;
		$aurl = qq_login_url($_SESSION["appid"], $_SESSION["scope"], $_SESSION["callback"]);
	}
} else {
	if(isset($_SESSION['zq_qqlogin']) && $_SESSION['zq_qqlogin']){//如果是QQ登录，载入自己的身份标识
        define('QZONE_ACCESS_TOKEN', $_SESSION["access_token"]); 
        define('QZONE_OPEN_ID', $_SESSION["openid"]);
    }else{
       include_once( 'emlog_qzone_token_conf.php' ); 
    }
}

function qq_login_url($appid, $scope, $callback) {
	$_SESSION['state'] = md5(uniqid(rand(), TRUE));
	return "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=". $appid . "&redirect_uri=" . urlencode($callback). "&state=" . $_SESSION['state']. "&scope=".$scope;
}

function qq_callback() {
    if($_REQUEST['state'] == $_SESSION['state']) {
        $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
            . "client_id=" . $_SESSION["appid"]. "&redirect_uri=" . urlencode($_SESSION["callback"])
            . "&client_secret=" . $_SESSION["appkey"]. "&code=" . $_REQUEST["code"];

        $response = get_url_contents($token_url);
        if (strpos($response, "callback") !== false) {
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);
            if (isset($msg->error)) {
                echo "<h3>error:</h3>" . $msg->error;
                echo "<h3>msg  :</h3>" . $msg->error_description;
                exit;
            }
        }

        $params = array();
        parse_str($response, $params);
	file_put_contents(EMLOG_ROOT.'/content/plugins/emlog_qzone/emlog_qzone_token_conf.php',"<?php define('QZONE_ACCESS_TOKEN', '".$params["access_token"]."');");
	//error_log("<?php define('QZONE_ACCESS_TOKEN', ".$params["access_token"].");", 3, EMLOG_ROOT.'/content/plugins/emlog_qzone/emlog_qzone_token_conf.php');
        $_SESSION["access_token"] = $params["access_token"];

    } else {
        echo("The state does not match. You may be a victim of CSRF.");
    }
}

function get_openid() {
    $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=" 
        . $_SESSION['access_token'];

    $str  = get_url_contents($graph_url);
    if (strpos($str, "callback") !== false)
    {
        $lpos = strpos($str, "(");
        $rpos = strrpos($str, ")");
        $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
    }

    $user = json_decode($str);
    if (isset($user->error))
    {
        echo "<h3>error:</h3>" . $user->error;
        echo "<h3>msg  :</h3>" . $user->error_description;
        exit;
    }
file_put_contents(EMLOG_ROOT.'/content/plugins/emlog_qzone/emlog_qzone_token_conf.php', " define('QZONE_OPEN_ID', '".$user->openid."');", FILE_APPEND);
//error_log(" define('QZONE_OPEN_ID', '".$user->openid."');", 3, EMLOG_ROOT.'/content/plugins/emlog_qzone/emlog_qzone_token_conf.php');
    $_SESSION["openid"] = $user->openid;
}

function plugin_setting_view() {
	global $aurl;
?>
<script>
$("#emlog_qzone").addClass('sidebarsubmenu1');
</script>
<style>
    #sinat_form {margin:20px 5px;}
    #sinat_form li{padding:5px;}
    #sinat_form li input{padding:2px; width:180px; height:20px;}
    #sinat_form p input{padding:2px; width:80px; height:30px;}
    #sinat_form p span{margin-left:30px;}
</style>
<div class=containertitle><img src="../content/plugins/emlog_qzone/t.png"> <b>Qzone</b>
<?php if(isset($_GET['setting'])):?><span class="actived">插件设置完成</span><?php endif;?>
<?php if(isset($_GET['error'])):?><span class="error">保存失败，配置文件不可写</span><?php endif;?>
</div>
<div class=line></div>
<div class="des">Qzone插件基于腾讯Qzone API，可以将emlog内发布的碎语、日志自动同步到你所指定的Qzone账号，无需你手动操作。
<br /><br />提示：请确保本插件目录及emlog_qzone_profile.php文件据有写权限（777）。</div>
<div id="sinat_form">

<?php
if (!isset($_GET['oauth_token']) && !defined('QZONE_ACCESS_TOKEN') && !defined('QZONE_OPEN_ID')): ?>
	<li><a href="<?php echo $aurl ?>"><img src="../content/plugins/emlog_qzone/t-login.png"></a></li>
<?php else:?>
<?php
function get_user_info() {
    $get_user_info = "https://graph.qq.com/user/get_user_info?"
        . "access_token=" . QZONE_ACCESS_TOKEN
        . "&oauth_consumer_key=" . $_SESSION["appid"]
        . "&openid=" . QZONE_OPEN_ID
        . "&format=json";

    $info = get_url_contents($get_user_info);
    $arr = json_decode($info, true);

    return $arr;
}

//获取用户基本资料
$arr = get_user_info();
?>
	<li><img src="<?php echo $arr['figureurl_2']; ?>" style="border:2px #CCCCCC solid;"/></li>
	<li><b><?php echo $arr["nickname"]; ?></b> (当前Qzone账号， <a href="./plugin.php?plugin=emlog_qzone&do=chg">更换账号</a>，更换账户
	时请先退出当前浏览器中Qzone(qzone.qq.com)的登录状态)</li>
<?php endif;?>

</div>
<form id="form1" name="form1" method="post" action="plugin.php?plugin=emlog_qzone&action=setting">
<div id="sinat_form">
<li>内容同步方案：
        <select name="sync">
        <?php
        $ex1 = $ex2 = $ex3 = '';
        $sync = 'ex' . QZONE_SYNC;
        $$sync = 'selected="selected"';
        ?>
          <option value="1" <?php echo $ex1; ?>>碎语和日志</option>
          <option value="2" <?php echo $ex2; ?>>仅碎语</option>
          <option value="3" <?php echo $ex3; ?>>仅日志</option>
        </select>
</li>
<li>碎语内容追加来源博客：
            <select name="tfrom">
        <?php
        $ex4 = $ex5 = '';
        $tfrom = 'ex' . QZONE_TFROM;
        $$tfrom = 'selected="selected"';
        ?>
          <option value="4" <?php echo $ex4; ?>>是</option>
          <option value="5" <?php echo $ex5; ?>>否</option>
        </select>
</li>
<li>是否在空间生成一条日志：
            <select name="tblog">
        <?php
        $ex6 = $ex7 = '';
        $tblog = 'ex' . QZONE_BLOG;
        $$tblog = 'selected="selected"';
        ?>
          <option value="6" <?php echo $ex6; ?>>是</option>
          <option value="7" <?php echo $ex7; ?>>否</option>
        </select>
</li>
<p><input name="input" type="submit" value="保存设置" /> <span><a href="http://qzone.qq.com" target="_blank">访问Qzone&raquo;</a></span></p>
</div>
</form>
<?php
}

function plugin_setting(){
    $profile = EMLOG_ROOT.'/content/plugins/emlog_qzone/emlog_qzone_profile.php';

	$tx_sync = htmlspecialchars($_POST['sync'], ENT_QUOTES);
	$tx_tfrom = htmlspecialchars($_POST['tfrom'], ENT_QUOTES);
	$tx_tblog = htmlspecialchars($_POST['tblog'], ENT_QUOTES);

	$tx_new_profile = "<?php\ndefine('QZONE_SYNC','$tx_sync');\ndefine('QZONE_TFROM','$tx_tfrom');\ndefine('QZONE_BLOG','$tx_tblog');\n";

	$fp = @fopen($profile,'wb');
	if(!$fp) {
	    return false;
	}
	fwrite($fp,$tx_new_profile);
	fclose($fp);
}
?>
