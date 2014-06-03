<?php
	#error_log("COOKIES=".print_r($_COOKIE,true));

	if (empty($_SESSION['Auth']['Customer'])) { 
		header ('Location: /account');
		exit();
	}
	$customer = (object)$_SESSION['Auth']['Customer'];
	$customerID = $customer->customer_id;
?>
