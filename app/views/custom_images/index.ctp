<?
if(!empty($product['Product'])) { $product = $product['Product']; }
?>
<? $this->element("steps/steps",array('step'=>'image')); ?>
<div class="customImage form">

	<?
	$template = $config['default_custom_image_layout'];
	if(!empty($_REQUEST['template']))
	{
		$template = $_REQUEST['template'];
	}
	if(empty($template)) { $template = 'standard'; }
	?>

	<?= $this->element("products/get_started",array()); ?>

	<br/>

	<?php echo $form->end(); ?>
</div>
<script>
j('form').submit(function() {
	j('#flashMessage').remove();

});
</script>
