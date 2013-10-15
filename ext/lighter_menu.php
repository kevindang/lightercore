<?php
/**
 * Register menu locations
 * @throws Exception if array $menus is empty
 */
function lc_add_menu_locations() {
	$temp = apply_filters ( 'lc_menu_locations', array (
			'top' => __ ( 'Top Navigation Menu', 'lc_menu' ),
			'main' => __ ( 'Main Navigation Menu', 'lc_menu' ),
			'bottom' => __ ( 'Bottom Navigation Menu' ) 
	) );
	$menus = get_theme_support ( 'lc_menus' );
	if (is_array ( $menus )) {
		foreach ( $menus [0] as $menu ) {
			if (array_key_exists ( $menu, $temp ))
				;
			{
				register_nav_menu ( $menu, $temp [$menu] );
			}
		}
	} else {
		throw new Exception ( __ ( 'You must set value for menu locations setting', 'lc_menu' ) );
	}
}
add_action ( 'after_setup_theme', 'lc_add_menu_locations' );
class LCWalkerMenuWithDescription extends Walker_Nav_Menu implements LCSingle {
	private static $instance;
	public static function getInstance() {
		if (static::$instance == null) {
			static::$instance = new static ();
		}
		return static::$instance;
	}
	/**
	 * Custommize walker for lc menus , you can change value via two filters:
	 * lc_nav_menu_wrap and lc_nav_menu_description
	 * 
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *       
	 * @param string $output
	 *        	Passed by reference. Used to append additional content.
	 * @param object $item
	 *        	Menu item data object.
	 * @param int $depth
	 *        	Depth of menu item. Used for padding.
	 * @param int $current_page
	 *        	Menu item ID.
	 * @param object $args        	
	 */
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		$indent = ($depth) ? str_repeat ( "\t", $depth ) : '';
		
		$class_names = $value = '';
		
		$classes = empty ( $item->classes ) ? array () : ( array ) $item->classes;
		$classes [] = 'menu-item-' . $item->ID;
		
		$class_names = join ( ' ', apply_filters ( 'nav_menu_css_class', array_filter ( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr ( $class_names ) . '"' : '';
		
		$id = apply_filters ( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr ( $id ) . '"' : '';
		
		$output .= $indent . '<li' . $id . $value . $class_names . '>';
		
		$atts = array ();
		$atts ['title'] = ! empty ( $item->attr_title ) ? $item->attr_title : '';
		$atts ['target'] = ! empty ( $item->target ) ? $item->target : '';
		$atts ['rel'] = ! empty ( $item->xfn ) ? $item->xfn : '';
		$atts ['href'] = ! empty ( $item->url ) ? $item->url : '';
		
		$atts = apply_filters ( 'nav_menu_link_attributes', $atts, $item, $args );
		
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if (! empty ( $value )) {
				$value = ('href' === $attr) ? esc_url ( $value ) : esc_attr ( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		$wrapMenu = explode ( "|", apply_filters ( 'lc_nav_menu_wrap', '<span class="lc-nav-menu">|</span>' ) );
		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . apply_filters ( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= apply_filters ( 'lc_nav_menu_description', $wrapMenu [0] . $item->description . $wrapMenu [1] );
		$item_output .= $args->after;
		
		$output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}
