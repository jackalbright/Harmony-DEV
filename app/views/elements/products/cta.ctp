<? $direct_upload = true; ?>
<?if(empty($product['Product']['is_stock_item'])) { ?>
<? if(empty($prod)) { $prod = ''; } ?>

<div align="center" class="bold">
	<form method="POST" action="/gallery" enctype="multipart/form-data" onSubmit="showPleaseWait();">
		<? if(count($compare_products) > 1) { ?>
		<select name="prod" style="width: 150px;">
			<? foreach($related_products as $rp) { ?>
			<option value="<?= $rp['Product']['code'] ?>"><?= !empty($rp['Product']['pricing_name']) ? $rp['Product']['pricing_name'] : $rp['Product']['name'] ?></option>
			<? } ?>
		</select>
		<br/>
		<div style="font-size: 10px;">(You can change<br/>your product later)</div>
		<? } else { ?>
		<input type="hidden" name="prod" value="<?= $product['Product']['code'] ?>"/>
		<? } ?>
		<input type="image" src="/images/buttons/See-Your-Design-Now.gif"/>
	</form>
</div>

<? } else { ?>
<div align="left" class="">
	<div style="border: solid #AAA 1px; background-color: white; width: 225px;">
	<h6 align="left" style="background-color: #CCC; padding: 5px; font-weight: bold;">Order <?= Inflector::pluralize($product['Product']['short_name']) ?></h6>
	<?= $this->element("products/stock_calc_container",array('p'=>$product['Product'])); ?>
	<script>
	//document.observe('dom:loaded', function() { calculateStockSubtotal('<?= $product['Product']['code'] ?>'); });
	</script>
	</div>
</div>

<? } ?>
