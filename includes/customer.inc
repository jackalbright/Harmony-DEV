<?php
	$customer = null;
	if ( array_key_exists ('customerLogin', $_SESSION) && $_SESSION['customerLogin'] != '' ) {
		$customerID = $_SESSION['customerLogin'];
		$result = mysql_query ("Select * from customer where customer_id = $customerID", $database);
		if ( mysql_num_rows($result) == 1 ) {
			$customer = mysql_fetch_object($result);
		}
	}
?>