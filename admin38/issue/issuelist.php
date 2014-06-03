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
  $txtQueryType=$_POST['hdnQueryType'];
  switch($txtQueryType) {
  	case "openDate":
		if ($_POST['txtEndYear']=="yyyy"){
			$txtSQLQueryString = "SELECT issue_ID, UNIX_TIMESTAMP(issue_Date) as codedStart, issue_Title, issue_Description, issue_controller, issue_passed_to, issue_Priority, issue_Status from issue where NOT (issue_staus='Closed') AND NOT (issue_status='Cancelled') AND issue_Date='$_POST[txtStartYear]-$_POST[txtStartMonth]-$_POST[txtStartDay]' ORDER BY codedStart, issue_Priority";
		} else {
			$txtSQLQueryString = "SELECT issue_ID, UNIX_TIMESTAMP(issue_Date) as codedStart, issue_Title, issue_Description, issue_controller, issue_passed_to, issue_Priority, issue_Status from issue where NOT (issue_staus='Closed') AND NOT (issue_status='Cancelled') AND issue_Date BETWEEN '$_POST[txtStartYear]-$_POST[txtStartMonth]-$_POST[txtStartDay]' AND '$_POST[txtEndYear]-$_POST[txtEndMonth]-$_POST[txtEndDay]' ORDER BY codedStart, issue_Priority";
		};
		break;
	case "openAdmin":
		$txtSQLQueryString = "SELECT issue_ID, UNIX_TIMESTAMP(issue_Date) as codedStart, issue_Title, issue_Description, issue_controller, issue_passed_to, issue_Priority, issue_Status from issue where NOT (issue_staus='Closed') AND NOT (issue_status='Cancelled') AND issue_controller='$_POST[txtPassedTo]' ORDER BY codedStart, issue_Priority";
		break;
	case "openPriority":
		$txtSQLQueryString = "SELECT issue_ID, UNIX_TIMESTAMP(issue_Date) as codedStart, issue_Title, issue_Description, issue_controller, issue_passed_to, issue_Priority, issue_Status from issue where NOT (issue_staus='Closed') AND NOT (issue_status='Cancelled') AND issue_Priority='$_POST[txtPriority]' ORDER BY codedStart, issue_Priority";
		break;
  	case "allDate":
		if ($_POST['txtEndYear']=="yyyy"){
			$txtSQLQueryString = "SELECT issue_ID, UNIX_TIMESTAMP(issue_Date) as codedStart, issue_Title, issue_Description, issue_controller, issue_passed_to, issue_Priority, issue_Status from issue where issue_Date='$_POST[txtStartYear]-$_POST[txtStartMonth]-$_POST[txtStartDay]' ORDER BY codedStart, issue_Priority";
		} else {
			$txtSQLQueryString = "SELECT issue_ID, UNIX_TIMESTAMP(issue_Date) as codedStart, issue_Title, issue_Description, issue_controller, issue_passed_to, issue_Priority, issue_Status from issue where issue_Date BETWEEN '$_POST[txtStartYear]-$_POST[txtStartMonth]-$_POST[txtStartDay]' AND '$_POST[txtEndYear]-$_POST[txtEndMonth]-$_POST[txtEndDay]' ORDER BY codedStart, issue_Priority";
		};
		break;
	case "allAdmin":
		$txtSQLQueryString = "SELECT issue_ID, UNIX_TIMESTAMP(issue_Date) as codedStart, issue_Title, issue_Description, issue_controller, issue_passed_to, issue_Priority, issue_Status from issue where issue_controller='$_POST[txtPassedTo]' ORDER BY codedStart, issue_Priority";
		break;
	case "allPriority":
		$txtSQLQueryString = "SELECT issue_ID, UNIX_TIMESTAMP(issue_Date) as codedStart, issue_Title, issue_Description, issue_controller, issue_passed_to, issue_Priority, issue_Status from issue where issue_Priority='$_POST[txtPriority]' ORDER BY codedStart, issue_Priority";
		break;
	default:
		$txtSQLQueryString = "SELECT issue_ID, UNIX_TIMESTAMP(issue_Date) as codedStart, issue_Title, issue_Description, issue_controller, issue_passed_to, issue_Priority, issue_Status from issue ORDER BY codedStart, issue_Priority";
		break;
  }
  include ('../../includes/database.inc');
  $result = mysql_query($txtSQLQueryString, $database);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>View Open Issues</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; line-height: normal; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.subtitle {
color: blue; font-style: normal; font-weight: bold; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular
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
						<span class="title">View Issues </span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title style1">Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
				      <a href="menu.php">Back to Issue Menu</a></p>
			  </td>
				<td>
					<div align="left">
					  	<p class="basetext">Select the issue you wish to have more details on:</p>
						<?php
							while ($row = mysql_fetch_row($result))
								{
									$txtIssueID=$row[0];
									$txtIssueTitle=$row[2];
									$txtIssuePriority=$row[6];
									$txtIssueController=$row[4];
									$txtIssuePassedTo=$row[5];
									$txtIssueDescription=$row[3];
									$txtIssueStatus=$row[7];
									$txtIssueDay=date('j', $row[1]);
									$txtIssueMonth=date('n', $row[1]);
									$txtIssueYear=date('Y', $row[1]);
									echo "<table width='450' border='0' cellspacing='0' cellpadding='0'>";
									echo "<tr>";
									echo "<td width='300' class='subtitle'><a href='viewissue.php?issue=$txtIssueID'>$txtIssueTitle</a></td>";
									echo "<td width='150' class='subtitle'>Priority: $txtIssuePriority</td>";
									echo "</tr>";
									echo "<tr>";
									echo "<td class='basetext'><strong>Administrator:</strong> $txtIssueController</td>";
									echo "<td class='basetext'><strong>Status:</strong> $txtIssueStatus</td>";
									echo "</tr>";
									echo "<tr>";
									echo "<td class='basetext'><strong>Passed To:</strong> $txtIssuePassedTo</td>";
									echo "<td class='basetext'><strong>Opened:</strong> $txtIssueMonth-$txtIssueDay-$txtIssueYear</td>";
									echo "</tr>";
									echo "<tr>";
									echo "<td colspan='2' class='basetext'><blockquote>";
									echo "<p><strong>Description:</strong> $txtIssueDescription";
									echo "</blockquote></td></tr></table><p>&nbsp;</p>";
								};
								mysql_close($database);
						?>
					  	<p>&nbsp;</p>
					  	<p>&nbsp;</p>
				  </div></td>
			</tr>
			<tr>
			  <td></td>
			  <td>&nbsp;</td>
		  </tr>
		</table>
		<p></p>
	</body>

</html>