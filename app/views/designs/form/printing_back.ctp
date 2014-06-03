<?
$defaultSide = $this->Session->read("Design.Design.sides");
if(empty($defaultSide)) { $defaultSide = 1; }
?>
<h3><?=$i ?>. Select Number of Sides</h3>
<div id="1_step_printing_back">
	<div class='left'>
		<?= $this->Form->input("Design.sides", array('options'=>array(1=>'One-sided'),'value'=>$defaultSide,'legend'=>false,'type'=>'radio','class'=>'DesignSides')); ?>
	</div>
	<div class='left' style="padding-left: 2px;">
		<?= $this->Form->hidden("Design.printing_back"); ?>
		<?= $this->Form->input("Design.sides", array('options'=>array(2=>'Two-sided'),'value'=>$defaultSide,'legend'=>false,'type'=>'radio','class'=>'DesignSides')); ?>
		<div style="font-size: 10px; padding-left: 25px;">
		<i><?= sprintf("$%u setup + $%.02f ea", $optionsByCode['printing_back']['Part']['PartPricing'][0]['setup_charge'], $optionsByCode['printing_back']['Part']['PartPricing'][0]['price']); ?></i>
		</div>
		<? #print_r($optionsByCode['printing_back']); ?>
	</div>
	<div class='clear'></div>

<script>
j('.DesignSides').bind('click, change', function() {

	var sides = parseInt(j('.DesignSides:checked').val());
	if(sides == 1 && j('#side2thumb').size()
		&& !confirm("Are you sure you want to remove side 2?"))
	{
		sides = 2;
		j('#DesignSides2').attr('checked','checked');
		return;
	}

	j.loading();

	if(sides == 1)
	{
		j('#DesignPrintingBack').val('');
	
		//j('#DesignForm').save();

		j('#DesignPricing').load("/designs/pricing", j('#DesignForm').serializeObject());
	
		j('#side1label').hide();
	
		j('#side2goto').hide();

		j('#side2').html('').hide();
		j('#preview2').html('').hide();

		j('#side2thumb').hide();
		j('#side1thumb').hide();

		window.location = '#side1'; // make sure. in case deleted side 2, no longer on.

		//j('#side1 :input').trigger('preview');
		// shouldn't be needed!

		j.loading(false);
	} else {  // two sided.
		// we need to preserve second side so they dont lose it all, 
		// so it needs to be loaded.
		j('#DesignPrintingBack').val('1');

		j('#DesignPricing').load("/designs/pricing", j('#DesignForm').serializeObject());

		j('#side1label').show();

		// Load preview.
		j('#preview2').load("/designs/preview/2", j('#DesignForm').serializeObject(), function() {
	
			// now load steps.
			j('#side2').load("/designs/side/2", j('#DesignForm').serializeObject(), function() {
				// NOT automatically going to side 2. since done in earlier step.
				j('#side2goto').show();

				// XXX TODO update pricing. - but once updated, load proper buttons.
				// load side 2 thumb.
				// XXX TODO
				if(j('#DesignSide2Edited').val()) // we've already edited the second side. only show secondary thumb then.
				{
					// load pic now.
					j('#side2thumb img.thumb').attr('src', '/designs/png/2?rand='+(Math.random()*10000));
					j('#side2thumb').show();
				}


	
	
				j.loading(false);
			});
		});
	}

	// update pricing.
	j.update_pricing();
});


// Click toggle must go after where item exists.

</script>

<?= $this->element("../designs/next"); ?>

</div>
