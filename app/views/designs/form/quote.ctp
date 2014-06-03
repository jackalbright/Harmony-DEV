<?
$layout = $this->Session->read("DesignSide.$side.layout");
$hasText = ($layout != 'imageonly');
# Probably obsolete.
?>
<h3 id="<?=$side ?>_header_quote" class='step_header side<?=$side?>'><?=$i ?>. Type Text (optional)</h3>
<div id="<?=$side ?>_step_quote" class='step side<?=$side?>'>
<?
###############################
# need to manually code since points vary, even though they are nicer numbers.
$quoteFontSizes = array( # pixel=>point name
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
$defaultFontSize = 22;#19;

$fonts = array(
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
$defaultFont = 'tk-adobe-garamond-pro';

$script_excludes = array('tk-bickham-script-pro'=>1);
$quote_fontFamilies = array_diff_key($fontFamilies, $script_excludes); # Filter out scripts

?>
<div id="Quote<?=$side?>Details" style=''>
	<table width="285" cellpadding=0 cellspacing=0>
	<tr><td width="160" valign="top" style="padding-right: 5px;"> 
		<?= $this->Form->input("DesignSide.$side.quote_font", array('options'=>$quote_fontFamilies,'class'=>'font','default'=>$defaultFont,'label'=>'Font')); ?>
	</td><td align='left' valign="top" style="padding-right: 5px;">
		<?= $this->Form->input("DesignSide.$side.quote_font_size", array('options'=>$quoteFontSizes,'default'=>$defaultFontSize,'label'=>'Size')); ?>
	</td>
	<td width="50" align="left" valign="top">
		<?= $this->Form->input("DesignSide.$side.quote_color", array('label'=>'Color','type'=>'text','default'=>'#000')); ?>
	</td></tr></table>

	<br/>


	<label class=''>Style</label>
	<div class='QuoteStyle'>
	<?
		$dropcap_img = $this->Html->image("/images/icons/dropcap.png");
		$center_img = $this->Html->image("/images/icons/centered_text.png");
	?>
	<div class='left'>
		<?= $this->Form->input("DesignSide.$side.quote_style", array('options'=>array('dropcap'=>$dropcap_img),'escape'=>false,'type'=>'radio','default'=>'dropcap','legend'=>false)); ?>
	</div>
	<div class='right'>
		<?= $this->Form->input("DesignSide.$side.quote_style", array('options'=>array('center'=>$center_img),'escape'=>false,'type'=>'radio','default'=>'dropcap','legend'=>false)); ?>
	</div>
	<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<br/>

	<?= $this->Form->input("DesignSide.$side.quoteNone", array('type'=>'hidden')); ?>
	<div>
		<div class='right'>
			<?= $this->Html->link("Browse Quotation Library", "/designs/quotes/{$side}", array('id'=>"DesignSide{$side}QuoteLibrary",'onClick'=>'j.loading();','class'=>'modal','title'=>'Browse Quotation Library')); ?>
		</div>

		<?= $this->Form->hidden("DesignSide.$side.quote_id"); ?>
		<?= $this->Form->input("DesignSide.$side.quote", array('type'=>"textarea",'cols'=>null,'width'=>'100%','label'=>'Text','Xlabel'=>'Type your text','class'=>'DesignQuote')); ?>
		<div class='tip'>
		Click &amp; drag text on product at right to reposition
		</div>

		<div align='right'>
		<?= $this->Form->input("DesignSide.$side.quote_attribution", array('type'=>"text",'width'=>'100%','label'=>false,'class'=>'DesignQuoteAttribution')); ?>
		</div>
	</div>
	<script>
	j('#DesignSide<?=$side?>Quote').ghostable("Your quotation, text, or other wording here"); 
	j('#DesignSide<?=$side?>QuoteAttribution').ghostable("Attribution (author of quote)");
	</script>

</div>

<?= $this->Form->hidden("DesignSide.$side.quote_x", array('id'=>"{$side}_quote_x",'div'=>false,'label'=>false,'size'=>4)); ?>
<?= $this->Form->hidden("DesignSide.$side.quote_y", array('id'=>"{$side}_quote_y",'div'=>false,'label'=>false,'size'=>4)); ?>


<script>
j('#DesignSide<?=$side?>QuoteFont').fontpicker();
//j('#DesignSide<?=$side?>QuoteFont').fontSelector();

j('#DesignSide<?=$side?>QuoteFont').bind('preview', function() {
	var font = j(this).val();
	var allfonts = j.map(j(this).find('option'), function(e) { return e.value; }).join(" ");
	j('#preview<?=$side?> .fullbleed .quote p').removeClass(allfonts).addClass(font);
});

j('#DesignSide<?=$side?>Quote').bind('keyup', function(e) {
	var string = j(this).val();
	if(string.match(/^\s+/))
	{
		string = string.replace(/^\s+/, "");
		j(this).val(string);
	}
});

j('#DesignSide<?=$side?>Quote').bind('preview', function() {
	if(!j(this).val())// && j(this).closest('.ui-accordion-content').hasClass('completed')) 
	{
		j('#preview<?=$side?> .fullbleed .quote p.text').html('').removeClass('ghosted attributed').hide().parent().removeClass('enabled').contain(5);
	} else if(j(this).css('display') != 'none') // since visible could catch closed step
	{
		var string = j(this).val();
		//console.log("STR1="+string);

		// remove leading whitesapce (spaces and breaks)
		string = string.replace(/^\s+/, "");

		string = string.nl2br(); // translate newlines

		// Replace ellipses with special char... (so dropcap works)
		string = string.replace(/([.]\s*[.]\s*[.])/gm, "…");

		// remove beginning and ending quotes
		var attributed = false;
		if(string.match(/"(.+)"/)) // remove so dropcap found properly.
		{
			string = string.replace(/"(.+)"/, "$1");
			// add quote marks... done after dropcap set.
			attributed = true;
		}

		// add placeholder for dropcap ... any char.
		string = string.replace(/^(.)(.*)$/m, "<span class='cap'>$1</span><span class='content'>$2</span>");
		//console.log("STR2="+string);

		// Add quote marks.
		if(attributed)
		{
			string = "<span class='lquote'>“ </span>" + string + "<span class='rquote'> ”</span>";
			j('#preview<?=$side?> .fullbleed .quote').addClass('attributed');
		} else {
			j('#preview<?=$side?> .fullbleed .quote').removeClass('attributed');
		}

		j('#preview<?=$side?> .fullbleed .quote p.text').html(string).removeClass('ghosted').show().parent().addClass('enabled').contain(5);
		j('#DesignSide<?=$side?>QuoteNone').val('');

		j('#DesignSide<?=$side?>QuoteId').val(''); // clear quote id, customized
	}
});

// start attribution 
j('#DesignSide<?=$side?>QuoteAttribution').bind('preview', function() {
	if(!j(this).val() && j(this).closest('.ui-accordion-content').hasClass('completed')) 
	{
		j('#preview<?=$side?> .fullbleed .quote p.attribution').html('').removeClass('ghosted').hide().parent().removeClass('enabled').contain(5);
	} else if(j(this).css('display') != 'none') // since visible could catch closed step
	{
		var string = j(this).val().nl2br();
		if(string)
		{
			string = "— "+string;
		}
		j('#preview<?=$side?> .fullbleed .quote p.attribution').html(string).removeClass('ghosted').show().parent().addClass('enabled').contain(5);
		j('#DesignSide<?=$side?>QuoteNone').val('');
		j('#DesignSide<?=$side?>QuoteId').val(''); // clear quote id, customized
	}
});

j('#DesignSide<?=$side?>QuoteStyleDropcap').bind('preview', function() {
	j('#preview<?=$side?> .fullbleed .quote').toggleClass('dropcap', j(this).is(":checked"));
	j('#preview<?=$side?> .fullbleed .quote').toggleClass('center', !j(this).is(":checked"));
});
j('#DesignSide<?=$side?>QuoteStyleCenter').bind('preview', function() {
	j('#preview<?=$side?> .fullbleed .quote').toggleClass('center', j(this).is(":checked"));
	j('#preview<?=$side?> .fullbleed .quote').toggleClass('dropcap', !j(this).is(":checked"));
});
j('#DesignSide<?=$side?>QuoteFontSize').bind('preview', function() {
	var fontSize = j(this).val();
	j('#preview<?=$side?> .fullbleed .quote').css({fontSize: fontSize+"px"});
});

j('#DesignSide<?=$side?>QuoteNone').bind('change', function() {
	var none = j(this).val();
	if(none)
	{
		j('#DesignSide<?=$side?>Quote').val('').change().blur(); // blur does ghost restore.
	}
});

j('#DesignSide<?=$side?>QuoteColor').bind('preview', function() {
	var color = j(this).val();
	j('#preview<?=$side?> .quote').css({color: color});
});

j(document).ready(function() {

	j('#preview<?=$side?> .fullbleed .quote').addClass('dynamic');
	


	j('#DesignSide<?=$side?>QuoteColor').colorpicker({
		flat: true,
		showPaletteOnly: true,
		palette: [ '#000', '#FFF' ]
	});
});
j('#side<?=$side ?>').bind('visible', function() { // things sensitive to position.
	j('#preview<?=$side?> .quote').enableDraggable().enableResizable();
});
</script>

<?= $this->element("../designs/next",array('skip'=>'/images/buttons/small/No-Text.gif','skip_js'=>"j('#DesignSide{$side}QuoteNone').val('1').change();")); ?>

</div>
