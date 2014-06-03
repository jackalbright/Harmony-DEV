<?php
include ('../includes/database.inc');
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 4/3/04
******************************************************************************************/
	$UName = $_POST['strUsername'];
	$PWord = $_POST['strPassword'];
	$SecondTime = $_POST['hdnSecond'];
	error_log("START");
	if (!$UName==""){
	error_log("uname=$UName");
		$queryString="Select admin_username, password, canManageOrders, canManageParts, canManageUsers, canManageItems, canManageEvents, canManageDatabase, CanManageTestimonials from admin_user where admin_username = '$UName'";
		$result = mysql_query ($queryString, $database);
		if ( mysql_num_rows($result) == 0 ) {
	error_log("zero, QS=$queryString");
			$errorMsg = 'The username you entered is not in our records. Please check the username you entered or <a href="/custserv/newcustomer.php">create</a> a new account.';
		} else {
	error_log("cust");
			$customer = mysql_fetch_object ($result);
			if ( $PWord != $customer->password ) {
	error_log("badcust");
				$errorMsg = 'The password you entered does not match our records. Please try again or if you forgot your password you can <a href="/custserv/forgot.php">retrieve it</a>.';
			} else {
	error_log("sess_start");
				session_start();
				session_register('UName');
				session_register('canManageOrders');
				session_register('canManageParts');
				session_register('canManageUsers');
				session_register('canManageItems');
				session_register('canManageEvents');
				session_register('canManageDatabase');
				session_register('canManageTestimonials');
				$_SESSION['UName']=$customer->username;
				$_SESSION['canManageOrders']=$customer->canManageOrders;
				$_SESSION['canManageParts']=$customer->canManageParts;
				$_SESSION['canManageUsers']=$customer->canManageUsers;
				$_SESSION['canManageItems']=$customer->canManageItems;
				$_SESSION['canManageEvents']=$customer->canManageEvents;
				$_SESSION['canManageDatabase']=$customer->canManageDatabase;
				$_SESSION['canManageTestimonials']=$customer->CanManageTestimonials;

				error_log("COOK=".print_r($_COOKIE,true));
				error_log("REQ=".print_r($_REQUEST,true));

				if (isset($_COOKIE['admin_goto']))
				{
					$goto = $_COOKIE['admin_goto'];
					setcookie("admin_goto", null, 1, '/'); # Clear.
					header ("Location: $goto");
				# WONT WORK BELOW....
				} else if (($_REQUEST['referer']) != "" && !preg_match("/admin38\/index.php/", $_REQUEST['referer'])) {
					header ("Location: $_REQUEST[referer]");
				} else {
					header ('Location: /admin38/menu.php');
				}

				exit();
			};
		};
	};
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Harmony Designs Administrator Login</title>
	    <link href="../stylesheets/style.css" rel="stylesheet" type="text/css">
	</head>

	<body bgcolor="#ffffff">
		<table width="700" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" width="200">
					<div align="center">
						<img src="hdlogo.gif" alt="" height="78" width="160" border="0"></div>
				</td>
				<td valign="bottom">
					<div align="center">
						<span class="title">Administrator Login</span></div>
				</td>
			</tr>
			<tr>
				<td width="200"><span class="errormsg"><?php echo $errorString?></span> </td>
				<td>
					<div align="center">
						<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" name="FormName">
							<p>
							  <input type="hidden" name="hdnSecond" value="Yes">
							<p>Please enter your username and password to log into<br>
								the administrative functions of the web site.</p>
							<table width="300" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>Username:</td>
									<td><input type="text" name="strUsername" value="<?php echo $UName ?>" size="24" border="0"></td>
								</tr>
								<tr>
									<td>Password:</td>
									<td><input type="password" name="strPassword" value="<?php echo $PWord ?>" size="24" border="0"></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" name="btSubmit" value="Log In" border="0"></td>
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
