<?php
/**
 *	LTSingle -- An interface to force extend classes must overide getInstance method 
 *	@author longdhb
 *	@since 1.0
 *	@package LighterCore
 */
interface LCSingle {
	public static function getInstance();
}
/**
 * LTSingleFactory -- A class implemented Singleton design pattern
 *
 * @author longdhb
 * @since 1.0
 * @package LighterCore
 *         
 */
class LCSingleFactory implements LCSingle {
	protected static $instance;
	public static function getInstance() {
		if (static::$instance == null) {
			static::$instance = new static ();
		}
		return static::$instance;
	}
}
/**
 * get current taxonomy
 *
 * @return object taxonomy
 */
function lc_get_current_term() {
	return get_term_by ( 'slug', get_query_var ( 'term' ), get_query_var ( 'taxonomy' ) );
}
/**
 * get image url by id of taxonomy
 *
 * @param string $termID        	
 * @return string
 */
function lc_get_thumbnail_image($termID = null) {
	if (! $termID) {
		if (is_category ()) {
			$termID = get_query_var ( 'cat' );
		} elseif (is_tax ()) {
			$termID = lc_get_current_term ()->term_id;
		}
	}
	return get_option ( 'lc_taxonomy_image' . $termID );
}
/*
 * register javascript file for page
 */
function lc_register_script($handle = "", $filename = "") {
	wp_enqueue_script ( $handle, trailingslashit ( LC_JS_URI ) . $filename );
}
/**
 * Make image html tag with src and alt attributes
 *
 * @param string $src
 *        	image src
 * @param string $alt
 *        	image alt attribute
 * @return string image html tag
 */
function lc_image($src, $alt = "") {
	return '<img src="' . $src . '" alt="' . $alt . '" />';
}
function lc_get_icon_url($screenName = "", $size = 16) {
	$path = trailingslashit ( LC_IMG_URI );
	switch ($screenName) {
		case "lc_theme_settings" :
			return $path . "icon_theme_settings_" . $size . ".png";
			break;
	}
}








