<?php
/******************************************************************************************
Edited by: John Plecenik
Last edited: 12/13/05
******************************************************************************************/
	session_start();
	if (!array_key_exists('UName', $_SESSION)){
		header ('Location: /admin38/index.php');
	} else {
		$manageOrders=$_SESSION['canManageOrders'];
		$manageParts=$_SESSION['canManageParts'];
		$manageUsers=$_SESSION['canManageUsers'];
		$manageItems=$_SESSION['canManageItems'];
		$manageEvents=$_SESSION['canManageEvents'];
		$manageDatabase=$_SESSION['canManageDatabase'];
		$manageTestimonials=$_SESSION['canManageTestimonials'];
	};
	if ($_SESSION['canManageOrders']!="Yes"){
		header ('Location: ../menu.php');
	};
?>
<?php
	include ('../../includes/admin.inc');
?>
<?php
// Get Invoice Number.
	$txtInvoice = explode(" ", $_REQUEST['txtInvoice']);
	
// Write header for the file to identify it as a text file that would be downloaded.
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=purchase_item.txt");

// Write first row (column headers) for the table.
	echo "Item Number\tItem Name\tBuy\tSell\tInventory\tAsset Acct\tIncome Acct\tExpense/COS Acct\tExpense/COS Acct\tItem Picture\tDescription\tUse Desc. On Sale\tCustom List 1\tCustom List 2\tCustom List 3\t";
	echo "Custom Field 1\tCustom Field 2\tCustom Field 3\tPrimary Vendor\tVendor Item Number\tTax When Bought\tBuy Unit Measure\t# Items/Buy Unit\tReorder Quantity\Minimum Level\tSelling Price\tSell Unit Measure\tTax When Sold\t# Items/Sell Unit\t";
	echo "Quantity Break 1\tQuantity Break 2\tQuantity Break 3\tQuantity Break 4\tQuantity Break 5\tPrice Level A, Qty Break 1\tPrice Level B, Qty Break 1\tPrice Level C, Qty Break 1\tPrice Level D, Qty Break 1\tPrice Level E, Qty Break 1\tPrice Level F, Qty Break 1\t";
	echo "Price Level A, Qty Break 2\tPrice Level B, Qty Break 2\tPrice Level C, Qty Break 2\tPrice Level D, Qty Break 2\tPrice Level E, Qty Break 2\tPrice Level F, Qty Break 2\tPrice Level A, Qty Break 3\tPrice Level B, Qty Break 3\tPrice Level C, Qty Break 3\tPrice Level D, Qty Break 3\tPrice Level E, Qty Break 3\tPrice Level F, Qty Break 3\t";
	echo "Price Level A, Qty Break 4\tPrice Level B, Qty Break 4\tPrice Level C, Qty Break 4\tPrice Level D, Qty Break 4\tPrice Level E, Qty Break 4\tPrice Level F, Qty Break 4\tPrice Level A, Qty Break 5\tPrice Level B, Qty Break 5\tPrice Level C, Qty Break 5\tPrice Level D, Qty Break 5\tPrice Level E, Qty Break 5\tPrice Level F, Qty Break 5\tInactive Item\tFreight Amount\r";

foreach($txtInvoice as $invoice) {

// Pull the items for the particular invoice number.
	$productName="";
	$title="";
	$stampID="";
	$imageID="";
	$txtSurchargeNeeded = "False";
	$surcharge[0]=0;
	$surcharge[1]=0;
	$surcharge[2]=0;
	$surcharge[3]=0;
	include ('../../includes/database.inc');
    $txtQueryString = "SELECT order_item_id, product_type_id, specialID, Price, Quantity, reproduction FROM order_item WHERE Purchase_ID='$invoice'";
    $result = mysql_query ($txtQueryString, $database); 
	while ($row = mysql_fetch_object($result)){
		$orderItemID=$row->order_item_id;
		$productTypeID=$row->product_type_id;
		$productSpecialID=$row->specialID;
		$productPrice=$row->Price;
		$productQuantity=$row->Quantity;
		if ($row->reproduction=="Yes"){
			$prefix = "R-";
			$suffix = " (repro)";
		} else {
			$prefix = "";
			$suffix = "";
		};
		// Pull the product_type
		$txtQueryString2 = "SELECT code, name, income_acct, cust_invoice_acct, stamp FROM product_type WHERE product_type_id='$productTypeID'";
	    $result2 = mysql_query ($txtQueryString2, $database); 
		while ($row2 = mysql_fetch_object($result2)){
			$productCode=$row2->code;
			$productName=$row2->name;
			$productIncomeAcct=$row2->income_acct;
			$productCustomAcct=$row2->cust_invoice_acct;
			$productType=$row2->stamp;
		};
		// if special item, pull special item code
		if ($productSpecialID!=""){
		    $txtQueryString3 = "SELECT code, title FROM specialItem WHERE SpecialID='$productSpecialID'";
		    $result3 = mysql_query ($txtQueryString3, $database); 
			while ($row3 = mysql_fetch_object($result3)){
				$productCode=$prefix . $productCode . $row3->code;
				$productName=$row3->title;
			};
		};
		//pull necessary info from item parts table
		$txtQueryString4 = "SELECT pinStyle, ImageID, stampNumber, Charm_ID FROM item_parts WHERE order_Item_ID='$orderItemID'";
	    $result4 = mysql_query ($txtQueryString4, $database); 
		while ($row4 = mysql_fetch_object($result4)){
			$pinStyle=$row4->pinStyle;
			$imageID=$row4->ImageID;
			if ($imageID!=""){
				$productIncomeAcct=$productCustomAcct;
			};
			$itemCharmID = $row4->Charm_ID;
			$stampID=$row4->stampNumber;
		};
		if ($itemCharmID != "") {
			$txtQueryString5 = "SELECT name FROM charm WHERE charm_id='$itemCharmID'";
		    $result5 = mysql_query ($txtQueryString5, $database); 
			while ($row5 = mysql_fetch_object($result5)){
				$title=$row5->name;
			};
		}
		if ($imageID!=""){
			$txtQueryString5 = "SELECT Title FROM custom_image WHERE Image_ID='$imageID'";
		    $result5 = mysql_query ($txtQueryString5, $database); 
			while ($row5 = mysql_fetch_object($result5)){
				$title="Custom Image";
			};
		};
		if ($stampID!=""){
			$txtQueryString6 = "SELECT stamp_name FROM stamp WHERE catalog_number='$stampID'";
		    $result6 = mysql_query ($txtQueryString6, $database); 
			while ($row6 = mysql_fetch_object($result6)){
				$title=$row6->stamp_name . $suffix;
			};
			$txtQueryString6a = "SELECT per1, per12, per50, per100 FROM stamp_surcharge WHERE Catalog_number='$stampID'";
		    $result6 = mysql_query ($txtQueryString6, $database); 
			if ($result6) {
				while ($row6 = mysql_fetch_object($result6)){
					$surcharge[0]=$row6->per1;
					$surcharge[1]=$row6->per12;
					$surcharge[2]=$row6->per50;
					$surcharge[3]=$row6->per100;
				};
			} else {
				$surcharge[0]=0;
				$surcharge[1]=0;
				$surcharge[2]=0;
				$surcharge[3]=0;
			};
		};
		
		// pull prices from the database.
		if ($productSpecialID==""){
			$txtQueryString7 = "SELECT per1, per12, per50, per100 FROM price WHERE product_code='$productCode'";
		    $priceBreak=array(1, 11, 49, 99); 
		    $result7 = mysql_query ($txtQueryString7, $database); 
			while ($row7 = mysql_fetch_object($result7)){
				$priceAmt[0]=sprintf("%01.2f",$productPrice);#row7->per1);
				$priceAmt[1]=sprintf("%01.2f",$productPrice);#row7->per12);
				$priceAmt[2]=sprintf("%01.2f",$productPrice);#row7->per50);
				$priceAmt[3]=sprintf("%01.2f",$productPrice);#row7->per100);
				$priceSurcharge[0]=sprintf("%01.2f",$productPrice+$surcharge[0]);#row7->per1 + $surcharge[0]);
				$priceSurcharge[1]=sprintf("%01.2f",$productPrice+$surcharge[1]);#row7->per12 + $surcharge[1]);
				$priceSurcharge[2]=sprintf("%01.2f",$productPrice+$surcharge[2]);#row7->per50 + $surcharge[2]);
				$priceSurcharge[3]=sprintf("%01.2f",$productPrice+$surcharge[3]);#row7->per100 + $surcharge[3]);
			};
		} else {
			$txtQueryString7 = "SELECT quantity, price FROM specialPricePoint WHERE specialID='$productSpecialID' limit 0,4";
		    for ($i=0; $i<4; $i++){
				$priceAmt[$i]="";
				$priceBreak[$i]="";
				$priceA[$i]="";
			};
			$i=0;
			$result7 = mysql_query ($txtQueryString7, $database); 
			while ($row7 = mysql_fetch_object($result7)){
				$priceBreak[$i]=$row7->quantity;
				$priceAmt[$i]=sprintf("%01.2f",$row7->price);
				$i++;
			};
		};
		$priceBreak[0] = 0;
		if ($priceBreak[3]==100){
			for ($i=0; $i<count($priceBreak); $i++){	
				$priceA[$i]=$priceAmt[3];
			};
		} else {
			for ($i=0; $i<count($priceBreak); $i++){	
				if ($priceAmt[$i]!=""){
					$priceA[$i]=$priceAmt[0];
				};
			};
		};
		// Put together Item Code and description
		if ($pinStyle=="Tie Tack"){
			$productCode = "TT";
			$productIncomeAcct = "42113";
		};
		$itemNumber="";
		$itemName="";
		if ($prefix=="R-"){
			$txtSurchargeNeeded="False";
		};
		if ($productCode=="PR"){
			$title="";
		};
		$itemNumber=$prefix . $itemNumber . $productCode;
		if ($productCode=="CH"){
			$itemNumber .= $itemCharmID; 
		};
		if ($imageID != ""){
			$itemNumber = $itemNumber . "CustomImage";
		} else {
			$itemNumber = $itemNumber . $stampID;
		};
		$itemName = $title . " " . $productName;
		if ($productCode=="CH"){
			$itemName = $title . " " . $productName;
		};
    $txtQueryStringSC = "SELECT Shipping_Cost FROM purchase WHERE purchase_ID='$invoice'";
    $resultSC = mysql_query($txtQueryStringSC, $database); 
    while ($shippingCost = mysql_fetch_array($resultSC)) {
    $freightAmount = $shippingCost[Shipping_Cost];
    };
		// Write line
		echo "$itemNumber\t$itemName\t\tS\t\t\t$productIncomeAcct\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t$productPrice\tea.\t\t1\t$priceBreak[0]\t$priceBreak[1]\t$priceBreak[2]\t$priceBreak[3]\t\t$priceA[0]\t\t$priceAmt[0]\t\t\t\t$priceA[1]\t\t$priceAmt[1]\t\t\t\t$priceA[2]\t\t$priceAmt[2]\t\t\t\t$priceA[3]\t\t$priceAmt[3]\t\t\t\t\t\t\t\t\t\tN\t$freightAmount\r";
	};
	
} // Close foreach loop
?>