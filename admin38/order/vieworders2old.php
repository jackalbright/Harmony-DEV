<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 06/1/05
******************************************************************************************/

//***************************************************
//       ENcrypt class May 2008

include_once ("../../includes/classDefinitions.inc");
include_once ("../../includes/encdecclass.php");
$encdec = &New EncDec;
//***************************************************


	session_start();
	if (!array_key_exists('UName', $_SESSION)){
		header ('Location: /admin38/index.php');
		exit(0);
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
		exit(0);
	};

	include_once ('../../includes/admin.inc');
	include_once ('../../includes/settings.inc');
	include_once ('../../includes/database.inc');

// Get Purchase ID and Recalculate Order if Necessary
	if (array_key_exists('purchaseID', $_GET)){
		$purchaseID=$_GET['purchaseID'];
		$txtUpdate="false";
	} elseif (array_key_exists('hdnPurchaseID', $_POST)){
		$purchaseID=$_POST['hdnPurchaseID'];
		$txtShipper=$_POST['txtShipper'];
		if ($txtShipper!="Not Shipped"){
			$result = mysql_query ("UPDATE purchase SET Shipping_Method='$txtShipper' WHERE purchase_id=$purchaseID", $database); 	
		};
		$txtTrackingNumber=$_POST['txtTrackingNumber'];
		$result = mysql_query ("UPDATE purchase SET tracking_number='$txtTrackingNumber' WHERE purchase_id=$purchaseID", $database); 	
		$txtOrderStatus=$_POST['txtOrderStatus'];
		$result = mysql_query ("UPDATE purchase SET Order_Status='$txtOrderStatus' WHERE purchase_id=$purchaseID", $database); 	
		$cbCancel=(array)$_POST['cbCancel'];
		foreach ($cbCancel as $value){
			$itemCancel[$value]="No";
		};
		$txtUpdate="true";
		$result = mysql_query ("UPDATE order_item SET accepted='Yes' WHERE purchase_id=$purchaseID", $database); 	
		foreach ($cbCancel as $value){
			$result = mysql_query ("UPDATE order_item SET accepted='No' where order_item_id=$value", $database); 	
		};
	};
//Pull in General Order Information
	$testQuery="SELECT purchase.Order_Date, purchase.Order_Status, purchase.Shipping_Method, purchase.Shipping_ID, purchase.Customer_ID, shippingMethod.name as Ship_ID, purchase.Credit_Card_ID, purchase.Billing_ID, purchase.Shipping_Cost, purchase.order_comment, purchase.shipper, purchase.tracking_number FROM purchase, shippingMethod WHERE purchase.purchase_id='$purchaseID' and purchase.shipping_Method = shippingMethod.shippingMethodID";
	$result = mysql_query ($testQuery, $database); 	
	while ($event = mysql_fetch_object($result)){
		$orderdate=$event->Order_Date;
		$orderstatus=$event->Order_Status;
		$shippingmethod=$event->Ship_ID;
		$customerID=$event->Customer_ID;
		$shippingAddress=$event->Shipping_ID;
		$shippingID=$event->Shipping_Method;
		$creditCardID=$event->Credit_Card_ID;
		$billingID=$event->Billing_ID;
		$shippingCost=$event->Shipping_Cost;
		$originalShipping = $shippingCost;
		$orderComment=$event->order_comment;
		$txtShipper=$event->shipper;
		$txtTrackingNumber=$event->tracking_number;
	};

// Pull in Shipping Address
	$result = mysql_query ("SELECT contact_info.*, countries.name as countryName FROM contact_info, countries WHERE contact_id='$shippingAddress' AND contact_info.Country = countries.iso_code", $database); 	
	while ($row = mysql_fetch_object($result)){
		$shipAddress1=$row->Address_1;
		$shipAddress2=$row->Address_2;
		$shipInCareOf=$row->In_Care_Of;
		$shipCity=$row->City;
		$shipState=$row->State;
		$shipZipCode=$row->Zip_Code;
		$shipCountry=$row->Country;
		$shipCountryName = $row->countryName;
		$address = $row;
	};

//Pull in Customer Information
	$result2 = mysql_query ("SELECT First_Name, Last_Name, Company, Phone, eMail_Address FROM customer WHERE customer_id='$customerID'", $database);
	while ($row2 = mysql_fetch_object($result2)){
		$customerFirstName=$row2->First_Name;
		$customerLastName=$row2->Last_Name;
		$customerCompany=$row2->Company;
		$customerPhone=$row2->Phone;
		$customerEmail=$row2->eMail_Address;
		$custPhone=strtok($customerPhone, '() -');
	};

//Pull in Billing Address
	$result = mysql_query ("SELECT contact_info.*, countries.name as countryName FROM contact_info, countries WHERE contact_id='$billingID' AND contact_info.Country = countries.iso_code", $database); 	
	while ($row = mysql_fetch_object($result)){
		$billAddress1=$row->Address_1;
		$billAddress2=$row->Address_2;
		$billInCareOf=$row->In_Care_Of;
		$billCity=$row->City;
		$billState=$row->State;
		$billZipCode=$row->Zip_Code;
		$billCountry=$row->Country;
		$billCountryName = $row->countryName;
	};

//Pull in Credit Card information
	$result = mysql_query ("SELECT card_type, cardholder, number, expiration FROM credit_card WHERE credit_card_id='$creditCardID'", $database); 	
	while ($row = mysql_fetch_object($result)){
		$txtCardType=$row->card_type;
		$txtCardHolder=$row->cardholder;
		$txtCardNumber=$encdec->phpDecrypt($row->number);
		$txtCardExpiration=$row->expiration;
	};
	
//Pull in All Basic Order Items	
	$result = mysql_query ("SELECT order_item_id, Quantity, Price, product_type_id, specialID, comments, accepted, reproduction FROM order_item WHERE purchase_id='$purchaseID'", $database); 	
	while ($row = mysql_fetch_object($result)){
		if ($row->reproduction == "Yes"){
			$itemPrefix[] = "R-";
			$itemSuffix[] = "(reproduction)";
		} else {
			$itemPrefix[] = "";
			$itemSuffix[] = "";
		}
		$itemID[]=$row->order_item_id;
		if ($row->accepted=="No"){
			$itemCancel[$row->order_item_id]="No";
		};
		if ($itemCancel[$row->order_item_id]=="No"){
			$itemPrice[]=0.00;
			$tempPrice=0.00;
			$itemQuantity[]=0;
		} else {
			$itemPrice[]=$row->Price;
			$tempPrice=$row->Price;
			$itemQuantity[]=$row->Quantity;
		};
		$itemTypeID[]=$row->product_type_id;
		if ($row->specialID != ""){
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
		$itemTotal[]=$row->Quantity * $tempPrice;
		$txtAccepted[]=$row->accepted;
	};

//Pull in Individual Item Information for each Item
	foreach ($itemID as $key=>$value){
		$result = mysql_query ("SELECT code, name, weight FROM product_type WHERE product_type_id='$itemTypeID[$key]'", $database); 	
		while ($row = mysql_fetch_object($result)){
			$itemCode[$key]=$itemCode[$key] . $row->code;
			if ($itemName[$key]==""){
				$itemName[$key]=$row->name;
			};
			$itemWeight[$key]=$row->weight * $itemQuantity[$key];
		};
		$result = mysql_query ("SELECT parts_id, order_Item_ID, imageID, ribbon_ID, tassel_ID, charm_ID, quote_ID, border_ID, custom_quote, personalization, stampNumber, frameID, pinStyle, reproductionStamp, personalizationStyle, Size, PrintSide FROM item_parts WHERE order_item_id=$itemID[$key]", $database); 	
		while ($row = mysql_fetch_object($result)){
			$itemCustomImageID[$key]=$row->imageID;
			$itemRibbonID[$key]=$row->ribbon_ID;
			$itemTasselID[$key]=$row->tassel_ID;
			$itemCharmID[$key]=$row->charm_ID;
			$itemQuoteID[$key]=$row->quote_ID;
			$itemBorderID[$key]=$row->border_ID;
			$itemCustomQuote[$key]=nl2br($row->custom_quote);
			$itemPersonalization[$key]=nl2br($row->personalization);
			$itemStampID[$key]=$row->stampNumber;
			$itemFrameID[$key]=$row->frameID;
			$itemPinStyle[$key]=$row->pinStyle;
			$stampReproduction[$key]=$row->reproductionStamp;
			$personalizationStyle[$key]=$row->personalizationStyle;
			$itemSize[$key]=$row->Size;
			$itemPrintSide[$key]=$row->PrintSide;
		};
//Get Custom Image Information for Item
		if ($itemCustomImageID[$key]!=""){
			$result = mysql_query ("SELECT Image_ID, thumbnail_location, Approved, Image_Location, Title FROM custom_image WHERE image_id='$itemCustomImageID[$key]'", $database); 	
			while ($row = mysql_fetch_object($result)){
				$itemPictureID[$key]="CI#".$row->Image_ID;
				$itemStampName[$key]=$row->Title;
				$itemImageName[$key]="<b>Custom Image Number:</b> " . $row->Image_ID . " <br /><b>Approved:</b> <A HREF='../part/approvecustom3.php?image_id=" . $row->Image_ID . "' target='_Blank'>" . $row->Approved . "</a><br />";
				if ($row->Image_Location){
					$itemImageLocationPrefix = "<a href=\"../../" . $row->Image_Location . "\" target=\"_blank\">";
					$itemImageLocationSuffix = "</a>";
				} else {
					$itemImageLocationPrefix = "";
					$itemImageLocationSuffix = "";
				};
				$itemImageLocation[$key]= $itemImageLocationPrefix . "<img src=\"../../" . $row->thumbnail_location . "\"/>" . $itemImageLocationSuffix;
			};
		};
// Get Stamp Info for Item
		if ($itemStampID[$key]!=""){
			$result = mysql_query ("SELECT stamp_name, thumbnail_location FROM stamp WHERE catalog_number='$itemStampID[$key]'", $database); 	
			while ($row = mysql_fetch_object($result)){
				$itemPictureID[$key]=$itemStampID[$key];
				$itemStampName[$key]=$row->stamp_name;
				$itemImageName[$key]="<b>Stamp Number:</b> " . $row->stamp_name . " ($itemStampID[$key])<br />";
				$itemImageLocation[$key]="<img src=\"../../" . $row->thumbnail_location . "\"/>";
			};
		};

// Get Ribbon Info for Item
		if ($itemRibbonID[$key]!=""){
			$result = mysql_query ("SELECT color_name FROM ribbon WHERE ribbon_id='$itemRibbonID[$key]'", $database); 	
			while ($row = mysql_fetch_object($result)){
				$itemRibbonColor[$key]="<b>Ribbon:</b> " . $row->color_name . "<br />";
			};
		} else {
			$itemRibbonColor[$key]="";
		};

//Get Tassel Info for Item
		if ($itemTasselID[$key]!=""){
			$result = mysql_query ("SELECT color_name FROM tassel WHERE tassel_id='$itemTasselID[$key]'", $database); 	
			while ($row = mysql_fetch_object($result)){
				$itemTasselColor[$key]=$row->color_name;
			};
		} else {
			$itemTasselColor[$key]="";
		};

//Get Charm Info for Item
		if ($itemCharmID[$key]!=""){
			$result = mysql_query ("SELECT name, graphic_location FROM charm WHERE charm_id='$itemCharmID[$key]'", $database); 	
			while ($row = mysql_fetch_object($result)){
				$itemCharmName[$key]="<b>Charm:</b> " . $row->name . "<br /><IMG src='" . $row->graphic_location ."'/><br />";
				$itemCharmDesc[$key]=$row->name;
			};
		} else {
			if ($itemTypeID[$key] == 13 || $itemTypeID[$key] == 4){
				$itemCharmName[$key]="<b>Charm:</b> None<br /><IMG src='/charms/no-charm.jpg'/><br />";
				$itemCharmDesc[$key]="";
			} else {
				$itemCharmName[$key]="";
				$itemCharmDesc[$key]="";
			}; 
		};

//Get Border Info for Item
		if ($itemBorderID[$key]!=""){
			$result = mysql_query ("SELECT name,location FROM border WHERE border_id='$itemBorderID[$key]'", $database); 	
			while ($row = mysql_fetch_object($result)){
				$itemBorderName[$key]="<b>Border:</b>" . $row->name . "<br /><IMG src='" . $row->location ."'/><br />";
			};
		} else {
			$itemBorderName[$key]="";
		};

//Get Frame Info for Item
		if ($itemFrameID[$key]!=""){
			$result = mysql_query ("SELECT name FROM frame WHERE frame_id='$itemFrameID[$key]'", $database); 	
			while ($row = mysql_fetch_row($result)){
				$itemFrameName[]="<b>Frame</b>: $row[0]<br />";
			};
		} else {
			$itemFrameName[]="";
		};

// Get Quote Info for Item
		if ($itemQuoteID[$key]!=""){
			$result = mysql_query ("SELECT text, title, attribution, use_quote_marks FROM quote WHERE quote_id='$itemQuoteID[$key]'", $database); 	
			while ($row = mysql_fetch_object($result)){
				$addMarks="";
				if ($row->use_quote_marks=="yes"){
					$addMarks="&quot;";
				};
				$quoteBody=nl2br($row->text);
				$itemQuote[]="<b>QUOTE:</b> <b>$row->title</b> $addMarks $quoteBody $addMarks <I>$row->attribution</I><br />";
			};
		} else {
			$itemQuote[]="";
		};
	};
// Get Shippers
		$i=0;
		$result = mysql_query ("SELECT shippingMethodID, name FROM shippingMethod", $database); 	
		while ($row = mysql_fetch_object($result)){
			$shipperName[$i]= "<option value='$row->shippingMethodID'";
			if ($shippingID == $row->shippingMethodID && $orderstatus=="Shipped"){ 
				$shipperName[$i] .= " SELECTED";
			};
			$shipperName[$i].= ">$row->name</option>";
			$i++;
		};
// Get information for Shipping Cost Recalc
/* ######## Load settings ######## */
	$queryString = "SELECT packageWeightMultiplier, internationalSurcharge FROM settings WHERE settingsID =1";
	$result = mysql_query ($queryString, $database);
	$temp = mysql_fetch_object($result);
	$packageWeightMultiplier = $temp->packageWeightMultiplier;
	$internationalSurcharge = $temp->internationalSurcharge;

	$itemWeight=0;
	$result = mysql_query ("SELECT order_item.Quantity, product_type.shipWeight FROM order_item, product_type WHERE order_item.purchase_id='$purchaseID' AND product_type.product_type_id = order_item.product_type_id AND Accepted='Yes'", $database); 	
	while ($row = mysql_fetch_object($result)){
		$tempQuantity = $row->Quantity;
		$tempWeight = $row->shipWeight;
		$itemWeight = $itemWeight + ($tempQuantity * $tempWeight);
	};

/* ######## Calculate weights for different shipping determinations ######## */
	$packageWeight = $itemWeight * $packageWeightMultiplier;
	$orderWeight = $packageWeight + $itemWeight;
	$poundWeight = $orderWeight * 0.00220462262;
	$shippingWeight = ceil($poundWeight);

/* ######## Generate shipping cost information ######## */
	$queryString = "SELECT * from `handlingCharge` where weight <= $poundWeight order by weight desc limit 1";
	$result = mysql_query ($queryString, $database);
	$temp = mysql_fetch_object($result);
	$handlingCharge = $temp->price;
	
	$shippingOptions = array();
	if ($address->Country == 'US' || $address->Country == 'PR') {
		$shippingZip = substr ($address->Zip_Code, 0, 5);
		$queryString = "SELECT shippingMethod.*, shippingPricePoint.cost+$handlingCharge as cost FROM `shippingZoneUS`, `shippingPricePoint`, `shippingMethod` WHERE shippingZoneUS.zipStart <= $shippingZip and shippingZoneUS.zipEnd >= $shippingZip and shippingZoneUS.shippingMethod = shippingMethod.shippingMethodID and shippingMethod.available = 'yes' and shippingMethod.shippingMethodID = shippingPricePoint.shippingmethod and shippingZoneUS.zoneNumber = shippingPricePoint.zoneNumber and shippingPricePoint.weight = $shippingWeight order by shippingMethod.dayMin desc";
		$result = mysql_query($queryString, $database);
		while ($temp = mysql_fetch_object($result)) {
			$shippingOptions[$temp->shippingMethodID] = $temp;
		}			
	} else if ($address->Country == 'VI' || $address->Country == 'GU') {
		$shippingZip = substr ($address->Zip_Code, 0, 5);
		$queryString = "SELECT shippingMethod.*, shippingPricePoint.cost+$handlingCharge as cost FROM `shippingZoneUS`, `shippingPricePoint`, `shippingMethod` WHERE shippingZoneUS.zipStart <= $shippingZip and shippingZoneUS.zipEnd >= $shippingZip and shippingZoneUS.shippingMethod = shippingMethod.shippingMethodID and shippingMethod.available = 'yes' and shippingMethod.shippingMethodID = shippingPricePoint.shippingmethod and shippingZoneUS.zoneNumber = shippingPricePoint.zoneNumber and shippingPricePoint.weight = $shippingWeight order by shippingMethod.dayMin desc";
		$result = mysql_query($queryString, $database);
		while ($temp = mysql_fetch_object($result)) {
			$shippingOptions[$temp->shippingMethodID] = $temp;
		}			
		$isoCode = $address->Country;
		$queryString = "SELECT shippingMethod.*, shippingPricePoint.cost+$handlingCharge as cost FROM `shippingZoneInt`, `shippingPricePoint`, `shippingMethod` WHERE shippingZoneInt.country = '$isoCode' and shippingZoneInt.shippingMethod = shippingMethod.shippingMethodID and shippingMethod.available = 'yes' and shippingMethod.shippingMethodID = shippingPricePoint.shippingmethod and shippingZoneInt.zone = shippingPricePoint.zoneNumber and shippingPricePoint.weight = $shippingWeight order by shippingMethod.dayMin desc";
		$result = mysql_query($queryString, $database);
		while ($temp = mysql_fetch_object($result)) {
			$shippingOptions[$temp->shippingMethodID] = $temp;
		}
	} else if ($address->Country == 'CA') {
		$shippingCode = substr ($address->Zip_Code, 0, 3);
		$queryString = "SELECT shippingMethod.*, shippingPricePoint.cost+$handlingCharge+$internationalSurcharge as cost FROM `shippingZoneCA`, `shippingPricePoint`, `shippingMethod` WHERE shippingZoneCA.codeMin <= '$shippingCode' and shippingZoneCA.codeMax >= '$shippingCode' and shippingZoneCA.shippingMethod = shippingMethod.shippingMethodID and shippingMethod.available = 'yes' and shippingMethod.shippingMethodID = shippingPricePoint.shippingmethod and shippingZoneCA.zone = shippingPricePoint.zoneNumber and shippingPricePoint.weight = $shippingWeight order by shippingMethod.dayMin desc";
		$result = mysql_query($queryString, $database);
		while ($temp = mysql_fetch_object($result)) {
			$shippingOptions[$temp->shippingMethodID] = $temp;
		}			
	} else {
		$isoCode = $address->Country;
		$queryString = "SELECT shippingMethod.*, shippingPricePoint.cost+$handlingCharge+$internationalSurcharge as cost FROM `shippingZoneInt`, `shippingPricePoint`, `shippingMethod` WHERE shippingZoneInt.country = '$isoCode' and shippingZoneInt.shippingMethod = shippingMethod.shippingMethodID and shippingMethod.available = 'yes' and shippingMethod.shippingMethodID = shippingPricePoint.shippingmethod and shippingZoneInt.zone = shippingPricePoint.zoneNumber and shippingPricePoint.weight = $shippingWeight order by shippingMethod.dayMin desc";
		$result = mysql_query($queryString, $database);
		while ($temp = mysql_fetch_object($result)) {
			$shippingOptions[$temp->shippingMethodID] = $temp;
		}
	}
	$shippingCost = $shippingOptions[$shippingID]->cost;
	mysql_close($database);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>View Purchase Orders</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; line-height: normal; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {font-weight: bold}
--></style>
<?php
		echo "<script language=\"javascript\" type=\"text/javascript\">";
		echo "function recalcTotal(){";
		echo "location.href=\"vieworders2.php?purchaseID=$purchaseID\";};";
		echo "</script>";
?>
	</head>

	<body bgcolor="#ffffff">
		<form action="vieworders2.php" method="post" name="POForm">
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
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br />
				      <a href="menu.php">Back to Order Menu</a></p>
			  </td>
				<td>
					<div align="center">
						<table width="450" border="0" cellspacing="2" cellpadding="0">
							<tr>
								<td valign="top" width="50%">
									<h3><b><font color="purple">Order Number: <?php echo "$purchaseID"; ?>
									  <input type="hidden" name="hdnPurchaseID" value="<?php echo "$purchaseID"; ?>">
                                      <input type="hidden" name="hdnUpdate" value="true">
</font></b></h3>							  </td>
								<td valign="top"><h4><b>Date:  <?php echo "$orderdate"; ?></b></h4></td>
							</tr>
							<tr>
								<td valign="top" width="50%">
									<b>Shipping to:</b>
									<br /><?php
										if ($customerCompany!=""){
										  echo "$customerCompany<br />";
										};
										if ($shipInCareOf!=""){
										  echo "ATTN: $shipInCareOf<br />";
										} else {
										  echo "ATTN: $customerFirstName $customerLastName<br />";
										};
										echo "$shipAddress1<br />$shipAddress2<br />$shipCity, $shipState $shipZipCode<br />$shipCountryName<br />$customerPhone<br /><a href=\"mailto:$customerEmail\">$customerEmail</a>";
									?>
								</td>
								<td valign="top">
									<b>Billing to:</b>
									<br /><?php
										if ($customerCompany!=""){
										  echo "$customerCompany<br />";
										};
										if ($customerInCareOf!=""){
										  echo "ATTN: $billInCareOf<br />";
										} else {
										  echo "ATTN: $customerFirstName $customerLastName<br />";
										};
										echo "$billAddress1<br />$billAddress2<br />$billCity, $billState $billZipCode<br />$billCountryName<br />$customerPhone<br /><a href=\"mailto:$customerEmail\">$customerEmail</a>";
									?>
								</td>
							</tr>
							<tr>
								<td valign="top" width="50%">
									<!--
									<b>Shipping Method:</b>
									<br />
									<?php echo $shippingmethod; ?>
									-->
								</td>
								<td valign="top" rowspan="3"><b>Order Comments:</b><br /><?php echo $orderComment; ?></td>
							</tr>
							<tr>
								<td valign="top" width="50%">
									<b>Payment Method:</b><br />
								<?php
									echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>Card Type:</b>  $txtCardType<br />";
									echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>Cardholder: </b> $txtCardHolder<br />";
									echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>Number:</b>  $txtCardNumber<br />";
									echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>Expires:</b>  $txtCardExpiration<br />";
								?>
								</td>
							</tr>
							<tr>
								<td valign="top" width="50%">
									<b>Shipping Method:</b><br />
									<select name="txtShipper">
										<?php
											foreach ( $shippingOptions as $shippingMethod ) {
												echo "<option value=\"$shippingMethod->shippingMethodID\"";
												if ( $shippingID == $shippingMethod->shippingMethodID ) {
													echo " selected=\"selected\"";
												};
												echo ">$shippingMethod->name \{";
												if ($shippingMethod->dayMin == $shippingMethod->dayMax){
													echo "$shippingMethod->dayMin days - \$$shippingMethod->cost}</option>\n";
												} else {
													echo "$shippingMethod->dayMin to $shippingMethod->dayMax days - \$$shippingMethod->cost}</option>\n";
												};
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td valign="top" width="50%">
									<b>Tracking Number:</b><br /><input name="txtTrackingNumber" type="text" size="30" value="<?php echo $txtTrackingNumber; ?>">
									
							  </td>
								<td valign="top">
								<strong>Order Status:</strong><br />
								<select name="txtOrderStatus">
								  <option value="Submitted" <?php if ($orderstatus=="Submitted"){echo " SELECTED";}; ?>>New Order</option>
								  <option value="Processing" <?php if ($orderstatus=="Processing"){echo " SELECTED";}; ?>>In Progress</option>
								  <option value="Shipped" <?php if ($orderstatus=="Shipped"){echo " SELECTED";}; ?>>Shipped</option>
							    </select></td>
							</tr>
							<tr>
							  <td valign="top">&nbsp;</td>
							  <td valign="top"><div align="right">
							    <input type="submit" name="Submit1" value="Recalculate and Submit Changes">						      
						      </div></td>
						  </tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
		<table width="100%" border="1" cellspacing="2" cellpadding="0">
			<tr>
			  <td width="8%"><h4>Cancel</h4></td>
				<td width="5%">
					<h4>Qty.</h4>
				</td>
				<td>
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
					if ($itemCode[$key]=="CH"){
						$itemFirstName=$itemCharmID[$key];
						$itemStampName[$key] = $itemCharmDesc[$key];
						$itemPictureID[$key] = $itemCharmID[$key];
					};
			?>
			<tr>
			  <td valign="top"><div align="center">
			    <input type="checkbox" name="cbCancel[]" value="<?php echo $itemID[$key]; ?>"<?php if ($itemCancel[$itemID[$key]]=='No'){echo " CHECKED";}; ?>>
			  </div></td>
				<td valign="top"><?php echo $itemQuantity[$key]; ?><br /></td>
				<td valign="top">
				<b>Name:</b> <?php echo "$itemStampName[$key] $itemName[$key] $itemSuffix[$key]"; ?><br />
				<b>Catalog:</b> <?php echo $itemPrefix[$key]. "$itemCode[$key]-$itemPictureID[$key]"; ?><br />
				<?php
					if ($itemRibbonID[$key]!=""){
						echo "$itemRibbonColor[$key]";
					};
					if ($itemTasselID[$key]!=""){
						echo "<b>Tassel:</b> $itemTasselColor[$key]<br />";
					};
					if ($itemCharmID[$key]!="" || ($itemTypeID[$key]==13 || $itemTypeID[$key] == 4)){
						echo "$itemCharmName[$key]";
					};
					if ($itemQuoteID[$key]!=""){
						echo "$itemQuote[$key]";
					};
					if ($itemCustomQuote[$key]!=""){
						echo "<b>CUSTOM QUOTE:</b>  $itemCustomQuote[$key]<br />";
					};
					if ($itemPersonalization[$key]!=""){
						echo "<b>Personalization:</b>  $itemPersonalization[$key] ($personalizationStyle[$key])<br />";
					};
					if ($itemBorderID[$key]!=""){
						echo "$itemBorderName[$key]";
					};
					if ($itemFrameID[$key]!=""){
						echo "$itemFrameName[$key]";
					};
					if ($itemPinStyle[$key]!=""){
						echo "<b>Pin Style:</b>  $itemPinStyle[$key]<br />";
					};
					if ($itemSize[$key]!=""){
						echo "<b>Size:</b>  $itemSize[$key]<br />";
					};
					if ($itemPrintSide[$key]!=""){
						echo "<b>Print Side:</b>  $itemPrintSide[$key]<br />";
					};
					echo $itemImageName[$key];
					if ($itemComment[$key]!=""){
						echo "<br /><br /><b>Item Comments:</b>  <i>$itemComment[$key]</i><br />";
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
				<td></td>
				<td colspan="2">
					<div align="right">
						<b>Shipping:</b></div>
				</td>
				<td width="10%"><?php echo"\$".sprintf("%01.2f", $shippingCost); ?></td>
			</tr>
			<?php
				if ( (float)$shippingCost != (float)$originalShipping ) {
					echo "<tr>\n<td colspan=\"3\"></td>\n<td colspan=\"2\" style=\"text-align: right; font-style: italic;\">Originial Shipping:</td>\n";
					echo "<td style=\"font-style: italic;\">\$$originalShipping</td>\n</tr>\n";
				}
			?>
			<tr>
			  <td></td>
				<td></td>
				<td><div align="right">
							    <input type="submit" name="Submit1" value="Recalculate and Submit Changes">						      
						      </div></td>
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
	</form>
	</body>
</html>
