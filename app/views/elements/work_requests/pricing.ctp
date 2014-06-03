<div>
	<label class="bold">Est. Price</label>
	<?= sprintf("$%.02f", $price); ?>
	<br/>
	<a href="Javascript:void(0);" onClick="calculateWorkRequestPricing($('WorkRequestAddForm'));"><img src="/images/buttons/small/Calculate-grey.gif"/></a>
	<script>
		hidePleaseWait();
	</script>
</div>
