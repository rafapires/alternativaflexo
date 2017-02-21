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
define('DB_NAME', 'alternativa');

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
define('AUTH_KEY',         '=!lTx.:e9,W/C0h63Zsr@jvNc<[pJo`A6PL-27-1!3svZTBv*mFmMF^*:Q ::JU|');
define('SECURE_AUTH_KEY',  'r4OLH{@PvY]s$E2^H$oQ;,damJ[^h=^<qM+Ni/|QkP~D?AaH3V2l,IwQ-YL1,1p(');
define('LOGGED_IN_KEY',    'y -uqgO6u!#G?j7epoN[e$mfA:u:0;xEdPC].x&1!f,09Fg>Uucj7<rJ@|R1:=1 ');
define('NONCE_KEY',        'y(v&=aC^?cY-~yyjOCt%Q@{eOX6{apQ7NaB~2o*L-;c*}.S*zV`0j)9tWien*&,L');
define('AUTH_SALT',        '_IT(mIek?]R3y&Hb]9_-OaCmaD8n6nVI^,I^eA}u2S)q2VCGRgkY]w=`5+;]P<_w');
define('SECURE_AUTH_SALT', '#J*CNs$3sbADQZXAQ@:C[cIJFBJvWmN3<>D+&PZGp.N1_M~e8 nL$g0J_v-V=i3G');
define('LOGGED_IN_SALT',   's_OF<lS51g|LCSbzVeAp#*S;jt;U&yj>)U]+rEac:f?)bYp<%p0aGjl3te>=.wcW');
define('NONCE_SALT',       '{@*O%mz-Z .oGj)Z}W~l~>ZSO@.p#}{{>ua?4/O6tkv/9oY?uFhIn.hl7KBj7obK');

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
