<div class="completedArtImages view">
<h2><?php  __('CompletedArtImage');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedArtImage['CompletedArtImage']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedArtImage['Product']['pricing_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedArtImage['CompletedArtImage']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<a href="mailto:<?php echo $completedArtImage['CompletedArtImage']['email']; ?>">
			<?php echo $completedArtImage['CompletedArtImage']['email']; ?>
			</a>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedArtImage['CompletedArtImage']['phone']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Organization'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedArtImage['CompletedArtImage']['organization']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Comments'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedArtImage['CompletedArtImage']['comments']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Approx Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedArtImage['CompletedArtImage']['quantity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Price Quote?'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?= !empty($completedArtImage['CompletedArtImage']['price_quote']) ? "Yes" : "No"; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Image'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>

			<a href="<?php echo $completedArtImage['CompletedArtImage']['original_path']; ?>">
			<img src="<?php echo $completedArtImage['CompletedArtImage']['display_path']; ?>"/>
			</a>
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $completedArtImage['CompletedArtImage']['created']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit CompletedArtImage', true), array('action' => 'edit', $completedArtImage['CompletedArtImage']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete CompletedArtImage', true), array('action' => 'delete', $completedArtImage['CompletedArtImage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $completedArtImage['CompletedArtImage']['id'])); ?> </li>
		<li><?php echo $html->link(__('List CompletedArtImages', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New CompletedArtImage', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
