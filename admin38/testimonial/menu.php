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
  function makerows()
  {
    include ('../../includes/database.inc');
    $result = mysql_query ("SELECT testimonial_id, attribution FROM `testimonial` order by testimonial_id", $database);
    echo "<option value=\" \" selected>Select a testimonial...</option>\n";
    while ($row = mysql_fetch_row($result))
        {
           $eventID=$row[0];
           $title=$row[1];
           echo "<option value=\"$eventID\">$eventID - by $title</option>\n";
         };
     mysql_close($database);
  };
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>Administrator Menu</title>
	    <link href="../../stylesheets/style.css" rel="stylesheet" type="text/css">
		<SCRIPT language="JavaScript1.1" type="text/javascript">
            function besure(){
            	return confirm("Do you really want to delete this testimonial?");
            };
        </script>

	    <style type="text/css">
<!--
.style1 {font-size: medium}
-->
        </style>
	</head>

	<body bgcolor="#ffffff">
		<table width="700" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" width="200">
					<div align="center">
						<img src="../hdlogo.gif" alt="Harmony Designs Logo" height="78" width="160" border="0"></div>
				</td>
				<td valign="bottom">
					<div align="center">
						<span class="title">Testimonial Menu</span></div>
				</td>
			</tr>
			<tr>
			  <td width="200" valign="top"><p class="title style1">Navigation:</p>
				  <p class="basetext1"><a href="../menu.php">Back to Main Menu</a><br>
	          </p></td>
				<td>
					<div align="left">
						<br>
						<ul>
						  <li class="basetext"><a href="addtestimonial.php">Add Testimonial</a><br>
						    <br>                           
						  <li class="basetext">Edit Testimonial<br>
						    <form name="frmEditTestimonial" method="post" action="edittestimonial.php">
						      <select name="txtTestimonialID">
							  	<?php makerows(); ?>
					          </select>
						      <br>
						      <input type="submit" name="sbEdit" value="Edit Testimonial">                           
						    </form>
					      <li><span class="basetext">Delete Testimonial</span><br>
					        						    <form name="frmDeleteTestimonial" method="post" action="deletetestimonial.php">
						      <select name="txtTestimonialID">
							  	<?php makerows(); ?>
					          </select>
						      <br>
						      <input type="submit" name="sbDelete" value="Delete Testimonial" onClick="return besure();">                           
						    </form>
<br>						
                      </ul>
					</div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>