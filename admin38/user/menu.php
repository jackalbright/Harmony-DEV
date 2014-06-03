<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 9/20/04
******************************************************************************************/
	session_start();
	error_log(print_r($_SESSION,true));
	if (!array_key_exists('UName', $_SESSION)){
		error_log("NO UNAME");
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
	if ($_SESSION['canManageUsers']!="Yes"){
		header ('Location: ../menu.php');
	};
?>
<?php
	include ('../../includes/admin.inc');
?>
<?php
  function makerows()
  {
    include ('../../includes/database.inc');
    $result = mysql_query ("SELECT administrator_id, first_name, last_name, username FROM `administrator` order by last_name, first_name", $database);
    echo "<option value=\" \" selected>Select a user...</option>\n";
    while ($row = mysql_fetch_row($result))
        {
           $adminID=$row[0];
           $firstName=$row[1];
           $lastName=$row[2];
		   $txtUsername=$row[3];
           echo "<option value=\"$adminID\">$firstName $lastName ($txtUsername)</option>\n";
         };
     mysql_close($database);
  };
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Administrator Menu</title>
		<SCRIPT language="JavaScript1.1" type="text/javascript">
            function besure(){
            	return confirm("Do you really want to delete this border?");
            };
        </script>
        <link href="../../stylesheets/style.css" rel="stylesheet" type="text/css">
	    <style type="text/css">
<!--
.style1 {font-size: medium}
-->
        </style>
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
						<span class="title">Administrator Info Menu</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title style1 style1">Navigation:</p>
			    <p class="basetext1"><a href="../menu.php">Back to Main Menu</a></p></td>
				<td>				  <div align="center">
						
							<table width="500" border="0" cellspacing="0" cellpadding="0">
								<TR>
									<TD>&nbsp;</TD>
								</TR>
								<tr>
								  <form action="changepassword.php" method="post" name="AddEvent">
									<td width="200"><span class="basetext">Change Password</span></td>
									<td width="200"></td>
									<td width="100"><input type="submit" name="sbAdd" value="Change Password"></td>
								  </form>
								</tr>
							<?php  if ($manageUsers=="Yes"){?>								<TR>
									<TD>&nbsp;</TD>
								</TR>
								<tr>
								  <form action="adduser.php" method="post" name="AddEvent">
									<td width="200"><span class="basetext">Add User </span></td>
									<td width="200"></td>
									<td width="100"><input type="submit" name="sbAdd" value="New Administrator"></td>
								  </form>
								</tr>
	<?php };?>
							<?php  if ($manageUsers=="Yes"){?>								<TR>
								<TR>
									<TD>&nbsp;</TD>
								</TR>
								<tr>
								  <form action="edituser.php" method="post" name="EditEvent">
									<td width="200"><span class="basetext">Edit User </span></td>
									<td width="200"><select name="txtAdminID" size="1">
											<?php makerows(); ?>
										</select></td>
									<td width="100"><input type="submit" name="sbEdit" value="Edit Administrator"></td>
								  </form>		
								</tr>
	<?php };?>
							<?php  if ($manageUsers=="Yes"){?>								<TR>
								<TR>
									<TD>&nbsp;</TD>
								</TR>
								<tr>
								  <form action="deleteuser.php" method="post" name="DeleteEvent">					
  									<td width="200"><span class="basetext">Delete User </span></td>
									<td width="200"><select name="txtAdminID" size="1">
											<?php makerows(); ?>
										</select></td>
									<td width="100"><input type="submit" name="sbDelete" value="Delete Administrator" onclick="return besure();"></td>
								  </form>		
								</tr>	<?php };?>
<TR>
									<TD>&nbsp;</TD>
							  </TR>
								<tr>
								  <form action="../menu.php" method="post" name="ReturnToMain">					
  									<td width="200"><span class="basetext">Return to Main Menu </span></td>
									<td width="200">&nbsp;</td>
									<td width="100"><input type="submit" name="sbDelete" value="Return to Main"></td>
								  </form>		
								</tr>
							</table>
					</div>
					<div align="left">
						<p></p>
					</div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>
