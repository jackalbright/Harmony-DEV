<div id="quantity_container">

	<div>
		<input type="text" name="quantity" value="<?= $build['quantity'] ?>" size="4" onChange="alert('changing pricing, etc...'); showPleaseWait();"/> qty.
	</div>
	<?
		# Loop through options.???
	?>
	<div>
		<?= sprintf("$%.02f", $build['quantity_price_list']['total']); ?> unit price
	</div>
	<div>
		<?= sprintf("$%.02f", $build['quantity_price_list']['total']*$build['quantity']); ?> subtotal
	</div>
	?? prices adjust....maybe reload with ajax?

	<script>
		hidePleaseWait();
	</script>
</div>
