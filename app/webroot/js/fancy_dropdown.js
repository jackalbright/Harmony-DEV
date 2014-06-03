(function($) {

	$.fn.fontpicker = function()
	{
		$(this).fancyDropdown(function(li, value)
		{
			//$(li).css({fontFamily: value});
			$(li).addClass(value);
		});

	};
	$.fn.fancyDropdown = function(callback)
	{
		var select = this;
		var select_id = $(select).attr('id');
		var dropdown = $("<div class='fancyDropdown'><div class='arrow'></div></div>");
		$(select).after(dropdown);
		var input = $("<input type='text'/>");
		var defaultValue = $(select).val();
		if(!defaultValue) { 
			defaultValue = $(select).children('option').first().text();
		}
		var defaultText = $(select).children('option[value='+defaultValue+']').html();

		$(input).val(defaultText);
		if(typeof callback == 'function')
		{
			callback(input, defaultValue);
		}


		$(dropdown).append(input);

		// copy style/css
		/*
		if($(select).attr("class"))
		{
			//$(input).addClass($(select).attr("class"));
		}
		if($(select).attr("style"))
		{
			//$(input).attr("style", $(select).attr("style"));
		}
		*/

		/* width is 0 when page loads and select isnt visible */
		/*
		var width = $(select).width();
		if(width > 0) { // set if possible, else go with css default.
			$(input).width(width);
		}
		*/
		/* cant just go with inline-block, since may vary */

		var options = $("<ul></ul>");
		$(dropdown).append(options);

		$(select).children("option").each(function() {
			var opt = this;
			var value = $(opt).attr('value');
			var option = $("<li>"+$(opt).html()+"</li>"); // oddly text() returns 'undefined', at least on this jquery 1.7.1 version
			$(option).data("value", value);
			$(options).append(option);
			if(typeof callback == 'function')
			{
				callback(option, value);
			}
			$(option).click(function(e)
			{
				$(option).parent().children().removeClass('selected');
				$(option).addClass('selected');
				console.log(select);
				console.log(value);
				$(select).val(value).change();
				console.log($(select).val());
				$(input).val($(option).html());
				if(typeof callback == 'function')
				{
					callback(input, value); // re-style input.
				}
				$(options).hide();
				e.stopPropagation();
			});
		});

		/// Put options below input
		$(dropdown).click(function(e) {
			$(options).toggle();
			e.stopPropagation();
		});

		$(input).keydown(function(e) {
			return false; // dont let manually edit!
		});
		$(input).focus(function(e) {
			$(this).blur();
			return false;
		});

		$(input).click(function(e) {
			$(options).toggle();
			e.stopPropagation();
		});
		$('html').click(function() {
			$(options).hide();
		});



		// Now hide select
		$(select).hide();
		

	};

})(jQuery);
