<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 9/20/04
******************************************************************************************/
	session_start();
	if (!array_key_exists('UName', $_SESSION)){
		header ('Location: /admin38/index.php');
		exit(0);
	} else {
		$manageOrders=$_SESSION['canManageOrders'];
		$manageParts=$_SESSION['canManageParts'];
		$manageUsers=$_SESSION['canManageUsers'];
		$manageItems=$_SESSION['canManageItems'];
		$manageEvents=$_SESSION['canManageEvents'];
		$manageDatabase=$_SESSION['canManageDatabase'];
		$manageTestimonials=$_SESSION['canManageTestimonials'];
	};

	include ('../includes/admin.inc');
	$title = "Administrator Menu";
	include ('includes/htmlTop.php');
?>

	<link href="../stylesheets/adminstyle.css" rel="stylesheet" type="text/css">
	</head>

	<body >
    <div id="mainContainer">
    <?php include("includes/header.php"); ?>
	
<div id="mainContent">						 
<ul class="adminSubmenu">
<?php  if ($manageOrders=="Yes"){?>
<li>
<span class="basetext"><a href="/admin38/order/menu.php">Order Management</a></span>
<br>
Click here to check daily orders, manage customers and get files for transfering into your business management program. 
</li>
<?php };?>
<li>
<span class="basetext"><a href="/admin38/issue/menu.php">Issue Management</a></span> 
<br>
Click here to enter and track problems on the website. 
</li>
<?php  if ($manageParts=="Yes"){?>
<li>
<span class="basetext"><a href="/admin38/part/menu.php">Part Management </a></span> 
<br>
Enter stamps, tassels, quotes and other parts for the items offered by Harmony Designs. 
</li>
<?php };?>
<li>
<span class="basetext"><a href="/admin38/user/menu.php">Administrator Management</a></span> 
<br>
Manage access to the Administrative area in this section. 
</li>
<?php  if ($manageEvents=="Yes"){?>
<li>
<span class="basetext"><a href="/admin38/event/menu.php">Event Management</a></span> 
<br>
This area is for adding new events for the homepage. 
</li>
<?php };?>
<?php  if ($manageDatabase=="Yes"){?>
<li>
<span class="basetext"><a href="/admin38/phpMyAdmin/index.php" target="_blank">Database Management</a></span> 
<br>
This link will bring you to the MySQL database Admin page for direct editing of the tables on the database. 
</li>
<?php };?>
<?php  if ($manageTestimonials=="Yes"){?>
<li>
<span class="basetext"><a href="/admin38/testimonial/menu.php">Testimonial Management</a></span> 
<br>
Add, edit and delete testimonials that can be viewed on the website's homepage. 
</li>
<?php };?>
<li>
<span class="basetext"><a href="/admin38/whatsnew/menu.php">"What's New" Management</a></span> 
<br>
Add special events and new web features to the home page, &quot;What's New&quot; web page and the newsletter. Also, the newsletter itself may be created and e-mailed to users who have signed up for it. 
</li>
<li>
<span class="basetext"><a href="/admin38/stats/index.php">Site Statistics</a></span> 
<br>
View statistics for the website including searches, referral sites, and entry/exit pages. 
</li>
<li>
<span class="basetext"><a href="/admin38/logout.php">Admin Logout</a></span> 
<br>
Log out of admin system.
</li>
</ul>
</div><!--mainContent-->


<?php include ('includes/footer.php'); ?>      
</div><!--mainContainer-->
<?php include ('includes/htmlBottom.php'); ?>
