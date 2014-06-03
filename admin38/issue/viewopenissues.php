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
.style1 {font-size: medium}
.style2 {color: blue; font-style: normal; font-weight: bold; font-size: medium; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular; }
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
						<span class="title">View Open Issues</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top"><p class="title style1">Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
                      <a href="menu.php">Back to Issue Menu</a></p></td>
				<td>
					<div align="left">
						<form name="frmDateRange" method="post" action="issuelist.php">
						  <table width="450" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td colspan="2"><div align="center" class="title">
                                <p class="style1">
                                  <input type="hidden" name="hdnQueryType" value="1">
                                By Date Range</p>
                                <p class="basetext"><strong><em>Select a range of dates. If you just want a particular <br>
                                date, just put in the start date.  </em></strong></p>
                              </div></td>
                            </tr>
                            <tr>
                              <td width="150" class="basetext">Start Date: </td>
                              <td width="300"><input type="text" name="txtStartMonth" size="4" value="mm">
                                /
                                <input type="text" name="txtStartDay" size="4" value="dd">
                                /
                                <input type="text" name="txtStartYear" size="8" value="yyyy"></td>
                            </tr>
                            <tr>
                              <td class="basetext">End Date: </td>
                              <td><input type="text" name="txtEndMonth" size="4" value="mm">
/
  <input type="text" name="txtEndDay" size="4" value="dd">
/
<input type="text" name="txtEndYear" size="8" value="yyyy"></td>
                            </tr>
                            <tr>
                              <td class="basetext">&nbsp;</td>
                              <td><input type="submit" name="Submit" value="View Issues">
                              <input type="reset" name="Reset" value="Reset"></td>
                            </tr>
                          </table>
					    </form>
						<form name="frmByAdmin" method="post" action="issuelist.php">
						  <table width="450" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td colspan="2"><div align="center" class="title">
                                <p class="style2"><span class="style1">
                                  <input type="hidden" name="hdnQueryType" value="2">
                                </span>By Administrator<br> 
                                </p>
                              </div></td>
                            </tr>
                            <tr>
                              <td width="150" class="basetext">Passed To: </td>
                              <td width="300"><select name="txtPassedTo">
                              <?php
							  	include ('../../includes/database.inc');
								$result = mysql_query ("SELECT Username, First_Name, Last_Name FROM `administrator`", $database);
								echo "<option value=\" \" selected>Select an administrator...</option>\n";
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
                              <td>&nbsp;</td>
                              <td><input type="submit" name="Submit2" value="View Issues">
                                <input type="reset" name="Reset2" value="Reset"></td>
                            </tr>
                          </table>
					    </form>
						<form name="frmByPriority" method="post" action="issuelist.php">
						  <table width="450" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td colspan="2"><div align="center" class="style2"><span class="style1">
                                <input type="hidden" name="hdnQueryType" value="3">
                              </span>By Priority</div></td>
                            </tr>
                            <tr>
                              <td width="150" class="basetext">Priority:</td>
                              <td width="300"><select name="txtPriority">
                                <option value="Critical">Critical</option>
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                              </select></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td><input type="submit" name="Submit22" value="View Issues">
                                <input type="reset" name="Reset22" value="Reset"></td>
                            </tr>
                          </table>
					    </form>
						<p><br>
						  <br>
						    <br>
				  </p>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
						<p>&nbsp;        </p>
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