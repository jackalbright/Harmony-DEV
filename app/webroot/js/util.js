function isNumeric(n)
{
	return !isNaN(parseFloat(n)) && isFinite(n);
}

(function($) {
	$.loading = function(show)
	{
		var hide = (show === false); // no parameter assumes 'show' ; false = 'hide'

		if(!j('#waiting').size())
		{
			j('body').append("<div id='waiting' style='display:none;'><div class='XXui-widget-overlay'></div><div id='' class='progress ui-corner-all'>Loading...<div class='progressbar'></div></div></div>");
			//hide = false;
		}
		if(hide)
		{
			j('#waiting').fadeOut();
		} else {
			j('#waiting .progressbar').progressbar({value: false});
			if(!j('#waiting').is(":visible"))
			{
				j('#waiting').fadeIn();
			}
		}
	};
	$.fn.ignoreEnter = function()
	{
		$(this).keypress(function(e) {
				if(e.keyCode == 10 || e.keyCode == 13)
				{
					e.preventDefault();
				}
			}
		);
		
	};

	$.fn.changeup = function(callback, timeout) {
		var target = this;
		if(!timeout) { timeout = 500; }
		$(this).keyup(function() {
			clearTimeout($(this).data('keyup_timeout_id'));
			$(this).data('keyup_timeout_id', setTimeout(function() { callback(target); }, timeout));
		});
		// also detect paste
		$(this).bind('paste',function() {
			clearTimeout($(this).data('keyup_timeout_id'));
			callback($(this));
		});
		$(this).change(function() {
			clearTimeout($(this).data('keyup_timeout_id'));
			callback($(this));
		});
	};
	
	$.alert = function(msg,title)
	{
		// hide pleasewait abruptly (not animated)
		j.hidespin(true);

		j('#alert').html(msg);
		j('#alert').dialog({modal: true, title: title, resizable: false, width: 400, draggable: false, buttons: [ {text: "OK", click: function() { j('#alert').dialog('close'); } } ] });
	};

	$.fn.modalcenter = function() {

		// Also change the height if it's too tall, ie content added.

		j(this).unbind('dialogopen.modalcenter');
		
		j(this).bind('dialogopen.modalcenter', function() { 

			// call after open. since math matters.
			//
			//var buffer = 10;

			var dialogHeight = j(this).closest('.ui-dialog').height(); // if modal not opened yet.

			// Reset modal height to 'auto' so there's no scrollbars. so height() is accurate to real height....
			j(this).height('auto');

			var windowHeight = $(window).height();
			var modalHeight = j(this).height();

			// consider titlebar
			var titleHeight = j(this).parent().find('.ui-dialog-titlebar').height();
			// consider any buttons, too.
			var buttonsHeight = j(this).parent().find('.ui-dialog-buttonpane').height();

			var buffer = 50;

			if(titleHeight) { buffer += titleHeight; }
			if(buttonsHeight) { buffer += buttonsHeight; }

			if(windowHeight < modalHeight + buffer)
			{
				j(this).dialog({height: windowHeight - buffer });
			} else {
				j(this).dialog({height: 'auto'});
				//j(this).height('auto');
			}


			j(this).modaloption('width', j(this).parent().width());
			// ie7 title bar bug fix when width: auto;
			//
			//
			// ONLY show vert scrollbar.
			j(this).css({overflow: 'hidden', overflowY: 'auto'});

			// Also adjust width so no horiz scrollbars, in case new content sticks over edge...
			//ji(this).width'div.ui-dialog').width(j('div.ui-dialog').get(0).scrollWidth+5);

			j(this).modaloption('position','center');
		});

		if($(this).modalopened()) { j(this).trigger('dialogopen.modalcenter'); }
	};

	$.fn.modalopened = function() // saner. initialized may not mean open. async lag.
	{
		return $(this).parent('.ui-dialog').size() && $(this).dialog('isOpen');
	};

	$.fn.modaloption = function(key, value)
	{
		//console.log("SETTING="+key+"="+value);
		var container = this;
		if($(container).modalopened())
		{
			//console.log("TRIGOPT="+key+", V="+value);
			$(container).dialog('option',key,value);
		} else {
		//	console.log("DELAYED OPT="+key+", V="+value);

		}
		j(container).bind('dialogopen', function() { 
			j(container).dialog('option', key, value);
		});
	};


	$.fn.modal = function(e) // called on LINK, so we get url properly....
	{
		var title = j(this).prop('title');
		if(!title) { title = j(this).text(); }

		var href = j(this).prop('href');
		e.stopPropagation();
		j('#modal').load(href, null, function(response)
		{
			//console.log(response);
			
			j('#modal').dialog({
				width: 'auto', // should keep width w/o scrollbar?
				title: title,
				modal: true,
				resizable: false,
				draggable: false,
				open: function(event, ui) {
					j('#modal').modalcenter();
					j('#modal').trigger('modalready');
				},
				buttons: null
			});
			//console.log(j('#modal .resizable'));
			j('#modal .resizable').resize(function(e) { // need to put on inner container so scrollbar doesn't trigger.
				//console.log("RESIZED!");
				var top = j('#modal').scrollTop();
				j('#modal').modalcenter();
				// Keep scroll position the same.
				j('#modal').scrollTop(top);
			});


			j('.ui-widget-overlay').click(function() {
				j('#modal').dialog('close');
			});
		})

		return false;
	};

	$.fn.modalready = function(callback) // Call if already opened, since won't get called otherwise.
	{
		if(typeof callback == 'function') // register at same time.
		{
			j(this).bind('modalready', callback);
		}

		if(j(this).modalopened())
		{
			j(this).trigger('modalready');
		}
	};

	$.fn.closemodal = $.fn.modalclose = function(callback)
	{
		var container = this;
		if(callback && !isNumeric(callback))
		{
			$(container).bind('dialogclose', function() {
				if(typeof callback == 'function')
				{
					callback();
				} else if (typeof callback == 'string') { // from controller.
					eval(callback);
				}
			});
		}
		$(container).dialog('close');
		$(container).dialog('destroy');
		$(container).html(''); // clear content.
		//e.stopPropagation();
		return false;
	};


	$.fn.formerror = function(msg, before)
	{
		if(!msg) { msg = 'Missing Information'; }
		var id = j(this).attr('id');
		var errorid = id+"_error";
		if(!j("#"+errorid).size())
		{
			var container = "<div id='"+errorid+"' class='formerror'></div>";
			if(before)
			{
				j('#'+id).before(container);
			} else {
				// Place as last sibling, since may be stuff to right.
				j('#'+id).parent().append(container);
			}
		}
		//console.log(msg);
		j('#'+errorid).html(msg).show();

		return false;
	};
	$.fn.originalShow = $.fn.show;
	$.fn.originalHide = $.fn.hide;

	$.fn.show = function(speed, call)
	{
		$(this).trigger('show');
		return $(this).originalShow(speed,call);
	};

	$.fn.hide = function(speed, call)
	{
		$(this).trigger('hide');
		return $(this).originalHide(speed,call);
	};

	$.fn.ghostable = function(text)
	{
		var original = $(this);
		var overlay = original.clone();
		overlay.attr('id', original.attr('id')+"_clone");
		overlay.attr('name', '');//original.attr('name')+"_ghostable");
		overlay.addClass('ghost');
		original.after(overlay);
		overlay.val(text);

		overlay.click(function() { overlay.hide(); original.show().change(); original.focus(); });
		overlay.select(function() { overlay.hide(); original.show().change(); original.focus(); });
		overlay.focus(function() {  overlay.hide(); original.show().change(); original.focus(); });
		original.blur(function() { if(!original.val()) { overlay.show().change(); original.hide(); } else { original.show(); overlay.hide(); } });

		// IF YOU NEED TO CHANGE PROGRAMATICALLY, CALL blur(); SINCE ABOVE CALLS CHANGE() to trigger any previewing
		//original.change(function() { if(!original.val()) { overlay.show(); original.hide(); } else { original.show(); overlay.hide(); } });
		
		overlay.bind('paste', function() { overlay.val(''); setTimeout(function() { original.val(overlay.val()).show().change(); overlay.val(text).hide(); }, 100) });
		// 

		if(original.val())
		{
			overlay.hide();
		} else {
			original.hide();
		}
	};


	$.fn.ghostable2 = function(text) // Disabled element that won't submit or be gathered unless custom text.
	{
		$(this).wrap("<span class='ghostable_wrapper'/>");

		var $original = $(this);
		var $parent = $original.closest('span.ghostable_wrapper');
		var $overlay = $(this).clone();
		$overlay.val(text);
		//$("<div class='ghostable_overlay'>"+text+"</div>");	

		// style the overlay
		$overlay.css({
		      // position the overlay in the same real estate as the original parent element 
		        position: "absolute"
		      , top: $parent.position().top
		      , left: $parent.position().left
		      , width: $parent.outerWidth()
		      , height: $parent.outerHeight()
		      , zIndex: 10000
		      // IE needs a color in order for the layer to respond to mouse events
		      , backgroundColor: "#fff"
		      // set the opacity to 0, so the element is transparent
		      , opacity: 0
		    })
		    // attach the click behavior
		    .click(function (){
		    	$self.show(); // Show
			$(this).hide();
		    	// Hide me, focus on original.
		      // trigger the original event handler
		      //return $self.trigger("click");
		    });
		
		    // add the overlay to the page  
		$parent.append($overlay);
	};

	$.spin = function()
	{
		var container = $('body #spin');
		if(!container.size())
		{
			container = $("<div id='spin' style='display: none;'></div>");
			$('body').append(container);
			$(container).click(function() {
				$.hidespin();
			});
		}
		$(container).show();
		$(container).spin('large');
	};

	$.unspin = $.hidespin = function(immediate)
	{
		if(immediate)
		{
			$('body #spin').hide();
		} else {
			$('body #spin').fadeOut('slow');
		}
	};

	$.fn.spin = function(opts, color) {
		var defaults = {
			color: '#FFF'
		};
		var presets = {
			"tiny": { lines: 8, length: 2, width: 2, radius: 3 },
			"small": { lines: 8, length: 4, width: 3, radius: 5 },
			"large": { lines: 10, length: 8, width: 4, radius: 8 }
		};
		if (typeof Spinner != 'undefined') {
			return this.each(function() {
				var $this = $(this),
					data = $this.data();
				
				if (data.spinner) {
					data.spinner.stop();
					delete data.spinner;
				}
				if (opts !== false) {
					if (typeof opts === "string") {
						if (opts in presets) {
							opts = $.extend(defaults, presets[opts]);
						} else {
							opts = defaults;//{};
						}
						if (color) {
							opts.color = color;
						}
					}
					data.spinner = new Spinner($.extend({color: $this.css('color')}, opts)).spin(this);
				}
			});
		} else {
			throw "Spinner class not available.";
		}
	};

	$(document).ready(function() {
		// Remove all form error content.
		j('.formerror').html('').hide();

		j(document).on('click', 'a.modal', function(e) {
			j(this).modal(e);
			return false;
		});

		// Handle forms based on modal
		
		// so this works on modals even after submitted first time around.
		j(document).on('submit', '#modal form:not(.nomodal)', function(e) { // as a submit check, respects onSubmit for verify fields,etc.
				//console.log("AJAX SUBMIT");
				j(this).ajaxSubmit({ target: '#modal' });
				return false; // prevent default submit to whole page!
		});

		j('#modal form').require_fields();

		// Hide flash messages once a form is submitted.
		j('form').submit(function() {
			j('#flashMessage').hide();
		});
	});

	String.prototype.nl2br = function()
	{
		return this.replace(/\n/g, "<br/>\n");
	};

})(jQuery);
