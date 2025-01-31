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
 * Include File
 *
 */

// Constants
require_once get_parent_theme_file_path() . '/inc/mediax-constants.php';

//theme setup
require_once MEDIAX_DIR_PATH_INC . 'theme-setup.php';

//essential scripts
require_once MEDIAX_DIR_PATH_INC . 'essential-scripts.php';

// Woo Hooks
require_once MEDIAX_DIR_PATH_INC . 'woo-hooks/mediax-woo-hooks.php';

// Woo Hooks Functions
require_once MEDIAX_DIR_PATH_INC . 'woo-hooks/mediax-woo-hooks-functions.php';

// plugin activation
require_once MEDIAX_DIR_PATH_FRAM . 'plugins-activation/mediax-active-plugins.php';

// theme dynamic css
require_once MEDIAX_DIR_PATH_INC . 'mediax-commoncss.php';

// meta options
require_once MEDIAX_DIR_PATH_FRAM . 'mediax-meta/mediax-config.php';

// page breadcrumbs
require_once MEDIAX_DIR_PATH_INC . 'mediax-breadcrumbs.php';

// sidebar register
require_once MEDIAX_DIR_PATH_INC . 'mediax-widgets-reg.php';

//essential functions
require_once MEDIAX_DIR_PATH_INC . 'mediax-functions.php';

// helper function
require_once MEDIAX_DIR_PATH_INC . 'wp-html-helper.php';

// Demo Data
require_once MEDIAX_DEMO_DIR_PATH . 'demo-import.php';

// pagination
require_once MEDIAX_DIR_PATH_INC . 'wp_bootstrap_pagination.php';

// mediax options
require_once MEDIAX_DIR_PATH_FRAM . 'mediax-options/mediax-options.php';

// hooks
require_once MEDIAX_DIR_PATH_HOOKS . 'hooks.php';

// hooks funtion
require_once MEDIAX_DIR_PATH_HOOKS . 'hooks-functions.php'; 


add_action('wp_ajax_update_cart_count', 'update_cart_count');
add_action('wp_ajax_nopriv_update_cart_count', 'update_cart_count');

function update_cart_count() {
    if (class_exists('woocommerce')) {
        global $woocommerce;
        $product_id = intval($_POST['product_id']);
        $woocommerce->cart->add_to_cart($product_id); // Add the product to the cart

        $cart_count = $woocommerce->cart->cart_contents_count;
        echo esc_html($cart_count);
    }
    wp_die();
}

