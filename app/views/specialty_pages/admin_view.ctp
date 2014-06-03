<div class="specialtyPage view">
<h2><?php  __('SpecialtyPage');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Specialty Page Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPage['SpecialtyPage']['specialty_page_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Page Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPage['SpecialtyPage']['page_title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Body Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPage['SpecialtyPage']['body_title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Meta Keywords'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPage['SpecialtyPage']['meta_keywords']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Meta Desc'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPage['SpecialtyPage']['meta_desc']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit SpecialtyPage', true), array('action'=>'edit', $specialtyPage['SpecialtyPage']['specialty_page_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete SpecialtyPage', true), array('action'=>'delete', $specialtyPage['SpecialtyPage']['specialty_page_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $specialtyPage['SpecialtyPage']['specialty_page_id'])); ?> </li>
		<li><?php echo $html->link(__('List SpecialtyPage', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New SpecialtyPage', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
