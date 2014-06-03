<?php
/* SVN FILE: $Id: bootstrap.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 *
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php is loaded
 * This is an application wide file to load any function that is not used within a class define.
 * You can also use this to include or require any files in your application.
 *
 */
/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * $modelPaths = array('full path to models', 'second full path to models', 'etc...');
 * $viewPaths = array('this path to views', 'second full path to views', 'etc...');
 * $controllerPaths = array('this path to controllers', 'second full path to controllers', 'etc...');
 *
 */
//EOF

set_include_path(get_include_path() . PATH_SEPARATOR . "/usr/share/pear" . PATH_SEPARATOR . dirname(__FILE__)."/../../");
ini_set("memory_limit", "200M");
ini_set("upload_max_filesize", "100M");

?>
<?
$hostname = $_SERVER['HTTP_HOST'];
$hostname_parts = split("[.]", $hostname);
if(count($hostname_parts) > 2 && preg_match("/^[a-zA-Z]+/", $hostname)) { array_shift($hostname_parts); }
$domain = join(".", $hostname_parts);
	#error_log("DOM=$domain");
if ($domain && preg_match("/^[a-zA-Z]+/", $hostname))
{
	ini_set('session.cookie_domain', ".$domain");
	#error_log("COOK_DOMA=$domain");
}
$expire_one_year = 60*60*24*365;
ini_set('session.cookie_lifetime', $expire_one_year);

# REDIRECT IF HDTEST AND NOT FROM OFFICE.....
$internal_ip = '71.224.15.94';
$internal_ip = '69.139.23.131';
$internal_ip = '24.127.150.29';
$internal_ip = '71.224.1.11';
$internal_ip = '69.253.57.132';
if (!empty($_SERVER['HTTP_HOST']) && preg_match("/hdtest/", $_SERVER['HTTP_HOST']) && $_SERVER['REMOTE_ADDR'] != $internal_ip)
{
	#header("Location: http://www.harmonydesigns.com/");
	#exit(0);
}

# ZEND
ini_set('include_path', ini_get('include_path') . ':' . APP . DS . '/vendors');

/**
 * AutoLoading Zend Vendor Files
 */
function __autoload($path) {
    if(substr($path, 0, 5) == 'Zend_') {
        include str_replace('_', '/', $path) . '.php';
    }
    return $path;
}

#ini_set("session.cache_limiter", "public");

?>