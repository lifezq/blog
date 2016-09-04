<?php
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}

function plugin_setting_view() {
    global $user_cache;
    $dimDir = '../content/plugins/em_dimension/dimension/';
    //删除二维码
    if (isset($_GET['dimdel']) && !empty($_GET['dimdel'])) {
        if (is_file($dimDir . $_GET['dimdel'])) {
            $del_ok=false;
            if(@unlink($dimDir . $_GET['dimdel']))
                $del_ok=true;
        }
    }elseif(isset($_POST['operate']) && !empty($_POST['operate'])){
        $_GET['dimdel']=true;
        foreach($_POST['demenid'] as $v){
            @unlink($dimDir .$v);
        }
        $del_ok=true;
    }
    $avatar = empty($user_cache[UID]['avatar']) ? './views/images/avatar.jpg' : '../' . $user_cache[UID]['avatar'];
    ?>
    <script>
        $("#em_dimension").addClass('sidebarsubmenu1');
    </script>
    <div class=containertitle> <b>二维码生成</b>
        <?php if (isset($_GET['dimdel']) && $del_ok): ?><span class="actived">二维码文件删除成功</span><?php elseif(isset($_GET['dimdel'])): ?><span class="error">删除失败，权限不足</span><?php endif; ?>
        <?php if (isset($_GET['setting'])): ?><span class="actived">二维码已经成功生成</span><?php endif; ?>
        <?php if (isset($_GET['error'])): ?><span class="error">生成失败，权限不足</span><?php endif; ?>
    </div>
    <div class=line></div>
    <div class="des">二维码生成，可以随意设置您自己想生成的二维码文字，赶快生成属于自己的二维码吧!
        <br /><br />提示：请确保dimension文件夹有可写可读权限。即：0777</div>
    <div id="tw">
        <div class="main_img"><a href="./blogger.php"><img src="<?php echo $avatar; ?>" height="52" width="52" /></a></div>
        <div class="right">
            <div id="sinat_form">
                <form action="plugin.php?plugin=em_dimension&action=setting" method="post">
                    请输入二维码内容:    
                    <div class="msg">你还可以输入140字</div>
                    <div class="box_1"><textarea class="box" name="dimension"></textarea></div>
                    <div class="tbutton"><input type="submit" value="生 成" onclick="return checkt();"/> </div>
                </form>

            </div>

            
        </div>
<div style="clear:both;padding:20px 0;">
    <form action="plugin.php?plugin=em_dimension" method="post" name="form_dimen" id="form_dimen">
                <table width="100%" id="adm_dimension_list" class="item_list">
                    <thead>
                        <tr>
                            <th width="369" colspan="2"><b>二维码文件</b></th>
                            <th width="250"><b>操作</b></th>
                        </tr>
                    </thead>
                    <?php

                    //读取已经生成的二维码列表
                    function _files($f) {
                        $file = glob($f);
                        static $fs;
                        static $i;
                        $i = 0;
                        foreach ($file as $v) {
                            if (is_dir($v)) {
                                _files($v . '/*');
                                $i++;
                            } else {
                                $k = str_replace('../content/plugins/em_dimension/dimension/', '', $v);
                                $fs[$i] = $k;
                                $i++;
                            }
                        }

                        return $fs;
                    }

                    $files = _files($dimDir . '*');
                    ?>
                    <tbody>
                        <?php
                        if ($files) {
                            $$dimenum=count($files);
                            $i=0;
                            foreach ($files as $k => $v):
                                $i++;
                                ?>
                                <tr>
                                    <td width="30"><input type="checkbox"  value="<?php echo $v; ?>"  name="demenid[]" class="ids" /></td>
                                    <td width="350"><?php echo $i.'.'; ?> <a href="<?php echo $dimDir . $v; ?>" title="查看" target="_blank"><?php echo $v; ?></a></td>
                                    <td><a href="javascript:;" title="删除" onClick="this.href='plugin.php?plugin=em_dimension&dimdel=<?php echo $v; ?>'">删除</a></td>
                                </tr>
                                <?php
                            endforeach;
                        }else {
                            ?>
                            <tr><td class="tdcenter" colspan="4">您还没有自己的二维码喔！</td></tr>
    <?php } ?>
                    </tbody>
                </table>
        <?php if ($files) : ?>
        <div class="list_footer">
	<a href="javascript:void(0);" id="select_all">全选</a> 选中项：
    <a href="javascript:commentact('del');" class="care">删除</a>
	<input name="operate" id="operate" value="" type="hidden" />
	</div>
    <div class="page"><?php if(isset($dimenum)){ echo '(共有'.$dimenum.'个二维码文件)';  } ?></div> 
    <?php endif; ?>
    </form>
            </div>
    </div>
    <?php
}

function plugin_setting() {
    require_once 'phpqrcode.php'; //载入二维码类
    $dimension = trim(htmlspecialchars(addslashes($_POST['dimension'])), ',');

    $dir = '../content/plugins/em_dimension/dimension/';
    if (!is_dir($dir))
        mkdir($dir, 0777, true);
    $dimen_img = $dir . date('Ymd-H-i-s') . '-' . rand(0, 1000) . '.png';

    QRcode::png($dimension, $dimen_img);
    if (is_file($dimen_img)) {
        return true;
    } else {
        return false;
    }
}
?>
<script>
    $(document).ready(function(){
        	$("#select_all").toggle(function () {$(".ids").attr("checked", "checked");},function () {$(".ids").removeAttr("checked");});
	$("#adm_dimension_list tbody tr:odd").addClass("tralt_b");
	$("#adm_dimension_list tbody tr")
		.mouseover(function(){$(this).addClass("trover");$(this).find("span").show();})
		.mouseout(function(){$(this).removeClass("trover");$(this).find("span").hide();})


        $(".box").keyup(function(){
            var t=$(this).val();
            var n = 140 - t.length;
            if (n>=0){
                $(".msg").html("你还可以输入"+n+"字");
            }else {
                $(".msg").html("<span style=\"color:#FF0000\">已超出"+Math.abs(n)+"字</span>");
            }
        });
    });
    function checkt(){
        var t=$(".box").val();
        if (t.length > 140){return false;}
    }
    
setTimeout(hideActived,2600);
function commentact(act){
	if (getChecked('ids') == false) {
		alert('请选择要操作的二维码文件');
		return;
	}
	if(act == 'del' && !confirm('你确定要删除所选二维码文件吗？')){return;}
	$("#operate").val(act);
	$("#form_dimen").submit();
}
</script>