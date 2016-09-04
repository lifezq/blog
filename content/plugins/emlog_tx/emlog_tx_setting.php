<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}

session_start();
include_once('emlog_tx_profile.php');
include_once('config.php');
include_once('lib/Weibo.php');

OpenSDK_Tencent_Weibo::init(MB_AKEY, MB_SKEY);

if(!file_exists(EMLOG_ROOT.'/content/plugins/emlog_tx/emlog_tx_token_conf.php')) {
	if (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) {
		if(OpenSDK_Tencent_Weibo::getAccessToken($_GET['oauth_verifier'])) {
			save_access_token($_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN], $_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET]);
		}
		include_once('emlog_tx_token_conf.php');
	} else {
		$mini=true;
		$callback = BLOG_URL.'admin/plugin.php?plugin=emlog_tx';
		$request_token = OpenSDK_Tencent_Weibo::getRequestToken($callback);
		$aurl = OpenSDK_Tencent_Weibo::getAuthorizeURL($request_token);
		$_SESSION['keys'] = $request_token;
	}
} else {
	include_once('emlog_tx_token_conf.php');
}

function plugin_setting_view() {
	global $aurl;
?>
<script>
$("#emlog_tx").addClass('sidebarsubmenu1');
</script>
<style>
    #sinat_form {margin:20px 5px;}
    #sinat_form li{padding:5px;}
    #sinat_form li input{padding:2px; width:180px; height:20px;}
    #sinat_form p input{padding:2px; width:80px; height:30px;}
    #sinat_form p span{margin-left:30px;}
</style>
<div class=containertitle><img src="../content/plugins/emlog_tx/t.png"> <b>腾讯微博插件</b>
<?php if(isset($_GET['setting'])):?><span class="actived">插件设置完成</span><?php endif;?>
<?php if(isset($_GET['error'])):?><span class="error">保存失败，配置文件不可写</span><?php endif;?>
</div>
<div class=line></div>
<div class="des">腾讯微博插件基于腾讯微博API，可以将emlog内发布的碎语、日志自动同步到你所指定的腾讯微博账号，无需你手动操作。
<br /><br />提示：请确保本插件目录及emlog_tx_profile.php文件据有写权限（777）。</div>
<div id="sinat_form">

<?php
if (!isset($_GET['oauth_token']) && !defined('TX_ACCESS_TOKEN')): ?>
	<li><a href="<?php echo $aurl ?>"><img src="../content/plugins/emlog_tx/t-login.png"></a></li>
<?php else:?>
<?php
	$api_name = 'user/info';
	$ms = OpenSDK_Tencent_Weibo::call($api_name);
?>
	<li><img src="<?php echo $ms['data']['head']; ?>/100" style="border:2px #CCCCCC solid;"/></li>
	<li><b><?php echo $ms['data']['nick']; ?></b> (当前腾讯微博账号， <a href="./plugin.php?plugin=emlog_tx&do=chg">更换账号</a>，更换账户
	时请先退出当前浏览器中腾讯微博(t.qq.com)的登录状态)</li>
<?php endif;?>

</div>
<form id="form1" name="form1" method="post" action="plugin.php?plugin=emlog_tx&action=setting">
<div id="sinat_form">
<li>内容同步方案：
        <select name="sync">
        <?php
        $ex1 = $ex2 = $ex3 = '';
        $sync = 'ex' . TX_SYNC;
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
        $tfrom = 'ex' . TX_TFROM;
        $$tfrom = 'selected="selected"';
        ?>
          <option value="4" <?php echo $ex4; ?>>是</option>
          <option value="5" <?php echo $ex5; ?>>否</option>
        </select>
</li>
<p><input name="input" type="submit" value="保存设置" /> <span><a href="http://t.qq.com" target="_blank">访问腾讯微博&raquo;</a></span></p>
</div>
</form>
<?php
}

function save_access_token($token, $secret){
	$profile = EMLOG_ROOT.'/content/plugins/emlog_tx/emlog_tx_token_conf.php';

	$sinat_new_profile = "<?php\ndefine('TX_ACCESS_TOKEN','$token');\ndefine('TX_ACCESS_SECRET','$secret');\n";

	$fp = @fopen($profile,'wb');
	if(!$fp) {
	    emMsg('操作失败，请确保插件目录(/content/plugins/emlog_tx/)可写');
	}
	fwrite($fp,$sinat_new_profile);
	fclose($fp);
}

function plugin_setting(){
    $profile = EMLOG_ROOT.'/content/plugins/emlog_tx/emlog_tx_profile.php';

	$tx_sync = htmlspecialchars($_POST['sync'], ENT_QUOTES);
	$tx_tfrom = htmlspecialchars($_POST['tfrom'], ENT_QUOTES);

	$tx_new_profile = "<?php\ndefine('TX_SYNC','$tx_sync');\ndefine('TX_TFROM','$tx_tfrom');\n";

	$fp = @fopen($profile,'wb');
	if(!$fp) {
	    return false;
	}
	fwrite($fp,$tx_new_profile);
	fclose($fp);
}
?>
