<?php
// Block direct access
if( !defined( 'ABSPATH' ) ){
    exit();
}
/**
 * @Packge     : Mediax
 * @Version    : 1.0
 * @Author     : Themeholy
 * @Author URI : https://themeforest.net/user/themeholy
 *
 */

// enqueue css
function mediax_common_custom_css(){
	wp_enqueue_style( 'mediax-color-schemes', get_template_directory_uri().'/assets/css/color.schemes.css' );

    $CustomCssOpt  = mediax_opt( 'mediax_css_editor' );
	if( $CustomCssOpt ){
		$CustomCssOpt = $CustomCssOpt;
	}else{
		$CustomCssOpt = '';
	}

    $customcss = "";
    
    if( get_header_image() ){
        $mediax_header_bg =  get_header_image();
    }else{
        if( mediax_meta( 'page_breadcrumb_settings' ) == 'page' ){
            if( ! empty( mediax_meta( 'breadcumb_image' ) ) ){
                $mediax_header_bg = mediax_meta( 'breadcumb_image' );
            }
        }
    }
    
    if( !empty( $mediax_header_bg ) ){
        $customcss .= ".breadcumb-wrapper{
            background-image:url('{$mediax_header_bg}')!important;
        }";
    }
    
	// Theme color
	$mediaxthemecolor = mediax_opt('mediax_theme_color'); 
    if( !empty( $mediaxthemecolor ) ){
        list($r, $g, $b) = sscanf( $mediaxthemecolor, "#%02x%02x%02x");

        $mediax_real_color = $r.','.$g.','.$b;
        if( !empty( $mediaxthemecolor ) ) {
            $customcss .= ":root {
            --theme-color: rgb({$mediax_real_color});
            }";
        }
    }
    // Theme color 2
	$mediaxthemecolor2 = mediax_opt('mediax_theme_color2'); 
    if( !empty( $mediaxthemecolor2 ) ){
        list($r, $g, $b) = sscanf( $mediaxthemecolor2, "#%02x%02x%02x");

        $mediax_real_color = $r.','.$g.','.$b;
        if( !empty( $mediaxthemecolor2 ) ) {
            $customcss .= ":root {
            --theme-color2: rgb({$mediax_real_color});
            }";
        }
    }
    // Heading  color
	$mediaxheadingcolor = mediax_opt('mediax_heading_color');
    if( !empty( $mediaxheadingcolor ) ){
        list($r, $g, $b) = sscanf( $mediaxheadingcolor, "#%02x%02x%02x");

        $mediax_real_color = $r.','.$g.','.$b;
        if( !empty( $mediaxheadingcolor ) ) {
            $customcss .= ":root {
                --title-color: rgb({$mediax_real_color});
            }";
        }
    }
    // Body color
	$mediaxbodycolor = mediax_opt('mediax_body_color');
    if( !empty( $mediaxbodycolor ) ){
        list($r, $g, $b) = sscanf( $mediaxbodycolor, "#%02x%02x%02x");

        $mediax_real_color = $r.','.$g.','.$b;
        if( !empty( $mediaxbodycolor ) ) {
            $customcss .= ":root {
                --body-color: rgb({$mediax_real_color});
            }";
        }
    }

     // Body font
     $mediaxbodyfont = mediax_opt('mediax_theme_body_font', 'font-family');
     if( !empty( $mediaxbodyfont ) ) {
         $customcss .= ":root {
             --body-font: $mediaxbodyfont ;
         }";
     }
 
     // Heading font
     $mediaxheadingfont = mediax_opt('mediax_theme_heading_font', 'font-family');
     if( !empty( $mediaxheadingfont ) ) {
         $customcss .= ":root {
             --title-font: $mediaxheadingfont ;
         }";
     }


    if(mediax_opt('mediax_menu_icon_class')){
        $menu_icon_class = mediax_opt( 'mediax_menu_icon_class' );
    }else{
        $menu_icon_class = 'f469';
    }

    if( !empty( $menu_icon_class ) ) {
        $customcss .= ":root {
            .main-menu ul.sub-menu li a:before {
                content: \"\\$menu_icon_class\";
            }
        }";
    }

	if( !empty( $CustomCssOpt ) ){
		$customcss .= $CustomCssOpt;
	}

    wp_add_inline_style( 'mediax-color-schemes', $customcss );
}
add_action( 'wp_enqueue_scripts', 'mediax_common_custom_css', 100 );