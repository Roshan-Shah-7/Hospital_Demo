<?php
/**
 * @Packge     : Mediax
 * @Version    : 1.0
 * @Author     : Themeholy
 * @Author URI : https://themeforest.net/user/themeholy
 *
 */

// Block direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
    
    /**
    *
    * Hook for Footer Content
    *
    * Hook mediax_footer_content
    *
    * @Hooked mediax_footer_content_cb 10
    *
    */
    do_action( 'mediax_footer_content' );


    /**
    *
    * Hook for Back to Top Button
    *
    * Hook mediax_back_to_top
    *
    * @Hooked mediax_back_to_top_cb 10
    *
    */
    do_action( 'mediax_back_to_top' );

    /**
    *
    * mediax grid lines
    *
    * Hook mediax_grid_lines
    *
    * @Hooked mediax_grid_lines_cb 10
    *
    */
    do_action( 'mediax_grid_lines' );

    wp_footer();
    ?>
</body>
</html>