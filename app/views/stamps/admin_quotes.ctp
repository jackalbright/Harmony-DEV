<script>
function deleteQuote(stamp_id, quote_id)
{
	new Ajax.Updater('recommendedQuotes', "/admin/stamps/delete_quote/"+stamp_id+"/"+quote_id, { evalScripts: true, asynchronous: true });
}
</script>

	<? foreach($this->data['Quote'] as $quote) { if(empty($quote['text'])) { continue; } ?>
	<div style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: solid #CCC 1px;" id="quote_<?= $quote['quote_id'] ?>">
		<div style="font-style: italic;">
			<input type="checkbox" checked="checked" onClick="deleteQuote('<?= $stamp_id ?>', '<?= $quote['quote_id'] ?>')"/>
			<?= $quote['text'] ?>
		</div>
		<? if(!empty($quote['attribution'])) { ?>
		<div align="right" class="">
			&mdash; <?= $quote['attribution'] ?>
		</div>
		<? } ?>
	</div>
	<? } ?>
