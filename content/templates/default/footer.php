<?php 
/**
 * 页面底部信息
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
</div><!--end #content-->
<div style="clear:both;"></div>
<div id="footerbar">
	Powered by <a href="http://www.emlog.net" title="emlog <?php echo Option::EMLOG_VERSION;?>">emlog</a> 
	<a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a> <?php echo $footer_info; ?>
	<?php doAction('index_footer'); ?>
</div><!--end #footerbar-->
</div><!--end #wrap-->
<script>prettyPrint();</script>

<!-- blog.lifezq.com Baidu tongji analytics -->
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fcbd656b3f0593714fc390aba8f59c3e1' type='text/javascript'%3E%3C/script%3E"));
</script>

</body>
</html>