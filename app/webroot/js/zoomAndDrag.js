(function($) {
$.fn.zoomAndDraggable = function(custom_opts)
{
	var canvas = this;
	$(canvas).addClass('cropper');

	if(typeof custom_opts.canvas_init == 'function')
	{
		custom_opts.canvas_init(canvas);
		// ie adjustment of size as needed, etc. - before image reacts.
	}

	var img = custom_opts.img ? $(canvas).find(custom_opts.img) : $(canvas).children('img').first();

	var slider = custom_opts.slider ? $(custom_opts.slider) : null;
	/*$('.slider');
	if(!slider.size())
	{
		var slider = $("<div class='slider'></div>");
		$(canvas).after(slider);
	}
	// never add since causes other problems.
	*/

	var defaults = {
		coords: null, // [x,y,w,h]
		callback: null // func passes [x,y,w,h]
	};

	var options = $.extend(defaults, custom_opts);
	
	function snapToCanvas(position) // dont let go off edge unless zoomed in (sticking over other side)
	{
		// can be used to translate params for css() setting
		// since image may grow.
		var imgw = $(img).width();
		var imgh = $(img).height();
		var cw = $(canvas).width();
		var ch = $(canvas).height();

		// dont left it go off box unless other side is still on/outside box. (ie zoomed)
		var imgx1 = position.left;
		var imgy1 = position.top;
		var imgx2 = imgx1 + imgw;
		var imgy2 = imgy1 + imgh;

		//console.log("CW,H="+cw+","+ch +"; IX1,Y1,X2,Y2="+imgx1+","+imgy1+","+imgx2+","+imgy2);

		// Don't let go too far.
		// setting false cause the thing to abort, ie cant correct.
		// so must adjust!

		// XXX seems to restrict left/right but not up/down

		// XXX needs tweaking...

		// not too far left.
		if(imgw < cw) // if narrower, dont let y1 < 0
		{
			if(imgx1 < 0)
			{
				position.left = 0;
			}
		} else { // if wider, dont let y2 < cw
			if(imgx2 < cw)
			{
				position.left = cw-imgw;
			}
		}

		// not too far right.
		if(imgw < cw)  // narrower, dont let x2 > cw
		{
			if(imgx2 > cw)
			{
				position.left = cw-imgw;
			}
		} else { // wider, dont let x1 > 0
			if(imgx1 > 0)
			{
				position.left = 0;
			}

	
		}

		// not too far up.
		// if equal/smaller height, and y1 < 0, stop at y1=0
		if(imgh < ch) // shorter, dont let y1 < 0
		{
			if(imgy1 < 0)
			{
				position.top = 0;
			}
		} else { // taller height. dont let y2 < h 
			if(imgy2 < ch)
			{
				position.top = ch-imgh;
			}
		}

		// not too far down.
		if(imgh < ch) // smaller, dont let imgy2 > ch
		{
			if(imgy2 > ch)
			{
				position.top = ch-imgh;
			}
		} else { //larger, dont let y1 > 0
			if(imgy1 > 0)
			{
				position.top = 0;
			}
		}

		//console.log("Y1="+imgy1+", Y2="+imgy2+" > H="+ch+", IH <> CH="+imgh+", "+ch);

		return position; // in case needed to be passed to css()
	};

	function initDraggable()
	{
		// if image is exact size, restrict wont let move.
		// if too small, needs moving around
		// if too big, needs moving around.
		j(img).draggable({
			start: function(e,ui) {
				j(img).addClass('dragging');
			},
			stop: save,
			drag: function(e,ui) {
				return snapToCanvas(ui.position);
			}
		});

	}

	function initZoom(options)
	{
		$(slider).parent().hide();
		var orig_imgw = $(img).data('original-width');
		var orig_imgh = $(img).data('original-height');

		var canw = $(canvas).width();
		var canh = $(canvas).height();

		//console.log(orig_imgw +">"+canw +" || "+orig_imgh +">"+canh);

		// Only enable zoom sometimes
		if(true || orig_imgw > canw || orig_imgh > canh) // if wont be blurry
		{
			// values range from fit inside (w or h)
			// to max size as long as < original

			var owidth = $(img).data('original-width');
			var oheight = $(img).data('original-height');
			var imgw2h = owidth / oheight;

			maxh = oheight*1.25; // never allow blurry.

			if(options.minh)
			{
				minh = options.minh;
			} else {
				minh = canh;
				if(canw < canh)
				{
					minh = parseInt(canw/imgw2h);
				}
				// min width fits by height.
				if(oheight < minh) // super small
				{
					minh = oheight;
				}

			}

			//console.log("MXH="+maxh);
			//console.log("MH="+minh);

			//if(minh == maxh) { return; } // cant zoom anyway.
				


			defaulth = $(img).height(); // current.

			//console.log("SLIDER=");

			// Gather zoom constraints.
			var slider_opts = {
				min: minh,
				max: maxh,
				value:defaulth, // may retrieve from db fields...
				step: 10, // better for x,y changes
				slide: function(e,ui) {
					// Handle change, ie image scale.
					var val = ui.value;
					zoom(val);
				}
			};

			//console.log(slider);
			//console.log(slider_opts);

			$(slider).slider(slider_opts);
			$(slider).parent().show();

			// now add draggable to object.
			/*
			console.log("RESIZABLE, "+minh+"=>"+maxh);
			$(img).resizable({
				handles: 'n, e, w, s',
				aspectRatio: true,
				maxHeight: maxh,
				minHeight: minh,
				resize: function(e,ui)
				{
					// adjust slider.
					$(slider).slider('value', $(img).height());
				},
				stop: function(e,ui)
				{
					// adjust slider.
					$(slider).slider('value', $(img).height());
					save();
				},

			});
			*/

		}
	}

	function fit() // puts in center and fits by width (longer side)
	{
		var canw = $(canvas).width();
		var canh = $(canvas).height();
		var oldw = $(img).width();
		var oldh = $(img).height();
		var owidth = $(img).data('original-width');
		var oheight = $(img).data('original-height');
		var imgw2h = owidth/oheight;

		var imgh = canh;
		var imgw = Math.ceil(imgh * imgw2h);

		// Make sure bleeding.
		if(imgw < canw)
		{
			imgw = canw;
			imgh = Math.ceil(imgw / imgw2h);
		}

		//console.log("IW,H="+imgw+","+imgh+", CANW,H="+canw+","+canh);

		var imgy = Math.floor(canh/2 - imgh/2);
		var imgx = Math.floor(canw/2 - imgw/2);

		$(img).height(imgh);
		$(img).width(imgw);
		$(img).css({top: imgy, left: imgx});

		// sync with slider...
		$(slider).slider('value', imgh);

		save();
	};

	function fullsize() // puts in center and goes back to original size
	{
		var canw = $(canvas).width();
		var canh = $(canvas).height();
		var oldw = $(img).width();
		var oldh = $(img).height();
		var owidth = $(img).data('original-width');
		var oheight = $(img).data('original-height');
		var imgw2h = owidth/oheight;
		
		var imgw = owidth;
		var imgh = oheight;

		//console.log("IW,H="+imgw+","+imgh+", CANW,H="+canw+","+canh);

		var imgy = Math.floor(-imgh/2 + canh/2);
		var imgx = Math.floor(-imgw/2 + canw/2);

		//console.log("X,Y="+imgx+","+imgy);

		$(img).height(imgh);
		$(img).width(imgw);
		$(img).css({top: imgy, left: imgx});

		// sync with slider...
		$(slider).slider('value', imgh);


		save();
	};

	function clearwarn(msg) {
	};

	function warnsize() { // on init.
		var canw = $(canvas).width();
		var canh = $(canvas).height();
		var imgw = $(img).data('original-width');
		var imgh = $(img).data('original-height');
		if(imgw >= canw && imgh >= canh) { return; }

		var warnid = $(canvas).attr('id')+"_warning";
		var warndiv = $("#"+warnid);

		warndiv.html("Uploaded picture is smaller ("+imgw+"x"+imgh+") than available box ("+canw+"x"+canh+"), so size and placement is limited");
		warndiv.addClass('warn');
	};

	function center() // puts in center and fits by height
	{
		var canw = $(canvas).width();
		var canh = $(canvas).height();
		var oldw = $(img).width();
		var oldh = $(img).height();
		var owidth = $(img).data('original-width');
		var oheight = $(img).data('original-height');
		var imgw2h = owidth/oheight;

		var imgh = canh;
		var imgw = imgh * imgw2h;
		var imgy = Math.floor(canh/2 - imgh/2);
		var imgx = Math.floor(canw/2 - imgw/2);

		$(img).css({width: imgw, height: imgh, top: imgy, left: imgx});

		// sync with slider...
		$(slider).slider('value', imgh);

		save();
	};

	function zoom(heightval)
	{
		var oldw = $(img).width();
		var oldh = $(img).height();
		var oldx = $(img).position().left;
		var oldy = $(img).position().top;
		var canw = $(canvas).width();
		var canh = $(canvas).height();

		var imgw2h = $(img).data("original-width") / $(img).data("original-height");

		// Set height to val, then readjust center.
		var widthval = imgw2h * heightval;


		$(img).css({height: heightval, width: widthval});
		var neww = $(img).width();
		var newh = $(img).height();
		// Figure out height from width. If less than container, then set width so fits height instead.

		var diffw = neww - oldw;
		var diffh = newh - oldh;

		//console.log("DIFFW,H="+diffw+","+diffh);

		var newx = Math.ceil(oldx - diffw/2);
		var newy = Math.ceil(oldy - diffh/2);
		$(img).css(snapToCanvas({top: newy, left: newx}));
		// XXX need to pass top/left to the constraint tool, so it snaps it in place immediately.

		//console.log("NEWX,Y="+newx+","+newy);

		save();
	};

	function move(e, x,y)
	{
		// Go to x,y

		$(img).css({top: y, left: x});

		//console.log("MOVE="+x+","+y);

		save();
	};

	function save(id)
	{
		var imgx = parseInt($(img).css('left'));//position().left;
		var imgy = parseInt($(img).css('top'));//position().top;
		// stupidly says AUTO... we must assign a numeric value prior, parseInt'ed

		var imgw = $(img).width();
		var imgh = $(img).height();

		//console.log(id+" SAVING="+imgx+","+imgy+","+imgw+","+imgh);

		if(typeof options.callback == 'function')
		{
			options.callback(imgx,imgy,imgw,imgh);
		}
	};

	function positionPhoto()
	{
		// Generate defaults
		if(!options.coords || !options.coords[2] || !options.coords[3]) // center fit.
		{
			//console.log("POSITION PHOTO CENTER");
			var canw = $(canvas).width();
			var canh = $(canvas).height();
			var canw2h = canw/canh;

			var imgw = $(img).width();
			var imgh = $(img).height();
			var imgw2h = imgw/imgh;

			var w = canw;
			var h = Math.ceil(w / imgw2h);

			if(h > canh)
			{
				h = canh;
				w = Math.ceil(h * imgw2h);
			}
			x = Math.ceil((canw - w)/2);
			y = Math.ceil((canh - h)/2);

			options.coords = [x,y,w,h];
		}
		//console.log("COORDS=");
		//console.log(options.coords);

		var randid = Math.random();

		//console.log(randid+"=POSITION="+options.coords[0]+","+options.coords[1]+","+options.coords[2]+","+options.coords[3]);

		$(img).css('left', parseInt(options.coords[0]));
		$(img).css('top', parseInt(options.coords[1]));
		$(img).height(parseInt(options.coords[3]));
		//$(img).width(parseInt(options.coords[2]));
		// XXX double adds offset.... hmmm...

		save(randid);
	}

	function init() {
		// bind convenient helpers.
		$(img).bind('fullbleed', fit);
		$(img).bind('fit', fit);
		$(img).bind('fullsize', fullsize);
		$(img).bind('center', center);

		// reset size.
		$(img).width('auto');
		$(img).height('auto');

		// *** this works life-size, 950x450, etc
		$(img).data('original-width', $(img).width());
		$(img).data('original-height', $(img).height());


		// if not what expected, warn them.
		warnsize();

		// place image in a sensible location
		positionPhoto();

		initDraggable();
		// only enable slider sometimes.
		initZoom(custom_opts);

		save(); // save coords just in case.
	};

	init();
	// image is already loaded, so just fire.

};

})(jQuery);

