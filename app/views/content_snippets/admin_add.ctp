<div class="contentSnippets form">
<?php echo $form->create('ContentSnippet');?>
	<fieldset>
 		<legend><?php __('Add ContentSnippet');?></legend>
	<?php
		echo $form->input('snippet_code');
		echo $form->input('snippet_title');
		echo $form->input('content');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List ContentSnippets', true), array('action'=>'index'));?></li>
	</ul>
</div>
