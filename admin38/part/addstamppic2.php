<?php
/******************************************************************************************
Edited by: John Plecenik
Last edited: 10/23/2006
******************************************************************************************/
	//generalized image load function
	function loadImage ( $imgFile ) {
		$type = exif_imagetype ($imgFile);
		switch ($type) {
			case IMAGETYPE_GIF:
				$img = @imageCreateFromGIF ( $imgFile );
				break;
			case IMAGETYPE_JPEG:
				$img = @imageCreateFromJPEG ( $imgFile );
				break;
			case IMAGETYPE_PNG:
				$img = @imageCreateFromPNG ( $imgFile );
				break;
			default:
				$img = false;
				break;
		}
		if ($img)
			return $img;
		else
			return false;
	}

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

	include ('../../includes/admin.inc');
	// PHP configuration directives for this script
	ini_set ('max_execution_time', 180);
	ini_set ('memory_limit', 20000000);

	$txtCatalogNumber=$_POST['txtCatalogNumber'];
	$uploadDirectory = '/home/harmony/www/temp/';
	$uploadExtension = strrchr($_FILES['fileStampImage']['name'], '.');
	$uploadName = $txtCatalogNumber . $uploadExtension;
	$uploadFile = $uploadDirectory . $uploadName;
	$tempfileaddress = '../../temp/' . $uploadName;
	$uploadFile = $_FILES['fileStampImage']['tmp_name'];
    $imageSize=getimagesize($uploadFile);
	$imageWidth=$imageSize[0];
	$imageHeight=$imageSize[1];
	$stampImage = '../../stamps/' . $uploadName;
	$thumbImage = '../../thumbnails/' . $uploadName;	
	$sourceImage='../../temp/' . $uploadName;
	$imgSource = loadImage($uploadFile);
	if ($imageHeight >= ($imageWidth * 1.5)){
		$stampHeight=200;
		$stampWidth = floor($imageWidth * $stampHeight / $imageHeight);
	} else {
		$stampWidth=180;
		$stampHeight= floor($imageHeight * $stampWidth / $imageWidth);
	};
	$thumbHeight=60;
	$thumbWidth= floor($imageWidth * $thumbHeight / $imageHeight);
	$newWidth = $stampWidth;
	$newHeight = $stampHeight;
	
	$imgDest = imagecreatetruecolor($newWidth, $newHeight);
	imagecopyresampled($imgDest, $imgSource, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);
	
	#imagejpeg($imgDest, $stampImage, 60);
	imagegif($imgDest, $stampImage, 60);
	$newWidth = $thumbWidth;
	$newHeight = $thumbHeight;
	$imgDest = imagecreatetruecolor($newWidth, $newHeight);
	imagecopyresampled($imgDest, $imgSource, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);
	#imagejpeg($imgDest, $thumbImage, 60);
	imagegif($imgDest, $thumbImage, 60);
		
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
			      <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br><a href="menu.php">Back to Parts Menu</a><br>
                      <a href="stampsmenu.php">Back to Stamp Menu</a> </p>
			      <p>&nbsp;</p>
			      <p>&nbsp; </p></td>
				<td valign='top'><p><br>
				    <span class="style6">Thumbnail Image</span></p>
			    <p><img src="<?php echo $thumbImage; ?>"></p>
			    <p class="style6">Stamp Image</p>
			    <p><img src="<?php echo $stampImage; ?>"></p>
			    <p>To enter a new stamp image, click <a href="addstamppic.php">here</a>. </p>
			    <p>To enter the description for this stamp, click <a href="addstamp.php?StampID=<?php echo $txtCatalogNumber; ?>">here</a>. </p></td>
			</tr>
		</table>
		<p></p>
	</body>

</html>
