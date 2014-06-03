(function($) {
	console.log("loading designer.js");
	$.fn.initialize_centerize = function() 
	{
		var width = j(this).width();
		var x = j(this).position().left;
		var center = width/2;
		//console.log("INIT CENTERIZE, X="+x+", W="+width+", CENTER="+(x+width/2));
		j(this).data('centerize-width', width);
		return this;
	};

	$.fn.centerize = function() // keep text centered ..... may be moved, so depends on 
	{
		// as they type, keep center point the same.
		// initialize on page load, designate width into 'data'

		var id = j(this).attr('id');

		var x = j(this).position().left;

		var current_text = j(this).text();


		// We need to clear the old x-position (to 0) to get maximum width
		//j(this).css("left", 0);

		// Reset width, so we can make it wider as they type, in case it's been explicitly set from saved design...
		j(this).css('width','');

		var width = j(this).width();
		//console.log("WIDHT="+width);

		var container_width = j(this).parent().width();

		if(width > container_width)
		{
			var buffer = 10; // pixels....
			width = container_width - buffer;
			j(this).width(width);
		}

		var text = j(this).text();

		// XXX center is a tad bit too much to the right.... ie off by 1 char....
		
		var previous_width = parseFloat(j(this).data('centerize-width')); // typing...

		//console.log("PREVIOUS_WIDTH="+previous_width);

		var fb_x = j(this).parent().position().left;
		var fb_y = j(this).parent().position().top;
		var fb_w = j(this).parent().width();
		var previous_text = j(this).data('centerize-text');
		var previous_x = j('#'+id+'_x').val();

		// we need to set the DEFAULT 'x', so as we type, we are centered!
		if(!previous_text)
		{
			x = fb_w/2;
		}

		if(isNumeric(previous_width))
		{
			//console.log("X="+x+", PW="+previous_width);
			var previous_center = x + previous_width/2;


			// adjust X to left by (new_width-old_width)/2

			var new_x = previous_center - width/2;//x + (previous_width-width)/2;
			//console.log("NEW_X="+new_x+"="+x+"+("+previous_width+"-"+width+")/2");

			// If typing and center action spills over side, nudge back inside.
			if (new_x+width > fb_w) { 
				new_x = fb_w-width;
				//console.log("TOO FAR OVER, NEW_X="+new_x);
			} 
			if(new_x < 0) { 
				//console.log("TOO FAR LEFT, NEW_X=0");
				new_x = 0; 
			}

			x = new_x;

			

			j(this).data('centerize-width', width); // save new width.


			// Save coordinate field.
			if(previous_text && previous_text != current_text) { // text has changed.
				//console.log("TYPING TO RECENTER, PREV != WID="+previous_width+" != "+width);
				j('#'+id+'_x').val(new_x+fb_x);
				// Move content over
				//
				// change width!!!
			} else if(previous_x) { // load saved coordinate.
				x = previous_x - fb_x;
				//console.log("SETTING SAVED LEFT @ "+x+" (prev_x-fb_x)="+previous_x+"-"+fb_x);
			} else { // center for the hell of it.
				x = (fb_w-width)/2;

			}
			j('#'+id+'_width').val(width);
			//console.log("SET_LEFT="+x);
			j(this).css('left', x); // minus parent, since relative to it.
			//j('#DesignForm').save(); // delayed
			j(this).data('centerize-text', current_text);
		}

		return this; // Nothing for now.

	};
	
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
	
				j('#side'+side+' :input').trigger('reset').trigger('preview'); // must reset coordinates too.
	
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

	console.log("S="+sides);

		// set hidden field of sides

		if(sides > 1) // Add side 2.
		{
		console.log("SIDE2");
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
		console.log("designer.js : fn.rotateProduct");
		j.loading();
		// Change product CSS
		//
		j('#PreviewCss').load("/designs/preview_css", j('#DesignForm').serializeObject(), function() {
			//j('.preview .fullbleed img').trigger('reset');
			// reset quote, pers, border...
			// Reload parts, ie rotated pics, border, tassel
			j('#DesignForm :input').trigger('reset'); // should implicitly call 'preview'

			// width should be cleared...

			// overlays should resize too... to default.
			

			// Reload 2nd side thumb, if there. or first.
			var thumb2 = j('#side2thumb img');
			if(thumb2.size())
			{
				thumb2.attr('src', "/designs/png/2?reset_coords=1&rand="+(Math.random()*100000))
			}
			var thumb1 = j('#side1thumb img');
			if(thumb1.size())
			{
				thumb1.attr('src', "/designs/png/1?reset_coords=1&rand="+(Math.random()*100000))
			}

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
				//j('#DesignForm :input').trigger('reset'); // should implicitly call 'preview'
				//j('.preview .fullbleed img').trigger('reset');
				//
				j('#DesignForm :input').trigger('reset'); // should implicitly call 'preview'
				// EVERYTHING (that's already there) needs to be reset, shouldn't keep position of text/etc if different shape.
				//
				$(this).changeProductForm(productCode, function() {
					// may add/remove steps.
					//j('#CustomImage1Filename, #CustomImage2Filename').trigger('reset');
				});
			});
		} else {
			$(this).changeProductForm(productCode);
		}
	};

	$.fn.changeProductForm = function(productCode, cb)
	{
		// We need to load the form after the preview, so items load.
		var callback = function() 
		{
			setTimeout(function() { j.loading(false); }, 2500);
			if(typeof cb == 'function')
			{
				cb();
			}
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
	console.log("loadSteps: steps: " + steps);
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
		//console.log(step);
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
			console.log("ADDING FORM STEP="+stepName);

				j.post("/designs/step/"+stepName+"/"+side, j('#DesignForm').serializeObject(), (function(i) { return function(html) { // timing matters.
				// Retrieve mini-form for step.
				//console.log("I="+i);
					var stepName = steps[i]['Part']['part_code'];
					var prevStepName = i > 0 ? steps[i-1]['Part']['part_code'] : null;
					var nextStepName = i+1 < steps.length ? steps[i+1]['Part']['part_code'] : null;

				console.log("STEP="+stepName+", BF="+prevStepName);


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
				console.log("NEW IN ("+stepName+")=");
				console.log(inputs);
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
			top: 0
		}).wrap(container);

		j(file).parent().after("<div class='clear'></div>");

	};

	$.fn.save = function(callback) // done on form.
	{
		//if(typeof callback == 'function') { return callback(); }
		//return; // XXX for now

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
		if(!j(this).size()) { return this; } // could be removed for switching products...
		if(!padding) { padding = 0; }

		// this only moves up when we're typing beyond the bottom.
		// check for _y field, assume that's the position.
		// if that's not set, then go via position()
		// only change _y field when seems needing to change!
		// the _y position DOES have extra pixels added from the parent, since it's absolute to the edge.

		var parent = j(this).parent();
		var parent_height = j(parent).height();
		var parent_y = j(parent).position().top;

		var text = this;
		var id = j(text).attr('id');

		var y1 = parseFloat(j('#'+id+'_y').val());
		//console.log("SAVED_Y="+y1);
		if(!y1)
		{
			y1 = j(text).position().top; // default
		} else { // Consider parent as saved param includes.
			y1 -= parent_y;
		}

		var h = j(text).height();
		var y2 = y1 + h;

		//console.log("Y1="+y1);

		//console.log("Y2="+y2+" > PH="+parent_height);

		var top = y1;
		if(y2 > parent_height) // only not sticking over bottom matters...
		{
		//console.log("CONAIN="+cHeight+"-"+padding+"-"+h);
			top = parent_height - padding - h;
			// too far down.
			j(text).css('top', top);
			//console.log("SETTING "+id+"_y TO="+(top+parent_y));
			j('#'+id+"_y").val(top+parent_y); // Adjust y coordinate in form, if any. Relative to parent!
		}



		// We may need to move content back toward edge (bottom) as the lines are deleted and gap widens.
		return this;
	};

	$.fn.resetImageZoomAndDrag = function(fullbleed)
	{
		// reset coords for BOTH sides.... (for reset thumb of other side)
		// cakephp doesnt do classes on hidden fields, tho.
		j('#1_crop_x, #2_crop_x').val('');
		j('#1_crop_y, #2_crop_y').val('');
		j('#1_crop_w, #2_crop_w').val('');
		j('#1_crop_h, #2_crop_h').val('');

		// But only preview THIS side...
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
		else if(pw > default_width && !default_fullbleed)
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
		var coords = (isNumeric(w) && w > 0 && isNumeric(h) && h > 0) ?
			[x,y,w,h] : [px,py,pw,ph]

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
			
				j(fullbleed).find('.image img').trigger('updated');
				// for overlay adjustment.

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
					custom_opts.callback(ui.position.left, ui.position.top, ui.helper.width(), ui.helper.height());
				}
				ui.helper.addClass('dragged'); // so we know explicitly moved.
				ui.helper.removeClass('dragging');

				ui.helper.trigger('updated'); // move overlay, etc.
			}
		};
		opts = $.extend(opts, custom_opts);
	
		return $(this).draggable(opts);
	};

	$.fn.enableDraggable = function(constraints)
	{
		//console.log("ENABLE_DRAGGABLE=");
		//console.log(this);

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

			//console.log("FOR="+j(this).attr('id'));
			//console.log(constraints);

			// containment below doesn't consider MARGIN set on item...

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
				callback: function(x,y,w) {
					x += parent.position().left;
					y += parent.position().top;

				//console.log("SAVING TO="+prefix+"_y");

					//console.log("SAVING="+x+", "+y);
		
					$('#'+side+"_"+prefix+'_x').val(x);
					$('#'+side+"_"+prefix+'_y').val(y);

					$('#'+side+"_"+prefix+'_width').val(w);

					j('#DesignForm').save();
				}
			});

			// while we're at it, pre-load existing coordinates...
			var x = parseInt($('#'+side+"_"+prefix+'_x').val());
			var y = parseInt($('#'+side+"_"+prefix+'_y').val());
			var w = parseInt($('#'+side+"_"+prefix+'_width').val());

			if(isNumeric(x)) { x -= j(parent).position().left; }
			if(isNumeric(y)) { y -= j(parent).position().top; }

			if(isNumeric(x)) { j('#'+side+"_"+prefix).css('left', x); }
			if(isNumeric(y)) { j('#'+side+"_"+prefix).css('top', y); }
			if(isNumeric(w)) { j('#'+side+"_"+prefix).width(w); }

			//console.log("SETTING "+prefix+"="+x+","+y);

		});

		return this;
	};

	$.fn.matchShape = function(src, higher)
	{
		var target = this;
		/*
		console.log(src);
		console.log(j(src).attr('id'));
		console.log(j(target).attr('id'));
		*/
		//if(!j(src).is(":visible")) { j(src).show(); }

		target.css({
			position: 'absolute',
			top: j(src).position().top, // ie bug where offsetParent fails (unspecified error) when absolutely positioned....
			left: j(src).position().left,
			width: j(src).width(),
			height: j(src).height(),
		});
		if(higher)
		{
			target.css({zIndex: parseInt(j(src).css('zIndex'))+1000});
		}

		return target;
	};

	$.fn.designResizable = function(custom_opts)
	{
		var target_id = j(this).attr('id').replace(/_overlay$/, "");
		var opts = {
			handles: "e, w", // just to the right/left.
			//alsoResize: j('#'+target_id), // w00t!
			resize: function(e,ui) {
				j('#'+target_id).matchShape(ui.helper);
				//console.log(ui.helper);

				if(custom_opts && typeof custom_opts.resize == 'function') // also call custom stuff..
				{
					custom_opts.resize();
				}
			},
			stop: function(e,ui) { // update hidden fields...
				var parent = ui.helper.parent();
				//console.log(parent.position().left);

				j('#'+target_id+"_x").val(ui.helper.position().left + parent.position().left);
				j('#'+target_id+"_y").val(ui.helper.position().top + parent.position().top);
				j('#'+target_id+"_width").val(ui.helper.width());

				j('#DesignForm').save();
			}
		}; // containment in caller
		opts = $.extend(opts, custom_opts);
	
		return $(this).resizable(opts);
	};

	$.fn.enableResizable = function(custom_opts) // MUST be done on overlays itself.
	{
		var fullbleed = j(this).closest('.overlays');

		var opts = {
			containment: fullbleed
		};

		opts = $.extend(opts, custom_opts);

		$(this).each(function() {
			$(this).designResizable(custom_opts);
		});
	};


	$.fn.showPart = function(items, key) {
		j(this).html('').removeClass('enabled');
		var overlay = j(this).attr('id')+"_overlay";
		if(key && !(key < 0))
		{
			var src = items[key];
			var img = "<img src='"+src+"'/>"; // non object so in both.
			j(this).html(img).show().addClass('enabled');
			j('#'+overlay).show();
		} else {
			// hide.
			//j(this).hide();
			// dont hide thing, just make it invisible. but hide overlay. causes issues with border placement. etc
			// we need visibility to properly align elsewhere.
			j(this).html('').show().removeClass('enabled');
			j('#'+overlay).hide();
		}
	};

	$.fn.draggable_overlay = function() { // called on target, it clones an overlay.
		// XXX TODO create for EACH. 
		var target = this;
		var id = j(target).attr('id');
		var side = j(target).closest('.preview').attr('id').replace(/^preview/, "");

		if(!id)
		{
			id = "target"+parseInt(Math.random()*10000);
			j(target).attr('id',id);
		}
		//console.log(target);
		var overlay_id = id+"_overlay";
		//console.log(overlay_id);

		// We need a separate group layer for the overlays, at the same level as the product overlay....
		var overlay = j('#'+overlay_id);

		var overlays = $(target).closest('.preview').find('.overlays');

		if(!j(overlay).size())
		{
			var overlay = $("<div id='"+overlay_id+"' class='draggable_overlay' style='display: none;'></div>");
			// hidden until preview triggered by targets
			$(overlays).append(overlay);
		}

		// clone size/shape
		//console.log(j(target).css('zIndex'));
		//console.log($(overlay).css('zIndex'));

		$(target).bind('updated', function() {
			// overlay needs to refresh.
			$(overlay).matchShape(target,true);

			// if target is hidden or empty, we need to hide too
			if($(target).is("img") && $(target).attr('src') && !$(target).attr('src').match(/trans[.]gif/))
			{
				//console.log("SHOWING OVERLAY img");
				$(overlay).show();
			} else if ($(target).is(":visible") && $(target).html()) { 
				//console.log("SHOWING OVERLAY html");
				$(overlay).show();
			} else {
				//console.log("HIDING OVERLAY");
				$(overlay).hide();
			}
		});

		$(target).trigger('updated'); // initially.

		$(overlay).bind('mouseout', function(e) {
			j(target).removeClass('hover');
		});

		$(overlay).bind('mouseup click mousedown mousemove', function(e) {
		// perhaps a bit too slow for IE....
			
			evt = e || window.event;
			// propagate until reach a "dynamic" object.
			//
			//console.log(evt);
			
			var x = evt.pageX;
			var y = evt.pageY;

			j('.preview *.hover').removeClass('hover');

			if(target.size())
			{
				// XXX slider todo...
				
				// XXX maybe 'drag' operation should affect US?
				j(target).trigger(e); // pass movement along...
				j(overlay).css('cursor', j(target).css('cursor'));
				j(target).addClass('hover');
			} else {
				j(overlay).css({cursor: 'auto'});
			}
		});
		return overlay;
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
