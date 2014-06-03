<?php
/******************************************************************************************
Edited by: John Plecenik
Last edited: 11/04/2004
******************************************************************************************/
	session_start();
	if ( array_key_exists('UName', $_SESSION) ) {
		if ($_SESSION['canManageOrders']!="Yes"){
			header ('Location: ../menu.php');
			exit(0);
		} else {
			$manageOrders=$_SESSION['canManageOrders'];
			$manageParts=$_SESSION['canManageParts'];
			$manageUsers=$_SESSION['canManageUsers'];
			$manageItems=$_SESSION['canManageItems'];
			$manageEvents=$_SESSION['canManageEvents'];
			$manageDatabase=$_SESSION['canManageDatabase'];
			$manageTestimonials=$_SESSION['canManageTestimonials'];
		}
	} else {
		header ('Location: /admin38/index.php');
		exit(0);
	}
	
	include_once ('../../includes/admin.inc');
	include_once ('../../includes/database.inc');

// Create product part lookup arrays
	$productInfo = array();
	$result = mysql_query ("SELECT * FROM product_type", $database);
	while ($temp = mysql_fetch_object($result) ) {
		$productInfo[$temp->product_type_id] = $temp;
	}
	$ribbonColors = array();
	$result = mysql_query ("Select * from ribbon", $database);
	while ($temp = mysql_fetch_object($result) ) {
		$ribbonColors[$temp->ribbon_id] = $temp->color_name;
	}
	$tasselColors = array();
	$result = mysql_query ("Select * from tassel", $database);
	while ($temp = mysql_fetch_object($result) ) {
		$tasselColors[$temp->tassel_id] = $temp->color_name;
	}
	$charmNames = array();
	$result = mysql_query ("Select * from charm", $database);
	while ($temp = mysql_fetch_object($result) ) {
		$charmNames[$temp->charm_id] = $temp->name;
	}
	$frameNames = array();
	$result = mysql_query ("Select * from frame", $database);
	while ($temp = mysql_fetch_object($result) ) {
		$frameNames[$temp->frame_id] = $temp->name;
	}
	$borderNames = array();
	$result = mysql_query ("Select * from border", $database);
	while ($temp = mysql_fetch_object($result) ) {
		$borderNames[$temp->border_id] = $temp->name;
	}

// extract dates from GET variable and concatenate into mySQL compatible date strings
	$startDate= $_GET['txtStartYear'] . '-' . $_GET['txtStartMonth'] . '-' . $_GET['txtStartDay'];
	$endDate= $_GET['txtEndYear'] . '-' . $_GET['txtEndMonth'] . '-' . $_GET['txtEndDay'];


// determine how many dates were entered and construct appropriate WHERE clause for mySQL query
	if ( $startDate == '0000-00-00' && $endDate == '0000-00-00' ) {
		$sqlDateCheck = "Order_Date = \'" . date('m-d-Y') . "\'" ;
	} else if ( $startDate == '0000-00-00' ) {
		$sqlDateCheck = "Order_Date = '$endDate'";
	} else if ( $endDate == '0000-00-00' ) {
		$sqlDateCheck = "Order_Date = '$startDate'";
	} else {
		$sqlDateCheck = "Order_Date BETWEEN '$startDate' AND '$endDate'";
	}
	$result = mysql_query ("SELECT * FROM purchase WHERE $sqlDateCheck", $database);
	$orders = array();
	while ( $temp = mysql_fetch_object($result) ) {
		$orders[$temp->purchase_id] = $temp;
	}


	$customers = array();
	$shippingAddresses = array();
	$billingAddresses = array();
	$creditCards = array();
	$items = array();
	$itemParts = array();
	$stamps = array();
	$quotes = array();
	
	foreach ($orders as $orderID=>$order) {
		$result = mysql_query ("SELECT * FROM customer WHERE customer_id=$order->Customer_ID", $database);
		$customers[$orderID] = mysql_fetch_object($result);
		
		$result = mysql_query ("SELECT * FROM contact_info WHERE Contact_ID=$order->Billing_ID", $database);
		$billingAddresses[$orderID] = mysql_fetch_object($result);
		
		$result = mysql_query ("SELECT  * FROM contact_info WHERE Contact_ID=$order->Shipping_ID", $database);
		$shippingAddresses[$orderID] = mysql_fetch_object($result);

		$result = mysql_query ("SELECT *  FROM credit_card WHERE credit_card_id=$order->Credit_Card_ID", $database);
		$creditCards[$orderID] = mysql_fetch_object($result);
		
		$result = mysql_query ("SELECT *  FROM order_item WHERE purchase_id=$orderID", $database);
		$orderItems = array();
		while ($temp = mysql_fetch_object($result) ) {
			$orderItems[$temp->order_item_id] = $temp;
		}
		$items[$orderID] = $orderItems;
		
		foreach ($orderItems	as $itemID=>$item ) {
			$result = mysql_query ("SELECT *  FROM item_parts WHERE order_item_ID=$itemID", $database);
			$parts = mysql_fetch_object($result);
			$itemParts[$itemID] = $parts;
			if ( isset($parts->quote_id) && $parts->quote_id != '' ) {
				$result = mysql_query ("Select * from quote where quote_id = $parts->quote_id", $database);
				$quotes[$itemID] = mysql_fetch_object($result);
			}
			if ( isset ($parts->stampNumber) && $parts->stampNumber != '' ) {
				$result = mysql_query ("Select stamp_name from stamp where catalogNumber = $parts->stampNumber", $database);
				$temp = mysql_fetch_object($result);
				$stamps[$itemID] = $temp->stamp_name;
			}
		}

	}
	mysql_close ($database);

	header("Content-type: text/tab-separated-values");
	header("Content-Disposition: attachment; filename=dailyreport.txt");
	echo "Co./Last Name\tFirst Name\tAddr 1 - Line 1\t           - Line 2\t           - Line 3\t           - Line 4\tInvoice #\tDate\tCustomer PO\tShip Via\tAlready Printed\tItem Number\tQuantity\tDescription\tPrice\tDiscount\tTotal\tJob\tComment\tJournal Memo\tSalesperson Last Name\tSalesperson First Name\tShipping Date\tTax Code\tTax Amount\tFreight Amount\tTax on Freight\tFreight Tax Amount\tSale Status\tCurrency Code\tExchange Rate\tTerms - Payment is Due\t           - Discount Days\t           - Balance Due Days\t           - % Discount\t           - % Monthly Charge\tReferral Source\tAmount Paid\tPayment Method\tPayment Notes\tName on Card\tCard Number\tExpiration Date\tAddress (AVS)\tZIP (AVS)\tCard Verification (CVV2)\tAuthorization Code\tCheck Number\tCategory\r\n";
	foreach ($items as $orderID=>$orderItems) {
		$customer = $customers[$orderID];
		$shipping = $shippingAddresses[$orderID];
		$billing = $billingAddresses[$orderID];
		$creditCard = $creditCards[$orderID];
		foreach ($orderItems as $itemID=>$item) {
			$parts = $itemParts[$itemID];
			echo $customer->Company . ' ' . $customer->Last_Name; // Co./Last Name
			echo "\t";
			echo $customer->First_Name; // First Name
			echo "\t";
			// Addr 1 - Line 1
			echo "\t";
			//            - Line 2
			echo "\t";
			//            - Line 3
			echo "\t";
			//            - Line 4
			echo "\t";
			// Invoice #
			echo "\t";
			// Date
			echo "\t";
			// Customer PO
			echo "\t";
			// Ship Via
			echo "\t";
			// Already Printed
			echo "\t";
			// Item Number
			echo "\t";
			// Quantity
			echo "\t";
			// Description
			echo "\t";
			// Price
			echo "\t";
			// Discount
			echo "\t";
			// Total
			echo "\t";
			// Job
			echo "\t";
			// Comment
			echo "\t";
			// Journal Memo
			echo "\t";
			// Salesperson Last Name
			echo "\t";
			// Salesperson First Name
			echo "\t";
			// Shipping Date
			echo "\t";
			// Tax Code
			echo "\t";
			// Tax Amount
			echo "\t";
			// Freight Amount
			echo "\t";
			// Tax on Freight
			echo "\t";
			// Freight Tax Amount
			echo "\t";
			// Sale Status
			echo "\t";
			// Currency Code
			echo "\t";
			// Exchange Rate
			echo "\t";
			// Terms - Payment is Due
			echo "\t";
			//            - Discount Days
			echo "\t";
			//            - Balance Due Days
			echo "\t";
			//            - % Discount
			echo "\t";
			//            - % Monthly Charge
			echo "\t";
			// Referral Source
			echo "\t";
			// Amount Paid
			echo "\t";
			// Payment Method
			echo "\t";
			// Payment Notes
			echo "\t";
			// Name on Card
			echo "\t";
			// Card Number
			echo "\t";
			// Expiration Date
			echo "\t";
			// Address (AVS)
			echo "\t";
			// ZIP (AVS)
			echo "\t";
			// Card Verification (CVV2)
			echo "\t";
			// Authorization Code
			echo "\t";
			// Check Number
			echo "\t";
			// Category
			echo "\r\n";
		}
	}
?>
