<div class="completedArtImages form inline_label_form" style="width: 475px;">
<?php echo $form->create('CompletedArtImage',array('type'=>'file','url'=>array('action'=>'add',$product['Product']['code']))); ?>
	<h4 class="bold">Submit your completed art <?= !empty($product) ? "for ". $hd->pluralize(strtolower($product['Product']['short_name'])) : "" ?> </h4>

	<!--<p><a href="/template_requests/add">Request a template</a> first to get image constraints for your completed art.</p>-->
	<?php
		if(empty($product)) { echo $form->input('product_type_id',array('label'=>'Select a product','options'=>$product_types)); }
		$values = array_values($related_products);
		$default_code = !empty($product) ? $product['Product']['product_type_id'] : $values[0];

		if(!empty($related_products) && count($related_products) > 1) { echo $form->input("product_id",array('label'=>'Select a style','options'=>$related_products,'value'=>$default_code)); }
		else { echo $form->hidden("product_id"); }

		?>
		<br/>

		<?= $form->input('name',array('class'=>'required')); ?>
		<?= $form->input('organization',array('label'=>'Organization (optional)')); ?>

		<br/>
		<p>Please provide contact information so we can discuss your project with you.</p>
		<?= $form->input('email',array('class'=>'required')); ?>
		<?= $form->input('phone',array('class'=>'required')); ?>


		<br/>
		<?= $form->input('quantity',array('label'=>'Approx. quantity (optional)')); ?>
		<div class="clear"></div>
		<?= $form->input('comments',array('label'=>'Project details (optional)','type'=>'textarea')); ?>
		<?= $form->input('price_quote',array('label'=>'I would like a written price quote','type'=>'checkbox')); ?>

		<br/>


		<div id="upload" class="<?= !empty($this->data['CompletedArtImage']['thumb_path']) ? "hidden" : "" ?>">
			<?= $form->input('file',array('type'=>'file','label'=>'File','class'=>(empty($this->data['CompletedArtImage']['thumb_path'])?'required':''))); ?>
			<div style="margin-left: 150px;">Supported formats: JPG, PNG, GIF, TIF, PDF</div>
			<div class="clear"></div>
			<div class="left" style="margin-left: 150px;">
				<?= $form->submit("/images/buttons/Preview-grey.gif",array('name'=>'data[preview]','value'=>'preview','div'=>false)); ?>
			</div>
		</div>

		<div class="right">
		<?= $form->submit("/images/buttons/Send.gif",array('name'=>'data[send]','value'=>'send','div'=>false,'onClick'=>"return verifyRequiredFields('CompletedArtImageAddForm');"));?>
		</div>
		
		<? if(!empty($this->data['CompletedArtImage']['thumb_path'])) { ?>
		<div id="preview" align="" style="">
		<label>Preview</label>
			<div align="center">
				<br/>
				<a href="Javascript:void(0)" onClick="$('upload').removeClassName('hidden'); $('preview').addClassName('hidden'); ">Upload a different file</a>
			<br/>
			<img src="<?= $this->data['CompletedArtImage']['thumb_path'] ?>"/>
			</div>

			<?= $form->input('original_path',array('type'=>'hidden')); ?>
			<?= $form->input('display_path',array('type'=>'hidden')); ?>
			<?= $form->input('thumb_path',array('type'=>'hidden')); ?>
		</div>
		<? } ?>


		<div class="clear"></div>
		<br/>
		<br/>
		<div style="margin-left: 150px;" align="">
				We will be in touch with you within 24 hours.
		</div>

<?php echo $form->end();?>
</div>
