<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/home/touchdce/public_html/wodibenuah.com/wp-content/plugins/wp-super-cache/' );
define( 'DB_NAME', 'touchdce_wp41' );

/** MySQL database username */
define( 'DB_USER', 'touchdce_wp41' );

/** MySQL database password */
define( 'DB_PASSWORD', '-0Sp-467h7' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         'uvlal7b4u27ie0akqwgatdhldqclxxf1vmk3ly4nyla9xwwt4ilwkk4ayd3qjjxk' );
define( 'SECURE_AUTH_KEY',  'db05o4s64chxioa5ksvqjtwx0mddzfhncurqphyrph8md7krq2au7u9sxhlzexmh' );
define( 'LOGGED_IN_KEY',    'ydadd3tjrkhbnaeoiusd8zpw9qsdrky99jm0kvegrbxuogvxsfjdqobunkgoynto' );
define( 'NONCE_KEY',        '0ixz6v1zojnhzdqujh0saonpdvt2vxwvevd6myzxuxlitp42ew9kro9n1kvryj2n' );
define( 'AUTH_SALT',        'lj9oudoaxfhv7qr2xg84nunnakkhsbgk12fi7pnyndk12x8yxppy5z6lxx7lhcjb' );
define( 'SECURE_AUTH_SALT', 'dyvu3dbysxwxwlsjzmdhcflqtpjjwgl2jppsaxgcwzm3etr7e6me5hueqjmbithq' );
define( 'LOGGED_IN_SALT',   'xg2a5eyoinsu3oflyztodk5wfsvk8r894upyqlrsbkdfzutoyal0d8mub7hjjdmc' );
define( 'NONCE_SALT',       'jcg75cvmwm8axkgfbmippgitridhojtpzlagut8w98aoy8tlesgwg0ognroehge2' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpv5_';

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
