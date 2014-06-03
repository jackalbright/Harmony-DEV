<?php
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
		$txtApprovalMessage = "<html><head><style type=\"text/css\" media=\"all\">";
		$txtApprovalMessage .= "body{background-color: #FFFFD0; background-image: url(http://www.harmonydesigns.com/new-images/background.gif); margin: 6px; font-family: \"Arial\", sans-serif; font-size: 10pt; background-repeat: no-repeat; width: 500px; border-color: #090; border-width: 0 1px 0 0; border-style: none none none none;}";
		$txtApprovalMessage .= ".imgButton{	padding: 0px; margin: 0px; border-width: 0px; height: 29px; background-color: #FFE;}";
		$txtApprovalMessage .= ".nowrap { white-space: nowrap; }";
		$txtApprovalMessage .= "p { margin: 0 0 .5em 0; }";
		$txtApprovalMessage .= "h1,h2,h3,h4,h5,h6{color: #060; font-family: \"Times\", serif;	font-weight: bold; margin: 0 0 5px 0;}";
		$txtApprovalMessage .= "h1 { font-size: 32px; }";
		$txtApprovalMessage .= "h2 { font-size: 21px; }";
		$txtApprovalMessage .= "h3 { font-size: 17px; }";
		$txtApprovalMessage .= "h4 { font-size: 15px; }";
		$txtApprovalMessage .= "h5 { font-size: 12px; }";
		$txtApprovalMessage .= "h6 { font-size: 11px; }";
		$txtApprovalMessage .= "a h1,a h2,a h3,a h4,a h5,a h6{color: #039; text-decoration: none;}";
		$txtApprovalMessage .= "a h1:hover,a h2:hover,a h3:hover,a h4:hover,a h5:hover,a h6:hover { color: #909; }";
		$txtApprovalMessage .= ".center { text-align: center; }";
		$txtApprovalMessage .= ".right { text-align: right; }";
		$txtApprovalMessage .= "a:link { color: #039; }";
		$txtApprovalMessage .= "a:visited { color: #903; }";
		$txtApprovalMessage .= "a:hover { color: #909; }";
		$txtApprovalMessage .= "a:active { color: #309; }";
		$txtApprovalMessage .= "hr.narrow { margin: 0; }";
		$txtApprovalMessage .= ".note{font-size: smaller; font-style: italic; font-weight: normal;}";
		$txtApprovalMessage .= ".super{vertical-align: super; font-size: 0.7em;}";
		$txtApprovalMessage .= ".sub{vertical-align: sub; font-size: 0.7em;}";
		$txtApprovalMessage .= ".divider { clear: both; }";
		$txtApprovalMessage .= "div#header{width: 760px; height: 88px;}";
		$txtApprovalMessage .= "#header img { border-width: 0px; }";
		$txtApprovalMessage .= "#header img#logo{position: absolute; top: 4px; left: 17px;}";
		$txtApprovalMessage .= "#header img#slogan{position: absolute; top: 10px; left: 186px;}";
		$txtApprovalMessage .= "div#title{clear: right;}";
		$txtApprovalMessage .= "</style></head><body>";
		$txtApprovalMessage .= "<div id=\"header\"><a href=\"www.harmonydesigns.com/index.php\"><img id=\"logo\" src=\"http://www.harmonydesigns.com/new-images/large-logo.gif\" width=\"160\" height=\"79\" border=\"0\"></a><img id=\"slogan\" src=\"http://www.harmonydesigns.com/new-images/Slogan.gif\" width=\"387\" height=\"18\">\n";
		$txtApprovalMessage .= "</div><p><br>";
		$txtApprovalMessage .= "Dear $txtFirstName $txtLastName,\n<BR><BR>\n<img src=\"http://www.harmonydesigns.com$txtThumbnailLocation\" align=\"right\"/>";
		if ($txtApprovalStatus == "Yes"){
			$txtApprovalMessage = $txtApprovalMessage . "Thank you for uploading your art, image, photo or graphic.  We have approved the image that you have uploaded to our website.  Any gifts that you have already ordered will be created and shipped.  You can create other gift items with the same image by going to the &quot;Your Account&quot; area and clicking on the &quot;Custom Image&quot; menu.\n"; 
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
			$txtApprovalMessage = $txtApprovalMessage . "Any items that you have ordered with this graphic are &quot;on hold&quot; for a maximum of five business days until we receive art that meets our guidelines.  Please let us know how wish to proceed.";
		};
		if ($txtAdditionalNotes != ""){
			$txtApprovalMessage = $txtApprovalMessage . "<BR><BR>$txtAdditionalNotes\n";
		};
		$txtApprovalMessage .= "<BR><BR>Best Regards,<BR><BR><BR>Sherrill Franklin<BR>Harmony Designs, Inc.</p><HR>";
		$txtApprovalMessage .= "<p align=\"center\">Harmony Designs, Inc. ...making history one piece at a time since 1992 <BR>129 E. Harmony Road West Grove, PA 19390 <br>Order line: 1-888-293-1109 Project consult line: 610-869-4234<br>Fax: 610-869-7415<br>email: <a href=\"mailto:info@harmonydesigns.com\">info@harmonydesigns.com</a><br>";
		$txtApprovalMessage .= "email: <a href=\"mailto:orders@harmonydesigns.com\">orders@harmonydesigns.com</a><br>website: <a href=\"http://www.harmonydesigns.com/\">www.harmonydesigns.com</a></p>";
		$txtApprovalMessage .= "<p align=\"center\">Bookmarks &bull; PageWeights &bull; Magnets &bull; Keychains &bull; Posters &bull; Mugs &bull; Rulers <br>&bull; Pins &bull; Framed Stamps &bull; Stamps on a Card &bull; Paperweight Kits<br>";
		$txtApprovalMessage .= "</p></body></html>";
		mail($txtEMailAddress, "Your Custom Image Approval from Harmony Designs", $txtApprovalMessage, $headers);
	};

?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>Custom Graphic Approval Page</title>
		<style type="text/css" media="all">
		<!--
			.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
			.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
			.basetext { color: black; font-weight: normal; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
			.basetextgrey { color: gray; font-weight: normal; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
			.style1 {font-size: medium}
			body { background-color: white; }
.style2 {font-size: x-small}
		-->
		</style>
	</head>
	<body>
		<table width="700" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" width="200">
					<div align="center"><img src="../hdlogo.gif" alt="" height="78" width="160" border="0"></div>
				</td>
				<td valign="bottom">
					<div align="center">
						<span class="title">Custom Graphic Approval Page</span>
					</div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top">
					<p class="title style1">Navigation:</p>
					<p class="basetext style2">
						<a href="../menu.php">Back to Main Menu</a><br>
						<a href="menu.php">Back to Parts Menu</a><br>
						<a href="approvecustom.php">Back to Custom Image Menu</a></p>
			    </td>
				<td class="basetext">
					<p>This image has been updated in the database.</p>
				<?php if ($txtSendMail == "Queued"){?>
					<p>An e-mail has been sent concerning the status of this image. </p>					</td>
				<?php };?>
			</tr>
		</table>
	</body>
</html>