(function($) {
	// AJAX history plugin, esp for modals. can be used for arbitrary containers 
	// (someday, probably needs tweaking if we move too much and the sub-container no longer exists, ie 'content' should ALWAYS be for full modal/page)
	$.history = {
		// storage of html content so we don't have to RELOAD the whole damned page! and since hpmodal() is SLOW
		
		_queue: [],
		_setting: false,
		_active_url: null,

		update: function() { // if we have subcontent changing, we want most accurate final state of page.
			var state = $.history._queue[$.history._active_url];
			if(state)
			{
				$.history._queue[$.history._active_url].content = $('#'+state.target).html();
			}
		},
		add: function(target, url, content) {
			$.history._setting = true;

			// ensure unique URL for content, to avoid page duplicates.
			var unique_url = target+":"+url;
			//while($.history._queue[unique_url])
			//{
			//	unique_url = orig_url + parseInt(Math.random()*10000)); // Make something random so no conflicts.
			//}
			// WHATEVER GETS SET LAST IS WHAT IS AUTHORITATIVE/UP-TO-DATE . Even if we go back to the Nth copy, 
			// it makes no sense to see outdated info if a newer version has something different. page should best reflect database/server.

			var title = (target == 'modal' || target == 'modaltmp') ? j('#'+target).dialog('option','title') : null; // get title to save.
		
			//console.log("ADDING("+target+")="+unique_url);

			window.document.location.hash = unique_url; // SET in browser, so recognize change.

			$.history._queue[unique_url] = { target: target, content: content, title: title };

			$.history._active_url = unique_url;
		},
		init: function() {
			$(window).bind('hashchange', function(event) {
				if($.history._setting) { 
					$.history._setting = false;
					return; 
				} // First-time set, don't double the efforts.

	    			var hash = window.document.location.hash.replace(/^#/, "");                    

				//console.log("WANTING="+hash);
	
				if(!hash) {  // base page.
					if(j('#modal').dialog('isOpen'))
					{
						j('#modal').dialog('close');
					} else { // Not open, just refresh page.
						window.document.location = window.document.location; // Refresh/Clear page.
					}
					return;
				}
				var state = $.history._queue[hash];

				if(hash.match(/^\//) && !state) // if clearly a path starting with a '/', create pseudo entry for url typed in... other formats skipped.
				{
					// Load via hpmodal.
					j('#modal').hpmodal(hash);
				}
				else if(state) { // already in history.
					//console.log("RESTORING PAGE");
					j('#'+state.target).html(state.content);
					if(state.target == 'modal')
					{
						j('#modal').dialog('open');
						// restore title.
						if(state.title)
						{
							j('#modal').dialog('option','title', state.title);
						}
						j('#modal').dialog('option','position','center');
					}

					// DONT delete, so we can go into future instead.
				} // else do nothing, no guarantee it's related to anything modal oriented!

			});

		}
	};

	$.history.init();
})(jQuery);
