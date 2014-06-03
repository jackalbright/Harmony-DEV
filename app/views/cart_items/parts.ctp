<? 
if(empty($parts)) { $parts = array(); } 
$parts_by_code = Set::combine($parts, "{n}.Part.part_code", "{n}"); 

$layouts = array();
if(!empty($prod) && in_array($prod, array('MG','MG-USA','KC','SMKC','ORN'))) # Double sided.
{
	$layouts['standard'] = 'Image and text';
	$layouts['imageonly'] = 'Image on both sides';
} else if(!empty($parts_by_code['quote']))
{
	$layouts['standard'] = 'Image, quotation and personalization';
	$layouts['imageonly'] = 'Image and personalization';
	$layouts['imageonly_nopersonalization'] = 'Image only';
}
else if(!empty($parts_by_code['personalization']))
{
	$layouts['standard'] = 'Image and personalization';
	$layouts['imageonly_nopersonalization'] = 'Image only';
}
?>

<!-- PIECES=<? print_r(array_keys($parts_by_code)); ?> -->

<? if(!empty($backgrounds)) { ?>
	<?= $form->input("options.backgroundColor", array('options'=>$backgrounds,'empty'=>'White','div'=>array('class'=>'left margin'))); ?>
<? } ?>
<? if(!empty($ribbons)) { ?>
	<? $ribbon_options = Set::combine($ribbons, "{n}.ribbon_id", "{n}.color_name"); ?>
	<?= $form->input("options.ribbonID", array('options'=>$ribbon_options,'empty'=>'- None -','default'=>1,'div'=>array('class'=>'left margin'))); ?>
<? } ?>
<? if(!empty($parts_by_code['handles'])) { $handles = array('Black'=>'Black','Navy'=>'Navy','Red'=>'Red'); } ?>
<? if(!empty($handles)) { ?>
	<?= $form->input("options.handles", array('options'=>$handles,'default'=>'Black','div'=>array('class'=>'left margin'))); ?>
<? } ?>
<? if(!empty($parts_by_code['pinback'])) { $pinbacks = array('Bar'=>'Bar','Tie Tack'=>'Tie Tack'); } ?>
<? if(!empty($pinbacks)) { ?>
	<?= $form->input("options.pinStyle", array('options'=>$pinbacks,'default'=>'Bar','div'=>array('class'=>'left margin'))); ?>
<? } ?>
<? if(!empty($parts_by_code['printside'])) { $sides = array('Front'=>'Front','Back'=>'Back'); } ?>
<? if(!empty($sides)) { ?>
	<?= $form->input("options.printSide", array('options'=>$sides,'default'=>'Front','div'=>array('class'=>'left margin'))); ?>
<? } ?>
<? if(!empty($borders)) { ?>
	<? $border_options = Set::combine($borders, "{n}.border_id", "{n}.name"); ?>
	<?= $form->input("options.borderID", array('options'=>$border_options,'empty'=>'- None -','XXXdefault'=>2,'div'=>array('class'=>'left margin'))); ?>
<? } ?>
<? if(!empty($tassels)) { ?>
<? $defaultTassel = 41; ?>
	<? $tassel_options = Set::combine($tassels, "{n}.tassel_id", "{n}.color_name"); ?>
	<?= $form->input("options.tasselID", array('options'=>$tassel_options,'default'=>$defaultTassel,'empty'=>'- None -','div'=>array('class'=>'left margin'))); ?>
<? } ?>
<? if(!empty($charms)) { ?>
<? $defaultCharm = ($prod == 'PW' ? null : 17); ?>
	<? $charm_options = Set::combine($charms, "{n}.charm_id", "{n}.name"); ?>
	<?= $form->input("options.charmID", array('options'=>$charm_options,'default'=>$defaultCharm,'empty'=>'- None -','div'=>array('class'=>'left margin margin'))); ?>
<script>
var defaultTasselID = 41;

j('#optionsTasselID').change(function() { 
	var tid = parseInt(j(this).val());
	var cid = parseInt(j('#optionsCharmID').val());
	if(cid > 0 && !(tid > 0)) // Removed tassel
	{
		j('#optionsCharmID').val(''); // Remove charm.
	}

});
j('#optionsCharmID').change(function() { 
	var cid = parseInt(j(this).val());
	var tid = parseInt(j('#optionsTasselID').val());
	if(cid > 0 && !(tid > 0))
	{
		j('#optionsTasselID').val(defaultTasselID);
	}
});
</script>
<? } ?>
<div class="clear"></div>

<table><tr><td width="50%" style="vertical-align: bottom;">
	<?= $form->input("CartItem.template", array('options'=>$layouts,'label'=>'Layout','default'=>'imageonly_nopersonalization')); ?>
</td><td style="vertical-align: bottom;">
	<?= $form->input("options.fullbleed", array('label'=>'Fullbleed','type'=>'checkbox')); ?>
</td></tr></table>
<script>
j('#CartItemTemplate').change(function() {
	var layout = j(this).val();
	//console.log(layout);
	if(layout == 'standard')
	{
		j('#quoteContainer').show();
		j('#persContainer').show();
	}
	if(layout == 'imageonly')
	{
		j('#quoteContainer').hide();
		j('#persContainer').show();
	}
	if(layout == 'imageonly_nopersonalization')
	{
		j('#quoteContainer').hide();
		j('#persContainer').hide();
	}

});
j(document).ready(function() {
	j('#CartItemTemplate').change(); // Keep accurate.

});
</script>

<table width="100%">
<tr><td width="50%" id="" colspan=2>
	<div id="quoteContainer">
	<? if(!empty($parts_by_code['quote'])) { ?>
		<?= $form->input("options.customQuote", array('class'=>'no_editor','type'=>'textarea')); ?>
		<table width="100%"><tr><td>
		<?= $form->input("options.centerQuote", array('label'=>'Quote Style','options'=>array(0=>'Dropcap',1=>'Center quote'))); ?>
		</td><td>
		<?= $form->input("options.alignQuote", array('label'=>'Text placement','options'=>array('top'=>'Top','middle'=>'Middle','bottom'=>'Bottom'))); ?>
		</td><td>
		<?= $form->input("options.textSize", array('label'=>'Text size','options'=>array('Small'=>'Small','Medium'=>'Medium','Large'=>'Large'),'default'=>'Large')); ?>
		</td></tr></table>
	<? } ?>
	</div>
</td><td id="" colspan=2>
	<div id="persContainer">
	<? if(!empty($parts_by_code['personalization'])) { ?>
		<?= $form->input("options.personalizationInput", array('label'=>'Personalization','style'=>'width: 100%')); ?>
		<table width="100%"><tr><td>
		<?= $form->input("options.personalizationStyle", array('label'=>'Font','options'=>array('block'=>'Block','script'=>'Script'))); ?>
		</td><td>
		<?= $form->input("options.personalizationColor", array('label'=>'Color','options'=>array('black'=>'Black','white'=>'White'))); ?>
		</td>
		<td>
			<?= $form->input("options.personalizationSize", array('label'=>'Personalization size','options'=>array('Small'=>'Small','Medium'=>'Medium','Large'=>'Large'),'default'=>'Large')); ?>
		</td>
		</tr></table>
	<? } ?>
	</div>
</td></tr>
<tr><td>
</td><td>
</td><td>
</td></tr>
</table>

<hr/>
