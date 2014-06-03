<div class="sampleRequests form" style="padding: 15px;">
<?#= $form->create('SampleRequest',array('url'=>$this->here,'onSubmit'=>"if(j('input.product').size() > 0 && j('input.product:checked').size() <= 0) { j('#styles').formerror('Please choose a style'); return false; }; return verifyRequiredFields(this);"));?>
<?= $form->create('SampleRequest',array('url'=>$this->here,'onSubmit'=>"return verifyRequiredFields(this);",'id'=>'SampleRequestAddForm'));?>
<? if(!empty($this->params['isAjax']) || !empty($this->params['requested'])) { ?>
<script>
j('#SampleRequestAddForm').submit(function(e) {
	j(this).ajaxSubmit({target: '#sample'});
	e.preventDefault();
	return false;
});
</script>
<? } ?>

	<h1>Request a random <?= !empty($product) ? preg_replace("/custom /", "", Inflector::singularize(strtolower($product['Product']['short_name']))) : "" ?> sample</h1>

	<p style='font-size: 15px;'>Inspect quality and materials before you buy. Your sample will be shipped to you within 1-2 business days.</p>

	<div>
	<table width="100%">
	<tr>
	<td valign="top" rowspan=2>
		<?= $form->input('name',array('class'=>'required','label'=>'First Name')); ?>
		<?= $form->input('last_name',array('class'=>'required')); ?>
		<?= $form->input('organization',array('label'=>'Organization (optional)')); ?>
		<br/>
			<p style="font-size: 12px; color: #B82A2A; font-weight: bold;">(U.S. addresses only)</p>
		<br/>
		<?= $form->input('address_1',array('class'=>'required')); ?>
		<?= $form->input('address_2'); ?>
		<?= $form->input('city',array('class'=>'required')); ?>
		<?= $form->input('state',array('class'=>'required')); ?>
		<?= $form->input('zip_code',array('class'=>'required')); ?>

		<br/>
		<br/>

		<div class="bold" style="color: #B82A2A;">* Required fields</div>
	</td>
	<td valign="top">
		<? 
		if(empty($product)) { echo $form->input('product_type_id',array('label'=>'Select a product')); }

		if(!empty($related_products) && count($related_products) > 1) { 
			?> 
			<label> Select a style </label> 
		<div id="styles" class="required_one">
			<div style=""> <?
			$i = 0; foreach($related_products as $rp)
			{
				$pid = $rp['Product']['product_type_id'];
				$pname = $rp['Product']['pricing_name'];
				$pdesc = $rp['Product']['pricing_description'];
				if($pid != 37 && !preg_match("/French Lead/", $pname)) {
				?>
				<input <?= !empty($this->data['SampleRequestProductType'][$i]['product_type_id']) ? "checked='checked'" : "" ?> id="<?= $rp['Product']['code'] ?>" class="left product" type="checkbox" name="data[SampleRequestProductType][<?=$i++ ?>][product_type_id]" value="<?= $pid ?>"/> 
				<div style="float: left; width: 300px; margin-top: 3px;">
					<label style="width: 100%;" for="<?= $rp['Product']['code'] ?>">
					<?= $pname ?>
					<? if(!empty($pdesc)) { ?>
					<div style="font-size: 10px; margin-left: 10px;">
						<?= $pdesc ?>
					</div>
					<? } ?>
					</label>
				</div>
				<div class="clear"></div>
				<?
				}
			}
			?>
			</div>
		</div>

			<?
			if($product['Product']['code'] == 'PW')
			{
			?>
				If you need a French Lead Crystal Domed Paperweight sample, please call 888.293.1109
			<?
			}
		} else {
				?>
				<input type="hidden" name="data[SampleRequestProductType][0][product_type_id]" value="<?= $product['Product']['product_type_id'] ?>"/>
				<?
		}
		?>
		<?= $form->input('comments',array('style'=>'width: 100%')); ?>
		<br/>
		<p>Please provide email or phone in case we have questions</p>
		<div style="padding-right: 25px;" class="right"><input type="image" src="/images/buttons/Send-grey.gif"/></div>
		<?= $form->input('email',array('label'=>'Email or Phone','class'=>'required')); ?>

		<br/>
		<?= $this->Captcha->show(); ?>
	</td>
	</tr>
	</table>

	<table>
	<tr>
	<td valign="middle">
	</td>
	<td valign="middle" align="left">
	<div style="padding-left: 100px;">
	</div>
	</td>
	</tr>
	</table>

	</div>

<?php echo $form->end();?>
</div>
