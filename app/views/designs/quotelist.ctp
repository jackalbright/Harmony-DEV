<? if(!empty($quotes)) { ?>
<table width="100%">
<? $i = 0; foreach($quotes as $quote) { ?>
<tr class="<?= $i++ % 2 == 0 ? "odd" : "even" ?>">
	<td style="padding: 10px;" class='Quote'>
		<table width="100%">
		<tr>
			<td width="65" valign="top">
				<a id="quote_<?= $quote['Quote']['quote_id'] ?>" href="javascript:void(0)" class='QuoteID'>
					<img src="/images/buttons/small/Select.gif"/>
				</a>
			</td>
			<td valign="top">
				<div class='text'><?= $quote['Quote']['text'] ?></div>
			</td>
		</tr>
		</table>
		<? if(!empty($quote['Quote']['attribution'])) { ?>
		<div class='attribution'><?= $quote['Quote']['attribution'] ?></div>
		<? } ?>
	</td>
</tr>
<? } ?>
</table>
<? } ?>
