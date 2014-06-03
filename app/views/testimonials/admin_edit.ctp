<div class="testimonials form">
<?php echo $form->create('Testimonial');?>
	<fieldset>
 		<legend><?php __('Edit Testimonial');?></legend>
	<?php
		echo $form->input('testimonial_id');
		echo $form->input('text');
		echo $form->input('attribution',array('style'=>'width: 400px;'));
		echo $form->input('approved',array('after'=>' (visible to public)','options'=>array(0=>'No',1=>'Yes'),'type'=>'select'));
	?>
	<br/>
	<br/>
	<table width="100%">
	<tr>
		<td valign="top" width="33%">
			<?= $form->input('CustomerType.CustomerType',array('label'=>__('Customer Type',true), 'type'=>'select','options'=>$customer_types,'empty'=>'')); ?>
		</td>
		<td valign="top" width="33%">
			<?= $form->input('Products.Products',array('label'=>__('Products',true), 'type'=>'select', 'multiple'=>'checkbox','options'=>$products)); ?>
		</td>
		<td valign="top" width="33%">
			<?= $form->input('SpecialtyPages.SpecialtyPages',array('label'=>__('Specialty Pages',true), 'type'=>'select', 'multiple'=>'checkbox','options'=>$specialtyPages)); ?>
		</td>
	</tr>
	</table>
	</fieldset>

<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Testimonial.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Testimonial.id'))); ?></li>
		<li><?php echo $html->link(__('List Testimonials', true), array('action'=>'index'));?></li>
	</ul>
</div>

