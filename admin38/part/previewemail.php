<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 11/29/04
******************************************************************************************/
	session_start();
	if (!array_key_exists('UName', $_SESSION)){
		header ('Location: ../index.php');
	} else {
		$manageOrders=$_SESSION['canManageOrders'];
		$manageParts=$_SESSION['canManageParts'];
		$manageUsers=$_SESSION['canManageUsers'];
		$manageItems=$_SESSION['canManageItems'];
		$manageEvents=$_SESSION['canManageEvents'];
		$manageDatabase=$_SESSION['canManageDatabase'];
		$manageTestimonials=$_SESSION['canManageTestimonials'];
	};
	if ($_SESSION['canManageParts']!="Yes"){
		header ('Location: ../menu.php');
	};
?>
<?php 
	$txtImageID = stripslashes($_GET['txtImageID']);
	$txtApprovalStatus = stripslashes($_GET['txtApprovalStatus']);
	$txtRefusalReason = (array)$_GET['txtRefusalReason'];
	$txtOtherReason = stripslashes(htmlentities($_GET['txtOtherReason']));
	$txtAdditionalNotes = stripslashes(htmlentities($_GET['txtAdditionalNotes']));
	$txtQueryString = "SELECT customer.First_Name, customer.Last_Name, custom_image.display_location FROM customer, custom_image WHERE custom_image.Image_ID = $txtImageID AND customer.Customer_ID = custom_image.Customer_ID";
    include ('../../includes/database.inc');
    $result = mysql_query ($txtQueryString, $database);
	if ($result){
	   	while ($row = mysql_fetch_row($result)){
			$txtCustomerFirstName=$row[0];
			$txtCustomerLastName=$row[1];
			$txtThumbnailLocation=$row[2];
        };
	};
     mysql_close($database);
	$txtName = $txtFirstName;
	$txtName .= ($txtName?" ":"").$txtLastName;
	$txtApprovalMessage .= "Hello".($txtName?" $txtName":"").",\n<BR><BR>\n<a style='float: right;' href='http://{$_SERVER['HTTP_HOST']}/custom_images?login=1'><img width='200' src=\"http://{$_SERVER['HTTP_HOST']}$txtThumbnailLocation\" align=\"right\"/></a>";
	if ($txtApprovalStatus == "Yes"){
		$txtApprovalMessage = $txtApprovalMessage . "Thank you for uploading your art, image, photo or graphic.  We have approved the image that you have uploaded to our website. To view your saved image and order online, visit <a href='http://{$_SERVER['HTTP_HOST']}/custom_images?login=1'>http://{$_SERVER['HTTP_HOST']}/custom_images</a>.";#Any gifts that you have already ordered will be created and shipped.  You can create other gift items with the same image by going to the &quot;Your Account&quot; area and clicking on the &quot;Custom Image&quot; menu.\n"; 
	} elseif ($txtApprovalStatus == "No") {
		$txtApprovalMessage = $txtApprovalMessage . "Thank you for uploading your art, image, photo or graphic.  Because of the following problems, your art will not reproduce successfully on your gift item(s):";
		foreach($txtRefusalReason as $value){
			$value = stripslashes($value);
			$txtQueryString = "SELECT reason_item, reason_explanation FROM refusal_reasons WHERE reason_id = $value";
			include ('../../includes/database.inc');
    		$result = mysql_query ($txtQueryString, $database);
			if ($result){
				echo "<UL>";
			};
    		while ($row = mysql_fetch_row($result)){
					$txtReasonItem=$row[0];
					$txtReasonExplanation=$row[1];
					$txtApprovalMessage = $txtApprovalMessage . "<LI><B>$txtReasonItem:</B>  $txtReasonExplanation";
       		};
     		mysql_close($database);
			if ($value=="'8'"){
				$txtApprovalMessage = $txtApprovalMessage . "<BLOCKQUOTE>$txtOtherReason</BLOCKQUOTE>";
			}; 
			$txtApprovalMessage = $txtApprovalMessage . "</LI>";
		};
			if ($result){
				echo "</UL>";
			};
		#$txtApprovalMessage = $txtApprovalMessage . "Any items that you have ordered with this graphic are &quot;on hold&quot; for a maximum of five business days until we receive art that meets our guidelines.  Please let us know how you wish to proceed.";
	};
	if(!empty($txtAdditionalNotes))
	{
		$txtApprovalMessage = $txtApprovalMessage . "<BR><BR>$txtAdditionalNotes<BR>";
	}
	$txtApprovalMessage .= "<br/><br/>Please note:  This is approval information about your art only. You will receive a separate confirmation once an order is placed. If you have any questions, please email:  info@harmonydesigns.com  We look forward to working with you. <br><br>";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>E-mail Preview</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<style type="text/css" media="all">
body{background-color: #FFFFD0; margin: 25px; font-family: "Arial", sans-serif; font-size: 10pt; background-repeat: no-repeat; width: 600px; border-color: #090; border-width: 0 1px 0 0; border-style: none none none none;}
.imgButton{	padding: 0px; margin: 0px; border-width: 0px; height: 29px; background-color: #FFE;}
.nowrap { white-space: nowrap; }
p { margin: 0 0 .5em 0; }
h1,h2,h3,h4,h5,h6{color: #060; font-family: "Times", serif;	font-weight: bold; margin: 0 0 5px 0;}
h1 { font-size: 32px; }
h2 { font-size: 21px; }
h3 { font-size: 17px; }
h4 { font-size: 15px; }
h5 { font-size: 12px; }
h6 { font-size: 11px; }
a h1,a h2,a h3,a h4,a h5,a h6{color: #039; text-decoration: none;}
a h1:hover,a h2:hover,a h3:hover,a h4:hover,a h5:hover,a h6:hover { color: #909; }
.center { text-align: center; }
.right { text-align: right; }
a:link { color: #039; }
a:visited { color: #903; }
a:hover { color: #909; }
a:active { color: #309; }
hr.narrow { margin: 0; }
.note{font-size: smaller; font-style: italic; font-weight: normal;}
.testimonial{text-align: left; color: #060; font-style: italic; font-weight: bold; margin-bottom: 0.25em;}
.attribution{text-align: right; color: #060; font-style: italic; margin-top: 0.25em;}
.super{vertical-align: super; font-size: 0.7em;}
.sub{vertical-align: sub; font-size: 0.7em;}
.divider { clear: both; }
div#header{width: 760px; height: 88px;}
#header img { border-width: 0px; }
#header img#logo{position: absolute; top: 4px; left: 17px;}
#header img#slogan{position: absolute; top: 10px; left: 186px;}
div#title{clear: right;}
</style>
</head>
<body>
<div id="header"><a href="www.harmonydesigns.com/index.php"><img id="logo" src="http://www.harmonydesigns.com/images-shared/large-logo.gif" border="0"></a>
</div>
<p><br>
  <?php echo $txtApprovalMessage; ?><BR>
Best Regards,<BR>

<BR><BR>Sherrill Franklin<BR>
Harmony Designs, Inc.
</p><HR>
<p align="center">Harmony Designs, Inc. ...making history one piece at a time since 1992 <BR>129 E. Harmony Road West Grove, PA 19390 <br>
  Phone: 888.293.1109<br/>
  Fax: 610.869.7415<br>
  Email: <a href="mailto:info@harmonydesigns.com">info@harmonydesigns.com</a><br>
  Website: <a href="http://www.harmonydesigns.com/">www.harmonydesigns.com</a></p>
<p align="center">Bookmarks &bull; Paperweights &bull; Magnets &bull; Keychains &bull; Mugs &bull; Rulers &bull; T-shirts &bull; Ornaments &bull; Tote Bags <br>
 &bull; Mouse Pads &bull; Puzzles &bull; Pins &bull; Stamps on a Card &bull; Paperweight Kits<br>
</p>
</body>
</html>
