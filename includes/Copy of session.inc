<?php
	if ( $_SERVER['SERVER_NAME'] == 'www.hdtest.com' ) {
		error_reporting (E_ALL);
	} else {
		error_reporting (E_ERROR);
	}
	include_once ('baseSecurity.inc');
	include_once ('classDefinitions.inc');
	include_once ('database.inc');
	session_start ();

	if ( ! array_key_exists ('shoppingCart', $_SESSION) ) {
		$_SESSION['shoppingCart'] = array();
	}
	if ( ! array_key_exists ('browseNode', $_SESSION) ) {
		$_SESSION['browseNode'] = 1;
	}
	if ( ! array_key_exists ('resultOffset', $_SESSION) ) {
		$_SESSION['resultOffset'] = 1;
	}
	if ( ! array_key_exists ('resultCount', $_SESSION) ) {
		$_SESSION['resultCount'] = 10;
	}
	if ( ! array_key_exists ('catalogNumber', $_SESSION) ) {
		$_SESSION['catalogNumber'] = '';
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
	if ( ! array_key_exists ('shipping', $_SESSION) ) {
		$_SESSION['shipping'] = array();
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
	if ( ! array_key_exists ('acctInfo', $_SESSION) ) {
		$_SESSION['acctInfo'] = array();
	}
	if ( ! array_key_exists ('checkoutErrors', $_SESSION) ) {
		$_SESSION['checkoutErrors'] = array();
	}
	if ( ! array_key_exists ('pageHistory', $_SESSION) ) {
		$_SESSION['pageHistory'] = array();
	}

// Remove quotes from magic_quotes_gpc if necessary
	include ('stripMagicQuotes.inc');

// Session Tracking Code START
	if ( ! array_key_exists ('dbSessionID', $_SESSION) ) {
		$referrer = ( array_key_exists('HTTP_REFERER', $_SERVER) ? mysql_escape_string ( $_SERVER['HTTP_REFERER'] ) : 'NULL' );
		$sessionKey = session_id();
		$ipAddress = mysql_escape_string ( $_SERVER['REMOTE_ADDR'] );
		$browser = mysql_escape_string ( $_SERVER['HTTP_USER_AGENT'] );
		$result = mysql_query ("Insert into session( session_key, referrer, ip_address, browser, start_time ) values( '$sessionKey', '$referrer', '$ipAddress', '$browser', NOW() )", $database);
		$_SESSION['dbSessionID'] = mysql_insert_id();
	}
	
	$page = mysql_escape_string ( $_SERVER['REQUEST_URI'] );
	$dbSessionID = $_SESSION['dbSessionID'];
	$result = mysql_query ("Insert into page_load( session_id, page, time ) values( '$dbSessionID', '$page', NOW() )", $database);
// Session Tracking Code END

	$_SESSION['pageHistory'][] = mysql_escape_string( $_SERVER['REQUEST_URI'] ); // add the current page to the history. Doesn't use the variable set for session tracking above to prevent dependency if the code is changed.
	
	$keys = array_keys ($_SESSION);
	foreach ($keys as $key) {
		$$key =& $_SESSION[$key];
	}
	$keys = array_keys ($_POST);
	foreach ($keys as $key) {
		$$key = $_POST[$key];
	}
	
?>