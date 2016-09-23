<?php
/*
Plugin Name: 二维码生成
Version: 1.0
Description: 二维码生成，可以随意设置您自己想生成的二维码文字
Author: 之晴
Author Email: yangqianleizq@gmail.com
Author URL: http://lifezq.com
*/
!defined('EMLOG_ROOT') && exit('access deined!');

function em_dimension_menu() {
    echo '<div class="sidebarsubmenu" id="em_dimension"><a href="./plugin.php?plugin=em_dimension">二维码生成</a></div>';
}

addAction('adm_sidebar_ext', 'em_dimension_menu');
?>