<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

define ('APP_CONTROLLER', APPPATH.'controller/');
define ('APP_VIEW', APPPATH.'view/');
define ('APP_MODELS', 'model/');

/* Konfigurasi APP */

$CONFIG['admin']['app_server'] = TRUE;
$CONFIG['admin']['smarty_enabled'] = false;
$CONFIG['admin']['app_status'] = 'Development';
$CONFIG['admin']['app_debug'] = TRUE;
$CONFIG['admin']['app_underdevelopment'] = FAlSE;
$CONFIG['admin']['smarty_enabled'] = true;
$CONFIG['admin']['php_ext'] = '.php';
$CONFIG['admin']['html_ext'] = '.html';
$CONFIG['admin']['default_view'] = 'home';
$CONFIG['admin']['login'] = 'login';


$CONFIG['admin']['app_url'] = 'http://localhost/codekir/codekir/';
$CONFIG['admin']['base_url'] = 'http://localhost/codekir/codekir/admin/';
$CONFIG['admin']['root_path'] = $_SERVER['DOCUMENT_ROOT'].'/codekir/codekir/admin';

$CONFIG['admin']['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/codekir/codekir/public_assets/';

$CONFIG['admin']['max_filesize'] = 2097152;

$CONFIG['admin']['css'] = APPPATH.'css/';
$CONFIG['admin']['images'] = APPPATH.'images/';
$CONFIG['admin']['js'] = APPPATH.'js/';

$basedomain = $CONFIG['admin']['base_url'];
$app_domain = $CONFIG['admin']['app_url'];

/* Konfigurasi DB */

$dbConfig[0]['active']   = TRUE;
$dbConfig[0]['host'] = 'host';
$dbConfig[0]['user'] = 'user';
$dbConfig[0]['pass'] = 'password';
$dbConfig[0]['name'] = 'db_name';
$dbConfig[0]['server'] = 'mysql';


?>
