<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 1/3/05
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
	}
	if ($_SESSION['canManageOrders']!="Yes"){
		header ('Location: ../menu.php');
	}
	include ('../../includes/admin.inc');
	include_once ('../../includes/database.inc');
	include_once ('../../includes/spellCheck.inc');
// Get Invoice Number.
	$txtInvoice = (array)$_REQUEST['txtInvoice'];
	
// Write header for the file to identify it as a text file that would be downloaded.
	header("Content-type: application/txt");
	header("Content-Disposition: attachment; filename=FedExImport.csv");

// Write first row (column headers) for the table.
	#echo "Nickname,FullName,FirstName,LastName,Title,Company,Department,AddressOne,AddressTwo,City,State,Zip,PhoneNumber,ExtensionNumber,FAXNumber,PagerNumber,MobilePhoneNumber,CountryCode,EmailAddress,VerifiedFlag,AcceptedFlag,ValidFlag,ResidentialFlag,CustomsIDEIN,ReferenceDescription,ServiceTypeCode,PackageTypeCode,CollectionMethodCode,BillCode,BillAccountNumber,DutyBillCode,DutyBillAccountNumber,CurrencyTypeCode,InsightIDNumber,GroundReferenceDescription,GroundShipAlertFlag,GroundShipAlertRecipientFaxNumber,GroundShipAlertRecipientEmail,ExpressShipAlertSenderEmail,ExpressShipAlertRecipientEmail,PartnerTypeCodes,NetReturnBillAccountNumber,CustomsIDTypeCode,AddressTypeCode,,,,,,,,,,,,,,,,,,,,,,,,,,\r";

	echo "Nickname,FullName,FirstName,LastName,Title,Company,Department,AddressOne,AddressTwo,City,State,Zip,PhoneNumber,ExtensionNumber,FAXNumber,PagerNumber,MobilePhoneNumber,CountryCode,EmailAddress,VerifiedFlag,AcceptedFlag,ValidFlag,ResidentialFlag,CustomsIDEIN,ReferenceDescription,ServiceTypeCode,PackageTypeCode,CollectionMethodCode,BillCode,BillAccountNumber,DutyBillCode,DutyBillAccountNumber,CurrencyTypeCode,InsightIDNumber,GroundReferenceDescription,ShipmentNotificationRecipientEmail,RecipientEmailLanguage,RecipientEmailShipmentnotification,RecipientEmailExceptionnotification,RecipientEmailDeliverynotification,PartnerTypeCodes,NetReturnBillAccountNumber,CustomsIDTypeCode,AddressTypeCode,ShipmentNotificationSenderEmail,SenderEmailLanguage,SenderEmailShipmentnotification,SenderEmailExceptionnotification,SenderEmailDeliverynotification,RecipientEmailPickupnotification,SenderEmailPickupnotification,OpCoTypeCd,BrokerAccounttID,BrokerTaxID,DefaultBrokerID\r";



#	echo "GroundShipAlertFlag,GroundShipAlertRecipientFaxNumber,GroundShipAlertRecipientEmail,ExpressShipAlertSenderEmail,ExpressShipAlertRecipientEmail,PartnerTypeCodes,NetReturnBillAccountNumber,CustomsIDTypeCode,AddressTypeCode,,,,,,,,,,,,,,,,,,,,,,,,,,\r";
// Breakdown by Invoice
	foreach ($txtInvoice as $invoice){
// Pull the Order.
		$result = mysql_query ("SELECT Customer_ID, Shipping_ID, Shipping_Method FROM purchase WHERE purchase_id='$invoice'", $database); 	
		while ($event = mysql_fetch_object($result)){
			$customerID=$event->Customer_ID;
			$shippingID=$event->Shipping_ID;
			$shippingMethod=$event->Shipping_Method;
			switch($shippingMethod){
				case 'standard':
					$shipTypeCode="11";
				break;
				case 'expedited':
					$shipTypeCode="4";
				break;
				case 'overnight':
					$shipTypeCode="2";
				break;
			}
		}
// Pull the customer information
		$result2 = mysql_query ("SELECT First_Name, Last_Name, Company, Phone, eMail_Address FROM customer WHERE customer_id='$customerID'", $database);
		while ($row2 = mysql_fetch_object($result2)){
			$customerFirstName=$row2->First_Name;
			$customerLastName=$row2->Last_Name;
			$customerCompany=$row2->Company;
			$customerPhone=$row2->Phone;
			$customerEmail=$row2->eMail_Address;
			$customerFullName= $customerFirstName . " " . $customerLastName;
	// Convert phone number to proper format 
			$tempPhone="";
			for ($i=0; $i<strlen($customerPhone); $i++){
				if (stristr("~0123456789",$customerPhone[$i])){	//Find out if the current digit is a number
					$tempPhone=$tempPhone . $customerPhone[$i];
				}
			}
			$customerPhone = substr($tempPhone, 0, 3) . "-" . substr($tempPhone, 3, 3) . "-" . substr($tempPhone, 6, 4);
		}	
// Pull in Shipping Address
		$result3 = mysql_query ("SELECT * FROM contact_info WHERE contact_id='$shippingID'", $database); 	
		while ($row = mysql_fetch_object($result3)){
			$shipAddress1=$row->Address_1;
			$shipAddress2=$row->Address_2;
			$shipInCareOf=$row->In_Care_Of;
			$shipCity=$row->City;
			$shipState=$row->State;
			$shipCompany=$row->Company;
			$shipZipCode=$row->Zip_Code;
			$shipCountry=$row->Country;
			if ($shipInCareOf != ''){
				$customerFullName = $customerFullName . " (c/o " . $shipInCareOf . ")";
			}
			if ($shipCompany != ""){
				$companyLine =  "$shipCompany"; 
			} else if ($customerCompany != ""){
				$companyLine =  "$customerCompany"; 
			} else {
				$companyLine = "";
			}
		}
		if ($shipCountry == 'US') {
			$result = mysql_query ("Select code from state where name = '$shipState' or abbr = '$shipState'", $database);
			if ( mysql_num_rows($result) > 0 ) {
				$temp = mysql_fetch_object($result);
				$stateCode = $temp->code;
				$shipState = $stateCode;
			}
		}
		$residentialFlag = '';
		#$residentialFlag = 'R'; # All commercial.

// Write information to the file
		echo "\"$invoice - $customerLastName\",\"$customerFullName\",\"$customerFirstName\",\"$customerLastName\",,\"$companyLine\",,\"$shipAddress1\",\"$shipAddress2\",\"$shipCity\",\"$shipState\",\"$shipZipCode\",\"$customerPhone\",,,,,US,\"$customerEmail\",N,N,Y,$residentialFlag,,\"Order Number: $invoice\",$shipTypeCode,7,2,1,178574752,1,,USD,,,$customerEmail,,Y,,,,,,,info@harmonydesigns.com,,,,,,,,,,\n";

// Next Invoice
	}
?>
