<?php
if($prod == 'DPW' || $prod == 'DPW-FLC'){
	$divStyle = " style='display:none;' ";
}else{
	$divStyle = "";
}
?>

<div class="clear" id="quoteDivTest" <?php echo $divStyle?> >

	<table width="100%" style="padding-left: 20px;">

	<? if(!empty($recommendedQuotes)) { ?>
	<tr>
		<td colspan=2 class="build_option_group_header">
			<a href="Javascript:void(0);" onClick="toggleBuildOptionsGroup('recommendedQuotes','quotes_group','customQuote');"><img align="top" id="recommendedQuotes_arrow_hide" class="build_option_group_arrow hidden " src="/images/icons/arrow_right.gif"/><img align="top" id="recommendedQuotes_arrow_show" class="build_option_group_arrow" src="/images/icons/arrow_down.gif"/></a>
			<a href="Javascript:void(0);" onClick="toggleBuildOptionsGroup('recommendedQuotes','quotes_group');"><?= $build['GalleryImage']['stamp_name'] ?> Quotes (<?= count($recommendedQuotes); ?>)</a>
		</td>
	</tr>
	<tr id="recommendedQuotes" class="build_option_group quotes_group">
	<td colspan=2>
		<div style="height: 300px; overflow: scroll;">
		<table width="90%">
		<? foreach($recommendedQuotes as $quote) { ?>
		<tr>
			<td valign="top">
				<input type="radio" name="data[options][quoteID]" <? if(!empty($build['options']['quoteID']) && $build['options']['quoteID'] == $quote['Quote']['quote_id']) { echo "checked='checked'"; } ?> value="<?= $quote['Quote']['quote_id'] ?>" onClick="$('option_quote').value = ''; updateBuild('<?=$i?>'); "/>
			</td>
			<td valign="top">
				<div class="quoteText">
					<?= $quote['Quote']['text']; ?>
				</div>
	
				<? if(!empty($quote['Quote']['attribution'])) { ?>
				<div class="quoteAttribution">
					<br/>- <?= $quote['Quote']['attribution']; ?>
				</div>
				<? } ?>
			</td>
		</tr>
		<? } ?>
		</table>
		</div>
	</td>
	</tr>
	<? } ?>

	<? if(!empty($productQuotes)) { ?>
	<tr>
		<td colspan=2 class="build_option_group_header">
			<a href="Javascript:void(0);" onClick="toggleBuildOptionsGroup('productQuotes','quotes_group','customQuote');"><img align="top" id="productQuotes_arrow_hide" class="build_option_group_arrow " src="/images/icons/arrow_right.gif"/><img align="top" id="productQuotes_arrow_show" class="build_option_group_arrow hidden" src="/images/icons/arrow_down.gif"/></a>
			<a href="Javascript:void(0);" onClick="toggleBuildOptionsGroup('productQuotes','quotes_group','customQuote');"><?= $build['Product']['name'] ?> Quotes (<?= count($productQuotes); ?>)</a>
		</td>
	</tr>
	<tr id="productQuotes" class="quotes_group build_option_group hidden">
	<td colspan=2>
		<div style="height: 300px; overflow: scroll;">
		<table width="90%">
		<? foreach($productQuotes as $quote) { ?>
		<tr>
			<td valign="top">
				<input type="radio" name="data[options][quoteID]" <? if(!empty($build['options']['quoteID']) && $build['options']['quoteID'] == $quote['Quote']['quote_id']) { echo "checked='checked'"; } ?> value="<?= $quote['Quote']['quote_id'] ?>" onClick="$('option_quote').value = ''; updateBuild('<?=$i?>'); "/>
			</td>
			<td valign="top">
				<div class="quoteText">
					<?= $quote['Quote']['text']; ?>
				</div>
	
				<? if(!empty($quote['Quote']['attribution'])) { ?>
				<div class="quoteAttribution">
					<br/>- <?= $quote['Quote']['attribution']; ?>
				</div>
				<? } ?>
			</td>
		</tr>
		<? } ?>
		</table>
		</div>
	</td>
	</tr>
	<? } ?>

	<tr>
		<td colspan=2 class="build_option_group_header">
			<a href="Javascript:void(0);" onClick="toggleBuildOptionsGroup('customQuote','quotes_group','customQuote');"><img align="top" id="customQuote_arrow_hide" class="build_option_group_arrow <?= empty($recommendedQuotes) ? "hidden" : "" ?>" src="/images/icons/arrow_right.gif"/><img align="top" id="customQuote_arrow_show" class="build_option_group_arrow <?= empty($recommendedQuotes) ? "" : "hidden" ?>" src="/images/icons/arrow_down.gif"/></a>
			<a href="Javascript:void(0);" onClick="toggleBuildOptionsGroup('customQuote','quotes_group','customQuote');">Custom Quote/Text</a>
		</td>
	</tr>
	<tbody id="customQuote" class="quotes_group build_option_group <?= empty($recommendedQuotes) ? "" : "hidden" ?>">
	<tr>
		<td valign="top" colspan=2> 
			<div align="right">
					<a rel="shadowbox;width=800;height=400" href="/build/quote_select/<?= $build['Product']['code'] ?>/<?= !empty($build['GalleryImage']) ? $build['GalleryImage']['catalog_number'] : "" ?>">Text/Quotation Library</a>
			</div>

		</td>
	</tr>
	<tr>
		<td valign="top">
			<input id="other_quoteID" type="radio" name="data[options][quoteID]" value="" <? if(empty($build['options']['quoteID'])) { echo "checked='checked'"; } ?> > 
		</td>
		<td valign="top">
	<textarea name="data[options][customQuote]" id="option_quote" style="width: 95%; height: 100px; " 
		onchange="$('other_quoteID').checked = 'checked'; changedQuote('<?= $product['Product']['quote_limit'] ?>'); typingQuote('<?= $product['Product']['quote_limit'] ?>'); updateBuild('<?=$i?>');" 
		onchangeX="$('quote_checkbox').removeClassName('hidden'); changedQuote('<?= $product['Product']['quote_limit'] ?>'); typingQuote('<?= $product['Product']['quote_limit'] ?>'); updateBuildImage();" 
		onblur="changedQuote('<?= $product['Product']['quote_limit'] ?>')" onkeyup="typingQuote('<?= $product['Product']['quote_limit'] ?>');"><?= !empty($build['options']['customQuote']) ? $build['options']['customQuote'] : "" ?></textarea>

			<?  $quoteLength = !empty($build['options']['customQuote']) ? strlen($build['options']['customQuote']) : 0; ?>

			<div class="note">
				<span id="customQuoteLength"><?= !empty($quoteLength) ? $quoteLength : "0" ?></span> of <?= $this_product->quote_limit ?> characters.
			</div>
		</td>
	</tr>
	</tbody>
	</table>
	
	<br/>

</div>

