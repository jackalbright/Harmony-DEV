<?php
# Redirect to production site if test and not internal ip....

$internal_ip = '71.224.15.94'; 
$internal_ip = '69.139.23.131';
$internal_ip = '24.127.150.29';
$internal_ip = '71.224.1.11';
$internal_ip = '69.139.23.21';
if (!empty($_SERVER['HTTP_HOST']) && preg_match("/hdtest/", $_SERVER['HTTP_HOST']) && $_SERVER['REMOTE_ADDR'] != $internal_ip)
{
        #header("Location: http://www.harmonydesigns.com/");
	#exit(0);
	#Should force auth now, instead.
}



// some housekeeping chores. Not session related but this file is included everywhere.
include_once("classDefinitions.inc");

set_include_path(get_include_path() . PATH_SEPARATOR . "/usr/share/pear" . PATH_SEPARATOR . dirname(__FILE__));
#set_include_path(get_include_path() . PATH_SEPARATOR . "/usr/share/pear");

# Set session domain....
$cookieParams = session_get_cookie_params();
$cookieServer = $cookieParams[2];
if (!$cookieServer) { $cookieServer = $_SERVER['HTTP_HOST']; }
$cookieServerParts = split("[.]", $cookieServer);
if (count($cookieServerParts) <= 2) { 
	$cookieServer = ".".join(".", $cookieServerParts); # MUST have . in front!
	# Could switch over to www at any point...
} else {
	array_shift($cookieServerParts);
	$cookieServer = ".".join(".", $cookieServerParts); # MUST have . in front!
	#$cookieServer = preg_replace("/^\w+(([.]\w+){2,})$/", "\\1", $cookieServer);
}
#session_set_cookie_params($cookieParams[0], $cookieParams[1], $cookieServer);
#session_set_cookie_params($cookieParams[0], '/', $cookieServer);


// limit script execution when server is experiencing heavy load
 #$max_load = '12.50'; //your max load
 #$stats = @exec('/usr/bin/uptime');
 #preg_match('/averages?: ([0-9\.]+),[\s]+([0-9\.]+),[\s]+([0-9\.]+)/',$stats,$regs);
#
#echo "<h3>T = $stats</h3>\n"; 
# if ($regs[1] > $max_load)
# {
# echo " harmonydesigns.com is currently under heavy traffic and is 
#unable to complete your request. Please try again later.";
# exit (0);
# }
#
// set error reporting level	
#$debug = (!preg_match("/harmonydesigns.com/", $_SERVER['SERVER_NAME']));
$debug = (preg_match("/malysoft.com/", $_SERVER['SERVER_NAME']));
#$debug = 1;

if ($debug) {
		error_reporting (E_ALL);
	} else {
		error_reporting (E_ERROR);
	}
// send header for privacy policy
	header("P3P: policyref=\"http://www.harmonydesigns.com/w3c/p3p.xml\", CP=\"CAO DSP COR CURa ADMa DEVa OUR DELi STP PUR NAV INT\"");

// include necessary files	
	include_once ('baseSecurity.inc');
	include ('stripMagicQuotes.inc');
	include_once ('database.inc');
	include_once ('classDefinitions.inc');
	
// activate custom session handling code
	#include_once ('dbSession.inc');
	#$dbSession = new session();

	#session_set_save_handler (
	#			array(&$dbSession, '_open'), 
	#			array(&$dbSession, '_close'), 
	#			array(&$dbSession, '_read'), 
	#			array(&$dbSession, '_write'), 
	#			array(&$dbSession, '_destroy'), 
	#			array(&$dbSession, '_gc') ); 
				
	#session_start ();

	##error_log("SESS=".print_r($_SESSION,true));

// customer login
	if ( ! array_key_exists ('customerLogin', $_SESSION) ) {
		$_SESSION['customerLogin'] = '';
	}
	if ( ! array_key_exists ('currentLogin', $_SESSION) ) {
		$_SESSION['currentLogin'] = false;
	}
	if ( array_key_exists ('loginPersistence', $_COOKIE) ) {
		$idHash = $_COOKIE['loginPersistence'];
		if ($idHash!='no'){
			$result = mysql_query("SELECT * FROM `customer` where `idHash` = '$idHash'", $database);
			if (mysql_num_rows($result) == 1) {
				#$temp = mysql_fetch_object ($result);
				$customer = mysql_fetch_assoc($result);
				##error_log("CUST=".print_r($customer,true));

				$_SESSION['customerLogin'] = $customer['customer_id'];
				$_SESSION['customerRecord'] = $customer;
				$_SESSION['currentLogin'] = true;
			}
		}
	}

	if ( !array_key_exists('customerRecord', $_SESSION) && array_key_exists('customerlogin', $_COOKIE) )
	{
		$customer_id = preg_replace("/^(\d+)x.*/", "\\1", $_COOKIE['customerlogin']);
		$result = mysql_query("SELECT * FROM `customer` where `customer_id` = '$customer_id'", $database);
		if (mysql_num_rows($result) == 1) {
				$customer = mysql_fetch_assoc($result);

				$_SESSION['customerLogin'] = $customer['customer_id'];
				$_SESSION['customerRecord'] = $customer;
				$_SESSION['currentLogin'] = true;
		}
	#	$customerRecord = array();
	#	if (isset($_COOKIE['customerlogin']))
	#	{
	#	}
	}


// guest login
	if ( ! array_key_exists ('guestLogin', $_SESSION) ) {
		$_SESSION['guestLogin'] = '';
	}
    
// shopping cart
	if ( ! array_key_exists ('shoppingCart', $_SESSION) ) {
		$_SESSION['shoppingCart'] = array();
	}
	if ( ! array_key_exists ('zipCode', $_SESSION) ) {
		$_SESSION['zipCode'] = '';
	}
// Checkout Progress
	if ( ! array_key_exists ('checkoutProgress', $_SESSION) ) {
		$_SESSION['checkoutProgress'] = 'start';
	}
	if ( ! array_key_exists ('checkoutAccount', $_SESSION) ) {
		$_SESSION['checkoutAccount'] = null;
	}
// Category Browsing
	if ( ! array_key_exists ('browseNode', $_SESSION) ) {
		$_SESSION['browseNode'] = 1;
	}
	if ( ! array_key_exists ('resultOffset', $_SESSION) ) {
		$_SESSION['resultOffset'] = 1;
	}
	if ( ! array_key_exists ('resultCount', $_SESSION) ) {
		$_SESSION['resultCount'] = 10;
	}
// Last stamp viewed
	if ( ! array_key_exists ('catalogNumber', $_SESSION) ) {
		$_SESSION['catalogNumber'] = '';
	}
// Search Results
	if ( ! array_key_exists ('altSearch', $_SESSION) ) {
		$_SESSION['altSearch'] = false;
	}	
	if ( ! array_key_exists ('searchResults', $_SESSION) ) {
		$_SESSION['searchResults'] = array();
	}
	if ( ! array_key_exists ('pageResults', $_SESSION) ) {
		$_SESSION['pageResults'] = array();
	}
	if ( ! array_key_exists ('productResults', $_SESSION) ) {
		$_SESSION['productResults'] = array();
	}
	if ( ! array_key_exists ('catResults', $_SESSION) ) {
		$_SESSION['catResults'] = array();
	}
	if ( ! array_key_exists ('searchOffset', $_SESSION) ) {
		$_SESSION['searchOffset'] = 0;
	}
	if ( ! array_key_exists ('searchString', $_SESSION) ) {
		$_SESSION['searchString'] = '';
	}
	if ( ! array_key_exists ('ignoredTerms', $_SESSION) ) {
		$_SESSION['ignoredTerms'] = array();
	}
	if ( ! array_key_exists ('ignoreCt', $_SESSION) ) {
		$_SESSION['ignoreCt'] = 0;
	}
// Checkout
	if ( ! array_key_exists ('shippingOptions', $_SESSION) ) {
		$_SESSION['shippingOptions'] = array();
	}
	if ( ! array_key_exists ('submitOrder', $_SESSION) ) {
		$_SESSION['submitOrder'] = false;
	}
	if ( ! array_key_exists ('oldCart', $_SESSION) ) {
		$_SESSION['oldCart'] = array();
	}
	if ( ! array_key_exists ('oldPurchaseID', $_SESSION) ) {
		$_SESSION['oldPurchaseID'] = 'None';
	}
	if ( ! array_key_exists ('checkoutErrors', $_SESSION) ) {
		$_SESSION['checkoutErrors'] = array();
	}
// Account Login
	if ( ! array_key_exists ('acctInfo', $_SESSION) ) {
		$_SESSION['acctInfo'] = array();
	}
// Session History
	if ( ! array_key_exists ('pageHistory', $_SESSION) ) {
		$_SESSION['pageHistory'] = array();
	}
// Custom Images
	if ( ! array_key_exists ('tempImages', $_SESSION) ) {
		$_SESSION['tempImages'] = array();
	}
	if ( $_SESSION['customerLogin'] != '' ) {
		$customerID = $_SESSION['customerLogin'];
		$result = mysql_query ("SELECT `image_id` FROM `custom_image` where `customer_id` = $customerID AND `Show_Field` = 'yes'", $database);
		$savedImageCt = mysql_num_rows($result);
	} else {
		$savedImageCt = 0;
	}

// Create a directory for session related files
	#if ( ! array_key_exists ('sessionDirectory', $_SESSION) ) {
		#$fileBase = $_SERVER['DOCUMENT_ROOT'] . '/';
	#	$fileBase = dirname(__FILE__)."/../";
	#	$filePath = $fileBase . 'phpSession/' . session_id();
		#if ( ! file_exists ($filePath) ) {
		#	mkdir ($filePath, 0755);
		#}
		#$_SESSION['sessionDirectory'] = $filePath;
	#}
	
// Session Tracking Code START
/*
	if ( ! array_key_exists ('dbSessionID', $_SESSION) ) {
		$referrer = ( array_key_exists('HTTP_REFERER', $_SERVER) ? mysql_escape_string ( $_SERVER['HTTP_REFERER'] ) : 'NULL' );
		$sessionKey = session_id();
		$ipAddress = mysql_escape_string ( $_SERVER['REMOTE_ADDR'] );
		$browser = mysql_escape_string ( $_SERVER['HTTP_USER_AGENT'] );
		$result = mysql_query ("Insert into session( session_key, referrer, ip_address, browser, start_time ) values( '$sessionKey', '$referrer', '$ipAddress', '$browser', NOW() )", $database);
		$_SESSION['dbSessionID'] = mysql_insert_id($database);
	}
	
	$page = mysql_escape_string ( $_SERVER['REQUEST_URI'] );
	$dbSessionID = $_SESSION['dbSessionID'];
	$result = mysql_query ("Insert into page_load( session_id, page, time ) values( '$dbSessionID', '$page', NOW() )", $database);
*/
// Session Tracking Code END

// add the current page to the history.

	$pageHistory = $_SESSION['pageHistory'];
	if (!is_array($pageHistory)) { $pageHistory = array(); }
	$pageHistory[] = mysql_escape_string( $_SERVER['REQUEST_URI'] ); 

	$limit = 10; # Only keep last 10 items....

	$_SESSION['pageHistory'] = array_slice($pageHistory, count($pageHistory)-$limit-1, $limit);
	
// Set the session variables as globals for the current page
$keys = array_keys ($_SESSION);
	foreach ($keys as $key) {
		$$key =& $_SESSION[$key];
	}	

	if ($_REQUEST['session_debug']) 
	{ 
		echo "SESSION=".print_r($_SESSION,true)."\n<br/>"; 
		echo "\n<br/>COOKIES=".print_r($_COOKIE,true)."\n";
	}

	function set_logout_cookie()
	{
		set_cookies(array('customerlogin'=>false, 'loginPersistence'=>false));
		set_cookies(array('customerlogin'=>false, 'loginPersistence'=>false), -1, 'www.harmonydesigns.com');
		set_cookies(array('customerlogin'=>false, 'loginPersistence'=>false), -1, 'harmonydesigns.com');
		set_cookies(array('customerlogin'=>false, 'loginPersistence'=>false), -1, false);
	}

	function set_login_cookie($cookieText, $persistent = false)
	{
		$loginPersists = $persistent ? md5( rand(1000, 9999) . time() ) : 'no';
		set_cookies(array('customerlogin'=>$cookieText, 'loginPersistence'=>$loginPersists), $persistent);
	}

	function set_guest_login_cookie($cookieText, $persistent = false)
	{
		$loginPersists = $persistent ? md5( rand(1000, 9999) . time() ) : 'no';
		set_cookies(array('guestlogin'=>$cookieText, 'loginPersistence'=>$loginPersists), $persistent);
	}

	function set_cookies($cookies = array(), $persistent = false, $cookieServer = '')
	{
		# Strip off hostname, if there...
		#$cookieServer = preg_replace("/^\w+([.]\w+){2,}$/", "\\1", $_SERVER['HTTP_HOST']);
		if ($cookieServer === '')
		{
			$cookieServer = $_SERVER['HTTP_HOST'];
			$cookieServer = preg_replace("/^\w+(([.]\w+){2,})$/", "\\1", $cookieServer);
		}
		#error_log("CSERVER=$cookieServer, HPST=".$_SERVER['HTTP_HOST']);
		$cookieExpiration = 0;
		if ($persistent === -1) { $cookieExpiration = -1; }
		#if ($persistent === -1) { $cookieExpiration = 1; }
		else if ($persistent) { $cookieExpiration = time() + 64000000; }

		foreach($cookies as $key => $value)
		{
			if ($cookieServer === false)
			{
				#error_log("SETCOOKIE (NOSERV)=$key, $value, $cookieExpiration, /");
				setcookie($key, $value, $cookieExpiration, '/');
			} else {
				#error_log("SETCOOKIE=$key, $value, $cookieExpiration, /, $cookieServer");
				setcookie($key, $value, $cookieExpiration, '/', $cookieServer);
			}
		}
	}

?>
