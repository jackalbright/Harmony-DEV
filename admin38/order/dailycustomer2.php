<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 12/13/04
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
	$txtPurchaseID=$_GET['txtPurchaseID'];
	header("Content-type: application/txt");
	header("Content-Disposition: attachment; filename=customer.txt");
	include ('../../includes/database.inc');
	echo "Co./Last Name\tFirst Name\tCard ID\tCard Status\tCurrency Code\tAddr 1 - Line 1\t           - Line 2\t           - Line 3\t           - Line 4\t           - City\t           - State\t           - ZIP Code\t           - Country\t           - Phone # 1\t           - Phone # 2\t           - Phone # 3\t           - Fax #\t           - Email\t           - WWW\t           - Contact Name\t           - Salutation	Addr 2 - Line 1\t           - Line 2\t           - Line 3\t           - Line 4\t           - City\t           - State\t           - ZIP Code\t           - Country\t           - Phone # 1\t           - Phone # 2\t           - Phone # 3\t           - Fax #\t           - Email\t           - WWW\t           - Contact Name\t           - Salutation	Addr 3 - Line 1\t           - Line 2\t           - Line 3\t           - Line 4\t           - City\t           - State\t           - ZIP Code\t           - Country\t           - Phone # 1\t           - Phone # 2\t           - Phone # 3\t           - Fax #\t           - Email\t           - WWW\t           - Contact Name\t           - Salutation	Addr 4 - Line 1\t           - Line 2\t           - Line 3\t           - Line 4\t           - City\t           - State\t           - ZIP Code\t           - Country\t           - Phone # 1\t           - Phone # 2\t           - Phone # 3\t           - Fax #\t           - Email\t           - WWW\t           - Contact Name\t           - Salutation	Addr 5 - Line 1\t           - Line 2\t           - Line 3\t           - Line 4\t           - City\t           - State\t           - ZIP Code\t           - Country\t           - Phone # 1\t           - Phone # 2\t           - Phone # 3\t           - Fax #\t           - Email\t           - WWW\t           - Contact Name\t           - Salutation\tPicture\tNotes\tIdentifiers\tCustom List 1\tCustom List 2\tCustom List 3\tCustom Field 1\tCustom Field 2\tCustom Field 3\tBilling Rate\tTerms - Payment is Due\t           - Discount Days\t           - Balance Due Days\t           - % Discount\t           - % Monthly Charge	Tax Code\tCredit Limit\tTax ID No.\tVolume Discount %\tSales/Purchase Layout\tPrice Level\tPayment Method\tPayment Notes\tName on Card\tCard Number\tExpiration Date\tAddress (AVS)\tZIP (AVS)\tCard Verification (CVV2)\tAccount\tSalesperson\tSalesperson Card ID\tComment\tShipping Method\tPrinted Form\tFreight Tax Code\tReceipt Memo\r";
			$result = mysql_query ("SELECT c.first_name, c.last_name, c.company, c.phone, ba.in_care_of, ba.address_1, ba.address_2, ba.city, ba.state, ba.zip_code, ba.country, sa.in_care_of, sa.address_1, sa.address_2, sa.city, sa.state, sa.zip_code, sa.country, cc.card_type, cc.cardholder, cc.expiration, cc.number, p.shipping_method, MONTH(cc.expiration) as expMonth, YEAR(cc.expiration) as expYear, c.eMail_Address FROM purchase p, customer c, contact_info ba, contact_info sa, credit_card cc WHERE p.purchase_id='$txtPurchaseID' AND p.customer_id = c.customer_id AND p.billing_id=ba.contact_id AND p.shipping_id=sa.contact_id AND p.credit_card_id=cc.credit_card_id", $database); 
			while ($row = mysql_fetch_row($result)){
				$txtCardType=$row[18];
				if ($txtCardType=="Mastercard"){
					$txtCardType="MasterCard";
				};
				$txtExpMonth=sprintf("%02s",$row[23]);
				$txtExpYear=substr($row[24],2,2);
				$txtEmail=$row[25];
				if ($row[2]=""){
				$txtBillingAddress="$row[5]\t$row[6]\t\t\t$row[7]\t$row[8]\t$row[9]\t$row[10]\t$row[3]\t\t\t\t$txtEmail\t\t\t\t";
				$txtShippingAddress="$row[12]\t$row[13]\t\t\t\t\t$row[14]\t$row[15]\t$row[16]\t$row[17]\t$row[3]\t\t\t\t$txtEmail\t\t\t\t";
				} else {
				$txtBillingAddress="$row[2]\t$row[4]\t$row[5]\t$row[6]\t\t$row[7]\t$row[8]\t$row[9]\t$row[10]\t$row[3]\t\t\t\t$txtEmail\t\t\t";
				$txtShippingAddress="$row[2]\t$row[11]\t$row[12]\t$row[13]\t\t$row[14]\t$row[15]\t$row[16]\t$row[17]\t$row[3]\t\t\t\t$txtEmail\t\t\t\t";
				}
				echo "$row[1]\t$row[0]\t*None\t\t$txtBillingAddress$txtShippingAddress\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tI\t\t\t\t\t\t\t0\t1\t0\t0\t0\t0\tX\t0\t\t0\tN\t3\t$txtCardType\t\t$row[19]\t$row[21]\t$txtExpMonth/$txtExpYear\t$row[5]\t$row[9]\t\t\tFranklin, Sherrill\t*None\tWe look forward to serving you again.\t\t\t-\t\r";
		};
		mysql_close($database);
?>
