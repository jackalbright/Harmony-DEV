<?php
$mode = 'prod'; // change this to anything but 'debug' to exit debug mode

/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 11/8/04
******************************************************************************************/
session_start();
if (!array_key_exists('UName', $_SESSION)){
	header ('Location: ../index.php');
	exit(0);
};
if ($_SESSION['canManageParts']!="Yes") {
	header ('Location: ../menu.php');
	exit(0);
};
include ('../../includes/admin.inc');

require_once "Mail.php";  //Pear package
?>
<?php
	$txtImageID = $_POST['hdnImageID'];
	$txtImageName = addslashes($_POST['txtImageName']);
	$txtImageDescription = addslashes(htmlentities($_POST['txtImageDescription']));
	$txtSubmitMonth = $_POST['txtSubmitMonth'];
	$txtSubmitDay = $_POST['txtSubmitDay'];
	$txtSubmitYear = $_POST['txtSubmitYear'];
	$txtApprovalStatus = $_POST['txtApprovalStatus'];
	$txtRefusalReason = (array)$_POST['txtRefusalReason'];
	$txtOtherReason = htmlentities($_POST['txtOtherReason']);
	$txtAdditionalNotes = htmlentities($_POST['txtAdditionalNotes']);
	$txtCustomerID = $_POST['hdnCustomerID'];
	$txtThumbnailLocation = $_POST['hdnThumbnailLocation'];
	$txtToday = getdate();
	$txtApprovalDate = $txtToday['year'] . "-" . $txtToday['mon'] . "-" . $txtToday['mday'];
	$txtSendMail = $_POST['hdnSendEmail'];
	if ($txtSendMail == "Queued"){
		$txtSentMail = "Yes";
	} else {
		$txtSentMail="No";
	};
	include ('../../includes/database.inc');
    $txtQueryString = "UPDATE custom_image SET Approved='$txtApprovalStatus', approval_notes='$txtAdditionalNotes', Notes='$txtOtherReason', Title='$txtImageName', Approval_Date='$txtApprovalDate', Description='$txtImageDescription', send_email='$txtSentMail' WHERE Image_ID=$txtImageID";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM custom_reason WHERE custom_image_id=$txtImageID";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
	include ('../../includes/database.inc');
    $txtQueryString = "SELECT order_Item_ID FROM item_parts WHERE ImageID=$txtImageID";
    $result = mysql_query ($txtQueryString, $database); 
	while ($row = mysql_fetch_row($result)){
		$partsID=$row[0];
	    $txtQueryString2 = "UPDATE order_item SET accepted='No' WHERE order_Item_ID=$partsID";
	    $result2 = mysql_query ($txtQueryString, $database); 
	};
	mysql_close($database);
	include ('../../includes/database.inc');
	foreach ($txtRefusalReason as $value){
 	   $txtQueryString = "INSERT custom_reason (custom_image_id, refusal_reason_id) VALUES ($txtImageID, '$value')";
 	   $result = mysql_query ($txtQueryString, $database); 
	};
	mysql_close($database);
	if ($txtSendMail=="Queued"){
		include ('../../includes/database.inc');
	    $txtQueryString = "SELECT First_Name, Last_Name, eMail_Address FROM customer WHERE customer_id = '$txtCustomerID'";
	    $result = mysql_query ($txtQueryString, $database); 
		mysql_close($database);
		while ($row = mysql_fetch_row($result)){
			$txtFirstName = $row[0];
			$txtLastName = $row[1];
			$txtEMailAddress = $row[2];
		};
		/* To send HTML mail, you can set the Content-type header. */
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

		/* additional headers */
		$headers .= "From: info@harmonydesigns.com\r\n";
		$txtApprovalMessage = "<html>\n<head>\n<style type=\"text/css\" media=\"all\">\n";
		$txtApprovalMessage .= "body{background-color: #eee; margin: 0; font-family: Optima,'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', 'Dejavu Sans', Verdana, sans-serif; font-size: 12pt;   }\n";
		$txtApprovalMessage .= ".imgButton{	padding: 0px; margin: 0px; border-width: 0px; height: 29px; background-color: #FFE;}\n";
		$txtApprovalMessage .= ".nowrap { white-space: nowrap; }\n";
		$txtApprovalMessage .= "p { margin: 0 0 .5em 0; }\n";
		$txtApprovalMessage .= "h1,h2,h3,h4,h5,h6{color: #060; font-family: \"Times\", serif;	font-weight: bold; margin: 0 0 5px 0;}\n";
		$txtApprovalMessage .= "#mainContainer { background-color: #FFE;width:80%; padding:15px;margin-left:auto;margin-right:auto;}\n";
		$txtApprovalMessage .= "h1 { font-size: 32px; }\n";
		$txtApprovalMessage .= "h2 { font-size: 21px; }\n";
		$txtApprovalMessage .= "h3 { font-size: 17px; }\n";
		$txtApprovalMessage .= "h4 { font-size: 15px; }\n";
		$txtApprovalMessage .= "h5 { font-size: 12px; }\n";
		$txtApprovalMessage .= "h6 { font-size: 11px; }\n";
		$txtApprovalMessage .= "a h1,a h2,a h3,a h4,a h5,a h6{color: #039; text-decoration: none;}\n";
		$txtApprovalMessage .= "a h1:hover,a h2:hover,a h3:hover,a h4:hover,a h5:hover,a h6:hover { color: #909; }\n";
		$txtApprovalMessage .= ".center { text-align: center; }\n";
		$txtApprovalMessage .= ".right { text-align: right; }\n";
		$txtApprovalMessage .= "a:link { color: #039; }\n";
		$txtApprovalMessage .= "a:visited { color: #903; }\n";
		$txtApprovalMessage .= "a:hover { color: #909; }\n";
		$txtApprovalMessage .= "a:active { color: #309; }\n";
		$txtApprovalMessage .= "hr.narrow { margin: 0; }\n";
		$txtApprovalMessage .= ".note{font-size: smaller; font-style: italic; font-weight: normal;}\n";
		$txtApprovalMessage .= ".super{vertical-align: super; font-size: 0.7em;}\n";
		$txtApprovalMessage .= ".sub{vertical-align: sub; font-size: 0.7em;}\n";
		$txtApprovalMessage .= ".divider { clear: both; }\n";
		$txtApprovalMessage .= "div#header{width: 760px; height: 88px;}\n";
		$txtApprovalMessage .= "#header img { border-width: 0px; }\n";
		//$txtApprovalMessage .= "#header img#logo{position: absolute; top: 4px; left: 15px;}\n";
		//$txtApprovalMessage .= "#header img#slogan{position: absolute; top: 10px; left: 186px;}\n";
		$txtApprovalMessage .= "#footer {border-top:1px solid #aaa; padding-top:10px;margin-top:10px; text-align:center;font-weight:normal; font-size:11px;}\n";
		$txtApprovalMessage .= ".pictureCell{text-align:center; width:50%;}\n";
		$txtApprovalMessage .= "div#title{clear: right;}\n";
		$txtApprovalMessage .= "</style>\n</head>\n";
		$txtApprovalMessage .= "<body>\n";
		$txtApprovalMessage .= "<div id='mainContainer'>\n";
		$txtApprovalMessage .= "<div id=\"header\"><a href=\"www.harmonydesigns.com/index.php\"><img id=\"logo\" src=\"http://www.harmonydesigns.com/images/HD-CHECKER-LOGO-sq.png\" border=\"0\"></a>\n";
		$txtApprovalMessage .= "</div>\n";
		$txtApprovalMessage .= "<table width='100%' border='0' cellpadding='0' cellspacing='0'>\n";
		$txtApprovalMessage .= "<tr><td><p>\n";
		$txtApprovalMessage .= "Dear " . ucfirst(strtolower($txtFirstName))  ." ". ucfirst(strtolower($txtLastName)) . ",\n<BR><BR>\n";
		if ($txtApprovalStatus == "Yes"){
			$txtApprovalMessage = $txtApprovalMessage . "Thank you for uploading your art, image, photo or graphic.  We have approved the image that you have uploaded to our website. To view your saved image and order online, visit <a href='http://{$_SERVER['HTTP_HOST']}/custom_images?login=1'>http://{$_SERVER['HTTP_HOST']}/custom_images</a>.";#Any gifts that you have already ordered will be created and shipped.  You can create other gift items with the same image by going to the &quot;Your Account&quot; area and clicking on the &quot;Custom Image&quot; menu.\n"; 
		} elseif ($txtApprovalStatus == "No") {
			$txtApprovalMessage = $txtApprovalMessage . "Thank you for uploading your art, image, photo or graphic.  Because of the following problems, your art will not reproduce successfully on your gift item(s):\n";
			foreach($txtRefusalReason as $value){
				$txtQueryString = "SELECT reason_item, reason_explanation FROM refusal_reasons WHERE reason_id = $value";
				include ('../../includes/database.inc');
	    		$result = mysql_query ($txtQueryString, $database);
	    		while ($row = mysql_fetch_row($result)){
					$txtReasonItem=$row[0];
					$txtReasonExplanation=$row[1];
					$txtApprovalMessage = $txtApprovalMessage . "<UL><LI><B>$txtReasonItem:</B>  $txtReasonExplanation\n";
					if ($value=="8"){
						$txtApprovalMessage = $txtApprovalMessage . "<BLOCKQUOTE> $txtOtherReason </BLOCKQUOTE>\n";
					}; 
					$txtApprovalMessage = $txtApprovalMessage . "</LI></UL>";
	       		};
	     		mysql_close($database);
			};
			#$txtApprovalMessage = $txtApprovalMessage . "Any items that you have ordered with this graphic are &quot;on hold&quot; for a maximum of five business days until we receive art that meets our guidelines.  Please let us know how wish to proceed.";
		};
		if ($txtAdditionalNotes != ""){
			$txtApprovalMessage = $txtApprovalMessage . "<BR><BR>$txtAdditionalNotes\n";
		};
		$txtApprovalMessage .= "<br/><br/>Please note:  This is approval information about your art only. You will receive a separate confirmation once an order is placed. If you have any questions, please email:  info@harmonydesigns.com  We look forward to working with you. ";

		$txtApprovalMessage .= "<BR><BR>Best Regards,<BR><BR><BR>Sherrill Franklin</p></td>";
		/* ----------------------------------------------
		T A B L E     C E L L      W I T H      I M A G E
		----------------------------------------------  */
		$txtApprovalMessage .="<td class='pictureCell' valign='top'>\n<a  href='http://{$_SERVER['HTTP_HOST']}/custom_images?login=1'><img width='200' src=\"http://{$_SERVER['HTTP_HOST']}$txtThumbnailLocation\" /></a>\n</td>\n</tr>\n";
		$txtApprovalMessage .= "</table>\n";
		$txtApprovalMessage .="<div id='footer'>\n";
		$txtApprovalMessage .= "<p ><strong>Harmony Designs, Inc.</strong><br>129 East Harmony Road, West Grove, PA 19390 <br>Phone: 888.293.1109 | Fax: 610.869.7415 | Email: <a href=\"mailto:info@harmonydesigns.com\">info@harmonydesigns.com</a><br>";
		$txtApprovalMessage .= "       Website: <a href=\"http://www.harmonydesigns.com/\">www.harmonydesigns.com</a></p>";
		//$txtApprovalMessage .= "<p align=\"center\">Bookmarks &bull; Paperweights &bull; Magnets &bull; Keychains &bull; Mugs &bull; Rulers &bull; T-shirts &bull; Ornaments &bull; Tote Bags<br> &bull; Mouse Pads &bull; Puzzles &bull; Pins &bull; Stamps on a Card &bull; Paperweight Kits<br>";
		$txtApprovalMessage .= "</div>\n";
		$txtApprovalMessage .= "</div>\n";
		$txtApprovalMessage .= "</body>\n</html>";
/*		
		mail($txtEMailAddress, "Your Custom Image Approval from Harmony Designs", $txtApprovalMessage, $headers);
*/
	error_log("7");
$body = $txtApprovalMessage;
$host = "mail.harmonydesigns.com";
$from = "info@harmonydesigns.com";
if(isset($mode) && $mode == 'debug'){
	$to = 'jacka510@mac.com';
}else{
	$to = $txtEMailAddress;
}
$subject = "Your Custom Image Approval from Harmony Designs";
// $headers = array ('From' => $from, 'To' => $to,'Subject' => $subject);
$headers = array ('From' => $from, 'To' => $to,'Subject' => $subject,'Content-type' => 'text/html');
$auth_user = 'orders@harmonydesigns.com';
$auth_pass = '!bookmark#2014';
	error_log("8");
$smtp = Mail::factory('smtp', array ('host' => $host, 'auth' => true, 'username'=>$auth_user, 'password'=>$auth_pass));
	error_log("9");
$mail = $smtp->send($to, $headers, $body);
	error_log("10");
if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . " ($auth_user, $host)</p>");
 } 
	error_log("11");
	};
	error_log("12");


$title = "Custom Graphic Approval Page";
	
include ('../includes/htmlTop.php');
?>
<style type="text/css" media="all">
<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetextgrey { color: gray; font-weight: normal; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {font-size: medium}

.style2 {font-size: x-small}
-->  
</style>
	
</head>
<body>
<div id="mainContainer">
<?php include("../includes/header.php"); ?>
<div id="mainContent">
<ul class="admin38_submenu">
<li><a href="../menu.php">Main</a></li>
<li><a href="menu.php">Parts Menu</a></li>
<li><a href="approvecustom.php">Back to Custom Menu</a></li>
</ul>		
<br style="clear:both">
		<table width="700" border="0" cellspacing="0" cellpadding="0">

				<td class="basetext">
					<p>This image has been updated in the database.</p>
				<?php if ($txtSendMail == "Queued"){?>
					<p>An e-mail has been sent concerning the status of this image. </p>					</td>
				<?php };?>
			</tr>
		</table>
</div><!--mainContent-->

<?php include ('../includes/footer.php'); ?>      
</div><!--mainContainer-->
<?php include ('../includes/htmlBottom.php'); ?>
