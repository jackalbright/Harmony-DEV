<?php 
//session_start();
//if (isset($_SESSION['navtype'])) {
if (isset($_GET['nav'])) {
    if ($_GET['nav']=="subject") {
       $_SESSION["navtype"] = "product";
    } else {
	   $_SESSION["navtype"] = "subject";
}
}
//echo "<BR><BR><BR>" .  $_SESSION["navtype"] . "<BR><BR><BR>";
?>
<?php
	include ('sidebarSearch2.inc');
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
if (isset($_SESSION['navtype'])) {
  if ( $_SESSION['navtype'] == "product" ) 
{

//echo "in subject<BR>" . $_SESSION['navtype'] . "<BR>";

echo '<div class="toggle-button"><a href="' . $product_uri . '" class="nav"><img src="/images-shared/buttonProduct.gif" alt="Shop by Product" width="87" height="21" border="0"></a></div>';
echo '<div class="toggle-button"><a href="' . $subject_uri . '" class="nav"><img src="/images-shared/buttonSubjectChecked.gif" alt="Shop by Subject" width="88" height="21" border="0"></a></div>';
	include_once('relatedSubjects.inc');
	echo '<h4>Shop by Subject</h4>';
	echo '<div id="subjectList">' . "\n";
	currentSubjectPath ($browseNode, $database);
	echo '</div>' . "\n";
}
else 	//$_SESSION['navtype'] == "product"
{
//echo "in product<BR>" . $_SESSION['navtype'] . "<BR>";
echo '<div class="toggle-button"><a href="' . $product_uri . '" class="nav"><img src="/images-shared/buttonProductChecked.gif" alt="Shop by Product" width="87" height="21" border="0"></a></div>';
echo '<div class="toggle-button"><a href="' . $subject_uri . '" class="nav"><img src="/images-shared/buttonSubject.gif" alt="Shop by Subject" width="88" height="21" border="0"></a></div>';
	include_once ('products.inc');
}

} else {
// no navtype set yet
echo '<div class="toggle-button"><a href="' . $product_uri . '" class="nav"><img src="/images-shared/buttonProductChecked.gif" alt="Shop by Product" width="87" height="21" border="0"></a></div>';
echo '<div class="toggle-button"><a href="' . $subject_uri . '" class="nav"><img src="/images-shared/buttonSubject.gif" alt="Shop by Subject" width="88" height="21" border="0"></a></div>';
	include_once ('products.inc');



}
?>
<!--End Subject/Product Navigation-->
