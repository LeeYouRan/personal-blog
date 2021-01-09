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
define( 'DB_NAME', 'blog' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'boXm3;bC~Sb6SH=$t.`b,ShXzL$/Rpbg}>[bO;h WRvL4(2f=]d/48ZuGw/dC,&[' );
define( 'SECURE_AUTH_KEY',  'RM^Mp]s*- hBl<_.JtKuIO V&_f?([w.`<~qq];>EcSxg9Uk!zLe^jNC,D_M1X[n' );
define( 'LOGGED_IN_KEY',    'Z<Di5}+vK^C`8(Zq&BVP:`0>/7#amgD8!JtgLgkXIa]m%wwU52hm&{5Bx#6[hTLk' );
define( 'NONCE_KEY',        '4?qjYuk^Q;%Hod3u}Tt5m +XYh~b)m-R*4::P%##]N0lV0q/q${M^#{^=qmRJ02Q' );
define( 'AUTH_SALT',        '}k[iF:w-cZ8.y`xs&7/qp,Rc^.J=6w/d8#/:t8D$@E$c;<r5% :DVPPCk?>drT#]' );
define( 'SECURE_AUTH_SALT', 'ECR}Z)x00CK.yh&+r~#chn$#PCFxxh*%pS_{rCp?M9N/gp(M=<)#m0~ITd2H@:N[' );
define( 'LOGGED_IN_SALT',   'eL^TNm*E#ibGQO3zbtDH~||-anJ#aDnHzyR50>-/z+_^gioLRNBS5Lr4s$+@|WGl' );
define( 'NONCE_SALT',       'QbRO$8c6Tnd Q6QK8|3`{<WE)bY(1 (E$m1W5SOJYqy@?~^q4Pth/XHHk!3p{q<V' );

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
