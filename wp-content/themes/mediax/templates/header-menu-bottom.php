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

    if( defined( 'CMB2_LOADED' )  ){
        if( !empty( mediax_meta('page_breadcrumb_area') ) ) {
            $mediax_page_breadcrumb_area  = mediax_meta('page_breadcrumb_area');
        } else {
            $mediax_page_breadcrumb_area = '1';
        }
    }else{
        $mediax_page_breadcrumb_area = '1';
    }
    
    $allowhtml = array(
        'p'         => array(
            'class'     => array()
        ),
        'span'      => array(
            'class'     => array(),
        ),
        'a'         => array(
            'href'      => array(),
            'title'     => array()
        ),
        'br'        => array(),
        'em'        => array(),
        'strong'    => array(),
        'b'         => array(),
        'sub'       => array(),
        'sup'       => array(),
    );
    
    if(  is_page() || is_page_template( 'template-builder.php' )  ) {
        if( $mediax_page_breadcrumb_area == '1' ) {
            echo '<!-- Page title 2 -->';
            
            if( class_exists( 'ReduxFramework' ) ){
                $ex_class = '';
            }else{
                $ex_class = ' th-breadcumb';   
            }
            echo '<div class="breadcumb-wrapper '. esc_attr($ex_class).'" id="breadcumbwrap">';
                echo '<div class="container">';
                    echo '<div class="breadcumb-content">';
                        if( defined('CMB2_LOADED') || class_exists('ReduxFramework') ) {
                            if( !empty( mediax_meta('page_breadcrumb_settings') ) ) {
                                if( mediax_meta('page_breadcrumb_settings') == 'page' ) {
                                    $mediax_page_title_switcher = mediax_meta('page_title');
                                } else {
                                    $mediax_page_title_switcher = mediax_opt('mediax_page_title_switcher');
                                }
                            } else {
                                $mediax_page_title_switcher = '1';
                            }
                        } else {
                            $mediax_page_title_switcher = '1';
                        }

                        if( $mediax_page_title_switcher ){
                            if( class_exists( 'ReduxFramework' ) ){
                                $mediax_page_title_tag    = mediax_opt('mediax_page_title_tag');
                            }else{
                                $mediax_page_title_tag    = 'h1';
                            }

                            if( defined( 'CMB2_LOADED' )  ){
                                if( !empty( mediax_meta('page_title_settings') ) ) {
                                    $mediax_custom_title = mediax_meta('page_title_settings');
                                } else {
                                    $mediax_custom_title = 'default';
                                }
                            }else{
                                $mediax_custom_title = 'default';
                            }

                            if( $mediax_custom_title == 'default' ) {
                                echo mediax_heading_tag(
                                    array(
                                        "tag"   => esc_attr( $mediax_page_title_tag ),
                                        "text"  => esc_html( get_the_title( ) ),
                                        'class' => 'breadcumb-title'
                                    )
                                );
                            } else {
                                echo mediax_heading_tag(
                                    array(
                                        "tag"   => esc_attr( $mediax_page_title_tag ),
                                        "text"  => esc_html( mediax_meta('custom_page_title') ),
                                        'class' => 'breadcumb-title'
                                    )
                                );
                            }

                        }
                        if( defined('CMB2_LOADED') || class_exists('ReduxFramework') ) {

                            if( mediax_meta('page_breadcrumb_settings') == 'page' ) {
                                $mediax_breadcrumb_switcher = mediax_meta('page_breadcrumb_trigger');
                            } else {
                                $mediax_breadcrumb_switcher = mediax_opt('mediax_enable_breadcrumb');
                            }

                        } else {
                            $mediax_breadcrumb_switcher = '1';
                        }

                        if( $mediax_breadcrumb_switcher == '1' && (  is_page() || is_page_template( 'template-builder.php' ) )) {
                                mediax_breadcrumbs(
                                    array(
                                        'breadcrumbs_classes' => '',
                                    )
                                );
                        }
                    echo '</div>';
                echo '</div>';

            echo '</div>';
            echo '<!-- End of Page title -->';
            
        }
    } else {
        echo '<!-- Page title 3 -->';
         if( class_exists( 'ReduxFramework' ) ){
            $ex_class = '';
            if (class_exists( 'woocommerce' ) && is_shop()){
            $breadcumb_bg_class = 'custom-woo-class';
            }elseif(is_404()){
                $breadcumb_bg_class = 'custom-error-class';
            }elseif(is_search()){
                $breadcumb_bg_class = 'custom-search-class';
            }elseif(is_archive()){
                $breadcumb_bg_class = 'custom-archive-class';
            }else{
                $breadcumb_bg_class = '';
            }
        }else{
            $breadcumb_bg_class = ''; 
            $ex_class = ' th-breadcumb';     
        }
        echo '<div class="breadcumb-wrapper '. esc_attr($breadcumb_bg_class . $ex_class).'">'; 
            echo '<div class="container z-index-common">';
                    echo '<div class="breadcumb-content">';
                        if( class_exists( 'ReduxFramework' )  ){
                            $mediax_page_title_switcher  = mediax_opt('mediax_page_title_switcher');
                        }else{
                            $mediax_page_title_switcher = '1';
                        }

                        if( $mediax_page_title_switcher ){
                            if( class_exists( 'ReduxFramework' ) ){
                                $mediax_page_title_tag    = mediax_opt('mediax_page_title_tag');
                            }else{
                                $mediax_page_title_tag    = 'h1';
                            }
                            if( class_exists('woocommerce') && is_shop() ) {
                                echo mediax_heading_tag(
                                    array(
                                        "tag"   => esc_attr( $mediax_page_title_tag ),
                                        "text"  => wp_kses( woocommerce_page_title( false ), $allowhtml ),
                                        'class' => 'breadcumb-title'
                                    )
                                );
                            }elseif ( is_archive() ){
                                echo mediax_heading_tag(
                                    array(
                                        "tag"   => esc_attr( $mediax_page_title_tag ),
                                        "text"  => wp_kses( get_the_archive_title(), $allowhtml ),
                                        'class' => 'breadcumb-title'
                                    )
                                );
                            }elseif ( is_home() ){
                                $mediax_blog_page_title_setting = mediax_opt('mediax_blog_page_title_setting');
                                $mediax_blog_page_title_switcher = mediax_opt('mediax_blog_page_title_switcher');
                                $mediax_blog_page_custom_title = mediax_opt('mediax_blog_page_custom_title');
                                if( class_exists('ReduxFramework') ){
                                    if( $mediax_blog_page_title_switcher ){
                                        echo mediax_heading_tag(
                                            array(
                                                "tag"   => esc_attr( $mediax_page_title_tag ),
                                                "text"  => !empty( $mediax_blog_page_custom_title ) && $mediax_blog_page_title_setting == 'custom' ? esc_html( $mediax_blog_page_custom_title) : esc_html__( 'Latest News', 'mediax' ),
                                                'class' => 'breadcumb-title'
                                            )
                                        );
                                    }
                                }else{
                                    echo mediax_heading_tag(
                                        array(
                                            "tag"   => "h1",
                                            "text"  => esc_html__( 'Latest News', 'mediax' ),
                                            'class' => 'breadcumb-title',
                                        )
                                    );
                                }
                            }elseif( is_search() ){
                                echo mediax_heading_tag(
                                    array(
                                        "tag"   => esc_attr( $mediax_page_title_tag ),
                                        "text"  => esc_html__( 'Search Result', 'mediax' ),
                                        'class' => 'breadcumb-title'
                                    )
                                );
                            }elseif( is_404() ){
                                echo mediax_heading_tag(
                                    array(
                                        "tag"   => esc_attr( $mediax_page_title_tag ),
                                        "text"  => esc_html__( 'Error Page', 'mediax' ),
                                        'class' => 'breadcumb-title'
                                    )
                                );
                            }elseif( is_singular( 'product' ) ){
                                $posttitle_position  = mediax_opt('mediax_product_details_title_position');
                                $postTitlePos = false;
                                if( class_exists( 'ReduxFramework' ) ){
                                    if( $posttitle_position && $posttitle_position != 'header' ){
                                        $postTitlePos = true;
                                    }
                                }else{
                                    $postTitlePos = false;
                                }

                                if( $postTitlePos != true ){
                                    echo mediax_heading_tag(
                                        array(
                                            "tag"   => esc_attr( $mediax_page_title_tag ),
                                            "text"  => wp_kses( get_the_title( ), $allowhtml ),
                                            'class' => 'breadcumb-title'
                                        )
                                    );
                                } else {
                                    if( class_exists( 'ReduxFramework' ) ){
                                        $mediax_post_details_custom_title  = mediax_opt('mediax_product_details_custom_title');
                                    }else{
                                        $mediax_post_details_custom_title = __( 'Shop Details','mediax' );
                                    }

                                    if( !empty( $mediax_post_details_custom_title ) ) {
                                        echo mediax_heading_tag(
                                            array(
                                                "tag"   => esc_attr( $mediax_page_title_tag ),
                                                "text"  => wp_kses( $mediax_post_details_custom_title, $allowhtml ),
                                                'class' => 'breadcumb-title'
                                            )
                                        );
                                    }
                                }
                            }else{
                                $posttitle_position  = mediax_opt('mediax_post_details_title_position');
                                $postTitlePos = false;
                                if( is_single() ){
                                    if( class_exists( 'ReduxFramework' ) ){
                                        if( $posttitle_position && $posttitle_position != 'header' ){
                                            $postTitlePos = true;
                                        }
                                    }else{
                                        $postTitlePos = false;
                                    }
                                }
                                if( is_singular( 'product' ) ){
                                    $posttitle_position  = mediax_opt('mediax_product_details_title_position');
                                    $postTitlePos = false;
                                    if( class_exists( 'ReduxFramework' ) ){
                                        if( $posttitle_position && $posttitle_position != 'header' ){
                                            $postTitlePos = true;
                                        }
                                    }else{
                                        $postTitlePos = false;
                                    }
                                }

                                if( $postTitlePos != true ){
                                    echo mediax_heading_tag(
                                        array(
                                            "tag"   => esc_attr( $mediax_page_title_tag ),
                                            "text"  => wp_kses( get_the_title( ), $allowhtml ),
                                            'class' => 'breadcumb-title'
                                        )
                                    );
                                } else {
                                    if( class_exists( 'ReduxFramework' ) ){
                                        $mediax_post_details_custom_title  = mediax_opt('mediax_post_details_custom_title');
                                    }else{
                                        $mediax_post_details_custom_title = __( 'Blog Details','mediax' );
                                    }

                                    if( !empty( $mediax_post_details_custom_title ) ) {
                                        echo mediax_heading_tag(
                                            array(
                                                "tag"   => esc_attr( $mediax_page_title_tag ),
                                                "text"  => wp_kses( $mediax_post_details_custom_title, $allowhtml ),
                                                'class' => 'breadcumb-title'
                                            )
                                        );
                                    }
                                }
                            }
                        }
                        if( class_exists('ReduxFramework') ) {
                            $mediax_breadcrumb_switcher = mediax_opt( 'mediax_enable_breadcrumb' );
                        } else {
                            $mediax_breadcrumb_switcher = '1';
                        }
                        if( $mediax_breadcrumb_switcher == '1' ) {
                            if(mediax_breadcrumbs()){
                            echo '<div>';
                                mediax_breadcrumbs(
                                    array(
                                        'breadcrumbs_classes' => 'nav',
                                    )
                                );
                            echo '</div>';
                            }
                        }
                    echo '</div>';
            echo '</div>';

        echo '</div>';
        echo '<!-- End of Page title -->';
    }