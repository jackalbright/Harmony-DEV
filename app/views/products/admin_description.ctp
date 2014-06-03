<?
if(!isset($i)) { $i = count($this->data['ProductDescription']); }
if(empty($pid)) {
	$pid = !empty($this->data['Product']['product_type_id']) ? $this->data['Product']['product_type_id'] : null;
}
$desc = !empty($this->data['ProductDescription'][$i]) ? $this->data['ProductDescription'][$i] : null;
$id = !empty($desc['id']) ? $desc['id'] : rand(5000,10000);
?>
<div id="ProductDescription<?= $id ?>" style="width: 380px; padding: 10px; height: 330px; float: left;" class="productDescription">
	<div class="right">
		<a href="javascript:void(0)" class="delete"><img class="" height="32" src="/images/icons/delete.png"/></a>
	</div>
	<div class="right handle">
		<img class="" height="32" src="/images/icons/arrows_both.png"/>
	</div>

	<?= $this->Form->hidden("ProductDescription.$i.id"); ?>
	<?= $this->Form->hidden("ProductDescription.$i.ix", array('id'=>"ProductDescription{$id}Ix")); ?>
	<?= $this->Form->hidden("ProductDescription.$i.product_type_id", array('value'=>$pid)); ?>
	<?= $this->Form->input("ProductDescription.$i.title"); ?>
	<?#= $this->Form->input("ProductDescription.$i.with_overview"); ?>
	<?#= $this->Form->input("ProductDescription.$i.disabled"); ?>
	<?= $this->Form->input("ProductDescription.$i.content", array('id'=>"ProductDescription{$id}Content",'class'=>'tinyMCE')); ?>
	<script>
	<? if(!empty($this->params['isAjax'])) { ?>
	j(document).ready(function() {
		j('#ProductDescription<?=$id?>Content').rte();
	});
	<? } ?>
	</script>
</div>
