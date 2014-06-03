<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 9/20/04
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
	$cbQuote=$_POST['cbQuote'];
	include ('../../includes/database.inc');
    $result = mysql_query ("SELECT quote_id, text, title, attribution, use_quote_marks, text_length, subjects FROM quote WHERE quote_id='$cbQuote'", $database);
    while ($quote = mysql_fetch_object($result))
        {
	        $txtQuoteID=$quote->quote_id;
			$txtQuoteBody=$quote->text;
			$txtQuoteTitle=$quote->title;
			$txtQuoteAttribution=$quote->attribution;
			$txtQuoteMarks=$quote->use_quote_marks;
			$txtQuoteLength=$quote->text_length;
			$txtQuoteSubjects=$quote->subjects;
         };
     mysql_close($database);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Quote Addition Page</title>
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
	function updateQuoteLength(){	
		var quoteLength;
		quoteLength=document.frmQuote.txtQuoteBody.value.length
		document.frmQuote.txtQuoteLength.value=quoteLength;
		if (document.frmQuote.cbAddMarks.checked){
			document.frmQuote.txtQuoteLength.value=quoteLength+2;
		};
		document.frmQuote.txtQuoteLength.focus();
		document.frmQuote.cbAddMarks.focus();
		return true;
	};
	function updateQuoteMarkLength(){	
		var quoteLength;
		quoteLength=document.frmQuote.txtQuoteBody.value.length
		document.frmQuote.txtQuoteLength.value=quoteLength;
		if (document.frmQuote.cbAddMarks.checked){
			document.frmQuote.txtQuoteLength.value=quoteLength+2;
		};
		document.frmQuote.txtQuoteLength.focus();
		document.frmQuote.txtAttribution.focus();
		return true;
	};
	function validateForm(){
		if (document.frmQuote.txtQuoteTitle.value == "" && document.frmQuote.txtQuoteBody.value == ""){
			alert("You must enter a quote title and/or a quote body to continue.");
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
						<span class="title">Quote Edit Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top" class="title style3"><form name="LengthForm" method="post" action="">
				  <p>Navigation:</p>
			      <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br><a href="menu.php">Back to Parts Menu</a><br>
                      <a href="quotesmenu.php">Back to Quote Menu</a> </p>
			      <p>&nbsp;</p>
			      <p>&nbsp;</p>
				</form>	</td>
				<td>
					<div align="center">
						<form action="editquote2.php" method="post" name="frmQuote">
							<table width="450" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>&nbsp;</td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Next --&gt;"><input type="reset" name="sbReset" value="Clear Form" onClick="clearFields();"></div>
									</td>
								</tr>
								<tr>
									<td><span class="basetext">Quote Title :</span></td>
									<td><input type="text" name="txtQuoteTitle" size="60" value="<?php echo $txtQuoteTitle; ?>"></td>
								</tr>
								<tr>
								  <td class="basetext">Quote Body: </td>
								  <td><textarea name="txtQuoteBody" cols="55" rows="4" onChange="updateBodyLength();"><?php echo $txtQuoteBody; ?></textarea></td>
							  </tr>
								<tr>
								  <td>&nbsp;</td>
								  <td><span class="basetext">
								    <input type="checkbox" name="cbAddMarks" value="yes" <?php if ($txtQuoteMarks=="yes"){echo "checked";}; ?> >
							      Add Quotation Marks to Quote Body</span><br>	</td>
							  </tr>
								<tr>
									<td><span class="basetext">Quote Attribution :
									  <input type="hidden" name="cbQuote" value="<?php echo $cbQuote; ?>">
									</span></td>
									<td><input type="text" name="txtAttribution" size="80" onChange="updateAttribLength();" value="<?php echo $txtQuoteAttribution; ?>" ></td>
								</tr>
								<tr>
								  <td class="basetext">Quote Length: </td>
								  <td><input type="text" name="txtQuoteLength" value="<?php echo $txtQuoteLength; ?>"></td>
							  </tr>
							  <tr>
							  		<td class="basetext">Subjects: </td>
							  		<td><input type="text" name="txtQuoteSubjects" size="80" value="<?php echo $txtQuoteSubjects; ?>"></td>
							  </tr>
								<tr>
									<td>&nbsp;</td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Next --&gt;"><input type="reset" name="sbReset" value="Clear Form" onClick="clearFields();"></div>
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