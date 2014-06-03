<div class="templateRequests form" style="padding: 15px;"> 
<?php echo $form->create('TemplateRequest',array('url'=>$this->here, 'onSubmit'=>"return verifyRequiredFields(this);"));?>
	<h4 class="bold" >Request for a <?= !empty($product) ? preg_replace("/custom /", "", Inflector::singularize(strtolower($product['Product']['short_name']))) : "" ?> template in PDF format</h4>

	<table width="100%">
	<tr>
	<td valign="top">

	<?
	if(empty($product)) { echo $form->input('product_id',array('label'=>'Select a product')); }

	if(!empty($related_products) && count($related_products) > 1) { echo $form->input("product_id",array('label'=>'Select a style','options'=>$related_products)); }
	else { echo $form->hidden("product_id",array('value'=>$product['Product']['product_type_id'])); }
	?>
	
	<?php
		echo $form->input('name',array('class'=>'required','label'=>'First Name'));
		echo $form->input('last_name',array('class'=>'required','label'=>'Last Name'));
		echo $form->input('organization',array('label'=>'Organization (optional)','class'=>''));
		?>
		<br/>

		<?= $form->input('email',array('class'=>'required')); ?>
		Email is required so we can<br/>send you your template

		<?= $form->input('phone',array('class'=>'')); ?>
		A phone number is useful<br/>in case we have questions

		<br/>
		<br/>

		<div class="alert bold">* Required fields</div>

	</td>
	<td valign="top">
		<?= $form->input('comments',array('label'=>'Comments/Questions? (optional)','style'=>'width: 100%;')); ?>
		<br/>
		<div class="clear"></div>
		<br/>

		<?= $this->Captcha->show(); ?>

		<br/>

		<div class="" align="center"><input type="image" src="/images/buttons/Send-grey.gif"/></div>
	</td>
	</tr></table>

<?php echo $form->end(); ?>
</div>
