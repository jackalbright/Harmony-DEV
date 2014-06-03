<? $code = $build['Product']['code']; ?>
<? if($code != 'P') { ?>

				<? $option_code = 'proof'; ?>
				<div id="step_<?= $option_code ?>" class="step <?= empty($build['complete'][$option_code]) ? "incomplete_step" : "" ?>">
					<table id="header_part_settings_<?= $option_code ?>" width="100%" class="step_header">
					<tr>
						<th align="left">
							<a class="bold" href="Javascript:void(0)" onClick="showBuildStep('<?=$option_code?>');">STEP <span class='stepnum'><?= $i+1 ?></span>. Email Proof (optional)</a>
						</th>
						<td align="right" style="width: 175px;">
							<div id="done_part_settings_<?= $option_code ?>" class="complete">
							<span style="color: green; font-weight: bold; font-size: 1.2em;"><img src="/images/icons/check.png"/></span>
								<span style="font-weight: bold;">COMPLETED</span>
							</div>
						</td>
					</tr>
					</table>

					<div style="<?= $step == $option_code ? "" : "display: none;" ?>" class="part_settings part_settings_<?= $i+1 ?>" id="part_settings_<?=$option_code?>" >
						<?= $this->element("build/step", array('option_code'=>$option_code)); ?>
					</div>
				</div>
<? } ?>
