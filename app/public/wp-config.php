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
define( 'DB_NAME', 'root' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'mysql' );

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
define( 'AUTH_KEY',         'uC 3ct!voN=59 mB%$ROA54x`[B8 C&;.*RrIUIcD=,INMq@eNr<`gK[RKOLtJLm' );
define( 'SECURE_AUTH_KEY',  '_/<+4.Q]2*lSACeM6QSd>T-Z3l^!7*wZlOI6@b0Lr?v6~_@)=pD&1s4S(9m[Hl,C' );
define( 'LOGGED_IN_KEY',    'u8`T0YB!P~7^f?RT%)PVPZexVN&9h0!-h%`wZ6F1!r6}8Vww#w;x$eu52u|Q{#7D' );
define( 'NONCE_KEY',        'zNIp1H_5tx6]O-CwIPiatBE`RsJSGHVD)]l/!{sJhH.zf4-XLV@O=LpA&|n<{^~E' );
define( 'AUTH_SALT',        'z5W#[D$P,rrm V?$k%,xAMw}~k|@=QI~yk l+e.;^,djTYZY^4pn%VVM}4bmjw];' );
define( 'SECURE_AUTH_SALT', 'g1!*uvb$7cNIq5*?&u1We7{^/m;=<Ik9sL&Iv*)Y]yN@OgB*DeN}#-I>_*pU*Q_<' );
define( 'LOGGED_IN_SALT',   'ER##T*|iT.RL3m)wKgzuj!{`]n;}/MNqUroxaiomf$>in]#q}M0c,ioK| i;w2nQ' );
define( 'NONCE_SALT',       'U!2nf() rHpFXzYt4q*b>~D&Hnmj3S$q;gQLkvj7w-#.^sZ/CRJis7C7GH@eMi22' );

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
define( 'WP_DEBUG', false );
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG_DISPLAY', false);
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
