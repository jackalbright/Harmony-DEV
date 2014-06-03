<div class="quotes form">
<?php echo $form->create('Quote');?>
	<fieldset>
 		<legend><?php __('Edit Quote');?></legend>
	<?php
		echo $form->input('quote_id');
		echo $form->input('text');
		echo $form->input('title');
		echo $form->input('attribution');
		echo $form->input('text_length');
		echo $form->input('attrib_length');
		echo $form->input('use_quote_marks');
		echo $form->input('subjects');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Quote.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Quote.id'))); ?></li>
		<li><?php echo $html->link(__('List Quotes', true), array('action'=>'index'));?></li>
	</ul>
</div>
