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
define( 'DB_NAME', 'wp_foody' );

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
define( 'AUTH_KEY',         'w0itlwSP2U40bY,o#0bUV.yo_4Mld, V_6sm$BuOwfb)ok-4,!Rr5*:t^z}aQH)^' );
define( 'SECURE_AUTH_KEY',  'Ap!k-O1((n+E@:6!9<%ZX]r>VYJug{VxPPX5tE@rc[JluHiJO:]mu|nyV*[0De0I' );
define( 'LOGGED_IN_KEY',    'nh=h8O}i;B,Bu#9aUFdueie1wHB>Pj_%%t@SHMYjb54 f~zE]i}K,_~s,#6ClZR)' );
define( 'NONCE_KEY',        '@0$_(A&7<TE2;iJh|4FA_)-C$5XWz:42}0_L/n|TmIUXQ~_8=hd#}6*TYR,S7Grq' );
define( 'AUTH_SALT',        'YKyUpxGZ8;K|nU{aj6,DG2:n6ng`d*,]3~nftkM5et4Y<=_EM|xN1:hRRve9A-?*' );
define( 'SECURE_AUTH_SALT', 'D<b8|jX~j;E{tVJQ vg>$n-2RH&o>wLerVKxvh}rT0k&lwy%aCA;(p;tP{h#il1E' );
define( 'LOGGED_IN_SALT',   'm5F4QSaZSuMuKBWLtm9f;ABh/N4rZ=Ep$j@S[l0WT%apnPcd6ciSHH%]v~?y0:E5' );
define( 'NONCE_SALT',       '^zlxsiKJ|~i8tC2DVr]SnH:QQT!p[?|U*WgP5$]P0+p5mEN%qWu4PVGKY7e]L2qH' );

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
$debug = false;
define( 'WP_DEBUG', $debug );
define('WP_DEBUG_LOG', $debug);
define('WP_DEBUG_DISPLAY', $debug);

/* Add any custom values between this line and the "stop editing" line. */
/** XAMPP ProFTPD settings */
define("FS_METHOD","direct");
define("FTP_HOST", "localhost");
define("FTP_USER", "daemon");
define("FTP_PASS", "xampp");


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Enables page caching for Cache Enabler. */
if ( ! defined( 'WP_CACHE' ) ) {
	define( 'WP_CACHE', true );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
