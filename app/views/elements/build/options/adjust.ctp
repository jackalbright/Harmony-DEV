<? if(empty($build['Product']['is_stock_item']) && !empty($build['CustomImage'])) { ?>
<h3 class="grey_header" style="text-align: center;"><span>Position Your Picture</span></h3>

<div align="center" class="grey_border">

<script>
var start_event = null;
var finish_event = null;
var dragging = false;
var dragged = false;
var timeoutId = 0;

function startDrag(e)
{
	//console.log(e);
	window.dragging = true;
	window.dragged = true;
	window.start_event = e;//Event.extend(e);
	window.finish_event = null;
	return true;
}

function doDrag(e)
{
	//console.log(e);
	window.finish_event = e;//Event.extend(e);
	if(window.dragging)
	{
		//console.log("DRAG");
		moveImage();
		
		/*
		clearTimeout(timeoutId);
		timeoutId = setTimeout("moveImage()", 20);
		*/
	} else if (dragged) { // Get one last position after mouse up.
		//console.log("DONE DRAG");

		window.dragging = false;
		window.dragged = false;
		//moveImage();
		/*clearTimeout(timeoutId);
		timeoutId = setTimeout("moveImage()", 20);
		*/
	}
	return false;
}

function endDrag(e)
{
	if(window.dragging)
	{
	window.dragging = false;
	window.finish_event = e;//Event.extend(e);

	//trackEvent(e, 'IMAGE MOVE'); 

	/*
	clearTimeout(timeoutId);
	timeoutId = setTimeout("moveImage()", 20);
	*/
	moveImage();
	}
	return true;
}

function moveImage()
{
	var x1 = parseInt($('img').getStyle("left"));
	var y1 = parseInt($('img').getStyle("top"));
	var w = parseInt($('img').getStyle("width"));
	var h = parseInt($('img').getStyle("height"));

	var dx = window.finish_event.clientX-start_event.clientX;
	var dy = window.finish_event.clientY-start_event.clientY;

	window.start_event = window.finish_event; // Start next move where left off. don't double/exaggerate.

	var ix1 = x1+dx;
	var iy1 = y1+dy;

	var ix2 = ix1+w;
	var iy2 = iy1+h;

	// Not adjust constraints so cant move too far off canvas.
	var cx1 = 0;//parseInt($('canvas').getStyle('left'));
	var cy1 = 0;//parseInt($('canvas').getStyle('top'));
	// image is relative to canvas!
	var cw = parseInt($('canvas').getStyle('width'));
	var ch = parseInt($('canvas').getStyle('height'));
	var cx2 = cx1 + cw;
	var cy2 = cy1 + ch;

	// Keep picture constrained within canvas, so dont add padding

	//alert( "PIC="+ix1+","+iy1+"="+ix2+","+iy2 + "CANVAS="+cx1+","+cy1+"="+cx2+","+cy2);

	// For each side, if a side sticks inside the canvas,
	// and the opposite side sticks out, move toward edge
	// until that side hits the edge or other side hits edge or is inside

	//alert(ix1+" > "+cx1+", "+ix2 + ">"+cx2);

	// ALLOW for moving off canvas, up to 25% left. even for super wide images, canvas can be 3/4 blank

	// too far right
	while(ix1 > cx1 && ix2 > cx2 && ix1 > cx2-(cx2-cx1)/4)
	{
		ix1--;
		ix2--;
	}
	//alert("NOW="+ix1+", "+iy1);
	// too far left
	while(ix2 < cx2 && ix1 < cx1 && ix2 < cx1+(cx2-cx1)/4)
	{
		ix1++;
		ix2++;
	}
	// too far below
	while(iy1 > cy1 && iy2 > cy2 && iy1 > cy2-(cy2-cy1)/4)
	{
		iy1--;
		iy2--;
	}
	// too far above
	while(iy1 < cy1 && iy2 < cy2 && iy2 < cy1+(cy2-cy1)/4)
	{
		iy1++;
		iy2++;
	}


	//alert("MOVING "+x1+ ", "+y1+", TO="+ix1+", "+iy1);
	// is this relative to before, or absolute?
	$('img').setStyle({top: iy1+"px", left: ix1+"px"});
	if($('img2'))
	{
		$('img2').setStyle({top: iy1+"px", left: ix1+"px"});
	}
	//alert("DID="+$('img').getStyle('left')+", "+$('img').getStyle('top'));
	setCoords();
}

function zoom(newh)
{
	//printStackTrace();
	var w2h = parseFloat($('imgw2h').value);
	var w = parseInt($('img').getStyle('width'));
	var h = parseInt($('img').getStyle('height'));
	if(Math.abs(newh-h) < 3) { return; } // Not doing anything.
	//console.log("ZOOM TO NEW HEIGHT="+newh+", OLD_HEIGHT="+h);

	var ix = parseInt($('img').getStyle('left'));
	var iy = parseInt($('img').getStyle('top'));

	var cw = parseInt($('canvas').getStyle('width'));
	var ch = parseInt($('canvas').getStyle('height'));
	//alert("WID="+neww+", HEIGHT="+newh);

	var minw = parseInt($('minwidth').value);
	var minh = parseInt($('minheight').value);

	// Apply.
	$('img').setStyle({height: newh+"px"});
	if($('img2'))
	{
		$('img2').setStyle({height: newh+"px"});
	}

	// WHEN onSlide is called, the #'s alternate...

	recenterImage(ix,iy,w,h);

}

function rotateImageClockwise(id)
{
	var angle = parseInt($('rotate').value);
	if(angle >= 270) { angle = 0; }
	else { angle += 90; }

	$('rotate').value = angle;
	var w2h = parseFloat($('imgw2h').value);
	var new_w2h = 1/w2h; // Invert, since, rotating.
	$('imgw2h').value = new_w2h;

	var full_imgwidth = parseFloat($('full_imgwidth').value);
	var full_imgheight = parseFloat($('full_imgheight').value);
	$('full_imgheight').value = full_imgwidth;
	$('full_imgwidth').value = full_imgheight;

	var w = parseInt($('img').getStyle('width'));
	var h = parseInt($('img').getStyle('height'));


	showPleaseWait();

	$('img').src = "/product_image/image_rotate/"+id+"/"+angle;
	// May need to adjust position?
	if($('img2'))
	{
		$('img2').src = "/product_image/image_rotate/"+id+"/"+angle;
	}

	// Now grow it until it fits best.
	// XXX MAYTBE it doesnt get coords for new image, but keeps old until new one is done loading??

	$('img').observe('load', function() { $('img').setStyle({height: w+"px"}); centerImage(); updateSliderValues(h,w); hidePleaseWait(); });
	if($('img2'))
	{
		$('img2').observe('load', function() { $('img2').setStyle({height: w+"px"}); hidePleaseWait(); });
	}

	
}

function updateSection(section)
{
	var div = $('part_settings_'+section);
	if(!div) { return; }
	new Ajax.Updater(div,"/build/step/"+section, {asynchronous: true, evalScripts: true});
}

function createSliderValuesList(w, h)
{
	var maxfactor = 1.5;
	var imageonly = '<?= $imageonly ?>';
	var canvash = parseInt('<?= $canvas[3] ?>');
	var canvasw = parseInt('<?= $canvas[2] ?>');
	var portrait = (canvash > canvasw);

	var w2h = w/h; 
	// We need to know custom image's ratio, so we
	// can gauge whether fullbleeding or not....

	var heightvalue = h;

	var range = [];
	var fullbleeding = false;

	// Should have NOTHING to do with image, other than verifying fullbleed
	// imgw >= canvasw && imgh >= canvash

	// Start with HALF the size of fit. whatever that means.
	// if canvas is portrait, start with half the width
	// if canvas landscape, start with half the height.
	// XXX TODO

	var fullbled = false;

	var incr = 20;

	// START so we can shrink to both half width AND half height
	var scaledh = Math.floor(canvasw / w2h);
	if(scaledh > canvash)
	{
		scaledh = canvash;
		scaledw = Math.floor(w2h / canvash);
	}

	for(var ih = scaledh/2; ih <= canvash*maxfactor || (imageonly && !fullbled); ih += incr)
	{
		if(ih % 2 != 0) { ih++; } // Ensure is even.
		// This may not always work for keeping img from moving left
		// since width of image could be odd...
		var iw = Math.floor(ih*w2h);
		range[range.length] = ih;
		if(iw > canvasw*maxfactor) { fullbled = true; }
	}

	//console.log("NEW SLIDER ("+w+","+h+")="+range);
	return range;
}

function updateSliderValues(w,h)
{
	if(window.slider) { window.slider.dispose(); }
	// Eliminate duplicate calls to zoom() after rotating.

	var sliderValue = h;
	//console.log("UPDATE_SLIDER_VALUES="+h);

	var sliderValuesList = createSliderValuesList(w,h);

	window.slider = new Control.Slider('handle1','track1', { 
		range: $R(sliderValuesList.min(), sliderValuesList.max()),
		//minimum: sliderValuesList.min(),
		//maximum: sliderValuesList.max(),
		values: sliderValuesList,
		sliderValue: sliderValue,
		onSlide: function(v) { zoom(v); },
		onChange: function(v) { zoom(v); } 
		// onSlide required to give live zoom before unclick.
	});
}

function rotateImageCounterClockwise(id)
{
	var angle = parseInt($('rotate').value);
	if(angle <= 0) { angle = 270; }
	else { angle -= 90; }

	$('rotate').value = angle;
	var w2h = parseFloat($('imgw2h').value);
	var new_w2h = 1/w2h; // Invert, since, rotating.
	$('imgw2h').value = new_w2h;

	var full_imgwidth = parseFloat($('full_imgwidth').value);
	var full_imgheight = parseFloat($('full_imgheight').value);
	$('full_imgheight').value = full_imgwidth;
	$('full_imgwidth').value = full_imgheight;


	var w = parseInt($('img').getStyle('width'));
	var h = parseInt($('img').getStyle('height'));


	showPleaseWait();

	$('img').src = "/product_image/image_rotate/"+id+"/"+angle;
	if($('img2'))
	{
		$('img2').src = "/product_image/image_rotate/"+id+"/"+angle;
	}

	// Now grow it until it fits best.
	$('img').observe('load', function() { $('img').setStyle({height: w+"px"}); updateSliderValues(h,w); centerImage(); hidePleaseWait(); });
	if($('img2'))
	{
		$('img2').observe('load', function() { $('img2').setStyle({height: w+"px"}); hidePleaseWait(); });
	}
}

function recenterImage(ix,iy,w,h) // Adjust center of 'new' image based on center of old.
{
	// Recenter according to center of image.
	//return;

	var neww = parseInt($('img').getStyle('width'));
	var newh = parseInt($('img').getStyle('height'));

	// Adjust x by half of the difference of w, y by half the diff of h
	var newx = ix + ((w - neww)/2);
	var newy = iy + ((h - newh)/2);
	// If the image changes position when it's small, we risk affecting coordinates worse.
	// NOT rounding makes it work better.
	/*
	if(console)
	{
		console.log("LEFT=("+w+"-"+neww+")/2 + "+ix +"="+newx);
	}
	*/

	// will likely always have odd pixel-off issue if zoom back and forth, 
	// simply because of small number of pixels and wrong approximation.
	//console.log("RECENTER TO="+newx+","+newy+", FROM="+w+","+h);

	$('img').setStyle({left: newx+"px", top: newy+"px"});
	if($('img2'))
	{
		$('img2').setStyle({left: newx+"px", top: newy+"px"});
	}
	setCoords();
}

function centerImage()
{
	// Now move coordinates so stay on center.
	var ih = parseInt($('img').getStyle('height'));
	var iw = parseInt($('img').getStyle('width'));
	var cw = parseInt($('canvas').getStyle('width'));
	var ch = parseInt($('canvas').getStyle('height'));
	var newx = Math.floor((cw - iw)/2);
	var newy = Math.floor((ch - ih)/2);

	//alert("IW,IH="+iw+","+ih+"; CW,CH="+cw+","+ch+"; NEWX,Y="+newx+","+newy);

	$('img').setStyle({left: newx+"px", top: newy+"px"});
	if($('img2'))
	{
		$('img2').setStyle({left: newx+"px", top: newy+"px"});
	}

	setCoords();
}

function setCoords()
{
	var template = $('template').value;
	if(template == 'imageonly_nopersonalization') { template = 'imageonly'; }
	if(template != 'imageonly') { template = 'standard'; }

	var ix = parseInt($('img').getStyle('left'));
	var iy = parseInt($('img').getStyle('top'));
	var iw = parseInt($('img').getStyle('width'));
	var ih = parseInt($('img').getStyle('height'));

	var cw = parseInt($('canvas').getStyle('width'));
	var ch = parseInt($('canvas').getStyle('height'));

	var full_imgwidth = parseFloat($('full_imgwidth').value);
	var full_imgheight = parseFloat($('full_imgheight').value);
	var factor = full_imgwidth / iw;

	var visw = cw * full_imgwidth / iw;
	var vish = ch * full_imgheight / ih;

	$('coord_x').value = Math.floor(-ix * factor); 
	$('coord_y').value = Math.floor(-iy * factor);
	$('coord_w').value = Math.floor(visw);
	$('coord_h').value = Math.floor(vish);

	// Save crop info in data format, so image refreshes (new options) show updated coordinates.
	if($('crop_'+template+'_0')) { $('crop_'+template+'_0').value = $('coord_x').value; }
	if($('crop_'+template+'_1')) { $('crop_'+template+'_1').value = $('coord_y').value; }
	if($('crop_'+template+'_2')) { $('crop_'+template+'_2').value = $('coord_w').value; }
	if($('crop_'+template+'_3')) { $('crop_'+template+'_3').value = $('coord_h').value; }

	// when we zoom in, w,h should get smaller, zoom out, w,h bigger

	// AJAX submission... (timeout-based!)
	if(timeoutId > 0) { clearTimeout(timeoutId); }
	timeoutId = setTimeout("submitCoords()", 500);
}

function submitCoords()
{
	var x = $('coord_x').value;
	var y = $('coord_y').value;
	var w = $('coord_w').value;
	var h = $('coord_h').value;
	var rotate = $('rotate').value;
	//alert("SAVING COORDS");

	new Ajax.Request("/build/ajax_save_coords", { asynchronous: true, method: 'post', parameters: { "data[x]": x, "data[y]": y, "data[w]": w, "data[h]": h, "data[rotate]": rotate, "data[layout]": '<?= $build['template'] ?>'}, onComplete: function() { 
		//updateSection('layout'); 
	}});

	// Update view larger link so image accurate.
	updateViewLarger();

	//updateSection('layout'); // should do it here since we have saved rotate
}

function resetAdjust()
{

	// Rotate as needed

	if($('rotate').value != '0')
	{
		$('imgw2h').value = "<?= $imgw2h ?>";
		$('img').src = "<?= $image_path ?>";
		if($('img2'))
		{
			$('img2').src = "<?= $image_path ?>";
		}
	}
	

	// Scale down.
	var fitwidth = parseInt("<?= $fitwidth ?>");
	//slider.options.values[0];
	window.slider.setValue(fitwidth);

	// Move picture to center.
	var iw = parseInt($('img').getStyle('width'));
	var ih = parseInt($('img').getStyle('height'));
	var cw = parseInt($('canvas').getStyle('width'));
	var ch = parseInt($('canvas').getStyle('height'));

	ix = Math.floor((cw-iw)/2);
	iy = Math.floor((ch-ih)/2);


	$('img').setStyle({top: iy+"px", left: ix+"px"});

	setCoords();
}



</script>
		<style>
		#track1
		{
			background: url("/images/slider-images-track-right.png") no-repeat scroll right top transparent;
		}
		#track1-left {
			background: url("/images/slider-images-track-left.png") no-repeat scroll left top transparent;
			height: 9px;
			position: absolute;
			width: 5px;
		}
		</style>
		<?
		$toolbox = 1;
		?>

		<? if($toolbox == 1) { ?>
		<div id="adjust_controls" class="">
		<table cellpadding=0 cellspacing=0 width="100%">
		<tr>
			<td width="50%" align="center" colspan=3 style="font-weight: bold;">
				ZOOM
				<br/>
				<table cellpadding=0 cellspacing=0>
				<tr>
					<td>
						<a class="ignore" href="Javascript:void(0)" onClick="setSliderValue(-1);"><img align="middle" src="/images/buttons/small/Rotate-button-minus.gif"/></a>
					</td>
					<td>
					<div align="left">
						<div id="track1" style="width: 75px; height: 9px;">
							<div id="track1-left"></div>
							<div id="handle1" class="selected" style="width: 19px; height: 20px; left: 0px; position: relative;">
								<img style="float: left;" src="/images/slider-images-handle.png"/>
							</div>
						</div>
						<div class="clear"></div>
					</div>
					</td>
					<td>
						<a class="ignore" href="Javascript:void(0)" onClick="setSliderValue(1);"><img align="middle" src="/images/buttons/small/Rotate-button-plus.gif"/></a>
					</td>
				</tr>
				</table>
				

			</td>
			<td align="center" colspan=3 style="font-weight: bold;">
				ROTATE
				<br/>
				<a class="" href="Javascript:void(0)" onClick="return rotateImageCounterClockwise('<?= $imgid ?>'); "><img align="middle" src="/images/buttons/small/Rotate-button-left-grey.gif"/></a>
				&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
				<a class="" href="Javascript:void(0)" onClick="return rotateImageClockwise('<?= $imgid ?>'); "><img align="middle" src="/images/buttons/small/Rotate-button-right-grey.gif"/></a>
				<div class="clear"></div>
			</td>
		</tr>
		</table>




		<!--<a id="view_larger" style="text-decoration: none !important; " class="view_larger" rel="shadowbox;player=img" href="/product_image/build_view/-900x650.png?rand=<?= time(); ?>">+ View Larger</a>-->
		<script>
			var sliderValuesList = createSliderValuesList('<?= $imgwidth ?>', '<?= $imgheight ?>');
			var sliderValue = <?= $imgheight; ?>;
			//console.log("SLID_VAL="+sliderValue);

			window.slider = new Control.Slider('handle1','track1', { 
				range: $R(sliderValuesList.min(), sliderValuesList.max()),
				//minimum: sliderValuesList.min(),
				//maximum: sliderValuesList.max(),
				values: sliderValuesList,
				sliderValue: sliderValue,
				onSlide: function(v) { zoom(v); },
				//onChange: function(v,s) { trackEvent(s.event, 'SLIDER ZOOM'); zoom(v); } // something broken, s.event not defined.
				onChange: function(v,s) { zoom(v); } 
			});

			function setSliderValue(direction)
			{
				var current = window.slider.value;
				var values = window.slider.options.values;
				var newvalue = current;
				//alert("CUR="+current);
				//alert("VALUES="+values);

				for(i = 0; i < values.length; i++)
				{
					if(values[i] == current)
					{
						if(direction > 0 && i < values.length-1)
						{
							newvalue = values[i+1];
						} else if (direction < 0 && i > 0) {
							newvalue = values[i-1];
						}
						break;
					}
				} // Get nearest actual value based on current.

				//console.log("SET_SLIDER_VALUE="+newvalue);

				window.slider.setValue(newvalue);
			}
		</script>
		<script>
		<? if(empty($this->params['isAjax'])) { ?>
		Event.observe(window,'load', function() {
			//console.log("SETTING UP VIEWLARGER");
			window['Shadowbox'].setup("#view_larger");
		});
		<? } else { ?>
		j(document).ready(function() {
		window['Shadowbox'].setup("#view_larger");
		});
		<? } ?>
		</script>
		<? if(false && empty($build['Product']['is_stock_item']) && !empty($build['CustomImage'])) { ?>
		<br/>
		<br/>
		<div>
		<a href="Javascript:void(0)" onClick="centerImage();">Center picture</a>
		</div>
		<? } ?>
		</div>
		<? } else if($toolbox == 2) { ?>
		<div id="adjust_controls" class="">
		<table cellpadding=0 cellspacing=0>
		<tr>
		<tr>
			<td align="center" colspan=3 style="font-weight: bold;">
			<span class="green" style="font-variant: small-caps;">First</span> Zoom your picture
			</td>
		</tr>
		<tr>
		<td>
			<a class="ignore" href="Javascript:void(0)" onClick="setSliderValue(-1);"><img align="middle" src="/images/buttons/small/Rotate-button-minus.gif"/></a>
		</td>
		<td>
		<div align="left">
			<div id="track1" style="width: 200px; height: 9px;">
				<div id="track1-left"></div>
				<div id="handle1" class="selected" style="width: 19px; height: 20px; left: 0px; position: relative;">
					<img style="float: left;" src="/images/slider-images-handle.png"/>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		</td>
		<td>
			<a class="ignore" href="Javascript:void(0)" onClick="setSliderValue(1);"><img align="middle" src="/images/buttons/small/Rotate-button-plus.gif"/></a>
		</td>
		</tr>
		</table>
		<br/>

		<script>
			var sliderValuesList = createSliderValuesList('<?= $imgwidth ?>', '<?= $imgheight ?>');
			var sliderValue = <?= $imgheight; ?>;
			//console.log("SLID_VAL="+sliderValue);

			window.slider = new Control.Slider('handle1','track1', { 
				range: $R(sliderValuesList.min(), sliderValuesList.max()),
				//minimum: sliderValuesList.min(),
				//maximum: sliderValuesList.max(),
				values: sliderValuesList,
				sliderValue: sliderValue,
				onSlide: function(v) { zoom(v); },
				//onChange: function(v,s) { trackEvent(s.event, 'SLIDER ZOOM'); zoom(v); } // something broken, s.event not defined.
				onChange: function(v,s) { zoom(v); } 
			});

			function setSliderValue(direction)
			{
				var current = window.slider.value;
				var values = window.slider.options.values;
				var newvalue = current;
				//alert("CUR="+current);
				//alert("VALUES="+values);

				for(i = 0; i < values.length; i++)
				{
					if(values[i] == current)
					{
						if(direction > 0 && i < values.length-1)
						{
							newvalue = values[i+1];
						} else if (direction < 0 && i > 0) {
							newvalue = values[i-1];
						}
						break;
					}
				} // Get nearest actual value based on current.

				//console.log("SET_SLIDER_VALUE="+newvalue);

				window.slider.setValue(newvalue);
			}
		</script>

		<div align="center">
			<a href="Javascript:void(0)" onClick="return rotateImageCounterClockwise('<?= $imgid ?>'); "><img align="middle" src="/images/buttons/small/Rotate-button-left-grey.gif"/></a>
			<span class="bold"> Rotate your picture </span>
			<a href="Javascript:void(0)" onClick="return rotateImageClockwise('<?= $imgid ?>'); "><img align="middle" src="/images/buttons/small/Rotate-button-right-grey.gif"/></a>
		</div>


		<a id="view_larger" style="text-decoration: none !important; " class="view_larger" rel="shadowbox;player=img" href="/product_image/build_view/-900x650.png?rand=<?= time(); ?>">+ View Larger</a>
		<script>
		<? if(empty($this->params['isAjax'])) { ?>
		Event.observe(window,'load', function() {
			//console.log("SETTING UP VIEWLARGER");
			window['Shadowbox'].setup("#view_larger");
		});
		<? } else { ?>
		j(document).ready(function() {
		window['Shadowbox'].setup("#view_larger");
		});
		<? } ?>
		</script>
		<? if(empty($build['Product']['is_stock_item']) && !empty($build['CustomImage'])) { ?>
		<br/>
		<br/>
		<div>
		<a href="Javascript:void(0)" onClick="centerImage();">Center picture</a>
		</div>
		<? } ?>
		<br/>
		<br/>

		</div>
		<? } else if($toolbox == 3) { ?>
		<div id="adjust_controls" class="">
		<table cellpadding=0 cellspacing=0>
		<tr>
		<tr>
			<td align="center" colspan=3 style="font-weight: bold;">
			<span class="green" style="font-variant: small-caps;">First</span> Zoom your picture
			</td>
		</tr>
		<tr>
		<td>
			<a class="ignore" href="Javascript:void(0)" onClick="setSliderValue(-1);"><img align="middle" src="/images/buttons/small/Rotate-button-minus.gif"/></a>
		</td>
		<td>
		<div align="left">
			<div id="track1" style="width: 200px; height: 9px;">
				<div id="track1-left"></div>
				<div id="handle1" class="selected" style="width: 19px; height: 20px; left: 0px; position: relative;">
					<img style="float: left;" src="/images/slider-images-handle.png"/>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		</td>
		<td>
			<a class="ignore" href="Javascript:void(0)" onClick="setSliderValue(1);"><img align="middle" src="/images/buttons/small/Rotate-button-plus.gif"/></a>
		</td>
		</tr>
		</table>
		<br/>

		<script>
			var sliderValuesList = createSliderValuesList('<?= $imgwidth ?>', '<?= $imgheight ?>');
			var sliderValue = <?= $imgheight; ?>;
			//console.log("SLID_VAL="+sliderValue);

			window.slider = new Control.Slider('handle1','track1', { 
				range: $R(sliderValuesList.min(), sliderValuesList.max()),
				//minimum: sliderValuesList.min(),
				//maximum: sliderValuesList.max(),
				values: sliderValuesList,
				sliderValue: sliderValue,
				onSlide: function(v) { zoom(v); },
				//onChange: function(v,s) { trackEvent(s.event, 'SLIDER ZOOM'); zoom(v); } // something broken, s.event not defined.
				onChange: function(v,s) { zoom(v); } 
			});

			function setSliderValue(direction)
			{
				var current = window.slider.value;
				var values = window.slider.options.values;
				var newvalue = current;
				//alert("CUR="+current);
				//alert("VALUES="+values);

				for(i = 0; i < values.length; i++)
				{
					if(values[i] == current)
					{
						if(direction > 0 && i < values.length-1)
						{
							newvalue = values[i+1];
						} else if (direction < 0 && i > 0) {
							newvalue = values[i-1];
						}
						break;
					}
				} // Get nearest actual value based on current.

				//console.log("SET_SLIDER_VALUE="+newvalue);

				window.slider.setValue(newvalue);
			}
		</script>

		<div align="center">
			<a href="Javascript:void(0)" onClick="return rotateImageCounterClockwise('<?= $imgid ?>'); "><img align="middle" src="/images/buttons/small/Rotate-button-left-grey.gif"/></a>
			<span class="bold"> Rotate your picture </span>
			<a href="Javascript:void(0)" onClick="return rotateImageClockwise('<?= $imgid ?>'); "><img align="middle" src="/images/buttons/small/Rotate-button-right-grey.gif"/></a>
		</div>


		<a id="view_larger" style="text-decoration: none !important; " class="view_larger" rel="shadowbox;player=img" href="/product_image/build_view/-900x650.png?rand=<?= time(); ?>">+ View Larger</a>
		<script>
		<? if(empty($this->params['isAjax'])) { ?>
		Event.observe(window,'load', function() {
			//console.log("SETTING UP VIEWLARGER");
			window['Shadowbox'].setup("#view_larger");
		});
		<? } else { ?>
		j(document).ready(function() {
		window['Shadowbox'].setup("#view_larger");
		});
		<? } ?>
		</script>
		<? if(empty($build['Product']['is_stock_item']) && !empty($build['CustomImage'])) { ?>
		<br/>
		<br/>
		<div>
		<a href="Javascript:void(0)" onClick="centerImage();">Center picture</a>
		</div>
		<? } ?>
		<br/>
		<br/>

		</div>
		<? } else if($toolbox == 4) { ?>
		<div id="adjust_controls" class="">
		<table cellpadding=0 cellspacing=0>
		<tr>
		<tr>
			<td align="center" colspan=3 style="font-weight: bold;">
			<span class="green" style="font-variant: small-caps;">First</span> Zoom your picture
			</td>
		</tr>
		<tr>
		<td>
			<a class="ignore" href="Javascript:void(0)" onClick="setSliderValue(-1);"><img align="middle" src="/images/buttons/small/Rotate-button-minus.gif"/></a>
		</td>
		<td>
		<div align="left">
			<div id="track1" style="width: 200px; height: 9px;">
				<div id="track1-left"></div>
				<div id="handle1" class="selected" style="width: 19px; height: 20px; left: 0px; position: relative;">
					<img style="float: left;" src="/images/slider-images-handle.png"/>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		</td>
		<td>
			<a class="ignore" href="Javascript:void(0)" onClick="setSliderValue(1);"><img align="middle" src="/images/buttons/small/Rotate-button-plus.gif"/></a>
		</td>
		</tr>
		</table>
		<br/>

		<script>
			var sliderValuesList = createSliderValuesList('<?= $imgwidth ?>', '<?= $imgheight ?>');
			var sliderValue = <?= $imgheight; ?>;
			//console.log("SLID_VAL="+sliderValue);

			window.slider = new Control.Slider('handle1','track1', { 
				range: $R(sliderValuesList.min(), sliderValuesList.max()),
				//minimum: sliderValuesList.min(),
				//maximum: sliderValuesList.max(),
				values: sliderValuesList,
				sliderValue: sliderValue,
				onSlide: function(v) { zoom(v); },
				//onChange: function(v,s) { trackEvent(s.event, 'SLIDER ZOOM'); zoom(v); } // something broken, s.event not defined.
				onChange: function(v,s) { zoom(v); } 
			});

			function setSliderValue(direction)
			{
				var current = window.slider.value;
				var values = window.slider.options.values;
				var newvalue = current;
				//alert("CUR="+current);
				//alert("VALUES="+values);

				for(i = 0; i < values.length; i++)
				{
					if(values[i] == current)
					{
						if(direction > 0 && i < values.length-1)
						{
							newvalue = values[i+1];
						} else if (direction < 0 && i > 0) {
							newvalue = values[i-1];
						}
						break;
					}
				} // Get nearest actual value based on current.

				//console.log("SET_SLIDER_VALUE="+newvalue);

				window.slider.setValue(newvalue);
			}
		</script>

		<div align="center">
			<a href="Javascript:void(0)" onClick="return rotateImageCounterClockwise('<?= $imgid ?>'); "><img align="middle" src="/images/buttons/small/Rotate-button-left-grey.gif"/></a>
			<span class="bold"> Rotate your picture </span>
			<a href="Javascript:void(0)" onClick="return rotateImageClockwise('<?= $imgid ?>'); "><img align="middle" src="/images/buttons/small/Rotate-button-right-grey.gif"/></a>
		</div>


		<a id="view_larger" style="text-decoration: none !important; " class="view_larger" rel="shadowbox;player=img" href="/product_image/build_view/-900x650.png?rand=<?= time(); ?>">+ View Larger</a>
		<script>
		<? if(empty($this->params['isAjax'])) { ?>
		Event.observe(window,'load', function() {
			//console.log("SETTING UP VIEWLARGER");
			window['Shadowbox'].setup("#view_larger");
		});
		<? } else { ?>
		j(document).ready(function() {
		window['Shadowbox'].setup("#view_larger");
		});
		<? } ?>
		</script>
		<? if(empty($build['Product']['is_stock_item']) && !empty($build['CustomImage'])) { ?>
		<br/>
		<br/>
		<div>
		<a href="Javascript:void(0)" onClick="centerImage();">Center picture</a>
		</div>
		<? } ?>
		<br/>
		<br/>

		</div>
		<? } ?>

		<input type="hidden" id="rotate" name="data[rotate]" value="<?= !empty($build['rotate']) ? $build['rotate'] : 0 ?>"/>

		<input type="hidden" id="imgw2h" name="imgw2h" value="<?= $imgw2h ?>"/>
		<input type="hidden" id="minwidth" name="minwidth" value="<?= $fitwidth*0.5 ?>"/>
		<input type="hidden" id="minheight" name="minheight" value="<?= $fitheight*0.5?>"/>
		<input type="hidden" id="full_imgwidth" name="full_imgwidth" value="<?= $full_imgwidth ?>"/>
		<input type="hidden" id="full_imgheight" name="full_imgheight" value="<?= $full_imgheight ?>"/>
		<input type="hidden" id="coord_x" name="coord_x" value="<?= $coordx ?>" size="5"/>
		<input type="hidden" id="coord_y" name="coord_y" value="<?= $coordy ?>" size="5"/> 
		<input type="hidden" id="coord_w" name="coord_w" value="<?= $coordw ?>" size="5"/> 
		<input type="hidden" id="coord_h" name="coord_h" value="<?= $coordh ?>" size="5"/>

		<br/>

		<? #print_r($build['crop']); ?>

		<!-- need to save crop coords for ALL layouts, so we don't lose when switchin back and forth -->
		<? if(!empty($build['crop'])) { ?>
			<? foreach($build['crop'] as $temp =>$coords) { if(!is_array($coords)) { continue; } # Skip other stuff ?>
				<? foreach($coords as $ix => $coord) { ?>
					<input id="crop_<?= $temp ?>_<?= $ix ?>" type="hidden" name="data[crop][<?= $temp ?>][<?=$ix?>]" value="<?= $coord ?>"/>
				<? } ?>
			<? } ?>
		<? } ?>

</div>
<? } ?>
