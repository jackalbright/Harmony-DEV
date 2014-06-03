<div class="productQuotes form">
<?php echo $form->create('ProductQuote');?>
	<fieldset>
 		<legend><?php __('Edit ProductQuote');?></legend>
	<?php
		echo $form->input('product_quote_id');
		echo $form->input('product_type_id');
		echo $form->input('quote_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('ProductQuote.product_quote_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('ProductQuote.product_quote_id'))); ?></li>
		<li><?php echo $html->link(__('List ProductQuotes', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Products', true), array('controller'=> 'products', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product', true), array('controller'=> 'products', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Quotes', true), array('controller'=> 'quotes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Quote', true), array('controller'=> 'quotes', 'action'=>'add')); ?> </li>
	</ul>
</div>
