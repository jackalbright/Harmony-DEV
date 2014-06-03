<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 9/2/07 by DJL
Reason: Added search by subjects
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
	$txtDirection=$_POST['txtDirection'];
?>
<?php
	$txtQuotes=(array)$_POST['txtRecQuote'];
	$txtSearchPhrase=stripslashes($_POST['txtSearchPhrase']);
	$cbTitle=$_POST['cbTitle'];
	$cbQuoteBody=$_POST['cbQuoteBody'];
	$cbAttribution=$_POST['cbAttribution'];
	$cbSubjects=$_POST['subjects'];
	$numQuotes=-1;
	$searchOffset = 0;
	$matches = array();
	preg_match_all ('/\"[^\"]*\"/', $txtSearchPhrase,  $matches );
	$quotedTerms = preg_replace ('/\"/', '', $matches[0]);
	$tempString = trim(preg_replace ('/\"[^\"]*\"/', '', $txtSearchPhrase));
	$excisedSearchString = preg_replace ('/\"/', '', $tempString);
	$unquotedTerms = preg_split ('/\s+/', $excisedSearchString, -1, PREG_SPLIT_NO_EMPTY );
	$allTerms = array_merge ($quotedTerms, $unquotedTerms);
	$numTerms = count($allTerms);
	foreach ($txtQuotes as $value){
		include ('../../includes/database.inc');
	    $result = mysql_query ("SELECT quote_id, text, title, attribution, subjects FROM quote WHERE quote_id='$value'", $database);
	    while ($quote = mysql_fetch_object($result))
	        {
			   $numQuotes++;
			   $txtQuoteID[$numQuotes]=$quote->quote_id;
	           $txtQuoteBody[$numQuotes]=$quote->text;
	           $txtQuoteTitle[$numQuotes]=$quote->title;
	           $txtQuoteAttribution[$numQuotes]=$quote->attribution;
	           $txtQuoteSubjects[$numQuotes]=$quote->subjects;
			   $txtQuoteChecked[$numQuotes]="True";

	         };
	     mysql_close($database);
	};
	if ($cbQuoteBody!="" && $txtSearchPhrase!=""){
		for ($i=0; $i < $numTerms; $i++){
			include ('../../includes/database.inc');
		    $result = mysql_query ("SELECT quote_id, text, title, attribution, subjects FROM quote WHERE text LIKE '%$allTerms[$i]%'", $database);
		    while ($quote = mysql_fetch_object($result)){
					$match=0;
					for ($i=0; $i<$numQuotes; $i++){
						if ($quote->quote_id == $txtQuoteID[$i]){
							$match++;
						};
					};
					if ($match == 0){
					   $numQuotes++;
			           $txtQuoteID[$numQuotes]=$quote->quote_id;
			           $txtQuoteBody[$numQuotes]=$quote->text;
			           $txtQuoteTitle[$numQuotes]=$quote->title;
			           $txtQuoteAttribution[$numQuotes]=$quote->attribution;
			           $txtQuoteSubjects[$numQuotes]=$quote->subjects;
					   $txtQuoteChecked[$numQuotes]="False";
					};
				};	
		     mysql_close($database);
	     };
	};
	if ($cbTitle=="True" && $txtSearchPhrase!=""){
		for ($i=0; $i < $numTerms; $i++){
			include ('../../includes/database.inc');
		    $result = mysql_query ("SELECT quote_id, text, title, attribution, subjects FROM quote WHERE title LIKE '%$allTerms[$i]%'", $database);
	    while ($quote = mysql_fetch_object($result))
	        {
				$match=0;
				for ($i=0; $i<$numQuotes; $i++){
					if ($quote->quote_id == $txtQuoteID[$i]){
						$match++;
					};
				};
				if ($match == 0){
				   $numQuotes++;
		           $txtQuoteID[$numQuotes]=$quote->quote_id;
		           $txtQuoteBody[$numQuotes]=$quote->text;
		           $txtQuoteTitle[$numQuotes]=$quote->title;
		           $txtQuoteAttribution[$numQuotes]=$quote->attribution;
		           $txtQuoteSubjects[$numQuotes]=$quote->subjects;
				   $txtQuoteChecked[$numQuotes]="False";
				};
	         };
			 
	     mysql_close($database);
		 };
	};
	if ($cbAttribution=="True" && $txtSearchPhrase!=""){
		for ($i=0; $i < $numTerms; $i++){
			include ('../../includes/database.inc');
		    $result = mysql_query ("SELECT quote_id, text, title, attribution, subjects FROM quote WHERE attribution LIKE '%$allTerms[$i]%'", $database);
	    while ($quote = mysql_fetch_object($result))
	        {
				$match=0;
				for ($i=0; $i<$numQuotes; $i++){
					if ($quote->quote_id == $txtQuoteID[$i]){
						$match++;
					};
				};
				if ($match == 0){
				   $numQuotes++;
		           $txtQuoteID[$numQuotes]=$quote->quote_id;
		           $txtQuoteBody[$numQuotes]=$quote->text;
		           $txtQuoteTitle[$numQuotes]=$quote->title;
		           $txtQuoteAttribution[$numQuotes]=$quote->attribution;
		           $txtQuoteSubjects[$numQuotes]=$quote->subjects;
				   $txtQuoteChecked[$numQuotes]="False";
				};
	         };
	     mysql_close($database);
		 };
	};
	if ($cbSubjects=="True" && $txtSearchPhrase!=""){
			for ($i=0; $i < $numTerms; $i++){
				include ('../../includes/database.inc');
			    $result = mysql_query ("SELECT quote_id, text, title, attribution, subjects FROM quote WHERE subjects LIKE '%$allTerms[$i]%'", $database);
		    while ($quote = mysql_fetch_object($result))
		        {
					$match=0;
					for ($i=0; $i<$numQuotes; $i++){
						if ($quote->quote_id == $txtQuoteID[$i]){
							$match++;
						};
					};
					if ($match == 0){
					   $numQuotes++;
			           $txtQuoteID[$numQuotes]=$quote->quote_id;
			           $txtQuoteBody[$numQuotes]=$quote->text;
			           $txtQuoteTitle[$numQuotes]=$quote->title;
			           $txtQuoteAttribution[$numQuotes]=$quote->attribution;
			           $txtQuoteSubjects[$numQuotes]=$quote->subjects;
					   $txtQuoteChecked[$numQuotes]="False";
					};
		         };
		     mysql_close($database);
			 };
	};
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
	updateBodyLength(){	
		document.LengthForm.txtBodyLength.value=document.frmQuote.txtQuoteBody.value.length;
	};
	updateAttrigLength(){
		document.LengthForm.txtAttribLength.value=document.frmQuote.txtAttribution.value.length;
	};
</script>
<script language="javascript1.2" type="text/javascript">
	function clearform(){
		document.frmQuote.action="editquote.php";
		document.frmQuote.submit();
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
						<span class="title">Quote Search Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top" class="title style3"><p>Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
				      <a href="menu.php">Back to Parts Menu</a><br>
                      <a href="quotesmenu.php">Back to Quote Menu</a> </p>
			    <p></p></td>
				<td>
					<div align="center">
						<form action="searchquotea.php" method="post" name="frmQuote">
							<table width="450" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td><span class="basetext">Quote Search Phrase:</span></td>
								  <td><input type="text" name="txtSearchPhrase" size="60" value="<?php echo $txtSearchPhrase; ?>">
									  <span class="basetext">
									  <input type="hidden" name="txtDirection" value="True">
								    </span></td>
								</tr>
								<tr>
								  <td class="basetext">&nbsp;</td>
								  <td><p>
								    <label>								    </label>
								    <span class="basetext">
								    <input type="checkbox" name="cbTitle" value="True" checked>
								    in Title<br>
							        <input type="checkbox" name="cbQuoteBody" value="True" checked>
							        in Quote Body<br>
							        <input type="checkbox" name="cbAttribution" value="True" checked>
							        in Attribution<br>
							        <input type="checkbox" name="cbSubjects" value="True" checked>
							        in Subjects								    </span><br>
					              </p>							      </td>
							  </tr>
							   <tr>
									<td height="43"></td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Run Quote Search">
											<input type="button" name="sbContinue2" value="Next --&gt;" onClick="return clearform();">
									  </div></td>
							  </tr>
								<?php 
								if ($numQuotes<0 && $txtDirection=="True"){?>
								<tr>
									<td></td>
									<td class="errormsg">This search has produced no results. Please try again. </td>
								</tr>
								<?php }; ?>
 
								<?php 
								if ($numQuotes>=0){
								for ($i=0; $i<=$numQuotes; $i++){?>
								<tr>
									<td><input class="txtRecQuote" type="radio" name="cbQuote" value="<?php echo $txtQuoteID[$i]; ?>"></td>
									<td><p><span class="basetext"><b>Title:  <?php echo $txtQuoteTitle[$i]; ?></b></span><br>
									      <span class="basetext">Body:  <?php echo $txtQuoteBody[$i]; ?></span><br>
							            <span class="basetext"><i>Attribution: <?php echo $txtQuoteAttribution[$i]; ?></i></span><br>
							            <span class="basetext"><i>Subjects: <?php echo $txtQuoteSubjects[$i]; ?></i></span></p>
								    <p>&nbsp;</p></td>
								</tr>
								<?php };}; ?>
								<?php if ($numQuotes>=0){?>
								<tr>
									<td></td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Run Quote Search">
											<input type="button" name="sbContinue" value="Next --&gt;" onClick="return clearform();">
									  </div></td>
								</tr>
								<?php };?>
							</table>
						</form>
					</div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>