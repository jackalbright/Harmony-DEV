<div class="cartItems index">
<h2><?php __('CartItems');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('cart_item_id');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('customer_id');?></th>
	<th><?php echo $paginator->sort('quantity');?></th>
	<th><?php echo $paginator->sort('session_id');?></th>
	<th><?php echo $paginator->sort('productCode');?></th>
	<th><?php echo $paginator->sort('unitPrice');?></th>
	<th style='max-width: 500px;'><?php echo $paginator->sort('parts');?></th>
	<th><?php echo $paginator->sort('comments');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($cartItems as $cartItem):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $cartItem['CartItem']['cart_item_id']; ?>
		</td>
		<td>
			<?php echo $cartItem['CartItem']['created']; ?>
		</td>
		<td>
			<?php echo $cartItem['CartItem']['customer_id']; ?>
		</td>
		<td>
			<?php echo $cartItem['CartItem']['quantity']; ?>
		</td>
		<td>
			<a href="/admin/tracking_requests/session/<?= $cartItem['CartItem']['session_id'] ?>">
			<?php echo $cartItem['CartItem']['session_id']; ?>
			</a>
		</td>
		<td>
			<?php echo $cartItem['CartItem']['productCode']; ?>
		</td>
		<td>
			<?php echo $cartItem['CartItem']['unitPrice']; ?>
		</td>
		<td>
			<? $parts = unserialize($cartItem['CartItem']['parts']); 
				$prod = $cartItem['CartItem']['productCode'];
				$imgtype = "";
				if (!empty($parts['customImageID'])) { $imgtype = 'Custom'; $imgid = $parts['customImageID']; }
				if (!empty($parts['catalogNumber'])) { $imgtype = 'Gallery'; $imgid = $parts['catalogNumber']; }
				if($prod && $imgtype && $imgid)
				{
			?>
			<div class="right">
				<a rel="" href="/product_image/cart_view?cart_item_id=<?= $cartItem['CartItem']['cart_item_id'] ?>">
					<img src="/product_image/cart_view/x150.png?cart_item_id=<?= $cartItem['CartItem']['cart_item_id'] ?>"/>
				</a>
			</div>
			<?
				}
			foreach($parts as $part => $value)
			{
				?><?= $part ?>: <?= $value ?><br/>
				<?
			}
			?>
		</td>
		<td>
			<?php echo $cartItem['CartItem']['comments']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $cartItem['CartItem']['cart_item_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $cartItem['CartItem']['cart_item_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $cartItem['CartItem']['cart_item_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cartItem['CartItem']['cart_item_id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New CartItem', true), array('action'=>'add')); ?></li>
	</ul>
</div>
