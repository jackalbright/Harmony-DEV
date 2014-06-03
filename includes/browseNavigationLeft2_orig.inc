<?php 

session_start();
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

	include_once('relatedSubjects.inc');
	echo '<div id="leftbar_header">Browse Image Gallery</div>';
	echo '<div id="subjectList">' . "\n";
	#echo "SBN=".$_SESSION['browseNode'];
	global $database;
	currentSubjectPath ($_SESSION['browseNode'], $database);
	echo '</div>' . "\n";
?>
<!--End Subject/Product Navigation-->
