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

    if( class_exists( 'ReduxFramework' ) && defined('ELEMENTOR_VERSION') ) {
        if( is_page() || is_page_template('template-builder.php') ) {
            $mediax_post_id = get_the_ID();

            // Get the page settings manager
            $mediax_page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );

            // Get the settings model for current post
            $mediax_page_settings_model = $mediax_page_settings_manager->get_model( $mediax_post_id );

            // Retrieve the color we added before
            $mediax_header_style = $mediax_page_settings_model->get_settings( 'mediax_header_style' );
            $mediax_header_builder_option = $mediax_page_settings_model->get_settings( 'mediax_header_builder_option' );

            if( $mediax_header_style == 'header_builder'  ) {

                if( !empty( $mediax_header_builder_option ) ) {
                    $mediaxheader = get_post( $mediax_header_builder_option );
                    echo '<header class="header">';
                        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $mediaxheader->ID );
                    echo '</header>';
                }
            } else {
                // global options
                $mediax_header_builder_trigger = mediax_opt('mediax_header_options');
                if( $mediax_header_builder_trigger == '2' ) {
                    echo '<header>';
                    $mediax_global_header_select = get_post( mediax_opt( 'mediax_header_select_options' ) );
                    $header_post = get_post( $mediax_global_header_select );
                    echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $header_post->ID );
                    echo '</header>';
                } else {
                    // wordpress Header
                    mediax_global_header_option();
                }
            }
        } else {
            $mediax_header_options = mediax_opt('mediax_header_options');
            if( $mediax_header_options == '1' ) {
                mediax_global_header_option();
            } else {
                $mediax_header_select_options = mediax_opt('mediax_header_select_options');
                $mediaxheader = get_post( $mediax_header_select_options );
                echo '<header class="header">';
                    echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $mediaxheader->ID );
                echo '</header>';
            }
        }
    } else {
        mediax_global_header_option();
    }