<div class='form' style='width: 600px;'>

<?= $this->Form->create("Quote", array('url'=>$this->here,'id'=>'QuotesForm')); ?>
<table border=0>
<tr>
	<td valign="bottom">
		<?= $this->Form->input("browse_node_id", array('label'=>'Browse By Category', 'empty'=>'Browse','options'=>$categories)); ?>
	</td>
	<td width="125" align="center" valign="bottom" class="bold" style="padding-bottom: 5px;">
		OR
	</td>
	<td valign="bottom">
		<?= $this->Form->input("keywords", array('label'=>'Search By Keywords')); ?>
	</td>
	<td valign="bottom" width="100">
		<?= $this->Form->submit("Search"); ?>
	</td>
</tr>
</table>

<hr/>

<? if(isset($browseQuotes)) { ?>
	<h3>Browse Results (<?= count($browseQuotes) ?> total)</h3>
	<? if(empty($browseQuotes)) { ?>
	<div style="padding: 10px 0px 25px 25px;">
		<i>No results</i>
	</div>
	<? } else { ?>
	<?= $this->element("../designs/quotelist", array('quotes'=>$browseQuotes)); ?>
	<? } ?>
<hr/>
<? } ?>

<? if(isset($searchQuotes)) { ?>
	<h3>Search Results (<?= count($searchQuotes) ?> total)</h3>
	<? if(empty($searchQuotes)) { ?>
	<div style="padding: 10px 0px 25px 25px;">
		<i>No results</i>
	</div>
	<? } else { ?>
	<?= $this->element("../designs/quotelist", array('quotes'=>$searchQuotes)); ?>
	<? } ?>
<hr/>
<? } ?>

<? if(!empty($productQuotes)) { ?>
	<h3>Product Quotes (<?= count($productQuotes) ?> total)</h3>
	<?= $this->element("../designs/quotelist", array('quotes'=>$productQuotes)); ?>
<? } ?>

<script>
j('#QuoteBrowseNodeId').change(function() {
	j('#QuotesForm').submit();
	j('#QuotesForm #QuoteKeywords').val('');
});

j('#QuotesForm #QuoteKeywords').change(function() {
	j('#QuoteBrowseNodeId').val('');
});
j('#QuotesForm').submit(function() {
	j.loading();
});

j('#QuotesForm a.QuoteID').click(function() {
	j.loading();
	var id = j(this).attr('id').replace(/^quote_/, "");

	// Get quote text.
	var text = j(this).closest('.Quote').find('div.text').text();
	// Extract attribution...
	var attribution = j(this).closest('.Quote').find('div.attribution').text();

	//console.log(text);
	//console.log(attribution);

	if(text)
	{
		j('#DesignSide<?= $side ?>Quote').val(text).blur().change();
	}

	j('#DesignSide<?= $side ?>QuoteAttribution').val(attribution).blur().change();
	// Will clear if not there.

	j('#DesignSide<?= $side ?>QuoteId').val(id);

	j('#DesignForm').save();

	j('#modal').modalclose(function() {
		j.loading(false);
	});

});

j.loading(false);

// On loading content, resize.
j('#modal').modalready(function() {
	j('#modal').modalcenter();
});

</script>






<?= $this->Form->end(); ?>
</div>
