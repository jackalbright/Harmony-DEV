<?
$parts = !empty($cartItem['parts']) ? $cartItem['parts'] : array();
$parts2 = !empty($cartItem['parts2']) ? $cartItem['parts2'] : array();
$sides = array($parts);
if(!empty($parts2)) { $sides[] = $parts2; }
?>

<div class="item_description">
	<h4>
		<? if((!empty($parts['customImageID']) || !empty($parts['catalogNumber'])) && empty($checkout) && empty($cartItem['order_item_id'])) { ?>
			<? if(!empty($this->params['admin'])) { ?>
				<a style="color: #0369A7;" href="/admin/cartItems/edit/<?= $cartItem['cart_item_id'] ?>">
			<? } else { ?>
				<a href="/design/edit/<?= $cartItem['cart_item_id'] ?>">
			<? } ?>
		<? } else if (!empty($order_item_id) && !empty($reorder_url)) { ?>
			<a href="<?= $reorder_url; # FIX W/DETAILS ?>">
		<? } ?>
		<? if (isset($cartItem['GalleryImage'][0])) { ?>
			&#8220;<?= $cartItem['GalleryImage'][0]['stamp_name'] ?>&#8221;
		<? } ?>
		<? if (isset($cartItem['GalleryImage'][1])) { ?>
			/ &#8220;<?= $cartItem['GalleryImage'][1]['stamp_name'] ?>&#8221;
		<? } ?>
		<?= $cartItem['Product']['name'] ?>
		<?= !empty($parts2) ? "(Double Sided)" : "" ?>
		<? if(empty($checkout) && ((!empty($parts['customImageID']) || !empty($parts['catalogNumber']) || !empty($cartItem['order_item_id'])))) { ?>
		</a>
		<? } ?>
	</h4>
	<table class="productInfo" cellpadding=0 cellspacing=0>
	<? if(!empty($parts['reproductionStamp']) && strtolower($parts['reproductionStamp']) == 'yes') { ?>
		<td colspan=2 class="note">(licensed reproduction stamp)</td>
	<? } ?>
	<tr>
	<td class="productInfoHeading">Item #</td>
	<td class="productInfo">
		<? if(!empty($parts['reproductionStamp']) && strtolower($parts['reproductionStamp']) == 'yes') { ?>R-<? } ?>
		<?= $cartItem['Product']['code'] ?>-<?= !empty($parts['catalogNumber']) ?
			$parts['catalogNumber'] : (!empty($parts['customImageID']) ? 
			$parts['customImageID'] : null); 
		?>
		<? if(!empty($parts2)) { ?>
		/
		<?= $cartItem['Product']['code'] ?>-<?= !empty($parts2['catalogNumber']) ?
			$parts2['catalogNumber'] : (!empty($parts2['customImageID']) ? 
			$parts2['customImageID'] : null); 
		?>
		<? } ?>
	</td>
	</tr>
<? for($i = 0; $i < count($sides); $i++) { 
	$side = $sides[$i];
	$meta = !empty($side['meta']) ? $side['meta'] : $cartItem; # Worst case scenario, old stuff.
?>
	<tr>
		<td style="font-size: 1.2em;" class='productInfoHeading bold'>
			<? if(count($sides) > 1) { ?>
			Side <?= $i+1 ?>
			<? } else { ?>
				&nbsp;
			<? } ?>
		</td>
		<td>
			<? if(empty($checkout) && empty($cartItem['order_item_id'])) { ?>
				<a href="/design/edit/<?= $cartItem['cart_item_id'] ?>#side<?= $i+1 ?>">Make Changes</a>
			<? } ?>
		</td>
	</tr>
	<? if(isset($side['quoteID']) || isset($side['customQuote'])) { ?>
	<tr>
	<td class="productInfoHeading">Quote </td>
	<td class="productInfo">
		<? if(!empty($meta['quote_info'])) { ?>
			<? if(isset($meta['quote_info']['title'])) { ?>
			<em><?= $meta['quote_info']['title'] ?></em>
			<? } ?>
			<? if($meta['quote_info']['text']) { ?>
			&#8220;
			<?= $meta['quote_info']['text'] ?>
			&#8221;
			<? } ?>
		<? } else if (!empty($side['customQuote'])) { ?>
			<?= nl2br($side['customQuote']); ?> 
		<? } else { ?>
			<i>None</i>
		<? } ?>
		<? if (!empty($side['quote_attribution'])) { ?>
			<div class='italic'>&mdash; <?= nl2br($side['quote_attribution']); ?></div>
		<? } ?>
	</td>
	</tr>
	<? } ?>
			
	<? if (isset($side['size'])) { ?>
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
		<? if(is_array($side['size'])) { ?>
			<input type="hidden" id="quantity<?= $cartItem['cart_item_id'] ?>" name="quantity<?= $cartItem['cart_item_id']?>" value="<?= $cartItem['quantity'] ?>"/>
			<table>
			<? $si = 0; foreach($size as $s => $q) { if(empty($q)) { continue; } ?>
			<? if($si % 2 == 0) { ?><tr><? } ?>
			<? $si++; ?>
			<td align="right">
				<?= $s ?>: <?= $q ?>
			</td>
			<? if($si % 2 == 0) { ?></tr><? } ?>

			<? } ?>
			</table>
		<? } else { ?>
			<?= $side['size'] ?> 
		<? } ?>
	</td>
	</tr>
	<? } ?>
	<? if (isset($side['crystalType'])) { ?>
	<tr>
	<td class="productInfoHeading">Crystal</td>
	<td class="productInfo">
		<?= $side['crystalType'] ?> 
	</td>
	</tr>
	<? } ?>

	<? if (isset($side['printSide'])) { ?>
	<tr>
	<td class="productInfoHeading">Print side</td>
	<td class="productInfo">
		<?= $side['printSide'] ?> 
	</td>
	</tr>
	<? } ?>

	<? if (isset($meta['tassel_info'])) { ?>
	<tr>
	<td class="productInfoHeading">Tassel color</td>
	<td class="productInfo">
		<?= $meta['tassel_info']['color_name'] ?> 
	</td>
	</tr>
	<? } ?>

	<? if (isset($meta['border_info'])) { ?>
	<tr>
	<td class="productInfoHeading">Border</td>
	<td class="productInfo">
		<?= $meta['border_info']['name'] ?> 
	</td>
	</tr>
	<? } ?>

	<? if (isset($meta['charm_info'])) { ?>
	<tr>
	<td class="productInfoHeading">Charm</td>
	<td class="productInfo">
		<? if(!empty($meta['charm_info'])) { ?>
			<?= $meta['charm_info']['name'] ?> 
		<? } else { ?>
			<i>None</i>
		<? } ?>
	</td>
	</tr>
	<? } ?>

	<? if (isset($meta['ribbon_info'])) { ?>
	<tr>
	<td class="productInfoHeading">Ribbon</td>
	<td class="productInfo">
		<?= ucwords($meta['ribbon_info']['color_name']) ?> 
	</td>
	</tr>
	<? } ?>

	<? if (isset($meta['frame_info'])) { ?>
	<tr>
	<td class="productInfoHeading">Frame</td>
	<td class="productInfo">
		<?= $meta['frame_info']['name'] ?> 
	</td>
	</tr>
	<? } ?>

	<? if (isset($side['pinStyle'])) { ?>
	<tr>
	<td class="productInfoHeading">Pin style</td>
	<td class="productInfo">
		<?= $side['pinStyle']; ?>
	</td>
	</tr>
	<? } ?>

	<? if (isset($side['handles'])) { ?>
	<tr>
	<td class="productInfoHeading">Handle color</td>
	<td class="productInfo">
		<?= $side['handles'] ?> 
	</td>
	</tr>
	<? } ?>

	<? if (!empty($side['backgroundColor']) && !empty($backgroundColors[$side['backgroundColor']])) { ?>
	<tr>
	<td class="productInfoHeading">Background color</td>
	<td class="productInfo">
		<?= $backgroundColors[$side['backgroundColor']] ?> 
	</td>
	</tr>
	<? } ?>
	
	<? if (isset($side['personalization_logo_id'])) { ?>
	<tr>

	<td class="productInfoHeading">Personalization Logo
	</td>
	<td class="productInfo">
		Logo #<?= $side['personalization_logo_id'] ?>
	</td>
	</tr>
	<? } else if (isset($side['personalization'])) { ?>
	<tr>

	<td class="productInfoHeading">Personalization
	<? if(false && !empty($side['personalizationStyle'])) { ?><br/><span class="note">(style: <?= $parts['personalizationStyle'] ?>)</span><? } ?>
	<? if(false && !empty($side['personalizationColor'])) { ?><br/><span class="note">(color: <?= $parts['personalizationColor'] ?>)</span><? } ?>
	</td>
	<td class="productInfo">
		<? if(!empty($side['personalization'])) { ?>
			<?= nl2br($side['personalization']) ?> 
		<? } else { ?>
			<i>None</i>
		<? } ?>
	</td>
	</tr>
	<? } ?>
<? } ?>


	<? if (!empty($cartItem['comments'])) { ?>
	<tr>
	<td class="productInfoHeading">Comments</td>
	<td class="productInfo">
			<?= nl2br($cartItem['comments']) ?> 
	</td>
	</tr>
	<? } ?>

	<? if (empty($cartItem["Product"]['is_stock_item'])) { ?>
	<tr>
	<td class="productInfoHeading">Proof</td>
	<td class="productInfo">
		<?= (!empty($cartItem['proof']) && $cartItem['proof'] == 'yes') ? "yes" : "no"; ?>
	</td>
	</tr>
	<? } ?>
	</table>
</div>
