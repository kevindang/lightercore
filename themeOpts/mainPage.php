<?php
/**
 * Add theme settings options page and subpage
 */
function lc_add_admin_page(){
	$pages = get_theme_support('lc_theme_settings');
	if(!is_null($page)){
		
	}
}
add_action('admin_menu','lc_add_admin_page');
