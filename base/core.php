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
 *
 */
function lc_register_script($handle = "", $filename = "") {
	wp_enqueue_script ( $handle, trailingslashit ( LC_JS_URI ) . $filename );
}
function lc_image($src, $alt = "") {
	return '<img src="' . $src . '" alt="' . $alt . '" />';
}
abstract class LCAMenuPageFactory extends LCSingleFactory {
	public function createPage($main = FALSE) {
		return new LCAMenuPage ();
	}
}
class LCMenuPageFactory extends LCAMenuPageFactory {
	public function createPage($main = FALSE) {
		if ($main) {
			return new LCMainMenuPage ();
		} else {
			return new LCSubMenuPage ();
		}
	}
}
abstract class LCAMenuPage {
	public $menu_slug;
	public $page_title;
	public $menu_title;
	public $section = array ();
	public $capabitily = 'manage_options';
	public function addPage() {
		add_action ( 'admin_menu', array (
				&$this,
				'register' 
		),2 );
	}
	public abstract function register();
	public abstract function display();
}
class LCMainMenuPage extends LCAMenuPage {
	public function register() {
		add_menu_page ( $this->page_title, $this->menu_title, $this->capabitily, $this->menu_slug, array (
				&$this,
				'display' 
		), '' );
	}
	public function display() {
	}
}
class LCSubMenuPage extends LCAMenuPage {
	public $parent_slug;
	public function __construct() {
	}
	public function register() {
	}
	public function display() {
	}
}
