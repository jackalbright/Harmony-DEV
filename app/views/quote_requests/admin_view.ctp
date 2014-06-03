<div class="quoteRequests view">
<h2><?php  __('QuoteRequest');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $quoteRequest['QuoteRequest']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($quoteRequest['Product']['name'], array('controller' => 'products', 'action' => 'view', $quoteRequest['Product']['product_type_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $quoteRequest['QuoteRequest']['quantity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Options'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?
				$options = split(",", $quoteRequest['QuoteRequest']['options']);
				foreach($options as $opt) { if(!empty($opt)) { echo "$opt<br/>"; } }
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Comments'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $quoteRequest['QuoteRequest']['comments']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('First Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $quoteRequest['QuoteRequest']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Last Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $quoteRequest['QuoteRequest']['last_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Organization'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $quoteRequest['QuoteRequest']['organization']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?= $this->Html->link($quoteRequest['QuoteRequest']['email'],
				"mailto:".$quoteRequest['QuoteRequest']['email']."?Re: Your Custom Quote"); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $quoteRequest['QuoteRequest']['phone']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $quoteRequest['QuoteRequest']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $quoteRequest['QuoteRequest']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit QuoteRequest', true), array('action' => 'edit', $quoteRequest['QuoteRequest']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete QuoteRequest', true), array('action' => 'delete', $quoteRequest['QuoteRequest']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $quoteRequest['QuoteRequest']['id'])); ?> </li>
		<li><?php echo $html->link(__('List QuoteRequests', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New QuoteRequest', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
