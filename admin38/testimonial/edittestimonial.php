<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 9/20/04
******************************************************************************************/
	session_start();
	if (!array_key_exists('UName', $_SESSION)){
		header ('Location: ../admin38/index.php');
	} else {
		$manageOrders=$_SESSION['canManageOrders'];
		$manageParts=$_SESSION['canManageParts'];
		$manageUsers=$_SESSION['canManageUsers'];
		$manageItems=$_SESSION['canManageItems'];
		$manageEvents=$_SESSION['canManageEvents'];
		$manageDatabase=$_SESSION['canManageDatabase'];
		$manageTestimonials=$_SESSION['canManageTestimonials'];
	};
	if ($_SESSION['canManageTestimonials']!="Yes"){
		header ('Location: ../menu.php');
	};
?>
<?php
	include ('../../includes/admin.inc');
?>
<?php 
	$txtTestimonialID=$_POST['txtTestimonialID'];
	include ('../../includes/database.inc');
    $result = mysql_query ("SELECT * FROM `testimonial` WHERE testimonial_id='$txtTestimonialID'", $database);
    while ($event = mysql_fetch_object($result))
        {
		   $txtTestimonialID=$event->testimonial_id;
		   $txtTestimonialText=$event->text;
		   $txtAttribution=$event->attribution;
         };
     mysql_close($database);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>Testimonial Addition Page</title>
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
<script language="javascript" type="text/javascript">
	function clearFields(){
		document.frmTestimonial.txtTestimonialText.value="";
		document.frmTestimonial.txtAttribution.value="";
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
						<span class="title">Testimonial Addition Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top" class="title style3"><p class="title style1">Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
				      <a href="menu.php">Back to Testimonial Menu</a></p>
			  </td>
				<td>
					<div align="center">
						<form action="edittestimonial2.php" method="post" name="frmTestimonial">
							<table width="450" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td><span class="basetext">Testimonial<br>
									  Text:
									      <input type="hidden" name="txtTestimonialID" value="<?php echo $txtTestimonialID; ?>">
									</span></td>
									<td><textarea name="txtTestimonialText" cols="55" rows="4"><?php echo $txtTestimonialText; ?></textarea></td>
								</tr>
								<tr>
									<td><span class="basetext">Attribution:</span></td>
									<td><input type="text" name="txtAttribution" size="60" value="<?php echo $txtAttribution; ?>"></td>
								</tr>
								<tr>
									<td></td>
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