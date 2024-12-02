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

define( 'HEBERGEMENT_LOCAL', true);

// ** Database settings - You can get this info from your web host ** //
if ( HEBERGEMENT_LOCAL ) {
	/** The name of the database for WordPress */
	define( 'DB_NAME', 'wordpress2024_duprassimardfelix' );

	/** Database username */
	define( 'DB_USER', 'root' );

	/** Database password */
	define( 'DB_PASSWORD', '' );

	/** Database hostname */
	define( 'DB_HOST', '127.0.0.1' );
}
else {
	/** The name of the database for WordPress */
	define( 'DB_NAME', 'wordpress2024_duprassimardfelix' );

	/** Database username */
	define( 'DB_USER', 'DraT0x' );

	/** Database password */
	define( 'DB_PASSWORD', '5CBBRw9R7H9h4uC' );

	/** Database hostname */
	define( 'DB_HOST', 'localhost' );
}

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
define( 'AUTH_KEY',         '6ksY^j?dG:hg=IeNK+@_usx=2>cT?VHAVTU_V<IErEM?JThCU.C1;y.XpMcmV66w' );
define( 'SECURE_AUTH_KEY',  '4;CHeJglXK10W{3r)vNRm.[K_GSSr0$,~_,pA{PT8rt4gG$N23i~fWAzbkM9*,cG' );
define( 'LOGGED_IN_KEY',    '*Q)?KcYSD5-lXJ`rw=7DOk:BIxDwty;FgJJl[zRHK5[foRm^1(@w`j6$X&b:nain' );
define( 'NONCE_KEY',        '!t>&Gc;&AF>an}2]XTQ0K3~i$i%J1n!t?^3 Virm} %G!W6[(-:jmPIUby<DZ[- ' );
define( 'AUTH_SALT',        ':!m|K`w()QC`9do?#Muj}PypR8H%1lD-xFP):M}Cp{YEO0$%Z[0)`GMZ}e536Jc7' );
define( 'SECURE_AUTH_SALT', 'zXymvSCXyw]0L|_-kf8B5g`nWMcST`I*U_?$|.SkdQV`4~XHAlB; -M3b!+t0>nK' );
define( 'LOGGED_IN_SALT',   'IUq]G^-<R`v3j]uqQl/DW:Du&4q&1>=NsIXI$Go9n}I6EUd0P2=w=oHj{nRk8.D,' );
define( 'NONCE_SALT',       '?*=>vn6c(|s6vF &tRF-RyWPG<{e_!=8 |Cs]},9e]017Bmmw]&>a,wd5HsxSY>0' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'fds6_';

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
// Active (true) ou désactive (false) le mode débogage
define( 'WP_DEBUG', true );

// Pendant le débogage, lorsqu'une erreur est rencontrée, n'affiche pas de message d'erreur à l'écran.
// Plutôt, WordPress enverra un codes d'état HTTP 500 au navigateur.
define( 'WP_DEBUG_DISPLAY', true );

// Pendant le débogage, WordPress enregistrera les messages d'erreur dans le fichier cité.
// Note : si la constante est simplement initialisée à true, les messages seront enregistrés dans le fichier wp-content/debug.log.
if ( HEBERGEMENT_LOCAL ) {
	define( 'WP_DEBUG_LOG',dirname(__FILE__, 2) . '/dev/debug/debug-' . date('Y-m-d') . '.log' );
} else {
	define( 'WP_DEBUG_LOG', dirname(__FILE__, 2) . '/debug-' . date('Y-m-d') . '.log' );
}
// En production (lorsque WP_DEBUG est à false), n'affiche pas les erreurs à l'écran.
@ini_set( 'display_errors', '0' );

/* Add any custom values between this line and the "stop editing" line. */
// COURRIEL
define( 'SMTP_HOST', 'mail.dratoxweb.org' );
define( 'SMTP_AUTH', true );
define( 'SMTP_PORT', '587' );  // ou 465
define( 'SMTP_SECURE', 'tls' );   // ou ssl
define( 'SMTP_USERNAME', 'no-reply@dratoxweb.org' );
define( 'SMTP_PASSWORD', 'EtvLYpG91*14}\@0O|£s)K' );
define( 'SMTP_FROM', 'no-reply@dratoxweb.org' );
if ( HEBERGEMENT_LOCAL ) {
	define( 'SMTP_FROMNAME', 'wordpress2024-duprassimardfelix.dvl.to' );
}
else {
	define( 'SMTP_FROMNAME', 'dratoxweb.org' );
}


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
