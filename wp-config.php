<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'bkt_hospital' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'A*3}5_Ob/}?%LVQJ.6wC8Zt-F8!Y.toN12$Rg0)f9[hp(dS/x%PY!f<:@b,z/LK&' );
define( 'SECURE_AUTH_KEY',  '=%E*efpK|EN~1ehbpf>dG,FS__U6U%Gt[@K>;c/-_IusrGJ_:M{xJhXMwHljszL7' );
define( 'LOGGED_IN_KEY',    'N:u;(. GEi+YJpH:`9r.L3/i8?]w!3d;66o,+Cr/Zc-R~2h5kp%|*n#-ls,yi,0k' );
define( 'NONCE_KEY',        'w6#lD:f(x9Z eB iw(?Dx0~x2u3W7fn*QU/Qq4J5!y9pt*LJy?NxaiB(F7[|i)e(' );
define( 'AUTH_SALT',        'jBO]$_tw&,ZmGJL;`{=Mzb6{2V%m%Y8cy;^<yy+0yi^O?ST^sWx3t-?@T/kFUf>O' );
define( 'SECURE_AUTH_SALT', 'cp`Vpoy6`6/_oOUhF/2m2:<DvfYygsFQ%2Y%YO{PR@J-zq`zb5dEpPx#LX%Dq$kc' );
define( 'LOGGED_IN_SALT',   'x,jG@+stJVw93uA@.{uDEl[tOB:R_yi)s~c;%/<kkTb;c%f@sBL5BVdr_ >Vxkm(' );
define( 'NONCE_SALT',       '&#.AX$d^jA~?e[E_T-2R<qt/Qr#.C1,s2>F{P-EgG|x-OSm{FA83I^Fs.`6KhaY1' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
