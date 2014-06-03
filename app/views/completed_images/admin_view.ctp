<div class="completedImages view">
<h2><?php  __('Completed Image');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedImage['CompletedImage']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Company'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedImage['CompletedImage']['company']; ?>
			&nbsp;
		</dd>
		<? if(empty($completedImage['CompletedImage']['wholesale_customer'])) { ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Wholesale/Reseller'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?= !empty($completedImage['CompletedImage']['wholesale_customer']) ? "YES" : "no" ?>
			&nbsp;
		</dd>
		<? } ?>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedImage['CompletedImage']['full_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?= $this->Html->link(
				$completedImage['CompletedImage']['email'],
				"mailto:".$completedImage['CompletedImage']['email'],
				array()); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Session'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?= $this->Html->link($completedImage['CompletedImage']['session_id'],
				"/admin/tracking_requests/session/".$completedImage['CompletedImage']['session_id'],
				array()); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedImage['CompletedImage']['phone']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Zip Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedImage['CompletedImage']['zip_code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($completedImage['Product']['long_name'], array('controller' => 'products', 'action' => 'view', $completedImage['Product']['product_type_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedImage['CompletedImage']['quantity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Services Needed'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?= !empty($completedImage['CompletedImage']['free_consultation']) ? "Free consultation<br/>":"" ?>
			<?= !empty($completedImage['CompletedImage']['free_email_proof']) ? "Free email proof<br/>":"" ?>
			<?= !empty($completedImage['CompletedImage']['proof_without_order']) ? "Proof without order<br/>":"" ?>
			<?= !empty($completedImage['CompletedImage']['free_quote']) ? "Free quote<br/>":"" ?>
			<? $printing_back = $completedImage['CompletedImage']['printing_on_back']; ?>
			<? if($printing_back == 'same') { ?>
				Print on two sides &ndash; Same art both sides
			<? } else if($printing_back == 'different') { ?>
				Print on two sides &ndash; Different art on each side
			<? } else { ?>
				Print on one side
			<? } ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Needed By'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?= date("m/d/Y", strtotime($completedImage['CompletedImage']['needed_by'])); ?>
			<?= $completedImage['CompletedImage']['needed_by_strict'] ? "<b>Strict deadline</b>" : ""; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Comments'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedImage['CompletedImage']['comments']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Artwork'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<b>Side 1:</b><br/>
			<a href="/<?= $completedImage['CompletedImage']['path'] ?>/<?= $completedImage['CompletedImage']['filename'] ?>">
				<img src="/<?= $completedImage['CompletedImage']['path'] ?>/<?= $completedImage['CompletedImage']['filename'] ?>"/>
			</a>
			<br/>
			<a href="/<?= $completedImage['CompletedImage']['path'] ?>/<?= $completedImage['CompletedImage']['filename'] ?>">
				/<?= $completedImage['CompletedImage']['path'] ?>/<?= $completedImage['CompletedImage']['filename'] ?>
			</a>

			<? if(!empty($completedImage['CompletedImage']['file2_path'])) { ?>
			<br/>
			<b>Side 2:</b><br/>
			<a href="/<?= $completedImage['CompletedImage']['file2_path'] ?>/<?= $completedImage['CompletedImage']['file2_filename'] ?>">
				<img src="/<?= $completedImage['CompletedImage']['file2_path'] ?>/<?= $completedImage['CompletedImage']['file2_filename'] ?>"/>
			</a>
			<br/>
			<a href="/<?= $completedImage['CompletedImage']['file2_path'] ?>/<?= $completedImage['CompletedImage']['file2_filename'] ?>">
				/<?= $completedImage['CompletedImage']['file2_path'] ?>/<?= $completedImage['CompletedImage']['file2_filename'] ?>
			</a>
			<? } ?>
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Completed Image', true), array('action' => 'edit', $completedImage['CompletedImage']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Completed Image', true), array('action' => 'delete', $completedImage['CompletedImage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $completedImage['CompletedImage']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Completed Images', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Completed Image', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>
