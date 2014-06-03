<?
$productCode = $product['code'];
if(empty($cart_item_id)) { $cart_item_id = ""; }
if(empty($order_item_id)) { $order_item_id = ""; }
$parts = array();
if (!empty($cart_item['parts']))
{
	$parts = $cart_item['parts'];
	$quoteID = !empty($parts['quoteID']) ? $parts['quoteID'] : null;
	$customQuote = !empty($parts['customQuote']) ? $parts['customQuote'] : null;
	$size = !empty($parts['size']) ? $parts['size'] : null;
	$printSide = !empty($parts['printSide']) ? $parts['printSide'] : null;
	$personalization = !empty($parts['personalizationInput']) ? $parts['personalizationInput'] : null;
	$personalizationSize = !empty($parts['personalizationSize']) ? $parts['personalizationSize'] : null;
	$personalizationLogoID = !empty($parts['personalization_logo_id']) ?  $parts['personalization_logo_id'] : null;
}
if (!empty($cart_item['ItemPart']))
{
	$parts = $cart_item['ItemPart'];
	$quoteID = $parts['quote_ID'];
	$customQuote = $parts['custom_quote'];
	$size = $parts['Size'];
	$printSide = $parts['PrintSide'];
	$personalization = $parts['personalization'];
	$personalizationLogoID = $parts['personalization_logo_id'];

	$reorder_url = empty($product['is_stock_item']) ? "/build/customize?reorder=true&itemID=".$order_item_id : 
		"/cart/add?productCode=$productCode&quantity=$quantity";
}
$textSize = !empty($parts['textSize']) ? $parts['textSize'] : null;
$personalizationSize = !empty($parts['personalizationSize']) ? $parts['personalizationSize'] : null;
$repro = !empty($parts['reproductionStamp']) ? strtolower($parts['reproductionStamp']) : null;

?>
<div class="item_description">
	<h4>
		<? if((!empty($imageID) || !empty($catalog_number)) && empty($checkout) && empty($order_item_id)) { ?>
			<? if(!empty($this->params['admin'])) { ?>
				<a style="color: #0369A7;" href="/admin/cart_items/edit/<?= $cart_item_id ?>">
			<? } else { ?>
				<a href="/build/step?catalogNumber=<?= $catalog_number ?>&imageID=<?= $imageID ?>&productCode=<?= $productCode ?>&cart_item_id=<?= $cart_item_id ?>&order_item_id=<?= $order_item_id ?>">
			<? } ?>
		<? } else if (!empty($order_item_id)) { ?>
			<a href="<?= $reorder_url ?>">
		<? } ?>
		<? if(isset($cart_item['CustomImage']) && !empty($cart_item['CustomImage']['Title'])) { ?>
			&#8220;<?= $cart_item['CustomImage']['Title'] ?>&#8221;
		<? } else if (isset($cart_item['GalleryImage'])) { ?>
			&#8220;<?= $cart_item['GalleryImage']['stamp_name'] ?>&#8221;
		<? } ?>
		<?= $cart_item['Product']['name'] ?>
		<? if(empty($checkout) && ((!empty($imageID) || !empty($catalog_number) || !empty($order_item_id)))) { ?>
		</a>
		<? } ?>
	</h4>
	<table class="productInfo" cellpadding=0 cellspacing=0>
	<? if(!empty($repro) && strtolower($repro) == 'yes') { ?>
		<td colspan=2 class="note">(licensed reproduction stamp)</td>
	<? } ?>
	<tr>
	<td class="productInfoHeading">Item #</td>
	<td class="productInfo">
		<? if(!empty($repro) && strtolower($repro) == 'yes') { ?>R-<? } ?>
		<?= $cart_item['Product']['code'] ?><?
		if (isset($cart_item['CustomImage'])) {
			echo "-".$cart_item['CustomImage']['Image_ID'];
		} else if (isset($cart_item['GalleryImage'])) {
			echo "-".$cart_item['GalleryImage']['catalog_number'];
		}
		if(!empty($personalizationLogoID)) { 
			echo "-$personalizationLogoID";
		}
		?>
		<!-- xxx todo tasselID, charmID, etc WHATEVERID based if stock item -->
		<!-- but not sure how data saved anyway... need to motify stock add -->
	</td>
	</tr>
	<? if(isset($quoteID) || isset($customQuote)) { ?>
	<tr>
	<td class="productInfoHeading">Quote
		<? if(!empty($textSize)) { ?> <br/><span class='note'>(Size: <?= $textSize ?>)</span> <? } ?>
	</td>
	<td class="productInfo">
		<? if(isset($cart_item['quote_info'])) { ?>
			<? if(isset($cart_item['quote_info']['title'])) { ?>
			<em><?= $cart_item['quote_info']['title'] ?></em>
			<? } ?>
			<? if(isset($cart_item['quote_info']['text'])) { ?>
			&#8220;
			<?= $cart_item['quote_info']['text'] ?>
			&#8221;
			<? } ?>
		<? } else if (isset($customQuote)) { ?>
			<?= nl2br($customQuote); ?> 
		<? } ?>
	</td>
	</tr>
	<? } ?>
			
	<? if (isset($size)) { ?>
	<tr>
	<td class="productInfoHeading">Size</td>
	<td class="productInfo" align="right">
		<script>
		function quantitySum(name)
		{
			var qtys = $$('.'+name);//IE doesnt like.... document.getElementsByClassName(name);
			var qty = 0;
			for (var i = 0; i < qtys.length; i++)
			{
				if(qtys[i].value)
				{
				qty += parseInt(qtys[i].value);
				}
			}
			return qty;
		}
		</script>
		<? if(is_array($size)) { ?>
			<input type="hidden" id="quantity<?= $cart_item_id ?>" name="quantity<?= $cart_item_id?>" value="<?= $cart_item['quantity'] ?>"/>
			<table>
			<? $si = 0; foreach($size as $s => $q) { if(empty($q)) { continue; } ?>
			<? if($si % 2 == 0) { ?><tr><? } ?>
			<? $si++; ?>
			<td align="right">
				<?= $s ?>: <? if(false && !empty($cart_item_id) &&empty($checkout)) { ?>
				<? } else { ?> <?= $q ?> <? } ?>
			</td>
			<? if($si % 2 == 0) { ?></tr><? } ?>

			<? } ?>
			</table>
			<? if(false && empty($checkout)) { ?>
			<input type="image" height="20" src="/images/buttons/Update-Qty-grey.gif" onClick="return checkMinimum(quantitySum('quantity_size<?=$cart_item_id?>'), '<?= $product['minimum'] ?>', 'quantity<?=$cart_item_id?>');"/>
			<? } ?>
		<? } else { ?>
			<?= $size ?> 
		<? } ?>
	</td>
	</tr>
	<? } ?>
	<? if (isset($parts['crystalType'])) { ?>
	<tr>
	<td class="productInfoHeading">Crystal</td>
	<td class="productInfo">
		<?= $parts['crystalType'] ?> 
	</td>
	</tr>
	<? } ?>

	<? if (isset($printSide)) { ?>
	<tr>
	<td class="productInfoHeading">Print side</td>
	<td class="productInfo">
		<?= $printSide ?> 
	</td>
	</tr>
	<? } ?>

	<? if (isset($cart_item['tassel_info'])) { ?>
	<tr>
	<td class="productInfoHeading">Tassel color</td>
	<td class="productInfo">
		<?= $cart_item['tassel_info']['color_name'] ?> 
	</td>
	</tr>
	<? } ?>

	<? if (isset($cart_item['border_info'])) { ?>
	<tr>
	<td class="productInfoHeading">Border</td>
	<td class="productInfo">
		<?= $cart_item['border_info']['name'] ?> 
	</td>
	</tr>
	<? } ?>

	<? if (isset($cart_item['charm_info'])) { ?>
	<tr>
	<td class="productInfoHeading">Charm</td>
	<td class="productInfo">
		<? if(!empty($cart_item['charm_info'])) { ?>
			<?= $cart_item['charm_info']['name'] ?> 
		<? } else { ?>
			<i>None</i>
		<? } ?>
	</td>
	</tr>
	<? } ?>

	<? if (isset($cart_item['ribbon_info'])) { ?>
	<tr>
	<td class="productInfoHeading">Ribbon</td>
	<td class="productInfo">
		<?= ucwords($cart_item['ribbon_info']['color_name']) ?> 
	</td>
	</tr>
	<? } ?>

	<? if (isset($cart_item['frame_info'])) { ?>
	<tr>
	<td class="productInfoHeading">Frame</td>
	<td class="productInfo">
		<?= $cart_item['frame_info']['name'] ?> 
	</td>
	</tr>
	<? } ?>

	<? if (isset($parts['pinStyle'])) { ?>
	<tr>
	<td class="productInfoHeading">Pin style</td>
	<td class="productInfo">
		<?= $parts['pinStyle']; ?>
	</td>
	</tr>
	<? } ?>

	<? if (isset($parts['handles'])) { ?>
	<tr>
	<td class="productInfoHeading">Handle color</td>
	<td class="productInfo">
		<?= $parts['handles'] ?> 
	</td>
	</tr>
	<? } ?>

	<? if (!empty($parts['backgroundColor']) && !empty($backgroundColors[$parts['backgroundColor']])) { ?>
	<tr>
	<td class="productInfoHeading">Background color</td>
	<td class="productInfo">
		<?= $backgroundColors[$parts['backgroundColor']] ?> 
	</td>
	</tr>
	<? } ?>
	
	<? if (isset($personalizationLogoID)) { ?>
	<tr>

	<td class="productInfoHeading">Personalization Logo
	</td>
	<td class="productInfo">
		Logo #<?= $personalizationLogoID ?>
	</td>
	</tr>
	<? } else if (isset($personalization)) { ?>
	<tr>

	<td class="productInfoHeading">Personalization
	<? if(!empty($parts['personalizationStyle'])) { ?><br/><span class="note">(style: <?= $parts['personalizationStyle'] ?>)</span><? } ?>
	<? if(!empty($parts['personalizationColor'])) { ?><br/><span class="note">(color: <?= $parts['personalizationColor'] ?>)</span><? } ?>
	<? if(!empty($textSize)) { ?> <br/><span class='note'>(Size: <?= $textSize ?>)</span> <? } ?>
	</td>
	<td class="productInfo">
		<? if(!empty($personalization)) { ?>
			<?= nl2br($personalization) ?> 
		<? } else { ?>
			<i>None</i>
		<? } ?>
	</td>
	</tr>
	<? } ?>

	<? if (!empty($cart_item['comments'])) { ?>
	<tr>
	<td class="productInfoHeading">Comments</td>
	<td class="productInfo">
			<?= nl2br($cart_item['comments']) ?> 
	</td>
	</tr>
	<? } ?>

	<? if (empty($cart_item["Product"]['is_stock_item'])) { ?>
	<tr>
	<td class="productInfoHeading">Proof</td>
	<td class="productInfo">
		<?= (!empty($cart_item['proof']) && $cart_item['proof'] == 'yes') ? "yes" : "no"; ?>
	</td>
	</tr>
	<? } ?>
	</table>

	
</div>
