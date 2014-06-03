<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 10/06/04
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
	if ($_SESSION['canManageEvents']!="Yes"){
		header ('Location: ../menu.php');
	};
?>
<?php
	include ('../../includes/admin.inc');
	// PHP configuration directives for this script
	ini_set ('max_execution_time', 180);
	ini_set ('memory_limit', 20000000);
?>
<?php
	$txtImageTitle=$_POST['txtImageTitle'];
	$uploadDirectory = '/vservers/harmonydesignsco/htdocs/temp/';
	$uploadExtension = strrchr($_FILES['fileImage']['name'], '.');
	$uploadName = $txtImageTitle . $uploadExtension;
	$uploadFile = $uploadDirectory . $uploadName;
	$tempfileaddress = '../../temp/' . $uploadName;
	move_uploaded_file($_FILES['fileImage']['tmp_name'], $uploadFile);
$imageSize=getimagesize($tempfileaddress);
	$imageWidth=$imageSize[0];
	$imageHeight=$imageSize[1];
	$eventImage = '../../event-images/' . $uploadName;
	$sourceImage='../../temp/' . $uploadName;
	$imgSource = imagecreatefromjpeg($sourceImage);
	$eventWidth=150;
	$eventHeight= floor($imageHeight * $eventWidth / $imageWidth);
	$newWidth = $eventWidth;
	$newHeight = $eventHeight;
	$imgDest = imagecreatetruecolor($newWidth, $newHeight);
	imagecopyresampled($imgDest, $imgSource, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);
	imagejpeg($imgDest, $eventImage, 60);		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Stamp Addition Page</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetextgrey { color: gray; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetextSurcharge {
color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular
}
.style3 {font-size: medium}
.style6 {color: #0000CC; font-style: normal; font-weight: bolder; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular; }
--></style>
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
						<span class="title">Stamp Image Addition Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top" class="title style3"><p>Navigation:</p>
			      <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
			        <a href="menu.php">Back to Event Menu</a><br>
</p>
			      <p>&nbsp;</p>
			      <p>&nbsp; </p></td>
				<td valign='top'><p><br>
				    <span class="style6">Event Image</span></p>
			      <p><img src="<?php echo $eventImage;?>"></p>
			    <p class="style6">Event Image Location</p>
			    <p><b><?php 
				$imageLocation = '/event-images/' . $uploadName;
				echo $imageLocation; ?></b></p>
			    <p class="basetext">To enter a new event image, click <a href="addeventimage.php">here</a>. </p>
			    <p class="basetext">To enter the description for this event, click <a href="addevent.php?ImageLoc=<?php echo $imageLocation; ?>">here</a>. </p></td>
			</tr>
		</table>
		<p></p>
	</body>
</html>