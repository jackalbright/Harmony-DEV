		<div class="build">
			<? 
			$i = 0; 
			$product_templates = split(",", $build['Product']['product_template']);
			?>

				<? $i = 0; ?>

			<? if(!empty($build['CustomImage'])) { $option_code = 'layout'; ?>
			<div class="top_border grey_border" valign="top">
					<table id="header_part_settings_<?= $option_code ?>" width="100%" class="step selected_step">
					<tr>
						<th align="left">
							<a class="bold" href="Javascript:void(0)" onClick="showBuildStep('layout');">  
								STEP <?= $i+1 ?>. Layout
							</a>
						</th>
						<td align="right">
							<div id="done_part_settings_<?= $option_code ?>" class="complete hidden">
							<span style="color: green; font-weight: bold; font-size: 1.2em;">&#x2713;</span>
								<span style="font-weight: bold;">COMPLETED</span>
							</div>
						</td>
					</tr>
					</table>

					<div id="part_settings_layout" style="<?= $i > 0 ? "display: none;" : "" ?>" class="part_settings part_settings_<?= $i ?>">
						<div class="padded">
							<input type="radio" name="" <?= (empty($build['template']) || $build['template'] == 'standard') ? "checked='checked'" : ""; ?> value="standard" onClick="showPleaseWait(); document.location.href='/build/customize/<?= $prod ?>?template=standard'; "/> <a onClick="showPleaseWait();" href="/build/customize/<?= $prod ?>?template=standard">Image &amp; Text</a>
							<br/>
							<br/>
								<input type="radio" name="" <?= (!empty($build['template']) && $build['template'] == 'imageonly') ? "checked='checked'" : "" ?> value="imageonly" onClick="showPleaseWait(); document.location.href='/build/customize/<?= $prod ?>?template=imageonly'; "/>
								<a onClick="showPleaseWait();" href="/build/customize/<?= $prod ?>?template=imageonly">Image Only</a>
						</div>

						<table width="100%">
						<tr>
							<td align="left">
								<? if($i > 0) { ?>
								<a href="Javascript:void(0);" onClick="showBuildStepPrevious('<?= $i ?>');">Previous</a>
								<? } ?>
								&nbsp;
							</td>
							<td align="right">
								<a href="Javascript:void(0);" onClick="showBuildStepNext('<?= $i ?>');"><img src="/images/buttons/small/Next.gif"></a>
							</td>
						</tr>
						</table>
					</div>
			</div>
			<? $i++; } else { ?>
			<? } ?>
			<input type="hidden" name="data[template]" value="<?= !empty($build['template']) ? $build['template'] : null ?>"/>


			<? foreach($options as $option) { 
				$option_code = $option['Part']['part_code'];
			?>
				<div colspan=1 class="top_border grey_border" valign="top">
					<?
					$extra_charge = !empty($option['Part']['price']) ? " extra charge" : "";
					?>

					<table id="header_part_settings_<?= $option_code ?>" width="100%" class="step">
					<tr>
						<th align="left">
							<a class="bold" href="Javascript:void(0)" onClick="showBuildStep('<?= $option_code ?>');">  
								STEP <?= $i+1 ?>. <?= $option['Part']['part_name'] ?> <? if($option['ProductPart']['optional'] == 'yes') { echo "(opt.) $extra_charge"; } ?>
							</a>
						</th>
						<td align="right">
							<div id="done_part_settings_<?= $option_code ?>" class="complete hidden">
							<span style="color: green; font-weight: bold; font-size: 1.2em;">&#x2713;</span>
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
	
						<?= $hd->product_element("build/options/$option_code", $build['Product']['prod'], array('i'=>$i)); ?>
	
						<table width="100%">
						<tr>
							<td align="left">
								<? if($i > 0) { ?>
								<a href="Javascript:void(0);" onClick="showBuildStepPrevious('<?= $i ?>');">Previous</a>
								<? } ?>
								&nbsp;
							</td>
							<td align="right">
								<a href="Javascript:void(0);" onClick="showBuildStepNext('<?= $i ?>');"><img src="/images/buttons/small/Next.gif"></a>
							</td>
						</tr>
						</table>

					</div>
				</div>
			<? $i++; } $option_code = 'comments'; ?>

				<div class="top_border grey_border">
					<table id="header_part_settings_<?= $option_code ?>" width="100%" class="step">
					<tr>
						<th align="left">
							<a class="bold" href="Javascript:void(0)" onClick="showBuildStep('comments');">STEP <?=$i+1 ?>. Comments</a>
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
								<a href="Javascript:void(0);" onClick="showBuildStepPrevious('<?= $i ?>');">Previous</a>
							</td>
							<td align="right">
								Choose your quantity and click 'Add to Cart'
								<!--
								<a href="Javascript:void(0);" onClick="showBuildStepNext('<?= $i ?>');"><img src="/images/buttons/small/Next.gif"></a>
								-->
							</td>
						</tr>
					</table>

					</div>
				</div>
		</div>

