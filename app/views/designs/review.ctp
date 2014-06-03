<script src="/js/designer.js"></script>
<? $sides = $design['Design']['sides']; ?>
<? $this->set("body_title", "Review My Design &amp; Add to Cart"); ?>
<?= $this->Form->create("Design", array('url'=>array('action'=>'cart'),'id'=>'DesignForm')); ?>
<?= $this->Form->hidden("review", array('value'=>1)); ?>
<?= $this->Form->hidden("minimum", array('id'=>'minimum','value'=>$product['Product']['minimum'])); ?>

	<? foreach($design['Design'] as $k=>$v) { 
		if(in_array($k, array('quantity','proof','comments'))) { continue; } # Don't repeat since already there in visible form.
	?>
		<?= $this->Form->hidden("Design.$k", array('value'=>$v)); ?>
	<? } ?>
	<? foreach($design['DesignSide'] as $i=>$ds) { ?>
		<? foreach($ds as $k=>$v) { ?>
			<?= $this->Form->hidden("DesignSide.$i.$k", array('value'=>$v)); ?>
		<? } ?>
	<? } ?>
<div class='form'>

	<pre><? #print_r($design['Design']); ?></pre>
	<table width="100%">
	<tr>
	<td valign="top" width="700">
		<div id="Side1" class='relative left' valign="top" style="width: 45%;">
			<? if($sides > 1) { ?>
			<h3 class='bold left '>Side 1</h3>
			<? } ?>
			<div class='left' style='margin-left: 25px;'>
				<?= $this->Html->link("Make Changes", "/design/#side1", array('onClick'=>'j.loading();','title'=>($sides > 1 ? 'Make changes to side 1 details' : 'Make changes to details'))); ?>
			</div>
			<div class='clear'></div>
			<?= $this->Html->image("/designs/png/1"); ?>
		</div>
	<? if($sides > 1) { ?>
		<div id="Side2" valign="top" class='left relative' style="width: 45%;">
			<h3 class='bold left'>Side 2
			</h3>
			<div class='left' style='margin-left: 25px;'>
				<?= $this->Html->link("Make Changes", "/design/#side2", array('onClick'=>'j.loading();','title'=>'Make changes to side 2 details')); ?>
			</div>
			<div class='clear'></div>
			<?= $this->Html->image("/designs/png/2"); ?>
		</div>
	<? } ?>
	</td>
	<td valign="top" style="padding-right: 25px;">
	<div style="width: 300px;">
		<div class='widget'>
			<h3>Proof Options</h3>
		<div>
			<?= $this->element("../designs/proof"); ?>
		</div>
		</div>

		<div class='widget'>
		<h3>Special Instructions About Your Order</h3>
		<div>

			<?= $this->Form->input("comments", array('label'=>false,'after'=>'<br/>(optional)',
			'type'=>'textarea','rows'=>4,'style'=>'width: 98%;')); ?>
		</div>
		</div>

		<div class='widget'>
		<h3>Pricing</h3>
		<div id="DesignPricing">
			<?= $this->element("../designs/pricing",array('cart'=>1)); ?>
		</div>
		</div>
		<div class='clear'></div>
	</div>
	</td>
	</tr>
	</table>
</div>
<?= $this->Form->end(); ?>
<style>
#Side1 img, #Side2 img
{
	max-width: 250px;
}
</style>
<?= $this->Html->css("design"); ?>
