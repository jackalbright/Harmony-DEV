<style>
.preview_wrapper
{
	min-width: <?= $product_width ?>px;
	min-height: <?= $product_height ?>px;
}
.preview
{
	/*margin: 0 auto;*/
	position: absolute;
	top: 0px;
	left: 0px;
	width: <?= $product_width ?>px;
	height: <?= $product_height ?>px;
	/* w,h depends upon product and orientation; load from .png specs */
	background: url("<?= $product_image ?>") no-repeat;
/*	margin: 0 auto; */
}

.overlay
{
	position: absolute;
	top: 0; left: 0;
	width: <?= $product_width ?>px;
	height: <?= $product_height ?>px;
	/* w,h depends upon product and orientation; load from .png specs */
	background: url("<?= $product_image_overlay ?>") no-repeat;
	z-index: 75;
}
/*
.options
{
	background-color: #EEE;
	padding: 10px;
	position: relative;
}
*/
.canvas_overlay
{
	display: block;
	position: absolute;
	z-index: 100;
	width: <?= $product_width ?>px;
	height: <?= $product_height ?>px;
}

.coords
{
	z-index: 10;
	position: absolute;
	width: <?= $product_width ?>px;
	height: <?= $product_height ?>px;
}

<? $stuff = array_merge($coords, $parts); ?>
<? foreach($stuff as $coord) { ?>
.<?= $coord['id'] ?>
{
	position: absolute;
	top: <?= intval($coord['y']); ?>px;
	left: <?= intval($coord['x']); ?>px;
	width: <?= $coord['width'] ?>px;
	height: <?= $coord['height']; ?>px;

	overflow: hidden;
}
<? } ?>
.coords
{
	z-index: -10;
}
.parts
{
	z-index: 10;
}

.textonly.preview .quote
{
	top: <?= !empty($items['textonly']['y']) ? $items['textonly']['y'] - $items['fullbleed']['y'] : 0 ?>px;
}

.preview.imageonly .quote
{
	max-height: <?= $items['fullbleed']['height']; ?>px;
}

<? $stuff = array_merge($dragimg, $dragrect); ?>
<? foreach($stuff as $coord) { ?>
.<?= $coord['id'] ?>
{
	position: absolute;
	<? if(false && $coord['id'] == 'personalization') { ?>
	/* <?= $fullbleed[0]['y'] ?>, <?= $fullbleed[0]['h'] ?>, CY=<?= $coord['y'] ?>, CH=<?= $coord['h'] ?> */
	bottom: <?= intval(($fullbleed[0]['y'] + $fullbleed[0]['height']) - $coord['y'] - $coord['height']) ?>px;
	<? } else { ?>
	top: <?= intval($coord['y'] - $fullbleed[0]['y']); ?>px;
	<? } ?>

	left: <?= intval($coord['x'] - $fullbleed[0]['x']); ?>px;
	width: <?= $coord['width']; ?>px;
	<? if($coord['id'] == 'personalization') { ?>
		max-height: <?= $items['fullbleed']['height']/3; ?>px;
	<? } else if($coord['id'] == 'quote') { # slight clip with 'max-height' ?>
		max-height: <?= $items['fullbleed']['height']; ?>px;
	<? } else { ?>
		height: <?= $coord['height']; ?>px;
	<? } ?>
	overflow: visible;


	z-index: 10;
}
<? if(in_array($coord['id'], array('border1','border2'))) { ?>
.<?= $coord['id'] ?> img
{
	display: block;
	width: <?= $coord['width']; ?>px;
	height: <?= $coord['height']; ?>px;
}
<? } ?>
<? } ?>

.parts img
{
}

.image
{
	top: 0px;
	left: 0px;
	width: <?= $fullbleed[0]['width'] ?>px;
	height: <?= $fullbleed[0]['height'] ?>px;
}


.fullbleed .quote p.text,
.fullbleed .personalization p.text
{
	position: relative;
	margin: 0px;
	line-height: <?= $textOptions['lineHeight'] ?>em; /* dropcap should be two lines worth */
}

.fullbleed .quote.attributed.dropcap
{
	margin: <?= $textOptions['quotedMargin'] ?>em;
}

.fullbleed .quote span.lquote,
.fullbleed .quote span.rquote
{
	font-family: <?= $textOptions['quotedFont'] ?>, Times New Roman, serif;
}

.fullbleed .quote p.text span.lquote
{
	p% 0 0 0;osition: relative;
}
.fullbleed .quote.dropcap p.text span.lquote
{
	float: left;
	left: -<?= $textOptions['leftQuoteOffsetX'] ?>em;
	top: -<?= $textOptions['leftQuoteOffsetY'] ?>em;
	font-size: <?= $textOptions['leftQuoteSize'] ?>em;
}

.fullbleed .quote p.attribution
{
	line-height: <?= $textOptions['lineHeight'] ?>em;
	margin: <?= $textOptions['attributionMargin'] ?>em 0 0 0;
	font-style: italic;
	font-size: <?= $textOptions['attributionSize'] ?>em;
	color: inherit !important;
}
.quote p
{
	margin: 0px;
}

/*
.fullbleed .quote p.attribution:before
{
	 content: "— ";
	float; left;
}
*/

#DesignForm .DesignQuoteAttribution
{
	text-align: right;
}

.fullbleed .quote.dropcap p.text
{
	position: relative;
}

<? foreach($fontNames as $font_id=>$font_name) { # Font could have tweaks, so consider. ?>
.fullbleed .quote p.<?= $font_id?>, .fullbleed .personalization p.<?=$font_id?>
{
	padding-right: <?= !empty($fontTweaks[$font_id]['rightShaveFudge']) ? 
				$fontTweaks[$font_id]['rightShaveFudge'] : 
				(!empty($textOptions['rightShaveFudge']) ? $textOptions['rightShaveFudge'] : 0)
			?>em;
}
.fullbleed .quote.dropcap p.text.<?=$font_id?> span.cap
{
	letter-spacing: 0;
	float: left;
	position: relative;
	padding: 0px;
	left: 0px;
	top: 0px;
	/* 1em causes trouble on narrow letters, ie Y has huge gap vs W 
	width: 1em;
	*/
	font-size: <?= !empty($fontTweaks[$font_id]['dropcapFactor']) ? $fontTweaks[$font_id]['dropcapFactor'] : $textOptions['dropcapFactor']; ?>em;
	/*
	line-height: <?= (!empty($fontTweaks[$font_id]['dropcapDrop']) ? $fontTweaks[$font_id]['dropcapDrop'] : $textOptions['dropcapDrop'])*100*
		(!empty($fontTweaks[$font_id]['dropcapLineHeightFudge']) ? $fontTweaks[$font_id]['dropcapLineHeightFudge'] : 1);# Fudge factor. 
		?>%;
	XXX fix dropcapDrop
	*/
	line-height: <?= (!empty($fontTweaks[$font_id]['dropcapLineHeightFudge']) ? $fontTweaks[$font_id]['dropcapLineHeightFudge'] : $textOptions['dropcapLineHeightFudge']) * 100 ?>%;

	margin-right: <?= (!empty($fontTweaks[$font_id]['dropcapMarginRight']) ? $fontTweaks[$font_id]['dropcapMarginRight']*100 : $textOptions['dropcapMarginRight']*100)*
		(!empty($fontTweaks[$font_id]['dropcapMarginRightFudge']) ? $fontTweaks[$font_id]['dropcapMarginRightFudge'] : 1);# Fudge factor. 
		?>%;
	margin-top: <?= (!empty($fontTweaks[$font_id]['dropcapMarginTop']) ? $fontTweaks[$font_id]['dropcapMarginTop']*100 : $textOptions['dropcapMarginTop']*100) ?>%;
}

.fullbleed .quote.dropcap p.text.<?= $font_id ?>
{
	line-height: <?= !empty($fontTweaks[$font_id]['lineHeight']) ? $fontTweaks[$font_id]['lineHeight'] : $textOptions['lineHeight'] ?>em;
}
.fullbleed .quote.dropcap p.text.<?= $font_id ?> span.content
{
	display: block;
	text-indent: <?= (!empty($fontTweaks[$font_id]['dropcapTextIndent']) ? $fontTweaks[$font_id]['dropcapTextIndent'] : $textOptions['dropcapTextIndent'])*
		(!empty($fontTweaks[$font_id]['dropcapTextIndentFudge']) ? $fontTweaks[$font_id]['dropcapTextIndentFudge'] : $textOptions['dropcapTextIndentFudge']); # Fudge ?>em;
}

<? } ?>

.parts .image
{
}

.preview .image img
{
	cursor: move;
}

/*
.preview .selected
{
	border: dashed 2px #888;
	cursor: move;
}
*/
</style>
