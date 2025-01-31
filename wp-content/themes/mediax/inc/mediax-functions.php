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
    exit;
}

 // theme option callback
function mediax_opt( $id = null, $url = null ){
    global $mediax_opt;

    if( $id && $url ){

        if( isset( $mediax_opt[$id][$url] ) && $mediax_opt[$id][$url] ){
            return $mediax_opt[$id][$url];
        }
    }else{
        if( isset( $mediax_opt[$id] )  && $mediax_opt[$id] ){
            return $mediax_opt[$id];
        }
    }
}


// theme logo
function mediax_theme_logo() {
    // escaping allow html
    $allowhtml = array(
        'a'    => array(
            'href' => array()
        ),
        'span' => array(),
        'i'    => array(
            'class' => array()
        )
    );
    $siteUrl = home_url('/');
    if( has_custom_logo() ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $siteLogo = '';
        $siteLogo .= '<a class="logo" href="'.esc_url( $siteUrl ).'">';
        $siteLogo .= mediax_img_tag( array(
            "class" => "img-fluid",
            "url"   => esc_url( wp_get_attachment_image_url( $custom_logo_id, 'full') )
        ) );
        $siteLogo .= '</a>';

        return $siteLogo;
    } elseif( !mediax_opt('mediax_text_title') && mediax_opt('mediax_site_logo', 'url' )  ){

        $siteLogo = '<img class="img-fluid" src="'.esc_url( mediax_opt('mediax_site_logo', 'url' ) ).'" alt="'.esc_attr__( 'logo', 'mediax' ).'" />';
        return '<a class="logo" href="'.esc_url( $siteUrl ).'">'.$siteLogo.'</a>';


    }elseif( mediax_opt('mediax_text_title') ){
        return '<h2 class="mb-0"><a class="logo" href="'.esc_url( $siteUrl ).'">'.wp_kses( mediax_opt('mediax_text_title'), $allowhtml ).'</a></h2>';
    }else{
        return '<h2 class="mb-0"><a class="logo" href="'.esc_url( $siteUrl ).'">'.esc_html( get_bloginfo('name') ).'</a></h2>';
    }
}

// custom meta id callback
function mediax_meta( $id = '' ){
    $value = get_post_meta( get_the_ID(), '_mediax_'.$id, true );
    return $value;
}


// Blog Date Permalink
function mediax_blog_date_permalink() {
    $year  = get_the_time('Y');
    $month_link = get_the_time('m');
    $day   = get_the_time('d');
    $link = get_day_link( $year, $month_link, $day);
    return $link;
}

//audio format iframe match
function mediax_iframe_match() {
    $audio_content = mediax_embedded_media( array('audio', 'iframe') );
    $iframe_match = preg_match("/\iframe\b/i",$audio_content, $match);
    return $iframe_match;
}


//Post embedded media
function mediax_embedded_media( $type = array() ){
    $content = do_shortcode( apply_filters( 'the_content', get_the_content() ) );
    $embed   = get_media_embedded_in_content( $content, $type );


    if( in_array( 'audio' , $type) ){
        if( count( $embed ) > 0 ){
            $output = str_replace( '?visual=true', '?visual=false', $embed[0] );
        }else{
           $output = '';
        }

    }else{
        if( count( $embed ) > 0 ){
            $output = $embed[0];
        }else{
           $output = '';
        }
    }
    return $output;
}


// WP post link pages
function mediax_link_pages(){
    wp_link_pages( array(
        'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'mediax' ) . '</span>',
        'after'       => '</div>',
        'link_before' => '<span>',
        'link_after'  => '</span>',
        'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'mediax' ) . ' </span>%',
        'separator'   => '<span class="screen-reader-text">, </span>',
    ) );
}


// Data Background image attr
function mediax_data_bg_attr( $imgUrl = '' ){
    return 'data-bg-img="'.esc_url( $imgUrl ).'"';
}

// image alt tag
function mediax_image_alt( $url = '' ){
    if( $url != '' ){
        // attachment id by url
        $attachmentid = attachment_url_to_postid( esc_url( $url ) );
       // attachment alt tag
        $image_alt = get_post_meta( esc_html( $attachmentid ) , '_wp_attachment_image_alt', true );
        if( $image_alt ){
            return $image_alt ;
        }else{
            $filename = pathinfo( esc_url( $url ) );
            $alt = str_replace( '-', ' ', $filename['filename'] );
            return $alt;
        }
    }else{
       return;
    }
}


// Flat Content wysiwyg output with meta key and post id

function mediax_get_textareahtml_output( $content ) {
    global $wp_embed;

    $content = $wp_embed->autoembed( $content );
    $content = $wp_embed->run_shortcode( $content );
    $content = wpautop( $content );
    $content = do_shortcode( $content );

    return $content;
}

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */

function mediax_pingback_header() {
    if ( is_singular() && pings_open() ) {
        echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
    }
}
add_action( 'wp_head', 'mediax_pingback_header' );


// Excerpt More
function mediax_excerpt_more( $more ) {
    return '...';
}

add_filter( 'excerpt_more', 'mediax_excerpt_more' );


// mediax comment template callback
function mediax_comment_callback( $comment, $args, $depth ) {
        $add_below = 'comment';
    ?>
    <li <?php comment_class( array('th-comment-item') ); ?>>
        <div id="comment-<?php comment_ID() ?>" class="th-post-comment">
            <?php
                if( get_avatar( $comment, 100 )  ) :
            ?>
            <!-- Author Image -->
            <div class="comment-avater">
                <?php
                    if ( $args['avatar_size'] != 0 ) {
                        echo get_avatar( $comment, 110 );
                    }
                ?>
            </div>
            <!-- Author Image -->
            <?php endif; ?>
            <!-- Comment Content -->
            <div class="comment-content">
                <div class="">
                    <h3 class="name"><?php echo esc_html( ucwords( get_comment_author() ) ); ?></h3>
                    <span class="commented-on"><i class="fal fa-calendar-alt"></i><?php printf( esc_html__('%1$s', 'mediax'), get_comment_date() ); ?></span>
                </div>
                <p class="text"><?php echo get_comment_text(); ?></p>
                <div class="reply_and_edit">
                    <?php
                        $reply_text = wp_kses_post( '<i class="fas fa-reply"></i> Reply', 'mediax' );

                        $edit_reply_text = wp_kses_post( '<i class="fas fa-pencil-alt"></i> Edit', 'mediax' );

                        comment_reply_link(array_merge( $args, array( 'add_below' => $add_below, 'depth' => 3, 'max_depth' => 5, 'reply_text' => $reply_text ) ) );
                    ?>  
                </div>
                <?php if ( $comment->comment_approved == '0' ) : ?>
                <p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'mediax' ); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <!-- Comment Content -->
<?php
}

//body class
add_filter( 'body_class', 'mediax_body_class' );
function mediax_body_class( $classes ) {
    if( class_exists('ReduxFramework') ) {
        $mediax_blog_single_sidebar = mediax_opt('mediax_blog_single_sidebar');
        if( ($mediax_blog_single_sidebar != '2' && $mediax_blog_single_sidebar != '3' ) || ! is_active_sidebar('mediax-blog-sidebar') ) {
            $classes[] = 'no-sidebar';
        }
        $new_class = is_page() ? mediax_meta('custom_body_class') : null;

        if ( $new_class ) {
            $classes[] = $new_class;
        }
    } else {
        if( !is_active_sidebar('mediax-blog-sidebar') ) {
            $classes[] = 'no-sidebar';
        }
    }
    $classes[] = 'dark-theme';
    return $classes;
}

//Global Footer
function mediax_footer_global_option(){
    // Mediax Widget Enable Disable
    if( class_exists( 'ReduxFramework' ) ){
        $mediax_footer_newsletter_enable = mediax_opt( 'mediax_footer_newsletter_enable' );
        $mediax_footer_widget_enable = mediax_opt( 'mediax_footerwidget_enable' );
        $mediax_footer_bottom_active = mediax_opt( 'mediax_disable_footer_bottom' );
    }else{
        $mediax_footer_newsletter_enable = '';
        $mediax_footer_widget_enable = '';
        $mediax_footer_bottom_active = '1';
    }

    if( $mediax_footer_widget_enable == '1' || $mediax_footer_bottom_active == '1' ){
        $bg = mediax_opt('mediax_footer_background', 'background-image' );
        $footer_bg = $bg ? $bg : '#';
        
        echo '<!---footer-wrapper start-->';
        echo '<footer class="footer-wrapper footer-layout1 prebuilt-foo" data-bg-src="'.esc_url(  $footer_bg ).'">';
            if( $mediax_footer_newsletter_enable == '1' ){
                echo '<div class="container z-index-common">';
                    echo '<div class="newsletter-wrap">';
                        if(!empty(mediax_opt( 'mediax_newsletter_text' ))){
                            echo ' <div class="newsletter-content">';
                                echo '<h2 class="sec-title">'.esc_html( mediax_opt( 'mediax_newsletter_text' ) ).'</h2>';
                            echo '</div>';
                        }
                        if(!empty(mediax_opt( 'mediax_newsletter_button' ))){
                        echo '<form class="newsletter-form">';
                            echo '<div class="form-group">';
                                echo '<input class="form-control" type="email" placeholder="'.esc_html( mediax_opt( 'mediax_newsletter_placeholder' ) ).'" required="">';
                            echo '</div>';
                            echo '<button type="submit" class="th-btn shadow-1">'.wp_kses_post( mediax_opt( 'mediax_newsletter_button' ) ).'</button>';
                        echo '</form>';
                        }
                    echo '</div>';
                echo '</div>';
            }
            if( $mediax_footer_widget_enable == '1' ){
                if( ( is_active_sidebar( 'mediax-footer-1' ) || is_active_sidebar( 'mediax-footer-2' ) || is_active_sidebar( 'mediax-footer-3' ) || is_active_sidebar( 'mediax-footer-4' ) )) {
                    echo '<div class="widget-area">';
                        echo '<div class="container">';
                                echo '<div class="row justify-content-between">';
                                    if( is_active_sidebar( 'mediax-footer-1' )){
                                    dynamic_sidebar( 'mediax-footer-1' ); 
                                    }
                                    if( is_active_sidebar( 'mediax-footer-2' )){
                                    dynamic_sidebar( 'mediax-footer-2' ); 
                                    }
                                    if( is_active_sidebar( 'mediax-footer-3' )){
                                    dynamic_sidebar( 'mediax-footer-3' ); 
                                    } 
                                    if( is_active_sidebar( 'mediax-footer-4' )){
                                    dynamic_sidebar( 'mediax-footer-4' ); 
                                    }  
                                echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
            }

            if( $mediax_footer_bottom_active == '1' ){
                echo '<div class="copyright-wrap">';
                    echo '<div class="container">';
                        echo '<div class="row gy-2 align-items-center">';
                            if( !empty( mediax_social_icon()) ){
                               $class = 'col-md-7';
                               $center = '';
                            }else{
                                $class = 'col-md-12';
                                $center = 'text-center';
                            }
                            echo '<div class="'.esc_attr( $class ).'">';
                                echo '<p class="copyright-text '.esc_attr( $center ).'">'.wp_kses_post( mediax_opt( 'mediax_copyright_text' ) ).'</p>';
                            echo '</div>';

                            if( !empty( mediax_social_icon()) ){
                                echo '<div class="col-md-5 text-center text-md-end">';
                                    echo '<div class="th-social">';
                                        echo mediax_social_icon();
                                    echo '</div>';
                                echo '</div>';
                            }
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }

        echo '</footer>';
        echo '<!---footer-wrapper end-->';
    }
}

// Social link
function mediax_social_icon(){
    $mediax_social_icon = mediax_opt( 'mediax_social_links' );
    if( ! empty( $mediax_social_icon ) && isset( $mediax_social_icon ) ){
        $social_item = '';
        foreach( $mediax_social_icon as $social_icon ){
            // if( !empty($social_icon['title']) || $social_icon['description'] ){
                $social_item .= '<a href="'.esc_url( $social_icon['url'] ).'"><i class="'.esc_attr( $social_icon['title'] ).'"></i>'.esc_attr( $social_icon['description'] ).'</a>';
            // }
        }
        return $social_item;
    }
}


// global header
function mediax_global_header_option() {

    if( class_exists( 'ReduxFramework' ) ){ 
        echo '<header class="th-header header-layout1 prebuilt">';
            echo mediax_header_offcanvas();
            echo mediax_header_cart_offcanvas();
            echo mediax_mobile_menu();
            echo mediax_search_box();

            if(mediax_opt('mediax_header_sticky')){
                $sticky = '';
            }else{
                $sticky = '-no';
            }
            
            if(mediax_opt('mediax_menu_icon')){
				$menu_icon = '';
			}else{
				$menu_icon = 'hide-icon';
			}

            echo mediax_header_menu_topbar();

            echo '<div class="sticky-wrapper'.esc_attr($sticky).'">';
                echo '<!-- Main Menu Area -->';
                echo '<div class="menu-area">';
                    echo '<div class="container">';
                       echo ' <div class="row align-items-center justify-content-between">';
                            echo '<div class="col-auto">';
                                echo '<div class="header-logo">';
                                    if(!empty(mediax_opt('mediax_logo_shape', 'url' ) )){
                                        echo '<div class="logo-bg" data-bg-src="'.esc_url( mediax_opt('mediax_logo_shape', 'url' ) ).'"></div>';
                                    }
                                    echo mediax_theme_logo();
                                echo '</div>';
                            echo '</div>';
                            echo '<div class="col-auto d-none d-lg-inline-block">';
                                echo '<nav class="main-menu d-none d-lg-inline-block '.esc_attr($menu_icon).'">';
                                    wp_nav_menu( array(
                                        "theme_location"    => 'primary-menu',
                                        "container"         => '',
                                        "menu_class"        => ''
                                    ) ); 
                                echo '</nav>';
                            echo '</div>';
                            echo '<div class="col-auto">';
                                echo '<div class="header-button">';
                                    if(!empty(mediax_opt( 'mediax_header_search_switcher' )) ){
                                        echo '<button type="button" class="icon-btn searchBoxToggler d-none d-xl-inline-block"><i class="far fa-search"></i></button>';
                                    }
                                    if(!empty(mediax_opt( 'mediax_header_cart_switcher' )) ){
                                        if( class_exists( 'woocommerce' ) ){
                                            global $woocommerce;
                                            if( ! empty( $woocommerce->cart->cart_contents_count ) ){
                                                $count = $woocommerce->cart->cart_contents_count;
                                            }else{
                                                $count = "0";
                                            }
                                            echo '<button type="button" class="icon-btn sideMenuCart">';
                                                echo '<span class="badge cart_badge">'.esc_html( $count ).'</span>';
                                                echo '<i class="far fa-cart-shopping"></i>';
                                            echo '</button>'; 
                                        }
                                    }
                                    if( !empty(mediax_opt( 'mediax_btn_text' ) ) ){
                                        echo '<a href="'.esc_url(mediax_opt( 'mediax_btn_url' )).'" class="th-btn th_btn">'.wp_kses_post(mediax_opt( 'mediax_btn_text' )).'</a>';
                                    }
                                    if(!empty(mediax_opt( 'mediax_offcanvaas_switcher' )) ){
                                        echo '<button type="button" class="icon-btn sideMenuInfo d-none d-xl-inline-block"><i class="far fa-bars"></i></button>';
                                    }
                                    echo '<button type="button" class="th-menu-toggle d-block d-lg-none"><i class="far fa-bars"></i></button>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';

        echo '</header>';
    }else{
        echo mediax_global_header();
    }
}

if( ! function_exists( 'mediax_header_menu_topbar' ) ){
    function mediax_header_menu_topbar(){
        if( class_exists( 'ReduxFramework' ) ){
            $mediax_header_topbar_switcher  = mediax_opt( 'mediax_header_topbar_switcher' );
            $mediax_show_social_switcher      = mediax_opt( 'mediax_header_social_switcher' );
            $mediax_header_lang_switcher      = mediax_opt( 'mediax_header_lang_switcher' );
        }else{
            $mediax_header_topbar_switcher  = '';
            $mediax_show_social_switcher    = '';
            $mediax_header_lang_switcher    = '';
        }

        if( $mediax_header_topbar_switcher ){

            $phone     = mediax_opt( 'mediax_topbar_phone' );
            $email     = mediax_opt( 'mediax_topbar_email' );
            $office     = mediax_opt( 'mediax_topbar_office' );
            $phone_icon = !empty(mediax_opt( 'mediax_topbar_phone_icon' )) ? mediax_opt( 'mediax_topbar_phone_icon' ): '';
            $email_icon = !empty(mediax_opt( 'mediax_topbar_email_icon' )) ? mediax_opt( 'mediax_topbar_email_icon' ): '';
            $office_icon = !empty(mediax_opt( 'mediax_topbar_office_icon' )) ? mediax_opt( 'mediax_topbar_office_icon' ): '';

            $replace        = array(' ','-',' - ');
            $replace_phone  = array(' ','-',' - ', '(', ')');
            $with           = array('','','');
    
            $phoneurl       = str_replace( $replace_phone, $with, $phone );
            $emailurl       = str_replace( $replace, $with, $email );

            echo '<div class="header-top">';
                echo '<div class="container">';
                    echo '<div class="row justify-content-center justify-content-lg-between align-items-center gy-2">';
                        echo '<div class="col-auto d-none d-lg-block">';
                            echo '<div class="header-links">';
                                echo '<ul>';
                                    if( !empty( $phone ) ){
                                        echo '<li class="d-none d-sm-inline-block">'.wp_kses_post( $phone_icon ).'<a href="'.esc_attr('tel:' . $phoneurl).'">'. esc_html( $phone ) .'</a></li>';
                                    }
                                    if( !empty( $email ) ){
                                        echo '<li class="d-none d-sm-inline-block">'.wp_kses_post( $email_icon ).'<a href="'.esc_attr('mailto:' . $emailurl).'">'. esc_html( $email ) .'</a></li>';
                                    }
                                    if( !empty( $office ) ){
                                        echo '<li class="d-none d-xxl-inline-block">'. wp_kses_post( $office_icon . $office ) .'</li>';
                                    }
                                echo '</ul>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-auto">';
                            echo '<div class="header-links">';
                                echo '<ul>';
                                    if(!empty($mediax_header_lang_switcher) ){
                                        echo '<li class="d-none d-md-inline-block">';
                                            echo '<div class="dropdown-link">';
                                                echo '<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-light fa-globe"></i> '.esc_html__('Language', 'mediax').'</a>';
                                                echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">';
                                                    echo '<li>';
                                                        echo do_shortcode('[gtranslate]');
                                                    echo '</li>';
                                                echo '</ul>';
                                            echo '</div>';
                                        echo '</li>';
                                    }
                                    if(!empty($mediax_show_social_switcher) ){
                                        echo '<li>';
                                            echo '<div class="social-links">';
                                                if(!empty(mediax_opt( 'mediax_header_social_text' ))){
                                                    echo '<span class="social-title">'.esc_html(mediax_opt( 'mediax_header_social_text' )).'</span>';
                                                }
                                                echo mediax_social_icon();
                                            echo '</div>';
                                        echo '</li>';
                                    }
                                echo '</ul>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';

        }
    }
}

// mediax woocommerce breadcrumb
function mediax_woo_breadcrumb( $args ) {
    return array(
        'delimiter'   => '',
        'wrap_before' => '<ul class="breadcumb-menu">',
        'wrap_after'  => '</ul>',
        'before'      => '<li>',
        'after'       => '</li>',
        'home'        => _x( 'Home', 'breadcrumb', 'mediax' ),
    );
}

add_filter( 'woocommerce_breadcrumb_defaults', 'mediax_woo_breadcrumb' );

function mediax_custom_search_form( $class ) {
    echo '<!-- Search Form -->';

    echo '<form role="search" method="get" action="'.esc_url( home_url( '/' ) ).'" class="'.esc_attr( $class ).'">';
        echo '<label class="searchIcon">';
            echo mediax_img_tag( array(
                "url"   => esc_url( get_theme_file_uri( '/assets/img/search-2.svg' ) ),
                "class" => "svg"
            ) );
            echo '<input value="'.esc_html( get_search_query() ).'" name="s" required type="search" placeholder="'.esc_attr__('What are you looking for?', 'mediax').'">';
        echo '</label>';
    echo '</form>';
    echo '<!-- End Search Form -->';
}



//Fire the wp_body_open action.
if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}

//Remove Tag-Clouds inline style
add_filter( 'wp_generate_tag_cloud', 'mediax_remove_tagcloud_inline_style',10,1 );
function mediax_remove_tagcloud_inline_style( $input ){
   return preg_replace('/ style=("|\')(.*?)("|\')/','',$input );
}

/* This code filters the Categories archive widget to include the post count inside the link */
add_filter( 'wp_list_categories', 'mediax_cat_count_span' );
function mediax_cat_count_span( $links ) {
    $links = str_replace('</a> (', '</a> <span class="category-number">', $links);
    $links = str_replace(')', '</span>', $links);
    return $links;
}

/* This code filters the Archive widget to include the post count inside the link */
add_filter( 'get_archives_link', 'mediax_archive_count_span' );
function mediax_archive_count_span( $links ) {
    $links = str_replace('</a>&nbsp;(', '</a> <span class="category-number">', $links);
    $links = str_replace(')', '</span>', $links);
    return $links;
}

//header search box
if(! function_exists('mediax_search_box')){
    function mediax_search_box(){
        echo '<div class="popup-search-box d-none d-lg-block">';
            echo '<button class="searchClose"><i class="fal fa-times"></i></button>';
            echo '<form role="search" method="get" action="'.esc_url( home_url( '/' ) ).'">';
                echo '<input value="'.esc_html( get_search_query() ).'" name="s" required type="search" placeholder="'.esc_attr__('What are you looking for?', 'mediax').'">';
                echo '<button type="submit"><i class="fal fa-search"></i></button>';
            echo '</form>';
        echo '</div>';
    }
}


// Mediax Default Header
if( ! function_exists( 'mediax_global_header' ) ){
    function mediax_global_header(){ ?>

        <!--Mobile menu & Search box-->
        <?php 
        echo mediax_search_box(); 
        echo mediax_mobile_menu(); 
        
        ?>

        <!--======== Header ========-->
        <header class="th-header header-layout1 unittest-header">
            <div class="sticky-wrapper">
                <div class="sticky-active">
                    <div class="menu-area">
                        <div class="container">
                            <div class="row gx-20 align-items-center justify-content-between">

                                <div class="col-auto">
                                    <div class="header-logo">
                                        <div class="logo-bg"></div>
                                        <?php echo mediax_theme_logo(); ?>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <?php
                                    if( has_nav_menu( 'primary-menu' ) ) { ?>
                                        <nav class="main-menu d-none d-lg-inline-block">
                                            <?php
                                            wp_nav_menu( array(
                                                "theme_location"    => 'primary-menu',
                                                "container"         => '',
                                                "menu_class"        => ''
                                            ) ); ?>
                                        </nav>
                                    <?php } ?>                                   
                                    </nav>
                                    <button type="button" class="th-menu-toggle d-inline-block d-lg-none"><i class="far fa-bars"></i></button>
                                </div>
                                <div class="col-auto d-none d-xl-block">
                                    <div class="header-button">
                                        <button type="button" class="icon-btn searchBoxToggler"><i class="far fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    <?php
    }
}


//header Offcanvas
if( ! function_exists( 'mediax_header_offcanvas' ) ){
    function mediax_header_offcanvas(){
    ?>
    <div class="sidemenu-wrapper sidemenu-info">
        <div class="sidemenu-content">
            <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
            <?php 
                if(is_active_sidebar('mediax-offcanvas')){
                    dynamic_sidebar( 'mediax-offcanvas' );
                }else{
                    echo '<h4 class="widget_title">No Widget Added </h4>';
                    echo '<p>Please add some widget in Offcanvs Sidebar</p>';
                }
            ?>
        </div>
    </div>
    
<?php
    }
}

//header Cart Offcanvas
if( ! function_exists( 'mediax_header_cart_offcanvas' ) ){
    function mediax_header_cart_offcanvas(){
        ?>
        <div class="sidemenu-wrapper sidemenu-cart">
            <div class="sidemenu-content">
                <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
                <div class="widget woocommerce widget_shopping_cart">
                    <h3 class="widget_title"><?php echo esc_html__( 'Shopping cart', 'mediax' ); ?></h3>
                    <div class="widget_shopping_cart_content">
                        <?php 
                            if( class_exists( 'woocommerce' ) ){
                                echo woocommerce_mini_cart();
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }
}

// mobile logo
function mediax_mobile_logo() {
    $logo_url = mediax_opt('mediax_mobile_logo', 'url' );
    $mobile_menu = '';
    if( !empty($logo_url )){
        $mobile_menu = '<div class="mobile-logo"><a href="'.home_url('/').'"><img src="'.esc_url($logo_url).'" alt="'.esc_attr__( 'logo', 'mediax' ).'"></a></div>';
    }else{
        $mobile_menu .= '<div class="mobile-logo">';
        $mobile_menu .= mediax_theme_logo();
        $mobile_menu .= '</div>';
    }

    return $mobile_menu;
 }

//header Mobile Menu
if( ! function_exists( 'mediax_mobile_menu' ) ){
    function mediax_mobile_menu(){
    ?>
    <div class="th-menu-wrapper">
        <div class="th-menu-area text-center">
            <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            <?php  if( class_exists('ReduxFramework') ):?>
                <?php 
                    if(!empty(mediax_opt('mediax_menu_menu_show') )){
                        echo mediax_mobile_logo(); 
                    }
                ?>
            <?php else: ?>
                <div class="mobile-logo">
                    <?php echo mediax_theme_logo(); ?>
                </div>
            <?php endif; ?>
            <div class="th-mobile-menu">
                <?php 
                    if( has_nav_menu( 'primary-menu' ) ){
                        wp_nav_menu( array(
                            "theme_location"    => 'primary-menu',
                            "container"         => '',
                            "menu_class"        => ''
                        ) );
                    }
                ?>
            </div>
        </div>
    </div>

<?php
    }
}



// Blog post views function
function mediax_setPostViews( $postID ) {
    $count_key  = 'post_views_count';
    $count      = get_post_meta( $postID, $count_key, true );
    if( $count == '' ){
        $count = 0;
        delete_post_meta( $postID, $count_key );
        add_post_meta( $postID, $count_key, '0' );
    }else{
        $count++;
        update_post_meta( $postID, $count_key, $count );
    }
}

function mediax_getPostViews( $postID ){
    $count_key  = 'post_views_count';
    $count      = get_post_meta( $postID, $count_key, true );
    if( $count == '' ){
        delete_post_meta( $postID, $count_key );
        add_post_meta( $postID, $count_key, '0' );
        return __( '0', 'mediax' );
    }
    return $count;
}


// Add Extra Class On Comment Reply Button
function mediax_custom_comment_reply_link( $content ) {
    $extra_classes = 'reply-btn';
    return preg_replace( '/comment-reply-link/', 'comment-reply-link ' . $extra_classes, $content);
}

add_filter('comment_reply_link', 'mediax_custom_comment_reply_link', 99);

// Add Extra Class On Edit Comment Link
function mediax_custom_edit_comment_link( $content ) {
    $extra_classes = 'reply-btn';
    return preg_replace( '/comment-edit-link/', 'comment-edit-link ' . $extra_classes, $content);
}

add_filter('edit_comment_link', 'mediax_custom_edit_comment_link', 99);


function mediax_post_classes( $classes, $class, $post_id ) {
    if ( get_post_type() === 'post' ) {
        $classes[] = "th-blog blog-single has-post-thumbnail";
    }elseif( get_post_type() === 'product' ){
        // Return Class
    }elseif( get_post_type() === 'page' ){
        $classes[] = "page--item";
    }
    
    return $classes;
}
add_filter( 'post_class', 'mediax_post_classes', 10, 3 );

// Contact form 7
add_filter('wpcf7_autop_or_not', '__return_false');