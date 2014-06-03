<?php
	include_once ('database.inc');

//Create product array of product id, name, code
$result = mysql_query ("SELECT product_type_id, name, code From product_type  where product_type.code='" . $_REQUEST['prod'] . "'", $database);
	$productName = array();
	while ($temp = mysql_fetch_object($result) ) {
		$productName[] = $temp;
	}


// Create Product arrays for reproducible and non-reproducible items
	$result = mysql_query ("Select product_type.* from product_type, product_part, part_type where product_type.code='" . $_REQUEST['prod'] . "' and part_type.part_name='image' and part_type.part_id = product_part.part_id and product_part.product_type_id = product_type.product_type_id and product_type.buildable='yes' and product_type.available='yes' and product_type.stamp != 'custom' order by product_type.sort_index", $database);
	$allProducts = array();
	while ($temp = mysql_fetch_object($result) ) {
		$allProducts[] = $temp;
	}

	$reproProducts = array();
	$result = mysql_query ("Select product_type.* from part_type, product_part, product_type where product_type.code='" . $_REQUEST['prod'] . "' and  part_type.part_name = 'image' and part_type.part_id = product_part.part_id and product_part.product_type_id = product_type.product_type_id and product_type.available = 'yes' and product_type.buildable = 'yes' and product_type.stamp != 'real' and product_type.stamp != 'custom' order by product_type.sort_index", $database);
	while ($temp = mysql_fetch_object($result)) {
		$reproProducts[] = $temp;
	}

	$result = mysql_query ("Select product_type.* from product_type, product_part, part_type where product_type.code='" . $_REQUEST['prod'] . "' and  part_type.part_name='image' and part_type.part_id = product_part.part_id and product_part.product_type_id = product_type.product_type_id and product_type.buildable='yes' and product_type.available='yes' and not (product_type.stamp='repro') and not (product_type.stamp='custom') order by product_type.sort_index", $database);
	$stampProducts = array();
	while ($temp = mysql_fetch_object($result) ) {
		$stampProducts[] = $temp;
	}
//$result1 = count($allProducts);
//$result2 = count($reproProducts);
//$result3 = count($stampProducts);
// echo 'COUNTS ' . $result1 . ' ' . $result2 . ' ' . $result3 . '<br>';
	
function listStamp ($stamp) {

	global $productName, $allProducts, $stampProducts, $reproProducts; //, $result1, $result2, $result3;
//$result1 = count($allProducts);
//$result2 = count($reproProducts);
//$result3 = count($stampProducts);
//echo 'COUNTS ' . $result1 . ' ' . $result2 . ' ' . $result3 . '<br>';
//if ($result1==0 && $result2==0 && $result3==0) {
// do nothing - do not show stamp
//} else { 

		echo '<div class="subjectList">' . "\n";
		echo '<a href="/product/detail.php?catalogNumber=' . $stamp->catalog_number . '" />' . "\n";
		echo '<h3>' . $stamp->stamp_name . ' Gifts</h3>' . "\n";
		echo '<img src="' . $stamp->thumbnail_location . '">' . "\n";
		echo '</a>' . "\n";
		echo '<div class="stampDesc">' . "\n";
		echo '<p>' . $stamp->short_description . "\n";
		echo '<span class="catNum">Catalog&nbsp;#&nbsp;' . $stamp->catalog_number . '</span>' . "\n";
		//echo '<span style="color:#ffffd0;font-size:0.5em;">' . $stamp->relevance . '</span>' . "\n";
		echo "</p>\n";
		echo '</div>' . "\n";
		echo '<form action="/product/build.php" method="get">' . "\n";
		echo '<input type="hidden" name="catalogNumber" value="' . $stamp->catalog_number . '" />' . "\n";
	//	echo '<input type="hidden" name="productCode" value="' . $productName->name . '" />' . "\n";
		echo '<input type="hidden" name="productCode" value="' . $_SESSION['product'] . '" />' . "\n";
		echo 'Build ';
		//echo  $productName->name[0] . ' w ';
		foreach ($productName as $product) {
			echo "$product->name ";
		}
		
		
		
//		
//		echo '<select name="productCode"><option selected="selected">Select an item...</option>' . "\n";
//		if ($stamp->reproducible == 'Yes') {
//			foreach ($allProducts as $product) {
//				echo "<option value=\"$product->code\">$product->name</option>\n";
//			}
//		} elseif ($stamp->reproducible == 'Only') {
//			foreach ($reproProducts as $product) {
//				echo "<option value=\"$product->code\">$product->name</option>\n";
//			}
//		} else {
//			foreach ($stampProducts as $product) {	
//				echo "<option value=\"$product->code\">$product->name</option>\n";
//			}
//		}
//		echo '</select>' . "\n";
//		
		
		
		
		
		echo '<button type="submit" value="Go">Go</button>' . "\n";
		echo '</form>' . "\n";
		if ($stamp->reproducible == 'No') {
			echo "<p class=\"note\">Due to copyright, this stamp is not available on <a href=\"/info/about-us.php#reproduction\">items requiring reproductions</a>.</p>\n";
		}
		if ($stamp->reproducible == 'Only') {
			echo "<p class=\"note\">This stamp is only available as a licensed reproduction.  Because of this, we cannot create <a href=\"/details/stamp-on-card.php\">stamps-on-cards</a>, <a href=\"/details/pin.php\">pins/tie-tacks</a> or <a href=\"/details/framedstamp.php\">framed stamps</a> with this item.</p>\n";
		}
		echo '</div>' . "\n";
//	}	
}
	
	

?>