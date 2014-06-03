<div class="quoteRequests form " style="padding: 15px;">
<?php echo $form->create('QuoteRequest', array('url'=>$this->here,'onSubmit'=>"return verifyRequiredFields(this);"));?>
	<h4 class="bold" >Request for a custom price quote for <?= !empty($product) ? preg_replace("/custom /", "", $hd->pluralize(strtolower($product['Product']['short_name']))) : "" ?></h4>
	<script>
	function changeProduct(prod)
	{
		var options_PW = $('options_PW');
		if(prod == '13' && options_PW) // Rect pw
		{
			options_PW.removeClassName('hidden');
		} else if(options_PW) {
			options_PW.addClassName('hidden');
		}
	}
	</script>

	<table width="100%"><tr>
	<td valign="top">
	<?

		if(empty($product)) { echo $form->input('product_id',array('label'=>'Select a product','onChange'=>"changeProduct(this.value);")); }

		if(!empty($related_products) && count($related_products) > 1 && $prod != 'B') { echo $form->input("product_id",array('label'=>'Select a style','options'=>$related_products,'onChange'=>"changeProduct(this.value);")); }
		else { echo $form->hidden("product_id"); }

		?>
		<br/>
		<?= $form->input('quantity',array('style'=>'width: 75px;','class'=>'required')); ?>
		<br/>

		<div>
			<? if($prod == 'B') { ?>
			<label>Options</label>
<div class="clear"></div>
<?= $form->input("options.0",array('value'=>'printing on back','label'=>'Printing on back','type'=>'checkbox')); ?>
<?= $form->input("options.1",array('value'=>'tassel','label'=>'Deluxe chainette tassel','type'=>'checkbox','id'=>'options_tassel', 'onClick'=>"if(!this.checked) { $('options_charm').checked = ''; }")); ?>
<?= $form->input("options.2",array('value'=>'charm','label'=>'Gold-plated charm','type'=>'checkbox','id'=>'options_charm','onClick'=>"if(this.checked) { $('options_tassel').checked = 'checked'; } ")); ?>
			<? } else if ($prod == 'PW') { ?>
<div id="options_PW" class="<?= $prod != 'PW' ? 'hidden' : "" ?>">
			<label>Options</label>
<div class="clear"></div>
<?= $form->input("options",array('value'=>'charm','label'=>'Gold-plated charm','type'=>'checkbox')); ?>
</div>
			<? } ?>
		</div>
		<br/>
		<?
			
		?>

		<?= $form->input('name',array('class'=>'required','label'=>'First Name')); ?>
		<?= $form->input('last_name',array('class'=>'required','label'=>'Last Name')); ?>
		<?= $form->input('organization',array('label'=>'Organization (optional)')); ?>

		<br/>
		<p>Let us know how we can contact you</p>
		<?= $form->input('email',array('class'=>'required')); ?>
		<?= $form->input('phone'); ?>

		<br/>
		<br/>

		<div class="alert bold">* Required fields</div>
	</td>
	<td valign="top">

		<br/>
		<?= $form->input('comments',array('label'=>'Your Comments','style'=>'width: 100%;')); ?>

		<br/>
		<?= $this->Captcha->show(); ?>

		<br/>
		<div align="center">
		<?= $form->submit("/images/webButtons2014/grey/large/send.png"); ?>
		</div>
	</td>
	</tr></table>

<?php echo $form->end();?>
</div>
