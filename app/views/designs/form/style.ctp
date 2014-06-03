<?
$styles = Set::combine($product_styles, "{n}.Product.code", "{n}.Product.pricing_name");
?>
<h3><?= $i ?>. Select a Style</h3>
<div id="step_style">
	<? foreach($product_styles as $style) { ?>
	<div id="style_<?= $style['Product']['code'] ?>" class="style <?= $style['Product']['code'] == $productCode ? "selected": "" ?>">
		<?= $this->Form->input("Design.productCode", array('type'=>'radio','class'=>'DesignProductCode','options'=>array($style['Product']['code']=>$style['Product']['name']),'style'=>'font-size: 16px;','default'=>$productCode)); ?>
		<p style='margin: 5px 0px 0px 25px; font-size: 12px;'>
			<?= $style['Product']['pricing_description']; ?>

			<?#= $this->element("../designs/price_chart", array('pricing'=>$pricings[$style['Product']['code']])); ?>
		</p>
	</div>
	<? } ?>

<script>
j('.DesignProductCode').bind('change', function() {
	var files = [];
	<? foreach($product_styles as $style) { ?>
	<? if(file_exists(APP."/webroot/images/designs/products/".$style['Product']['code'].".svg")) { ?>
	files['<?= $style['Product']['code'] ?>'] = '/images/designs/products/<?= $style['Product']['code'] ?>.png';
	<? } else if(!empty($parent)) { ?>
	files['<?= $style['Product']['code'] ?>'] = '/images/designs/products/<?= $parent['Product']['code'] ?>.png';
	<? } ?>
	<? } ?>

	var file = files[j(this).val()];
	j('#DesignForm').changeProduct(j(this).val(), file); // only changes preview if file differs.
	j('#step_style .style').removeClass('selected');
	j('#step_style #style_'+j(this).val()).addClass('selected');
});
</script>

<?= $this->element("../designs/next"); ?>

</div>
