var stepNumber = 0;
(function($) {
	
	$.fn.assertMinimum = function(callback)
	{
		var qty = parseInt(j('#quantity').val());
		var minimum = parseInt(j('#minimum').val());
		if(qty && qty >= minimum)
		{
			if(typeof callback == 'function')
			{
				callback();
			}
			//j.loading(false);
			return true;
		//} else if (j('#quantity').val() === '') { 
		//		alert("Please enter a quantity");
		} else { 
			if(j('#quantity').val() == "")
			{
				alert("Please enter a quantity. Minimum is "+minimum);
			} else {
				alert("Minimum quantity is "+minimum);
			}
		}
		j('#quantity').focus().select();
		j.loading(false);
		return false;

	};

	$.fn.resetSide = function(side)
	{
		$.confirm("Are you sure you want to start this side over?", function() {
			j.loading();
			j('#side'+side).load("/designs/reset_side/"+side, null, function() {
				//console.log("CROPP=");
				//console.log(j('#1_crop_x').val()+","+j('#1_crop_y').val()+","+j('#1_crop_w').val()+","+j('#1_crop_h').val());
	
				j('#CustomImage'+side+'Filename').trigger('preview'); // remove picture.
	
				j('#side'+side+' :input').trigger('preview');
	
				/*j('#CustomImage'+side+'File').val(''); 
				*/
				j('#side'+side).trigger('visible'); // get image list to reload.
	
	
				j.loading(false);
			});

		}, "Yes", "No");
	};

	$.fn.setSides = function(sides)
	{
		j.loading();

	//console.log("S="+sides);

		// set hidden field of sides

		if(sides > 1) // Add side 2.
		{
		//console.log("SIDE2");
			// XXX load second side preview......
			j('#side2').load("/designs/side/2", j('#DesignForm').serializeObject(), function() {
				j.loading(false);
			});
		} else { // remove side 2
			// delete div.side1, remove #preview2
			j('#options .side2').remove();
			j('#preview2').html('');
			j('#DesignForm').save(function() {
				j.loading(false);
			});
		}

		// XXX TODO add/remove tabs and 2nd side parts/accordion
		//j.loading();
		//window.location = "/designs/add/sides:"+j(this).val();
	};

	$.fn.rotateProduct = function() // orientation is saved in form already....
	{
		j.loading();
		// Change product CSS
		//
		j('#PreviewCss').load("/designs/preview_css", j('#DesignForm').serializeObject(), function() {
			j('.preview .fullbleed img').trigger('reset');
			// reset quote, pers, border...
			// Reload parts, ie rotated pics, border, tassel
			j('#DesignForm :input').trigger('preview');

			j.loading(false);
		});
		
		// then there's getting the svg/png preview to work.
	};

	$.fn.changeProduct = function(productCode, img)
	{
		j.loading();
	
		// Check preview pics, if differs, reload preview first.
		var bgimg = j('#preview1').css('background-image');
		var re = new RegExp(img);
		if(!bgimg.match(re))
		{
			//console.log("DIFFERENT PICTURE");
			// Update side 1 (and maybe 2) preview
			j('#PreviewCss').load("/designs/preview_css", j('#DesignForm').serializeObject(), function() {
				j('.preview .fullbleed img').trigger('reset');

				$(this).changeProductForm(productCode);
			});
		} else {
			$(this).changeProductForm(productCode);
		}
	};

	$.fn.changeProductForm = function(productCode)
	{
		// We need to load the form after the preview, so items load.
		var callback = function() 
		{
			setTimeout(function() { j.loading(false); }, 2500);
		};
	
		j.post("/designs/form.json", j('#DesignForm').serializeObject(), function(response) {
			var sideCount = 0;
			for(var i = 0; i < response.steps.length; i++)
			{
				if(response.steps[i].length)
				{
					sideCount++;
				}
			}

			if(!sideCount)
			{
				callback();
			}

			for(var i = 0; i < response.steps.length; i++)
			{
				var side = i+1;
				j('#options #accordion'+side).loadSteps(response.steps[i], i+1, function() {
					//window.theSteps[i] = response.steps[i];
					if (--sideCount <= 0)
					{
						callback();
					}
				});
			}
	
			// Load css file. 
	
			// Now update preview CSS. (ie add/remove tassel, etc)
			//j('#PreviewCss').load("/designs/preview_css", j('#DesignForm').serializeObject(), function() {
	
				//hidePleaseWait();
	
				// Updating pricing....
				/*
				j.update_pricing(function() {
					j.loading(false);
				});
				*/
	
			//});
			// need to be able to add/remove parts. add-on-fly, and check against valid parts to remove invalids.
		});
	
		// reload pic, IF needed. (if other svg files exist)
	
		//j('#preview').removeClass('horizontal vertical').addClass(orientation);
		//
		j.update_pricing();
	};

	$.update_pricing = function(callback,review) {
		// XXX TODO assert minimum....
		//
		/*
		if(!j('#DesignForm').assertMinimum())
		{
			console.log("POOP");
			return;
		}
		*/

		j.loading();
		j('#DesignPricing').load("/designs/pricing", j('#DesignForm').serializeObject(), function() {
			if(typeof callback == 'function')
			{
				callback();
			} else {
				j.loading(false);
			}
		});
	};


	$.fn.loadSteps = function(steps,side, callback)
	{
	//console.log("UPDATING STEPS... for side="+side);
	//console.log(steps);
		if(!side) { side = 1; }

		// XXX TODO distinguish front and rear sides for each part.

		// load parts via json. so we can avoid flicker.
		// Deal with part accordian
		// if NOT already there, then 
		// this has to be in the proper order.
		var steps_found = [];

		var stepCount = steps.length;

		for(var i = 0; i < steps.length; i++)
		{
			var step = steps[i];
		//console.log("step: " + step);
		
		
			var stepName = step['Part']['part_code'];
			var prevStepName = i > 0 ? steps[i-1]['Part']['part_code'] : null;
			steps_found[steps_found.length] = stepName;

		//console.log(stepName);

			var part = (stepName == 'border') ? 'border-1' : stepName;

			// If preview div is not there, add.
			// NEED TO CATCH border-1, border-2, etc... as ok..
			//
		//console.log("CHECK PREV "+part);
			//console.log("CHECKING="+part);
			//console.log(j('#preview'+side+' .'+part));

			if(!j('#preview'+side+' .'+part).size())
			{
			//console.log("ADDING PREVIEW DIV FOR="+stepName);
				switch(stepName)
				{
					case 'quote':
					case 'personalization':
					case 'image':
						j('#preview'+side+' .fullbleed').append("<div class='"+stepName+"'></div>");
						break;
					default:
						j('#preview'+side+' .parts').append("<div class='"+stepName+"'></div>");
						break;
				}
			}

			// If step is not there, add. will initialize part.
			// Must insert relative to prior part, if any. for proper ordering.
			if(!j('#'+side+'_step_'+stepName).size())
			{
				// XXX TODO getting steps to load in right order, ie charm in middle.... and not mix up two sides.
				//
			//console.log("ADDING FORM STEP="+stepName);

				j.post("/designs/step/"+stepName+"/"+side, j('#DesignForm').serializeObject(), (function(i) { return function(html) { // timing matters.
				// Retrieve mini-form for step.
				//console.log("I="+i);
					var stepName = steps[i]['Part']['part_code'];
					var prevStepName = i > 0 ? steps[i-1]['Part']['part_code'] : null;
					var nextStepName = i+1 < steps.length ? steps[i+1]['Part']['part_code'] : null;

				//console.log("STEP="+stepName+", BF="+prevStepName);


					if(nextStepName && j('#'+side+'_step_'+nextStepName).size())
					{ // get full list and put before ones after...
						j('#'+side+'_header_'+nextStepName).before(html);

					} else if(prevStepName && j('#'+side+'_step_'+prevStepName).size()) {
						j('#'+side+'_step_'+prevStepName).after(html);
						// insert after previously found step.
					} else {
						j('#accordion'+side).append(html);
					}
					j('#accordion'+side).accordion('refresh');
					var inputs = j('#'+side+'_step_'+stepName).find(':input');
				//console.log("NEW IN ("+stepName+")=");
				//console.log(inputs);
					j(inputs).trigger('preview');

					j('#accordion'+side).trigger('refresh');

				}; })(i)
				);
			}
			

			if(--stepCount <= 0 && typeof callback == 'function')
			{
				callback();
			}
		}


		// Remove any extraneous steps.
		j('#accordion'+side+' .step').each(function(ix) {
			var num = ix+1;
			var id = j(this).attr('id').replace(/^([\d_]*)step_/,"");
		//console.log("OLD STEP GOPT="+id);
			if(j.inArray(id, steps_found) === -1) // not found.
			{
			//console.log("PART NO LONGER THERE="+side+"_"+id);

				j('#'+side+'_header_'+id).remove();
				j('#'+side+'_step_'+id).remove();
				// and remove piece from XML preview.
				// XXX TODO
				if(id == 'border')
				{
					j('#preview'+side+' .'+id+"-1").remove();
					j('#preview'+side+' .'+id+"-2").remove();
				} else {
					j('#preview'+side+' .'+id).remove();
				}
			}
		});

		// Fix prefix, separate since excluded some necessary.
		// needs to happen AFTER new steps are added.
		j('#accordion'+side+' .ui-accordion-header').each(function(ix) {
			var num = ix+1;
			var heading = j(this).text().replace(/^\d+[.] /, "");
			j(this).html(num+". "+ heading);
		});
		j('#accordion'+side).trigger('refresh');

	};


	$.fn.uploadify = function(settings)
	{
		var file = this;
		var container = j("<div></div>").css({
			position: 'relative',
			background: "url("+settings.image+") no-repeat",
			width: settings.width,
			height: settings.height,
			float: 'left',
			overflow: 'hidden'
		});

		j(file).css({
			position: 'absolute',
			cursor: 'pointer',
			opacity: 0,
			transform: "translate(-500px, 0px) scale(4)",
			//width: settings.width,
			//height: settings.height,
			fontSize: '24px',
			margin: 0,
			right: 0,
			top: 0,
		}).wrap(container);

		j(file).parent().after("<div class='clear'></div>");

	};

	$.fn.save = function(callback) // done on form.
	{
		clearTimeout(j(this).data('save_timeout'));
		// save only the most recent call. so data is most accurate.
		// waits for them to pause for 2 seconds.
		//
		if(typeof callback == 'function')
		{
			window.save_callback = callback; // there may be several calls, callbacks always need to be triggered.
		}

		j(this).data('save_timeout', setTimeout(function() {
			j.post("/designs/save", j('#DesignForm').serializeObject(), function() {
				if(typeof window.save_callback == 'function')
				{
					window.save_callback();
					window.save_callback = null;
				}
			});
		}, 2000));

		
	}


	$.fn.contain = function(padding) // object needs to be inside container. ie for text. if adding, will move up to make fit.
	{ // only bothers with vertical.
		// assumes position is relative to container
		//
		var container = j(this).parent();
		var cHeight = j(container).height();

		var text = this;
		//console.log(text);

		if(!padding) { padding = 0; }
		var y1 = j(text).position().top;
		var h = j(text).height();
		var y2 = y1 + h;

		//console.log("CH="+cHeight+", Y1="+y1+", H="+h+", Y2="+y2);

		/*if(y1 < 0)
		{
			j(text).css('top', 0+padding);
		}
		*/
		if(y2 > cHeight) // only not sticking over bottom matters...
		{
		//console.log("CONAIN="+cHeight+"-"+padding+"-"+h);
			j(text).css('top', cHeight - padding - h);
		} else if (y2 < cHeight-padding && !j(text).hasClass('dragged')) { // all fits inside already, 
			j(text).css('top', '');
			var defaultTop = parseInt(j(text).css('top'));
			var newTop = cHeight - padding - h;

			// We may have moved explicitly by dragging, in which case we should not touch position

			// move top position as close to default as possible while still fitting whole thing.
			// moves back down to normal when shrinking.
			if(defaultTop && top < defaultTop)
			{
			//console.log("NEWTOP="+newTop+", "+top+" < "+defaultTop);
				j(text).css('top', newTop);
			} else if(defaultTop != y1) { // reset top to previous/existing.
				// don't explicitly set when in class settings. 
				j(text).css('top', y1);
			}
		}

		// We may need to move content back toward edge (bottom) as the lines are deleted and gap widens.
	};

	$.fn.resetImageZoomAndDrag = function(fullbleed)
	{
		var side = j(this).closest('.preview').attr('id').replace(/^preview/, "");
		j('#'+side+'_crop_x').val(null);
		j('#'+side+'_crop_y').val(null);
		j('#'+side+'_crop_w').val(null);
		j('#'+side+'_crop_h').val(null);
		j(this).loadImageZoomAndDrag(null, fullbleed);
	};

	$.fn.loadImageZoomAndDrag = function(disabled,default_fullbleed) {
		var side = j(this).closest('.preview').attr('id').replace(/^preview/, "");

		var fullbleed = j(this).closest('.preview').find('.fullbleed');

		// load defaults (existing).
		var x = j('#'+side+'_crop_x').val();
		var y = j('#'+side+'_crop_y').val();
		var w = j('#'+side+'_crop_w').val();
		var h = j('#'+side+'_crop_h').val();


		// fix offset...
		if(x) { x-= j(fullbleed).position().left; }
		if(y) { y-= j(fullbleed).position().top; }

		//console.log("XYWH="+x+","+y+","+w+","+h);

		//console.log("IMGZD="+j(this).attr('src'));

		// src is OLD picture....
		//

		var picture = this;
		var default_container = j(this).closest('.preview').find(default_fullbleed?'.fullbleed':'.standard');


	//console.log("LOAD IMAGE ZOOM AND DRAG FOR SIDE="+side);
	//
		var std_x = j('.standard').position().left - j(fullbleed).position().left; // relative to viewable fullbleed.
		var std_y = j('.standard').position().top - j(fullbleed).position().top;
		var std_height = j('.standard').height();
		var std_width = j('.standard').width();
	
		var default_x = j(default_container).position().left - j(fullbleed).position().left; // relative to viewable fullbleed.
		var default_y = j(default_container).position().top - j(fullbleed).position().top;

		// reset. esp when reloading pics.
		j(picture).width('auto');
		j(picture).height('auto');

		var default_height = j(default_container).height();
		var default_width = j(default_container).width();
		var picture_height = j(picture).height();
		var picture_width = j(picture).width();
		var picture_w2h = picture_width/picture_height;

	//console.log("PicW="+picture_width);
	//console.log("PicH="+picture_height);
	
		var ph = default_height;
		var pw = ph * picture_w2h;

		if(pw < default_width && default_fullbleed)
		{
			pw = default_width;
			ph = pw / picture_w2h;
		}
		else if(pw > default_width)
		{
			pw = default_width;
			ph = pw / picture_w2h;
		}

		var minh = std_height/3; // consider pic may be really wide, needs more zoom

		var px = (default_width - pw)/2 + default_x;
		var py = (default_height - ph)/2 + default_y;

	//console.log("DEFx="+std_x+" + ("+std_width+" - "+pw+")/2="+px);
	//console.log("DEFy="+std_y+" + ("+std_height+" - "+ph+")/2="+py);
	//console.log("DEFw="+pw);
	//console.log("DEFh="+ph);
	//
		//console.log("C="+x+","+y+","+w+","+h);
		//console.log("P="+px+","+py+","+pw+","+ph);
	
		// get default positioning.
		// if numbers are 0 (ie pic on edge), etc this could throw it all off..
		var coords = [
			isNumeric(x)?x:px,
			isNumeric(y)?y:py,
			isNumeric(w)?w:pw,
			isNumeric(h)?h:ph
		];

		/*
	//console.log("COORDS=");
	//console.log(coords);
	//console.log(x);
	//console.log(y);
	//console.log(w);
	//console.log(h);
		*/

		// or if super wide, make fit so width can go into half.
		//
	
		j(fullbleed).zoomAndDraggable({
			coords: coords,
			img: '.image img',
			slider: '#zoomPicture'+side,
			minh: minh,
			callback: function(x,y,w,h)
			{
			//console.log("ZOOMANDDRAG="+x+","+y+","+w+","+h);

				x+= j(fullbleed).position().left;
				y+= j(fullbleed).position().top;


				j('#'+side+'_crop_x').val(parseInt(x));
				j('#'+side+'_crop_y').val(parseInt(y));
				j('#'+side+'_crop_w').val(parseInt(w));
				j('#'+side+'_crop_h').val(parseInt(h));

				j('#DesignForm').save();
			}
		});
		if(disabled) // dont enable by default
		{
			j(picture).draggable('disable');
			j(picture).resizable('disable');
		}

	};

	/* enabling/disabling of draggable */
	$.fn.designDraggable = function(custom_opts)
	{
		var opts = {
			start: function(event, ui) {
				ui.helper.addClass('dragging');
			},
			stop: function(event, ui) {
				// save coords somewhere in form...
				if(typeof custom_opts.callback == 'function')
				{
					custom_opts.callback(ui.position.left, ui.position.top);
				}
				ui.helper.addClass('dragged'); // so we know explicitly moved.
				ui.helper.removeClass('dragging');
			}
		};
		opts = $.extend(opts, custom_opts);
	
		return $(this).draggable(opts);
	};

	$.fn.enableDraggable = function(constraints)
	{
		var draggable = this;
		var parent = j(draggable).parent();

		$(this).each(function() {
			//console.log(constraints);

			var prefix = $(this).attr('id').replace(/^(\d+_)/,""); // quote, etc.

			var side = j(this).closest('.preview').attr('id').replace(/^preview/, "");
			var fullbleed = j(this).closest('.preview').find('.fullbleed');

		//console.log("SIDE FOR draggable="+side);
		//console.log(this);
		//console.log("PREF="+prefix);


			$(this).designDraggable({containment: fullbleed, // needs to be exact object, otherwise gets first side container by accident.
				drag: function(e,ui) {
					if(constraints && constraints.length == 4) // restrict to bounds
					{ // [x1,y1,x2,y2]
						//console.log("CONSTRINTED=");
						//console.log(constraints);
						//console.log(ui.position.left+", "+ui.position.top);
						var x1 = parseInt(constraints[0]);
						var y1 = parseInt(constraints[1]);
						var x2 = parseInt(constraints[2]);
						var y2 = parseInt(constraints[3]);

						// XXX TOMAS_MALY TODO

						if(ui.position.top < y1)
						{
							ui.position.top = y1;
						} else if (ui.position.top > y2) {
							ui.position.top = y2;
						}
						if(ui.position.left < x1) {
							ui.position.left = x1;

						} else if (ui.position.left > x2) {
							ui.position.left = x2;
						}
					}
				},
				callback: function(x,y) {
					x += parent.position().left;
					y += parent.position().top;

				//console.log("SAVING TO="+prefix+"_y");

					//console.log("SAVING="+x+", "+y);
		
					$('#'+side+"_"+prefix+'_x').val(x);
					$('#'+side+"_"+prefix+'_y').val(y);

					j('#DesignForm').save();
				}
			});

			// while we're at it, pre-load existing coordinates...
			var x = parseInt($('#'+side+"_"+prefix+'_x').val());
			var y = parseInt($('#'+side+"_"+prefix+'_y').val());

			if(isNumeric(x)) { x -= j(parent).position().left; }
			if(isNumeric(y)) { y -= j(parent).position().top; }

			if(isNumeric(x)) { j('#'+side+"_"+prefix).css('left', x); }
			if(isNumeric(y)) { j('#'+side+"_"+prefix).css('top', y); }

		});

		return this;
	};

	$.fn.designResizable = function(custom_opts)
	{
		var opts = {
			start: function(event, ui) {
				ui.helper.addClass('dragging');
			},
			stop: function(event, ui) {
				// save coords somewhere in form...
				if(typeof custom_opts.callback == 'function')
				{
					custom_opts.callback(ui.position.left, ui.position.top);
				}
				ui.helper.addClass('dragged'); // so we know explicitly moved.
				ui.helper.removeClass('dragging');
			}
		};
		opts = $.extend(opts, custom_opts);
	
		return $(this).draggable(opts);
	};

	$.fn.enableResizable = function()
	{
		var resizable = this;

		$(this).each(function() {
			/*$(this).designResizable(
			
			);
			*/
		});
	};


	$.fn.showPart = function(items, key) {
		j(this).html('').removeClass('enabled');
		if(key && !(key < 0))
		{
			var src = items[key];
			var img = "<img src='"+src+"'/>"; // non object so in both.
			j(this).html(img).addClass('enabled');
		}
	};

	$.fn.draggable_overlay = function() {

		$(this).bind('mouseup click mousedown mousemove', function(e) {
		// perhaps a bit too slow for IE....
			
			evt = e || window.event;
			// propagate until reach a "dynamic" object.
			//
			//console.log(evt);
			
			var x = evt.pageX;
			var y = evt.pageY;
		
			//var target = j.touching({x: x, y: y}, 'img.dynamic:visible, div.dynamic:has(*):has(:visible)').last();
			var target = j.touching({x: x, y: y}, 'img.dynamic.enabled, div.dynamic.enabled').last();
		//console.log

			if(target.size())
			{
				j(target).trigger(e);
				//console.log(target);
				//console.log(e.type);
				// XXX need tweaking with mouse cursor as move
				j(this).css('cursor', j(target).css('cursor'));
			} else {
				j(this).css({cursor: 'auto'});
			}
		
			if(e.type == 'mousemove')
			{
			}
		
		//	j(this).show();
		});

	};

	$.fn.colorpicker = function(params) {
		var field = this;
		var default_opts = {
			preferredFormat: "hex",
			showInput: true,
			clickoutFiresChange: 1,
			showPalette: 1,
			showInput: 1,
			palette: [
			        ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)", /*"rgb(153, 153, 153)","rgb(183, 183, 183)",*/
			        "rgb(204, 204, 204)", "rgb(217, 217, 217)", /*"rgb(239, 239, 239)", "rgb(243, 243, 243)",*/ "rgb(255, 255, 255)"],
			        ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
			        "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
			        ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
			        "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
			        "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
			        "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
			        "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
			        "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
			        "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
			        "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
			        /*"rgb(133, 32, 12)", "rgb(153, 0, 0)", "rgb(180, 95, 6)", "rgb(191, 144, 0)", "rgb(56, 118, 29)",
			 *         "rgb(19, 79, 92)", "rgb(17, 85, 204)", "rgb(11, 83, 148)", "rgb(53, 28, 117)", "rgb(116, 27, 71)",*/
			        "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
			        "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
			]
		};
		var opts = $.extend({}, default_opts, params);

		$(field).spectrum(opts);

		// to manually set, call spectrum('set', color)

	};
	

})(jQuery);
