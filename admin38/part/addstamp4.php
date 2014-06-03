<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 8/10/05
******************************************************************************************/
session_start();
if (!array_key_exists('UName', $_SESSION)){
	header ('Location: ../index.php');
	exit(0);
} 

if ($_SESSION['canManageParts']!="Yes") {
	header ('Location: ../menu.php');
	exit(0);
}

include ('../../includes/admin.inc');

$txtCatalogNumber=$_POST['txtCatalogNumber'];
$txtStampName=addslashes($_POST['txtStampName']);
$txtIssueDate=$_POST['txtIssueDate'];
$txtSeries=addslashes($_POST['txtSeries']);
$txtFaceValue=addslashes($_POST['txtFaceValue']);
$txtShortDescription=addslashes($_POST['txtShortDescription']);
$txtLongDescription=addslashes($_POST['txtLongDescription']);
$txtKeywords=addslashes($_POST['txtKeywords']);
$txtCountry=addslashes($_POST['txtCountry']);
$txtHTMLKeywords=addslashes($_POST['txtHTMLKeywords']);
$txtThumbnailLocation=addslashes($_POST['txtThumbnailLocation']);
$txtImageLocation=addslashes($_POST['txtImageLocation']);
$cbAvailable=$_POST['cbAvailable'];
$cbReproducible=$_POST['cbReproducible'];
$cbSurcharge=$_POST['cbSurcharge'];

if ($_POST['cbSurcharge'] == 'True') {
	$txtCharge1= ( is_numeric($_POST['txtCharge1']) ? $_POST['txtCharge1'] : '0.00' );
	$txtCharge12=( is_numeric($_POST['txtCharge12']) ? $_POST['txtCharge12'] : '0.00' );
	$txtCharge50=( is_numeric($_POST['txtCharge50']) ? $_POST['txtCharge50'] : '0.00' );
	$txtCharge100=( is_numeric($_POST['txtCharge100']) ? $_POST['txtCharge100'] : '0.00' );
	$txtCharge250=( is_numeric($_POST['txtCharge250']) ? $_POST['txtCharge250'] : '0.00' );
	$txtCharge500=( is_numeric($_POST['txtCharge500']) ? $_POST['txtCharge500'] : '0.00' );
	$txtCharge1000=( is_numeric($_POST['txtCharge1000']) ? $_POST['txtCharge1000'] : '0.00' );
	$txtCharge2500=( is_numeric($_POST['txtCharge2500']) ? $_POST['txtCharge2500'] : '0.00' );
	$txtCharge5000=( is_numeric($_POST['txtCharge5000']) ? $_POST['txtCharge5000'] : '0.00' );
	$txtCharge7500=( is_numeric($_POST['txtCharge7500']) ? $_POST['txtCharge7500'] : '0.00' );
}

$txtBorders=$_POST['txtRecBorder'];

$txtCharms=$_POST['txtRecCharm'];

$txtQuotes=$_POST['txtRecQuote'];

$txtRibbons=$_POST['txtRecRibbon'];

$txtTassels=$_POST['txtRecTassel'];

$txtNodes= $_POST['txtSuggestedNodes'];

if ($cbAvailable != "True") {
	$txtAvailable="No";
} else {
	$txtAvailable="Yes";
}
if ($cbReproducible == "True") {
	$txtReproducible="Yes";
} elseif ($cbReproducible == "Only"){
	$txtReproducible="Only";
} else {
	$txtReproducible="No";
}

$today=getdate();
$intStampFound=0;
include ('../../includes/database.inc');

$result = mysql_query ("SELECT * FROM `stamp` WHERE catalog_number='$txtCatalogNumber'", $database);
while ($event = mysql_fetch_object($result)) {
	$intStampFound++;
}
$txtToday = $today['year'] . "-" . $today['mon'] . "-" . $today['mday'];
echo $txtToday;         
if ($intStampFound==0) {
	$txtQueryString = "INSERT stamp (catalog_number, face_value, issue_date, series, stamp_name, long_description, short_description, country, keywords, HTML_Keywords, image_location, available, thumbnail_location, reproducible, entry_date) VALUES ('$txtCatalogNumber', '$txtFaceValue', '$txtIssueDate', '$txtSeries', '$txtStampName', '$txtLongDescription', '$txtShortDescription', '$txtCountry', '$txtKeywords', '$txtHTMLKeywords', '$txtImageLocation', '$txtAvailable', '$txtThumbnailLocation', '$txtReproducible', '$txtToday')";
	error_log($txtQueryString);
	$result = mysql_query ($txtQueryString, $database);
	
	if ($cbSurcharge=="True") {
		$txtQueryString = "INSERT stamp_surcharge (catalog_number, per1, per12, per50, per100, per250, per500, per1000, per2500, per5000, per7500, surcharge) VALUES ('$txtCatalogNumber', '$txtCharge1', '$txtCharge12', '$txtCharge50', '$txtCharge100', '$txtCharge250', '$txtCharge500', '$txtCharge1000', '$txtCharge2500', '$txtCharge5000', '$txtCharge7500', '$txtCharge7500')";
		$result = mysql_query ($txtQueryString, $database);
	}
	
	foreach ($txtBorders as $txtBorder) {
		$txtQueryString = "INSERT rec_border (Catalog_Number, Border_ID) VALUES ('$txtCatalogNumber', '$txtBorder')";
		$result = mysql_query ($txtQueryString, $database);
	}
	
	foreach ($txtCharms as $txtCharm) {
		$txtQueryString = "INSERT rec_charm (Catalog_Number, Charm_id) VALUES ('$txtCatalogNumber', '$txtCharm')";
		$result = mysql_query ($txtQueryString, $database);
	}
	
	foreach ($txtQuotes as $txtQuote) {
		$txtQueryString = "INSERT rec_quote (Catalog_Number, Quote_ID) VALUES ('$txtCatalogNumber', '$txtQuote')";
		$result = mysql_query ($txtQueryString, $database);
	}
	
	foreach ($txtRibbons as $txtRibbon) {
		$txtQueryString = "INSERT rec_ribbon (Catalog_Number, Ribbon_ID) VALUES ('$txtCatalogNumber', '$txtRibbon')";
		$result = mysql_query ($txtQueryString, $database);
	}
	
	foreach ($txtTassels as $txtTassel) {
		$txtQueryString = "INSERT rec_tassel (Catalog_Number, Tassel_ID) VALUES ('$txtCatalogNumber', '$txtTassel')";
		$result = mysql_query ($txtQueryString, $database);
	}
	
	foreach ($txtNodes as $txtNode) {
		$txtQueryString = "INSERT browse_link (catalog_number, browse_node_id) VALUES ('$txtCatalogNumber', '$txtNode')";
		$result = mysql_query ($txtQueryString, $database);
	}
}
mysql_close ($database);
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>Stamp Addition Page</title>
		<style type="text/css" media="all">
		<!--
			.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
			.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
			.basetext { color: black; font-weight: normal; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
			.basetextgrey { color: gray; font-weight: normal; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
			.style1 {font-size: medium}
			body { background-color: white; }
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
						<span class="title">Stamp Addition Page</span>
					</div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top">
					<p class="title style1">Navigation:</p>
					<p class="basetext">
						<a href="../menu.php">Back to Main Menu</a><br>
						<a href="menu.php">Back to Parts Menu</a><br>
						<a href="stampsmenu.php">Back to Stamp Menu</a>
					</p>
			    </td>
				<td>
					<div align="left" class="basetext">
					  <?php if ($intStampFound==0){ ?>						
							This stamp has been entered into the database successfully.
					  <?php } else { ?>
							Due to a database error, this stamp was not entered correctly into the database.  This could be for one of several reasons.
							<ul>
								<li>The stamp may have been entered into the database previously, possibly from another machine or possibly from navigating back to this page after the stamp had already been entered into the database.  Use the link below to see how the stamp looks on the site.  (Recommended:  Open the link in a new window.)  If the information shows up on that page, and the product build page, then it was obviously entered correctly.</li>
								<li>A database error may have occured while transmitting the information.  In this case, simply refresh this web page.  If this message comes up again, it is probably the first problem.</li>
								<li>Some unforseen problem may be preventing the data from being entered into the database.  Try changing the stamp information slightly and try submitting again.</li>					
							</ul>
						<?php }; ?>
					</div>					
					<p align="center" class="basetext">
						<strong>To see how the stamp looks on the site, click <a href="../../product/detail.php?catalogNumber=<?php echo htmlentities($txtCatalogNumber); ?>" target="_blank">here</a>. </strong>
					</p>
					<p align="center" class="basetext">
						<strong>To enter a new stamp or to edit a stamp, click <a href="stampsmenu.php">here</a>.</strong>
					</p>
					<p align="center" class="basetext">
						<strong>To return to the main menu, click <a href="menu.php">here</a>.</strong>
					</p>					
				</td>
			</tr>
		</table>
	</body>
</html>
