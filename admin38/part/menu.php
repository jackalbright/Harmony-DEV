<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 9/20/04
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
	

	
	$title = "Parts Menu";
	
	include ('../includes/htmlTop.php');
	include ('../../includes/admin.inc');
?>

	</head>

	<body >
    <div id="mainContainer">
    <?php include("../includes/header.php"); ?>
<div id="mainContent">	
<p class="basetext1"><a href="../menu.php">Back to Main Menu</a></p>

<ul class="adminSubmenu">
<li><span class="basetext"><a href="stampsmenu.php">Stamp Menu</a></span><br>
Add, Edit and Delete stamps from the online catalog.<br>
<li><span class="basetext"><a href="approvecustom2.php">Custom Image Menu (Image Approval)</a></span><br>
<!--<span class="basetext"><a href="customsmenu.php">Custom Image Menu (Image Approval)</a></span><br>-->

Approve and download custom images. <br>                            
<li><span class="basetext"><a href="bordersmenu.php">Border Menu</a></span><br>
Add, Edit and Delete border styles for the bookmark styles.<br>                            
<li><span class="basetext"><a href="charmsmenu.php">Charm Menu</a></span><br>
Add, Edit and Delete charms. <br>                           
<li><span class="basetext"><a href="quotesmenu.php">Quote Menu</a></span><br>
Add, Edit, Delete and SEARCH for quotes.<br>
<li><span class="basetext"><a href="ribbonsmenu.php">Ribbon Menu</a></span><br>
Add, Edit and Delete colors for different ribbons. <br>                                       
<li><span class="basetext"><a href="tasselsmenu.php">Tassel Menu</a></span><br>
Add, Edit and Delete colors for bookmark tassels. <br>
<br>
<br>
<br>						
</ul>

</div><!--mainContent-->

<?php include ('../includes/footer.php'); ?>      
</div><!--mainContainer-->
<?php include ('../includes/htmlBottom.php'); ?>
