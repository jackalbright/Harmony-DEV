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
$catalognumber=$_POST['hdncatalognumber'];
$txtCatalogNumber=$_POST['txtCatalogNumber'];
$txtOldCatalogNumber=$_POST['txtOldCatalogNumber'];
$txtStampName=htmlentities($_POST['txtStampName']);
$txtIssueDate=$_POST['txtIssueDate'];
$txtSeries=$_POST['txtSeries'];
$txtFaceValue=$_POST['txtFaceValue'];
$txtShortDescription=htmlentities($_POST['txtShortDescription']);
$txtLongDescription=htmlentities($_POST['txtLongDescription']);
$txtKeywords=htmlentities($_POST['txtKeywords']);
$txtCountry=htmlentities($_POST['txtCountry']);
$txtHTMLKeywords=htmlentities($_POST['txtHTMLKeywords']);
$txtThumbnailLocation=$_POST['txtThumbnailLocation'];
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
 ?>
<?php
	include ('../../includes/database.inc');
    $result = mysql_query ("SELECT * FROM `browse_node`", $database);
    $i=0;  
    while ($row = mysql_fetch_row($result))
        {  
           $nodekey[$i];
           $nodekey[$i]=$row['0'];
           $nodedescription;
           $nodedescription[$i]= $row['1'];
           $nodeparent[$i];
           $nodeparent[$i]= $row['2'];
           $i++;
         };
 mysql_close($database);  
 	include ('../../includes/database.inc');
	$txtQueryString="SELECT browse_node_id FROM browse_link WHERE Catalog_Number='$catalognumber'";
    $result = mysql_query($txtQueryString, $database);
    while ($row = mysql_fetch_row($result))
         {
           $prevlinkID[]=$row[0];
         };
	mysql_close($database);

?>
<?php
  function makerows($nodekey, $nodedescription, $nodeparent, $parent, $prevlinkID)
  {
    echo "<UL>\n";
    for ($a=0; $a<=count($nodekey); $a++)
        {
        if ($nodeparent[$a] == $parent) 
          {
          echo "<LI> <input class=\"txtSuggestedNodes\" type=\"checkbox\" name=\"txtSuggestedNodes[]\" value=\"$nodekey[$a]\"";
		   		foreach($prevlinkID as $key=>$value){
					if ($value==$nodekey[$a]){
						echo " CHECKED";
					};
				};
		  echo "> $nodedescription[$a]</LI>\n";
          makerows($nodekey, $nodedescription, $nodeparent, $nodekey[$a], $prevlinkID);
          };  
      };
    echo "</UL>\n";
    return True;
  };
?>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Stamp Addition Page</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small;  font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetextgrey { color: gray; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {font-size: medium}
--></style>
<script language="javascript1.2" type="text/javascript">
	function validateForm(){
		var counttags=0;
		var RecNode = document.getElementsByTagName('input');
		for (var loopIndex=0; loopIndex < RecNode.length; loopIndex++){
			if (RecNode[loopIndex].type == "checkbox" && RecNode[loopIndex].className=="txtSuggestedNodes" && RecNode[loopIndex].checked == true){
				counttags++;
			};
		};
		if (counttags == 0){
			alert("You must select at least one category before continuing.");
			return false;
		};
		return true;
	};
</script>
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
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br><a href="menu.php">Back to Parts Menu</a><br>
                      <a href="stampsmenu.php">Back to Stamp Menu</a> </p>
			    <p></p></td>
				<td>
					<div align="center">
						<form action="editstamp4.php" method="post" name="frmStamp" onSubmit="return validateForm();">
						  <input type="hidden" name="txtCatalogNumber" value="<?php echo $txtCatalogNumber; ?>">
						  <input type="hidden" name="txtOldCatalogNumber" value="<?php echo $txtOldCatalogNumber; ?>">
						  <input type="hidden" name="txtStampName" value="<?php echo $txtStampName; ?>">
						  <input type="hidden" name="txtIssueDate" value="<?php echo $txtIssueDate; ?>">
						  <input type="hidden" name="txtFaceValue" value="<?php echo $txtFaceValue; ?>">
						  <input type="hidden" name="txtSeries" value="<?php echo $txtSeries; ?>">
						  <input type="hidden" name="txtShortDescription" value="<?php echo $txtShortDescription; ?>">
						  <input type="hidden" name="txtLongDescription" value="<?php echo $txtLongDescription; ?>">
						  <input type="hidden" name="txtCountry" value="<?php echo $txtCountry; ?>">
						  <input type="hidden" name="txtKeywords" value="<?php echo $txtKeywords; ?>">
						  <input type="hidden" name="txtHTMLKeywords" value="<?php echo $txtHTMLKeywords; ?>">
						  <input type="hidden" name="txtThumbnailLocation" value="<?php echo $txtThumbnailLocation; ?>">
						  <input type="hidden" name="txtImageLocation" value="<?php echo $txtImageLocation; ?>">
						  <input type="hidden" name="cbAvailable" value="<?php echo $cbAvailable; ?>">
						  <input type="hidden" name="cbReproducible" value="<?php echo $cbReproducible; ?>">
						  <input type="hidden" name="hdnEntryDate" value="<?php echo $hdnEntryDate; ?>">
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
						  <input type="hidden" name="hdncatalognumber" value="<?php echo $catalognumber;?>">
						  <?php 
						  foreach ($txtBorders as $txtBorder){
						    echo"<input type=\"hidden\" name=\"txtRecBorder[]\" value=\"$txtBorder\">\n";   
						  };
						   ?>
						  <?php 
						  foreach ($txtCharms as $txtCharm){
						    echo"<input type=\"hidden\" name=\"txtRecCharm[]\" value=\"$txtCharm\">\n";   
						  };
						   ?>
						  <?php 
						  foreach ($txtQuotes as $txtQuote){
						    echo"<input type=\"hidden\" name=\"txtRecQuote[]\" value=\"$txtQuote\">\n";   
						  };
						   ?>
						  <?php 
						  foreach ($txtRibbons as $txtRibbon){
						    echo"<input type=\"hidden\" name=\"txtRecRibbon[]\" value=\"$txtRibbon\">\n";   
						  };
						   ?>
						  <?php 
						  foreach ($txtTassels as $txtTassel){
						    echo"<input type=\"hidden\" name=\"txtRecTassel[]\" value=\"$txtTassel\">\n";   
						  };
						   ?>
						  <table width="450" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td colspan="2">
										<div align="center">
											<span class="errormsg"><b>Recommended Categories</b></span></div>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Next --&gt;" ><input type="reset" name="sbReset" value="Reset"></div>
									</td>
								</tr>
								<tr>
									<td><?php makerows($nodekey,$nodedescription,$nodeparent,1, $prevlinkID); ?></td>
								</tr>
								<tr>
									<td></td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Next --&gt;" ><input type="reset" name="sbReset" value="Reset"></div>
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
