<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 10/27/04
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
$txtCatalogNumber=$_POST['txtCatalogNumber'];
$txtStampName=htmlentities($_POST['txtStampName']);
$txtIssueDate="$_POST[txtDateYear]-$_POST[txtDateMonth]-$_POST[txtDateDay]";
$txtSeries=htmlentities($_POST['txtSeries']);
$txtFaceValue=$_POST['txtFaceValue'];
$txtShortDescription=htmlentities($_POST['txtShortDescription']);
$txtLongDescription=htmlentities($_POST['txtLongDescription']);
$txtKeywords=htmlentities($_POST['txtKeywords']);
$txtHTMLKeywords=htmlentities($_POST['txtHTMLKeywords']);
$txtCountry=htmlentities($_POST['txtCountry']);
$txtThumbnailLocation=$_POST['txtThumbnailLocation'];
$txtImageLocation=$_POST['txtImageLocation'];
$cbAvailable=$_POST['cbAvailable'];
$cbReproducible=$_POST['cbReproducible'];
$cbSurcharge=$_POST['cbSurcharge'];
if ($_POST['cbSurcharge'] == 'True')
  {
    $txtCharge1=$_POST['txtPer1'];
    $txtCharge12=$_POST['txtPer12'];
    $txtCharge50=$_POST['txtPer50'];
    $txtCharge100=$_POST['txtPer100'];
    $txtCharge250=$_POST['txtPer250'];
    $txtCharge500=$_POST['txtPer500'];
    $txtCharge1000=$_POST['txtPer1000'];
    $txtCharge2500=$_POST['txtPer2500'];
    $txtCharge5000=$_POST['txtPer5000'];
    $txtCharge7500=$_POST['txtPer7500'];
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
?><?php
  function makerowsborders()
  {
	include ('../../includes/database.inc');
    $result = mysql_query ("SELECT border_id, name, location FROM `border` order by name", $database);
    while ($row = mysql_fetch_row($result))
        {
           $borderID=$row[0];
           $borderName=$row[1];
           $borderLocation=$row[2];
           echo "<option value=\"$borderID\">$borderName</option>\n";
         };
mysql_close($database);
  };
?><?php
  function makerowscharms()
  {
    include ('../../includes/database.inc');
    $result = mysql_query ("SELECT charm_id, name, graphic_location FROM `charm` order by name", $database);
    while ($row = mysql_fetch_row($result))
        {
           $charmID=$row[0];
           $charmName=$row[1];
           $charmLocation=$row[2];
           echo "<option value=\"$charmID\">$charmName</option>\n";
         };
         mysql_close($database);
  };
?><?php
  function makerowsquotes()
  {
	include ('../../includes/database.inc');
    $result = mysql_query ("SELECT quote_id, text, title, attribution FROM `quote` order by text, title", $database);
    while ($row = mysql_fetch_row($result))
        {
           $quoteID=$row[0];
           $quoteText=substr($row[1], 0,  30);
           $quoteTitle=substr($row[2], 0,  50);
           $quoteAttribution=substr($row[3], 0,  20);
          
           echo "<option value=\"$quoteID\">$quoteText $quoteTitle - $quoteAttribution</option>\n";
         };
         mysql_close($database);
  };
?><?php
  function makerowsribbons()
  {
	include ('../../includes/database.inc');
    $result = mysql_query ("SELECT ribbon_id, color_name, color_Code FROM `ribbon` order by color_name", $database);
    while ($row = mysql_fetch_row($result))
        {
           $ribbonID=$row[0];
           $ribbonColorName=$row[1];
           $ribbonColorCode=$row[2];
           echo "<option value=\"$ribbonID\">$ribbonColorName</option>\n";
         };
         mysql_close($database);
  };
?><?php
  function makerowstassels()
  {
	include ('../../includes/database.inc');
    $result = mysql_query ("SELECT tassel_id, color_name, color_Code FROM `tassel` order by color_name", $database);
    while ($row = mysql_fetch_row($result))
        {
           $tasselID=$row[0];
           $tasselColorName=$row[1];
           $tasselColorCode=$row[2];
           echo "<option value=\"$tasselID\">$tasselColorName</option>\n";
         };
         mysql_close($database);
  };
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>Stamp Addition Page</title>
<SCRIPT language="javascript" type="text/javascript">	
function checkForm(){
	var checkBorders=0;
	var checkCharms=0;
	var checkRibbons=0;
	var checkTassels=0;
	var ErrMsg="";
	var RecBorder = document.getElementById('txtRecBorder');
	var loopLimit = RecBorder.options.length;
	for (var loopIndex = 0; loopIndex < loopLimit; loopIndex++){
		if (RecBorder.options[loopIndex].selected == true){
			checkBorders++;
		};
	}; 
	if (checkBorders==0){
		ErrMsg="You must select at least one border to continue.\n";
	};
	var RecCharm = document.getElementById('txtRecCharm');
	loopLimit = RecCharm.options.length;
	for (loopIndex = 0; loopIndex < loopLimit; loopIndex++){
		if (RecCharm.options[loopIndex].selected == true){
			checkCharms++;
		};
	}; 
	if (checkCharms==0){
		ErrMsg=ErrMsg + "You must select at least one charm to continue.\n";
	};
	var RecRibbon = document.getElementById('txtRecRibbon');
	loopLimit = RecRibbon.options.length;
	for (loopIndex = 0; loopIndex < loopLimit; loopIndex++){
		if (RecRibbon.options[loopIndex].selected == true){
			checkRibbons++;
		};
	}; 
	if (checkRibbons==0){
		ErrMsg=ErrMsg + "You must select at least one ribbon to continue.\n";
	};

	var RecTassel = document.getElementById('txtRecTassel');
	loopLimit = RecTassel.options.length;
	for (loopIndex = 0; loopIndex < loopLimit; loopIndex++){
		if (RecTassel.options[loopIndex].selected == true){
			checkTassels++;
		};
	}; 
	if (checkTassels==0){
		ErrMsg=ErrMsg + "You must select at least one tassel to continue.\n";
	};
	if (ErrMsg != ""){
		alert (ErrMsg);
		return false;
	} else { 
		return true;
	};
};
</script>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetextgrey { color: gray; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style2 {font-weight: bold; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular; color: blue; font-style: normal;}
.style3 {color: #0033CC}
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
						<span class="title">Stamp Addition Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top" class="style3"><p class="style2" onClick="showborders()">Navigation:</p>
			      <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br><a href="menu.php">Back to Parts Menu</a><br>
                      <a href="stampsmenu.php">Back to Stamp Menu</a> </p>
			      <p class="style2" onClick="showborders()">Thumbnail:</p>
			      <p class="basetext"><img src="<?php echo "../.." . $txtImageLocation;?>"></p>			      <p></p></td>
				<td>
					<div align="center">
						<form action="addstamp2a.php" method="post" name="frmStamp" onSubmit="return checkForm();" >
						  <input type="hidden" name="txtCatalogNumber" value="<?php echo $txtCatalogNumber; ?>">
						  <input type="hidden" name="txtStampName" value="<?php echo $txtStampName; ?>">
						  <input type="hidden" name="txtIssueDate" value="<?php echo $txtIssueDate; ?>">
						  <input type="hidden" name="txtFaceValue" value="<?php echo $txtFaceValue; ?>">
						  <input type="hidden" name="txtSeries" value="<?php echo $txtSeries; ?>">
						  <input type="hidden" name="txtShortDescription" value="<?php echo $txtShortDescription; ?>">
						  <input type="hidden" name="txtLongDescription" value="<?php echo $txtLongDescription; ?>">
						  <input type="hidden" name="txtKeywords" value="<?php echo $txtKeywords; ?>">
						  <input type="hidden" name="txtCountry" value="<?php echo $txtCountry; ?>">
						  <input type="hidden" name="txtHTMLKeywords" value="<?php echo $txtHTMLKeywords; ?>">
						  <input type="hidden" name="txtThumbnailLocation" value="<?php echo $txtThumbnailLocation; ?>">
						  <input type="hidden" name="txtImageLocation" value="<?php echo $txtImageLocation; ?>">
						  <input type="hidden" name="cbAvailable" value="<?php echo $cbAvailable; ?>">
						  <input type="hidden" name="cbReproducible" value="<?php echo $cbReproducible; ?>">
						  <input type="hidden" name="cbSurcharge" value="<?php echo $cbSurcharge; ?>">
						  <input type="hidden" name="txtCharge1" value="<?php echo $txtCharge1; ?>">
						  <input type="hidden" name="txtCharge12" value="<?php echo $txtCharge12; ?>">
						  <input type="hidden" name="txtCharge50" value="<?php echo $txtCharge50; ?>">
						  <input type="hidden" name="txtCharge100" value="<?php echo $txtCharge100; ?>">
						  <input type="hidden" name="txtCharge250" value="<?php echo $txtCharge250; ?>">
						  <input type="hidden" name="txtCharge500" value="<?php echo $txtCharge500; ?>">
						  <input type="hidden" name="txtCharge1000" value="<?php echo $txtCharge1000; ?>">
						  <input type="hidden" name="txtCharge2500" value="<?php echo $txtCharge2500; ?>">
						  <input type="hidden" name="txtCharge5000" value="<?php echo $txtCharge5000; ?>">
						  <input type="hidden" name="txtCharge7500" value="<?php echo $txtCharge7500; ?>">
                          <br>
                          Press
the Mac key while clicking to select multiple items.
                          <table width="450" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="150"><span class="errormsg"><b>Recommendations</b></span></td>
									<td width="300"></td>
								</tr>
								<tr>
									<td></td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Next --&gt;"><input type="reset" name="sbReset" value="Reset Values"></div>
									</td>
								</tr><tr>
									<td valign="top"><p class="basetext">    Border:<br>
   									  </p>								    </td>
									<td><select id="txtRecBorder" name="txtRecBorder[]" size="4" multiple onChange="bordergraphics(this);">
											<?php makerowsborders(); ?>
										</select></td>
								</tr>
								<tr>
									<td valign="top"><p class="basetext">    Charm:<br>
   									  </p>								    </td>
									<td><select id="txtRecCharm" name="txtRecCharm[]" size="4" multiple>
											<?php makerowscharms(); ?>
										</select></td>
								</tr>
								<tr>
									<td valign="top"><p class="basetext">    Ribbon:<br>
								    </p>								    </td>
									<td><select id="txtRecRibbon" name="txtRecRibbon[]" size="4" multiple>
											<?php makerowsribbons(); ?>
										</select></td>
								</tr>
								<tr>
									<td valign="top"><span class="basetext">    Tassel:<br>
   									</span></td>
									<td><select id="txtRecTassel" name="txtRecTassel[]" size="4" multiple>
											<?php makerowstassels(); ?>
										</select></td>
								</tr>
								<tr>
									<td></td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit1" value="Next --&gt;"><input type="reset" name="sbReset1" value="Reset Values"></div>
									</td>
								</tr>
						  </table>
						</form>
					</div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>
</html>
