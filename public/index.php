<?php

defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

require_once APPLICATION_PATH . '/configs/constants.php';

$username = 'admin';
$password = 'admin';
if(APPLICATION_ENV != 'development') {
    $auth = isset($_GET[$username])?$_GET[$username]:'';
    if ($_SERVER['REMOTE_ADDR'] != '192.168.11.1' && $auth != $password){
        if(!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] != $username 
           || $_SERVER['PHP_AUTH_PW'] != $password) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            die;
        }
    }
}
    
//config for layout
require_once APPLICATION_PATH . '/../library/functions/layout.php';

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
      '/../library',
     '/../../library',
     '/home/gia53c14/public_html/library',
    get_include_path(),
)));



/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$application->bootstrap()
            ->run();