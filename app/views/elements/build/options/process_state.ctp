<?

	$catalogNumber = "";
	if (isset($_REQUEST['catalogNumber'])) { $catalogNumber = $_REQUEST['catalogNumber']; }
	else if (isset($_SESSION['Build']['catalog_number'])) { $catalogNumber = $_SESSION['Build']['catalog_number']; }

	#error_log("\n\n\n\nCL=$catalogNumber\n\n\n");
	

	$imageID = "";
	if (isset($_REQUEST['imageID'])) { $imageID = $_REQUEST['imageID']; }
	else if (isset($_SESSION['Build']['imageID'])) { $imageID = $_SESSION['Build']['imageID']; }

	$productCode = "";
	if (isset($_REQUEST['prod'])) { $productCode = $_REQUEST['prod']; }
	else if (isset($_REQUEST['productCode'])) { $productCode = $_REQUEST['productCode']; }
	else if (isset($_SESSION['Build']['productCode'])) { $productCode = $_SESSION['Build']['productCode']; }
	else if (isset($_SESSION['Build']['Product']['code'])) { $productCode = $_SESSION['Build']['Product']['code']; }
	#print_r($_SESSION['Build']);
	#exit(1);

	#error_log("PC=$productCode");

	if ( $catalogNumber )
	{
		#error_log("RESETTING...................................");
		$image = new Stamp();
		$image->initFromDB($catalogNumber, $database);
		$result = mysql_query ("Select * from stamp where catalog_number = '$catalogNumber'", $database);
		$stamp = mysql_fetch_object ($result);
		$stamp_array = get_object_vars($stamp);
		$_SESSION['Build']['catalog_number'] = $catalogNumber;
		$_SESSION['Build']['GalleryImage'] = $stamp_array;

	} else if ( $imageID ) {
		$catalogNumber="";
		$_SESSION['imageID'] = $imageID;
		$image = new CustomImage();
		if ( strpos($imageID, 't') !== false ) {
			$image->initFromArray($imageID);
		} else {
			$image->initFromDB($imageID, $database);
		}

		$imageResult = mysql_query ("Select * from custom_image where image_id = '$imageID'", $database);
		$image_array = mysql_fetch_assoc($imageResult);

		$_SESSION['Build']['imageID'] = $imageID;
		$_SESSION['Build']['CustomImage'] = $image_array;
	}
	if ( $productCode ) { 
		if ($productCode == 'BC')
			$productCode = 'B';
		if ($productCode == 'PSF'){
			$itemPosterFrame = "Yes";
			$productCode = 'PS';
		}
		$productResult = mysql_query ("Select * from product_type where code = '$productCode'", $database);
		$product = mysql_fetch_assoc($productResult);

		if ($product['is_stock_item']) 
		{
			$_SESSION['Build']['prod'] = null;
			$_SESSION['Build']['productCode'] = null;
			$_SESSION['Build']['Product'] = null;
			header("Location: /products/select");
			exit(0);
		}

		$_SESSION['Build']['productCode'] = $productCode;
		$_SESSION['Build']['Product'] = $product;
	} else { # No product selected.
		$errorMessages[] = "Please select what type of product you wish to build.";
		if ($imageID)
		{
			#header("Location: /custom/imageDisplay.php?imageID=$imageID");
		} else if ($catalogNumber) {
			#header("Location: /product/detail.php?catalogNumber=$catalogNumber");
		} else {
			#header("Location: /product/browse.php");
		}
		header("Location: /products/select");
		exit(0);
	}

	if ($_SESSION['Build']['Product']['available'] != 'yes')
	{
		$_SESSION['Build']['productCode'] = null;
		$_SESSION['Build']['Product'] = null;
		header("Location: /products/select");
		exit(0);
	}

?>
