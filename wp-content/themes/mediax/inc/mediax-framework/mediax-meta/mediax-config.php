<?php

/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

 /**
 * Only return default value if we don't have a post ID (in the 'post' query variable)
 *
 * @param  bool  $default On/Off (true/false)
 * @return mixed          Returns true or '', the blank default
 */
function mediax_set_checkbox_default_for_new_post( $default ) {
	return isset( $_GET['post'] ) ? '' : ( $default ? (string) $default : '' );
}

add_action( 'cmb2_admin_init', 'mediax_register_metabox' );

/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */

function mediax_register_metabox() {

	$prefix = '_mediax_';

	$prefixpage = '_mediaxpage_';
	
	$mediax_post_meta = new_cmb2_box( array(
		'id'            => $prefixpage . 'blog_post_control',
		'title'         => esc_html__( 'Post Thumb Controller', 'mediax' ),
		'object_types'  => array( 'post' ), // Post type
		'closed'        => true
	) );

    $mediax_post_meta->add_field( array(
        'name' => esc_html__( 'Post Format Video', 'mediax' ),
        'desc' => esc_html__( 'Use This Field When Post Format Video', 'mediax' ),
        'id'   => $prefix . 'post_format_video',
        'type' => 'text_url',
    ) );

	$mediax_post_meta->add_field( array(
		'name' => esc_html__( 'Post Format Audio', 'mediax' ),
		'desc' => esc_html__( 'Use This Field When Post Format Audio', 'mediax' ),
		'id'   => $prefix . 'post_format_audio',
        'type' => 'oembed',
    ) );
	$mediax_post_meta->add_field( array(
		'name' => esc_html__( 'Post Thumbnail For Slider', 'mediax' ),
		'desc' => esc_html__( 'Use This Field When You Want A Slider In Post Thumbnail', 'mediax' ),
		'id'   => $prefix . 'post_format_slider',
        'type' => 'file_list',
    ) );
	
	$mediax_page_meta = new_cmb2_box( array(
		'id'            => $prefixpage . 'page_meta_section',
		'title'         => esc_html__( 'Page Meta', 'mediax' ),
		'object_types'  => array( 'page', 'mediax_event' ), // Post type
        'closed'        => true
    ) );

    $mediax_page_meta->add_field( array(
		'name' => esc_html__( 'Page Breadcrumb Area', 'mediax' ),
		'desc' => esc_html__( 'check to display page breadcrumb area.', 'mediax' ),
		'id'   => $prefix . 'page_breadcrumb_area',
        'type' => 'select',
        'default' => '1',
        'options'   => array(
            '1'   => esc_html__('Show','mediax'),
            '2'     => esc_html__('Hide','mediax'),
        )
    ) );


    $mediax_page_meta->add_field( array(
		'name' => esc_html__( 'Page Breadcrumb Settings', 'mediax' ),
		'id'   => $prefix . 'page_breadcrumb_settings',
        'type' => 'select',
        'default'   => 'global',
        'options'   => array(
            'global'   => esc_html__('Global Settings','mediax'),
            'page'     => esc_html__('Page Settings','mediax'),
        )
	) );

    $mediax_page_meta->add_field( array(
        'name'    => esc_html__( 'Breadcumb Image', 'mediax' ),
        'desc'    => esc_html__( 'Upload an image or enter an URL.', 'mediax' ),
        'id'      => $prefix . 'breadcumb_image',
        'type'    => 'file',
        // Optional:
        'options' => array(
            'url' => false, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => __( 'Add File', 'mediax' ) // Change upload button text. Default: "Add or Upload File"
        ),
        'preview_size' => 'large', // Image size to use when previewing in the admin.
    ) );

    $mediax_page_meta->add_field( array(
		'name' => esc_html__( 'Page Title', 'mediax' ),
		'desc' => esc_html__( 'check to display Page Title.', 'mediax' ),
		'id'   => $prefix . 'page_title',
        'type' => 'select',
        'default' => '1',
        'options'   => array(
            '1'   => esc_html__('Show','mediax'),
            '2'     => esc_html__('Hide','mediax'),
        )
	) );

    $mediax_page_meta->add_field( array(
		'name' => esc_html__( 'Page Title Settings', 'mediax' ),
		'id'   => $prefix . 'page_title_settings',
        'type' => 'select',
        'options'   => array(
            'default'  => esc_html__('Default Title','mediax'),
            'custom'  => esc_html__('Custom Title','mediax'),
        ),
        'default'   => 'default'
    ) );

    $mediax_page_meta->add_field( array(
		'name' => esc_html__( 'Custom Page Title', 'mediax' ),
		'id'   => $prefix . 'custom_page_title',
        'type' => 'text'
    ) );

    $mediax_page_meta->add_field( array(
		'name' => esc_html__( 'Breadcrumb', 'mediax' ),
		'desc' => esc_html__( 'Select Show to display breadcrumb area', 'mediax' ),
		'id'   => $prefix . 'page_breadcrumb_trigger',
        'type' => 'switch_btn',
        'default' => mediax_set_checkbox_default_for_new_post( true ),
    ) );

    $mediax_layout_meta = new_cmb2_box( array(
		'id'            => $prefixpage . 'page_layout_section',
		'title'         => esc_html__( 'Page Layout', 'mediax' ),
        'context' 		=> 'side',
        'priority' 		=> 'high',
        'object_types'  => array( 'page' ), // Post type
        'closed'        => true
	) );

	$mediax_layout_meta->add_field( array(
		'desc'       => esc_html__( 'Set page layout container,container fluid,fullwidth or both. It\'s work only in template builder page.', 'mediax' ),
		'id'         => $prefix . 'custom_page_layout',
		'type'       => 'radio',
        'options' => array(
            '1' => esc_html__( 'Container', 'mediax' ),
            '2' => esc_html__( 'Container Fluid', 'mediax' ),
            '3' => esc_html__( 'Fullwidth', 'mediax' ),
        ),
	) );

	// code for body class//

    $mediax_layout_meta->add_field( array(
	'name' => esc_html__( 'Insert Your Body Class', 'mediax' ),
	'id'   => $prefix . 'custom_body_class',
	'type' => 'text'
    ) );

}

add_action( 'cmb2_admin_init', 'mediax_register_taxonomy_metabox' );
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
function mediax_register_taxonomy_metabox() {

    $prefix = '_mediax_';
	/**
	 * Metabox to add fields to categories and tags
	 */
	$mediax_term_meta = new_cmb2_box( array(
		'id'               => $prefix.'term_edit',
		'title'            => esc_html__( 'Category Metabox', 'mediax' ),
		'object_types'     => array( 'term' ),
		'taxonomies'       => array( 'category'),
	) );
	$mediax_term_meta->add_field( array(
		'name'     => esc_html__( 'Extra Info', 'mediax' ),
		'id'       => $prefix.'term_extra_info',
		'type'     => 'title',
		'on_front' => false,
	) );
	$mediax_term_meta->add_field( array(
		'name' => esc_html__( 'Category Image', 'mediax' ),
		'desc' => esc_html__( 'Set Category Image', 'mediax' ),
		'id'   => $prefix.'term_avatar',
        'type' => 'file',
        'text'    => array(
			'add_upload_file_text' => esc_html__('Add Image','mediax') // Change upload button text. Default: "Add or Upload File"
		),
	) );


	/**
	 * Metabox for the user profile screen
	 */
	$mediax_user = new_cmb2_box( array(
		'id'               => $prefix.'user_edit',
		'title'            => esc_html__( 'User Profile Metabox', 'mediax' ), // Doesn't output for user boxes
		'object_types'     => array( 'user' ), // Tells CMB2 to use user_meta as post_meta
		'show_names'       => true,
		'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
	) );
    $mediax_user->add_field( array(
		'name' => esc_html__( 'Author Designation', 'mediax' ),
		'desc' => esc_html__( 'Use This Field When Author Designation', 'mediax' ),
		'id'   => $prefix . 'author_desig',
        'type' => 'text',
    ) );
	$mediax_user->add_field( array(
		'name'     => esc_html__( 'Social Profile', 'mediax' ),
		'id'       => $prefix.'user_extra_info',
		'type'     => 'title',
		'on_front' => false,
	) );

	$group_field_id = $mediax_user->add_field( array(
        'id'          => $prefix .'social_profile_group',
        'type'        => 'group',
        'description' => __( 'Social Profile', 'mediax' ),
        'options'     => array(
            'group_title'       => __( 'Social Profile {#}', 'mediax' ), // since version 1.1.4, {#} gets replaced by row number
            'add_button'        => __( 'Add Another Social Profile', 'mediax' ),
            'remove_button'     => __( 'Remove Social Profile', 'mediax' ),
            'closed'         => true
        ),
    ) );

    $mediax_user->add_group_field( $group_field_id, array(
        'name'        => __( 'Icon Class', 'mediax' ),
        'id'          => $prefix .'social_profile_icon',
        'type'        => 'text', // This field type
    ) );

    $mediax_user->add_group_field( $group_field_id, array(
        'desc'       => esc_html__( 'Set social profile link.', 'mediax' ),
        'id'         => $prefix . 'lawyer_social_profile_link',
        'name'       => esc_html__( 'Social Profile link', 'mediax' ),
        'type'       => 'text'
    ) );
}
