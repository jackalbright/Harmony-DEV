<?
# Load xml from svg.
$product_svg = APP."/webroot/images/designs/products/B.svg";
$product_xmlstring = file_get_contents($product_svg);
#print_r($product_xmlstring);

$svg_xml = simplexml_load_string($product_xmlstring);
$svg_xml->registerXPathNamespace("svg", "http://www.w3.org/2000/svg");

$dragimg = $svg_xml->xpath("//svg:image[@clip-path]");
$dragrect = $svg_xml->xpath("//svg:rect[@clip-path]");

$coords = $svg_xml->xpath("//svg:rect[not(@clip-path)]");
$parts = $svg_xml->xpath("//svg:image[not(@clip-path)]");
$fullbleed = $svg_xml->xpath("//svg:rect[@id='fullbleed']");

$product_image = "/images/designs/products/B.png";
$product_image_overlay = "/images/designs/products/B-trans.png";
# Load some product info.
list($product_width,$product_height) = getimagesize(APP."/webroot/$product_image");

?>
<? if(!isset($side)) { $side = 0; } ?>
<div id="preview">
	<!-- stuff goes where it goes, and movement is allowed/restricted on only some items... -->
	<div id="fullbleed">
		<? foreach($dragimg as $img) { ?>
		<div id='<?= $img['id'] ?>'>
			<img src="/images/trans.gif"/>
		</div>
		<? } ?>
		<? foreach($dragrect as $rect) { ?>
		<div id='<?= $rect['id'] ?>'>
			<? if ($rect['id'] == 'quote' || $rect['id'] == 'personalization') { # XXX LOAD ?>
			<p>
			</p>
			<? } ?>
		</div>
		<? } ?>
	</div>
	<!-- some parts have full access, some are internal to product -->
	<div id="coords">
	<? foreach($coords as $coord) { if($coord['id'] == 'fullbleed') { continue; } ?>
	<div id='<?= $coord['id'] ?>' class='coord'>
	</div>
	<? } ?>
	</div>
	<div id='parts'>
	<? foreach($parts as $part) { ?>
	<div id='<?= $part['id'] ?>' class='part'>
		<img src="/images/trans.gif"/>
	</div>
	<? } ?>
	</div>
	<img src='/images/trans.gif' id='canvas_overlay'/>
</div>

<style>
td
{
	vertical-align: top;
}
#preview
{
	/*margin: 0 auto;*/
	position: relative;
	width: <?= $product_width ?>px;
	height: <?= $product_height ?>px;
	/* w,h depends upon product and orientation; load from .png specs */
	background: url("<?= $product_image ?>") no-repeat;
}
#preview.horizontal
{
	-moz-transform: rotate(-90deg);  /* FF3.5/3.6 */
	-o-transform: rotate(-90deg);  /* Opera 10.5 */
	-webkit-transform: rotate(-90deg);  /* Saf3.1+ */
	transform: rotate(-90deg);  /* Newer browsers (incl IE9) */
	transform-origin: <?= $product_width/2?>px <?= $product_width/2?>px;
	filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
}

#preview.horizontal #fullbleed #image img
{
	-moz-transform: rotate(90deg);  /* FF3.5/3.6 */
	-o-transform: rotate(90deg);  /* Opera 10.5 */
	-webkit-transform: rotate(90deg);  /* Saf3.1+ */
	transform: rotate(90deg);  /* Newer browsers (incl IE9) */
	filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=1);
}

#preview.horizontal #fullbleed #quote
{
	-moz-transform: rotate(90deg);  /* FF3.5/3.6 */
	-o-transform: rotate(90deg);  /* Opera 10.5 */
	-webkit-transform: rotate(90deg);  /* Saf3.1+ */
	transform: rotate(90deg);  /* Newer browsers (incl IE9) */
	filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=1);
}

#overlay
{
	position: absolute;
	top: 0; left: 0;
	width: <?= $product_width ?>px;
	height: <?= $product_height ?>px;
	/* w,h depends upon product and orientation; load from .png specs */
	background: url("<?= $product_image_overlay ?>") no-repeat;
	z-index: 75;
}
#options
{
	background-color: #EEE;
	padding: 10px;
	position: relative;
}
#parts
{
	position: relative;
}
#canvas_overlay
{
	display: block;
	position: absolute;
	z-index: 100;
	width: <?= $product_width ?>px;
	height: <?= $product_height ?>px;
}
#tassel, #canvas_overlay
{
	/*display:none;*/
}
#preview .ui-state-disabled
{
	opacity: 1;
}

#coords
{
	z-index: 0;
	position: absolute;
	width: <?= $product_width ?>px;
	height: <?= $product_height ?>px;
}
.coord
{
}
#fullbleed #quote.coord,
#fullbleed #personalization.coord
{
	display: block;
}

#fullbleed #quote,
#fullbleed #personalization
{
	cursor: pointer;
}

.ui-draggable:hover
{
	border: dashed #AAA 1px;
	cursor: move;
}
.ui-draggable-dragging
{
	border: dashed #AAA 1px;
	cursor: move;
}

#fullbleed #quote.selected,
#fullbleed #personalization.selected
{
	cursor: move;
}

#fullbleed #personalization 
{
	vertical-align: center;
	text-align: center;
}

#fullbleed #personalization p
{
}

<? $stuff = array_merge($coords, $parts); ?>
<? foreach($stuff as $coord) { ?>
#<?= $coord['id'] ?>
{
	position: absolute;
	top: <?= intval($coord['y']); ?>px;
	left: <?= intval($coord['x']); ?>px;
	width: <?= $coord['width']; ?>px;
	<? if($coord['id'] == 'quote' || $coord['id'] == 'personalization') { ?>
		max-height: <?= $coord['height']; ?>px;
	<? } else { ?>
		height: <?= $coord['height']; ?>px;
	<? } ?>


	overflow: hidden;
	z-index: 10;
}
<? } ?>
<? $stuff = array_merge($dragimg, $dragrect); ?>
<? foreach($stuff as $coord) { ?>
#<?= $coord['id'] ?>
{
	position: absolute;
	top: <?= intval($coord['y'] - $fullbleed[0]['y']); ?>px;
	left: <?= intval($coord['x'] - $fullbleed[0]['x']); ?>px;
	width: <?= $coord['width']; ?>px;
	<? if($coord['id'] == 'quote' || $coord['id'] == 'personalization') { ?>
		max-height: <?= $coord['height']; ?>px;
	<? } else { ?>
		height: <?= $coord['height']; ?>px;
	<? } ?>


	overflow: hidden;
	z-index: 10;
}
<? } ?>

#parts img
{
}

#image
{
	top: 0px;
	left: 0px;
	width: <?= $fullbleed[0]['width'] ?>px;
	height: <?= $fullbleed[0]['height'] ?>px;
}

#parts #product
{
	z-index: 0;
}

#parts #picture,
#fullbleed #quote,
#fullbleed #personalization 
{
	z-index: 50;
}
#parts #tassel { 
	z-index: 80;
}

#fullbleed #quote.center, #parts #personalization.center
{
	text-align: center;
}

#fullbleed #quote p,
#fullbleed #personalization p
{
	margin: 0px;
}
#fullbleed #quote.dropcap p
{
	position: relative;
	line-height: 1.1em;
}
#fullbleed #quote.dropcap p:first-letter
{
	letter-spacing: 0;
	line-height: 0.7;
	font-size: 2.75em;
	float: left;
	position: relative;
	padding: 0px;
	margin: 0 0.2em 0 0;
	top: 0px;
	left: 0px;
}
#parts #image
{
}

#preview #image img
{
	cursor: move;
}

/*
#preview .selected
{
	border: dashed 2px #888;
	cursor: move;
}
*/
/*
.ghosted
{
	color: #999;
}
*/
.ui-slider
{
	border-color: #AAA;
	height: 0.4em;
	margin: 1em;
}
.ui-slider .ui-slider-handle
{
	border-color: #AAA;
	background: url("/css/flick/images/ui-bg_highlight-soft_25_0073ea_1x100.png") repeat-x scroll 50% 50% #0073EA;
	cursor: move;
	width: 1em;/*0.7em;*/
	top: -0.5em;
}
</style>
