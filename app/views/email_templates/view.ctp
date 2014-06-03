<div class="emailTemplates view">
<h2><?php  __('EmailTemplate');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email Template Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailTemplate['EmailTemplate']['email_template_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailTemplate['EmailTemplate']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Message'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailTemplate['EmailTemplate']['message']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit EmailTemplate', true), array('action'=>'edit', $emailTemplate['EmailTemplate']['email_template_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete EmailTemplate', true), array('action'=>'delete', $emailTemplate['EmailTemplate']['email_template_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $emailTemplate['EmailTemplate']['email_template_id'])); ?> </li>
		<li><?php echo $html->link(__('List EmailTemplates', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New EmailTemplate', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Email Messages', true), array('controller'=> 'email_messages', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Message', true), array('controller'=> 'email_messages', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Email Messages');?></h3>
	<?php if (!empty($emailTemplate['EmailMessage'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Email Message Id'); ?></th>
		<th><?php __('Email Template Id'); ?></th>
		<th><?php __('Catalog Number'); ?></th>
		<th><?php __('Image Id'); ?></th>
		<th><?php __('Layout'); ?></th>
		<th><?php __('Custom Message'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($emailTemplate['EmailMessage'] as $emailMessage):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $emailMessage['email_message_id'];?></td>
			<td><?php echo $emailMessage['email_template_id'];?></td>
			<td><?php echo $emailMessage['catalog_number'];?></td>
			<td><?php echo $emailMessage['image_id'];?></td>
			<td><?php echo $emailMessage['layout'];?></td>
			<td><?php echo $emailMessage['custom_message'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'email_messages', 'action'=>'view', $emailMessage['email_message_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'email_messages', 'action'=>'edit', $emailMessage['email_message_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'email_messages', 'action'=>'delete', $emailMessage['email_message_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $emailMessage['email_message_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Email Message', true), array('controller'=> 'email_messages', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
