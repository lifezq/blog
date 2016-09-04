<?php 
/*
 * 读者墙插件
 * design by 小松
 */
function plugin_setting_view(){
	require_once('reader_wall_config.php');
}
?>
<script type="text/javascript">
$("#reader_wall").addClass('sidebarsubmenu1');
</script>
<div class="containertitle"><b>读者墙设置</b>
<?php if(isset($_GET['setting'])):?><span class="actived">插件设置完成</span><?php endif;?>
</div>
<div class="line"></div>
<form action="plugin.php?plugin=reader_wall&action=setting" method="post">
<div>
    <p>①、一周评论排行显示头像数：
	<input size="3" name="imgnum_week" type="text" value="<?php echo $imgnum_week; ?>" />
	&nbsp;&nbsp;头像大小（单位为px）：
	<input size="3" name="imgsize_week" type="text" value="<?php echo $imgsize_week; ?>" />
	</p>
    <p>②、一月评论排行显示头像数：
	<input size="3" name="imgnum_month" type="text" value="<?php echo $imgnum_month; ?>" />
	&nbsp;&nbsp;头像大小（单位为px）：
	<input size="3" name="imgsize_month" type="text" value="<?php echo $imgsize_month; ?>" />
	</p>
    <p>③、开博至今评论排行显示头像数：
	<input size="3" name="imgnum_all" type="text" value="<?php echo $imgnum_all; ?>" />
	&nbsp;&nbsp;头像大小（单位为px）：
	<input size="3" name="imgsize_all" type="text" value="<?php echo $imgsize_all; ?>" />
	</p>
	<p>④、侧边栏评论排行显示头像数：
	<input size="3" name="imgnum_side" type="text" value="<?php echo $imgnum_side; ?>" />
	&nbsp;&nbsp;头像大小（单位为px）：
	<input size="3" name="imgsize_side" type="text" value="<?php echo $imgsize_side; ?>" />
	&nbsp;&nbsp;统计区间：
	<select name="type_wall">
    <option value="week"<?php if($type_wall == 'week'):?> selected<?php endif;?>>week</option>
    <option value="month"<?php if($type_wall == 'month'):?> selected<?php endif;?>>month</option>
	<option value="all"<?php if($type_wall == 'all'):?> selected<?php endif;?>>all</option>
    </select>
	</p>
	<p>⑤、如果统计区间内数据为空，则显示如下：
	<input size="50" name="tip" type="text" value="<?php echo $tip; ?>" />
	</p>
	<p><input type="submit" value="保 存" class="submit" /></p>
</div>
</form>
<?php 
function plugin_setting(){
	$imgnum_week = isset($_POST['imgnum_week']) ? intval($_POST['imgnum_week']) : 20;
	$imgsize_week = isset($_POST['imgsize_week']) ? intval($_POST['imgsize_week']) : 32;
	$imgnum_month = isset($_POST['imgnum_month']) ? intval($_POST['imgnum_month']) : 30;
	$imgsize_month = isset($_POST['imgsize_month']) ? intval($_POST['imgsize_month']) : 32;
	$imgnum_all = isset($_POST['imgnum_all']) ? intval($_POST['imgnum_all']) : 40;
	$imgsize_all = isset($_POST['imgsize_all']) ? intval($_POST['imgsize_all']) : 32;
	$imgnum_side = isset($_POST['imgnum_side']) ? intval($_POST['imgnum_side']) : 8;
	$imgsize_side = isset($_POST['imgsize_side']) ? intval($_POST['imgsize_side']) : 32;
	$type_wall = isset($_POST['type_wall']) ? addslashes(trim($_POST['type_wall'])) : '';
	$tip = isset($_POST['tip']) ? addslashes(trim($_POST['tip'])) : '';
	$data = "<?php
	\$imgnum_week = ".$imgnum_week.";
	\$imgsize_week = ".$imgsize_week.";
	\$imgnum_month = ".$imgnum_month.";
	\$imgsize_month = ".$imgsize_month.";
	\$imgnum_all = ".$imgnum_all.";
	\$imgsize_all = ".$imgsize_all.";
	\$imgnum_side = ".$imgnum_side.";
	\$imgsize_side = ".$imgsize_side.";
	\$type_wall = '".$type_wall."';
	\$tip = '".$tip."';
?>";
	$file = EMLOG_ROOT.'/content/plugins/reader_wall/reader_wall_config.php';
	@ $fp = fopen($file, 'wb') OR emMsg('读取文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/reader_wall/reader_wall_config.php的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	@ $fw =	fwrite($fp,$data) OR emMsg('写入文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/reader_wall/reader_wall_config.php的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	fclose($fp);
}
?>