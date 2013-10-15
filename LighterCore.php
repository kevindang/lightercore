<?php
class Lighter {
	public function __construct() {
		$this->loadDefault ();
	}
	public function loadDefault() {
		add_action ( 'after_setup_theme', array (
				&$this,
				'loadBaseCore' 
		), 2 );
		add_action ( 'after_setup_theme', array (
				&$this,
				'loadExtensions' 
		), 3 );
	}
	public function loadBaseCore() {
		$this->define ();
		require_once trailingslashit ( LC_CORE_PATH ) . "core.php";
	}
	public function loadExtensions() {
		// load lighter menu extension
		require_if_theme_supports ( 'lc_menus', trailingslashit ( LC_EXT_PATH ) . "lighter_menu.php" );
		// load lighter taxonomies thumbnail
		require_if_theme_supports ( 'lc_taxonomies_thumbnail', trailingslashit ( LC_EXT_PATH ) . "lighterTaxonomiesThumbnail.php" );
		// load admin modules
		require_if_theme_supports ( 'lc_theme_settings', trailingslashit ( LC_THEME_OPT_PATH ) . "mainPage.php" );
	}
	public function define() {
		// define lighter core version
		define ( 'LC_VERSION', '1.0' );
		// define domain
		define ( 'LC_DOMAIN', 'en' );
		// define current path for LighterCore
		define ( "LC_PATH", trailingslashit ( get_template_directory () ) . "lib" );
		// define curent uri for LighterCore
		define ( "LC_URI", trailingslashit ( get_template_directory_uri () ) . "lib" );
		// define core path folder
		define ( "LC_CORE_PATH", trailingslashit ( LC_PATH ) . "base" );
		// define core url folder
		define ( "LC_CORE_URI", trailingslashit ( LC_URI ) . "base" );
		// define extension path
		define ( "LC_EXT_PATH", trailingslashit ( LC_PATH ) . "ext" );
		// define assets URI
		define ( "LC_ASSETS_URI", trailingslashit ( LC_URI ) . "assets" );
		// define js URI
		define ( "LC_JS_URI", trailingslashit ( LC_ASSETS_URI ) . "js" );
		// define img folder uri
		define ( "LC_IMG_URI", trailingslashit ( LC_ASSETS_URI ) . "image" );
		// define theme options path
		define ( "LC_THEME_OPT_PATH", trailingslashit ( LC_PATH ) . "themeOpts" );
	}
}