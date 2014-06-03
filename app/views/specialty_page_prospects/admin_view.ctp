<div class="specialtyPageProspects view">
<h2><?php  __('Specialty Inquiry');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
    	dt<?php if ($i % 2 == 0) echo $class;?>>ID</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['specialty_page_prospects_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Organization'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['organization']; ?>
			&nbsp;
		</dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>>Date Created</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo date("F d,Y  - h:i a",strtotime($specialtyPageProspect['SpecialtyPageProspect']['created'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<a href="mailto:<?php echo $specialtyPageProspect['SpecialtyPageProspect']['email']; ?>">
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['email']; ?>
			</a>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['phone']; ?>
			<? if(!empty($specialtyPageProspect['SpecialtyPageProspect']['phone_extension'])) { ?>
				x <?php echo $specialtyPageProspect['SpecialtyPageProspect']['phone_extension']; ?>
			<? } ?>
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

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Resale Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['resale_number']; ?> &nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Wholesale Account'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?= !empty($specialtyPageProspect['SpecialtyPageProspect']['want_account']) ? "Yes" : "No"; ?> &nbsp;
		</dd>


		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Want Sample'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['want_sample']?"Yes":"No"; ?> &nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sample1'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['Sample1']['pricing_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sample2'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['Sample2']['pricing_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sample3'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['Sample3']['pricing_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Want Quote'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['want_quote']?"Yes":"No"; ?> &nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['Product']['pricing_name']; ?> &nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['quantity']; ?> &nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Project Details'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['project_details']; ?> &nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Want Catalog'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?= $specialtyPageProspect['SpecialtyPageProspect']['want_catalog']?"Yes":"No"; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Want Consultation'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['want_consultation']?"Yes":"No"; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Purchase Order'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<? if(!empty($specialtyPageProspect['PurchaseOrder']['filename'])) { ?>
				<?= $this->Html->link("/".$specialtyPageProspect['PurchaseOrder']['path']."/".$specialtyPageProspect['PurchaseOrder']['filename']); ?>
			<? } ?>
			&nbsp;
		</dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>>Comments</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $specialtyPageProspect['SpecialtyPageProspect']['comment']; ?>
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
