<div class="">

<!--<div class="left" align="left"> <a href="Javascript:void('quote');" onClick="showBuildStepNext('<?= $option_code ?>');"><img src="/images/buttons/small/Next-green.gif"></a> </div>-->

<?
$recommendedQuoteIDs = !empty($recommendedQuotes) ? Set::classicExtract($recommendedQuotes, "{n}.Quote.quote_id") : array();
?>

		<div style="height: 120px; margin-bottom: 2px;">
			<table 
			cellpadding=0 cellspacing=0 width="100%" border=0>
			<tr>
				<td>
				<b>Style:</b> 
				</td>
				<td>
				<div style="width: 225px; border: solid #CCC 1px; background-color: white; padding: 5px; margin-bottom: 10px;">
				<input type="radio" name="data[options][centerQuote]" value="0" <?= empty($build['options']['centerQuote']) ? "checked='checked'" : "" ?> onClick="showText();"/> <img align="top" src="/images/icons/dropcap.png"/>
				<input type="radio" name="data[options][centerQuote]" value="1" <?= !empty($build['options']['centerQuote']) ? "checked='checked'" : "" ?> onClick="showText();"/> <img align="top" src="/images/icons/centered_text.png"/>
				</div>
				</td>
			</tr>
			<tr>
				<td colspan=1>
				<b>
				Text placement:
				</b>
				</td>
				<td>
					<div style="width: 225px; border: solid #CCC 1px; padding: 5px; background-color: white; margin-bottom: 10px;">
					<input type="radio" name="data[options][alignQuote]" <?= empty($build['options']['alignQuote']) || $build['options']['alignQuote'] == 'top' ? "checked='checked'":""?> value="top" onClick="showText();"/> Top
					<input type="radio" name="data[options][alignQuote]" <?= !empty($build['options']['alignQuote']) && $build['options']['alignQuote'] == 'middle' ? "checked='checked'":""?>value="middle" onClick="showText();"/> Middle
					<input type="radio" name="data[options][alignQuote]" <?= !empty($build['options']['alignQuote']) && $build['options']['alignQuote'] == 'bottom' ? "checked='checked'":""?>  value="bottom" onClick="showText();"/> Bottom
					</div>
				</td>
			</tr>
			<tr>
				<td colspan=1>
				<b>
				Text size:
				</b>
				</td>
				<td>
					<div style="width: 225px; border: solid #CCC 1px; padding: 5px; background-color: white;">
					<select name="data[options][textSize]" onChange="showText();">
						<option value="Small" <?= !empty($build['options']['textSize']) && $build['options']['textSize'] == 'Small' ? "selected='selected'" : "" ?> >Small</option>
						<option value="Medium" <?= !empty($build['options']['textSize']) && $build['options']['textSize'] == 'Medium' ? "selected='selected'" : "" ?> >Medium</option>
						<option value="Large" <?= empty($build['options']['textSize']) || $build['options']['textSize'] == 'Large' ? "selected='selected'" : "" ?> selected="selected">Large</option>
					</select>
					</div>
				</td>
			</tr>
			</table>
		</div>
		<div class="clear"></div>

		<div align="right">
			<a href="Javascript:void(0)" onClick="showText();"><img src="/images/buttons/small/Preview-grey.gif"/></a>
		</div>



	<table style="margin-left: 5px; " class="tab_list" cellpadding=0 cellspacing=0>
	<tr>
		<td id="custom_spacer" class="spacer quotes_spacers <?= empty($build['options']['quoteID']) ? "selected_spacer" : "" ?>">&nbsp;</td>
		<td id="custom_tab" class="quotes_tabs tab <?= empty($build['options']['quoteID']) ? "selected_tab" : "" ?>">
			<a href="Javascript:void(0)" onClick="selectTabNew('custom','quotes');">Custom Text</a>
		</td>
		<td id="browse_spacer" class="spacer quotes_spacers <?= !empty($build['options']['quoteID']) ? "selected_spacer" : "" ?>">&nbsp;</td>
		<td id="browse_tab" class="quotes_tabs tab <?= !empty($build['options']['quoteID']) ? "selected_tab" : "" ?>">
			<a href="Javascript:void(0)" onClick="selectTabNew('browse','quotes'); loadQuoteLibrary();">Browse Quotation Library</a>
		</td>
	</tr>
	</table>

<div style="border: solid #666 1px; padding: 5px; margin: 5px; margin-top: 0px; z-index: 0; position: relative; background-color: white;">

<div id="custom" class="quotes <?= empty($build['options']['quoteID']) ? "" : "hidden" ?>">
			<input id="other_quoteID" type="radio" name="data[options][quoteID]" style="display:none;" value="" <? if(empty($build['options']['quoteID'])) { echo "checked='checked'"; } ?> > 

	<textarea name="data[options][customQuote]" id="option_quote" style="width: 95%; height: 100px; "
		onchange="changedQuote('<?= $build['Product']['quote_limit'] ?>'); typingQuote('<?= $build['Product']['quote_limit'] ?>'); $('other_quoteID').checked = 'checked'; showText();"
		onblur="changedQuote('<?= $build['Product']['quote_limit'] ?>'); " onkeyup="typingQuote('<?= $build['Product']['quote_limit'] ?>');"><?= !empty($build['options']['customQuote']) ? $build['options']['customQuote'] : "" ?></textarea>

			<?  $quoteLength = !empty($build['options']['customQuote']) ? strlen($build['options']['customQuote']) : 0; ?>


			<div class="note" align="right">
				<span id="customQuoteLength"><?= !empty($quoteLength) ? $quoteLength : "0" ?></span> of <?= $build['Product']['quote_limit'] ?> characters.
			</div>
			<div class="clear"></div>



</div>

<script>
//enableDefaultText(j('#option_quote'), 'Type your text here...');
j('#option_quote').ghostable('Type your text here...');

var loaded = false;
function loadQuoteLibrary()
{
	if(!loaded)
	{
		new Ajax.Updater("browse", "/quotes/index/<?= $build['Product']['code'] ?>/<?= !empty($build['GalleryImage']) ? $build['GalleryImage']['catalog_number'] : "" ?>", { asynchronous: false, evalScripts: true });
		loaded = true;
	}
}
</script>

<div id="browse" class="quotes <?= !empty($build['options']['quoteID']) ? "" : "hidden" ?>" XXXXstyle="max-height: 350px; overflow: auto;">
	<?= $this->requestAction("/quotes/index/".$build['Product']['code']."/".(!empty($build['GalleryImage']['catalog_number'])?$build['GalleryImage']['catalog_number']:""), array('return')); ?>
</div>

<? /* ?>
<div id="suggested" class="quotes hidden">
		<div style="max-height: 350px; overflow: auto;">
		<table width="90%">
		<? $qi = 0; foreach($productQuotes as $quote) { ?>
		<tr style="background-color: <?= $qi++ % 2 == 0 ? "#FFF" : "#CCC"; ?>;">
			<td valign="top">
				<input type="radio" name="data[options][quoteID]" <? if(!empty($build['options']['quoteID']) && $build['options']['quoteID'] == $quote['Quote']['quote_id']) { echo "checked='checked'"; } ?> value="<?= $quote['Quote']['quote_id'] ?>" onClick="$('option_quote').value = ''; showText(); "/>
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
</div>
<? */ ?>

		<script>
		// TODO update when text changed.
		j('#step_text').bind('showPart.quote', function (e, dummy, load)
		{
			if(dbg) console.log("T="+j('#template').val());
			if(j('#template').val() == 'imageonly' || j('#template').val() == 'imageonly_nopersonalization') { return; }
			if(dbg) console.log("SHOW TEXT="+load);
			showText(load);
		});

		j(document).ready(function() {
			j('#step_text').trigger('showPart.quote', [null, true]);
		});

		</script>


</div>



		<div align="right">
			<a href="Javascript:void(0)" onClick="showText();"><img src="/images/buttons/small/Preview-grey.gif"/></a>
		</div>


</div>

