(function($){
    "use strict";
    
    let $mediax_page_breadcrumb_area      = $("#_mediax_page_breadcrumb_area");
    let $mediax_page_settings             = $("#_mediax_page_breadcrumb_settings");
    let $mediax_page_breadcrumb_image     = $("#_mediax_breadcumb_image");
    let $mediax_page_title                = $("#_mediax_page_title");
    let $mediax_page_title_settings       = $("#_mediax_page_title_settings");

    if( $mediax_page_breadcrumb_area.val() == '1' ) {
        $(".cmb2-id--mediax-page-breadcrumb-settings").show();
        if( $mediax_page_settings.val() == 'global' ) {
            $(".cmb2-id--mediax-breadcumb-image").hide();
            $(".cmb2-id--mediax-page-title").hide();
            $(".cmb2-id--mediax-page-title-settings").hide();
            $(".cmb2-id--mediax-custom-page-title").hide();
            $(".cmb2-id--mediax-page-breadcrumb-trigger").hide();
        } else {
            $(".cmb2-id--mediax-breadcumb-image").show();
            $(".cmb2-id--mediax-page-title").show();
            $(".cmb2-id--mediax-page-breadcrumb-trigger").show();
    
            if( $mediax_page_title.val() == '1' ) {
                $(".cmb2-id--mediax-page-title-settings").show();
                if( $mediax_page_title_settings.val() == 'default' ) {
                    $(".cmb2-id--mediax-custom-page-title").hide();
                } else {
                    $(".cmb2-id--mediax-custom-page-title").show();
                }
            } else {
                $(".cmb2-id--mediax-page-title-settings").hide();
                $(".cmb2-id--mediax-custom-page-title").hide();
    
            }
        }
    } else {
        $mediax_page_breadcrumb_area.parents('.cmb2-id--mediax-page-breadcrumb-area').siblings().hide();
    }


    // breadcrumb area
    $mediax_page_breadcrumb_area.on("change",function(){
        if( $(this).val() == '1' ) {
            $(".cmb2-id--mediax-page-breadcrumb-settings").show();
            if( $mediax_page_settings.val() == 'global' ) {
                $(".cmb2-id--mediax-breadcumb-image").hide();
                $(".cmb2-id--mediax-page-title").hide();
                $(".cmb2-id--mediax-page-title-settings").hide();
                $(".cmb2-id--mediax-custom-page-title").hide();
                $(".cmb2-id--mediax-page-breadcrumb-trigger").hide();
            } else {
                $(".cmb2-id--mediax-breadcumb-image").show();
                $(".cmb2-id--mediax-page-title").show();
                $(".cmb2-id--mediax-page-breadcrumb-trigger").show();
        
                if( $mediax_page_title.val() == '1' ) {
                    $(".cmb2-id--mediax-page-title-settings").show();
                    if( $mediax_page_title_settings.val() == 'default' ) {
                        $(".cmb2-id--mediax-custom-page-title").hide();
                    } else {
                        $(".cmb2-id--mediax-custom-page-title").show();
                    }
                } else {
                    $(".cmb2-id--mediax-page-title-settings").hide();
                    $(".cmb2-id--mediax-custom-page-title").hide();
        
                }
            }
        } else {
            $(this).parents('.cmb2-id--mediax-page-breadcrumb-area').siblings().hide();
        }
    });

    // page title
    $mediax_page_title.on("change",function(){
        if( $(this).val() == '1' ) {
            $(".cmb2-id--mediax-page-title-settings").show();
            if( $mediax_page_title_settings.val() == 'default' ) {
                $(".cmb2-id--mediax-custom-page-title").hide();
            } else {
                $(".cmb2-id--mediax-custom-page-title").show();
            }
        } else {
            $(".cmb2-id--mediax-page-title-settings").hide();
            $(".cmb2-id--mediax-custom-page-title").hide();

        }
    });

    //page settings
    $mediax_page_settings.on("change",function(){
        if( $(this).val() == 'global' ) {
            $(".cmb2-id--mediax-breadcumb-image").hide();
            $(".cmb2-id--mediax-page-title").hide();
            $(".cmb2-id--mediax-page-title-settings").hide();
            $(".cmb2-id--mediax-custom-page-title").hide();
            $(".cmb2-id--mediax-page-breadcrumb-trigger").hide();
        } else {
            $(".cmb2-id--mediax-breadcumb-image").show();
            $(".cmb2-id--mediax-page-title").show();
            $(".cmb2-id--mediax-page-breadcrumb-trigger").show();
    
            if( $mediax_page_title.val() == '1' ) {
                $(".cmb2-id--mediax-page-title-settings").show();
                if( $mediax_page_title_settings.val() == 'default' ) {
                    $(".cmb2-id--mediax-custom-page-title").hide();
                } else {
                    $(".cmb2-id--mediax-custom-page-title").show();
                }
            } else {
                $(".cmb2-id--mediax-page-title-settings").hide();
                $(".cmb2-id--mediax-custom-page-title").hide();
    
            }
        }
    });

    // page title settings
    $mediax_page_title_settings.on("change",function(){
        if( $(this).val() == 'default' ) {
            $(".cmb2-id--mediax-custom-page-title").hide();
        } else {
            $(".cmb2-id--mediax-custom-page-title").show();
        }
    });
    
})(jQuery);