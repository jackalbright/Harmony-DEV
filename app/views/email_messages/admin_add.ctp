<div class="emailMessages form">
<?php echo $form->create('EmailMessage');?>
	<fieldset>
 		<legend><?php __('Add EmailMessage');?></legend>
		<table width="100%">
		<tr>
			<td valign="top">
				<?= $form->hidden('EmailLetter.email_letter_id'); ?>
				<?= $form->input('email_template_id',array('empty'=>'[Select a template]','onChange'=>"")); ?>
				<?= $form->input('catalog_number'); ?>
				<?= $form->input('image_id'); ?>
				<div>
					Find image by <a href="/admin/custom_images/search" rel="shadowbox;height=500;width=600">customer</a>
				</div>
				<?= $form->input('template',array('label'=>'Layout','options'=>array('standard'=>'standard','imageonly'=>'imageonly','fullbleed'=>'fullbleed'))); ?>
			</td>
			<td valign="top">
				<?= $form->input('customQuote',array('class'=>'no_editor')); ?>
				<?= $form->input('personalizationInput'); ?>
			</td>
			<td valign="top">
				<?= $form->input('ribbon_id',array('default'=>16)); ?>
				<?= $form->input('tassel_id',array('default'=>41)); ?>
				<?= $form->input('charm_id',array('default'=>157)); ?>
				<?= $form->input('border_id',array('default'=>2)); ?>
			</td>
		</tr>
		</table>
	</fieldset>

	<script>
	function previewTemplate()
	{
		var template_id = $('EmailMessageEmailTemplateId').value;
		if(!template_id) { alert('Please select a template'); return false; }

		showPleaseWait();
		var form = $('EmailMessageAddForm').serialize();
		new Ajax.Updater("message_preview", "/admin/email_templates/message_edit/"+template_id, { method: 'post', parameters: form, evalScripts: true, asynchronous: true });
		new Ajax.Updater("template_preview", "/admin/email_templates/view/"+template_id, { method: 'post', parameters: form, evalScripts: true, asynchronous: true });
		$('preview').removeClassName('hidden');
	}
	</script>

	<h1><a href="Javascript:void(0);" onClick="previewTemplate();">Click to Preview</a></h1>

	<script>
		<? if(!empty($preview)) { ?>
		Event.observe(window,'load', function() { previewTemplate(); });
		<? } ?>
	</script>

<div id="preview" class='hidden'>

	<div>
		<table width="100%">
		<tr>
			<td valign="top">
				<label>Recipients</label>
				Type in an email, one per line.
				Or <a href="/admin/account/search_email" rel="shadowbox;width=900;height=500">find existing customers</a>
				<br/>
				<?= $form->textarea("recipients",array('class'=>'no_editor','style'=>'width: 250px; height: 150px;')); ?>
			</td>
			<td valign="top">
				<?= $form->input("create_account", array('label'=>'Create Account?','options'=>array(''=>'No account','retail'=>'Retail','wholesale'=>'Wholesale'))); ?>
				<br/>
				<?= $form->input("account_password", array('value'=>'password2')); ?>
				<br/>
				<?= $form->input("allow_billme", array('label'=>'Allow BillMe')); ?>
			</td>
			<td valign="top">
				<div id="message_preview"></div>
			</td>
			<td valign="top">
				<input type="submit" value="Send Email"/>
			</td>
		</tr>
		</table>
	</div>

	<h3>Preview:</h3>
	<div id="template_preview">
	</div>
	<?php echo $form->end('Send Email');?>
</div>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List EmailMessages', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Email Templates', true), array('controller'=> 'email_templates', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Template', true), array('controller'=> 'email_templates', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Email Message Recipients', true), array('controller'=> 'email_message_recipients', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Message Recipient', true), array('controller'=> 'email_message_recipients', 'action'=>'add')); ?> </li>
	</ul>
</div>
