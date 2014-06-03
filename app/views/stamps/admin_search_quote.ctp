<?= $ajax->form("search_quote/$stamp_id", 'post', array('model'=>'Quote','update'=>'quoteSearch')); ?>

<table><tr>
<td>
	<?= $form->input("keywords",array('label'=>'Search by title, text, attribution','style'=>'width: 400px;')); ?>
</td>
<td>
	<?= $form->submit('Search'); ?>
</td>
</tr></table>

<div class="clear"></div>

<script>
function addQuote(quote_id, checked)
{
	if(checked)
	{
		new Ajax.Updater('recommendedQuotes', "/admin/stamps/add_quote/<?= $stamp_id ?>/"+quote_id, { evalScripts: true, asynchronous: true });
	} else {
		new Ajax.Updater('recommendedQuotes', "/admin/stamps/delete_quote/<?= $stamp_id ?>/"+quote_id, { evalScripts: true, asynchronous: true });
	}
}
</script>

<? if(!empty($this->data['Quote']['keywords'])) { ?>
	<? if(empty($quotes)) { ?>
		<i>No quotes found</i>
	<? } else { ?>
		<? foreach($quotes as $quote) { if(empty($quote['Quote']['text'])) { continue; } ?>
		<div style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: solid #CCC 1px;" id="quote_<?= $quote['Quote']['quote_id'] ?>">
			<div style="font-style: italic;">
				<input type="checkbox" onClick="addQuote('<?= $quote['Quote']['quote_id'] ?>', this.checked)"/>
				<?= $quote['Quote']['text'] ?>
			</div>
			<div align="right" class="">
				&mdash; <?= $quote['Quote']['attribution'] ?>
			</div>
		</div>
		<? } ?>
	<? } ?>
<? } ?>


<?= $form->end(); ?>
