<?php
/*
 * 阅读日志页面
 */
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>
<div id="breadcrumbs" class="pagenav">
    <div class="bcrumbs"><strong><a href="<?php echo BLOG_URL; ?>" title="返回首页">&nbsp;</a></strong>
        <span>><?php blog_sort($logid); ?>></span>
        <span><?php echo $log_title; ?></span>
    </div>
</div>	


<div id="echolog">
    <div class="content">
        <div id="loginfo">
                <?php global $CACHE;
                $user_cache = $CACHE->readCache('user');
                ?>
          	
            <h2 title="<?php echo $log_title; ?>"><?php echo $log_title; ?></a></h2>
            <span class="info">
                由 <?php blog_author($author); ?> 发布于 <?php blog_sort($logid); ?>  <?php echo gmdate('Y-m-d', $date); ?>&nbsp;[ <?php echo ($views); ?> ] 次浏览 [ <?php echo ($comnum); ?> ] 条评论</span>
            <p class="tag"><?php blog_tag($logid); ?></p>
        </div><!--end loginfo-->
        <div class="post_content">
            <!--正文-->
            <?php
            /* if(!empty($user_cache[UID]['photo']['src']) && $zq_is_com): */
            if(function_exists("JA_Page")) echo JA_Page($log_content, $logid); else echo $log_content;
            /*
              else:
              if(isset($_COOKIE['qq-username']) && !empty($_COOKIE['qq-username'])):
              echo "<div style='clear:both;padding:20px;font-weight:bold;fond-size:14px;'>亲，您还没有完善帐户信息，或绑定帐户，赶快去完善吧!</div>";
              elseif(empty($user_cache[UID]['photo']['src'])):
              echo "<div style='clear:both;padding:20px;font-weight:bold;fond-size:14px;'>亲，您需要先登录，才能查看喔！</div>";
              else:
              echo "<div style='clear:both;padding:20px;font-weight:bold;fond-size:14px;'>亲，您需要先回复，才能查看喔！</div>";
              endif;
              endif;
             * 
             */
            ?>
        </div>

        <?php neighbor_log($neighborLog); ?>
        <?php doAction('log_related', $logData); ?>
        <?php if ($allow_remark == 'y'): ?>
            <?php $comnum = ($comnum != 0) ? '目前有 ' . $comnum . ' 条留言' : '等您坐沙发呢！'; ?>
            <h3 id="comments" style="margin:20px 0 10px 0;clear:both;"><?php echo $log_title; ?>：<?php echo $comnum; ?></h3>
            <?php blog_comments($comments, $params); ?>
            <div id="user_comment_result">&nbsp;&nbsp;</div>
            <?php
            /* if(!empty($user_cache[UID]['photo']['src'])): */
            blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark);
            /*
              elseif(isset($_COOKIE['qq-username']) && !empty($_COOKIE['qq-username'])):

              else:
              echo "<div style='clear:both;padding:20px;font-weight:bold;fond-size:14px;'>您还没有登录，还不能评论喔!</div>";
              endif;
             * 
             */
            ?>

<?php endif; ?>
    </div>
</div><!--end echolog-->
<?php
include View::getView('side');
include View::getView('footer');
?>