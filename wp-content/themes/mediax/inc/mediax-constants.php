<?php
/**
 * @Packge     : Mediax
 * @Version    : 1.0
 * @Author     : Themeholy
 * @Author URI : https://themeforest.net/user/themeholy
 *
 */

// Block direct access
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/**
 *
 * Define constant 
 *
 */

// Base URI
if ( ! defined( 'MEDIAX_DIR_URI' ) ) {
    define('MEDIAX_DIR_URI', get_parent_theme_file_uri().'/' );
}

// Assist URI
if ( ! defined( 'MEDIAX_DIR_ASSIST_URI' ) ) {
    define( 'MEDIAX_DIR_ASSIST_URI', get_theme_file_uri('/assets/') );
}


// Css File URI
if ( ! defined( 'MEDIAX_DIR_CSS_URI' ) ) {
    define( 'MEDIAX_DIR_CSS_URI', get_theme_file_uri('/assets/css/') );
}

// Js File URI
if (!defined('MEDIAX_DIR_JS_URI')) {
    define('MEDIAX_DIR_JS_URI', get_theme_file_uri('/assets/js/'));
}


// Base Directory
if (!defined('MEDIAX_DIR_PATH')) {
    define('MEDIAX_DIR_PATH', get_parent_theme_file_path() . '/');
}

//Inc Folder Directory
if (!defined('MEDIAX_DIR_PATH_INC')) {
    define('MEDIAX_DIR_PATH_INC', MEDIAX_DIR_PATH . 'inc/');
}

//MEDIAX framework Folder Directory
if (!defined('MEDIAX_DIR_PATH_FRAM')) {
    define('MEDIAX_DIR_PATH_FRAM', MEDIAX_DIR_PATH_INC . 'mediax-framework/');
}

//Hooks Folder Directory
if (!defined('MEDIAX_DIR_PATH_HOOKS')) {
    define('MEDIAX_DIR_PATH_HOOKS', MEDIAX_DIR_PATH_INC . 'hooks/');
}

//Demo Data Folder Directory Path
if( !defined( 'MEDIAX_DEMO_DIR_PATH' ) ){
    define( 'MEDIAX_DEMO_DIR_PATH', MEDIAX_DIR_PATH_INC.'demo-data/' );
}
    
//Demo Data Folder Directory URI
if( !defined( 'MEDIAX_DEMO_DIR_URI' ) ){
    define( 'MEDIAX_DEMO_DIR_URI', MEDIAX_DIR_URI.'inc/demo-data/' );
}