<?php
# Database Configuration
define( 'DB_NAME', 'local' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'root' );
define( 'DB_HOST', 'localhost' );
define( 'DB_HOST_SLAVE', '127.0.0.1:3306' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         '-)2`LlA6Nq_m&yE12l,@MJ~*hvpw+DT[+<fjq&(@c94#F2:J22|No?hjv*@Z*gI4');
define('SECURE_AUTH_KEY',  'by]AolXU4zM-gI7J?rqHn;5qYJ+i=VEl1VESW6dpD`jW/ TE.+9=idBIN$:2q ~%');
define('LOGGED_IN_KEY',    '{3j3uvfB`jeALmw+5HWao/|n|zP|Y/2%*&f$}0fxd|:f4utLux$TlyDpBYI#sc>)');
define('NONCE_KEY',        '2lDGx4X`tTYIO!g$g1{1](;3:}v;K7GUm%8z9n0cE${`T-sO3)n0LF+rFKN.%GRs');
define('AUTH_SALT',        'U36(kU,F,uTj#T0e&1t`/o9aTs84>3}}+SeHe3(!=Hy~Ikj0Pm{/7AB:ykZU8r=`');
define('SECURE_AUTH_SALT', ']Qf-D$u5NT~+U)ku.Lm(q92hFP__He-J|j0*iA6>nb{#9RpoEJP%/M7l@X|xU|f^');
define('LOGGED_IN_SALT',   'Qh*B{e$Qz<]d@YmM8%YYf|7X-A:n|?bAmolf+Vo&6#i|DV7{-?Wso]J8+&:|d:h0');
define('NONCE_SALT',       '>,vFfJk<2uNS*o>2ZdHRZ.Zo#,-pX~7|T,fe_4afV+b(g|2/K+nc*ptM<F}*}6uE');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'sentiodevstg' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'WPE_APIKEY', 'f2a5d595e9e6f466e699b640e3da290a15a0093b' );

define( 'WPE_CLUSTER_ID', '400025' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 2222 );

define( 'WPE_SFTP_ENDPOINT', '34.138.141.189' );

define( 'WPE_LBMASTER_IP', '' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'sentiodevstg.wpengine.com', 1 => 'sentiodevstg.wpenginepowered.com', );

$wpe_varnish_servers=array ( 0 => '127.0.0.1', );

$wpe_special_ips=array ( 0 => '34.74.5.29', 1 => 'pod-400025-utility.pod-400025.svc.cluster.local', );

$wpe_netdna_domains=array ( );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( 'default' =>  array ( 0 => 'unix:///tmp/memcached.sock', ), );
define('WPLANG','');

# WP Engine ID


# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', __DIR__ . '/');
require_once(ABSPATH . 'wp-settings.php');
