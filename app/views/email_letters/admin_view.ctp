<div class="emailLetters view">
<h2><?php  __('EmailLetter');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email Letter Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailLetter['EmailLetter']['email_letter_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Letter Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailLetter['EmailLetter']['letter_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email Template'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($emailLetter['EmailTemplate']['name'], array('controller'=> 'email_templates', 'action'=>'view', $emailLetter['EmailTemplate']['email_template_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Subject'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailLetter['EmailLetter']['subject']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Catalog Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailLetter['EmailLetter']['catalog_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Image Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailLetter['EmailLetter']['image_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('CustomQuote'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailLetter['EmailLetter']['customQuote']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('PersonalizationInput'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailLetter['EmailLetter']['personalizationInput']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Border Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailLetter['EmailLetter']['border_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Charm Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailLetter['EmailLetter']['charm_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tassel Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailLetter['EmailLetter']['tassel_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ribbon Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailLetter['EmailLetter']['ribbon_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Layout'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailLetter['EmailLetter']['layout']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Custom Message'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailLetter['EmailLetter']['custom_message']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit EmailLetter', true), array('action'=>'edit', $emailLetter['EmailLetter']['email_letter_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete EmailLetter', true), array('action'=>'delete', $emailLetter['EmailLetter']['email_letter_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $emailLetter['EmailLetter']['email_letter_id'])); ?> </li>
		<li><?php echo $html->link(__('List EmailLetters', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New EmailLetter', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Email Templates', true), array('controller'=> 'email_templates', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Template', true), array('controller'=> 'email_templates', 'action'=>'add')); ?> </li>
	</ul>
</div>
