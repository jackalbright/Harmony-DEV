<div>
	<?php echo $form->create('CustomerRating');?>
	<p>
		We appreciate your feedback....
	</p>

	<?= $form->input('name'); ?>
	<?= $form->input('organization'); ?>
	<?= $form->input('email',array('after'=>'(optional)')); ?>

	<br/>
	<br/>
	<label>How would you rate our products/service?</label>
	<div>
		<div id="star"></div>
		<script>
			function setRating(element, memo)
			{
				//alert(memo);
				var msg = "";
				alert(memo.rating);
				for (var i in memo)
				{
					msg += (i+": "+memo[i]+"\n");
				}
				alert(msg);
			}
			new Starbox("star", 5, { onRate: setRating, lockOnRate: false });
		</script>
	</div>

	<br/>

	<? echo $form->input('permission',array('label'=>"May we use your feedback publically on our website?")); ?>

	<?= $form->end(); ?>
</div>

<hr/>

<div class="customerRatings form">
<?php echo $form->create('CustomerRating');?>
	<fieldset>
 		<legend><?php __('Add CustomerRating');?></legend>
	<?php
		echo $form->input('customer_rating_id');
		echo $form->input('name');
		echo $form->input('organization');
		echo $form->input('email');
		echo $form->input('product_rating');
		echo $form->input('service_rating');
		echo $form->input('customer_type_id');
		echo $form->input('permission');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List CustomerRatings', true), array('action'=>'index'));?></li>
	</ul>
</div>
