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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'cats' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Be$=7gYPn]P}sgwJsZ13Puul=2AcjROaE?4}_Er,nr`frbv0Nck(?1j}8xYA#dmb' );
define( 'SECURE_AUTH_KEY',  '?b6XNu9aXnWR,W%|MqtL.~&S_l:&)`z6@Np/z2X)c!ppMuXJ=3+qK{6zHS/wY.x4' );
define( 'LOGGED_IN_KEY',    'prhf]c%dkQtksGWjwO6!CX50zy*GZi3|ql$biTTg,7 OJ0_$23(dz/0!3mfmYIrN' );
define( 'NONCE_KEY',        'C?FzSpPc^%pU|&jt4h8.dKW;xn}JN!E!:^-9jmB_*&pN,Om)Fz<E5Ev:K-|>6HW!' );
define( 'AUTH_SALT',        '|?|[guMjnlS~wDyugT`ESb~eZH8-Y|c/77{im#}$R]RgvKFUGB/yZKp]K{p9j0qS' );
define( 'SECURE_AUTH_SALT', 'tfTN9w0X]3hS+4HzLAlm0ht><whxqJ,`^{5`fC7a9Yf`2kjAg#);QJ%eFB`3=}u`' );
define( 'LOGGED_IN_SALT',   'P_,:bUks~Mc#EaFQ#8f9T_2v1moYF{39j,johqcs*(]tpz0O&g:pq*_){MU^L8wu' );
define( 'NONCE_SALT',       '*s=X!C1pL@pSKRP&(q^MP2K!DZuHq=+;MItajFY&dObtk7v[D:iH- e,JVB0fovY' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';