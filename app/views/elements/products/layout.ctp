<?
$this->set("cropper",true);
$rotate = !empty($build['rotate']) ? $build['rotate'] : null;
?>
	<script>

	function setLayout(layout, load)
	{
		/*
		showPleaseWait();
		document.location.href = '<?= $url ?>?step=layout&next=1&layout='+layout;
		*/
		var borderID = j('input[name=data\\[options\\]\\[borderID\\]:checked').val();

		if(layout == 'imageonly')
		{
			j('#personalization_details').show();
			j('#persColorBox').show();
			j('#personalization_details input, #personalization_details textarea').prop('disabled','');
			j('#quote_details').hide();
			j('#quote_details input, #quote_details textarea').prop('disabled','disabled');
			j('#personalizationNone').val('');

			if(borderID != '-1' && j('#step_border').size() && !j('#step_border').hasClass('completed_step')) // only have default and no longer needing.
			{
				selectBorder('-1'); // clear border if wasnt explicit.
			}

		} else if(layout == 'imageonly_nopersonalization') // Going to image only. no text. not even personalization.
		{
			//layout == 'imageonly';
			j('#personalizationNone').val('1'); // hidden field, now, set to 1, not checkbox/radio

			/*
			// DONT remove content, just in case they change their mind...

			j('#option_quote').val('').blur(); // clear text and trigger ghostable.
			j('#other_quoteID').prop('checked','checked'); // clear quotes
			j('#personalizationInput').val(''); // clear text.
			*/


			j('#quote_details').hide();
			j('#quote_details input, #quote_details textarea').prop('disabled','disabled');
			// disabled fields so form won't submit.

			j('#personalization_details').hide();
			j('#personalization_details input, #quote_details textarea').prop('disabled','disabled');

			if(borderID != '-1' && j('#step_border').size() && !j('#step_border').hasClass('completed_step')) // only have default and no longer needing.
			{
				selectBorder('-1'); // clear border if wasnt explicit.
			}
		} else {
			j('#quote_details').show();
			j('#personalization_details').show();
			j('#personalizationNone').val('');
			j('#persColorBox').hide();
			j('#persColorBlack').attr('checked','checked'); // Force black.

			j('#quote_details input, #quote_details textarea').prop('disabled','');
			j('#personalization_details input, #quote_details textarea').prop('disabled','');
		}


		j('#template').val(layout);

		showBuildSteps();

		var data = j('#build_form').serializeObject();
	
		if(j('#option_quote').hasClass('default_text'))
		{
			//console.log("DEFAULT_TEXT");
			data['data[options][customQuote]'] = ''; // Clear if just default.
		}

		//updateText(null, layout); // switch product view.
		if(layout == 'standard')
		{
			var border_settings = j('#step_border');
	
			j('#build_img_container').load("/build/preview_adjust/standard", data, function() {  // Serialize() will pass quote to build, so it's stored in session for setPart.
				setPart('<?= !empty($scaled_coords['text']) ? 'text':'personalization' ?>', "/product_image/print_text/standard?rand="+(Math.random()*500000), load);
				if(j('#border_2').size() && (!j('#step_border.completed_step').size()))
				// Border step not complete, it's ok to put in default.
				{
					selectBorder('2',true);
				}
	
				if(!load)
				{
					reloadParts();
					// could be messing up border here...
				}
			});
		} else if (layout == 'imageonly' || layout == 'imageonly_nopersonalization') {
			j('#build_img_container').load("/build/preview_adjust/"+layout, data, function() { 
				//console.log("LOADING IMAGEONLY");
	
				/////j('#template').val('imageonly');
				//if(part == 'text') { clearPart(part); }
	
				if(j('#border_-1').size() && (!j('#step_border.completed_step').size())) // border step not complete, ok to remove.
				{
					selectBorder('-1',true); // will clear
				}
	
				if(!load)
				{
					reloadParts();
				}	
			});
		}
	}
	</script>
<div style="padding: 10px;">

	<!--<input type="hidden" name="data[options][fullbleed]" value="<?= !empty($build['options']['fullbleed']) ?>"/>-->

	<table>
	<tr>
	<? if(empty($product_config['image.2']) && empty($product_config_fullview['image.2'])) { ?>
		<? if(!empty($build['Product']['imageonly']) || !empty($build['Product']['fullbleed'])) { ?>
		<td valign="bottom" width="200" align="center">
			<?=
				$this->element("build/preview", array('template'=>'imageonly_nopersonalization','noimage'=>0,'no_view_larger'=>1,'fullbleed'=>0,'set_layout_link'=>1,'scale'=>'-115x115','rotate'=>$rotate)); 
				# XXX TODO no personalization, either.
			?>
		</td>
		<? } ?>
		<?
		$standard_options_map = Set::combine($standard_options, '{n}.Part.part_code', '{n}');
		if(!empty($standard_options_map['personalization']) && !in_array($build['Product']['code'], array('RL')))
		{
		?>
		<td valign="bottom" width="200" align="center">
			<?= 
				$this->element("build/preview", array('template'=>'imageonly','no_view_larger'=>1,'noimage'=>0,'fullbleed'=>0,'set_layout_link'=>1,'scale'=>'-115x115','rotate'=>$rotate)); 
				# XXX TODO image + personalization.
			?>
		</td>
		<?
		}
		if(!empty($standard_options_map['quote'])) 
		{
		?>
		<td valign="bottom" width="200" align="center">
			<?= 
				$this->element("build/preview", array('template'=>'standard','noimage'=>0,'no_view_larger'=>1,'fullbleed'=>0,'set_layout_link'=>1,'scale'=>'-115x115','rotate'=>$rotate)); 
				# XXX TODO image + quote + personalization.
			?>
		</td>
		<?
		}
		?>
	<? } else { ?>
		<td valign="bottom" width="200" align="center">
			<?= $this->element("build/preview", array('noimage'=>0,'template'=>'imageonly_nopersonalization','no_view_larger'=>1,'fullbleed'=>0,'set_layout_link'=>1,'rotate'=>$rotate,'scale'=>'-115x115')); ?>
		</td>
		<? /*
		<td valign="bottom" width="200" align="center">
			<?= $this->element("build/preview", array('template'=>'imageonly','noimage'=>0,'no_view_larger'=>1,'fullbleed'=>0,'set_layout_link'=>1,'rotate'=>$rotate,'scale'=>'-115x115')); ?>
		</td>
		*/ ?>
		<td valign="bottom" width="200" align="center">
			<?= $this->element("build/preview", array('noimage'=>0,'template'=>'standard','no_view_larger'=>1,'fullbleed'=>0,'set_layout_link'=>1,'rotate'=>$rotate,'scale'=>'-115x115')); ?>
		</td>
	<? } ?>
	</tr>
	<tr>
	<? if(empty($product_config['image.2']) && empty($product_config_fullview['image.2'])) { ?>
		<? if(!empty($build['Product']['imageonly']) || !empty($build['Product']['fullbleed'])) { ?>
		<td valign="top" width="200" align="center">

			<label>
			<!-- TODO W/O PERS -->
			<input type="radio" name="data[templateALT]" value="imageonly_nopersonalization" <?= ($build['template'] == 'imageonly_nopersonalization' || !empty($build['options']['personalizationNone'])) ? "checked='checked'" : "" ?> onClick="setLayout(this.value);"/> Image only<br/>
			</label>
		</td>
		<? } ?>
		<? if(!empty($standard_options_map['personalization']) && !in_array($build['Product']['code'], array('RL')))  { ?>
		<td valign="top" width="200" align="center">
			<label>
			<!-- TODO W/PERS -->
			<input type="radio" name="data[templateALT]" value="imageonly" <?= (($build['template'] == 'imageonly' && empty($build['options']['personalizationNone'])) || empty($build['template'])) ? "checked='checked'" : "" ?> onClick="setLayout(this.value);"/> Image and personalization<br/>(customize below)
			</label>
		</td>
		<? } ?>
		<? if(!empty($standard_options_map['quote']))  { ?>
		<td valign="top" width="200" align="center">
			<label>
			<!-- TODO W/PERS -->
			<input type="radio" name="data[templateALT]" value="standard" <?= ($build['template'] == 'standard' || empty($build['template'])) ? "checked='checked'" : "" ?> onClick="setLayout(this.value);"/> Image, quotation/text, and personalization<br/>(customize below)
			</label>
		</td>
		<? } ?>
	<? } else { ?>
		<td valign="top" width="200" align="center">
			<label>
			<input type="radio" name="data[template]" value="imageonly_nopersonalization" <?= ($build['template'] == 'imageonly_nopersonalization') || ($build['template'] == 'imageonly' && !empty($build['options']['personalizationNone'])) ? "checked='checked'" : "" ?> onClick="setLayout(this.value);"/> Image only on both sides<br/>
			</label>
		</td>
		<!--
		<td valign="top" width="200" align="center">
			<label>
			<input type="radio" name="data[template]" value="imageonly" <?= ($build['template'] == 'imageonly' && empty($build['options']['personalizationNone'])) ? "checked='checked'" : "" ?> onClick="setLayout(this.value);"/> Image and personalization on both sides
			</label>
		</td>
		-->
		<td valign="top" width="200" align="center">
			<label>
			<input type="radio" name="data[template]" value="standard" <?= ($build['template'] == 'standard' || empty($build['template'])) ? "checked='checked'" : "" ?> onClick="setLayout(this.value);"/> Image on front, text on back
			</label>
		</td>
	<? } ?>
	</tr>
	</table>



</div>
	
