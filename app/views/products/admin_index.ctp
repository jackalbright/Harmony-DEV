<div class="products index">
<h2><?php __('Products');?></h2>

<?php echo $html->link(__('New Product / Landing Page', true), array('action'=>'add')); ?>
<br/>
<br/>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('prod');?></th>
</tr>
<?php
$i = 0;
foreach ($products as $product):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($product['Product']['name'], "/products/view/".$product['Product']['prod']); ?>
			<?php echo "(".$html->link(__('Edit', true), array('action'=>'edit', $product['Product']['product_type_id'])) . ")"; ?>
		</td>
		<td>
			<?php echo $product['Product']['prod']; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="">
	<?= "PA=".print_r($this->passedArgs,true); ?>
	<? $paginator->options(array('url' => $this->passedArgs)); ?>
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<!-- <li><?php echo $html->link(__('New Product Testimonial', true), array('controller'=> 'product_testimonials', 'action'=>'add')); ?> </li> -->
	</ul>
</div>
