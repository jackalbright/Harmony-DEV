/**
* Font selector plugin
* turns an ordinary input field into a list of web-safe fonts
* Usage: $('select').fontSelector();
*
* Author     : James Carmichael
* Website    : www.siteclick.co.uk
* License    : MIT
*/
(function($) { 

jQuery.fn.fontSelector = function() {
 
  return this.each(function(){
 
    // Get input field
    var sel = this;
 
    // Add a ul to hold fonts
    var ul = $('<ul class="fontselector"></ul>');
    $('body').prepend(ul);
    $(ul).hide();

    j(this).children("option").each(function(i, item) {
    //jQuery.each(fonts, function(i, item) {
    	var opt = this;
	var value = $(opt).attr('value');
	var label = $(opt).html();

	var a = $('<a href="#" class="'+value+'">' + label + '</a>');
	$(a).data('value', value);

	var option = $('<li/>');
	$(option).append(a);
      	$(ul).append(option);

	$(sel).bind('click', function(ev) {
        	ev.stopPropagation();
	});
 
      // Prevent real select from working
      $(sel).bind('focus', function(ev) {
        ev.preventDefault();
      	ev.stopImmediatePropagation(); // seems to be needed.

        // Show font list
      	if($(ul).is(":visible"))
	{
        	j(ul).hide();
		j(sel).removeClass('active');
	} else {
		j(sel).addClass('active');
        	$(ul).show();
        	// Position font list
        	$(ul).css({ top:  $(sel).offset().top + $(sel).height() + 4,
                    left: $(sel).offset().left});
        	// Blur field
	}
        $(this).blur();
 
 
        return false;
      });

    });
 
      j(ul).find('a').bind('focus.fontSelector', function(e) {
      	e.preventDefault();
	e.stopPropagation();
	e.stopImmediatePropagation(); // ignore body handler

        var font = $(this).data('value');
        j(sel).val(font).removeClass('active').trigger('change');
        j(ul).hide();
        return false;
      });


  $('html').click(function() {

  	if($(sel).hasClass('active'))
	{
		$(sel).removeClass('active');
		$(ul).hide();
	}
  });

});

  // 
 
}
})(jQuery);
