<?php
/*
Plugin Name: 激活邮件发送
Version: 1.0
Description: 激活邮件发送，可以测试邮件是否能及时并正确的发送的用户
Author: 之晴
Author Email: yangqianleizq@gmail.com
Author URL: http://lifezq.com
*/
!defined('EMLOG_ROOT') && exit('access deined!');

function zq_invite_menu() {
    echo '<div class="sidebarsubmenu" id="zq_invite"><a href="./plugin.php?plugin=zq_invite">邀请邮件</a></div>';
}

addAction('adm_sidebar_ext', 'zq_invite_menu');
?>
