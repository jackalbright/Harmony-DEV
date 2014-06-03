<?= $this->Form->hidden("layout", array('default'=>'standard')); ?>
<? if(empty($product_styles) || count($product_styles) <= 1) { ?>
	<?= $this->Form->hidden("Design.productCode", array('value'=>$productCode)); ?>
<? } ?>
<?= $this->Form->hidden("minimum", array('id'=>'minimum','value'=>$this->Session->read("Design.Product.minimum"))); ?>


<div id="accordion" class='accordion'>
	<? if(!empty($product_styles) && count($product_styles) > 1) { ?>
	<?= $this->element("../designs/form/style"); ?>
	<? } ?>
	<?= $this->element("../designs/form/sides"); ?>

	<?= $this->element("../designs/form/image"); # Not a part.?>

	<? foreach($steps as $side=>$side_steps) { # enabled parts for specified product/variant 
		foreach($side_steps as $step)
		{
			$stepid = $step['Part']['part_code'];
	?>
		<? if(file_exists(APP."/views/designs/form/$stepid.ctp")) { ?>
			<?= $this->element("../designs/form/$stepid",array('side'=>$side+1)); ?>
		<? } ?>
		<? # need to separate text/pers since different in db. ?>

	<? 
		}
	} 
	?>

	<?#= $this->element("../designs/form/image"); ?>
	<?#= $this->element("../designs/form/text"); ?>
	<?#= $this->element("../designs/form/border"); ?>
	<?#= $this->element("../designs/form/background"); ?>
	<?#= $this->element("../designs/form/tassel"); ?>
</div>

<script>
j('.accordion').accordion({
	heightStyle: 'content',
	collapsible: true,
	activate: function(event,ui) {
		if(j(this).hasClass('side1'))
		{
			j('#preview1').show();
			j('#preview2').hide();
		} else if (j(this).hasClass('side2')) { 
			j('#preview1').hide();
			j('#preview2').show();
		}
		// XXX TODO switch sides.

	}
});
j('.accordion').bind('next', function() {
	// need to mark as completed.
	j(this).find('.ui-accordion-content-active, .ui-accordion-header-active').addClass('completed');

	j(this).accordion('option','active', j(this).accordion('option','active') + 1);
});

// General updating of form to preview.
j(document).on('keyup change show', 'form :input', function() {
	j(this).trigger('preview');
});
j(document).on('change', 'form :input', function() { // apply to fields added later.
	j(this).trigger('preview');
});

j(document).ready(function() {
	j('form input, form textarea, form select').trigger('preview');

	j('.canvas_overlay').draggable_overlay(); // This proxies movement to 'dynamic' items
});
</script>

