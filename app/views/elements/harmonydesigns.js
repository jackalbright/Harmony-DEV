function saveMyImage(image_id, gotourl)
{
	//new Ajax.Request("/custom_images/save/"+image_id, {method: 'post', asynchronous: false});
	new Ajax.Updater('my_images','/custom_images/ajax_save/'+image_id+'?savegoto='+gotourl, {method: 'post', asynchronous:true});
}

function saveMyImageSignup(image_id, gotourl)
{
	document.location.href = '/custom_images/save/'+image_id+"?savegoto="+gotourl;
}

function loadMyImages()
{
	new Ajax.Updater('my_images','/custom_images/ajax_load', {method: 'post', asynchronous:true});
}


function deleteMyImage(image_id)
{
	new Ajax.Updater('my_images','/custom_images/ajax_delete/'+image_id, {method: 'post', asynchronous:true});
}

function accordianClick(id, classname)
{
	var tabs = document.getElementsByClassName(classname);
	var closed = $(id).hasClassName('hidden');
	var arrow_hide = $(id+"_arrow_hide");
	var arrow_show = $(id+"_arrow_show");

	// DONT CLOSE OTHERS!
	/*
	 * for(var i = 0; i < tabs.length; i++)
	{
		if(tabs[i].id != id || !closed)
		{
			new Effect.BlindUp($(tabs[i].id), {duration: 0.5 });
			tabs[i].addClassName('hidden');
		}
	}
	*/
	if(closed)
	{
		$(id).removeClassName('hidden');
		arrow_show.removeClassName('hidden');
		arrow_hide.addClassName('hidden');
		new Effect.BlindDown(id, {duration: 0.5 });
		track('products','accordianclick', {location: id} );
	} else {
		arrow_hide.removeClassName('hidden');
		arrow_show.addClassName('hidden');
		$(id).addClassName('hidden');
		new Effect.BlindUp(id, {duration: 0.5 });
	}
}

function showGalleryTab(prefix, key)
{
	var tabs = document.getElementsByClassName(prefix+"_tab");
	for(var i = 0; i < tabs.length; i++)
	{
		if(tabs[i].id == prefix+"_tab_"+key)
		{
			tabs[i].addClassName('selected');
		} else {
			tabs[i].removeClassName('selected');
		}
	}


	var galleries = document.getElementsByClassName(prefix);
	for(var i = 0; i < galleries.length; i++)
	{
		if(galleries[i].id == prefix+"_"+key)
		{
			galleries[i].removeClassName('hidden');
		} else {
			galleries[i].addClassName('hidden');
		}
	}
}

function build_get_radio_option(key)
{
	var form = $('build_form');
	var values = form['data[options]['+key+']'];
	if (!values || values.length == 0) { return null; }
	var value = "";
	for(i = 0; i < values.length; i++)
	{
		if(values[i].checked == true)
		{
			value = values[i].value;
		}
	}
	return value;
}

function showBuildOptionGroup(group)
{
	group.removeClassName('hidden'); // Let us close it if we want.....
	$(group.id+"_arrow_show").removeClassName("hidden");
	$(group.id+"_arrow_hide").addClassName("hidden");
}

function hideBuildOptionGroup(group)
{
	$(group.id+"_arrow_show").addClassName("hidden");
	$(group.id+"_arrow_hide").removeClassName("hidden");
	group.addClassName('hidden'); // Let us close it if we want.....
}

function showBuildOptionsGroup(id,group_class,default_id)
{
	var closing = false;
	var groups = document.getElementsByClassName(group_class);
	for(var i = 0; i < groups.length; i++)
	{
		var group = groups[i];
		if (group.id == id)
		{
			showBuildOptionGroup(group);
		} else {
			hideBuildOptionGroup(group);
		}
	}
}

function toggleBuildOptionsGroup(id,group_class,default_id)
{
	var closing = false;
	var groups = document.getElementsByClassName(group_class);
	for(var i = 0; i < groups.length; i++)
	{
		var group = groups[i];
		if (group.id == id)
		{
			if (group.hasClassName('hidden'))
			{ // Show
				showBuildOptionGroup(group);
			} else { // Hide
				hideBuildOptionGroup(group);
			}
		} else {
			hideBuildOptionGroup(group);
		}
	}
}

function ajax_changeShippingMethod(shipping_method_id)
{
	new Ajax.Request("/cart/ajax_change_shipping_method/"+shipping_method_id, {method: 'post', asynchronous: true});

}

function initFileUploads(form, img_src) 
{
		if(!img_src)
		{
			img_src = "/images/buttons/Upload-Your-Image.gif";
		}

		var W3CDOM = (document.createElement && document.getElementsByTagName);
		if (!W3CDOM) return;

		var fakeFileUpload = document.createElement('div');
		fakeFileUpload.className = 'fakefile';
		var dummy_input = document.createElement('input');
		fakeFileUpload.appendChild(dummy_input);
		var image = document.createElement('img');
		image.src=img_src;
		fakeFileUpload.appendChild(image);

		var x = document.getElementsByTagName('input');
		//var x = document.getElementsByClassName("oneclick_upload");
		for (var i=0;i<x.length;i++) {
			if (x[i].type != 'file') continue;
			if (x[i].parentNode.className != 'fileinputs') continue;
			x[i].className = 'file';
			var clone = fakeFileUpload.cloneNode(true);
			x[i].parentNode.appendChild(clone);
			x[i].relatedElement = clone.getElementsByTagName('input')[0];
			x[i].onchange = x[i].onmouseout = function () {
				this.relatedElement.value = this.value;
				form.submit();
			}
		}
}

function hideFlash()
{
	var flash = $('flashMessage');
	if(flash)
	{
		flash.addClassName('hidden');
	}
}

function confirmCompletedBuildForm()
{
	var incomplete_steps = $('build_form').select('.incomplete_step');
	if (incomplete_steps.length)
	{
		var incomplete_step = incomplete_steps[0];
		showBuildStep(incomplete_step.id, true);

		alert("Please finish selecting your options.");
		return false;
	}

	return true;
}

function showBuildStep(id)
{
	var steps = $('build_form').select('.step');
	var do_complete = (arguments.length > 1 && arguments[1] == true);
	do_complete = true;

	var found_step = false;

	for(var i = 0; i < steps.length; i++)
	{
		var step = steps[i];
		//alert("SID="+step.id);
		if (step.id == "step_" + id || step.id == id)
		{
			//alert("FOUND="+step.id);
			found_step = true;
			showStep(step);
		} else {
			if(!found_step)
			{
				//alert("HIDE="+step.id);
				//alert("ID="+step.id+" HAS="+$(step.id).className);
				if($(step.id).hasClassName('selected_step')) // Only complete if it was open.
				{
					completeBuildStep(step.id);
				}
			}
			hideStep(step); // Hide all other steps, even ones 'after', that were open.
		}
	}
}

function showStep(step)
{
	step.addClassName('selected_step');
	var settings = step.select('.part_settings');
	var setting = settings[0];

	new Effect.BlindDown(setting.id, {duration: 0.5 });
	//$(setting.id).removeClassName('hidden');
	$("header_"+setting.id).addClassName("selected_step");
}

function hideStep(step)
{
	step.removeClassName('selected_step');
	var settings = step.select('.part_settings');
	var setting = settings[0];

	new Effect.BlindUp(setting.id, {duration: 0.5 });
	//$(setting.id).addClassName('hidden');
	$("header_"+setting.id).removeClassName("selected_step");
}

function completeBuildStep(step_id)
{
	var step = $(step_id);
	step.addClassName('completed_step');
	step.removeClassName('incomplete_step');

	// Save mark so when reload, we dont forget.
	new Ajax.Request("/build/ajax_complete_step/"+step.id, {asynchronous: true});
}



function showBuildStepPrevious(id)
{
	var steps = $('build_form').select('.step');

	for(var i = 0; i < steps.length; i++)
	{
		var step = steps[i];
		if (step.id == "step_"+id)
		{
			// Show previous step.
			if (i > 0) 
			{
				showStep(steps[i-1]);
				// Hide this step.
				hideStep(steps[i]);
				//completeBuildStep(steps[i]);
			}
		}
	}
}

function showBuildStepNext(id)
{
	var steps = $('build_form').select('.step');

	for(var i = 0; i < steps.length; i++)
	{
		var step = steps[i];
		if (step.id == "step_"+id)
		{
			// Show next step.
			if (i < steps.length-1) 
			{
				showStep(steps[i+1]);
				// Hide this step.
				hideStep(steps[i]);
				completeBuildStep("step_"+id);
			}
		}
	}
}

function iframeUpdateBuild(id)
{

	showPleaseWait();
	completeBuildStep("step_"+id);
	updateBuildImage();
	update_build_pricing();
}

function updateBuild(id)
{
	showPleaseWait();
	completeBuildStep("step_"+id);
	updateBuildImage();
	update_build_pricing();
}


function mail(a, encoded_email)
{
	var decoded_email = Base64.decode(encoded_email);
	a.href = "mailto:"+encoded_email;
	return true; // Cause click.
}

function popup(url)
{
	var w = arguments.length > 1 ? arguments[1] : 400;
	var h = arguments.length > 2 ? arguments[2] : 600;
	var name = arguments.length > 3 ? arguments[3] : "popup";
	return window.open(url, name, 'location=no,toolbar=no,width='+w+',height='+h+',status=yes,resize=yes,scrollbars=yes,menubar=no');
}

function credit_card_expiration_valid()
{
	var d = new Date();
	var yearmonth = sprintf("%04d%02d", d.getFullYear(), 1+parseInt(d.getMonth()));
	var form_yearmonth = $('CreditCardExpirationYear').value + $('CreditCardExpirationMonth').value;
	if (form_yearmonth < yearmonth)
	{
		alert("Credit card has expired");
		$('CreditCardExpirationMonth').focus();
		return false;
	}
	return true;
}

function track(area, task)
{
	var data = arguments.length > 2 ? arguments[2] : {}; // as { a: '1', ... }
	
	new Ajax.Request('/tracking_entries/track_ajax/'+area+"/"+task, {method: 'post', parameters: data, asynchronous:true, evalScripts: true });
	return true;
}

function track_complete(area, task, id)
{
	var data = arguments.length > 3 ? arguments[3] : {}; // as { a: '1', ... }

	//alert("ID="+id);
	
	new Ajax.Request('/tracking_entries/track_ajax/'+area+"/"+task+"/"+id, {method: 'post', parameters: data, asynchronous:true, evalScripts: true });
	return true;
}

function toggleSpecialtySampleProduct(pid)
{
	var albums = document.getElementsByClassName("product_gallery");
	var id = "product_gallery_"+pid;
	for(var i =0; i < albums.length; i++)
	{
		var album = albums[i];
		if(album.id == id)
		{
			$(album).removeClassName('hidden');
		} else {
			$(album).addClassName('hidden');
		}
	}
}


function showblock(div)
{
	$(div).removeClassName('hidden');
}

function hideblock(div)
{
	$(div).addClassName('hidden');
}

function showGallerySubcategories(catnum)
{
	var all = $('subcat_all_'+catnum);
	var lead = $('subcat_lead_'+catnum);
	
	all.removeClassName('hidden');
	lead.addClassName('hidden');
}

function hideGallerySubcategories(catnum)
{
	var all = $('subcat_all_'+catnum);
	var lead = $('subcat_lead_'+catnum);
	
	lead.removeClassName('hidden');
	all.addClassName('hidden');
}

function calculateWorkRequestPricing(form)
{
	showPleaseWait();
	var serial_form = form.serialize(true);
	new Ajax.Updater('work_request_pricing','/work_requests/pricing', {method: 'post', parameters: serial_form, asynchronous:false, evalScripts: true, onComplete: function(t) { setTimeout("hidePleaseWait();",1000); } });
}

function updateBuildForm()
// Entire form, such as with changing template...
{
	// Need to save quote into $build...
	//showPleaseWait();
	var serial_form = $('build_form').serialize(true);
	new Ajax.Updater('build','/build/create_ajax', {method: 'post', parameters: serial_form, asynchronous:true, evalScripts: true, onComplete: function(t) { setTimeout("hidePleaseWait();",2000); } });
	//new Ajax.Updater('build_img_container','/build/preview', {method: 'post', parameters: serial_form, asynchronous:false });

	// Reinitialize view larger...
	Shadowbox.setup("#view_larger");

}
function updateBuildImage()
{
	updateBuildNotice();
	// Need to save quote into $build...
	//if(arguments.length == 0) { showPleaseWait(); }
	
	$('build_img').src = "/images/icons/please-wait.gif";

	var serial_form = $('build_form').serialize(true);
	//new Ajax.Updater('build_img_container','/build/preview', {method: 'post', parameters: serial_form, asynchronous:false, onComplete: function(t) { hidePleaseWait(); } });
	//new Ajax.Updater('build_img_container','/build/preview', {method: 'post', parameters: serial_form, asynchronous:false, evalScripts: true, onComplete: function(t) { setTimeout("hidePleaseWait();",2000); } });
	new Ajax.Updater('build_img_container','/build/preview', {method: 'post', parameters: serial_form, asynchronous:true, evalScripts: true, onComplete: function(t) { setTimeout("hidePleaseWait();",200); } });
	//new Ajax.Updater('build_img_container','/build/preview', {method: 'post', parameters: serial_form, asynchronous:false });

	// Reinitialize view larger...
	Shadowbox.setup("#view_larger");

	//var d = new Date();
	//var time = d.getTime();
	//$('build_img').src = "/product_image/build_view/200.png?rand="+time;
}

function updateBuildNotice()
{
	var serial_form = $('build_form').serialize(true);
	new Ajax.Updater('build_notice','/build/ajax_notice', {method: 'post', parameters: serial_form, asynchronous:true, evalScripts: true});
}

function updateGalleryCategoryThumbnail(catnum)
{
	var path = catnum != "" ? "/gallery/image/"+catnum : "";
	$('gallery_category_thumb_link').href = path;
	$('gallery_category_thumb_img').src = path;
}

function shipping_calc_new_field(template_name)
{
	var old_template = $(template_name);
	//var old_select = $$("#"+template_name+" select");
	var old_select = old_template.getElementsByTagName("select");
	var old_input = $$("#"+template_name+" input[type=text]");

	var content = old_template.innerHTML;
	var row = "<tr id='"+template_name+"'>"+content+"</tr>";
	//alert(content);
	old_template.insert({ after: row });
	if(old_select) { old_select.onChange = ""; alert("NO="+old_select.onChange); alert(old_select.name); }
	old_template.id = "";

	var select = $$("#"+template+" select");
	var text = $$("#"+template+" input[type=text]");
	//alert(select); alert(text);
}

function update_build_review()
{
	var serial_form = $('build_form').serialize(true);
	new Ajax.Updater('review_container','/build/update_review', {method: 'post', parameters: serial_form, asynchronous:true, onComplete: function(t) { } });
}


function update_build_pricing()
{
	var serial_form = $('build_form').serialize(true);
	//alert("SF="+serial_form);
	$('quantity_add').value = $('quantity').value;

	//if(arguments.length == 0) { showPleaseWait(); }
	//new Ajax.Updater('quantity_container','/build/update_quantity', {method: 'post', parameters: serial_form, asynchronous:false, onComplete: function(t) { hidePleaseWait(); } });
	//new Ajax.Updater('quantity_container','/build/update_quantity', {method: 'post', parameters: serial_form, asynchronous:true, onComplete: function(t) { } });
	update_build_review();
	new Ajax.Updater('estimate_container','/build/update_quantity', {method: 'post', parameters: serial_form, asynchronous:true, onComplete: function(t) { } });
	new Ajax.Updater('pricing_chart_container','/build/update_pricing_chart', {method: 'post', parameters: serial_form, asynchronous:true, onComplete: function(t) { hidePleaseWait(); } });
	// INTEGERATE pleaseWait
}

function save_build_options()
{
	var serial_form = $('build_form').serialize(true);
	new Ajax.Request('/build/ajax_update', {method: 'post', parameters: serial_form, asynchronous:true, onComplete: function(t) { } });
}

function saveBuild()
{
	var serial_form = $('build_form').serialize(true);
	new Ajax.Request("/build/ajax_save", {asynchronous: true, method: 'post', parameters: serial_form});
}

function build_choose_quote(quote_id)
{
	var quote_text = $("quote_text_"+quote_id).innerHTML;
	//alert("quote_text="+quote_text);
	build_choose('quote', quote_text);
	//updateBuildImage();
}


function build_choose(id, value)
{
	var item = window.parent.document.getElementById("option_"+id);
	item.value = value;
	//alert("V="+item.value);
	item.onchange();
	parent.Shadowbox.close();
}

function set_get_started_prod(prod)
{
	var existing_prod = $('existing_prod');
	if(existing_prod) { existing_prod.value = prod; }
	var custom_prod = $('custom_prod');
	if(custom_prod) { custom_prod.value = prod; }
	var gallery_prod = $('gallery_prod');
	if(gallery_prod) { gallery_prod.value = prod; }
	var clipart_prod = $('clipart_prod');
	if(clipart_prod) { clipart_prod.value = prod; }
}

function togglePopup(id)
{
	var box = $(id);
	if(!box) { return; }
	box.toggleClassName('hidden');
}

function showPopup(id)
{
	var box = $(id);
	if(!box) { return; }
	box.removeClassName('hidden');
	var morelink = $(id+"_more_link");
	var lesslink = $(id+"_less_link");
	if(morelink && lesslink)
	{
		morelink.addClassName('hidden');
		lesslink.removeClassName('hidden');
	}
}

function hidePopup(id)
{
	var box = $(id);
	if(!box) { return; }
	box.addClassName('hidden');
	var morelink = $(id+"_more_link");
	var lesslink = $(id+"_less_link");
	if(morelink && lesslink)
	{
		morelink.removeClassName('hidden');
		lesslink.addClassName('hidden');
	}
}

function changeOptionPreview(prefix, value, images)
{
	var img = $(prefix+"_preview");
	if (!img) { return; }
	var url = images[value];
	img.src = url;
	if(!url) { img.addClassName('hidden'); } 
	else { img.removeClassName('hidden'); }
}

function showPleaseWait()
{
	var loading = $('loading');
	if (!loading) { return; }
	loading.removeClassName("hidden");
}

function hidePleaseWait()
{
	//alert("hide");
	var loading = $('loading');
	if (!loading) { return; }
	loading.addClassName("hidden");
}

function checkMinimum(quantity_ordered, productminimum)
{
	var field = arguments.length > 2 ? arguments[2] : 'quantity';
	if (parseInt(quantity_ordered) < parseInt(productminimum))
	{
		alert("Minimum is "+productminimum);
		$(field).value = productminimum;
		return false;
	}
	return true;
}

function faq_toggleAnswer(id)
{
	var answers = document.getElementsByClassName("answer");
	var disabled = $('answer_'+id).hasClassName("hidden");
	for(var i = 0; i < answers.length; i++)
	{
		var answer = answers[i];
		if (answer.id == 'answer_'+id)
		{
			if(disabled)
			{
				answer.removeClassName("hidden");
			} else {
				answer.addClassName("hidden");
			}
		} else {
			answer.addClassName("hidden");
		}
	}
}

function cart_updateGrandTotal(id)
{
	var shippingtotals = document.getElementsByClassName("shippingTotal");
	for(var i = 0; i < shippingtotals.length; i++)
	{
		var st = shippingtotals[i];
		if (st.id == "shippingTotal"+id)
		{
			st.removeClassName("hidden");
		} else {
			st.addClassName("hidden");
		}
	}

	var grandtotals = document.getElementsByClassName("grandTotal");
	for(var i = 0; i < grandtotals.length; i++)
	{
		var gt = grandtotals[i];
		if (gt.id == "grandTotal"+id)
		{
			gt.removeClassName("hidden");
		} else {
			gt.addClassName("hidden");
		}
	}
}
function selectPreview(code)
{
	var previews = container.getElementsByClassName("preview");
	for(var i = 0; i < previews.length; i++)
	{
		var img = previews[i];
		if (img.id == "preview_"+code)
		{
			img.removeClassName("hidden");
		} else {
			img.addClassName("hidden");
		}
	}
}

function build_next_step(url)
{
	$('next_step').value = url;
	setTimeout("$('build_form').submit()", 500);
}

function showSelectedContent(sel, key)
{
	var value = sel.options[sel.selectedIndex].value;

	var id = key + "_" + value;

	var fields = document.getElementsByClassName(key);
	for(var i = 0; i < fields.length; i++)
	{
		var field = fields[i];
		if (field.id == id)
		{
			field.removeClassName("hidden");
		} else {
			field.addClassName("hidden");
		}
	}
}

function calculator_update(formid, product_pricing)
{
	var form = $(formid);
	var options = form.options;

	var unit_price_value = 0;
	//alert(form.options['price'].value);

	for(var i = 0; i < options.length; i++)
	{
		var field = options[i];
		if(field.type == 'select')
		{
		} else if (field.type == 'checkbox') {
			var value = field.value;
			if (field.checked)
			{
				unit_price_value += parseInt(value);
			}
		}
	}

	var quantity = $('quantity');
	var quantity_value = quantity.value;
	var minimum = 12;
	if (quantity_value < minimum)
	{
		alert("Minimum quantity is "+minimum);
		$('quantity').value = minimum;
	}

	var base_unit_price = form.options['price'].value;

	for(var min in pricing)
	{
		if (min < $('quantity').value)
		{
			base_unit_price = pricing[min];
		}
	}
	$('base_unit_price').innerHTML = sprintf("$%.02f", base_unit_price);

	unit_price_value += base_unit_price;

	var unit_price_field = $('unit_price');
	unit_price_field.innerHTML = sprintf("$%.02f", unit_price_value);

	var subtotal_value = unit_price_value * quantity_value;
	var subtotal_field = $('subtotal');
	subtotal_field.innerHTML("$.02f", subtotal_value);
	

}

function calculator_togglePart(checkbox)
{
	var key = checkbox.name;
	var checked_field = $(key+"_checked");
	var unchecked_field = $(key+"_unchecked");
	if (checkbox.checked)
	{
		unchecked_field.addClassName("hidden");
		checked_field.removeClassName("hidden");
	} else {
		checked_field.addClassName("hidden");
		unchecked_field.removeClassName("hidden");
	}
}

function verifyField(thisform, field)
{
	field = $(field);
	var value = field.value;
	var id = field.id;
	var label = thisform.select("label[for="+id+"]");
	var label_name = null;
	if (label && label.length) { label_name = label[0].textContent; }
	if(!label_name) { label_name = field.name; } // Default to field's name.

	var msg = "Missing required information "+(label_name != "" ? "for "+label_name : "");
	if (arguments.length >= 3)
	{
		msg = arguments[2]; // Let them overwrite message...
	}
	/*if (defined(required_value) && required_value != '' && required_value != value)
	{
		alert(msg);
		field.focus();
		return false;
	} 
	else */
	if (value == '')
	{
		if(msg)
		{
			alert(msg);
			field.focus();
		}
		return false;
	}
	return true;
}

function verifyRequiredFields(id)
{
	thisform = $(id);
	var requireds = thisform.select("input.required", "select.required");
	for(var i = 0; i < requireds.length; i++)
	{
		var field = requireds[i];
		if(!verifyField(thisform, field))
		{
			return false;
		}
	}
	return true;
}
function displayCharmCategory(charm_id)
{
	var prefix = "charm_category";
	var all_items = document.getElementsByClassName(prefix);

	var current = $(prefix+"_"+charm_id);
	var alreadyVisible = !current.hasClassName("hidden");

	for (i = 0; i < all_items.length; i++)
	{
		$(all_items[i]).addClassName("hidden");
	}
	if (current) {
		if (alreadyVisible)
		{
			current.addClassName("hidden");
		} else {
			current.removeClassName("hidden");
		}
	}
}

function displaySelectedContent(sel, prefix)
{
	var selvalue = sel.options[sel.selectedIndex].value;
	var all_items = document.getElementsByClassName(prefix);
	for (i = 0; i < all_items.length; i++)
	{
		$(all_items[i]).addClassName("hidden");
	}
	var current = $(prefix+"_"+selvalue);
	if (current) {
		current.removeClassName("hidden");
	}
}

function displayPartOptions(partType) 
{
		var targetURI = '/parts/' + partType + '.php';
		if (arguments.length > 1)
		{
			targetURI = targetURI + "/" + arguments[1]; // If we specify a relevent product.
		}
		var targetTitle = 'Available' + partType + 's';
		var targetAttributes = "toolbar=no,width=480,height=400,status=yes,resize=yes,scrollbars=yes,menubar=no";
		detailWindow = open(targetURI, targetTitle, targetAttributes);
		detailWindow.focus();
		return false;
};


function image_gallery_next(path, filecount, ext)
{
        var underpath = path.replace(/\//g, "_");
        var counter = $("image_gallery_counter_"+underpath);
        var a1 = $("image_gallery_largelink1_"+underpath);
        var a2 = $("image_gallery_largelink2_"+underpath);
        var img = $("image_gallery_"+underpath);
        var restr = "(\\d+)[.]"+ext;
        re = new RegExp(restr);
        var srcmatch = re.exec(img.src);
        var iter = parseInt(srcmatch.length > 0 ? srcmatch[1] : '0');
        iter++;
        if (iter >= filecount) { iter = 0; }


        a1.href = "/images/galleries/"+path+"/large/"+iter+"."+ext;
        a2.href = "/images/galleries/"+path+"/large/"+iter+"."+ext;
        img.src = "/images/galleries/"+path+"/"+iter+"."+ext;
        counter.innerHTML = (iter+1) + " of " + filecount;
}

function image_gallery_previous(path, filecount, ext)
{
        var underpath = path.replace(/\//g, "_");
        var counter = $("image_gallery_counter_"+underpath);
        var a1 = $("image_gallery_largelink1_"+underpath);
        var a2 = $("image_gallery_largelink2_"+underpath);
        var img = $("image_gallery_"+underpath);
        var restr = "(\\d+)[.]"+ext;
        re = new RegExp(restr);
        var srcmatch = re.exec(img.src);
        var iter = parseInt(srcmatch.length > 0 ? srcmatch[1] : '0');
        iter--;
        if (iter < 0) { iter = filecount-1; }

        a1.href = "/images/galleries/"+path+"/large/"+iter+"."+ext;
        a2.href = "/images/galleries/"+path+"/large/"+iter+"."+ext;
        img.src = "/images/galleries/"+path+"/"+iter+"."+ext;
        counter.innerHTML = (iter+1) + " of " + filecount;
}

function sample_image_gallery_previous(path)
{
	var classname = "sample_image_"+path;
	var images = document.getElementsByClassName(classname);
	//var images = $('.'+classname);
	var next_ix = 0;
	for(var i = 0; i < images.length; i++)
	{
		var image = images[i];
		if (!image.hasClassName('hidden'))
		{
			next_ix = i - 1;
			image.addClassName('hidden');
		}
	}
	if (next_ix < 0)
	{
		next_ix = images.length - 1;
	}

	images[next_ix].removeClassName('hidden');
	$("image_gallery_counter_"+path).innerHTML = (next_ix+1) + " of " + count;
}


function sample_image_gallery_next(path)
{
	var classname = "sample_image_"+path;
	//var images = $(classname);
	var images = document.getElementsByClassName(classname);
	var count = images.length;
	var next_ix = 0;
	for(var i = 0; images != null && i < images.length; i++)
	{
		var image = images[i];
		if (!image.hasClassName('hidden'))
		{
			next_ix = i + 1;
			image.addClassName('hidden');
		}
	}
	if (next_ix >= images.length)
	{
		next_ix = 0;
	}

	images[next_ix].removeClassName('hidden');
	$("image_gallery_counter_"+path).innerHTML = (next_ix+1) + " of " + count;
}

function selectCharm(container, charm_id)
{
	//$('customCharm').value = charm_id;
	$('charmID').value = charm_id;
	var hidden = $('charmID_hidden');
	if (hidden)
	{
		hidden.value = charm_id;
	}
	//$('charm_name').innerHTML = charm_name;
	//$('charm_img').src = image_url;
	// Erase highlight on all other classes!
	var charms = document.getElementsByClassName("charm");
	for (var i = 0; i < charms.length; i++)
	{
		charms[i].removeClassName("charm_selected");
	}
	container.addClassName("charm_selected");
	//document.location.href = "#top";
	$('quantity').select();
}

function confirmTasselSelected()
{
	//var tassel_color = $('customTassel').value;
	var tassel_color = $('tasselID').value;
	if (tassel_color == "")
	{
		alert("Please select a tassel color.");
		return false;
	} else {
		return true;
	}
}

function selectTassel(container, tassel_id, tassel_name, image_url, image_url_thumb)
{
	//$('customTassel').value = tassel_id;
	$('tasselID').value = tassel_id;
	//alert($('tasselID').value);
	var hidden = $('tasselID_hidden');
	if (hidden)
	{
		hidden.value = tassel_id;
	}
	//$('tassel_name').innerHTML = tassel_name;
	//$('tassel_img_large').href = image_url;
	// Need to 'reset' shadowbox for this one link.... so url not cached.
	Shadowbox.setup($('tassel_img_large'));
	//, { background: '#FFFFFF' } );

	/*
	$('tassel_img').src = image_url_thumb;
	*/
	// Erase highlight on all other classes!
	var tassels = document.getElementsByClassName("tassel");
	for (var i = 0; i < tassels.length; i++)
	{
		tassels[i].removeClassName("tassel_selected");
	}
	container.addClassName("tassel_selected");
	//document.location.href = "#top";
	$('quantity').select();
}

function assertMinimum(min)
{
	var autofill = arguments.length >= 2 ? arguments[2] : true;
	var field = $('quantity');
	if (!field) { return true; }
	var qty = field.value;
	if (qty < parseInt(min))
	{
		alert("The minimum quantity for purchase is "+min);
		if(autofill)
		{
			$('quantity').value = min;

			var hidden = $('quantity_hidden');
			if (hidden)
			{
				hidden.value = min;
			}
		}
		return false;
	} else {
		return true;
	}
}

function assertTasselSelected(min)
{
	var tasselID = $('tasselID_hidden').value;
	if (tasselID == "")
	{
		alert("Please select a tassel");
		return false;
	}
	return assertMinimum(min);
}

function assertCharmSelected(min)
{
	//var charmID = $('customCharm').value;
	var charmID = $('charmID_hidden').value;
	if (charmID == "")
	{
		alert("Please select a charm");
		return false;
	}
	return assertMinimum(min);
}

function sample_gallery_select_filter(sel, container_prefix)
{
	var id = container_prefix + "_" + sel.value;

	// Get all
	var containers = document.getElementsByClassName(container_prefix);
	var next_ix = 0;
	for(var i = 0; i < containers.length; i++)
	{
		var container = containers[i];
		if (!container.hasClassName('hidden'))
		{
			container.addClassName('hidden');
		}
	}
	$(id).removeClassName('hidden');
	// Remove hidden from one we want...
}

function stamp_dropshadow(container)
{
	var inner = $('stamp_inner_dropshadow');
	var drop = $('stamp_dropshadow');
	var container = $('stamp');
	var img = $('stamp_img');

	var img_w = img.width;
	var img_h = img.height;

	/*alert(img_w);
	alert(img_h);*/

	var wrap1 = document.createElement("div");
	wrap1.style.backgroundColor = '#CCC';
	wrap1.style.width = img_w + 5;
	wrap1.style.height = img_h + 5;
	wrap1.style.position = "absolute";
	wrap1.style.zIndex = "-1";
	img.style.zIndex = "100";
	wrap1.style.top = "1px";
	wrap1.style.left = "1px";

	var outerNode = img.parentNode;
	outerNode.style.position = "relative";
	outerNode.insertBefore(wrap1, img);

}

function selectTab(key)
{
	var suffix = arguments.length > 1 ? arguments[1] : "tab";
	var tab_id = key+"_"+suffix;
	var tab_content_id = key+"_"+suffix+"_content";

	var tabs = document.getElementsByClassName(suffix);
	var tab_contents = document.getElementsByClassName(suffix+"_content");

	for(i = 0; i < tab_contents.length; i++)
	{
		var tc = tab_contents[i];
		if (tc.id == tab_content_id)
		{
			tc.addClassName('selected_'+suffix+"_content");
		} else {
			tc.removeClassName('selected_'+suffix+"_content");
		}
	}

	for(i = 0; i < tabs.length; i++)
	{
		var t = tabs[i];
		if (t.id == tab_id)
		{
			t.addClassName('selected_'+suffix);
		} else {
			t.removeClassName('selected_'+suffix);
		}
	}
}

function selectProductValue(productCode)
{
	var field = $('productCode');
	var field_hidden = $('productCode_hidden');
	if (field)
	{
		field.value = productCode;
	}
	if (field_hidden)
	{
		field_hidden.value = productCode;
	}
}

function image_gallery_scroll_right(gallery_id)
{
	var container_id = gallery_id+"_row";
	var container = $(container_id);
	//var images = container.select("td");
	var images = container.getElementsByClassName("image");
	var next_ix = 0;
	for (var i = 0; i < images.length; i++)
	{
		var image = images[i];
		if (!image.hasClassName("hidden"))
		{
			next_ix = i+1;
		}
		image.addClassName("hidden");
	}
	if (next_ix >= images.length) { next_ix = 0; }
	images[next_ix].removeClassName("hidden");

	var counter_id = gallery_id+"_counter";
	var counter = $(counter_id);
	if(counter)
	{
		counter.innerHTML = next_ix+1;
	}

	return false;
}

function image_gallery_scroll_left(gallery_id)
{
	var container_id = gallery_id+"_row";
	var container = $(container_id);
	//var images = container.select("td");
	var images = container.getElementsByClassName("image");
	var next_ix = 0;
	for (var i = 0; i < images.length; i++)
	{
		var image = images[i];
		if (!image.hasClassName("hidden"))
		{
			next_ix = i-1;
		}
		image.addClassName("hidden");
	}
	if (next_ix < 0) { next_ix = images.length-1; }
	images[next_ix].removeClassName("hidden");

	var counter_id = gallery_id+"_counter";
	var counter = $(counter_id);
	if(counter)
	{
		counter.innerHTML = next_ix+1;
	}

	return false;
}


function image_gallery_album_scroll_right(container_id)
{
        var container = $(container_id);
        //var images = container.select("td");
        var images = container.getElementsByClassName("image");
        var image = images[0].remove();
        container.insert( { bottom: image } );
        return false;
}

function image_gallery_album_scroll_left(container_id)
{
        var container = $(container_id);
        //var images = container.select("td");
        var images = container.getElementsByClassName("image");
        var image = images[images.length-1].remove();
        container.insert( { top: image } );
        return false;
}

function dump(arr,level) 
{
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) { level_padding += "    "; }

	var line_count = 0;
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof value == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\", ";
			}
			if (dumped_text.length / 120 > line_count) { dumped_text += "\n"; line_count++; }
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}

function print_r(what)
{
	alert(dump(what));
}

function wait(msecs)
{
	var start = new Date().getTime();
	var cur = start
	while(cur - start < msecs)
	{
		cur = new Date().getTime();
	}
} 



sprintfWrapper = {
 
	init : function () {
 
		if (typeof arguments == 'undefined') { return null; }
		if (arguments.length < 1) { return null; }
		if (typeof arguments[0] != 'string') { return null; }
		if (typeof RegExp == 'undefined') { return null; }
 
		var string = arguments[0];
		var exp = new RegExp(/(%([%]|(\-)?(\+|\x20)?(0)?(\d+)?(\.(\d)?)?([bcdfosxX])))/g);
		var matches = new Array();
		var strings = new Array();
		var convCount = 0;
		var stringPosStart = 0;
		var stringPosEnd = 0;
		var matchPosEnd = 0;
		var newString = '';
		var match = null;
 
		while (match = exp.exec(string)) {
			if (match[9]) { convCount += 1; }
 
			stringPosStart = matchPosEnd;
			stringPosEnd = exp.lastIndex - match[0].length;
			strings[strings.length] = string.substring(stringPosStart, stringPosEnd);
 
			matchPosEnd = exp.lastIndex;
			matches[matches.length] = {
				match: match[0],
				left: match[3] ? true : false,
				sign: match[4] || '',
				pad: match[5] || ' ',
				min: match[6] || 0,
				precision: match[8],
				code: match[9] || '%',
				negative: parseInt(arguments[convCount]) < 0 ? true : false,
				argument: String(arguments[convCount])
			};
		}
		strings[strings.length] = string.substring(matchPosEnd);
 
		if (matches.length == 0) { return string; }
		if ((arguments.length - 1) < convCount) { return null; }
 
		var code = null;
		var match = null;
		var i = null;
 
		for (i=0; i<matches.length; i++) {
 
			if (matches[i].code == '%') { substitution = '%' }
			else if (matches[i].code == 'b') {
				matches[i].argument = String(Math.abs(parseInt(matches[i].argument)).toString(2));
				substitution = sprintfWrapper.convert(matches[i], true);
			}
			else if (matches[i].code == 'c') {
				matches[i].argument = String(String.fromCharCode(parseInt(Math.abs(parseInt(matches[i].argument)))));
				substitution = sprintfWrapper.convert(matches[i], true);
			}
			else if (matches[i].code == 'd') {
				matches[i].argument = String(Math.abs(parseInt(matches[i].argument)));
				substitution = sprintfWrapper.convert(matches[i]);
			}
			else if (matches[i].code == 'f') {
				matches[i].argument = String(Math.abs(parseFloat(matches[i].argument)).toFixed(matches[i].precision ? matches[i].precision : 6));
				substitution = sprintfWrapper.convert(matches[i]);
			}
			else if (matches[i].code == 'o') {
				matches[i].argument = String(Math.abs(parseInt(matches[i].argument)).toString(8));
				substitution = sprintfWrapper.convert(matches[i]);
			}
			else if (matches[i].code == 's') {
				matches[i].argument = matches[i].argument.substring(0, matches[i].precision ? matches[i].precision : matches[i].argument.length)
				substitution = sprintfWrapper.convert(matches[i], true);
			}
			else if (matches[i].code == 'x') {
				matches[i].argument = String(Math.abs(parseInt(matches[i].argument)).toString(16));
				substitution = sprintfWrapper.convert(matches[i]);
			}
			else if (matches[i].code == 'X') {
				matches[i].argument = String(Math.abs(parseInt(matches[i].argument)).toString(16));
				substitution = sprintfWrapper.convert(matches[i]).toUpperCase();
			}
			else {
				substitution = matches[i].match;
			}
 
			newString += strings[i];
			newString += substitution;
 
		}
		newString += strings[i];
 
		return newString;
 
	},
 
	convert : function(match, nosign){
		if (nosign) {
			match.sign = '';
		} else {
			match.sign = match.negative ? '-' : match.sign;
		}
		var l = match.min - match.argument.length + 1 - match.sign.length;
		var pad = new Array(l < 0 ? 0 : l).join(match.pad);
		if (!match.left) {
			if (match.pad == '0' || nosign) {
				return match.sign + pad + match.argument;
			} else {
				return pad + match.sign + match.argument;
			}
		} else {
			if (match.pad == '0' || nosign) {
				return match.sign + match.argument + pad.replace(/0/g, ' ');
			} else {
				return match.sign + match.argument + pad;
			}
		}
	}
}
 



sprintf = sprintfWrapper.init;

/**
*
*  Base64 encode / decode
*  http://www.webtoolkit.info/
*
**/
 
var Base64 = {
 
	// private property
	_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
 
	// public method for encoding
	encode : function (input) {
		var output = "";
		var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
		var i = 0;
 
		input = Base64._utf8_encode(input);
 
		while (i < input.length) {
 
			chr1 = input.charCodeAt(i++);
			chr2 = input.charCodeAt(i++);
			chr3 = input.charCodeAt(i++);
 
			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;
 
			if (isNaN(chr2)) {
				enc3 = enc4 = 64;
			} else if (isNaN(chr3)) {
				enc4 = 64;
			}
 
			output = output +
			this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
			this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
 
		}
 
		return output;
	},
 
	// public method for decoding
	decode : function (input) {
		var output = "";
		var chr1, chr2, chr3;
		var enc1, enc2, enc3, enc4;
		var i = 0;
 
		input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
 
		while (i < input.length) {
 
			enc1 = this._keyStr.indexOf(input.charAt(i++));
			enc2 = this._keyStr.indexOf(input.charAt(i++));
			enc3 = this._keyStr.indexOf(input.charAt(i++));
			enc4 = this._keyStr.indexOf(input.charAt(i++));
 
			chr1 = (enc1 << 2) | (enc2 >> 4);
			chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
			chr3 = ((enc3 & 3) << 6) | enc4;
 
			output = output + String.fromCharCode(chr1);
 
			if (enc3 != 64) {
				output = output + String.fromCharCode(chr2);
			}
			if (enc4 != 64) {
				output = output + String.fromCharCode(chr3);
			}
 
		}
 
		output = Base64._utf8_decode(output);
 
		return output;
 
	},
 
	// private method for UTF-8 encoding
	_utf8_encode : function (string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";
 
		for (var n = 0; n < string.length; n++) {
 
			var c = string.charCodeAt(n);
 
			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}
 
		}
 
		return utftext;
	},
 
	// private method for UTF-8 decoding
	_utf8_decode : function (utftext) {
		var string = "";
		var i = 0;
		var c = c1 = c2 = 0;
 
		while ( i < utftext.length ) {
 
			c = utftext.charCodeAt(i);
 
			if (c < 128) {
				string += String.fromCharCode(c);
				i++;
			}
			else if((c > 191) && (c < 224)) {
				c2 = utftext.charCodeAt(i+1);
				string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
				i += 2;
			}
			else {
				c2 = utftext.charCodeAt(i+1);
				c3 = utftext.charCodeAt(i+2);
				string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
				i += 3;
			}
 
		}
 
		return string;
	}
 
}
