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
$txtSeries=htmlentities($_POST['txtSeries']);
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
	$txtSearchPhrase=addslashes($_POST['txtSearchPhrase']);
	$cbTitle=$_POST['cbTitle'];
	$cbQuoteBody=$_POST['cbQuoteBody'];
	$numQuotes=0;
	$searchOffset = 0;
	$matches = array();
	preg_match_all ('/\"[^\"]*\"/', $txtSearchPhrase,  $matches );
	$quotedTerms = preg_replace ('/\"/', '', $matches[0]);
	$tempString = trim(preg_replace ('/\"[^\"]*\"/', '', $txtSearchPhrase));
	$excisedSearchString = preg_replace ('/\"/', '', $tempString);
	$unquotedTerms = preg_split ('/\s+/', $excisedSearchString, -1, PREG_SPLIT_NO_EMPTY );
	$allTerms = array_merge ($quotedTerms, $unquotedTerms);
	$numTerms = count($allTerms);
	$cbAttribution=$_POST['cbAttribution'];
	if ($_POST['hdnSecondPass'] == ""){
		include ('../../includes/database.inc');
	    $result = mysql_query ("SELECT quote_id FROM rec_quote WHERE catalog_number='$catalognumber'", $database);
	    while ($quote = mysql_fetch_object($result))
	        {
	           $txtQuotes[]=$quote->quote_id;
	         };
	     mysql_close($database);
	};
?>
<?php
	foreach ($txtQuotes as $value){
		include ('../../includes/database.inc');
	    $result = mysql_query ("SELECT quote_id, text, title, attribution FROM quote WHERE quote_id='$value'", $database);
	    while ($quote = mysql_fetch_object($result))
	        {
	           $txtQuoteID[$numQuotes]=$quote->quote_id;
	           $txtQuoteBody[$numQuotes]=$quote->text;
	           $txtQuoteTitle[$numQuotes]=$quote->title;
	           $txtQuoteAttribution[$numQuotes]=$quote->attribution;
			   $txtQuoteChecked[$numQuotes]="True";
			   $numQuotes++;
	         };
	     mysql_close($database);
	};
	if ($cbQuoteBody!="" && $txtSearchPhrase!=""){
		for ($i=0; $i < $numTerms; $i++){
			include ('../../includes/database.inc');
		    $result = mysql_query ("SELECT quote_id, text, title, attribution FROM quote WHERE text LIKE '%$allTerms[$i]%'", $database);
		    while ($quote = mysql_fetch_object($result)){
					$match=0;
					for ($i=0; $i<$numQuotes; $i++){
						if ($quote->quote_id == $txtQuoteID[$i]){
							$match++;
						};
					};
					if ($match == 0){
			           $txtQuoteID[$numQuotes]=$quote->quote_id;
			           $txtQuoteBody[$numQuotes]=$quote->text;
			           $txtQuoteTitle[$numQuotes]=$quote->title;
			           $txtQuoteAttribution[$numQuotes]=$quote->attribution;
					   $txtQuoteChecked[$numQuotes]="False";
					   $numQuotes++;
					};
				};	
		     mysql_close($database);
		     };
	};
	if ($cbTitle=="True" && $txtSearchPhrase!=""){
		for ($i=0; $i < $numTerms; $i++){
			include ('../../includes/database.inc');
		    $result = mysql_query ("SELECT quote_id, text, title, attribution FROM quote WHERE title LIKE '%$allTerms[$i]%'", $database);
	    while ($quote = mysql_fetch_object($result))
	        {
				$match=0;
				for ($i=0; $i<$numQuotes; $i++){
					if ($quote->quote_id == $txtQuoteID[$i]){
						$match++;
					};
				};
				if ($match == 0){
		           $txtQuoteID[$numQuotes]=$quote->quote_id;
		           $txtQuoteBody[$numQuotes]=$quote->text;
		           $txtQuoteTitle[$numQuotes]=$quote->title;
		           $txtQuoteAttribution[$numQuotes]=$quote->attribution;
				   $txtQuoteChecked[$numQuotes]="False";
				   $numQuotes++;
				};
	         };
			 
	     mysql_close($database);
		 };
	};
	if ($cbAttribution=="True" && $txtSearchPhrase!=""){
		for ($i=0; $i < $numTerms; $i++){
			include ('../../includes/database.inc');
		    $result = mysql_query ("SELECT quote_id, text, title, attribution FROM quote WHERE attribution LIKE '%$allTerms[$i]%'", $database);
	    while ($quote = mysql_fetch_object($result))
	        {
				$match=0;
				for ($i=0; $i<$numQuotes; $i++){
					if ($quote->quote_id == $txtQuoteID[$i]){
						$match++;
					};
				};
				if ($match == 0){
		           $txtQuoteID[$numQuotes]=$quote->quote_id;
		           $txtQuoteBody[$numQuotes]=$quote->text;
		           $txtQuoteTitle[$numQuotes]=$quote->title;
		           $txtQuoteAttribution[$numQuotes]=$quote->attribution;
				   $txtQuoteChecked[$numQuotes]="False";
				   $numQuotes++;
				};
	         };
	     mysql_close($database);
		 };
	};
$numQuotes--;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<title>Quote Search Page</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetextgrey { color: gray; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style2 {color: black; font-weight: normal; font-size: 9px; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular; }
.basetextSurcharge {
color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular
}
.style3 {font-size: medium}
--></style>
<script language="javascript1.2" type="text/javascript">
	function clearform(){
		var counttags=0;
		var RecQuote = document.getElementsByTagName('input');
		for (var loopIndex=0; loopIndex < RecQuote.length; loopIndex++){
			if (RecQuote[loopIndex].type == "checkbox" && RecQuote[loopIndex].className=="txtRecQuote" && RecQuote[loopIndex].checked == true){
				counttags++;
			};
		};
		
		if (counttags == 0){
			alert("You must select at least one quote before continuing.");
			return false;
		};
		document.frmQuote.action="editstamp3.php";
		document.frmQuote.submit();
		return true;
	};
	function newQuote(){
		open("addquote.php", "AddQuote");
		return false;
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
						<span class="title">Quote Search Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top" class="title style3"><p>Navigation:</p>
			      <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br><a href="menu.php">Back to Parts Menu</a><br>
                      <a href="stampsmenu.php">Back to Stamp Menu</a> </p>
			      <p class="basetext"><a href="addquote.php" onClick="return newQuote();">Add Quote</a> </p></td>
				<td>
					<div align="center">
						<form action="editstamp2a.php" method="post" name="frmQuote">
						<input type="hidden" name="hdnSecondPass" value="True">
						<input type="hidden" name="hdncatalognumber" value="<?php echo $catalognumber; ?>">
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
									<td><span class="basetext">Quote Search Phrase:</span></td>
									<td><input type="text" name="txtSearchPhrase" size="60"></td>
								</tr>
								<tr>
								  <td class="basetext"><input type="hidden" name="txtDirection" value="<?php echo $txtDirection;?>"></td>
								  <td><p>
								    <label>								    </label>
								    <span class="basetext">
								    <input type="checkbox" name="cbTitle" value="True" checked>
								    in Title<br>
							        <input type="checkbox" name="cbQuoteBody" value="True" checked>
							        in Quote Body<br>
							        <input type="checkbox" name="cbAttribution" value="True" checked>
							        in Attribution								    </span><br>
					              </p>							      </td>
								<tr>
									<td></td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Run Quote Search"><input type="button" name="sbContinue" value="Next --&gt;" onClick="clearform();"></div>
									</td>
								</tr>
							  </tr>
							    
								<?php 
								if ($numQuotes>=0){
								for ($i=0; $i<=$numQuotes; $i++){?>
								<tr>
									<td><input type="checkbox" class="txtRecQuote" name="txtRecQuote[]" value="<?php echo $txtQuoteID[$i]; ?>" <?php if ($txtQuoteChecked[$i]=="True"){ echo "checked";}; ?>></td>
									<td><p><span class="basetext"><b>Title:  <?php echo $txtQuoteTitle[$i]; ?></b></span><br>
									      <span class="basetext">Body:  <?php echo $txtQuoteBody[$i]; ?></span><br>
							            <span class="basetext"><i>Attribution: <?php echo $txtQuoteAttribution[$i]; ?></i></span></p>
								    <p>&nbsp;</p></td>
								</tr>
								<?php }; ?>
								<tr>
									<td></td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Run Quote Search"><input type="button" name="sbContinue" value="Next --&gt;" onClick="clearform();"></div>
									</td>
								</tr>
								<?php }; ?>
							</table>
						</form>
					</div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>
</html>
