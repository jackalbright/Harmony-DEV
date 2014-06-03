<div class="specialtyPageProspects view">
<h2><?php  __('SpecialtyPageProspect');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Specialty Page Prospects Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['name']; ?>
			&nbsp;
		</dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>>Date Created</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Organization'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['organization']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['phone']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Address1'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['address1']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Address2'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['address2']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('City'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['city']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('State'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['state']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Zipcode'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['zipcode']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sample1'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['sample1']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sample2'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['sample2']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sample3'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['sample3']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Project Details'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['project_details']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Want Quote'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['want_quote']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Want Catalog'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['want_catalog']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Want Consultation'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['want_consultation']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Want Sample'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['want_sample']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Specialty Page'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($specialtyPageProspect['SpecialtyPage']['specialty_page_id'], array('controller'=> 'specialty_pages', 'action'=>'view', $specialtyPageProspect['SpecialtyPage']['specialty_page_id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit SpecialtyPageProspect', true), array('action'=>'edit', $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete SpecialtyPageProspect', true), array('action'=>'delete', $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id'])); ?> </li>
		<li><?php echo $html->link(__('List SpecialtyPageProspects', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New SpecialtyPageProspect', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Specialty Pages', true), array('controller'=> 'specialty_pages', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Specialty Page', true), array('controller'=> 'specialty_pages', 'action'=>'add')); ?> </li>
	</ul>
</div>
