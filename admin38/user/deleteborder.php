<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 4/3/04
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
	if ($_SESSION['canManageParts']=="No"){
		header ('Location: ../menu.php');
	};
?>
<?php
	$txtBorderID=$_POST['txtBorderID'];
	include ('../../includes/database.inc');
    $txtQueryString = "DELETE FROM border WHERE border_id='$txtBorderID'";
    $result = mysql_query ($txtQueryString, $database); 
	$txtQueryString = "DELETE FROM rec_border WHERE Border_ID='$txtBorderID'";
    $result = mysql_query ($txtQueryString, $database); 
	mysql_close($database);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Stamp Menu</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>
       <SCRIPT language="JavaScript1.1" type="text/javascript">
            function besure(){
            	return confirm("Do you really want to delete this stamp?");
            };
        </script>
</head>

	<body bgcolor="#ffffff">
		<table width="750" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" width="200">
					<div align="center">
						<img src="../hdlogo.gif" alt="" height="78" width="160" border="0"></div>
				</td>
				<td valign="bottom">
					<div align="center">
						<span class="title">Deleting Borders  </span></div>
				</td>
			</tr>
			<tr>
				<td width="200"></td>
				<td><p></p>
					    <span class="basetext">Border <?php echo $txtStampID;?> is being deleted from all tables.</span> 
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>