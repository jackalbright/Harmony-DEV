<h3 id="<?=$side?>_header_personalization" class='step_header side<?=$side?>'><?=$i ?>. Type Personalization (optional)</h3>
<div id="<?=$side?>_step_personalization" class='step side<?=$side?>'>
<?
###############################
# need to manually code since points vary, even though they are nicer numbers.

$persFontSizes = array(
	13=>10,
	15=>11,
	16=>12,
	17=>13,
	19=>14,
	21=>15,
	22=>16,
	23=>17,
	24=>18,
	26=>20,
	28=>22,
	32=>24,
	35=>26,
	37=>28,
	42=>32,
);

# Filter personalization fonts
#$persAllowed = array('apple_chancery', 'shelley_allegro','baskerville');
#$persFonts = array_intersect_key($fonts, array_flip($persAllowed));
#

$persFonts = array(
	'tk-adobe-caslon-pro'=>'Adobe Caslon',
	'tk-caliban-std'=>'Caliban',
	'tk-adobe-garamond-pro'=>'Adobe Garamond',
	'tk-century-old-style-std'=>'Century Old Style',
	'tk-cooper-black-std'=>'Cooper Black',
	'tk-hypatia-sans-pro'=>'Hypatia Sans',
	'tk-leander-script-pro'=>'Leander Script',
	'tk-nueva-std'=>'Nueva',
	'tk-poetica-std'=>'Poetica',
	'tk-sanvito-pro'=>'Sanvito',
	'tk-warnock-pro'=>'Warnock',
	'tk-voluta-script-pro'=>'Voluta Script'
);

$defaultPersFontSize = 22;

$defaultPersFont = 'tk-leander-script-pro';

$hasPersonalization = !$this->Session->read("DesignSide.$side.personalizationNone");
?>
<div id="PersonalizationDetails<?=$side?>" style=''>
	<table width="285" cellpadding=0 cellspacing=0>
	<tr><td width="160" valign="top" style="padding-right: 5px;"> 
		<?= $this->Form->input("DesignSide.$side.personalization_font", array('options'=>$fontFamilies,'class'=>'font','default'=>$defaultPersFont,'label'=>'Font')); ?>
	</td><td align='left' valign="top" style="padding-right: 5px;">
		<?= $this->Form->input("DesignSide.$side.personalization_font_size", array('options'=>$persFontSizes,'default'=>$defaultPersFontSize,'label'=>'Size')); ?>
	</td>
	<td width="50" align="left" valign="top">
		<?= $this->Form->input("DesignSide.$side.personalizationColor", array('label'=>'Color','type'=>'text','default'=>'#000')); ?>
	</td>
	</tr></table>

	<br/>

	<?= $this->Form->input("DesignSide.$side.personalizationNone", array('type'=>'hidden')); ?>
	<?= $this->Form->input("DesignSide.$side.personalization", array('type'=>"textarea",'rows'=>3,'class'=>'DesignPersonalization','label'=>'Text','Xlabel'=>'Type your personalization')); ?>
</div>

<script>
	j('#DesignSide<?=$side?>Personalization').ghostable("Your Personalization");
</script>

<?= $this->Form->hidden("DesignSide.$side.personalization_x", array('id'=>"{$side}_personalization_x",'div'=>false,'label'=>false,'size'=>4)); ?>
<?= $this->Form->hidden("DesignSide.$side.personalization_y", array('id'=>"{$side}_personalization_y",'div'=>false,'label'=>false,'size'=>4)); ?>

<script>
j('#DesignSide<?=$side?>PersonalizationFont').fontpicker();
//j('#DesignSide<?=$side?>PersonalizationFont').fontSelector();

j('#DesignSide<?=$side?>PersonalizationFont').bind('preview', function() {
	var font = j(this).val();
	var allfonts = j.map(j(this).find('option'), function(e) { return e.value; }).join(" ");
	//j('#preview<?=$side?> #fullbleed #personalization').css({fontFamily: font});
	j('#preview<?=$side?> .fullbleed .personalization p').removeClass(allfonts).addClass(font);
});
/*
j('#DesignSide<?=$side?>Personalization_clone').bind('preview', function() {
	if(!j('#DesignSide<?=$side?>PersonalizationNone').val() && j(this).css('display') != 'none'
		&& !j(this).closest('.ui-accordion-content').hasClass('completed') 
	) // since visible could catch closed step
	{
		var string = j(this).val().nl2br();
		j('#preview<?=$side?> .fullbleed .personalization p').show().html(string).addClass('ghosted').parent().contain(5);
	}
});
*/

j('#DesignSide<?=$side?>Personalization').bind('preview', function() {
	// ghost isnt active, custom value was set.
	if(!j(this).val() && j(this).closest('.ui-accordion-content').hasClass('completed')) 
	{
		j('#preview<?=$side?> .fullbleed .personalization p').html('').removeClass('ghosted').hide().parent().contain(5);
	} else if(j(this).val()) { //!j('#DesignSide<?=$side?>PersonalizationNone').val() && j(this).css('display') != 'none') // since visible could catch closed step
		j('#DesignSide<?=$side?>PersonalizationNone').val('');
		var string = j(this).val().nl2br();
		j('#preview<?= $side?> .fullbleed .personalization p').show().html(string).removeClass('ghosted').parent().contain(5);
	}
});

j('#DesignSide<?=$side?>PersonalizationNone').bind('preview', function() {
	var none = j(this).val();
	if(none)
	{
		j('#preview<?=$side?> .fullbleed .personalization p').hide();
		j('#DesignSide<?=$side?>Personalization').val('').change().blur();
	}

});

j('#DesignSide<?=$side?>PersonalizationFontSize').bind('preview', function() {
	var fontSize = j(this).val();
	j('#preview<?=$side?> .fullbleed .personalization').css({fontSize: fontSize+"px"});
});

j('#DesignSide<?=$side?>PersonalizationColor').bind('preview', function() {
	var color = j(this).val();
	j('#preview<?=$side?> .personalization').css({color: color});
});

j(document).ready(function() {
	j('#preview<?=$side?> .fullbleed .personalization').addClass('dynamic');


	j('#DesignSide<?=$side?>PersonalizationColor').colorpicker({
		flat: true,
		showPaletteOnly: true,
		palette: [ '#000', '#FFF' ]
	});
});
j('#side<?=$side ?>').bind('visible', function() { // things sensitive to position.
	j('#preview<?=$side?> .personalization').enableDraggable();
});
</script>

<?= $this->element("../designs/next",array('skip'=>'/images/buttons/small/No-personalization.gif','skip_js'=>"j('#DesignSide{$side}PersonalizationNone').val('1').change();")); ?>
</div>
