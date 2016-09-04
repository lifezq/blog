<?php
/**
 * kl_auto_excerpt_setting.php
 * design by KLLER
 */
!defined('EMLOG_ROOT') && exit('access deined!');

function plugin_setting_view()
{
	include(EMLOG_ROOT.'/content/plugins/kl_auto_excerpt/kl_auto_excerpt_config.php');
?>
<script type="text/javascript">
$("#kl_auto_excerpt").addClass('sidebarsubmenu1');
function myKeyDown(e){
	if(window.event){//IE
		var k = e.keyCode;
		if ((k == 13)||(k == 9) || (k == 35) || (k == 36) || (k == 8) || (k == 46) || (k >= 48 && k <=57 )||( k >= 96 && k <= 105)||(k >= 37 && k <= 40)){
		}else{
			window.event.returnValue = false;
		}
	}else{//火狐
		var k = e.which;
		if ((k == 13)||(k == 9) || (k == 35) || (k == 36) || (k == 8) || (k == 46) || ( k>= 48 && k <= 57)||(k >= 96 && k <= 105)||(k >= 37 && k <= 40)){
		}else{
			e.preventDefault();
		}
	}
}
setTimeout(hideActived,2600);
</script>
<div class=containertitle><b>自动摘要</b><?php if(isset($_GET['setting'])):?><span class="actived">操作成功</span><?php endif;?></div>
<div class=line></div>
<form action="./plugin.php?plugin=kl_auto_excerpt&action=setting" method="POST">
设置摘要的长度：<input type="text" name="strlength" size="4" maxlength="4" value="<?php echo KL_AUTO_EXCERPT_LENGTH; ?>" style="ime-mode:disabled;" onkeydown="myKeyDown(event);" />
<input type="submit" value="提 交" />
</form>
<div style="margin-top:20px; padding:5px; width:600px; border:1px dashed #CCC">
<p><font color="Red"><b>重要提示：</b><br /></font>
1、当你改变这里的摘要长度设置后，之前生成的摘要长度不会改变，仅对之后新撰写的日志有效。<br />
2、你可以在日志撰写页面的高级选项里修改自动生成的摘要。
</p>
</div>
<?php
}
function plugin_setting()
{
	$fso = fopen(EMLOG_ROOT.'/content/plugins/kl_auto_excerpt/kl_auto_excerpt_config.php','r');
	$config = fread($fso,filesize(EMLOG_ROOT.'/content/plugins/kl_auto_excerpt/kl_auto_excerpt_config.php'));
	fclose($fso);
	$strlength = intval($_POST['strlength']);
	$pattern = array("/define\('KL_AUTO_EXCERPT_LENGTH',(.*)\)/",);
	$replace = array("define('KL_AUTO_EXCERPT_LENGTH','".$strlength."')",);
	$new_config = preg_replace($pattern, $replace, $config);
	$fso = fopen(EMLOG_ROOT.'/content/plugins/kl_auto_excerpt/kl_auto_excerpt_config.php','w');
	fwrite($fso,$new_config);
	fclose($fso);
}
?>