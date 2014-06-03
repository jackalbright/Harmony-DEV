<?
$optcodes = Set::combine($options, '{n}.Part.part_code', '{n}');
#print_r(array_keys($optcodes));

$product = $build['Product'];
$productCode = $product['code'];
if(empty($cart_item_id)) { $cart_item_id = ""; }
if(empty($order_item_id)) { $order_item_id = ""; }
$cart_item = $build;
$parts = $build['options'];
if (!empty($parts))
{
	$quoteID = !empty($parts['quoteID']) ? $parts['quoteID'] : null;
	$customQuote = !empty($parts['customQuote']) ? $parts['customQuote'] : null;
	$size = !empty($parts['size']) ? $parts['size'] : null;
	$printSide = !empty($parts['printSide']) ? $parts['printSide'] : null;
	$personalization = !empty($parts['personalizationInput']) ? $parts['personalizationInput'] : null;
}
$repro = !empty($parts['reproductionStamp']) ? strtolower($parts['reproductionStamp']) : null;

if(!empty($parts['charm']['charmID_data']))
{
	$parts['charm_info'] = $parts['charm']['charmID_data']['Charm'];
#echo "CH=";
#print_r($parts['charm_info']);
}
if(!empty($parts['tassel']['tasselID_data']))
{
	$parts['tassel_info'] = $parts['tassel']['tasselID_data']['Tassel'];
#echo "TA=";
#print_r($parts['tassel_info']);
}

?>
<div id="review" class="item_description">
	<table class="productInfo" cellpadding=0 cellspacing=0>
	<? if(!empty($repro) && strtolower($repro) == 'yes') { ?>
		<td colspan=2 class="note">(licensed reproduction stamp)</td>
	<? } ?>
	<tr>
	<td class="productInfoHeading">Item #</td>
	<td class="productInfo">
		<? if(!empty($repro) && strtolower($repro) == 'yes') { ?>R-<? } ?>
		<? 
			$code = $cart_item['Product']['code'];

			if($code == 'B' && empty($parts['tasselID']))
			{
				$code = 'BNT';
			}
			if($code == 'B' && !empty($parts['charmID']))
			{
				$code = 'BC';
			}
		?>
		<?= $code ?>-<?
		if (isset($cart_item['CustomImage'])) {
			echo $cart_item['CustomImage']['Image_ID'];
		} else if (isset($cart_item['GalleryImage'])) {
			echo $cart_item['GalleryImage']['catalog_number'];
		}
		?>
		<!-- xxx todo tasselID, charmID, etc WHATEVERID based if stock item -->
		<!-- but not sure how data saved anyway... need to motify stock add -->
	</td>
	</tr>
	<? if(!empty($optcodes['quote']) && (isset($quoteID) || isset($customQuote))) { ?>
	<tr>
	<td class="productInfoHeading">Quote</td>
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
	<td class="productInfo" align="left" valign="top">
		<script>
		function quantitySum(name)
		{
			var qtys = document.getElementsByClassName(name);
			var qty = 0;
			for (var i = 0; i < qtys.length; i++)
			{
				qty += parseInt(qtys[i].value);
			}
			return qty;
		}
		</script>
		<? if(is_array($size)) { ?>
			<input type="hidden" id="quantity<?= $cart_item_id ?>" name="quantity<?= $cart_item_id?>" value="<?= $cart_item['quantity'] ?>"/>
			<table>
			<? $si = 0; foreach($size as $s => $q) { if(empty($q)) { if(!empty($checkout)) { continue; }; $q = 0; }; ?>
			<? if(!empty($q)) { ?>
			<? if($si % 2 == 0) { ?><tr><? } ?>
			<? $si++; ?>
			<td align="left">
				<?= $s ?>: <? if(!empty($cart_item_id) &&empty($checkout)) { ?><input type="text" size="4" class="quantity_size<?=$cart_item_id?>" name="quantity_size<?=!empty($cart_item_id)?$cart_item_id:""?>[<?=$s?>]" value="<?= $q ?>"/>
				<? } else { ?> <?= $q ?> <? } ?>
			</td>
			<? if($si % 2 == 0) { ?></tr><? } ?>

			<? } ?>
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

	<?
		#echo "TASS=".print_r($optcodes['tassel'],true);
		#echo "TINFO=".print_r($parts['tassel_info'],true);
	?>

	<? if (!empty($optcodes['tassel']) && isset($parts['tassel_info'])) { ?>
	<tr>
	<td class="productInfoHeading">Tassel color</td>
	<td class="productInfo">
		<?= $parts['tassel_info']['color_name'] ?> 
	</td>
	</tr>
	<? } ?>

	<? if (!empty($optcodes['border']) && isset($cart_item['border_info'])) { ?>
	<tr>
	<td class="productInfoHeading">Border</td>
	<td class="productInfo">
		<?= $cart_item['border_info']['name'] ?> 
	</td>
	</tr>
	<? } ?>

	<?
		#echo "CHARM=".print_r($optcodes['charm'],true);
		#echo "CINFO=".print_r($parts['charm_info'],true);
	?>

	<? if (!empty($optcodes['charm']) && isset($parts['charm_info'])) { ?>
	<tr>
	<td class="productInfoHeading">Charm</td>
	<td class="productInfo">
		<? if(!empty($parts['charm_info'])) { ?>
			<?= $parts['charm_info']['name'] ?> 
		<? } else { ?>
			<i>None</i>
		<? } ?>
	</td>
	</tr>
	<? } ?>

	<? if (!empty($optcodes['ribbon']) && isset($cart_item['ribbon_info'])) { ?>
	<tr>
	<td class="productInfoHeading">Ribbon</td>
	<td class="productInfo">
		<?= ucwords($cart_item['ribbon_info']['color_name']) ?> 
	</td>
	</tr>
	<? } ?>

	<? if (!empty($optcodes['frame']) && isset($cart_item['frame_info'])) { ?>
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

	<? if (isset($parts['backgroundColor'])) { ?>
	<tr>
	<td class="productInfoHeading">Background color</td>
	<td class="productInfo">
		<?= $backgroundColors[$parts['backgroundColor']] ?> 
	</td>
	</tr>
	<? } ?>
	
	<? if (!empty($optcodes['personalization']) && isset($personalization)) { ?>
	<tr>

	<td class="productInfoHeading">Personalization
	<? if(!empty($parts['personalizationStyle'])) { ?><br/><span class="note">(style: <?= $parts['personalizationStyle'] ?>)</span><? } ?>
	<? if(!empty($parts['personalizationColor'])) { ?><br/><span class="note">(color: <?= $parts['personalizationColor'] ?>)</span><? } ?>
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

	<!--

	<tr>
	<td class="productInfoHeading">Comments</td>
	<td class="productInfo">
		<? if (!empty($parts['itemComments'])) { ?>
			<?= nl2br($parts['itemComments']) ?> 
		<? } ?>
	</td>
	</tr>
	-->

	<? if (empty($build['Product']['is_stock_item'])) { ?>
	<tr>
	<td class="productInfoHeading">Proof</td>
	<td class="productInfo">
		<?= (!empty($cart_item['proof']) && $cart_item['proof'] == 'yes') ? "yes" : "no"; ?>
	</td>
	</tr>
	<? } ?>
	</table>

</div>
