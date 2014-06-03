<div class="cart_items index">
<h2><?php __('CartItems');?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('prod');?></th>
</tr>
<?php
$i = 0;
foreach ($cart_items as $cart_item):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($cart_item['CartItem']['name'], "/cart_items/view/".$cart_item['CartItem']['prod']."?new=1"); ?>
			<?php echo "(".$html->link(__('Edit', true), array('action'=>'edit', $cart_item['CartItem']['cart_item_type_id'])) . ")"; ?>
		</td>
		<td>
			<?php echo $cart_item['CartItem']['prod']; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="">
	<? $paginator->options(array('url' => $this->passedArgs)); ?>
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
	</ul>
</div>
