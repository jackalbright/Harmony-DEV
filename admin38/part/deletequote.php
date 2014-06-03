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
$cbQuotes=(array)$_POST['cbQuote'];
?>
<?php
//	foreach ($cbQuotes as $cbQuote){
		include ('../../includes/database.inc');
//	    $txtQueryString = "DELETE FROM quote WHERE quote_id='$cbQuote'";
//	    $result = mysql_query ($txtQueryString, $database); 
//	    $txtQueryString = "DELETE FROM rec_quote WHERE quote_id='$cbQuote'";
//	    $result = mysql_query ($txtQueryString, $database); 
//	    mysql_close($database);
//	};
?>
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
.style1 {font-size: medium}
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
						<span class="title">Quote Deletion Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title style1">Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br><a href="menu.php">Back to Parts Menu</a><br>
                      <a href="quotesmenu.php">Back to Quote Menu</a> </p>
			    <p></p></td>
				<td>
					<div align="center">					  
					  <p class="basetext">
						The selected quote(s) have been deleted from the database: </p>
					  <p class="basetext"><?php
					  	foreach ($cbQuotes as $cbQuote){
					  		$txtQueryString1 = "select text from quote where quote_id='$cbQuote'";
					  		$result = mysql_query ($txtQueryString1, $database);
					  		$textOutput = mysql_fetch_array($result);
					  		echo $textOutput["text"];
	    					$txtQueryString = "DELETE FROM quote WHERE quote_id='$cbQuote'";
		 					$result = mysql_query ($txtQueryString, $database);
							echo "<br><br>";  
						};
?></p>
					  <p><span class="basetext"><b>To enter a new quote or to edit a quote, click <a href="quotesmenu.php">here</a>.</b></span></p>
						<p><span class="basetext"><b>To return to the main menu, click <a href="menu.php">here</a>.</b></span></p>
						<p></p>
				  </div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>
