<? $id = !empty($this->data['Coupon']['id']) ? $this->data['Coupon']['id'] : null; ?>
<div class="coupons form">
<?php echo $this->Form->create('Coupon',array('type'=>'file'));?>
	<fieldset>
		<legend><?= $id ? "Edit Coupon" : "Add Coupon" ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('code', array('label'=>'Coupon Code'));
		echo $this->Form->input('title', array('label'=>'Link Title'));
		echo $this->Form->input('file', array('type'=>'file','label'=>'Graphic File (optional) - 35px height recommended'));
	?>
		<? if(!empty($this->data['Coupon']['filename'])) { ?>
		<img src="/<?= $this->data['Coupon']['path'] ?>/<?= $this->data['Coupon']['filename'] ?>"/>
		<? } ?>

	<div style="width: 300px;">
		<?= $this->Form->input('description', array('label'=>'Description','class'=>'XXno_editor')); ?>
	</div>

	<?
		echo $this->Form->input('percent',array('label'=>'Percent Off Order'));
		echo $this->Form->input('amount',array('label'=>'OR Dollar Amount Off Order'));
		echo $this->Form->input('free_shipping',array('label'=>'OR Free Standard Shipping'));

		echo $this->Form->input('minimum',array('label'=>'Minimum Order Amount to Qualify'));
		echo $this->Form->input('start',array('type'=>'text','label'=>'Start Date'));
		echo $this->Form->input('end',array('type'=>'text','label'=>'End Date'));
		echo $this->Form->input('day_of_week',array('options'=>$days_of_week,'empty'=>'Any'));

		echo $this->Form->input('wholesale_only',array('label'=>'Wholesale Customers Only'));

		echo $this->Form->input('multiple_use');
		echo $this->Form->input('active',array('options'=>array(0=>'No',1=>'Yes'),'default'=>1));

		echo $this->Form->input('advertise',array('label'=>'Advertise on homepage/landing page'));
	?>
	<script>
   	j('#CouponStart').datepicker({
                showOn: "both",
                buttonImage: "/images/cal.gif",
                buttonImageOnly: true,
                dateFormat: "mm/dd/yy"
        });
   	j('#CouponEnd').datepicker({
                showOn: "both",
                buttonImage: "/images/cal.gif",
                buttonImageOnly: true,
                dateFormat: "mm/dd/yy"
        });
	</script>
	</fieldset>
<?php echo $this->Form->end(__('Save', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Coupon.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Coupon.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Coupons', true), array('action' => 'index'));?></li>
	</ul>
</div>
