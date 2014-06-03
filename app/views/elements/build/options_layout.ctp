<table width="100%">
	<tr>
	<td width="50%" valign="top">
	<?
		$image_and_text_label = !empty($product_config['image.2']) || !empty($product_config['fullview.2']) ? "Image on front, text on back" : "Image &amp; text";
		$image_only_label = !empty($product_config['image.2']) || !empty($product_config['fullview.2']) ? "Image on both sides" : "Image only";
	?>
	<? if(!empty($product_config['image.2'])) { ?>
		<div class="padded">
			<label class="nobr">
			<input type="radio" name="data[template]" <?= (empty($build['template']) || $build['template'] == 'standard') ? "checked='checked'" : ""; ?> value="standard" onClick="showPleaseWait(); document.location.href='/build/customize/<?= $prod ?>?template=standard&step=layout'; "/><?= $image_and_text_label ?>
			</label>
			<br/>
				<label class="bold nobr">
				<input type="radio" name="data[template]" <?= (!empty($build['template']) && $build['template'] == 'imageonly') ? "checked='checked'" : "" ?> value="imageonly" onClick="showPleaseWait(); document.location.href='/build/customize/<?= $prod ?>?template=imageonly&step=layout'; "/>
				<?= $image_only_label ?>
				</label>
				<br/>
				<? if(!empty($product['Product']['fullbleed']) && !empty($build['CustomImage']) && !empty($product_config['fullbleed'])) { ?>
				&nbsp; &nbsp; &nbsp;
				<label class="bold nobr">
				<input type="checkbox" name="data[options][fullbleed]" value="1" <?= (!empty($build['options']['fullbleed']) && $build['template'] == 'imageonly') ? "checked='checked'" : "" ?> onClick="showPleaseWait(); document.location.href='/build/customize/<?= $prod ?>?template=imageonly&step=layout&fullbleed='+(this.checked?1:0) "/> Full Bleed
				</label>
				<? } ?>
		</div>
	<? } else { ?>
	<?

	?>
		<div class="">
			<? $build['preview_layout'] = !empty($build['template']) ? $build['template'] : null;?>
			<?
				if($build['preview_layout'] == 'imageonly' && !empty($build['options']['fullbleed']))
				{
					$build['preview_layout'] = 'fullbleed';
				}
			?>
			<?= $this->element("build/select_layout",array('build'=>$build)); ?>
		</div>

		<div class="padded hidden">
			<? $image_only_default = true; ?>
			<? if(!empty($all_options_by_code['quote'])) { $image_only_default = false; ?>
			<label class="bold nobr">
			<input type="radio" name="data[template]" <?= (empty($build['template']) || $build['template'] == 'standard') ? "checked='checked'" : ""; ?> value="standard" onClick="showPleaseWait(); document.location.href='/build/customize/<?= $prod ?>?template=standard&step=layout'; "/><?= $image_and_text_label ?></label>
			<br/>
			<label class="bold nobr">
			<input type="radio" name="data[template]" <?= $image_only_default || (!empty($build['template']) && $build['template'] == 'imageonly') ? "checked='checked'" : "" ?> value="imageonly" onClick="showPleaseWait(); document.location.href='/build/customize/<?= $prod ?>?template=imageonly&step=layout'; "/><?= $image_only_label ?></label>
			<br/>
			<? } else { ?>
				<input type="hidden" name="data[template]" value="imageonly" />
			<? } ?>
				<? if(!empty($product['Product']['fullbleed']) && !empty($build['CustomImage'])) { ?>
				&nbsp; &nbsp; &nbsp;
				<input type="checkbox" name="data[options][fullbleed]" value="1" <?= (!empty($build['options']['fullbleed']) && $build['template'] == 'imageonly') ? "checked='checked'" : "" ?> onClick="showPleaseWait(); document.location.href='/build/customize/<?= $prod ?>?template=imageonly&step=layout&fullbleed='+(this.checked?1:0) "/> Full Bleed
				<? } ?>
		</div>
	<? } ?>

	</td>
	<td width="50%" valign="top">
		<? if(!empty($build['CustomImage'])) { ?>
			<div>
				<a href="Javascript:void(0)" onClick="showCropper();" class="bold">Click to crop/adjust image</a>
			</div>

			<div id="crop_outer_container" class='hidden'>
				<div class="relative" id="crop_container">
				<img id="crop_image" width="175" src="<?= $build['CustomImage']['display_location'] ?>?rand=<?=rand();?>"/>
				</div>
				<div class="clear"></div>
				<div style="font-size: 10px; font-variant: italic;">Draw a box inside your image to crop or adjust</div>
				<br/>
				<a href="Javascript:void(0);" onClick="saveCrop();"><img align="top" src="/images/buttons/small/Preview.gif"/></a>
				&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
				<a href="Javascript:void(0);" onClick="resetCrop();" class="underline_hover bold">Reset</a>
				<div class="clear"></div>
			</div>

					<div class="hidden <?= empty($malysoft) ? "hidden" : "" ?>">
						<input type="text" id="x" name="data[x]" size=5 />
						<input type="text" id="y" name="data[y]" size=5 />
						<br/>
						<input type="text" id="width" name="data[w]" size=5 />
						<input type="text" id="height" name="data[h]" size=5 />
					</div>
			<script type="text/javascript" src="/js/jcrop/jcrop.prototype.js"></script>
			<link rel="stylesheet" href="/css/jcrop.css" type="text/css" />
			<div class="hidden <?= empty($malysoft) ? "hidden" : null ?>">
			<? print_r($cropdata); ?>
			<br/>
			<br/>
			<? if(!empty($build['crop'])) { ?>
			<?print_r($build['crop']); ?>
			<? } ?>
			</div>

			<script>
				var cropper;

				Event.observe('crop_container', 'mouseout', function() { saveCropBackground(); });
				// How do we know they want these coords? if they don't want, they can click on 'reset'

				function showCropper()
				{
					$('crop_outer_container').removeClassName('hidden');
					loadCropper();
				}

				function resetCrop()
				{
					if(!cropper)
					{
						loadCropper();
					}
					<? if(empty($build['options']['fullbleed'])) { ?>
						cropper.release();
						$('x').value = '';
						$('y').value = '';
						$('width').value = '';
						$('height').value = '';
					<? } else { ?>
						var wh = cropper.getBounds();
						cropper.setSelect([ 0, 0, wh[0], wh[1] ]);
					<? } ?>
					saveCrop();
				}
				function bestFit()
				{
					if(!cropper)
					{
						loadCropper();
					}
					<?
						$start_w = $cropdata['bestfit']['scaled_w'];
                                                $start_h = $cropdata['bestfit']['scaled_h'];
                                                $start_x = $cropdata['bestfit']['scaled_x'];
                                                $start_y = $cropdata['bestfit']['scaled_y'];
					?>
					cropper.setSelect([ '<?= $start_x ?>', '<?= $start_y ?>', '<?= $start_x+$start_w ?>', '<?= $start_y+$start_h ?>' ]);
				}

				function loadCropper()
				{
	 				$('crop_image').jcrop(
						{
							onChange: setCoords,
							/*
								<? print_r($cropdata['crop']); ?>

							*/
							<? if(!empty($cropdata['crop']) && $cropdata['crop']['scaled_w'] > 0 && $cropdata['crop']['scaled_h'] > 0) { 
								$start_w = $cropdata['crop']['scaled_w'];
								$start_h = $cropdata['crop']['scaled_h'];
								$start_x = $cropdata['crop']['scaled_x'];
								$start_y = $cropdata['crop']['scaled_y'];
							?>
							setSelect: [ '<?= $start_x ?>', '<?= $start_y ?>', '<?= $start_x+$start_w ?>', '<?= $start_y+$start_h ?>' ],

							<? } ?>
							<? if(!empty($build['options']['fullbleed']) && !empty($cropdata['bestfit'])) { ?>
							aspectRatio: <?= $cropdata['bestfit']['scaled_w']/$cropdata['bestfit']['scaled_h'] ?>,
							<? } ?>
							dummyOption: 1
						});
	 				cropper = $('crop_image').getStorage().get('Jcrop');
				}

				function setCoords(c)
				{
					$('x').value = c.x;
					$('y').value = c.y;
					$('width').value = c.w;
					$('height').value = c.h;
				}

				function saveCropBackground()
				{
					var x = $('x').value;
					var y = $('y').value;
					var width = $('width').value;
					var height = $('height').value;
					var scale_w = $('crop_image').width;
					//new Ajax.Request("/build/crop_ajax/<?= $build['template'] ?>", {method: 'post', parameters: { "data[x]": x, "data[y]": y, "data[w]": width, "data[h]": height, "data[scale_w]": scale_w }, asynchronous: true});
					new Ajax.Updater("crop_coords", "/build/crop_ajax/<?= $build['template'] ?>", {method: 'post', parameters: { "data[x]": x, "data[y]": y, "data[w]": width, "data[h]": height, "data[scale_w]": scale_w }, asynchronous: true});
				}

				function saveCrop()
				{
					showPleaseWait();

					saveCropBackground();
		
					updateBuildImage();
				}
		
			</script>

		<? } ?>

		<? if(false && !empty($malysoft)) { ?>

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
			assigned to build? so we have a COPY of the image, rotated - may order other products w/differing rotation
		</div>

		<? } ?>

	</td>
</tr></table>
