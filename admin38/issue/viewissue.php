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
	include ('../../includes/admin.inc');
?>
<?php
if ($_POST['hdnSecondTime'] == "True"){
	$txtIssueID=$_POST['hdnIssueID'];
	$txtIssuePriority=$_POST['txtIssuePriority'];
	$txtIssuePassedTo=$_POST['txtPassedTo'];
	$txtIssueStatus=$_POST['txtStatus'];
	include ('../../includes/database.inc');
	$result = mysql_query("UPDATE issue SET issue_Priority='$txtIssuePriority', issue_passed_to='$txtIssuePassedTo', issue_status='$txtIssueStatus' WHERE issue_ID='$txtIssueID'", $database);			
	mysql_close($database);
};
if ($_GET['issue'] != ""){
	$txtIssueID=$_GET['issue'];
};
	include ('../../includes/database.inc');
	$result = mysql_query("SELECT issue_Date, issue_Title, issue_Description, issue_status, issue_controller, issue_passed_to, issue_Priority FROM issue WHERE issue_ID='$txtIssueID'", $database);			
	while ($row = mysql_fetch_row($result))
	{
		$txtIssueDate=$row[0];
		$txtIssueTitle=$row[1];
		$txtIssueDescription=$row[2];
		$txtIssueStatus=$row[3];
		$txtIssueController=$row[4];
		$txtIssuePassedTo=$row[5];
		$txtIssuePriority=$row[6];
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
.basetext { color: black; font-weight: normal; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext1 {color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {font-weight: bold}
.style3 {font-style: normal; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular; color: blue;}
.style4 {font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular; color: black;}
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
						<span class="title">View Issue Form</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p>&nbsp;</p>
			      <p class="title style1">Navigation:</p>
			      <p class="basetext1"><a href="../menu.php">Back to Main Menu</a><br>
                      <a href="menu.php">Back to Issue Menu</a></p>
			      <p class="title">Issue Menu </p>
			      <p class="style4"><a href="addstep.php?issue=<?php echo $txtIssueID; ?>">Add New Step Taken</a><br>
		          <a href="issuereport.php?issue=<?php echo $txtIssueID; ?>">Printer Friendly Version<br>
		          </a><a href="manageissues.php">Return to Issue Menu<br>
		          </a><a href="../menu.php">Return to Main Menu</a>&nbsp;</p>
		        <p>&nbsp;</p></td>
				<td>
					<div align="left">
					  <form name="ViewIssueForm" method="post" action="viewissue.php">
			          <table width="450" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="150" class="basetext"><strong>Issue Name:
                        <input type="hidden" name="hdnSecondTime" value="True">
                        <input type="hidden" name="hdnIssueID" value="<?php echo $txtIssueID; ?>">
</strong></td>
                              <td width="300" class="basetext"><?php echo $txtIssueTitle; ?></td>
                    </tr>
                            <tr>
                              <td valign="top" class="basetext"><strong>Issue Description: </strong></td>
                              <td class="basetext"><?php echo $txtIssueDescription; ?></td>
                            </tr>
                            <tr>
                              <td class="basetext"><strong>Issue Priority: </strong></td>
                              <td class="basetext"><select name="txtIssuePriority">
                                <option value="Critical" <?php if ($txtIssuePriority=="Critical"){ echo "selected";}; ?>>Critical</option>
                                <option value="High" <?php if ($txtIssuePriority=="High"){ echo "selected";}; ?>>High</option>
                                <option value="Medium" <?php if ($txtIssuePriority=="Medium"){ echo "selected";}; ?>>Medium</option>
                                <option value="Low" <?php if ($txtIssuePriority=="Low"){ echo "selected";}; ?>>Low</option>
                              </select></td>
                            </tr>
                            <tr>
                              <td class="basetext"><strong>Posted by:</strong></td>
                              <td class="basetext"><?php echo $txtIssueController; ?></td>
                            </tr>
                            <tr>
                              <td class="basetext"><strong>Passed to: </strong></td>
                              <td><select name="txtPassedTo">
							  <?php
							  	include ('../../includes/database.inc');
								$result = mysql_query ("SELECT Username, First_Name, Last_Name FROM `administrator`", $database);
								echo "<option value=\" \">Select an administrator...</option>\n";
								while ($row = mysql_fetch_row($result))
								{
									$UName=$row[0];
									$FirstName=$row[1];
									$LastName=$row[2];
									echo "<option value=\"$UName\"";
									if ($txtIssuePassedTo==$UName){
										echo " selected";
									};
									echo ">$FirstName $LastName</option>\n";
								};
								mysql_close($database);
							  ?>
                              </select></td>
                            </tr>
                            <tr>
                              <td class="basetext"><strong>Date:</strong></td>
							  
                              <td class="basetext"><?php
							  echo $txtIssueDate;
							  ?>                              </td>
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
                              <td class="basetext"><strong>Steps Taken: </strong></td>
                              <td><textarea name="textarea" cols="40" rows="8" readonly><?php
							  	include ('../../includes/database.inc');
								$result = mysql_query ("SELECT fix_description, fix_administrator, fix_time FROM issue_fix WHERE issue_ID='$txtIssueID' ORDER BY fix_time", $database);
								while($row=mysql_fetch_array($result)){
									echo "$row[0]\n--$row[1]\n$row[2]\n\n";
								};
							  ?></textarea></td>
                            </tr>
                            <tr>
                              <td class="basetext">&nbsp;</td>
                              <td><input type="submit" name="EditIssue" value="Edit Issue">
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