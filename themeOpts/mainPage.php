<?php
/**
 * Add theme settings options page and subpage
 */
function lc_add_admin_page() {
	add_menu_page ( 'LC Theme Settings', 'Theme Settings', 'manage_options', 'lc_theme_settings_page', 'lc_display_theme_settings_page', lc_get_icon_url ( 'lc_theme_settings' ), 91 );
}
add_action ( 'admin_menu', 'lc_add_admin_page', 2 );
function lc_display_theme_settings_page() {
	?>
<div class="wrap">
	<img src="<?php echo lc_get_icon_url('lc_theme_settings',32)?>"
		alt="Lighter Core Theme Settings" class="icon32" />
	<h2><?php echo __("Lighter Core Theme Setting","lc_admin");?></h2>
	<form action="options" method="post">
	<?php
	do_settings_sections ( 'lc_theme_settings_page' );
	?>
	<?php submit_button(__('Update Settings','lc_admin')); ?>
	</form>
</div>
<?php
}
/**
 * register theme options groups and sections for theme setting page;
 */
function lc_register_theme_settings_section() {
	$pages = get_theme_support ( 'lc_theme_settings' );
	$sections = apply_filters ( 'lc_theme_setting_sections', array (
			'header'=>'Header Options',
			'main'=>'Main Content Options',
			'footer'=>'Footer Options'
	) );
	if (is_array ( $pages )) {
		foreach ( $pages [0] as $page ) {
			if (array_key_exists ( $page, $sections )) {
				add_settings_section ( $page, $sections [$page], 'lc_display_'.$page."_section", 'lc_theme_settings_page' );
				register_setting ( 'lc_' . $page . '_settings', 'lc_' . $page . '_settings' );
			}
		}
	}
}
add_action ( 'admin_init', 'lc_register_theme_settings_section' );
function lc_display_header_section() {
	echo '<p class="description">' . __ ( "All settings for header layout content", "lc_admin" ) . '</p>';
}
function lc_display_main_section() {
	echo '<p class="description">' . __ ( "All settings for main layout content", "lc_admin" ) . '</p>';
}
function lc_display_footer_section(){
echo '<p class="description">' . __ ( "All settings for footer layout content", "lc_admin" ) . '</p>';
}