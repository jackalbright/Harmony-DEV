<?php
/* SVN FILE: $Id: database.php.default 8004 2009-01-16 20:15:21Z gwoo $ */
/**
 * This is core configuration file.
 *
 * Use it to configure core behaviour ofCake.
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
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 8004 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2009-01-16 12:15:21 -0800 (Fri, 16 Jan 2009) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * In this file you set up your database connection details.
 *
 * @package       cake
 * @subpackage    cake.config
 */
/**
 * Database configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * driver => The name of a supported driver; valid options are as follows:
 *		mysql 		- MySQL 4 & 5,
 *		mysqli 		- MySQL 4 & 5 Improved Interface (PHP5 only),
 *		sqlite		- SQLite (PHP5 only),
 *		postgres	- PostgreSQL 7 and higher,
 *		mssql		- Microsoft SQL Server 2000 and higher,
 *		db2			- IBM DB2, Cloudscape, and Apache Derby (http://php.net/ibm-db2)
 *		oracle		- Oracle 8 and higher
 *		firebird	- Firebird/Interbase
 *		sybase		- Sybase ASE
 *		adodb-[drivername]	- ADOdb interface wrapper (see below),
 *		odbc		- ODBC DBO driver
 *
 * You can add custom database drivers (or override existing drivers) by adding the
 * appropriate file to app/models/datasources/dbo.  Drivers should be named 'dbo_x.php',
 * where 'x' is the name of the database.
 *
 * persistent => true / false
 * Determines whether or not the database should use a persistent connection
 *
 * connect =>
 * ADOdb set the connect to one of these
 *	(http://phplens.com/adodb/supported.databases.html) and
 *	append it '|p' for persistent connection. (mssql|p for example, or just mssql for not persistent)
 * For all other databases, this setting is deprecated.
 *
 * host =>
 * the host you connect to the database.  To add a socket or port number, use 'port' => #
 *
 * prefix =>
 * Uses the given prefix for all the tables in this database.  This setting can be overridden
 * on a per-table basis with the Model::$tablePrefix property.
 *
 * schema =>
 * For Postgres and DB2, specifies which schema you would like to use the tables in. Postgres defaults to
 * 'public', DB2 defaults to empty.
 *
 * encoding =>
 * For MySQL, MySQLi, Postgres and DB2, specifies the character encoding to use when connecting to the
 * database.  Uses database default.
 *
 */
class DATABASE_CONFIG {

	var $dev_default = array(
		'driver' => 'mysql_log',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'harmony_main',
		'password' => 'harmony_main1',
		'database' => 'harmony_main',
		'prefix' => '',
	);

	var $dev_default_legacy = array(
		'driver' => 'mysql_log',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'harmony_main',
		'password' => 'harmony_main1',
		'database' => 'harmony_main',
		'prefix' => '',
	);

    var $default = array(
		'driver' => 'mysql_log',
		'persistent' => false,
		'database' => 'harmonyd_main',
		'login' => 'harmonyd_admin',
		'password' => 'no-gkyL4^P6h',
		'prefix' => '',
        );
		// N E W       D E V E L O P M E N T       S I T E     (05-05-2014)
	var $newDev_default = array(
		'driver' => 'mysql_log',
		'persistent' => false,
		'database' => 'harmonyd_main1',
		'login' => 'harmonyd_admin',
		'password' => 'no-gkyL4^P6h',
		'prefix' => '',
        );
	var $newDev_default_legacy = array(
		'driver' => 'mysql_log',
		'persistent' => false,
		'host' => 'localhost',
		'database' => 'harmonyd_main1',
		'login' => 'harmonyd_admin',
		'password' => 'no-gkyL4^P6h',
		'prefix' => '',
        );	
		
	var $hdtest_default = array(
        'driver' => 'mysql_log',
        'persistent' => false,
		'host'=>'localhost',
		'login'=>'hdtest',
		'password'=>'HarmonyDesigns1',
		'database'=>'hdtest',
                #'host' => '76.12.97.29',
                #'login' => 'hdtestcom',
                #'password' => 'HarmonyDesigns1',
                #'database' => 'hdtestcom',
         'prefix' => '',
        );

	var $default_legacy = array(
		'driver' => 'mysql_log',
		'persistent' => false,
		'host' => '67.59.151.236',
		'login' => 'harmony_main',
		'password' => 'idk2Xbbq',
		'database' => 'harmony_main',
		'prefix' => '',
        );

	var $test = array(
		'driver' => 'mysql_log',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'user',
		'password' => 'password',
		'database' => 'test_database_name',
		'prefix' => '',
	);

	var $zendSearchLucene = array(
		'datasource' => 'zend_search_lucene',
		'indexFile' => 'lucene', // stored in the cache dir.
		'driver' => '',
		'source' => 'search_indices'
	);


	function __construct()
	{
		$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : "";
		#error_log("HOST=$host");
		$server = php_uname('n');
		if (preg_match("/hdtest/", $host) || preg_match("/slotsoffun/", $server)) { 
			$this->default = $this->hdtest_default;
			$this->default_legacy = $this->hdtest_default;
		} else if (preg_match("/dev[.]harmonydesigns[.]com/", $server) ){
			#error_log("DEV");
			$this->default = $this->newDev_default;
			$this->default_legacy = $this->newDev_default_legacy;
		
		}else if (preg_match("/harmonydesigns[.]com/", $host) || preg_match("/tropicana/", $server)) { 
			# Do nothing.
			#$this->default = $this->hdtest_default;
			#$this->default_legacy = $this->hdtest_default;
		} 
		/*
		else if (($host && preg_match("/malysoft/", $host)) || $host == "") {
			#error_log("DEV");
			$this->default = $this->dev_default;
			$this->default_legacy = $this->dev_default_legacy;

		}
		*/
	}

}
?>