<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'uetKjKj6qhWtzu?@vwpd-[Ze5`E16U{bko=m^(~9(NM9i:S4R}1hfzE-ipjjr9NJ');
define('SECURE_AUTH_KEY',  '`ECVzB?;fODt^W6+&R+J47zh0Cn#A?ZI5HGb=0I2):q&aMf {QsziZfj[r.i:llL');
define('LOGGED_IN_KEY',    '5P76>Fy)zr|CxpERn>/H@4)@![N}RfEz~chC+=lGC[YZH?.x1>a*n;_^9KvOLCl5');
define('NONCE_KEY',        '%$-(v8w*}R|a(B l|DhUapkH`uNX<JfX;ivpy1K*6,240.T9U-F~hv>;UA+J=v]W');
define('AUTH_SALT',        'd]qC&wg#Z3y6v4)DK,t>@hz4-Hk2D)@KL/eibbY:4w&/>_g>/1i#<kJnBPZ>J/h4');
define('SECURE_AUTH_SALT', 'hK+,M;sw&iBz}As}T+6jZr0JJ}8XMH4fwHNJfj_rXq}OR]V:}fVw-SczK_#B8ldn');
define('LOGGED_IN_SALT',   'C-[~&;R35<My?Uz2v`g,(E1BWaJJyVMrr]v:wV#=NlHP#dRiEKrox5oFm^`]u2R,');
define('NONCE_SALT',       'F8uQj_5r4Yb{K,K`]tr^Ik3So(v0Bn97&I,3~!ecpj9m;kAYG<RFSteRFI8^}y?$');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
