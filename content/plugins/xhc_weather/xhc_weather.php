<?php
/*
Plugin Name: 浮动天气预报
Version: 2.0
Plugin URL:
Description: 浮动天气预报
Author: 小火柴
Author Email: vke@vke.cc
Author URL: http://xiaohuochai.net
*/
!defined('EMLOG_ROOT') && exit('access deined!');

function xhc_weather()//写入插件导航
{
	echo '<div class="sidebarsubmenu" id="xhc_weather"><a href="./plugin.php?plugin=xhc_weather">浮动天气预报</a></div>';
}
addAction('adm_sidebar_ext','xhc_weather');
include_once('xhc_weather_config.php');
function xhc_weather_do(){
?>
 <script defer src="<?php echo BLOG_URL; ?>content/plugins/xhc_weather/js/jquery.weather.build.js?parentbox=<?php echo parentText; ?>&moveArea=<?php echo moveArea; ?>&zIndex=<?php echo zIndexNum; ?>&move=<?php echo IsMove; ?>&drag=<?php echo IsDrag; ?>&autoDrop=<?php echo IsAutoDrop; ?>&styleSize=<?php echo styleSize; ?>&style=<?php echo style; ?>&areas=<?php echo area; ?>&city=<?php echo urlencode(cityName); ?>"></script>


<?php
}

addAction('index_footer','xhc_weather_do');
/*addAction('index_footer','xhc_weather_div');*/
?>