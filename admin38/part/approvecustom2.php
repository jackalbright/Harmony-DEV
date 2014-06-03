<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 9/29/04
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
	//echo __line__ . " here<br>";
	if ($_SESSION['canManageParts']!="Yes"){
		header ('Location: ../menu.php');
	};

	include ('../../includes/admin.inc');
//echo __line__ . " here<br>";
	$txtCustomerID="";
	$hdnApproved="";
	if (array_key_exists('hdnApproved', $_POST) && array_key_exists('txtCustomerID', $_POST)){
		$txtCustomerID = $_POST['txtCustomerID'];
		$hdnApproved = $_POST['hdnApproved'];
	} else {
		$txtCustomerID = "-1";
		$hdnApproved = "False";
	};
  function makerowspending($txtCustomerID, $hdnApproved)
  {	
  	$txtQueryString = "SELECT custom_image.Image_ID, custom_image.thumbnail_location, custom_image.Title, custom_image.Approved, MONTH(custom_image.Submission_Date) As submit_month, DAYOFMONTH(custom_image.Submission_Date) As submit_day, YEAR(custom_image.Submission_Date) As submit_Year, customer.First_Name, customer.Last_Name, customer.company, custom_image.description, customer.eMail_Address 
	FROM custom_image, customer 
	WHERE custom_image.customer_id = customer.customer_id";
	if ($hdnApproved == "True"){
		$txtQueryString = $txtQueryString . " AND custom_image.Approved='Pending'";
	};
	if ($txtCustomerID != "-1"){
		$txtQueryString = $txtQueryString . " AND custom_image.customer_id = '$txtCustomerID'";
	};
	$txtQueryString = $txtQueryString . " ORDER BY custom_image.submission_date DESC";
	error_log("Q=$txtQueryString");
    include ('../../includes/database.inc');
    $result = mysql_query ($txtQueryString, $database);
    while ($row = mysql_fetch_row($result))
        {
            $imageID=$row[0];
		    $thumb_location=$row[1];
			$title=$row[2];
			$status=$row[3];
			$sub_day=$row[5];
			$sub_month=$row[4];
			$sub_year=$row[6];
			$customer_name = $row[7] . " " . $row[8] . "(" . $row[9] . ") ". $row[11];
			$txtDescription=$row[10];
            echo "<td width=\"150\"><a href=\"approvecustom3.php?image_id='$imageID'\"><img src=\"../..$thumb_location\"></a></td>\n";
            echo "<td width=\"400\" valign=\"top\"><p><strong>Name:</strong> $title<br>\n";
            echo "<strong>Customer:</strong>  $customer_name<br>\n";
            echo "<strong>Submitted:</strong> $sub_month-$sub_day-$sub_year <br>\n";
            echo "<strong>Description:</strong>  $txtDescription<br>\n";
            echo "<strong>Approval Status:</strong>  $status</td>\n";
            echo "</tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>\n";
         };
     mysql_close($database);
  };
  //echo __line__ . " here<br>";
$title = "Custom Graphic Menu";
	
include ('../includes/htmlTop.php');
	//include ('../../includes/admin.inc');
	
?>
<style type="text/css">
<!--
.basetext1 {color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {font-weight: bold}
-->
</style>

</head>

<body >

<div id="mainContainer">
<?php include("../includes/header.php"); ?>
<div id="mainContent">

<ul class="admin38_submenu">
<li><a href="../menu.php">Main</a></li>
<li><a href="menu.php">Parts Menu</a></li>
<li><a href="approvecustom.php">Back to Custom Menu</a></li>
</ul>		
<br style="clear:both">		

		
						
		
<p>Click on the thumbnail to select an item to approve.</p>
                  								
<table width="550" border="0" cellspacing="0" cellpadding="0">
<?php 
makerowspending($txtCustomerID, $hdnApproved); ?>
</table>
	      
</div><!--mainContent-->

<?php include ('../includes/footer.php'); ?>      
</div><!--mainContainer-->
<?php include ('../includes/htmlBottom.php'); ?>
