<div class="contentSnippets form">
<?php echo $form->create('ContentSnippet');?>
	<fieldset>
 		<legend><?php __('Edit ContentSnippet');?></legend>
	<?php
		echo $form->input('content_snippet_id');
		echo $form->input('snippet_code');
		echo $form->input('snippet_title');
		echo $form->input('content');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('ContentSnippet.content_snippet_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('ContentSnippet.content_snippet_id'))); ?></li>
		<li><?php echo $html->link(__('List ContentSnippets', true), array('action'=>'index'));?></li>
	</ul>
</div>
