<div class="PageEmail fullwidth form">

<? if(!empty($sent)) { ?>
<div align="center">
	<a href="Javascript:void(0)" onClick="return parent.Shadowbox.close();"><img src="/images/buttons/Continue-Shopping-grey.gif"/></a><br/>
	or send another email:
</div>
<? } ?>

<?= $form->create("PageEmail", array('url'=>array('action'=>'add',$prod), 'onSubmit'=>"return verifyRequiredFields(this);")); ?>
	<?= $form->input('your_name',array('class'=>'required','label'=>'Your name:')); ?>
	<?= $form->input('recipient',array('class'=>'required','label'=>'Send to email:')); ?>
	<?= $form->input('subject',array('label'=>'Subject:','value'=>Inflector::pluralize($product['Product']['short_name']).' by Harmony Designs')); ?>
	<div>
		<label>URL:</label>
		<? $url = Router::url("/details/{$product['Product']['prod']}.php",true); ?>
		<?= $url ?>
		<?= $form->input('url',array('type'=>'hidden','value'=>$url)); ?>
	</div>
	<?= $form->input('custom_message',array('type'=>'textarea','label'=>'Your message to email recipient (optional)')); ?>
	<div align="center">
	<?= $form->submit('/images/buttons/Send-Email-grey.gif'); ?>
	</div>
<?= $form->end(); ?>
</div>
