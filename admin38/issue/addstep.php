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
if ($_POST['hdnSecondTime']=="True"){
	$txtIssueID=$_POST['hdnIssueID'];
	$txtNotesBy=$_POST['txtNotesBy'];
	$txtStepTaken=$_POST['txtStepTaken'];
	$txtTimeStamp=getdate();
	$txtOkay="True";
	if ($txtNotesBy=="" || $txtStepTaken==""){
		$txtOkay="False";
		$txtErrMsg="Please fill who is adding the step and details of the step taken.";
	};
	if ($txtOkay=="True"){
		include ('../../includes/database.inc');
		$txtQueryString="INSERT INTO issue_fix (fix_ID, fix_description, fix_administrator, issue_ID, fix_time) VALUES ('', '$txtStepTaken', '$txtNotesBy', '$txtIssueID', '$txtTimeStamp[year]-$txtTimeStamp[mon]-$txtTimeStamp[mday] $txtTimeStamp[hours]:$txtTimeStamp[minutes]:$txtTimeStamp[seconds]')";
		$result = mysql_query($txtQueryString, $database);
		mysql_close($database);
       	header ('Location: ../menu.php');
	};
};
?>
<?php
	if ($txtIssueID==""){
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
		<title>New Step Form</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; line-height: normal; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {font-size: medium}
.style2 {color: blue; font-style: normal; font-weight: bold; font-size: medium; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular; }
.style3 {font-size: xx-small}
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
						<span class="title">New Step Form</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p><?php echo $txtErrMsg; ?></p>
			    <p class="title style1">Navigation:</p>
			    <p class="basetext"><span class="style2"><a href="../menu.php"></a></span><a href="../menu.php">Back to Main Menu</a><br>
                    <a href="menu.php">Back to Issue Menu</a></p></td>
				<td>
					<div align="left">
					  <form name="NewIssueForm" method="post" action="addstep.php">
			          <table width="450" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="150" class="basetext"><strong>Issue:</strong> <input type="hidden" name="hdnSecondTime" value="True">
                      <input type="hidden" name="hdnIssueID" value="<?php echo $txtIssueID; ?>></td>
                              <td width="300"><?php echo "($txtIssueID) $txtIssueTitle"; ?></td>
                    </tr>
                            <tr>
                              <td class="basetext"><strong>Notes by : </strong></td>
                              <td><select name="txtNotesBy">
							  <?php
							  	include ('../../includes/database.inc');
								$result = mysql_query ("SELECT Username, First_Name, Last_Name FROM `administrator`", $database);
								echo "<option value=\"\">Select an administrator...</option>\n";
								while ($row = mysql_fetch_row($result))
								{
									$UName=$row[0];
									$FirstName=$row[1];
									$LastName=$row[2];
									echo "<option value=\"$UName\">$FirstName $LastName</option>\n";
								};
								mysql_close($database);
							  ?>
                              </select></td>
                            </tr>
                            <tr>
                              <td class="basetext"><strong>Date:</strong></td>
                              <td><?php
							  echo $txtIssueDate;
							  ?>                              </td>
                            </tr>
                            <tr>
                              <td class="basetext"><strong>Steps Taken: </strong><br>
                                <span class="style3">(Describe the process you used to solve the problem.)</span></td>
                              <td><textarea name="txtStepTaken" cols="40" rows="8"></textarea></td>
                            </tr>
                            <tr>
                              <td class="basetext">&nbsp;</td>
                              <td><input type="submit" name="EditIssue" value="Add Step">
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