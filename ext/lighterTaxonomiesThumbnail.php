<?php
/**
 * add image for taxonomies
 * @throws Exception
 * @package Lighter Core
 * @subpackage Thumnail For Taxonomies
 * @since 1.0
 */
function lc_taxonomies_thumbnail() {
	$taxes = get_taxonomies ();
	unset ( $taxes ['post_format'] );
	unset ( $taxes ['link_category'] );
	$taxes = apply_filters ( 'lc_taxonomies_thumbnail', $taxes );
	$taxesSupport = get_theme_support ( 'lc_taxonomies_thumbnail' );
	if (is_array ( $taxesSupport )) {
		foreach ( $taxesSupport [0] as $tax ) {
			if (array_key_exists ( $tax, $taxes )) {
				add_action ( $tax . "_add_form_fields", 'lc_add_taxonomies_field', 2 );
				add_action ( $tax . "_edit_form_fields", 'lc_edit_taxonomies_field', 2 );
				add_filter ( 'manage_edit-' . $tax . '_columns', 'lc_taxonomies_columns', 2 );
				add_filter ( 'manage_' . $tax . "_custom_column", 'lc_taxonomies_custom_column', 10, 3 );
			}
		}
	} else {
		throw new Exception ( __ ( 'You must set value for taxonomies', 'lc_menu' ) );
	}
	wp_enqueue_script ( 'thickbox' );
	wp_enqueue_style ( 'thickbox' );
	lc_register_script ( 'uploadScript', 'uploadBox.js' );
}
add_action ( 'admin_init', 'lc_taxonomies_thumbnail', 2 );
/**
 * add new thumbnail field each taxonomy into admin page.
 *
 * @package Lighter Core
 * @subpackage Thumnail For Taxonomies
 * @since 1.0
 */
function lc_add_taxonomies_field() {
	?>
<div class="form-field">
	<label for="lc_taxonomy_image">Image</label> <input type="text"
		name="lc_taxonomy_image" id="lc_taxonomy_image" value=""> <br />
	<button id="lc_image_button" class="button">Upload/Add image</button>
</div>
<script>
	jQuery(document).ready(function($){
		$("#lc_image_button").LCUploadBox("#lc_taxonomy_image","Upload/Seclet Image For Taxonomy");
		});
</script>
<?php
}
/**
 * add thumbnail field into edit screen
 *
 * @package Lighter Core
 * @subpackage Thumnail For Taxonomies
 * @since 1.0
 */
function lc_edit_taxonomies_field() {
	?>
<tr class="form-field">
	<th scope="row" valign="top"><label for="lc_taxonomy_image">Image</label></th>
	<td><input type="text" name="lc_taxonomy_image" id="lc_taxonomy_image"
		value="">
		<button id="lc_image_button" class="button">Upload/Add image</button>
		<button id="lc_remove_button" class="button">Remove image</button></td>
</tr>
<script>
	jQuery(document).ready(function($){
		$("#lc_image_button").LCUploadBox("#lc_taxonomy_image","Upload/Seclet Image For Taxonomy");
		});
</script>
<?php
}
/**
 * insert thumbnail header column into list taxonomy area
 *
 * @param array $columns
 *        	list field columns of taxonomy
 * @return multitype:
 * @package Lighter Core
 * @subpackage Thumnail For Taxonomies
 * @since 1.0
 */
function lc_taxonomies_columns($columns) {
	$lcColumns = array ();
	$lcColumns ['cb'] = $columns ['cb'];
	unset ( $columns ['cb'] );
	$lcColumns ['lc_image'] = __ ( "Image", "lc_taxonomies_thumbnail" );
	return array_merge ( $lcColumns, $columns );
}
/**
 * Display value of new custom field
 *
 * @param array $columns
 *        	list columns of taxonomy
 * @param string $column
 *        	name of current column
 * @param int $id
 *        	id of current taxonomy
 * @return array $columns
 * @package Lighter Core
 * @subpackage Thumnail For Taxonomies
 * @since 1.0
 */
function lc_taxonomies_custom_column($columns, $column, $id) {
	if ($column == 'lc_image') {
		$columns = '<span class="lc-image">' .lc_image(apply_filters('lc_taxonomy_default_image', lc_get_thumbnail_image ( $id )),"Thumbnail")  . '</span>';
	}
	return $columns;
}

add_action ( 'create_term', 'lc_save_image_for_term' );
add_action ( 'edit_term', 'lc_save_image_for_term' );
/**
 * Save image uri into database
 *
 * @param unknown $termID        	
 * @return array $columns
 * @package Lighter Core
 * @subpackage Thumnail For Taxonomies
 * @since 1.0
 */
function lc_save_image_for_term($termID) {
	if (isset ( $_POST ['lc_taxonomy_image'] )) {
		update_option ( 'lc_taxonomy_image' . $termID, $_POST ['lc_taxonomy_image'] );
	}
}
