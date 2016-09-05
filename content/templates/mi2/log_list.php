<?php 
/*
* 首页日志列表部分
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>

	


<div class="content">
<?php doAction('index_loglist_top'); ?>

		<?php if (isset($tag)):?>
    <div class="listtop">
		<span class="navtopnotice">>>包含标签 【<?php echo $tag; ?>】 的文章</span>
                </div>
		<?php elseif (isset($sortid)): ?>
    <div class="listtop">
		<?php global $CACHE; $sort_cache = $CACHE->readCache('sort'); ?>
		<span class="navtopnotice">>>以下是分类【<?php echo $sort_cache[$sortid]['sortname']; ?>】里的文章</span>
		</div>
		<?php elseif (isset($author)): ?>
    <div class="listtop">
		<span class="navtopnotice">>>作者 【<?php echo $author_name; ?>】 的文章</span>
		</div>
		<?php elseif (isset($keyword)):?>
    <div class="listtop">
		<span class="navtopnotice">>>含有搜索词 【<?php echo $keyword; ?>】 的文章</span>
		</div>
		<?php elseif (isset($record)):?>
    <div class="listtop">
		<span class="navtopnotice">>>存档于 【<?php echo $record; ?>】 的文章</span>
		</div>
			<?php endif; ?>
<!--listtop-->

<!--日志列表-->
<?php global $CACHE;	$user_cache = $CACHE->readCache('user'); foreach($logs as $value): ?>
<div class="lists">
    <div class="lists_m" >
        <div class="box">
          <div class="title">
            <?php echo $value['gid']; ?> . <a href="<?php echo $value['log_url']; ?>" rel="bookmark" title="<?php echo $value['log_title']; ?> --点击打开查看"><?php topflg($value['top']); ?><?php echo $value['log_title']; ?></font></a>
          </div>
            <div class="con_jie" class="con_jie"><?php echo $value['log_description'];?></div>
<span class="con_count"><?php echo gmdate('Y-n-j', $value['date']).' &nbsp;';
if(isset($value['sortname'])){
    echo  '分类：'.$value['sortname'].'&nbsp;';
}
?>  &nbsp;
        	<a href="<?php echo $value['log_url']; ?>#comments" target="_blank">评论：<?php echo $value['comnum']; ?></a>
			&nbsp;<a href="<?php echo $value['log_url']; ?>">浏览：<?php echo $value['views']; ?></a></span>
    	
         </div><!--end box-->
     </div><!--end lists_m-->
	 <div style="clear:both"></div>
</div><!--end lists-->
<?php endforeach; ?>
       
<div class="serpage">
	<a  href="<?php echo WEB_ROOT; ?>/messages.html" class='guestbookimg'></a>
	<div class="pagelist">  
			<?php echo $page_url;?> 
			<?php if($page_url): ?>
				<span class="pageinfo">第 <b><?php echo $page; ?></b> 页 / 共 <b><?php echo ceil($lognum/$index_lognum); ?></b> 页</span>
			<?php endif; ?>&nbsp;&nbsp;&nbsp;
	</div>
</div>
</div><!-- end #content-->
<?php
	include View::getView('side');
	include View::getView('footer');
?>