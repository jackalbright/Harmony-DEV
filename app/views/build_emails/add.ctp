<div class="BuildEmail fullwidth form">

<? if(!empty($sent)) { ?>
<div align="center">
	<a href="Javascript:void(0)" onClick="return parent.Shadowbox.close();"><img src="/images/buttons/Continue-Shopping-grey.gif"/></a><br/>
	or send another email:
</div>
<? } ?>

<?= $form->create("BuildEmail", array('url'=>array('action'=>'add'), 'onSubmit'=>"return verifyRequiredFields(this);")); ?>
	<?= $form->input('your_name',array('class'=>'required','label'=>'Your name:')); ?>
	<?= $form->input('recipient',array('class'=>'required','label'=>'Send to email:')); ?>
	<?= $form->input('subject',array('label'=>'Subject:','value'=>Inflector::singularize($build['Product']['name']).' design for your review')); ?>
	<?= $form->input('custom_message',array('type'=>'textarea','label'=>'Your message to email recipient (optional)')); ?>
	<div align="center">
	<?= $form->submit('/images/buttons/Send-Email-grey.gif'); ?>
	</div>
	<div>
		<label>Preview:</label>
		<?= $this->element("build/preview",array('no_view_larger'=>1,'live'=>1)); ?>
	</div>
<?= $form->end(); ?>
</div>
