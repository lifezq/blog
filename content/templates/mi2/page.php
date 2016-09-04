<?php
/*
 * 自建页面模板
 */
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>

<div id="breadcrumbs" class="pagenav">
    <div class="bcrumbs"><strong><a href="<?php echo BLOG_URL; ?>" title="返回首页">&nbsp;</a></strong>
        <span><?php echo $log_title; ?></span>
    </div>
</div>	

<!--start #page-->
<div class="page">
    <div class="content"><!--start #content-->
        <h2><?php echo $log_title; ?></h2>
        <?php echo $log_content; ?>	
        <?php if ($allow_remark == 'y'): ?>
            <?php $comnum = ($comnum != 0) ? '目前有 ' . $comnum . ' 条留言' : '等您坐沙发呢！'; ?>
            <h3 id="comments" style="margin:20px 0 10px 0;clear:both;"><?php echo $log_title; ?>：<?php echo $comnum; ?></h3>
            <?php blog_comments($comments, $params); ?>
            <div id="user_comment_result">&nbsp;&nbsp;</div>
    <?php blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark); ?>
<?php endif; ?>
    </div><!--end #content-->
</div><!--end #page-->
<?php
include View::getView('side');
include View::getView('footer');
?>