<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 8/10/05
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
	include ('../../includes/admin.inc');
?>
<?php
$catalognumber=$_POST['hdncatalognumber'];
$txtCatalogNumber=$_POST['txtCatalogNumber'];
$txtOldCatalogNumber=$_POST['txtOldCatalogNumber'];
$txtStampName=addslashes($_POST['txtStampName']);
$txtIssueDate=$_POST['txtIssueDate'];
$txtSeries=addslashes($_POST['txtSeries']);
$txtFaceValue=$_POST['txtFaceValue'];
$txtShortDescription=addslashes($_POST['txtShortDescription']);
$txtLongDescription=addslashes($_POST['txtLongDescription']);
$txtCountry=addslashes($_POST['txtCountry']);
$txtKeywords=addslashes($_POST['txtKeywords']);
$txtHTMLKeywords=addslashes($_POST['txtHTMLKeywords']);
$txtThumbnailLocation=addslashes($_POST['txtThumbnailLocation']);
$txtImageLocation=$_POST['txtImageLocation'];
$cbAvailable=$_POST['cbAvailable'];
$cbReproducible=$_POST['cbReproducible'];
$hdnEntryDate=$_POST['hdnEntryDate'];
$cbSurcharge=$_POST['cbSurcharge'];
if ($_POST['cbSurcharge'] == 'True')
  {
    $txtCharge1=$_POST['txtCharge1'];
    $txtCharge12=$_POST['txtCharge12'];
    $txtCharge50=$_POST['txtCharge50'];
    $txtCharge100=$_POST['txtCharge100'];
    $txtCharge250=$_POST['txtCharge250'];
    $txtCharge500=$_POST['txtCharge500'];
    $txtCharge1000=$_POST['txtCharge1000'];
    $txtCharge2500=$_POST['txtCharge2500'];
    $txtCharge5000=$_POST['txtCharge5000'];
    $txtCharge7500=$_POST['txtCharge7500'];
  } else {
    $txtCharge1="0.00";
    $txtCharge12="0.00";
	$txtCharge50="0.00";
    $txtCharge100="0.00";
    $txtCharge250="0.00";
    $txtCharge500="0.00";
    $txtCharge1000="0.00";
    $txtCharge2500="0.00";
    $txtCharge5000="0.00";
    $txtCharge7500="0.00";
 }
 #echo "CHARGE=$txtCharge1";
 $txtBorders=(array)$_POST['txtRecBorder'];
 $txtRecBorder=join(", ",$txtBorders);
 $txtCharms=(array)$_POST['txtRecCharm'];
 $txtRecCharm=join(", ",$txtCharms);
 $txtQuotes=(array)$_POST['txtRecQuote'];
 $txtRecQuote=join(", ",$txtQuotes);
 $txtRibbons=(array)$_POST['txtRecRibbon'];
 $txtRecRibbon=join(", ",$txtRibbons);
 $txtTassels=(array)$_POST['txtRecTassel'];
 $txtRecTassel=join(", ",$txtTassels);
 
 $txtNodes= (array)$_POST['txtSuggestedNodes'];
 $txtSuggestedNodes=join(", ", $txtNodes);
 if ($cbAvailable != "True")
     {
       $txtAvailable="No";
     } else {
       $txtAvailable="Yes";
     };
	if ($cbReproducible == "True") {
		$txtReproducible="Yes";
	} elseif ($cbReproducible == "Only"){
		$txtReproducible="Only";
	} else {
		$txtReproducible="No";
	};
 ?>
<?php
	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM stamp WHERE catalog_number='$catalognumber'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM stamp WHERE catalog_number='$txtCatalogNumber'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
	include ('../../includes/database.inc');
    $txtQueryString = "INSERT stamp (catalog_number, old_catalog_number, face_value, issue_date, series, stamp_name, long_description, short_description, country, keywords, HTML_Keywords, image_location, available, thumbnail_location, reproducible, entry_date) VALUES ('$txtCatalogNumber', '$txtOldCatalogNumber', '$txtFaceValue', '$txtIssueDate', '$txtSeries', '$txtStampName', '$txtLongDescription', '$txtShortDescription', '$txtCountry', '$txtKeywords', '$txtHTMLKeywords', '$txtImageLocation', '$txtAvailable', '$txtThumbnailLocation', '$txtReproducible', '$hdnEntryDate')";
    $result = mysql_query ($txtQueryString, $database); 
    $stamp_id = mysql_insert_id($database);
	mysql_close($database);

	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM stamp_surcharge WHERE catalog_number='$catalognumber'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);

	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM stamp_surcharge WHERE catalog_number='$txtCatalogNumber'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);

    if ($cbSurcharge=="True"){
		include ('../../includes/database.inc');
        $txtQueryString = "INSERT stamp_surcharge (stamp_id, catalog_number, surcharge, per1, per12, per50, per100, per250, per500, per1000, per2500, per5000, per7500) VALUES ('$stamp_id', '$txtCatalogNumber', '$txtCharge1', '$txtCharge1', '$txtCharge12', '$txtCharge50', '$txtCharge100', '$txtCharge250', '$txtCharge500', '$txtCharge1000', '$txtCharge2500', '$txtCharge5000', '$txtCharge7500')";
	#echo "QUERY=$txtQueryString";
        $result = mysql_query ($txtQueryString, $database);
	#echo "RES=$result".mysql_error()."\n";
        mysql_close($database);
     }

 	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM rec_border WHERE catalog_number='$catalognumber'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
 	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM rec_border WHERE catalog_number='$txtCatalogNumber'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
     foreach ($txtBorders as $txtBorder)
     {
		include ('../../includes/database.inc');
        $txtQueryString = "INSERT rec_border (Catalog_Number, Border_ID) VALUES ('$txtCatalogNumber', '$txtBorder')";
        $result = mysql_query ($txtQueryString, $database);
        mysql_close($database);
     };
 	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM rec_charm WHERE catalog_number='$catalognumber'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
 	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM rec_charm WHERE catalog_number='$txtCatalogNumber'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
     foreach ($txtCharms as $txtCharm)
     {
		include ('../../includes/database.inc');
        $txtQueryString = "INSERT rec_charm (Catalog_Number, Charm_id) VALUES ('$txtCatalogNumber', '$txtCharm')";
        $result = mysql_query ($txtQueryString, $database);
        mysql_close($database);
     };
	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM rec_quote WHERE catalog_number='$catalognumber'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM rec_quote WHERE catalog_number='$txtCatalogNumber'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
     foreach ($txtQuotes as $txtQuote)
     {
		include ('../../includes/database.inc');
        $txtQueryString = "INSERT rec_quote (Catalog_Number, Quote_ID) VALUES ('$txtCatalogNumber', '$txtQuote')";
        $result = mysql_query ($txtQueryString, $database);
        mysql_close($database);
     };
	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM rec_ribbon WHERE catalog_number='$catalognumber'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM rec_ribbon WHERE catalog_number='$txtCatalogNumber'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
     foreach ($txtRibbons as $txtRibbon)
     {
		include ('../../includes/database.inc');
        $txtQueryString = "INSERT rec_ribbon (Catalog_Number, Ribbon_ID) VALUES ('$txtCatalogNumber', '$txtRibbon')";
        $result = mysql_query ($txtQueryString, $database);
        mysql_close($database);
     };
	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM rec_tassel WHERE catalog_number='$catalognumber'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM rec_tassel WHERE catalog_number='$txtCatalogNumber'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
     foreach ($txtTassels as $txtTassel)
     {
		include ('../../includes/database.inc');
        $txtQueryString = "INSERT rec_tassel (Catalog_Number, Tassel_ID) VALUES ('$txtCatalogNumber', '$txtTassel')";
        $result = mysql_query ($txtQueryString, $database);
        mysql_close($database);
     };
	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM browse_link WHERE catalog_number='$catalognumber'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM browse_link WHERE catalog_number='$txtCatalogNumber'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
     foreach ($txtNodes as $txtNode)
     {
		include ('../../includes/database.inc');
        $txtQueryString = "INSERT browse_link (catalog_number, browse_node_id) VALUES ('$txtCatalogNumber', '$txtNode')";
        $result = mysql_query ($txtQueryString, $database);
        mysql_close($database);
     };
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Stamp Edit Page</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetextgrey { color: gray; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
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
						<span class="title">Stamp Edit Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title style1">Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
				      <a href="menu.php">Back to Parts Menu</a><br>
                      <a href="stampsmenu.php">Back to Stamp Menu</a> </p></td>
				<td>
					<div align="center">					  
					  <p class="basetext">
					  The changes to this stamp have been entered into the database. </p>
					  <p class="basetext">&nbsp;
				      </p>
					  <p class="basetext"><strong>To see how the stamp looks on the site, click <a href="../../product/detail.php?catalogNumber=<?php echo htmlentities($txtCatalogNumber); ?>" target="_blank">here</a>. </strong></p>
						<p><span class="basetext"><b>To enter a new stamp or to edit a stamp, click <a href="stampsmenu.php">here</a>.</b></span></p>
						<p><span class="basetext"><b>To return to the main menu, click <a href="menu.php">here</a>.</b></span></p>
						<p></p>
				  </div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>
