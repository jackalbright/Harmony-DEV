<?  $all_options_by_code = Set::combine($all_options, "{n}.Part.part_code", "{n}"); ?>
		<div class="build">
			<? 
			$i = 0; 
			$product_templates = split(",", $build['Product']['product_template']);
			?>

				<? $i = 0; ?>
			<? if(count($related_products) > 1) { $option_code = 'product'; ?>
			<div id="step_<?= $option_code ?>" class="step selected_step <?= empty($build['complete']['product']) ? "incomplete_step" : "" ?>" valign="top">
					<table id="header_part_settings_<?= $option_code ?>" width="100%" class="step_header">
					<tr>
						<th align="left">
							<a class="bold" href="Javascript:void(0)" onClick="showBuildStep('product');">  
								STEP <?= $i+1 ?>. Product Type
							</a>
						</th>
						<td align="right">
							<div id="done_part_settings_<?= $option_code ?>" class="complete">
							<span style="color: green; font-weight: bold; font-size: 1.2em;"><img src="/images/icons/check.png"/></span>
								<span style="font-weight: bold;">COMPLETED</span>
							</div>
						</td>
					</tr>
					</table>

					<div id="part_settings_product" style="<?= $i > 0 ? "display: none;" : "" ?>" class="part_settings part_settings_<?= $i ?>">

						<div class="padded">
							<select name="prod" id="prod" onChange="showPleaseWait(); setProduct(this.value);">
							<? foreach($related_products as $rp) { ?>
								<option value="<?= $rp['Product']['code'] ?>"><?= !empty($rp['Product']['pricing_name']) ? $rp['Product']['pricing_name'] : $rp['Product']['name']; ?></option>
							<? } ?>
							</select>
							<script>
								function setProduct(code)
								{
									document.location.href = "/build/customize/"+code;
								}
								<? if(!empty($build['Product']['code'])) { ?>
								$('prod').value = '<?= $build['Product']['code'] ?>';
								<? } ?>
							</script>
						</div>

						<div align="left">
							<a href="Javascript:void(0);" onClick="showBuildStepNext('<?= $option_code ?>');"><img src="/images/buttons/small/Next-green.gif"></a>
						</div>
					</div>
			</div>
			<? $i++; } ?>

			<? if(($build['Product']['code'] != 'P')) { $option_code = 'layout'; ?>
			<div id="step_<?= $option_code ?>" class="step <?= $i > 0 ? "" : "selected_step" ?> <?= empty($build['complete'][$option_code]) ? "incomplete_step" : "" ?>" valign="top">
					<table id="header_part_settings_<?= $option_code ?>" width="100%" class="step_header">
					<tr>
						<th align="left">
							<a class="bold" href="Javascript:void(0)" onClick="showBuildStep('layout');">  
								STEP <?= $i+1 ?>. Layout &amp; Orientation
							</a>
						</th>
						<td align="right">
							<div id="done_part_settings_<?= $option_code ?>" class="complete">
							<span style="color: green; font-weight: bold; font-size: 1.2em;"><img src="/images/icons/check.png"/></span>
								<span style="font-weight: bold;">COMPLETED</span>
							</div>
						</td>
					</tr>
					</table>

					<div id="part_settings_layout" style="<?= $i > 0 ? "display: none;" : "" ?>" class="part_settings <?= $i > 0 ? "" : "selected_step"?> part_settings_<?= $i ?>">

					<table width="100%">
					<tr>
					<td width="50%">
					<?
						$image_and_text_label = !empty($product_config['image.2']) || !empty($product_config['fullview.2']) ? "Image on front, text on back" : "Image &amp; text";
						$image_only_label = !empty($product_config['image.2']) || !empty($product_config['fullview.2']) ? "Image on both sides" : "Image only";
					?>
					<select id="template" name="template" onChange="showPleaseWait(); setLayout(this.value);">
					<? if(!empty($product_config['image.2'])) { ?>
							<option value="standard"/><?= $image_and_text_label ?></option>
							<option value="imageonly"/><?= $image_only_label ?></option>
							<? if(!empty($product['Product']['fullbleed']) && !empty($build['CustomImage'])) { ?>
							<option value="imageonly_fullbleed"/><?= $image_only_label ?> - Full bleed</option>
							<? } ?>

					<? } else { ?>
					<?

					?>

							<? $image_only_default = true; ?>
							<? if(!empty($all_options_by_code['quote'])) { $image_only_default = false; ?>
							<option value="standard"/><?= $image_and_text_label ?></option>
							<? } ?>
							<option value="imageonly"/><?= $image_only_label ?></option>
							<? if(!empty($product['Product']['fullbleed']) && !empty($build['CustomImage'])) { ?>
							<option value="imageonly_fullbleed"/><?= $image_only_label ?> - Full bleed</option>
							<? } ?>
						</select>
					<? } ?>
					<? if(!empty($product['Product']['fullbleed']) && !empty($build['CustomImage'])) { ?>
						<div>
							<input id="fullbleed" type="checkbox" name="data[options][fullbleed]" value="1"/>Full bleed
						</div>
					<? } ?>
							<script>
								function setLayout(layout)
								{
									document.location.href = "/build/customize?step=layout&template="+layout
								}
								<? if(!empty($build['template'])) { ?>
									<? if(!empty($build['options']['fullbleed'])) { ?>
										$('fullbleed').checked = 'checked';
									<? } ?>
									$('template').value = '<?= $build['template'] ?>';
								<? } ?>
							</script>

					</td>
					<td width="40%">
						<? if(!empty($build['CustomImage'])) { ?>
							<br/>
							<a href="Javascript:void(0);" onClick="loadBuildCrop('<?= $build['template'] ?>');">Crop/Adjust image</a>
							<br/>
							<br/>
						<? } ?>

						<script>
						function loadBuildCrop(template)
						{
							// Load blank version on left. TODO
							new Ajax.Updater("cropwindow", "/build/crop_ajax", {method: 'post', asynchronous: 'true',evalScripts:'true'});
						}
						</script>

						<? if(!empty($malysoft)) { ?>

						<div class="padded">
							<b>Orientation:</b><br/>
							<select style="width: 100px;" id='orient' name="orient" onChange="updateBuildImage();">
								<option value="0">Normal</option>
								<option value="270">Rotate 90&deg; clockwise (right)</option>
								<option value="180">Rotate 180&deg; (upside-down)</option>
								<option value="90">Rotate 90&deg; counter-clockwise (left)</option>
							</select>
							<script>
							<? if(!empty($build['CustomImage']['orient'])) { ?>
							$('orient').value = '<?= $build['CustomImage']['orient'] ?>';
							<? } ?>
							</script>
						</div>

						<? } ?>

					</td>
					</tr></table>
					<?= $this->element("build/crop",array('data'=>$cropdata)); ?>
					<div id="cropwindow"></div>

						<div align="left">
							<a href="Javascript:void(0);" onClick="showBuildStepNext('<?= $option_code ?>');"><img src="/images/buttons/small/Next-green.gif"></a>
						</div>
					</div>
			</div>
			<? $i++; } else { ?>
			<? } ?>
			<input type="hidden" name="data[template]" value="<?= !empty($build['template']) ? $build['template'] : null ?>"/>



			<? foreach($options as $option) { 
				$option_code = $option['Part']['part_code'];
			?>
				<div id="step_<?= $option_code ?>" colspan=1 class="step <?= empty($build['complete'][$option_code]) ? "incomplete_step" : "" ?> <?= $i == 0 && empty($build['CustomImage']) ? "selected_step" : "" ?>" valign="top">
					<?
					$extra_charge = !empty($option['Part']['price']) ? " extra charge" : "";
					?>

					<table id="header_part_settings_<?= $option_code ?>" width="100%" class="step_header">
					<tr>
						<th align="left">
							<a class="bold" href="Javascript:void(0)" onClick="showBuildStep('<?= $option_code ?>');">  
								STEP <?= $i+1 ?>. <?= $option['Part']['part_name'] ?> <? if($option['ProductPart']['optional'] == 'yes') { echo "(opt.) $extra_charge"; } ?>
							</a>
						</th>
						<td align="right">
							<div id="done_part_settings_<?= $option_code ?>" class="complete">
							<span style="color: green; font-weight: bold; font-size: 1.2em;"><img src="/images/icons/check.png"/></span>
								<span style="font-weight: bold;">COMPLETED</span>
							</div>
						</td>
					</tr>
					</table>

					<div id="part_settings_<?= $option_code ?>" style="<?= $i > 0 ? "display: none;" : "" ?>" class="part_settings part_settings_<?= $i ?>">
	
						<? if(!empty($option['Part']['part_summary'])) { ?>
						<div class="part_summary">
							<?= $option['Part']['part_summary'] ?>
						</div>
						<? } ?>
	
						<?= $hd->product_element("build/options/$option_code", $build['Product']['prod'], array('i'=>$option_code,'option_code'=>$option_code)); ?>
	
						<div align="left">
							<a href="Javascript:void(0);" onClick="showBuildStepNext('<?= $option_code ?>');"><img src="/images/buttons/small/Next-green.gif"></a>
						</div>

					</div>
				</div>
			<? $i++; } $option_code = 'comments'; ?>

				<div id="step_<?= $option_code ?>" class="step">
					<table id="header_part_settings_<?= $option_code ?>" width="100%" class="step_header">
					<tr>
						<th align="left">
							<a class="bold" href="Javascript:void(0)" onClick="showBuildStep('comments');">STEP <?=$i+1 ?>. Your Comments</a>
						</th>
						<td align="right">
						</td>
					</tr>
					</table>

					<div style="display: none;" class="part_settings part_settings_<?= $i ?>" id="part_settings_comments" >

					<?= $this->element("build/options/comments"); ?>

					<table width="100%">
						<tr>
							<td align="left">
								&nbsp;
							</td>
							<td align="right">
								Choose your quantity and click 'Add to Cart'
							</td>
						</tr>
					</table>

					</div>
				</div>
		</div>

