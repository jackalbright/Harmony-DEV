<?
$layouts = array(
	'standard'=>'Image and Text',
	'imageonly'=>'Image only',
	'textonly'=>'Text only'
);
$orient = array(
	'vertical'=>'Vertical',
	'horizontal'=>'Horizontal'
);
?>
<? if(!isset($side)) { $side = 0; } ?>

<? $image_id = $this->Session->read("CustomImage.Image_ID"); ?>
<? $image_path = $this->Session->read("CustomImage.path"); ?>
<? $image_filename = $this->Session->read("Build.CustomImage.filename"); ?>
<? $image_src = !empty($image_filename) ? "/$image_path/$image_filename" : "/images/your-image-here.jpg"; ?>
<!-- todo stamp -->

<div id="accordion">
<h3>Layout and orientation</h3>
<div>
	<table width="100%">
	<tr><td width="50%">
		<?= $this->Form->input("layout", array('label'=>'Style','options'=>$layouts)); ?>
		<script>
		j('#DesignLayout').change(function() {
			var layout = j(this).val();
			j('#preview').removeClass('standard imageonly textonly').addClass(layout);
	
			if(layout == 'standard')
			{
				j('#ImageDetails').show();
				j('#TextDetails').show();
				j('#fullbleed #image').show();
				j('#fullbleed #quote, #fullbleed #personalization').show();
	
				// Do we reset to I+T ?
	
			} else if (layout == 'imageonly') {
				j('#ImageDetails').show();
				j('#TextDetails').hide();
				j('#fullbleed #image').show();
				j('#fullbleed #quote, #fullbleed #personalization').hide();
	
				j('#DesignBorderId').val('').change();
	
				// Do we stretch the picture as far as it goes? (max fullbleed)
	
			} else if (layout == 'textonly') { 
				j('#ImageDetails').hide();
				j('#TextDetails').show();
				j('#fullbleed #image').hide();
				j('#fullbleed #quote, #fullbleed #personalization').show();
			}
		});
		</script>
	</td><td>
		<?#= $this->Form->input("orientation", array('label'=>'Orientation','options'=>$orient)); ?>
	</td></tr></table>
</div>

<h3>Upload Your Picture</h3>
<div id="ImageDetails">
	<?= $this->Form->input("CustomImage.file", array('type'=>'file')); ?>
	<?= $this->Form->input("CustomImage.filename", array('type'=>'hidden','value'=>$image_src)); ?>
	<script>
	j('#CustomImageFile').change(function() {
		//console.log("SUBMIT FILE");
		j('#DesignForm').ajaxSubmit({
			//target: '#options',
			url: "/designs/upload",
			dataType: 'json',
			success: function(data) {
				j('#CustomImageFilename').val("/"+data.CustomImage.path+"/"+data.CustomImage.filename);
				j('#CustomImageFilename').trigger('preview');
			}
		});
	});
	</script>

	<?= $this->Form->input("custom_image_id", array('type'=>'hidden','value'=>$image_id)); ?>
	<div>
	Zoom Your picture:
	<div id="zoomPicture"></div>
	</div>
</div>

<h3>Text and Personalization</h3>
<div id="TextDetails">
<?
###############################
# need to manually code since points vary, even though they are nicer numbers.
$quoteFontSizes = array( # pixel=>point name
	13=>10,
	16=>12,
	19=>14,
	22=>16,
	24=>18,
	26=>20,
	32=>24,
	37=>28,
	42=>32,
);

$persFontSizes = array(
	13=>10,
	16=>12,
	19=>14,
	22=>16,
	24=>18,
	26=>20,
	32=>24,
	37=>28,
	42=>32,
);

# Filter personalization fonts
$persAllowed = array('apple_chancery', 'shelley_allegro','baskerville');
$persFonts = array_intersect_key($fonts, array_flip($persAllowed));

$defaultFontSize = 22;#19;

$defaultPersFontSize = 16;

$defaultFont = 'baskerville';
$defaultPersFont = 'apple_chancery';

$defaultTasselId = 41;
$defaultBorderId = 2;

?>

	<table width="100%">
	<tr><td> 
		<?= $this->Form->input("quote_font", array('options'=>$fonts,'default'=>$defaultFont)); ?>
	</td><td align='left'>
		<?= $this->Form->input("quote_font_size", array('options'=>$quoteFontSizes,'default'=>$defaultFontSize)); ?>
	</td></tr></table>

	<?
		$dropcap_img = $this->Html->image("/images/icons/dropcap.png");
		$center_img = $this->Html->image("/images/icons/centered_text.png");
	?>
	<?= $this->Form->input("quote_style", array('options'=>array('dropcap'=>$dropcap_img, 'center'=>$center_img),'escape'=>false,'type'=>'radio','default'=>'dropcap')); ?>

	<?= $this->Form->input("quote", array('type'=>"textarea")); ?>
	<script>
	j('#DesignQuote').ghostable("Your quotation, text, or other wording here"); 
	</script>

	<table width="100%">
	<tr><td> 
		<?= $this->Form->input("personalization_font", array('options'=>$persFonts,'default'=>$defaultPersFont)); ?>
	</td><td align='left'>
		<?= $this->Form->input("personalization_font_size", array('options'=>$persFontSizes,'default'=>$defaultPersFontSize)); ?>
	</td></tr></table>
	<?= $this->Form->input("personalization", array('type'=>"textarea",'rows'=>2)); ?>
	<script>
	j('#DesignPersonalization').ghostable("Your Personalization");
	</script>
</div>

<!-- other parts details -->

<h3>Choose a tassel</h3>
<div>
	<?= $this->Form->input("tassel_id", array('empty'=>'[None]','options'=>$tassels,'default'=>$defaultTasselId)); ?>
</div>

<h3>Choose a border</h3>
<div>
	<?= $this->Form->input("border_id", array('empty'=>'[None]','options'=>$borders,'default'=>$defaultBorderId)); ?>
</div>


<h3>Choose a background</h3>
<div>
	<?= $this->Form->input("background_color", array('type'=>'text','value'=>'#FFF')); ?>
	<script>
	j('#DesignBackgroundColor').colorpicker();

	j('#DesignBackgroundColor').change(function() {

		var bg = j(this).val();
		var dark = (colorBrightness(bg) <= 130);
		if(dark)
		{
			j('#DesignTextColor').val('#FFF').change();
		} else {
			j('#DesignTextColor').val('#000').change();
		}
	});
	</script>

	<?= $this->Form->hidden("text_color", array('value'=>'000')); ?>

</div>
</div>

	<hr/>
	
<?= $this->Form->input("quantity", array('default'=>12)); ?>
Subtotal: XXX

<?= $this->Form->submit("/images/buttons/Add-to-Cart.gif"); ?>

	<hr/>
	<?= $this->Html->link("Save", "javascript:void(0)", array(
		'onClick'=>"j.post('/designs/save', j('#DesignForm').serialize());")); ?>
	|

	<?= $this->Html->link("Preview", "/designs/svg",array('target'=>'_new')); ?>

	|

	<?= $this->Html->link("PNG", "/designs/png",array('target'=>'_new')); ?>

	<br/>
	<br/>


<?= $this->Form->hidden("crop_x", array('id'=>'crop_x','div'=>false,'label'=>false,'size'=>4)); ?>
<?= $this->Form->hidden("crop_y", array('id'=>'crop_y','div'=>false,'label'=>false,'size'=>4)); ?>
<?= $this->Form->hidden("crop_w", array('id'=>'crop_w','div'=>false,'label'=>false,'size'=>4)); ?>
<?= $this->Form->hidden("crop_h", array('id'=>'crop_h','div'=>false,'label'=>false,'size'=>4)); ?>

<?= $this->Form->hidden("quote_x", array('id'=>'quote_x','div'=>false,'label'=>false,'size'=>4)); ?>
<?= $this->Form->hidden("quote_y", array('id'=>'quote_y','div'=>false,'label'=>false,'size'=>4)); ?>

<?= $this->Form->hidden("personalization_x", array('id'=>'personalization_x','div'=>false,'label'=>false,'size'=>4)); ?>
<?= $this->Form->hidden("personalization_y", array('id'=>'personalization_y','div'=>false,'label'=>false,'size'=>4)); ?>

<?= $this->Form->hidden("border-1_y", array('id'=>'border-1_y','div'=>false,'label'=>false,'size'=>4)); ?>
<?= $this->Form->hidden("border-2_y", array('id'=>'border-2_y','div'=>false,'label'=>false,'size'=>4)); ?>

<script>




j('#DesignOrientation').bind('preview', function() {
	var orientation = j(this).val();
	j('#preview').removeClass('horizontal vertical').addClass(orientation);
});
// operations on selected parts, or at least some of them.

var tassels = <?= json_encode( !empty($tasselImages) ? $tasselImages : array() ); ?>;

j('#DesignTasselId').bind('preview', function() {
	j('#parts #tassel').showPart(tassels, j(this).val());
});

var borders = <?= json_encode( !empty($borderImages) ? $borderImages : array() ); ?>;

j('#DesignBorderId').bind('preview', function() {
	j('#parts #border-1').showPart(borders, j(this).val());
	j('#parts #border-2').showPart(borders, j(this).val());
});

j('#DesignBackgroundColor').bind('preview', function() {
	var color = j(this).val();
	j('#fullbleed').css({backgroundColor: color});
});

j('#DesignTextColor').bind('preview', function() {
	var color = j(this).val();
	j('#preview').css({color: color});
});


j('#DesignQuoteFont').bind('preview', function() {
	var font = j(this).val();
	j('#fullbleed #quote p').removeClass('<?= join(" ", array_keys($fonts)); ?>').addClass(font);
});
j('#DesignPersonalizationFont').bind('preview', function() {
	var font = j(this).val();
	//j('#fullbleed #personalization').css({fontFamily: font});
	j('#fullbleed #personalization p').removeClass('<?= join(" ", array_keys($fonts)); ?>').addClass(font);
});
j('#DesignQuote_clone').bind('preview', function() {
	if(j(this).is(":visible"))
	{
		var string = j(this).val().nl2br();
		j('#fullbleed #quote p').html(string).addClass('ghosted').parent().contain(5);
	}
});
j('#DesignPersonalization_clone').bind('preview', function() {
	if(j(this).is(":visible"))
	{
		var string = j(this).val().nl2br();
		j('#fullbleed #personalization p').html(string).addClass('ghosted').parent().contain(5);
	}
});

j('#DesignQuote').bind('preview', function() {
	var string = j(this).val().nl2br();
	j('#fullbleed #quote p').html(string).removeClass('ghosted').parent().contain(5);
});
j('#DesignPersonalization').bind('preview', function() {
	var string = j(this).val().nl2br();
	j('#fullbleed #personalization p').html(string).removeClass('ghosted').parent().contain(5);
});

j('#DesignQuoteStyleDropcap').bind('preview', function() {
	j('#fullbleed #quote').toggleClass('dropcap', j(this).is(":checked"));
	j('#fullbleed #quote').toggleClass('center', !j(this).is(":checked"));
});
j('#DesignQuoteStyleCenter').bind('preview', function() {
	j('#fullbleed #quote').toggleClass('center', j(this).is(":checked"));
	j('#fullbleed #quote').toggleClass('dropcap', !j(this).is(":checked"));
});
j('#DesignQuoteFontSize').bind('preview', function() {
	var fontSize = j(this).val();
	j('#fullbleed #quote').css({fontSize: fontSize+"px"});
});

j('#DesignPersonalizationFontSize').bind('preview', function() {
	var fontSize = j(this).val();
	j('#fullbleed #personalization').css({fontSize: fontSize+"px"});
});

j('#CustomImageFilename').bind('preview', function() {
	var filename = j(this).val();
	j('#image img').attr('src', filename);
});

j('form :input').bind('keyup change show', function() {
	j(this).trigger('preview');
});
j('form :input').change(function() {
	j(this).trigger('preview');
});

j(document).ready(function() {
	j('form input, form textarea, form select').trigger('preview');
	j('#fullbleed img, #fullbleed #quote, #fullbleed #personalization, #preview #border-1, #preview #border-2').addClass('dynamic');

	<?
	# border x,y,w,h etc are relative to container, not just fullbleed.
	$border1maxx = $border1minx = $items['border-1']['x'];
	$border1miny = $items['border-1']['y'];
	$border1maxy = $border1miny + $fullbleed[0]['height']/4; // Allow going down 1/4th

	$border2maxx = $border2minx = $items['border-2']['x'];
	$border2maxy = $items['border-2']['y'];
	$border2miny = $border2maxy - $fullbleed[0]['height']/4; // Allow going up 1/4th
	?>
	j('#preview #border-1').enableDraggable([<?= $border1minx ?>, <?= $border1miny ?>, <?= $border1maxx ?>, <?= $border1maxy ?>]);
	j('#preview #border-2').enableDraggable([<?= $border2minx ?>, <?= $border2miny ?>, <?= $border2maxx ?>, <?= $border2maxy ?>]);

	j('#preview #quote, #preview #personalization').enableDraggable();
	//j('#preview #image img').enableDraggable();
	j('#canvas_overlay').draggable_overlay();

});
/*
j(document).click(function(e) {
	console.log( j("<div>").append(j(e.target).clone()).html() );
});
*/

</script>

