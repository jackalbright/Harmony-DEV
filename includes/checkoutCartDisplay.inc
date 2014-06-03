<?

function cartConvertHashToObject($cartItem_array)
{
	$cartItem = new CartItem();
	#error_log("CIA=".print_r($cartItem_array,true));
	foreach($cartItem_array as $k => $v)
	{
		#error_log("K=$k, V=$v");
		if ($k == 'comments')
		{
			$cartItem->comments = $v;#['itemComments'];
		} else if ($k == 'image_id') {
			$cartItem->parts->customImageID = $v;
		} else if ($k == 'catalog_number') {
			$cartItem->parts->catalogNumber = $v;
		} else if ($k == 'unit_price') {
			$cartItem->unitPrice = $v;
		} else if (is_array($v)) {
			foreach($v as $dk => $dv)
			{
				$partkey = $dk;
				if (preg_match("/^custom(.*)/", $dk, $matches) && $dv != "")
				{
					$partkey = strtolower($matches[1])."ID";
				}
				$cartItem->parts->$partkey = $dv; # Load for form use....
			}
		} else {
			$cartItem->$k = $v;
		}
	}
	#print_r($cartItem);
	return $cartItem;
}

function cartDisplay($cartItems, $database, $options = array())
{
	#if (!isset($database) && isset($this)) { $database = $this->database; }
	?>
	<div class="section">
		<h5 class="boldHead">
			Items in Cart: <? if(!isset($options['receipt'])) { ?> - <a style="font-size: 12px; text-decoration: underline;" href="/cart/display.php">Modify Cart</a> <? } ?>
		</h5>
		<?php
		#echo "CI=".print_r($cartItems, true);
		/* ######## Display items in shopping cart ######## */
			foreach ($cartItems as $cartItem_array) {
				if (empty($cartItem_array)) { continue; }
				if (is_object($cartItem_array))
				{
					$cartItem = $cartItem_array;
				} else if (is_array($cartItem_array)) {
					$cartItem = cartConvertHashToObject($cartItem_array);
				}
				#error_log("CI=".print_r($cartItem,true));
				echo '<div class="cartItem">';								
				$quoteID = $cartItem->parts->quoteID;
				
				if ( isset($cartItem->parts->catalogNumber) && $cartItem->parts->catalogNumber != '') {
					$image = new Stamp();
					$image->initFromDB($cartItem->parts->catalogNumber, $database);
				} else if ( isset($cartItem->parts->customImageID) && $cartItem->parts->customImageID != '') {
					$image = new CustomImage();
					$image->initFromDB($cartItem->parts->customImageID, $database);
				}
				
				$result = mysql_query ("Select * from product_type where code= '$cartItem->productCode'", $database);
				$product = mysql_fetch_object ( $result );
				
				if ( isset ($cartItem->parts->quoteID) )
				{
					$result = mysql_query ("Select * from quote where quote_id = $quoteID", $database);
					$quote = mysql_fetch_object ( $result );
				}
				
				if ( $cartItem->productCode == 'TA' ) {
				// display header information for tassels
					$tasselID = $cartItem->parts->tasselID;
					echo '<h6>';
					echo $product->name;
					echo '</h6>';
					
					echo '<p class="productInfoHeading">catalog #</p>';
					echo '<p class="productInfo">';
					echo $cartItem->productCode;
					echo '-';
					echo $cartItem->parts->tasselID;
					echo '</p>';	
					
				} else if ( $cartItem->productCode == 'CH' ) {								
					// display header information for charms
					$charmID = $cartItem->parts->charmID;
					echo "\n" . '<h6>';
					echo $product->name;
					echo ' - ' . $charmID;
					echo '</h6>' . "\n";
					echo '<p class="productInfoHeading">catalog #</p>' . "\n";
					echo '<p class="productInfo">';
					echo $cartItem->productCode;
					echo '-';
					echo $cartItem->parts->charmID;
					echo '</p>' . "\n";	
					if (isset ($cartItem->parts->charmID) ) {
						echo '<p class="productInfoHeading">charm</p>' . "\n";
						echo '<p class="productInfo">';
						$charmID = $cartItem->parts->charmID;
						$result = mysql_query ("Select * from charm where charm_id = $charmID", $database);
						$charm = mysql_fetch_object ( $result );
						echo $charm->name;
						echo '</p>' . "\n";
					}
				} else if ( $cartItem->productCode == 'PR' ) {
				// display header information for presidents rulers
					echo '<h6>';
					echo $product->name;
					echo '</h6>';
					
					echo '<p class="productInfoHeading">catalog #</p>';
					echo '<p class="productInfo">';
					echo $cartItem->productCode;
					echo '</p>';	
				} else if ( ($cartItem->productCode == 'PWK' || $cartItem->productCode == 'DPWK' || $cartItem->productCode == 'MDPWK') && !isset($cartItem->specialCode) ) {
				// display header information for pageweight kits
					echo '<h6>';
					echo $product->name;
					echo '</h6>';
										
					echo '<p class="productInfoHeading">catalog #</p>';
					echo '<p class="productInfo">';
					echo $cartItem->productCode;
					echo '</p>';	
				
				} else if ( isset($cartItem->specialCode) && $cartItem->specialCode != '') {
				//display header information for special items
					$result = mysql_query ("Select * from specialItem where code = '$cartItem->specialCode'", $database);
					$specialItem = mysql_fetch_object ($result);
					echo '<h6>';
					if ( isset ($cartItem->parts->catalogNumber) ) {
						echo '&#8220;' . $image->displayName() . '&#8221;';
					}
					echo $specialItem->title;
					echo '</h6>';
					
					echo '<p class="productInfoHeading">catalog #</p>';
					echo '<p class="productInfo">';
					echo $cartItem->specialCode . '-';
					echo $cartItem->productCode;
					if ( isset ($cartItem->parts->catalogNumber) ) {
						echo '-';
						echo $image->catalogNumber();
					}
					echo '</p>';	
	
				} else {
				// display header information for general products
					echo '<h6>';
					echo '&#8220;';
					echo $image->displayName();
					echo '&#8221; ';
					echo $product->name;
					echo '</h6>';
					if ($cartItem->parts->reproductionStamp) {
						echo "<p class=\"note\">(licensed reproduction stamp)</p>\n";
					}										
					echo '<p class="productInfoHeading">catalog #</p>';
					echo '<p class="productInfo">';
					if ($cartItem->parts->reproductionStamp) {
						echo "R-";
					}										
					echo $cartItem->productCode;
					echo '-';
					echo $image->catalogNumber();
					echo '</p>';
				}
				
				if ( isset ($cartItem->parts->quoteID) || isset ($cartItem->parts->customQuote) ) {
					echo '<p class="productInfoHeading">quote</p>';
					echo '<p class="productInfo">';
					if ( isset ($cartItem->parts->quoteID) ) {
						if ( isset ($quote->title) ) {
							echo $quote->title;
							echo '<br />';
						}
						if ( isset ($quote->text) ) {
							echo '&#8220;';
							if ( strlen ($quote->text) > 80 ) {
								$temp =  substr ($quote->text, 0, 80);
								$pos = strrpos ($temp, ' ');
								echo substr ($temp, 0, $pos);
								echo '&#8230;';
							} else 
								echo $quote->text;
							echo '&#8221;';
						}
					} else {
						echo nl2br($cartItem->parts->customQuote);
					}
					echo '</p>';
				}
	
				if (isset ($cartItem->parts->tasselID) ) {
					echo '<p class="productInfoHeading">tassel color</p>';
					echo '<p class="productInfo">';
					$tasselID = $cartItem->parts->tasselID;
					$result = mysql_query ("Select * from tassel where tassel_id = $tasselID", $database);
					$tassel = mysql_fetch_object ( $result );
					echo $tassel->color_name;
					echo '</p>';
				}
	
				if (isset ($cartItem->parts->shirtSize) ) {
					echo '<p class="productInfoHeading">shirt size</p>';
					echo '<p class="productInfo">';
					$shirtSize = $cartItem->parts->shirtSize;
					//$result = mysql_query ("Select * from shirt_Size where code = $shirtSize", $database);
					//$shirt = mysql_fetch_object ( $result );
					echo $shirtSize;
					echo '</p>';
				}
	
				if (isset ($cartItem->parts->printSide) ) {
					echo '<p class="productInfoHeading">print side</p>';
					echo '<p class="productInfo">';
					$printSide = $cartItem->parts->printSide;
					echo $printSide;
					echo '</p>';
				}
	
				if (isset ($cartItem->parts->ribbonID) ) {
					echo '<p class="productInfoHeading">ribbon color</p>';
					echo '<p class="productInfo">';
					$ribbonID = $cartItem->parts->ribbonID;
					$result = mysql_query ("Select * from ribbon where ribbon_id = $ribbonID", $database);
					$ribbon = mysql_fetch_object ( $result );
					echo $ribbon->color_name;
					echo '</p>';
				}
	
				if (isset ($cartItem->parts->borderID) ) {
					echo '<p class="productInfoHeading">border</p>';
					echo '<p class="productInfo">';
					$borderID = $cartItem->parts->borderID;
					$result = mysql_query ("Select * from border where border_id = $borderID", $database);
					$border = mysql_fetch_object ( $result );
					echo $border->name;
					echo '</p>';
				}
	
				if (isset ($cartItem->parts->charmID) && $cartItem->productCode != 'CH' ) {
					echo '<p class="productInfoHeading">charm</p>';
					echo '<p class="productInfo">';
					$charmID = $cartItem->parts->charmID;
					$result = mysql_query ("Select * from charm where charm_id = $charmID", $database);
					$charm = mysql_fetch_object ( $result );
					echo $charm->name;
					echo '</p>';
				}
				
				if (isset ($cartItem->parts->frameID) ) {
					echo '<p class="productInfoHeading">frame</p>';
					echo '<p class="productInfo">';
					$frameID = $cartItem->parts->frameID;
					$result = mysql_query ("Select * from frame where frame_id = $frameID", $database);
					$frame = mysql_fetch_object ( $result );
					echo $frame->name;
					echo '</p>';
				}
	
				if (isset ($cartItem->parts->pinStyle) ) {
					echo '<p class="productInfoHeading">pin style</p>';
					echo '<p class="productInfo">';
					echo $cartItem->parts->pinStyle;
					echo '</p>';
				}
				
				if (isset ($cartItem->parts->handles) ) {
					echo '<p class="productInfoHeading">handle color</p>';
					echo '<p class="productInfo">';
					echo $cartItem->parts->handles;
					echo '</p>';
				}
				
				if (isset ($cartItem->parts->postcardAddress) ) {
					echo '<p class="productInfoHeading">address/origin</p>';
					echo '<p class="productInfo">';
					echo $cartItem->parts->postcardAddress;
					echo '</p>';
				}
				
				if (isset ($cartItem->parts->personalization) ) {
					echo '<div class="personalization">' . "\n";
					echo '<p class="productInfoHeading">personalization<br /><span class="note">(style: ' . $cartItem->parts->personalizationStyle . ')</span></p>';
					echo '<p class="productInfo">';
					echo nl2br($cartItem->parts->personalization);
					echo '</p>' . "\n";
					echo '</div>' . "\n";
				}
	
				echo '<div class="quantity">' . "\n"; 
				echo '<p class="productInfoHeading">quantity</p>';
				echo '<p class="productInfo">';
				echo $cartItem->quantity;
				echo '</p>' . "\n";
				echo '</div>' . "\n";
	
				echo '<p class="productInfoHeading">unit price</p>';
				$temp = $cartItem->unitPrice;
				$pos = strpos($temp, '.');
				if ($pos === false)
					$temp = $temp . '.00';
					else if (strlen ($temp) - $pos == 2)
						$temp = $temp. '0';
				echo '<p class="productInfo">$';
				echo $temp;
				echo '</p>';
	
				echo '<p class="productInfoHeading">extended price</p>';
				$temp = round( ($cartItem->unitPrice * $cartItem->quantity), 2 );
				$pos = strpos($temp, '.');
				if ($pos === false)
					$temp = $temp . '.00';
					else if (strlen ($temp) - $pos == 2)
						$temp = $temp. '0';
				echo '<p class="productInfo">$';
				echo $temp;
				echo '</p>';
	
				if (isset ($cartItem->comments) ) {
					echo '<div class="itemComment">';
					echo '<p class="productInfoHeading" >item comments<br /><span class="note">(not on item)</span></p>';
					echo '<p class="productInfo">';
					echo nl2br($cartItem->comments);
					echo '</p>';
					echo '</div>';
				}
	
				echo '</div>';
			}
		?>
	</div>
	
	<?
}
?>
