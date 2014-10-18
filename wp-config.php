<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'absolvewinelounge_dev');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', 'utf8_general_ci');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '(KOw5/v!wD>R__+2S*&?Q?-mF$.MR&E |%FuEcOk#c9CNqr^gvLipo%b[@#=Tw>{');
define('SECURE_AUTH_KEY',  '94at9QH b?b@,VP|6){lERQh9/W>i~cFTCT`*vcEAKL*.N<wZ<A]V^^e|RHe`T%:');
define('LOGGED_IN_KEY',    ',r|iDo%4p=.+-nM[w7i~0u-<Y_yb=.FK+-oimpoa@`cC7=oIJY+|7qn1-@|[!9f<');
define('NONCE_KEY',        'nvmB]cdy%Qcj7{bo?eP+b<NnqWB^o3~vE+DT:m(0+`~hV&s;CQ=2>ri}9Wlm^nv ');
define('AUTH_SALT',        'v+|x+t[SI<eBoi-p0Ly@xfB^*Ec^5N91dE|v`pR#>;jy;Fm;-43qQE#}>;_/)k+`');
define('SECURE_AUTH_SALT', 'hE)]^p0/$`M%tk04zE+7&:<R[)W%gx#O`a#_S+Hu/Vp*QTvw6m~` @;Z[9dP<F|T');
define('LOGGED_IN_SALT',   'BG{9C`mTORj`UU)^>~k`@:QdgSwN=hdH>zw|@} +z]m;N:$-W@8jPJxU%Dp iOLo');
define('NONCE_SALT',       '`?#Clr[S18KMuc{^`+%>weYFb[mo|&|~+]bFYj+|?:Y|*ZAydV,kN*|p/lh@Z2&3');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'e32db47_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
