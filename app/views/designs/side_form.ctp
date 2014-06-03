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

<? $image_id = $this->Session->read("CustomImage.$side.Image_ID"); ?>
<? $image_path = $this->Session->read("CustomImage.$side.path"); ?>
<? $image_filename = $this->Session->read("Build.CustomImage.$side.filename"); ?>
<? $image_src = !empty($image_filename) ? "/$image_path/$image_filename" : "/images/your-image-here.jpg"; ?>
<!-- todo stamp -->

<h3>Side <?= $side+1 ?></h3>

<table width="100%">
<tr><td width="50%">
	<?= $this->Form->input("DesignSide.$side.layout", array('label'=>'Style','options'=>$layouts)); ?>
	<script>
	j('#DesignLayout').change(function() {
		var layout = j(this).val();
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

<div id="ImageDetails">
	<?= $this->Form->input("CustomImage.$side.file", array('type'=>'file')); ?>
	<?= $this->Form->input("CustomImage.$side.filename", array('type'=>'hidden','value'=>$image_src)); ?>
	<script>
	j('#CustomImage<?= $side ?>File').change(function() {
		console.log("SUBMIT FILE");
		j('#DesignForm').ajaxSubmit({
			//target: '#options',
			url: "/designs/upload",
			dataType: 'json',
			success: function(data) {
				j('#CustomImage<?=$side?>Filename').val(data.CustomImage.path+"/"+data.CustomImage.filename);
				j('#CustomImage<?=$side?>Filename').trigger('preview');
			}
		});
	});
	</script>

	<?= $this->Form->input("DesignSide.$side.custom_image_id", array('type'=>'hidden','value'=>$image_id)); ?>
	<div>
	Zoom Your picture:
	<div id="zoomPicture"></div>
	</div>
</div>

<div id="TextDetails">
<?
###############################
$quoteFontSizes = array();
for($i = 8; $i <= 36; $i+= 2) { $quoteFontSizes[$i] = $i; }

$persFontSizes = array();
for($i = 8; $i <= 20; $i+= 1) { $persFontSizes[$i] = $i; }

$defaultFontSize = 14;

$defaultPersFontSize = 12;

$defaultFont = null;#$fonts[0];

$defaultTasselId = 41;
$defaultBorderId = 2;

?>

	<?= $this->Form->input("quote_font", array('options'=>$fonts,'default'=>$defaultFont)); ?>
	<?= $this->Form->input("quote_font_size", array('options'=>$quoteFontSizes,'default'=>$defaultFontSize)); ?>
	<?
		$dropcap_img = $this->Html->image("/images/icons/dropcap.png");
		$center_img = $this->Html->image("/images/icons/centered_text.png");
	?>
	<?= $this->Form->input("quote_style", array('options'=>array('dropcap'=>$dropcap_img, 'center'=>$center_img),'escape'=>false,'type'=>'radio','default'=>'dropcap')); ?>

	<?= $this->Form->input("quote", array('type'=>"textarea")); ?>
	<script>
	j('#DesignQuote').ghostable("Your quotation, text, or other wording here"); 
	</script>

	<?= $this->Form->input("personalization_font", array('options'=>$fonts,'default'=>$defaultFont)); ?>
	<?= $this->Form->input("personalization_font_size", array('options'=>$persFontSizes,'default'=>$defaultPersFontSize)); ?>
	<?= $this->Form->input("personalization", array('type'=>"textarea",'rows'=>2)); ?>
	<script>
	j('#DesignPersonalization').ghostable("Your Personalization");
	</script>
</div>


<!-- other parts details -->

	<?= $this->Form->input("tassel_id", array('empty'=>'[None]','options'=>$tassels,'default'=>$defaultTasselId)); ?>

	<?= $this->Form->input("border_id", array('empty'=>'[None]','options'=>$borders,'default'=>$defaultBorderId)); ?>

	<?= $this->Form->input("background_color", array('type'=>'text')); ?>
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

	<br/>
	<hr/>
	<?= $this->Html->link("Save", "javascript:void(0)", array(
		'onClick'=>"j.post('/designs/save', j('#DesignForm').serialize());")); ?>
	|

	<?= $this->Html->link("Preview", "/designs/svg",array('target'=>'_new')); ?>

	<br/>
	<br/>


<?= $this->Form->input("crop_x", array('id'=>'crop_x','div'=>false,'label'=>false,'size'=>4)); ?>
<?= $this->Form->input("crop_y", array('id'=>'crop_y','div'=>false,'label'=>false,'size'=>4)); ?>
<?= $this->Form->input("crop_w", array('id'=>'crop_w','div'=>false,'label'=>false,'size'=>4)); ?>
<?= $this->Form->input("crop_h", array('id'=>'crop_h','div'=>false,'label'=>false,'size'=>4)); ?>

<?= $this->Form->input("quote_x", array('id'=>'quote_x','div'=>false,'label'=>false,'size'=>4)); ?>
<?= $this->Form->input("quote_y", array('id'=>'quote_y','div'=>false,'label'=>false,'size'=>4)); ?>

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
	j('#fullbleed #quote').css({fontFamily: font});
});
j('#DesignPersonalizationFont').bind('preview', function() {
	var font = j(this).val();
	j('#fullbleed #personalization').css({fontFamily: font});
});
j('#DesignQuote_clone').bind('preview', function() {
	if(j(this).is(":visible"))
	{
		var string = j(this).val().nl2br();
		j('#fullbleed #quote p').html(string).addClass('ghosted');
	}
});
j('#DesignPersonalization_clone').bind('preview', function() {
	if(j(this).is(":visible"))
	{
		var string = j(this).val().nl2br();
		j('#fullbleed #personalization p').html(string).addClass('ghosted');
	}
});

j('#DesignQuote').bind('preview', function() {
	var string = j(this).val().nl2br();
	j('#fullbleed #quote p').html(string).removeClass('ghosted');
});
j('#DesignPersonalization').bind('preview', function() {
	var string = j(this).val().nl2br();
	j('#fullbleed #personalization p').html(string).removeClass('ghosted');
});

j('#DesignQuoteStyleDropcap').bind('preview', function() {
	j('#fullbleed #quote').toggleClass('dropcap', j(this).is(":checked"));
});
j('#DesignQuoteStyleCenter').bind('preview', function() {
	j('#fullbleed #quote').toggleClass('center', j(this).is(":checked"));
});
j('#DesignQuoteFontSize').bind('preview', function() {
	var fontSize = j(this).val();
	j('#fullbleed #quote').css({fontSize: fontSize+"pt"});
});

j('#DesignPersonalizationFontSize').bind('preview', function() {
	var fontSize = j(this).val();
	j('#fullbleed #personalization').css({fontSize: fontSize+"pt"});
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
	j('#fullbleed img, #fullbleed #quote, #fullbleed #personalization').addClass('dynamic');
	j('#preview #quote, #preview #personalization').enableDraggable();
	j('#preview #image img').enableDraggable();
	j('#canvas_overlay').draggable_overlay();

});
/*
j(document).click(function(e) {
	console.log( j("<div>").append(j(e.target).clone()).html() );
});
*/

</script>

