<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
function callback_init(){
	$CACHE = Cache::getInstance();
	$DB = Database::getInstance();
	$options_cache = $CACHE->readCache('options');
	//写入widgest
	$custom_widget = $options_cache['custom_widget'] ? @unserialize($options_cache['custom_widget']) : array();
	$reader_wall_widgets_content = '<script type="text/javascript" src="'.BLOG_URL.'index.php?reader_wall_widgets"></script>';
	if(is_array($custom_widget))
	{
		if(!in_array('custom_wg_reader_wall',array_keys($custom_widget)))
		{
			//添加
			$custom_wg_index = 'custom_wg_reader_wall';
			$custom_widget[$custom_wg_index] = array('title'=>"读者墙",'content'=>$reader_wall_widgets_content);
			$custom_widget_str = addslashes(serialize($custom_widget));
			$DB->query("update ".DB_PREFIX."options set option_value='$custom_widget_str' where option_name='custom_widget'");
			//启用
			$widgets = !empty($options_cache['widgets1']) ? unserialize($options_cache['widgets1']) : array();
			$widgets[] = "custom_wg_reader_wall";
			$widgets = serialize($widgets);
			$DB->query("update ".DB_PREFIX."options set option_value='$widgets' where option_name='widgets1'");
			$CACHE->updateCache('options');
		}
	}
}
?>