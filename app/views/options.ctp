<? $code = $build['Product']['code'] ?>
<?  $all_options_by_code = Set::combine($all_options, "{n}.Part.part_code", "{n}"); ?>
<?
	$step = !empty($_REQUEST['step']) ? $_REQUEST['step'] : null;
?>
		<div class="build">
			<?#= $this->element("build/free"); ?>
			<?
				$i = 0;
			?>

			<? if(count($related_products) > 1) { ?>

			<? $option_code = 'style'; ?>
			<div id="step_<?= $option_code ?>" class="step<?= $i+1 ?> step <?= empty($step) || $step == $option_code ? "selected_step" : "" ?> <?= empty($build['complete']['product']) ? "incomplete_step" : "" ?>" valign="top">
					<table id="header_part_settings_<?= $option_code ?>" width="100%" class="step_header" cellpadding=0 cellspacing=0>
					<tr>
						<th align="left">
							<a class="bold" href="Javascript:void(0)" onClick="showBuildStep('style');">  
								STEP <span class='stepnum'><?= $i+1 ?></span>. Select a Style
							</a>
						</th>
						<td align="right" style="width: 125px;">
							<div id="done_part_settings_<?= $option_code ?>" class="complete">
							<span style="color: green; font-weight: bold; font-size: 1.2em;"><img src="/images/icons/check.png"/></span>
								<span style="font-weight: bold;">COMPLETED</span>
							</div>
						</td>
						</td>
					</tr>
					</table>


					<div id="part_settings_style" style="<?= $i > 1 ? "display: none;" : "" ?>" class="part_settings part_settings_<?= $i ?>">
						<? #if(in_array($build['Product']['code'], array('B','BNT','BC','BB'))) { ?>
							<?#= $this->element("build/options/laminate"); ?>
						<? #} else { ?>

						<?
							$imgtype = null;
							$imgid = null;
							if(!empty($build["CustomImage"]))
							{
								$imgtype = 'Custom';
								$imgid = $build['CustomImage']['Image_ID'];
							} else if(!empty($build["GalleryImage"])) { 
								$imgtype = 'Gallery';
								$imgid = $build['GalleryImage']['catalog_number'];
							}

							$blankProd = $build['Product']['code'];
							if(in_array($blankProd, array('BC'))) { $blankProd = 'B'; }
							if(in_array($blankProd, array('PSF'))) { $blankProd = 'PS'; }
							$blankdir = "/images/products/blanks/{$blankProd}";
							$vimg = "$blankdir/vertical/small/{$blankProd}.png";
							$himg = "$blankdir/horizontal/small/{$blankProd}.png";
							$img = file_exists(APP."/..".$himg) ? $himg : $vimg;
						?>

						<table width="100%">
						<tr>
							<? foreach($related_products as $rp) { ?>
							<td style="margin-bottom: 5px;" valign="bottom" width="<?= intval(100/count($related_products)); ?>%">
								<a href="/build/customize/<?= $rp['Product']['code'] ?>">
								<? /* ?><img src="/images/preview/<?= $rp['Product']['code'] ?><?= !empty($build['template']) ? "-{$build['template']}" : "" ?>/<?= $imgtype ?>/_<?= $imgid ?>/-150x150.png"/> <? */ ?>
								<img src="/images/blanks/<?= $rp['Product']['code'] ?>/<?= !empty($build['template']) ? $build['template'] : 'standard' ?>/x75.png"/>
								</a>
							</td>
							<?  } ?>
						</tr>
						<tr>
							<? foreach($related_products as $rp) { ?>
							<td valign="top">
								<label>
								<input type="radio" style="vertical-align: middle;" name="prod" onClick="showPleaseWait(); document.location.href = '/build/customize/'+this.value;" <?= $build['Product']['code'] == $rp['Product']['code'] ? "checked='checked'" : ""; ?> value="<?= $rp['Product']['code'] ?>"> 
								<?= !empty($rp['Product']['pricing_name']) ? strip_tags($rp['Product']['pricing_name']) : strip_tags($rp['Product']['name']); ?>
									<? if(!empty($rp['Product']['pricing_description'])) { ?>
									<div style="font-size: 10px;">
										<br/>
										<?= $rp['Product']['pricing_description'] ?>
									</div>
									<? } ?>
								</label>
									<? if(!empty($rp['Product']['build_notes'])) { ?>
									<div class="relative">
									<a href="Javascript:void(0)" onClick="$('info_style_<?= $rp['Product']['code'] ?>').toggle()"><img src="/images/icons/info.png"/></a>
									<div class="part_info" id="info_style_<?= $rp['Product']['code'] ?>" style="display: none; background-color: #FFF; border: solid #666 2px; color: #000; position: absolute; top: 25px; right: 0px; width: 300px; font-weight: normal; padding: 10px;">
										<div align="right">
											<a style="color: blue;" href="Javascript:void(0)" onClick="$('info_style_<?= $rp['Product']['code'] ?>').hide();">Close</a>
										</div>
										<div>
											<?= $rp['Product']['build_notes'] ?>
										</div>
									</div>
									</div>
									<? } ?>
							</td>
							<? } ?>
						</tr>
						</table>

						<? #} ?>

						<br/>

						<div style="padding-right: 100px;" align="right">
							<a href="Javascript:void('style');" onClick="showBuildStepNext('<?= $option_code ?>');"><img src="/images/buttons/small/Continue-green.gif"></a>
						</div>
					</div>
			</div>
			<? $i++; } ?>

			<? 
			$product_templates = split(",", $build['Product']['product_template']);

			$text_options = array();
			if(!empty($build['Product']['image_and_text']))
			{
				foreach($options as $option) { 
					$option_code = $option['Part']['part_code'];
					if($option_code == 'quote')
					{
						$text_options[$option_code] = 'Quotation &bull; Text Options <span style="font-size: 12px;">(optional)</span>';
					}
					if($option_code == 'personalization')
					{
						$text_options[$option_code] = 'Personalization <span style="font-size: 12px;">(optional)</span>';
					}
				}
			}

			$layouts = array();
			if(!empty($build['Product']['image_and_text'])) { $layouts[] = 'standard'; }
			if(!empty($build['Product']['imageonly'])) { $layouts[] = 'imageonly'; }
			if(!empty($build['Product']['fullbleed']) && empty($build['Product']['imageonly'])) { $layouts[] = 'imageonly'; }
			$default_layout = !empty($build['template']) ? $build['template'] : (!empty($layouts) ? $layouts[0] : 'standard');

			?>
			<? if(false) { ?>

			<? if($build['Product']['code'] != 'P' && count($layouts) >= 2 && !empty($build['CustomImage'])) { $option_code = 'layout'; ?>
			<div id="step_<?= $option_code ?>" class="step step<?=$i+1?> <?= $step == $option_code || $i == 0 ? "selected_step" : "" ?> <?= empty($build['complete'][$option_code]) ? "incomplete_step" : "" ?>" valign="top">
					<table id="header_part_settings_<?= $option_code ?>" width="100%" class="step_header" cellpadding=0 cellspacing=0>
					<tr>
						<th align="left">
							<a class="bold" href="Javascript:void(0)" onClick="showBuildStep('<?=$option_code?>');">  
								STEP <span class='stepnum'><?= $i+1 ?></span>. Choose Layout
							</a>
						</th>
						<td align="right" style="width: 125px;">
							<div id="done_part_settings_<?= $option_code ?>" class="complete">
							<span style="color: green; font-weight: bold; font-size: 1.2em;"><img src="/images/icons/check.png"/></span>
								<span style="font-weight: bold;">COMPLETED</span>
							</div>
						</td>
					</tr>
					</table>

					<div id="part_settings_<?=$option_code?>" style="<?= $i == 0 || $step == $option_code ? "" : "display: none;"  ?> " class="part_settings part_settings_<?= $i ?>">
						<?=
							$this->element("build/step", array('option_code'=>$option_code,'top_next'=>true)); 
						?>
					</div>
			</div>
			<? $i++; } else { ?>
				<input id="layout" type="hidden" name="data[template]" value="<?= $default_layout ?>"/>
				<!-- gets changed by form itself... based on presence of quote -->
			<? } ?>

			<? } else if (!empty($text_options)) { $option_code = 'text'; 
				$tptlist = array();
				if(array_key_exists('quote', $text_options))
				{
					$tptlist[] = "Quotation &bull; Text <span style='font-size: 12px;'>(optional)</span>";
				}
				if(array_key_exists('personalization', $text_options))
				{
					$tptlist[] = "Personalization <span style='font-size: 12px;'>(optional)</span>";
				}
				#$textpers_title = "LAYOUT: " . join(" &bull; ", $tptlist);

				$textpers_title = !empty($build['CustomImage']) && count($layouts) > 1 && false ? "Layout &bull; Text Options" : "Text Options";
			
			?>
			<div id="step_<?= $option_code ?>" class="step step<?=$i+1?> <?= $step == $option_code || $i == 0 ? "selected_step" : "" ?> <?= empty($build['complete'][$option_code]) ? "incomplete_step" : "" ?>" valign="top">
					
					<table id="header_part_settings_<?= $option_code ?>" width="100%" class="step_header" cellpadding=0 cellspacing=0>
					<tr>
						<th align="left">
							<a class="bold" href="Javascript:void(0)" onClick="showBuildStep('<?=$option_code?>');">  
								STEP <span class='stepnum'><?= $i+1 ?></span>. Select <?= $textpers_title ?>
							</a>
						</th>
						<td align="right" style="width: 125px;">
							<div id="done_part_settings_<?= $option_code ?>" class="complete">
							<span style="color: green; font-weight: bold; font-size: 1.2em;"><img src="/images/icons/check.png"/></span>
								<span style="font-weight: bold;">COMPLETED</span>
							</div>
						</td>
					</tr>
					</table>

					<div id="part_settings_<?=$option_code?>" style="<?= $i == 0 || $step == $option_code ? "" : "display: none;"  ?> " class="part_settings part_settings_<?= $i ?>">
						<?= $this->element("build/step", array('option_code'=>'layout','top_next'=>false,'next'=>false)); ?>

						<div id="text_details" align="center">

						<table style="text-align: left;">
						<?= !empty($vertical) ? "" : "<tr>"; ?>
						<? foreach($text_options as $to => $to_title) { 
							$style =  '';#'display:none;';
							if($to == 'quote' && $build['template'] == 'standard')
							{
								$style = '';#display: block;';
							}
							if($to == 'personalization' && $build['template'] != 'imageonly_nopersonalization' && empty($build['options']['personalizationNone']))
							{
								$style = '';#display: block;';
							}
							if(count($layouts) <= 1) { $style = ''; }

							$default_add = false;
							if(isset($build['options'][$to."None"]))
							{
								$default_add = !$build['options'][$to."None"]; # If set.
							} else if ($to == 'personalization') {
								$default_add = false;#!empty($build['GalleryImage']); # Stamps default standard
							}
							error_log("TO=$to, DEFAULT=$default_add, NONE=".print_r($build['options'],true));
						?>
						<?= !empty($vertical) ? "<tr>" : ""; ?>
						<td valign="top" style="<?= $style ?>">
							<div class='selected_box' id="<?= $to ?>_container">
								<h3 class="bold"><?= $to_title ?></h3>
								<? if(empty($build['GalleryImage']) || $to != 'quote') { ?>
								<div class=""> <label for="<?= $to ?>None">
									<input id="<?= $to ?>None" type="radio" name="data[options][<?=$to ?>None]" value="1" <?= !$default_add ? "checked='checked'" : "" ?> /> No <?= $to ?>
								</label> </div>
								<div class="clear"></div>

								<div class=""> <label for="<?= $to ?>Add">
									<input id="<?= $to ?>Add" type="radio" name="data[options][<?=$to ?>None]" value="0" <?= $default_add ? "checked='checked'" : "" ?> /> Add a <?= $to ?>
								</label> </div>
								<div class="clear"></div>
								<? } ?>

								<div id="<?= $to ?>_details" style="<?= !$default_add ? "display:none;":"" ?>" >
									<?= $this->element("build/step", array('option_code'=>$to,'top_next'=>false,'next'=>false)); ?>
								</div>
							</div>
						</td>
						<?= !empty($vertical) ? "<tr>" : ""; ?>
						<? } ?>
						<?= !empty($vertical) ? "" : "</tr>"; ?>
						</table>
						</div>

						<div style="padding-right: 100px;" align="right">
							<a href="Javascript:void('style');" onClick="showBuildStepNext('<?= $option_code ?>');"><img src="/images/buttons/small/Continue-green.gif"></a>
						</div>

					</div>
			</div>

			<? $skip_text = true; $i++; } ?>

			<? if(false && !empty($build['CustomImage'])) { $option_code = 'adjust'; ?>
			<div id="step_<?= $option_code ?>" class="step <?= $step != $option_code ? "" : "selected_step" ?> <?= empty($build['complete'][$option_code]) ? "incomplete_step" : "" ?>" valign="top">
					<table id="header_part_settings_<?= $option_code ?>" width="100%" class="step_header" cellpadding=0 cellspacing=0>
					<tr>
						<th align="left">
							<a class="bold" href="Javascript:void(0)" onClick="showBuildStep('<?=$option_code?>');">  
								STEP <span class='stepnum'><?= $i ?></span>. Crop/Adjust Image
							</a>
						</th>
						<td align="right" style="width: 125px;">
							<div id="done_part_settings_<?= $option_code ?>" class="complete">
							<span style="color: green; font-weight: bold; font-size: 1.2em;"><img src="/images/icons/check.png"/></span>
								<span style="font-weight: bold;">COMPLETED</span>
							</div>
						</td>
					</tr>
					</table>

					<div id="part_settings_<?=$option_code?>" style="display: none;" class="part_settings part_settings_<?= $i ?>">
						<?= $this->element("build/step", array('option_code'=>$option_code,'top_next'=>true)); ?>
					</div>
			</div>
			<? $i++; } else { ?>
			<? } ?>
			<? $zindex = 800; ?>

			<? foreach($options as $option) { 
				$option_code = $option['Part']['part_code'];
				#if($option_code == 'personalization' || $option_code == 'quote') { continue; }
				if(in_array($option_code, array('quote','personalization')) && !empty($skip_text)) { continue; }

				$step_templates = array('standard','imageonly','imageonly_nopersonalization');
				if($code == 'PW' && $option_code == 'charm')
				{
					$step_templates = array('standard');
				}
				#echo "ST($code, $option_code)=".print_r($step_templates,true);
			?>
				<div id="step_<?= $option_code ?>" colspan=1 class="custom_step step<?=$i+1?> step <?= join(" ", $step_templates) ?> <?= empty($build['complete'][$option_code]) ? "incomplete_step" : "" ?> <?= ($i == 0 || $step == $option_code) ? "selected_step" : "" ?>" valign="top">
					<?
					$extra_charge = !empty($option['Part']['price']) ? " extra charge" : "";
					?>

					<table id="header_part_settings_<?= $option_code ?>" width="100%" class="step_header" cellpadding=0 cellspacing=0>
					<tr>
						<th align="left" style="">
						<div style="position: relative; z-index: <?= $zindex-- ?>;">
							<? if(!empty($option['Part']['part_description'])) { ?>
							<div class="right">
							<a href="Javascript:void(0)" onClick="$('info_<?= $option['Part']['part_code'] ?>').toggle()"><img src="/images/icons/info.png"/></a>
							<div class="part_info" id="info_<?= $option['Part']['part_code'] ?>" style="display: none; background-color: #FFF; border: solid #666 2px; color: #000; position: absolute; top: 25px; right: 0px; width: 450px; font-weight: normal; padding: 10px;">
								<div align="right">
									<a style="color: blue;" href="Javascript:void(0)" onClick="$('info_<?= $option['Part']['part_code'] ?>').hide();">Close</a>
								</div>
								<div>
									<?= $option['Part']['part_description'] ?>
								</div>
							</div>
							</div>
							<? } ?>
							<a class="bold" href="Javascript:void(0)" onClick="showBuildStep('<?= $option_code ?>');" style="position: relative;">  
								STEP <span class='stepnum'><?= $i+1 ?></span>. Select <?= $option['Part']['part_name'] ?> <? if($option['ProductPart']['optional'] == 'yes') { echo "(opt.) $extra_charge"; } ?>
							</a>
							<div class="clear"></div>
						</div>
						</th>
						<td align="right" style="width: 125px;">
							<div id="done_part_settings_<?= $option_code ?>" class="complete">
							<span style="color: green; font-weight: bold; font-size: 1.2em;"><img src="/images/icons/check.png"/></span>
								<span style="font-weight: bold;">COMPLETED</span>
							</div>
						</td>
					</tr>
					</table>

					<div id="part_settings_<?= $option_code ?>" style="<?= $i > 0 ? "display: none;" : "" ?>" class="part_settings part_settings_<?= $i ?>">
						<?= $this->element("build/step", array('option_code'=>$option_code,'option'=>$option)); ?>
					</div>
				</div>
			<? $i++; } $option_code = 'comments'; ?>

				<? if(true || empty($vertical)) { ?>
					<?= $this->element("build/proof",array('i'=>$i,'step'=>$step)); ?>
					<? $i++; ?>
				<? } ?>

			<?if(true || empty($vertical)) { ?>
			<?= $this->element("build/options/cart",array('i'=>$i,'step'=>$step)); ?>
			<? } ?>
		</div>

<script>
j(document).ready(function() {
	showBuildSteps();

});

<? if(!empty($_REQUEST['step'])) { ?>
	<? if(!empty($_REQUEST['next'])) { ?>
	document.observe('dom:loaded', function() { showBuildStepNext('<?= $_REQUEST['step'] ?>'); });
	<? } else { ?>
	document.observe('dom:loaded', function() { showBuildStep('<?= $_REQUEST['step'] ?>'); });
	<? } ?>
<? } ?>

// Need to add trigger for library quotes as well!

// XXX TODO switch layout if they update specific text/pers fields
j('#option_quote').change(function() {
	updateLayout();
});
/* borken
j('#browse').on('click', 'input[type=radio]', function() { // needs to use on() since quotes may not be there automatically
	console.log("CLICK QUOTE");
	updateLayout();
});
*/
j('#personalizationInput').change(function() {
	updateLayout();
});
j('#personalizationNone').click(function() {
	updateLayout();
	showText();
	// layout may stay the same yet text changes... so we need to
	// properly update text.
});
j('#quoteNone').click(function() {
	updateLayout();
});

j('#personalizationAdd').click(function() {
	updateLayout();
	showText();
	// layout may stay the same yet text changes... so we need to
	// properly update text.
});
j('#quoteAdd').click(function() {
	updateLayout();
});

function updateLayout() // this figureso ut what the layout should be based on what text there is/not
{
	// clicking on checkboxes needs to disable form fields... FIRST, so we react appropriately.
	if(j('#quoteNone').is(":checked"))
	{
		j('#quote_details').hide();
		j('#quote_details input, #quote_details textarea').attr('disabled','disabled');
	} else {
		j('#quote_details').show();
		j('#quote_details input, #quote_details textarea').removeAttr('disabled');
	}

	// show/hide boxes separately....
	if(j('#personalizationNone').is(":checked"))
	{
		j('#personalization_details').hide();
		j('#personalization_details input, #personalization_details textarea').attr('disabled','disabled');
	} else {
		j('#personalization_details').show();
		j('#personalization_details input, #personalization_details textarea').removeAttr('disabled');

	}

	// XXX there IS the chance that the layout doesn't change and goes from
	// blank text to filled text (ie std nopers to std+pers)
	// XXX

	var text = j('#quote_details').is(':visible');
	var pers = j('#personalization_details').is(':visible');

	var can_text = j('#quote_details').size();
	var stamp = j('#CatalogNumber').val();

	// xxx correct above so we dont lose fields of both when only one is checked.
	// layout needs to be accurate when field is empty, but box doesn't need to disappear unless None is checked.
	
	var layout = j('#template').val();
	// *** possibly change layout - letting text remain hidden, but not in product (disabled?)
	// - refresh product no matter what

	if(dbg)	console.log("L="+layout+", T="+text+", P="+pers);

	// layout itself will hide/show appropriate texts

	// XXX this is where stamps accidentally are moved to imageonly w/pers on top when adding text.

	//console.log("STMAP="+stamp+", T="+text+"P="+pers+", L="+layout);

	if(stamp) { 
		if(!text && !pers) // && layout != 'imageonly_nopersonalization')
		{
			setLayout("imageonly_nopersonalization");
		} else if (pers && (!text || !can_text)) { // && layout != 'imageonly') {
			setLayout("imageonly");
		} else if ((text || pers)) {// && layout != 'standard') {
			setLayout("standard");
		}
		return;
		/*
		if(!pers && !text && layout == 'standard')
		{
			setLayout('imageonly_nopersonalization');
		} else {
			setLayout('standard');
		}
		*/
		//return; 
	} /// no changes for stamp!

	// XXX todo disabled text/pers
	if(text && (layout != 'standard' || !pers)) // with or without pers
	{
		setLayout('standard');
		j('#text_details input, #text_details textarea').removeAttr('disabled');
		//j('#personalization_details input, #personalization_details textarea').removeAttr('disabled');
		j('#template').val('standard');
	} else if (!text && !pers && layout != 'imageonly_nopersonalization') { 
		// XXX correction, if both are blank, hidden should be imnop
		// but don't hide both boxes.

		setLayout('imageonly_nopersonalization');
		//j('#personalization_details input, #personalization_details textarea').attr('disabled','disabled');
		j('#template').val('imageonly_nopersonalization');
	} else if (pers && !text && layout != 'imageonly' && (!stamp || can_text)) {
		setLayout('imageonly');
		//j('#text_details input, #text_details textarea').attr('disabled','disabled');
		j('#template').val('imageonly');
	}



	// XXX TODO if they complete this step and lave both text and pers empty,
	// we should auto-check the none fields....
}
</script>
