<?php
/*
 * 底部信息
 */
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>
<div style="clear:both;"></div>
<?php echo widget_link_footer('友情链接'); ?>
<div style="clear:both;"></div>
<div class="space"></div>
</div>
<!--footer-->
<div class="footer">
<div class="copyright">
    陕ICP备16000429号 Copyright ©  <a href="<?php echo WEB_ROOT; ?>" title="之晴博客" target="_blank">之晴</a>
    2012-<?php echo date('Y'); ?>  .  Powered by Emlog. Theme by <a href="<?php echo WEB_ROOT; ?>" title="之晴博客" target="_blank">之晴</a>.
</div>
<div class="right">
    <span class="navr">
        <a href="<?php echo $guestBook; ?>" target="_blank">联系我们</a> |
       <!--  <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=365755151&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:365755151:49" width="82" height="34" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>  | -->
        <a href="<?php echo BLOG_URL; ?>m" target="_blank">手机版</a> |
        <a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a>  |
        <!-- <?php echo WEB_ROOT; ?> Baidu tongji analytics -->
        <script type="text/javascript">
        var _hmt = _hmt || [];
        (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?0810a99adf306aca33f7df1d93290857";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
        })();
        </script>
    </span><br />
    <span><?php echo date("Y年m月d日"); ?>| <?php echo $footer_info; ?></span>
    </div><!--right-->
    <div class="clear"></div>
    <div class="footerRelief">
        <p>声明：之晴博客为个人站，此站主要为技术分享，资料共享，下载等，如果站内资源有侵犯您的利益，请及时联系我们会尽快处理。</p>
        <!-- <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p> -->
    </div>
    <div class="clear"></div>
    <?php doAction('index_footer');?>
    </div><!--end #footer-->
    <div id="shangxia">
        <div id="shang" title="↑ 返回顶部"></div>
        <div id="xia" title="↓ 移至底部"></div>
    </div>
    </div><!--end #warp-->
    <div style="clear:both;"></div>
    <script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>js/jquery_cmhello.js"></script>
    <!--[if IE 6]>
    <link href="<?php echo TEMPLATE_URL; ?>ie6.css" rel="stylesheet" type="text/css" />
    <script src="http://letskillie6.googlecode.com/svn/trunk/letskillie6.zh_CN.pack.js"></script>
    <script src="<?php echo TEMPLATE_URL; ?>js/PNG.js"></script>
    <script>DD_belatedPNG.fix('.png_bg');</script>
    <![endif]-->
    <script src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>js/thickbox_plus.js"></script>
</body>
</html>