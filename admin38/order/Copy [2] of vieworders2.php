<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 3/10/04
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
<?
	$purchaseID=$_GET['purchaseID'];
	// Get Purchase ID and Recalculate Order if Necessary
	if (array_key_exists('purchaseID', $_GET)){
		$purchaseID=$_GET['purchaseID'];
		$txtUpdate="false";
	} elseif (array_key_exists('hdnPurchaseID', $_POST)){
		$purchaseID=$_POST['hdnPurchaseID'];
		$txtShipper=$_POST['txtShipper'];
		$txtTrackingNumber=$_POST['txtTrackingNumber'];
		$txtOrderStatus=$_POST['txtOrderStatus'];
		$cbCancel=(array)$_POST['cbCancel'];
		$txtUpdate="true";
		include ('../../includes/database.inc');
		$result = mysql_query ("UPDATE order_item SET accepted='Yes' WHERE purchase_id=$purchaseID", $database); 	
		mysql_close($database);
		foreach ($cbCancel as $value){
			include ('../../includes/database.inc');
			$result = mysql_query ("UPDATE order_item SET accepted='No' where order_item_id=$value", $database); 	
			mysql_close($database);
		};
// Get information for Shipping Cost Recalc
	include ('../../includes/database.inc');
	$orderWeight=0;
	$result = mysql_query ("SELECT order_item.Quantity, product_type.weight FROM order_item, product_type WHERE order_item.purchase_id='$purchaseID' AND product_type.product_type_id = order_item.product_type_id", $database); 	
	while ($row = mysql_fetch_object($result)){
		$orderWeight += ($row->Quantity * $row->weight);
	};
	mysql_close($database);
		
	}; 

// Pull in general order information.
	include ('../../includes/database.inc');
	$result = mysql_query ("SELECT purchase.Order_Date, purchase.Order_Status, purchase.Shipping_ID, purchase.Customer_ID, shippingMethod.name as Ship_ID, purchase.Credit_Card_ID, purchase.Billing_ID, purchase.Shipping_Cost, purchase.order_comment, purchase.shipper, purchase.tracking_number FROM purchase, shippingMethod WHERE purchase.purchase_id='$purchaseID' and purchase.shipping_Method = shippingMethod.shippingMethodID", $database); 	
	while ($event = mysql_fetch_object($result)){
		$orderdate=$event->Order_Date;
		$orderstatus=$event->Order_Status;
		$shippingmethod=$event->Ship_ID;
		$customerID=$event->Customer_ID;
		$shippingID=$event->Shipping_ID;
		$creditCardID=$event->Credit_Card_ID;
		$billingID=$event->Billing_ID;
		$shippingCost=$event->Shipping_Cost;
		$orderComment=$event->order_comment;
		$txtShipper=$event->shipper;
		$txtTrackingNumber=$event->tracking_number;
	};
	mysql_close($database);

// Pull in Shipping Address
	include ('../../includes/database.inc');
	$result = mysql_query ("SELECT contact_ID, Address_1, Address_2, In_Care_Of, City, State, Zip_Code, Country FROM contact_info WHERE contact_id='$shippingID'", $database); 	
	while ($row = mysql_fetch_object($result)){
		$shipAddress1=$row->Address_1;
		$shipAddress2=$row->Address_2;
		$shipInCareOf=$row->In_Care_Of;
		$shipCity=$row->City;
		$shipState=$row->State;
		$shipZipCode=$row->Zip_Code;
		$shipCountry=$row->Country;
	};
	mysql_close($database);

//Pull in Customer Information
	include ('../../includes/database.inc');
	$result2 = mysql_query ("SELECT First_Name, Last_Name, Company, Phone, eMail_Address FROM customer WHERE customer_id='$customerID'", $database);
	while ($row2 = mysql_fetch_object($result2)){
		$customerFirstName=$row2->First_Name;
		$customerLastName=$row2->Last_Name;
		$customerCompany=$row2->Company;
		$customerPhone=$row2->Phone;
		$customerEmail=$row2->eMail_Address;
	};
	mysql_close($database);	

//Pull in Billing Address
	include ('../../includes/database.inc');
	$result = mysql_query ("SELECT contact_ID, Address_1, Address_2, In_Care_Of, City, State, Zip_Code, Country FROM contact_info WHERE contact_id='$billingID'", $database); 	
	while ($row = mysql_fetch_object($result)){
		$billAddress1=$row->Address_1;
		$billAddress2=$row->Address_2;
		$billInCareOf=$row->In_Care_Of;
		$billCity=$row->City;
		$billState=$row->State;
		$billZipCode=$row->Zip_Code;
		$billCountry=$row->Country;
	};
	mysql_close($database);

//Pull in Credit Card information
	include ('../../includes/database.inc');
	$result = mysql_query ("SELECT card_type, cardholder, number, expiration FROM credit_card WHERE credit_card_id='$creditCardID'", $database); 	
	while ($row = mysql_fetch_object($result)){
		$txtCardType=$row->card_type;
		$txtCardHolder=$row->cardholder;
		$txtCardNumber=$row->number;
		$txtCardExpiration=$row->expiration;
	};
	mysql_close($database);
	
//Pull in All Basic Order Items	
	include ('../../includes/database.inc');
	$result = mysql_query ("SELECT order_item_id, Quantity, Price, product_type_id, specialID, comments, accepted FROM order_item WHERE purchase_id='$purchaseID'", $database); 	
	while ($row = mysql_fetch_object($result)){
		$itemID[]=$row->order_item_id;
		$itemQuantity[]=$row->Quantity;
		$itemPrice[]=$row->Price;
		$itemTypeID[]=$row->product_type_id;
		if ($row->specialID != ""){
			include ('../../includes/database.inc');
			$result2 = mysql_query ("SELECT code, title FROM specialItem WHERE specialID='$row->specialID'", $database); 	
			while ($row2 = mysql_fetch_object($result2)){
				$itemCode[]=$row2->code . "-";
				$itemName[]=$row2->title;
			};				
		} else {
			$itemCode[]="";
			$itemName[]="";
		};
		$itemComment[]=$row->comments;
		$itemTotal[]=$row->Quantity * $row->Price;
		$txtAccepted[]=$row->accepted;
	};
	mysql_close($database);

//Pull in Individual Item Information for each Item
	foreach ($itemID as $key=>$value){
		include ('../../includes/database.inc');
		$result = mysql_query ("SELECT code, name, weight FROM product_type WHERE product_type_id='$itemTypeID[$key]'", $database); 	
		while ($row = mysql_fetch_object($result)){
			$itemCode[$key]=$itemCode[$key] . $row->code;
			if ($itemName[$key]==""){
				$itemName[$key]=$row->name;
			};
			$itemWeight[$key]=$row->weight * $itemQuantity[$key];
		};
		mysql_close($database);
		include ('../../includes/database.inc');
		$result = mysql_query ("SELECT parts_id, order_Item_ID, imageID, ribbon_ID, tassel_ID, charm_ID, quote_ID, border_ID, custom_quote, personalization, stampNumber, frameID, pinStyle, reproductionStamp, personalizationStyle FROM item_parts WHERE order_item_id=$itemID[$key]", $database); 	
		while ($row = mysql_fetch_object($result)){
			$itemCustomImageID[$key]=$row->imageID;
			$itemRibbonID[$key]=$row->ribbon_ID;
			$itemTasselID[$key]=$row->tassel_ID;
			$itemCharmID[$key]=$row->charm_ID;
			$itemQuoteID[$key]=$row->quote_ID;
			$itemBorderID[$key]=$row->border_ID;
			$itemCustomQuote[$key]=nl2br($row->custom_quote);
//			$itemCustomQuote[$key]=htmlentities($itemCustomQuote[$key]);
			$itemPersonalization[$key]=nl2br($row->personalization);
//			$itemPersonalization[$key]=htmlentities($itemPersonalization[$key]);
			$itemStampID[$key]=$row->stampNumber;
			$itemFrameID[$key]=$row->frameID;
			$itemPinStyle[$key]=$row->pinStyle;
			$stampReproduction[$key]=$row->reproductionStamp;
			$personalizationStyle[$key]=$row->personalizationStyle;
		};
		mysql_close($database);
//Get Custom Image Information for Item
		if ($itemCustomImageID[$key]!=""){
			include ('../../includes/database.inc');
			$result = mysql_query ("SELECT Image_ID, thumbnail_location, Approved, Image_Location, Title FROM custom_image WHERE image_id='$itemCustomImageID[$key]'", $database); 	
			while ($row = mysql_fetch_object($result)){
				$itemPictureID[$key]="CI#".$row->Image_ID;
				$itemStampName[$key]=$row->Title;
				$itemImageName[$key]="<B>Custom Image Number:</B> " . $row->Image_ID . " <BR><B>Approved:</B> <A HREF='../part/approvecustom3.php?image_id=" . $row->Image_ID . "' target='_Blank'>" . $row->Approved . "</a><BR>";
				if ($row->Image_Location){
					$itemImageLocationPrefix = "<a href=\"../.." . $row->Image_Location . "\" target=\"_blank\">";
					$itemImageLocationSuffix = "</a>";
				} else {
					$itemImageLocationPrefix = "";
					$itemImageLocationSuffix = "";
				};
				$itemImageLocation[$key]= $itemImageLocationPrefix . "<img src=\"../.." . $row->thumbnail_location . "\"/>" . $itemImageLocationSuffix;
			};
			mysql_close($database);
		};
// Get Stamp Info for Item
		if ($itemStampID[$key]!=""){
			include ('../../includes/database.inc');
			$result = mysql_query ("SELECT stamp_name, thumbnail_location FROM stamp WHERE catalog_number='$itemStampID[$key]'", $database); 	
			while ($row = mysql_fetch_object($result)){
				$itemPictureID[$key]=$itemStampID[$key];
				$itemStampName[$key]=$row->stamp_name;
				$itemImageName[$key]="<B>Stamp Number:</B> " . $row->stamp_name . " ($itemStampID[$key])<BR>";
				$itemImageLocation[$key]="<img src=\"../../" . $row->thumbnail_location . "\"/>";
			};
			mysql_close($database);
		};

// Get Ribbon Info for Item
		if ($itemRibbonID[$key]!=""){
			include ('../../includes/database.inc');
			$result = mysql_query ("SELECT color_name FROM ribbon WHERE ribbon_id='$itemRibbonID[$key]'", $database); 	
			while ($row = mysql_fetch_object($result)){
				$itemRibbonColor[$key]="<b>Ribbon:</b> " . $row->color_name . "<BR>";
			};
			mysql_close($database);
		} else {
			$itemRibbonColor[$key]="";
		};

//Get Tassel Info for Item
		if ($itemTasselID[$key]!=""){
			include ('../../includes/database.inc');
			$result = mysql_query ("SELECT color_name FROM tassel WHERE tassel_id='$itemTasselID[$key]'", $database); 	
			while ($row = mysql_fetch_object($result)){
				$itemTasselColor[$key]=$row->color_name;
			};
			mysql_close($database);
		} else {
			$itemTasselColor[$key]="";
		};

//Get Charm Info for Item
		if ($itemCharmID[$key]!=""){
			include ('../../includes/database.inc');
			$result = mysql_query ("SELECT name FROM charm WHERE charm_id='$itemCharmID[$key]'", $database); 	
			while ($row = mysql_fetch_object($result)){
				$itemCharmName[$key]="<B>Charm:</B> " . $row->name . "<BR>";
			};
			mysql_close($database);
		} else {
			$itemCharmName[$key]="";
		};

//Get Border Info for Item
		if ($itemBorderID[$key]!=""){
			include ('../../includes/database.inc');
			$result = mysql_query ("SELECT name FROM border WHERE border_id='$itemBorderID[$key]'", $database); 	
			while ($row = mysql_fetch_object($result)){
				$itemBorderName[$key]="<B>Border:</B>" . $row->name . "<BR>";
			};
			mysql_close($database);
		} else {
			$itemBorderName[$key]="";
		};

//Get Frame Info for Item
		if ($itemFrameID[$key]!=""){
			include ('../../includes/database.inc');
			$result = mysql_query ("SELECT name FROM frame WHERE frame_id='$itemFrameID[$key]'", $database); 	
			while ($row = mysql_fetch_row($result)){
				$itemFrameName[]="<b>Frame</b>: $row[0]<BR>";
			};
			mysql_close($database);
		} else {
			$itemFrameName[]="";
		};

// Get Quote Info for Item
		if ($itemQuoteID[$key]!=""){
			include ('../../includes/database.inc');
			$result = mysql_query ("SELECT text, title, attribution, use_quote_marks FROM quote WHERE quote_id='$itemQuoteID[$key]'", $database); 	
			while ($row = mysql_fetch_object($result)){
				$addMarks="";
				if ($row->use_quote_marks=="yes"){
					$addMarks="&quot;";
				};
				$quoteBody=nl2br($row->text);
				$itemQuote[]="<B>QUOTE:</B> <B>$row->title</B> $addMarks $quoteBody $addMarks <I>$row->attribution</I><BR>";
			};
			mysql_close($database);
		} else {
			$itemQuote[]="";
		};

	};

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>View Purchase Orders</title>
		<style type="text/css" media="screen"><!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; line-height: normal; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
--></style>
<?php
		echo "<script language=\"javascript\" type=\"text/javascript\">";
		echo "function recalcTotal(){";
		echo "location.href=\"vieworders2.php?purchaseID=$purchaseID\";};";
		echo "</script>";
?>
	</head>

	<body bgcolor="#ffffff">
		<table width="700" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" width="200">
					<div align="center">
						<img src="../hdlogo.gif" alt="" height="78" width="160" border="0"></div>
				</td>
				<td valign="bottom">
					<div align="center">
						<span class="title">View Purchase Orders</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title style1">Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
				      <a href="menu.php">Back to Order Menu</a></p>
			  </td>
				<td>
					<div align="center">
						<table width="450" border="0" cellspacing="2" cellpadding="0">
							<tr>
								<td valign="top" width="50%">
									<h2><b><font color="purple">Order Number: <?php echo "$purchaseID"; ?></font></b></h2><p>
									<h3><B>Date:  <?php echo "$orderdate"; ?></b></h3></P>
								</td>
								<td valign="top"></td>
							</tr>
							<tr>
								<td valign="top" width="50%">
									<h3><b>Shipping to:</b></h3>
									<p><?php
										if ($customerCompany!=""){
										  echo "$customerCompany<br>";
										};
										if ($shipInCareOf!=""){
										  echo "ATTN: $shipInCareOf<br>";
										} else {
										  echo "ATTN: $customerFirstName $customerLastName<BR>";
										};
										echo "$shipAddress1<BR>$shipAddress2<BR>$shipCity, $shipState $shipZipCode<BR>$shipCountry<BR>$customerPhone<BR><a href=\"mailto:$customerEmail\">$customerEmail</a>";
									
									?>
									</p>
								</td>
								<td valign="top">
									<h3>Billing to:</h3>
									<p><?php
										if ($customerCompany!=""){
										  echo "$customerCompany<br>";
										};
										if ($customerInCareOf!=""){
										  echo "ATTN: $billInCareOf<br>";
										} else {
										  echo "ATTN: $customerFirstName $customerLastName<BR>";
										};
										echo "$billAddress1<BR>$billAddress2<BR>$billCity, $billState $billZipCode<BR>$billCountry<BR>$customerPhone<BR><a href=\"mailto:$customerEmail\">$customerEmail</a>";
									?>
									</p>
								</td>
							</tr>
							<tr>
								<td valign="top" width="50%">
									<h3>Shipping Method:</h3>
									<P><?php echo $shippingmethod; ?></P>
								</td>
								<td valign="top"></td>
							</tr>
							<tr>
								<td valign="top" width="50%">
									<h3>Payment Method:</h3>
									<p><?php
										echo "<B>Card Type:</B>  $txtCardType<BR>";
										echo "<B>Cardholder: </b> $txtCardHolder<BR>";
										echo "<B>Number:</B>  $txtCardNumber<BR>";
										echo "<B>Expires:</B>  $txtCardExpiration<BR>";
									?></p>
								</td>
								<td valign="top"></td>
							</tr>
							<tr>
								<td valign="top" width="50%">
									<h3>Items in Order:</h3>
								</td>
								<td valign="top"></td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
		<table width="100%" border="1" cellspacing="2" cellpadding="0">
			<tr>
				<td width="5%">
					<h4>Qty.</h4>
				</td>
				<td width="63%">
					<h4>Description</h4>
				</td>
				<td width="12%">
					<h4>Image</h4>
				</td>
				<td width="10%">
					<h4>Price Ea.</h4>
				</td>
				<td width="10%">
					<h4>Ext. Price</h4>
				</td>
			</tr>
			<?php
				foreach ($itemTypeID as $key=>$value){	
					if ($itemStampID[$key]==""){
						$itemFirstName="Custom";
					} else {
						$itemFirstName=$itemStampName[$key];
					};
					if ($itemCode[$key]=="TA"){
						$itemFirstName=$itemTasselColor[$key];
					};
			?>
			<tr>
				<td valign="top"><?php echo $itemQuantity[$key]; ?><br></td>
				<td valign="top">
				
				<b>Name:</b> <?php echo "$itemStampName[$key] $itemName[$key]"; ?><br>
				<b>Catalog:</b> <?php echo "$itemCode[$key]-$itemPictureID[$key]"; ?><BR>
				<?php
					if ($itemRibbonID[$key]!=""){
						echo "$itemRibbonColor[$key]";
					};
					if ($itemTasselID[$key]!=""){
						echo "<B>Tassel:</b> $itemTasselColor[$key]<BR>";
					};
					if ($itemCharmID[$key]!=""){
						echo "$itemCharmName[$key]";
					};
					if ($itemQuoteID[$key]!=""){
						echo "$itemQuote[$key]";
					};
					if ($itemCustomQuote[$key]!=""){
						echo "<B>CUSTOM QUOTE:</b>  $itemCustomQuote[$key]<BR>";
					};
					if ($itemPersonalization[$key]!=""){
						echo "<B>Personalization:</b>  $itemPersonalization[$key] ($personalizationStyle[$key])<BR>";
					};
					if ($itemBorderID[$key]!=""){
						echo "$itemBorderName[$key]";
					};
					if ($itemFrameID[$key]!=""){
						echo "$itemFrameName[$key]";
					};
					if ($itemPinStyle[$key]!=""){
						echo "<b>Pin Style:</b>  $itemPinStyle[$key]<BR>";
					};
					echo $itemImageName[$key];
					if ($itemComment[$key]!=""){
						echo "<BR><BR><B>Item Comments:</b>  <i>$itemComment[$key]</i><BR>";
					};
				?>
				</td>
				<td valign="top" width="12%">
				<?php echo $itemImageLocation[$key];?>
				</td>
				<td valign="top" width="10%"><?php echo "\$".sprintf("%01.2f", $itemPrice[$key]); ?></td>
				<td valign="top" width="10%"><?php echo "\$".sprintf("%01.2f", $itemTotal[$key]); ?></td>
			</tr>
			<?php
				};
			?>
			<tr>
				<td></td>
				<td></td>
				<td colspan="2">
					<div align="right">
						<b>Sub-Total:</b></div>
				</td>
				<td width="10%"><?php echo "\$".sprintf("%01.2f", array_sum($itemTotal)); ?></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td colspan="2">
					<div align="right">
						<b>Shipping:</b></div>
				</td>
				<td width="10%"><?php echo"\$".sprintf("%01.2f", $shippingCost); ?></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td colspan="2">
					<div align="right">
						<b>Total:</b></div>
				</td>
				<td width="10%">
					<?php
						$total=array_sum($itemTotal)+$shippingCost;
						echo"\$".sprintf("%01.2f", $total);
					?>
				</td>
			</tr>
		</table>
		<h4>Comments:</h4>
		<p><?php echo $orderComment;?></p>
	</body>
</html>
