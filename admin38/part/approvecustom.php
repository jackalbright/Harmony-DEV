<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 10/20/04
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
  function makerows()
  {
    include ('../../includes/database.inc');
    $result = mysql_query ("SELECT ribbon_id, color_name FROM `ribbon` order by ribbon_id", $database);
    echo "<option value=\" \" selected>Select a ribbon color...</option>\n";
    while ($row = mysql_fetch_row($result))
        {
           $eventID=$row[0];
           $title=$row[1];
           echo "<option value=\"$eventID\">$eventID - $title</option>\n";
         };
     mysql_close($database);
  };
$title = "Custom Graphic Menu";
	
include ('../includes/htmlTop.php');
?>

</head>

<div id="mainContainer">
    <?php include("../includes/header.php"); ?>
<div id="mainContent">
<!--<h1>Custom Graphic Menu</h1>-->
<ul class="admin38_submenu">
<li><a href="../menu.php">Main</a></li>
<li><a href="menu.php">Parts Menu</a></li>
<li><a href="customsmenu.php">Custom Graphic Menu</a></li>
</ul>		
<br style="clear:both">					
<table width="500" border="0" cellspacing="0" cellpadding="0">
    <TR>
        <TD>&nbsp;</TD>
    </TR>
    <tr>
      <form action="approvecustom2.php" method="post" name="ApproveCustom">
        <td width="272" class="basetext">View All Unapproved </td>
        <td width="128"><div align="right">
          <input type="hidden" name="hdnApproved" value="True"><input type="hidden" name="txtCustomerID" value="-1">
          </div></td>
        <td width="100"><input type="submit" name="sbAdd" value="View Unapproved"></td>
      </form>
    </tr>
    <TR>
        <TD>&nbsp;</TD>
    </TR>
    <tr>
      <form action="approvecustom2.php" method="post" name="ApproveCustom">
        <td width="272" class="basetext">View All</td>
        <td width="128"><div align="right">
          <input type="hidden" name="hdnApproved" value="False"><input type="hidden" name="txtCustomerID" value="-1">
          </div></td>
        <td width="100"><input type="submit" name="sbAdd" value="View All"></td>
      </form>
    </tr>
    <TR>
        <TD>&nbsp;</TD>
    </TR>
    <tr>
      <form action="approvecustom2.php" method="post" name="EditCustom">
        <td colspan="2"><span class="basetext">View Unapproved Images By Customer</span><input type="hidden" name="hdnApproved" value="True">								  <div align="right">
        </div></td>
        <td width="100">&nbsp;</td>
        <tr>
        <td colspan="2">
            <select name="txtCustomerID" size="1">
        <?php
                include ('../../includes/database.inc');
                $result2 = mysql_query ("SELECT First_Name, Last_Name, customer_id, email_Address,dateAdded FROM customer WHERE eMail_Address IS NOT NULL AND eMail_Address != '' AND eMail_Address NOT LIKE '%harmonydesigns.com' ORDER BY Last_Name, Customer_ID desc", $database);
                while ($row2 = mysql_fetch_row($result2)){
                    echo"<option value='$row2[2]'>$row2[1], $row2[0] ($row2[3]) - $row2[4]</option>";
                };
                mysql_close($database);
        ?>
        </select>
        </td>
        <td width="100"><input type="submit" name="sbEdit" value="View Unapproved"></td>
      </form>		
    <TR>
        <TD>&nbsp;</TD>
    </TR>
    <tr>
      <form action="approvecustom2.php" method="post" name="ChooseCustom">
        <td colspan="2"><span class="basetext">View All Images By Customer</span>
          <input type="hidden" name="hdnApproved" value="False">								  <div align="right">
        </div></td>
        <td width="100">&nbsp;</td>
        <tr>
        <td colspan="2">
            <select name="txtCustomerID" size="1">
        <?php
                include ('../../includes/database.inc');
                $result2 = mysql_query ("SELECT First_Name, Last_Name, customer_id, email_Address, dateAdded FROM customer WHERE eMail_Address IS NOT NULL AND eMail_Address != '' AND eMail_Address NOT LIKE '%harmonydesigns.com' ORDER BY Last_Name, Customer_ID desc", $database);
                while ($row2 = mysql_fetch_row($result2)){
                    echo"<option value='$row2[2]'>$row2[1], $row2[0] ($row2[3]) - $row2[4] </option>";
                };
                mysql_close($database);
        ?>
        </select>
        </td>
        <td width="100"><input type="submit" name="sbEdit" value="View All"></td>
      </form>		
    </tr>

</table>
</div><!--mainContent-->

<?php include ('../includes/footer.php'); ?>      
</div><!--mainContainer-->
<?php include ('../includes/htmlBottom.php'); ?>
