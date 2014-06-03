<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 9/20/04
******************************************************************************************/
	session_start();
	if (!array_key_exists('UName', $_SESSION)){
		header ('Location: ../index.php');
?>
<?php
	if ($_POST['hdnSecondTime']=="True"){
		$txtIssueName=$_POST['txtIssueName'];
		$txtIssueDescription=$_POST['txtIssueDescription'];
		$txtIssuePriority=$_POST['txtIssuePriority'];
		$txtAdministrator=$_POST['txtAdministrator'];
		$txtPassedTo=$_POST['txtPassedTo'];
		$txtIssueMonth=$_POST['txtIssueMonth'];
		$txtIssueDay=$_POST['txtIssueDay'];
		$txtIssueYear=$_POST['txtIssueYear'];
		$txtIssueStatus=$_POST['txtStatus'];
		$txtOkay="True";
		$txtErrMsg="";
		if ($txtIssueName=="" || $txtIssueDescription=="" || $txtIssuePriority=="" || $txtAdministrator=="" || $txtPassedTo=="" || $txtIssueDay=="" || $txtIssueMonth=="" || $txtIssueYear=="" || $txtIssueStatus==""){
			$txtOkay="False";
			$txtErrMsg="Please fill all fields completely before submitting.";
		};
		if ($txtIssueMonth>12 || $txtIssueMonth<1 || $txtIssueYear < 2003 || $txtIssueDay > 31){
			$txtOkay="False";
			$txtErrMsg="Please check your date format (mm/dd/yyyy).";
		};
		if ($txtOkay=="True"){
			include ('../../includes/database.inc');
			$result = mysql_query ("INSERT INTO issue (issue_ID, issue_Date, issue_Title, issue_Description, issue_status, issue_controller, issue_passed_to, issue_Priority) VALUES ('', '$txtIssueYear-$txtIssueMonth-$txtIssueDay', '$txtIssueName', '$txtIssueDescription', '$txtIssueStatus', '$txtAdministrator', '$txtPassedTo', '$txtIssuePriority')", $database);
			mysql_close($database);
        	header ('Location: ../menu.php');
		};
	};
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>New Issue Form</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; line-height: normal; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {font-size: medium}
.style2 {
	font-size: xx-small;
	font-style: italic;
}
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
						<span class="title">New Issue Form</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><?php echo "<span class=\"errormsg\">$txtErrMsg</span>"; ?>
			      <p class="title style1">Navigation:</p>
			      <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
                      <a href="menu.php">Back to Issue Menu</a></p>
		        <p>&nbsp;</p></td>
				<td>
					<div align="left">
					  <form name="NewIssueForm" method="post" action="newissue.php">
			          <table width="450" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="150" class="basetext"><strong>Issue Name:</strong>                        <input type="hidden" name="hdnSecondTime" value="True"></td>
                              <td width="300"><input type="text" name="txtIssueName" size="45" value="<? echo $txtIssueName;?>"></td>
                        </tr>
                            <tr>
                              <td valign="top" class="basetext"><strong>Issue Description: </strong>
							 <br>
							 <span class="style2">Describe the basic problem and how the symptoms manifest. Be as complete as possible.</span>  </td>
                              <td><textarea name="txtIssueDescription" cols="45" rows="6"><? echo $txtIssueDescription; ?></textarea></td>
                            </tr>
                            <tr>
                              <td class="basetext"><strong>Issue Priority: </strong></td>
                              <td><select name="txtIssuePriority">
                                <option value="Critical" <?php if ($txtIssuePriority=="Critical"){ echo "selected";}; ?>>Critical</option>
                                <option value="High" <?php if ($txtIssuePriority=="High"){ echo "selected";}; ?>>High</option>
                                <option value="Medium" <?php if ($txtIssuePriority=="Medium"){ echo "selected";}; ?>>Medium</option>
                                <option value="Low" <?php if ($txtIssuePriority=="Low"){ echo "selected";}; ?>>Low</option>
                              </select></td>
                            </tr>
                            <tr>
                              <td class="basetext"><strong>Posted by:</strong></td>
                              <td><select name="txtAdministrator">
							  <?php
							  	include ('../../includes/database.inc');
								$result = mysql_query ("SELECT Username, First_Name, Last_Name FROM `administrator`", $database);
								echo "<option value=\"\" selected>Select an administrator...</option>\n";
								while ($row = mysql_fetch_row($result))
								{
									$UName=$row[0];
									$FirstName=$row[1];
									$LastName=$row[2];
									echo "<option value=\"$UName\"";
									if ($txtAdministrator==$UName){
										echo " selected ";
									};
									echo ">$FirstName $LastName</option>\n";
								};
								mysql_close($database);
							  ?>
                              </select></td>
                            </tr>
                            <tr>
                              <td class="basetext"><strong>Passed to: </strong></td>
                              <td><select name="txtPassedTo">
							  <?php
							  	include ('../../includes/database.inc');
								$result = mysql_query ("SELECT Username, First_Name, Last_Name FROM `administrator`", $database);
								echo "<option value=\"\" selected>Select an administrator...</option>\n";
								while ($row = mysql_fetch_row($result))
								{
									$UName=$row[0];
									$FirstName=$row[1];
									$LastName=$row[2];
									echo "<option value=\"$UName\"";
									if ($txtPassedTo==$UName){
										echo " selected ";
									};
									echo ">$FirstName $LastName</option>\n";
								};
								mysql_close($database);
							  ?>
                              </select></td>
                            </tr>
                            <tr>
                              <td class="basetext"><strong>Date:</strong></td>
							  <?php
							  $txtDate=getdate();
							  if ($txtIssueMonth==""){
							  	$txtIssueDate['mon']=$txtDate['mon'];
								$txtIssueDate['mday']=$txtDate['mday'];
								$txtIssueDate['year']=$txtDate['year'];
							} else {
								$txtIssueDate['mon']=$txtIssueMonth;
								$txtIssueDate['mday']=$txtIssueDay;
								$txtIssueDate['year']=$txtIssueYear;
							};
							  ?>
                              <td><input type="text" name="txtIssueMonth" size="4" value="<?php echo $txtIssueDate['mon']; ?>">
                                /
                                <input type="text" name="txtIssueDay" size="4" value="<?php echo $txtIssueDate['mday']; ?>">
                                /
                                <input type="text" name="txtIssueYear" size="8" value="<?php echo $txtIssueDate['year']; ?>"> 
                                <span class="style2">(mm/dd/yyyy)</span> </td>
                            </tr>
                            <tr>
                              <td class="basetext"><strong>Issue Status: </strong></td>
                              <td><select name="txtStatus">
                                <option value="Open" <?php if ($txtIssueStatus=="Open"){ echo "selected";}; ?>>Open</option>
                                <option value="In Progress" <?php if ($txtIssueStatus=="In Progress"){ echo "selected";}; ?>>In Progress</option>
                                <option value="Closed" <?php if ($txtIssueStatus=="Closed"){ echo "selected";}; ?>>Closed</option>
                                <option value="Cancelled" <?php if ($txtIssueStatus=="Cancelled"){ echo "selected";}; ?>>Cancelled</option>
                              </select></td>
                            </tr>
                            <tr>
                              <td class="basetext">&nbsp;</td>
                              <td><input type="submit" name="AddIssue" value="Add Issue">
                              <input type="Reset" name="Reset" value="Reset"></td>
                            </tr>
                        </table>
			          </form>
						<br>
						<br>
					  <br>
                      <br>						
			      </div></td>
			</tr>
		</table>
		<p></p>
	</body>
</html>