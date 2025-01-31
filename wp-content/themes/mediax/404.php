<?php
/**
 * @Packge     : Mediax
 * @Version    : 1.0
 * @Author     : Themeholy
 * @Author URI : https://themeforest.net/user/themeholy
 *
 */

    // Block direct access
    if( !defined( 'ABSPATH' ) ){
        exit();
    }

    if( class_exists( 'ReduxFramework' ) ) {
        $mediax404title     = mediax_opt( 'mediax_error_title' );
        $mediax404description  = mediax_opt( 'mediax_error_description' );
        $mediax404btntext      = mediax_opt( 'mediax_error_btn_text' );
    } else {
        $mediax404title     = __( 'OooPs! Page Not Found', 'mediax' );
        $mediax404description  = __( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'mediax' );
        $mediax404btntext      = __( ' Back To Home', 'mediax');

    }

    // get header //
    get_header(); 
    
        echo '<section class="space">'; 
            echo '<div class="container">';
                echo '<div class="error-img">';
                    if(!empty(mediax_opt('mediax_error_img', 'url' ) )){
                        echo '<img src="'.esc_url( mediax_opt('mediax_error_img', 'url' ) ).'" alt="'.esc_attr__('404 image', 'mediax').'">';
                    }else{
                        echo '<img src="'.get_template_directory_uri().'/assets/img/error.svg" alt="'.esc_attr__('404 image', 'mediax').'">';
                    }
                echo '</div>';
                echo '<div class="error-content">';
                    echo '<h2 class="error-title">'.wp_kses_post( $mediax404title ).'</h2>';
                    echo '<p class="error-text">'.esc_html( $mediax404description ).'</p>';
                    echo '<a href="'.esc_url( home_url('/') ).'" class="th-btn error-btn th-radius"><i class="far fa-home me-2"></i>'.esc_html( $mediax404btntext ).'</a>';
                echo '</div>';
            echo '</div>';
        echo '</section>';

    //footer
    get_footer();