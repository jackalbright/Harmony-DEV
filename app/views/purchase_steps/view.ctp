<div class="purchaseSteps view">
<h2><?php  __('PurchaseStep');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Purchase Step Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchaseStep['PurchaseStep']['purchase_step_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchaseStep['PurchaseStep']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchaseStep['PurchaseStep']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Text'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchaseStep['PurchaseStep']['text']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit PurchaseStep', true), array('action'=>'edit', $purchaseStep['PurchaseStep']['purchase_step_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete PurchaseStep', true), array('action'=>'delete', $purchaseStep['PurchaseStep']['purchase_step_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $purchaseStep['PurchaseStep']['purchase_step_id'])); ?> </li>
		<li><?php echo $html->link(__('List PurchaseSteps', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New PurchaseStep', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
