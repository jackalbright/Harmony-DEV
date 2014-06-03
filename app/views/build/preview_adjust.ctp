<?
$imgonlys = array('imageonly','imageonly_nopersonalization');

$width = 300;

$prod = $build['Product']['code'];
# FIX ODDBALL products that dont have own files.
if(in_array($prod, array('BC','BB'))) { $prod = 'B'; } 
if(in_array($prod, array('MG-USA'))) { $prod = 'MG'; } 

$template = !empty($build['template']) ? $build['template'] : 'imageonly---';
###echo date('Y-m-d H:i:s') . ", $template, ". $this->params['url']['url'];

# Guess orient based on shape of picture. 
# Check if dir exists, if not, try other orient.
# ALSO check dir named after template.
# (maybe best to just create a list of paths and then pick the best first)
# TODO


$blanks_dir = APP."/../$product_image_dir/original";
$coords_file = "$blanks_dir/$prod.inc";
$trans_file = "$blanks_dir/{$prod}-trans.png";

#echo "P=$prod";

$product_config = $coords = include($coords_file);


#print_r($coords);

$scale = $width / $coords['file'][2];

$scaled_coords = array();
foreach($coords as $item => $vals)
{
	$scaled_coords[$item] = array(ceil($vals[0]*$scale), ceil($vals[1]*$scale), ceil($vals[2]*$scale), ceil($vals[3]*$scale));
}
#echo "SCALE=$scale";
#print_r($coords['fullbleed']);
##print_r($coords['file']);
#print_r($scaled_coords['fullbleed']);
#print_r($scaled_coords['file']);

$nopers = !empty($build['options']['personalizationNone']) || empty($build['options']['personalizationInput']);

$imgbox = 'image';

if(in_array($template, $imgonlys) && !empty($product_config['fullbleed']))
{
	$imgbox = 'fullbleed'; # fullbleed, fullview, image
} else if (!empty($product_config['image.nopersonalization'])) {# && $nopers) { # can always shrink later....
	$imgbox = 'image.nopersonalization';
} else if (in_array($template, $imgonlys) && !empty($product_config['fullview']) && empty($product_config['image.nopersonalization'])) {
	$imgbox = 'fullview';
}
$imgbox_nopers = !empty($product_config['image.nopersonalization']) ? 'image.nopersonalization' : 'image';



?>
<style>
#livepreview
{
	position: relative;
	overflow:hidden;
	width: <?= !in_array($prod, array('RL','PR','PB')) ? $width: 500; ?>px;
}
#livepreview #blankimg
{
	position: relative;
	z-index: 1;
}
#livepreview #canvas
{
	overflow: hidden; 
	position: absolute; 
	top: <?= !empty($canvas[1]) ? $canvas[1] : 0 ?>px; 
	left: <?= !empty($canvas[0]) ? $canvas[0] : 0 ?>px; 
	width: <?= !empty($canvas[2]) ? $canvas[2] : 0 ?>px; 
	height: <?= !empty($canvas[3]) ? $canvas[3] : 0 ?>px; 
	z-index: 5;
}
#livepreview #canvas #img
{
	position: absolute; 
	top: <?= !empty($imgy)?$imgy:0?>px; 
	left: <?= !empty($imgx)?$imgx:0?>px; 
	height: <?= $imgheight ?>px; 
	z-index: 200;
	<? if(!empty($build['GalleryImage'])) { ?>
	background-color: black;
	padding: 4px;
	<? } ?>
}

#livepreview #trans,
#livepreview #trans2
{
	<?= !empty($build['CustomImage']) ? "cursor: move;":""?>
	z-index: 500;
	position: absolute;
	top: 0px;
	left: 0px;
}
#livepreview #trans
{
	top: <?= !empty($canvas[1]) ? $canvas[1] : 0 ?>px; 
	left: <?= !empty($canvas[0]) ? $canvas[0] : 0 ?>px; 
	width: <?= !empty($canvas[2]) ? $canvas[2] : 0 ?>px; 
	height: <?= !empty($canvas[3]) ? $canvas[3] : 0 ?>px; 
}
#livepreview #trans2
{
	top: <?= !empty($canvas2[1]) ? $canvas2[1] : 0 ?>px; 
	left: <?= !empty($canvas2[0]) ? $canvas2[0] : 0 ?>px; 
	width: <?= !empty($canvas2[2]) ? $canvas2[2] : 0 ?>px; 
	height: <?= !empty($canvas2[3]) ? $canvas2[3] : 0 ?>px; 
}

#livepreview #canvas2
{
	overflow: hidden; 
	position: absolute; 
	top: <?= !empty($canvas2[1]) ? $canvas2[1] : 0 ?>px; 
	left: <?= !empty($canvas2[0]) ? $canvas2[0] : 0 ?>px; 
	width: <?= !empty($canvas2[2]) ? $canvas2[2] : 0 ?>px; 
	height: <?= !empty($canvas2[3]) ? $canvas2[3] : 0 ?>px; 
	z-index: 5;
}
#livepreview #canvas2 #img2
{
	position: absolute; 
	top: <?= !empty($imgy)?$imgy:0?>px; 
	left: <?= !empty($imgx)?$imgx:0?>px; 
	height: <?= $imgheight ?>px; 
	z-index: 5;
	<? if(!empty($build['GalleryImage'])) { ?>
	background-color: black;
	padding: 5px;
	<? } ?>
}

#livepreview #transimg,
#livepreview #transimg_white
{
	position: absolute; 
	top: 0px; 
	left: 0px; 
	z-index: 10;
	/*
	width: <?= $width ?>px;
	*/
}

#livepreview .background_color
{
	position: absolute;
	top: 0px;
	width: 100%;
	height: 100%;
	left: 0px;
	z-index: 3;
}
#livepreview #parts
{
	position: absolute;
	top: 0px;
	left: 0px;
	z-index: 49;
}

#livepreview .part
{
	position: absolute;
	top: 0px;
	left: 0px;
	z-index: 50;
}
#livepreview .part[src=]
{
	display: none;
}
<? foreach($scaled_coords as $part => $part_coords) { ?>
#livepreview .<?= preg_replace("/[.]/", "_", $part); ?>
{
	<?
		# correct minor scaling issues....
		$left_offset = 0;
		$top_offset = 0;
		if($part == 'border.1' || $part == 'border.2')
		{
			$left_offset = 1;
		}
	?>
	left: <?= $part_coords[0]+$left_offset; ?>px;
	top: <?= $part_coords[1]+$top_offset; ?>px;
	border: none;
	float: none;
	margin: 0px;
	z-index: 40;
	width: <?= $part_coords[2] ?>px;
	height: <?= $part_coords[3] ?>px;
}

#livepreview .<?= preg_replace("/[.]/", "_", $part); ?>
{
	margin: 0px;
}

<? } ?>

#livepreview.PW .charm
{
	text-align: center;
	margin: 0 auto;
}
#livepreview.PW .charm img
{
	background-color: black;
	border: solid black 5px;
}

#livepreview .text,
#livepreview .personalization,
#livepreview .personalization_1,
#livepreview .personalization_2
{
	top: 0px;
	left: 0px;
	
	z-index: 100;
}

#livepreview #overlayimg
{
	position: absolute; 
	top: 0px; 
	left: 0px; 
	z-index: 400;
	/*
	width: <?= $width ?>px;
	*/
}

#livepreview .tassel
{
	z-index: 40; /* lower than the charm */
}

/*
.livepreview #canvas
.livepreview #blank
{
}
.livepreview #blank
{
	z-index: 1;
}
.livepreview #blank.trans
{
	z-index: 10;
	overflow: hidden;
}

.livepreview #canvas
{
	position: absolute;
	width: <?= $scaled_coords[$imgbox][2]; ?>px;
	height: <?= $scaled_coords[$imgbox][3]; ?>px;
	top: <?= $scaled_coords[$imgbox][1]; ?>px;
	left: <?= $scaled_coords[$imgbox][0]; ?>px;
	overflow: hidden;
	z-index: 500;
	
}

.livepreview #img
{
	z-index: 5;
}

*/
</style>

<div id="live_preview" style="display:none;position: relative;">Loading... </div>
<div class="clear"></div>

<script>
(function($) { 
	$.fn.adjustable = function() {

		// TODO add trans2 ...
		//j('*').click(function(event) { console.log(this); });

		//j('*').mouseup(function(event) { console.log(this); return true; });


		//j('#build_img_container').mouseup(function(event) { console.log("MOUSE UP"); return endDrag(event); });
		//j('#build_img_container').mouseout(function(event) { console.log("MOUSE OUT"); return endDrag(event); });

		j('#livepreview').mousedown(function(event) { return startDrag(event); }); // XXX somehow fix/improve so image can be moved only on clicking on it, despite being not the top layered image!
			// create an invisible layer on TOP above everything that fits the img and follows it perfectly. only way.
			// flaw to design of image not being on top
		j('body').mouseup(function(event) { return endDrag(event); });
		j('#livepreview').mousemove(function(event) { return doDrag(event); });
		j('#livepreview').bind('dragstart', function(event) { return false; });
		j('#livepreview').bind('drag', function(event) { return false; });


		j('#trans, #trans2').bind('drag', function(event) { return false; });
		j('#trans, #trans2').bind('dragstart', function(event) { return false; });

		j(this).find('#blankimg').bind('drag', function(event) { return false; });
		j(this).find('#blankimg').bind('dragstart', function(event) { return false; });
		//j(this).find('#blankimg').bind('load', function(event) { hidePleaseWait(); showAdjustControls(); });
		
		j(this).find('#img').load(function() { j('#pleasewaitbelow').addClass('hidden'); });

		j(this).find('#transimg').load(function() { if(j('#img').size()) { j('#img').removeClass('hidden'); } });
		j(this).find('#transimg').bind('drag', function(event) { return false; });
		j(this).find('#transimg').bind('dragstart', function(event) { return false; });


	};
	/*

	$.fn.livepreview = function() {
		var prod = j('#prod').val();
		if(prod == 'BC' || prod == 'BNT' || prod == 'BB') // do also for other things.
		{
			prod = 'B';
		}
		var image_id = j('#CustomImageID').val();
		var image_url = j('#CustomImageDisplayLocation').val();
		var image_height = 'auto'; // for now.
		var layout = j('input[data\\[template\\]]:checked');

		// XXX TODO 300px
		// different for rulers.

		var orient = "horizontal"; // TODO
		// XXX TODO may need to load given current info.... orientation, imageonly, fullbleed, etc... subdirs...

		j(this).html('');
		j(this).addClass('livepreview');
		<? if(file_exists($trans_file)) { ?>
			j(this).append("<div id='canvas'><img id='img' style='height: "+image_height+"' src='"+image_url+"'/></div>");
			j(this).append("<img id='blank' class='trans' src='/images/products/blanks/"+prod+"/horizontal/medium/"+prod+"-trans.png'/>");
		<? } else { ?>
			j(this).append("<img id='blank' src='/images/products/blanks/"+prod+"/horizontal/medium/"+prod+".png'/>");
			j(this).append("<div id='canvas'><img id='img' style='height: "+image_height+"' src='"+image_url+"'/></div>");
		<? } ?>

		// Adjust image to fit appropriately

		// Loop through parts...
		// XXX NEED scaled down versions
		j(this).append("<img class='tassel' src='/tassels/blanks/medium/black.png'/>");

		j(this).append("<img class='charm' src='/charms/blanks-B/medium/book.gif'/>");
	};
	*/
})(jQuery);

function clearPart(part)
{
	j('#livepreview #parts .part.'+part).remove();
}
function setPart(part, src, load) 
{
	//console.log("SET_PART="+part+", "+src+", ONLOAD?="+load);
	var img = j('#livepreview #parts').find('.'+part);

	if(img.attr('src') == src) { return; } // already did.

	//console.log("SET PART "+part+", ONLOAD="+load);
	showPleaseWait(part);
	if(!src) { src = ''; } // undefined should be blank string.
	//console.log("SRC="+src);
	if(!img.size())
	{
		j('#livepreview #parts').append("<div class='part "+part+"'><img style='display: none;' class='' src='' onLoad='hidePleaseWait(\""+part+"\");'/></div>");
	}
	j('#livepreview #parts .'+part+' img').load(function() { j(this).show(); if(!load) { updateBuild(part_name); } }); // So ie doesnt get glitchy bad img icon
	j('#livepreview #parts .'+part+' img').prop('src', src);
	if(!src)
	{
		hidePleaseWait(part);
		j('#livepreview #parts .'+part).css('display','none');
	} else {
		j('#livepreview #parts .'+part).css('display','block');
	}

	part_name = part.replace(/_.*$/, ""); // Treat border_1 like border

	//if(part_name != 'text' && part_name != 'personalization' && !load) // they handle themselves
	if(!load) // they handle themselves
	{
		if(dbg) console.log("NOT LOAD");
		j(document).ready(function() {
		updateViewLarger();
		});
		//updateBuild(part_name); // updates pricing/review, marks step complete
	}

	// ALWAYS update view larger
}

function showText(load)
{
	if(dbg) console.log("SHOW_T, UPDATES..."+load);

	var template = j('#template').val();
	//console.log("SHOWT="+load+", T="+template);

	var quote_id = j('input[name=data\\[options\\]\\[quoteID\\]]:checked').val();
	//console.log("QID="+quote_id);
	var custom_text = j('#option_quote').val();
	//console.log('c2='+j('#option_quote').get(0).class);
	//console.log('class='+j('#option_quote').clone().wrap('<div>').parent().html());

	if(j('#option_quote').hasClass('default_text'))
	{
		custom_text = '';
	}

	var textPos = j('#parts .text').size() ? 'text' : 'personalization';
	showPleaseWait(textPos);

	//console.log("TEMORIG="+j('#template').val());
	//console.log("TEM="+template);
	//console.log("QUID="+quote_id);
	//console.log("TEZT="+custom_text);

	//return;

	//console.log(j('#CatalogNumber').val());
	//console.log(j('#step_text').hasClass('complete_step'));


	// Don't change layout based on whether there is text or not -- show placeholder instead.
	return updateText('text',template,load);
} 

function updateText(part, template, load)
{
	if(dbg) console.log("UPDATE TEXT, LOAD="+load);

	if(window.saveTextId)
	{
		clearTimeout(window.saveTextId);
	}
	window.saveTextId = setTimeout("refreshText("+load+"); clearTimeout(window.saveTextId);", 100);
	 
	/*
	if(!load && part)
	{
		if(dbg) console.log("PNOTLOAD="+part);
		updateBuild(part);
	}
	*/
}

function refreshText(load) // this here submits form data and waits to call saveText after done.
{
	var data = j('#build_form').serialize();

	j.post("/build/save_ajax", data, function() { // stuff on the same step is synced with 'complete_step'. only inter-step changes are missing.
		saveText(load);
	});
}

function saveText(load)
{
	// If this is supposed to SAVE the text, it OUGHT to send a query and get a response FIRST.

	if(dbg) console.log("SAVE TEXT="+load);

	template = j('#template').val(); // How we set template now.
	var data = j('#build_form').serializeObject();

	if(j('#option_quote').hasClass('default_text'))
	{
		//console.log("DEFAULT_TEXT");
		data['data[options][customQuote]'] = ''; // Clear if just default.
	}
	//console.log(data);

	if(template == 'imageonly_nopersonalization') { template = 'imageonly'; }


	var textPrint = function() {
		if(dbg) console.log("PRINT _TEXT");
		var textPos = j('#parts .text').size() ? 'text' : 'personalization';
		if(dbg) console.log("POS="+textPos);

		j('#parts .'+textPos + " img").one('load', function() { updateBuild(); });

		setPart(textPos, "/product_image/print_text?rand="+(Math.random()*500000), load); // since print_text takes template as 1st arg, we must use QS for rand


		if(j('#template').val() == 'standard' && j('#border_2').size() && (!j('input[name=data\\[options\\]\\[borderID\\]]:checked').size() && !j('#border_-1').prop('checked'))) // Only change border if none set yet.
		{
			selectBorder('2',true);
		} 
	};

	if(load)
	{
		textPrint();
	} else { // updating...
		j.post("/build/save_text", data, function() {
			if(dbg) console.log("UPDATING TEXT");
			textPrint();
		});
	}
}

function reloadParts()
{
	//console.log("RELOAD_PARTS");
	j('div.step').trigger('showPart',[null, true]); // make sure we pass true so we dont mark steps as complete when we've just done the default...
}

function showPersonalization(load)
{
	if(dbg) console.log("SHOWP="+load);

	//return; // FOR NOW
	//return; // TODO FIX
	/*
		<? print_r($coords); ?>
	*/

	var hastext = <?= empty($coords['text']) ? 'false' : 'true' ?>;
	var double_sided = <?= empty($coords['image.2']) ? 'true' : 'false' ?>;
	var template = j('#template').val();
	var personalization = j('#personalizationInput').val();
	//console.log("T="+template+", HAS TEXT="+hastext);

	///////////if(load && !personalization) { return; } // no default text anymore.

	// we need to call either way since we may be tryin to update the personalization separately.

	// Switch layout if add/remove and no quotation possible
	if(personalization) { j('#personalizationAdd').attr('checked','checked'); }

	if(template == 'imageonly' && personalization && !hastext)
	{
		// don't explicitly set layout, so we're allowed to put pers on TOP of image, or zoom image fullbleed or less....
		////updateText('personalization','standard',load);
		updateText('personalization', null, load);
	} else if (double_sided && template == 'imageonly' && personalization && !hastext) {
		setCanvasNoPers(false);
		updateText('personalization', 'standard', load);
	} else if (double_sided && template == 'standard' && !personalization && !hastext) {
		setCanvasNoPers(true);
		updateText('personalization', 'imageonly', load);
	} else if (!personalization) {
		if(dbg) console.log("NO PERS");
		setCanvasNoPers(true);
		updateText('personalization', null, load);
	} else {	
		if(dbg) console.log("YES PERS");
		setCanvasNoPers(false);
		updateText('personalization', null, load);

	}

}

function setCanvasNoPers(nopers)
{
	var canvas_nopers = [
		'<?= $scaled_coords[$imgbox_nopers][0] ?>',
		'<?= $scaled_coords[$imgbox_nopers][1] ?>',
		'<?= $scaled_coords[$imgbox_nopers][2] ?>',
		'<?= $scaled_coords[$imgbox_nopers][3] ?>'
		];
	var canvas_pers = [
		'<?= $scaled_coords[$imgbox][0] ?>',
		'<?= $scaled_coords[$imgbox][1] ?>',
		'<?= $scaled_coords[$imgbox][2] ?>',
		'<?= $scaled_coords[$imgbox][3] ?>'
		];
	setCanvas(nopers ? canvas_nopers : canvas_pers);
}

function setCanvas(coords)
{
	/*
	// Change the coords of the picture inside the canvas (still let stretch more if wanted)
	if(j('#img').size())
	{
		var width = j('#img').css('width');
		var height = j('#img').css('height');
		var newwidth = width;
		var newheight = height;
		if(width > coords[2])
		{
			newwidth = coords[2];
			height = height * newwidth
			width = 
		}
		if(height
	}
	*/
}

//j('#live_preview').livepreview();

</script>

<?= $this->element("build/options/adjust"); ?>

<br/>

<div class="grey_border_top"><span></span></div>
<div class="grey_border_sides" align="center" style="">
		<? if(empty($build['Product']['is_stock_item']) && !empty($build['CustomImage'])) { ?>
		<div align="center" class="bold">
		<img src="/images/icons/hand-small.png" align="middle"> Drag your picture to adjust
		</div>
		<? } ?>

		<div id='livepreview' class="<?= $prod ?>">
			<img id="blankimg" src="<?= $blankimg ?>"/>

			<div id="canvas">
				<img id="img" src="<?= $image_path ?>" class="<?#= !empty($transimg) ? "hidden" : "" ?>"/>
			</div>
			<? if(!empty($canvas2)) { ?>
			<div id="canvas2">
				<img id="img2" src="<?= $image_path ?>" />
			</div>
			<? } ?>

			<? if(!empty($transimg)) { ?>
				<img id="transimg" src="<?= $transimg ?>" />
				<? if(!empty($transimg_gif)) { ?>
				<script>
				var ua = window.navigator.userAgent;
				if(ua.indexOf("MSIE 6") != -1)
				{
					$('transimg').src = "<?= $transimg_gif ?>";
				}
				</script>
				<? } ?>
			<? } ?>
			<? if(!empty($transimg_white)) { ?>
				<img id="transimg_white" src="<?= $transimg_white ?>" style="display:none;"/>
			<? } ?>
			<div class="background_color"></div>
			<div id="parts"></div>
			<? if(!empty($overlayimg)) { ?>
				<img id="overlayimg" src="<?= $overlayimg ?>" />
				<? if(!empty($overlayimg_gif)) { ?>
				<script>
				var ua = window.navigator.userAgent;
				if(ua.indexOf("MSIE 6") != -1)
				{
					$('overlayimg').src = "<?= $overlayimg_gif ?>";
				}
				</script>
				<? } ?>
			<? } ?>
			<img id="trans" src="/images/trans.gif" width="<?= $canvas[2]; ?>" height="<?= $canvas[3] ?>">
			<? if(!empty($canvas2)) { ?>
			<img id="trans2" src="/images/trans.gif" width="<?= $canvas[2]; ?>" height="<?= $canvas[3] ?>">
			<? } ?>
		</div>

		<a id="view_larger" style="text-decoration: none !important; " class="view_larger" rel="shadowbox;player=img" href="/product_image/build_view/-900x650.png?rand=<?= time(); ?>">+ View Larger</a>


</div>
<div class="grey_border_bottom"><span></span></div>
<script>
<? if(empty($build['Product']['is_stock_item']) && !empty($build['CustomImage'])) { ?>
	j('#livepreview').adjustable();
<? } ?>
</script>
