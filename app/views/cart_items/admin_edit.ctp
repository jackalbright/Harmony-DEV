<? $cart_item_id = !empty($this->data['CartItem']['cart_item_id']) ? $this->data['CartItem']['cart_item_id'] : null; ?>
<? $prod = !empty($this->data['CartItem']['productCode']) ? $this->data['CartItem']['productCode'] : null; ?>
<div class="cartItems form" style="width: 600px;">
<?php echo $form->create('CartItem');?>
 	<h2><?php __(!empty($cart_item_id) ? "Update Item " : "Add Item To Cart");?></h2>
	<fieldset>
	<?php
		echo $form->hidden('cart_item_id');
		echo $form->input('customer_id', array('options'=>$customers,'empty'=>'[Choose a Customer]'));
		echo $form->input('productCode', array('label'=>'Product','options'=>$products,'empty'=>'[Select a Product]'));
	?>
	<? $adult_sizes = array('S','M','L','XL','XXL','XXXL'); ?>
	<? $youth_sizes = array('YS','YM','YL','YXL'); ?>
	<table width="100%">
	<tr>
		<td>
			<div id="tshirtQuantity" style="<?= $prod != 'TS' ? 'display: none;' : '' ?>">
				<? foreach($adult_sizes as $size) {
					$qopts = array('class'=>'CartItemQuantitySize','label'=>"Adult $size");
					if($prod != 'TS') { $qopts['disabled'] = 'disabled'; }
				?> 
					<?= $form->input("options.quantity_size.$size", $qopts); ?>
				<? } ?>
				<? foreach($youth_sizes as $size) { 
					$qopts = array('class'=>'CartItemQuantitySize','label'=>"Youth $size");
					if($prod != 'TS') { $qopts['disabled'] = 'disabled'; }
				?> 
					<?= $form->input("options.quantity_size.$size", $qopts); ?>
				<? } ?>
			<hr/>
			</div>
			<?  $qopts = array('class'=>'CartItemQuantity','default'=>1,'after'=>' x '); ?> 
			<?  echo $form->input('quantity',$qopts); ?>
		</td>
		<td>
			<?= $form->input("unitPrice",array('between'=>'$')); ?>
		</td>
		<td><?= $form->input("setupPrice", array('label'=>'Setup / Other Surcharges','default'=>'0','between'=>'+ $')); ?></td>
	</tr>
	</table>
	<table width="100%">
	<tr><td width="50%">
		<?= $form->input("options.catalogNumber", array('label'=>'Stamp','options'=>$stamps,'empty'=>'- None -')); ?>
		<div align="center">
		<br/>
			<img id="GalleryImagePreview" src="" style="background-color: black; "/>
		</div>
		<script>
		j('#optionsCatalogNumber').change(function() {
			var catnum = j(this).val();
			var src = catnum ? "/stamps/"+catnum+".gif" : "/images/sprite.gif";
			j('#GalleryImagePreview').attr('src', src).show();
			if(catnum)
			{
				j('#optionsCustomImageID').val('');
				j('#CustomImagePreview').hide();
			}
		});
		j(document).ready(function() { j('#optionsCatalogNumber').change(); });
		</script>
	</td><td id="upload_container">
		<?= $this->element("../cart_items/admin_upload"); ?>

	</td></tr></table>

	<div id="parts">
		<?= $this->element("../cart_items/parts"); ?>
	</div>
	<script>
	var minimums = <?= json_encode($product_minimums); ?>;

	j('#CartItemCustomer').change(function() {
		// Adjust price for discount.
		j('#CartItemQuantity').change();
	});

	j('.CartItemQuantitySize').change(function() {
		// Sum to CartItemQuantity.
		var sum = 0;
		j('.CartItemQuantitySize').each(function() {
			sum += Number(j(this).val());
		});
		
		j('#CartItemQuantity').val(sum).change();
	});

	j('#CartItemQuantity').change(function() { // Calc unit price.

		// JSON response.
		var prod = j('#CartItemProductCode').val();
		var data = j('#CartItemAdminEditForm').serialize();
		// includes product, quantity, and customer_id (wholesale)

		j.post("/cart_items/unit_price", data, function(resp) {
			j('#CartItemUnitPrice').val(resp.price.total);
			if(resp.setupPrice)
			{
				j('#CartItemSetupPrice').val(resp.setupPrice);
			}
		});
	});

	j('#CartItemProductCode').change(function() {
		var prod = j(this).val();
		if(prod)
		{
			// SHOULD submit/preserve information as well.
			var data = j('#CartItemAdminEditForm').serialize();
			j('#parts').load("/cart_items/parts/"+prod, data);
			if(prod == 'TS')
			{
				j('#tshirtQuantity').show();
				j('#tshirtQuantity input').removeAttr('disabled');
				j('#singleQuantity').hide();
				j('#singleQuantity input').attr('disabled','disabled');

			} else {
				j('#singleQuantity').show();
				j('#singleQuantity input').removeAttr('disabled');
				j('#tshirtQuantity').hide();
				j('#tshirtQuantity input').attr('disabled','disabled');

				// Also load product minimum.
				var qty = parseInt(j('#CartItemQuantity').val());
		
				if(!qty || qty < minimums[prod])
				{
					j('#CartItemQuantity').val(minimums[prod]);
				}
			}
			j('#CartItemQuantity').change(); // trigger getting accurate price.
		} else {
			j('#parts').html('');
			return;
		}

	});

	// Also load product minimum if not '1', and unit priceo
	// reload unit price when qty OR product change

	j(document).ready(function() {
		//j('#CartItemProductCode').change();
	});
	</script>

	<?  echo $form->input('comments', array('class'=>'no_editor')); ?>

	</fieldset>

	<table>
	<tr><td width="300" valign="bottom">
		<?= $form->submit(!empty($this->data["CartItem"]['cart_item_id']) ? "Update Cart" : "Add to Cart"); ?>
	</td><td style="vertical-align: bottom;">
		<? if(!empty($this->data["CartItem"]['cart_item_id'])) { ?>
			<?php echo $html->link(__('Delete Cart Item', true), array('action'=>'delete', $this->data['CartItem']['cart_item_id']), array('style'=>"color: red;"), sprintf(__('Are you sure you want to delete # %s?', true), $this->data['CartItem']['cart_item_id'])); ?>
		<? } ?>
	</td>
	</tr></table>
<?php echo $form->end(); ?>
</div>
	<script>
	j('#CartItemAdminEditForm').submit(function() {
		// ensure nothing missing.
		if(!j('#CartItemProductCode').val())
		{
			alert("Missing product");
			return false;
		}

		if(!j('#optionsCatalogNumber').val() && !j('#optionsCustomImageID').val())
		{
			return confirm("Missing stamp or image upload. Are you sure?");
		}

	});
	</script>
