<? $cart_item_id = $this->Session->read("Design.Design.cart_item_id"); ?>
<? $this->set("body_title", "Select options to personalize your ".strtolower(Inflector::pluralize($product['short_name']))); ?>
<?php // echo $this->Html->css("design"); ?>

<? $sides = $this->Session->read("Design.Design.sides"); if(empty($sides)) { $sides = 1; } ?>
<script language="javascript" type="text/javascript">
//alert("prod: <?php //echo $prod?>" );
</script>
<script src="/js/designer.js"></script>

<? /* if(!empty($fontFamilies)) { ?>
	<? foreach($fontFamilies as $fontFamily=>$variants) { ?>
	<link rel="stylesheet" type="text/css" href="/fonts/<?= $fontFamily?>/stylesheet.css"/>
	<? } ?>
<? } */ 
?>

<div class='form'>
<?= $this->Form->create("Design",array('url'=>array('action'=>'cart'),'id'=>'DesignForm','type'=>'file')); ?>
<?= $this->Form->hidden("form_submit", array('name'=>'data[form_submit]','id'=>'form_submit')); ?>
<?= $this->Form->hidden("cart_item_id"); ?>
<?= $this->Form->hidden("layout", array('default'=>'standard')); ?>
<? if(empty($product_styles) || count($product_styles) <= 1) { ?>
	<?= $this->Form->hidden("Design.productCode", array('value'=>$productCode)); ?>
<? } ?>
<?= $this->Form->hidden("minimum", array('id'=>'minimum','value'=>$this->Session->read("Design.Product.minimum"))); ?>
<?= $this->Form->hidden("orientation", array('id'=>'DesignOrientation')); ?>
<!--
The following table encloses the entire form and preview area
-->
<table width="100%" border=0 cellpadding=0 cellspacing=0>
<tr>
	<td valign="top" style="" width="300" id="options" >
		<div id="side1" class="side">
			<?= $this->element("../designs/side",array('side'=>1)); ?>
		</div>
		<div id="side2" class="side" style="display:none;">
			<? if($sides > 1) { ?>
				<?= $this->element("../designs/side",array('side'=>2)); ?>
			<? } ?>

		</div>

		<div class='alert2'>
			<p>Most orders ship within 24-48 hours.<br>
            Please call if you have a deadline.<br>
            888.293.1109
            </p>
		</div>


		<!--
		<div align="right">
			<?= $this->Form->submit("/images/buttons/Review-Design.gif",array('onClick'=>"j.loading();")); ?>
		</div>
		-->

		<div id="side2thumb" style="<?= $sides <= 1 || empty($this->data['DesignSide'][2]['edited']) ? "display:none;" : "" ?>" class='sidethumb'>
			<h3 class=''>Side 2</h3>
			<? $side2thumb = $this->Html->image( $sides > 1 ?
				"/designs/png/2" : "/images/trans.gif",array('class'=>'thumb')); ?>
			<?= $this->Html->link($side2thumb, "#side2", array('escape'=>false,'title'=>'Click to go to side 2','class'=>'sidegoto')); ?>
			<div class='clear'></div>
		</div>
		<div id="side1thumb" style="display: none;" class='sidethumb'>
			<h3 class=''>Side 1</h3>
			<? $side1thumb = $this->Html->image("/images/trans.gif",array('class'=>'thumb')); ?>
			<?= $this->Html->link($side1thumb, "#side1", array('escape'=>false,'title'=>'Click to go to side 1')); ?>
		</div>





	</td>
	<td class="vtop">
	<div class='left' style="position: relative; z-index: 0;">
		<div class='preview_wrapper'>
		<div class='preview' id="preview1">

			<?= $this->element("../designs/preview",array('side'=>1)); ?>
		</div>
		<div class='preview' id="preview2" style="display:none;">
			<? if($sides > 1) { ?>
			<?= $this->element("../designs/preview",array('side'=>2)); ?>
			<? } ?>
		</div>
		</div>
	</div>
	<div class="right relative" width="275" style="position: relative; z-index: 500;">

		<!-- 
        	D E S I G N     P R I C I N G     S I D E B A R
        -->
        <p class='center_align'><a href="/info/testimonials.php" class='reviewsLink'><img src="/images/icons/starsForReviewSmall.png"> Reviews</a></p> 
		<div id="DesignPricing">
        
			<?= $this->element("../designs/pricing",array('cart'=>1)); ?>
		</div>
		<!-- 
        	P R O O F     O P T I O N S     S I D E B A R
        -->
        <div id='proofOptions'>
		<div class='widget'>
			<h3>Proof Options</h3>
			<!--<div>-->
				<?= $this->element("../designs/proof"); ?>
			<!--</div>-->
		</div><!--widget-->
        </div><!--proofOptions-->
		<!-- 
        	S P E C I A L     I N S T R U C T I O N S     S I D E B A R
        -->
        <div id="specialInstructions">
            <div class='widget'>
                <h3>Special Instructions<br>About Your Order</h3>
                <div>
        
                    <?= $this->Form->input("comments", array('label'=>false,'after'=>'<br/>(optional)',
                    'type'=>'textarea','rows'=>3,'style'=>'width: 98%;')); ?>
                </div>
            </div><!--widget-->
		</div><!--specialInstructions-->
		<div class='clear'></div>

		<div id="Tips">
        
		</div><!--Tips-->
        
	</div>
	<div class='clear'></div>
	</td>
</tr>
</table>
<?= $this->Form->end(); ?>

</div>
<div class='clear'></div>
<div id="PreviewCss">
	<?= $this->element("../designs/preview_css"); ?>
</div>
<script type="text/javascript" src="//use.typekit.net/sbr1rvs.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script>
var orientations = <?= json_encode($orientations); ?>;

// XXX only enable orientation change sometimes, ie when product has both files...
j(document).ready(function() {
	//
	var code = j('input.DesignProductCode:checked').val();
	orientations[code] ? j('.Orientation').show() : j('.Orientation').hide();
});
j('.DesignProductCode').bind('change', function() {
	var code = j(this).val();
	//j('.Orientation').toggle(orientations[code]);
	orientations[code] ? j('.Orientation').show() : j('.Orientation').hide();
});

j(document).on('click', '.Orientation', function(e) { // needs to be on() since side2 orientation may be added on the fly.
	//console.log("ORIENT CLICK");
	var orient = j('#DesignOrientation').val();
	var msg = "By changing orientation, some portion of your design may be reset. ";
	if(j('.DesignSides:checked').val() > 1)
	{
		msg += "<br/><br/>For double-sided products, the orientation will be the same on both sides. ";
	}
	j.confirm(msg, function() {
		if(orient == 'horizontal')
		{
			j('#DesignOrientation').val('').change();
		} else {
			j('#DesignOrientation').val('horizontal').change();
		}
	});
});

j('#DesignOrientation').change(function() {
	j('#DesignForm').rotateProduct(j(this).val());
});

j('#DesignForm input[type=text]').ignoreEnter();

j('#sides').tabs({
	fx: { width: 'toggle', duration: '500' }
});
j('#side2link').click(function() {
	j('#sides').tabs("option", "active", 1);
});
j('#side1link').click(function() {
	j('#sides').tabs("option", "active", 0);
});

/*
j('#DesignForm input[type=image], #DesignForm input[type=image]').click(function() {
	j('#form_submit').val(j(this).val());
});
*/
j(document).on('click', 'a.sidelink', function() {
	var panel = j(this).closest('div.side');
	var side = j(panel).attr('id').replace(/^side/,"");
});

// General updating of form to preview.
j(document).on('keyup change show', 'form :input', function() {
	var sidediv = j(this).closest('.side');
	var sideid = j(sidediv).attr('id');
	if(!sideid) { return; }
	var side = parseInt(sideid.replace(/^side/,""));
	j('#DesignSide'+side+'Edited').val(1); // mark edited so thumb will show next time.
	j(this).trigger('preview');
});
j(document).on('change', 'form :input', function() { // apply to fields added later.
	var sidediv = j(this).closest('.side');
	var sideid = j(sidediv).attr('id');
	if(!sideid) { return; }
	var side = parseInt(sideid.replace(/^side/,""));
	j('#DesignSide'+side+'Edited').val(1); // mark edited so thumb will show next time.

	j(this).trigger('preview');
});

j('.sidegoto').click(function() {
	var url = j(this).attr('href');
	if(location.hash == url) // fix situation where url is broken
	{
		j(window).hashchange(); // otherwise not called.
	}
});
j(document).ready(function() {
	j('form #accordion1 :input').trigger('preview');
});

j(window).hashchange(function() { // implement back button and switching sides.
	var hash = location.hash;
	if(hash.match(/^#side/))
	{
		var wanted = parseInt(hash.replace(/^#side/, ""));
		var other = (wanted == 1) ? 2 : 1;
		var sides = parseInt(j('.DesignSides:checked').val());

		if(wanted == 2 && sides != 2) { return; }

		j.loading();

		// Save changes and make sure picture reflects accurately! (kept in sync)
		j('#DesignForm').save(function() {

			j('#preview'+other).hide();
			j('#side'+other).hide();
			j('#preview'+wanted).show();
			j('#side'+wanted).show();
		
			// switch thumbs.
			j('#side'+other+'thumb img.thumb').attr('src','/designs/png/'+other+'?rand='+(Math.random()*10000));
			if(other == 1 || (sides > 1 && j('#DesignSide'+other+'Edited').val()))
			{
				j('#side'+other+'thumb').show();
			}
			j('#side'+wanted+'thumb').hide();
	
			if(wanted == 1 && sides == 2)
			{
				j('#side'+wanted+'label h3').show();
			}
	
			j('#side'+wanted+' :input').trigger('preview'); // Load pieces.
	
			// Trigger first step, ie for image gal, etc
			j('#accordion'+wanted).find('.ui-accordion-content:first').trigger('active');

			j('#side'+wanted).trigger('visible'); // trigger visibility sensitive options, ie draggable, etc....
		
			j.loading(false);
		});

	} else {
		j('#side1').trigger('visible'); // either way.

	}
});

j(document).ready(function() {
        j(window).hashchange();
});

</script>
