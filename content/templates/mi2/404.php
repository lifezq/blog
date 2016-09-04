<?php
/*
 * 自定义404页面
 */
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>错误提示-页面未找到</title>
        <style type="text/css">
            .main {
                background:url(<?php echo TEMPLATE_URL; ?>images/404.png) no-repeat;
                font-size: 12px;
                color: #666666;
                width:304px;
                height:204px;
                margin:60px auto 0px;
                border-radius: 10px;
                padding:0px 0px;


            }
            #returnpage {
                margin-top:10px;
                text-align:center;
            }
            #returnpage a{ color:#FF0000; font-weight:bolder; font-size:16px}
        </style>
    </head>
<?php include('header.php'); ?>
        <div class="main">
        </div>

        <p id="returnpage"><a href="javascript:history.back(-1);">&laquo;点击返回</a></p>
<?php include('footer.php'); ?>

        <!-- localhost Baidu tongji analytics -->
        <script type="text/javascript">
            var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
            document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fcbd656b3f0593714fc390aba8f59c3e1' type='text/javascript'%3E%3C/script%3E"));
        </script>
</html>