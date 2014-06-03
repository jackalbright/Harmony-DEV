<? if(empty($side)) { $side = 1; } ?>
<? $otherside = ($side == 1) ? 2 : 1; ?>
<? $sides = $this->Session->read("Design.Design.sides"); ?>
<? if(empty($sides)) { $sides = 1; } ?>
<? $i = 0; ?>
<?= $this->Form->hidden("DesignSide.$side.edited"); ?>

<div id="accordion<?=$side?>" class='accordion'>

	<? if($side == 1 && !empty($product_styles) && count($product_styles) > 1) { ?>
		<?= $this->element("../designs/form/style",array('i'=>++$i)); ?>
	<? } ?>

	<?= $this->element("../designs/form/image",array('side'=>$side,'i'=>++$i)); # Not a part.?>

	<? if($side == 1) { ?>
		<?#= $this->element("../designs/form/printing_back",array('i'=>++$i)); ?>
	<? } ?>


	<? foreach($steps[$side-1] as $step) { # enabled parts for specified product/variant 
		$stepid = $step['Part']['part_code'];
	?>
   
		<? if(file_exists(APP."/views/designs/form/$stepid.ctp")) { ?>
			<?= $this->element("../designs/form/$stepid",array('side'=>$side,'i'=>++$i,'part'=>$step['Part'])); ?>
		<? } ?>
		<? # need to separate text/pers since different in db. ?>
        

	<? 
	
	} 
	?>
</div>
<div class='clear'></div>

<? if($side == 2) { ?>
<div class='left sidegoto'>
	<? $side2delete = $this->Html->image("/images/buttons/small/Delete-Side-2.gif"); ?>
	<?= $this->Html->link($side2delete, "javascript:void(0)", array('escape'=>false,'id'=>'side2delete','class'=>'alert2')); ?>
</div>
<script>
j('#side2delete').click(function() {
	//console.log("CLk");
	//console.log(j('#DesignSides1'));
	j('#DesignSides1').attr('checked','checked').change();
});
</script>
<? } ?>

<div class='sidegoto right' id="side<?=$otherside?>goto" style="<?= $sides == 1 ? "display:none;":"" ?>">
	<?= $this->Html->link($this->Html->image("/images/buttons/Go-to-Side-{$otherside}.gif"), "#side{$otherside}", array('escape'=>false,'class'=>'sidegoto')); ?>
</div>

<div class='clear'></div>


<script>
j('#accordion<?=$side?>').accordion({
	heightStyle: 'content',
	collapsible: true,
	icons: false,
	activate: function( event, ui) {
		j(ui.newPanel).trigger('active'); // any init to run once step is visible.
	}
});
j('#accordion<?=$side?>').on('active', '.ui-accordion-content', function() {
	/*
		var step = j(this).attr('id').replace(/^(\d+_)?step_/,'');
		j('#Tips').fadeOut();
		j.get("/designs/tips/"+step, function(content) { 
			j('#Tips').html(content).fadeIn();
		});
	*/

});

j('#accordion<?=$side?>').bind('next', function() {
	// need to mark as completed.
	j(this).find('.ui-accordion-content-active, .ui-accordion-header-active').addClass('completed');

	var sides = parseInt(j('.DesignPrintSides:checked').val());
	var side = parseInt(j(this).attr('id').replace(/^accordion/,""));
	var nextIx = j(this).accordion('option','active') + 1;
	var stepCount = j(this).find('.ui-accordion-header').size();

	/*if (nextIx == stepCount && side == 1 && sides > 1) { // Go to next side.
		// if on first side and last step, go to next side.
		j('#side2thumb a:first').click();
	}
	*/
	j(this).accordion('option','active', nextIx);
});

j('#accordion<?= $side ?>').bind('refresh', function() {
	j(this).accordion('refresh'); // load new steps.

	// Fix prefixes.
	j(this).find('.ui-accordion-header').each(function(ix) {
        	var num = ix+1;
        	var heading = j(this).text().replace(/^\d+[.] /, "");
        	j(this).html(num+". "+ heading);
	});
});
// need to put thumbscroller here to load at proper time.
j('#thumbs<?=$side?>').closest('.side<?=$side?>').bind('active',function() {
	j('#thumbs<?=$side?>').load("/designs/images");
});
</script>
