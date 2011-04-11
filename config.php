<?php

/*** error reporting on ***/
 error_reporting(E_ALL);

 /*** define the site path constant ***/
 $site_path = realpath(dirname(__FILE__));
 define ('SITE_PATH', $site_path);

 /**
 * Keyspace for cassandra to used 
 */

 define('keyspace', 'blog',TRUE);
/* * *
 * Load cassandra phpcassa library
 */
require_once SITE_PATH . '/lib/phpcassa/' . 'connection.php';
require_once SITE_PATH . '/lib/phpcassa/' . 'columnfamily.php';

/**
 * Get class name and require filename
 */
function __autoload($class_name) {
    $filename = SITE_PATH . '/inc/' . $class_name . '.php';
    require_once $filename;
}
?>
