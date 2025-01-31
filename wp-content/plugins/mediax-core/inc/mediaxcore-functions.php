<?php

/**
 * @Packge     : Mediax
 * @Version    : 1.0
 * @Author     : Themeholy
 * @Author URI : https://themeforest.net/user/themeholy
 *
 */

    // Block direct access

    if( ! defined( 'ABSPATH' ) ){

        exit();

    }

/**

 * Admin Custom Login Logo

 */

function mediax_custom_login_logo() {

    $logo = ! empty( mediax_opt( 'mediax_admin_login_logo', 'url' ) ) ? mediax_opt( 'mediax_admin_login_logo', 'url' ) : '' ;

    if( isset( $logo ) && ! empty( $logo ) ){

        echo '<style type="text/css">body.login div#login h1 a { background-image:url('.esc_url( $logo ).'); }</style>';
    }
}

add_action( 'login_enqueue_scripts', 'mediax_custom_login_logo' );

/**
* Admin Custom css
*/

add_action( 'admin_enqueue_scripts', 'mediax_admin_styles' );

function mediax_admin_styles() {

  if ( ! empty( $mediax_admin_custom_css ) ) {
        $mediax_admin_custom_css = str_replace(array("\r\n", "\r", "\n", "\t", '    '), '', $mediax_admin_custom_css);
        echo '<style rel="stylesheet" id="mediax-admin-custom-css" >';
            echo esc_html( $mediax_admin_custom_css );
        echo '</style>';
    }
}

// share button code

 function mediax_social_sharing_buttons( ) {

    // Get page URL

    $URL        = get_permalink();
    $Sitetitle  = get_bloginfo('name');
    // Get page title

    $Title  = str_replace( ' ', '%20', get_the_title());

    // Construct sharing URL without using any script

    $twitterURL     = 'https://twitter.com/share?text='.esc_html( $Title ).'&url='.esc_url( $URL );
    $facebookURL    = 'https://www.facebook.com/sharer/sharer.php?u='.esc_url( $URL );
    $pinterest   = 'http://pinterest.com/pin/create/link/?url='.esc_url( $URL ).'&media='.esc_url(get_the_post_thumbnail_url()).'&description='.wp_kses_post(get_the_title());
    $linkedin       = 'https://www.linkedin.com/shareArticle?mini=true&url='.esc_url( $URL ).'&title='.esc_html( $Title );
    // Add sharing button at the end of page/page content

    $content = '';

    $content .= '<a href="'.esc_url( $facebookURL ).'" target="_blank"><i class="fab fa-facebook-f"></i></a>';
    $content .= '<a href="'. esc_url( $twitterURL ) .'" target="_blank"><i class="fab fa-twitter"></i></a>';
    $content .= '<a href="'.esc_url( $linkedin ).'" target="_blank"><i class="fab fa-linkedin-in"></i></a>';
    $content .= '<a href="'.esc_url( $pinterest ).'" target="_blank"><i class="fa-brands fa-pinterest-p"></i></a>';


    return $content;

};


//Post Reading Time Count

function mediax_estimated_reading_time() {
    global $post;
    // get the content
    $the_content = $post->post_content;
    // count the number of words
    $words = str_word_count( strip_tags( $the_content ) );
    // rounding off and deviding per 100 words per minute
    $minute = floor( $words / 100 );
    // rounding off to get the seconds
    $second = floor( $words % 100 / ( 100 / 60 ) );
    // calculate the amount of time needed to read
    $estimate = $minute . esc_html__(' Min', 'mediax') . ( $minute == 1 ? '' : 's' ) . esc_html__(' Read', 'mediax');
    // create output
    $output = $estimate;
    // return the estimate
    return $output;
}



//add SVG to allowed file uploads

function mediax_mime_types( $mimes ) {

    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svgz+xml';
    $mimes['exe'] = 'program/exe';
    $mimes['dwg'] = 'image/vnd.dwg';
    return $mimes;
}

add_filter('upload_mimes', 'mediax_mime_types');



function mediax_wp_check_filetype_and_ext( $data, $file, $filename, $mimes ) {

    $wp_filetype = wp_check_filetype( $filename, $mimes );
    $ext         = $wp_filetype['ext'];
    $type        = $wp_filetype['type'];
    $proper_filename = $data['proper_filename'];

    return compact( 'ext', 'type', 'proper_filename' );

}

add_filter( 'wp_check_filetype_and_ext', 'mediax_wp_check_filetype_and_ext', 10, 4 );


// if ( ! function_exists( 'etlms_course_categories' ) ) {
//     function etlms_course_categories() {
//         $course_categories      = array();
//         $course_categories_term = tutils()->get_course_categories_term();
//         foreach ( $course_categories_term as $term ) {
//             $course_categories[ $term->term_id ] = $term->name;
//         }

//         return $course_categories;
//     }
// }

// if ( ! function_exists( 'etlms_course_authors' ) ) {
//     function etlms_course_authors() {
//         $course_authors = array();
//         $authors        = get_users( array( 'role__in' => array( 'author', tutor()->instructor_role ) ) );
//         foreach ( $authors as $author ) {
//             $course_authors[ $author->ID ] = $author->display_name;
//         }

//         return $course_authors;
//     }
// }


// Event Post Type

// add_action( 'init','mediax_event', 0 );

function mediax_event(){

    $labels = array(

        'name'               => esc_html__( 'Events', 'post Category general name', 'mediax' ),
        'singular_name'      => esc_html__( 'Event', 'post Category singular name', 'mediax' ),
        'menu_name'          => esc_html__( 'Events', 'admin menu', 'mediax' ),
        'name_admin_bar'     => esc_html__( 'Event', 'add new on admin bar', 'mediax' ),
        'add_new'            => esc_html__( 'Add New', 'Event', 'mediax' ),
        'add_new_item'       => esc_html__( 'Add New Event', 'mediax' ),
        'new_item'           => esc_html__( 'New Event', 'mediax' ),
        'edit_item'          => esc_html__( 'Edit Event', 'mediax' ),
        'view_item'          => esc_html__( 'View Event', 'mediax' ),
        'all_items'          => esc_html__( 'All Events', 'mediax' ),
        'search_items'       => esc_html__( 'Search Events', 'mediax' ),
        'parent_item_colon'  => esc_html__( 'Parent Events:', 'mediax' ),
        'not_found'          => esc_html__( 'No Events found.', 'mediax' ),
        'not_found_in_trash' => esc_html__( 'No Events found in Trash.', 'mediax' ),
    );

    $args = array(

        'labels'             => $labels,
        'description'        => esc_html__( 'Description.', 'mediax' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-list-view',
        'supports'           => array( 'title', 'thumbnail', 'editor', 'elementor' ),
        'rewrite'            => array( 'slug' => 'events' ),
        'menu_position' => 10,
    );

    register_post_type( 'mediax_event', $args );


    $labels = array(

        'name'                       => esc_html__( 'Categories', 'taxonomy general name', 'mediax' ),
        'singular_name'              => esc_html__( 'Category', 'taxonomy singular name', 'mediax' ),
        'search_items'               => esc_html__( 'Search Categorys', 'mediax' ),
        'popular_items'              => esc_html__( 'Popular Categorys', 'mediax' ),
        'all_items'                  => esc_html__( 'All Categorys', 'mediax' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => esc_html__( 'Edit Category', 'mediax' ),
        'update_item'                => esc_html__( 'Update Category', 'mediax' ),
        'add_new_item'               => esc_html__( 'Add New Category', 'mediax' ),
        'new_item_name'              => esc_html__( 'New Category Name', 'mediax' ),
        'separate_items_with_commas' => esc_html__( 'Separate Categorys with commas', 'mediax' ),
        'add_or_remove_items'        => esc_html__( 'Add or remove Categorys', 'mediax' ),
        'choose_from_most_used'      => esc_html__( 'Choose from the most used Categorys', 'mediax' ),
        'not_found'                  => esc_html__( 'No Categorys found.', 'mediax' ),
        'menu_name'                  => esc_html__( 'Categories', 'mediax' ),
    );



    $args = array(

        'hierarchical'          => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'show_in_rest'          => true,
        'rewrite'               => array( 'slug' => 'event-category' ),
    );

    register_taxonomy( 'event_category', 'mediax_event', $args );



    // Add new taxonomy, NOT hierarchical (like tags)

    $labels = array(

        'name'                       => esc_html__( 'Tags', 'taxonomy general name', 'mediax' ),
        'singular_name'              => esc_html__( 'Tag', 'taxonomy singular name', 'mediax' ),
        'search_items'               => esc_html__( 'Search Tags', 'mediax' ),
        'popular_items'              => esc_html__( 'Popular Tags', 'mediax' ),
        'all_items'                  => esc_html__( 'All Tags', 'mediax' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => esc_html__( 'Edit Tag', 'mediax' ),
        'update_item'                => esc_html__( 'Update Tag', 'mediax' ),
        'add_new_item'               => esc_html__( 'Add New Tag', 'mediax' ),
        'new_item_name'              => esc_html__( 'New Tag Name', 'mediax' ),
        'separate_items_with_commas' => esc_html__( 'Separate Tags with commas', 'mediax' ),
        'add_or_remove_items'        => esc_html__( 'Add or remove Tags', 'mediax' ),
        'choose_from_most_used'      => esc_html__( 'Choose from the most used Tags', 'mediax' ),
        'not_found'                  => esc_html__( 'No Tags found.', 'mediax' ),
        'menu_name'                  => esc_html__( 'Tags', 'mediax' ),

    );

    $args = array(

        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'show_in_rest'          => true,
        'rewrite'               => array( 'slug' => 'event-tag' ),
    );

    register_taxonomy( 'event_tag', 'mediax_event', $args );
}

/**
 * Single Template
 */

// add_filter( 'single_template', 'mediax_core_template_redirect' );

if( ! function_exists( 'mediax_core_template_redirect' ) ){

    function mediax_core_template_redirect( $single_template ){
        global $post;

        if( $post ){

            if( $post->post_type == 'mediax_event' ){

                $single_template = MEDIAX_CORE_PLUGIN_TEMP . 'single-mediax_event.php';

            }
        }

        return $single_template;
    }

}


/**
 * Archive Template
 */

// add_filter( 'archive_template', 'mediax_core_template_archive' );

if( ! function_exists( 'mediax_core_template_archive' ) ){

    function mediax_core_template_archive( $archive_template ){

        global $post;


        if( $post ){

            if( $post->post_type == 'mediax_event' ){

                $archive_template = MEDIAX_CORE_PLUGIN_TEMP . 'archive-mediax_event.php';
            }
        }

        return $archive_template;
    }

}



// Add Image Size
add_image_size( 'mediax_85X85', 85, 85, true );
add_image_size( 'mediax_392X225', 392, 225, true );
add_image_size( 'mediax_332X190', 332, 190, true );
add_image_size( 'mediax_600X321', 600, 321, true );
add_image_size( 'mediax_401X256', 401, 256, true );

remove_filter( 'render_block', 'wp_render_layout_support_flag', 10, 2 );
remove_filter( 'render_block', 'gutenberg_render_layout_support_flag', 10, 2 );