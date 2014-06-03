
<?php 

# DISABLED!
#session_start();

	#include ('sidebarSearch2.inc');
?>
<!--Begin Subject/Product Navigation-->
<?php


$uri = $_SERVER['REQUEST_URI'];
$product_uri = $uri;
$subject_uri = $uri;

if (strpos($uri, "?")<1)  //  No variables in URI
{
	$product_uri = $uri . "?nav=product";
	$subject_uri = $uri . "?nav=subject";
}
else if (strpos($uri, "nav=") <1)  //  Variables in URI but NOT nav...
{
	$product_uri = $uri . "&nav=product";
	$subject_uri = $uri . "&nav=subject";
}

	$product_uri = str_replace("=subject", "=product", $product_uri);
	$subject_uri = str_replace("=product", "=subject", $subject_uri);

	#include_once('relatedSubjects.inc');
	#echo '<div class="sidebar_block">';
	#echo '<div class="sidebar_header">Image Subjects:</div>';
	#echo '<div id="" class="subject_links sidebar_content">' . "\n";
	#echo "SBN=".$_SESSION['browseNode'];
	#global $database;
	#$browseNode = !empty($_SESSION['browseNode']) ? $_SESSION['browseNode'] : null;

	#currentSubjectPath ($browseNode , $database);
	#echo '</div>' . "\n";
	#echo '</div>' . "\n";
?>
<!--End Subject/Product Navigation-->

<br/>
<img src="/images/credit_card_logos.gif"/>
