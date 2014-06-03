<div class="clear">
		<table width="100%"><tr>
		<td valign="top">

			<script>
			document.onkeypress = noTextEnter;
			</script>

			<div id="persDetails" style="<?#= !empty($build['options']['personalizationNone']) ? "display: none;":"" ?>">


			<div style="">
			<table cellpadding=0 cellspacing=0 border=0 width="100%">
				<tr>
					<td colspan=1>
						<table cellpadding=0 cellspacing=0 border=0 width="100%">
							<tr>
								<td colspan=3 rowspan=1 style="padding-right: 20px;" valign="top">
								<?
									$pers = !empty($build['options']['personalizationInput']) ? $build['options']['personalizationInput'] : "";
									if(strlen($pers) > $build['Product']['personalizationLimit'])
									{
										$pers = substr($pers, 0, $build['Product']['personalizationLimit']);
									}
								?>
									<textarea rows=2 id="personalizationInput" name="data[options][personalizationInput]" style="overflow: clip;" maxlength="<?= $build['Product']['personalizationLimit'] ?>" onBlur="" onChange="showPersonalization();" onkeyup="typingPersonalization(event, '<?= $build['Product']['personalizationLimit'] ?>');"><?= $pers ?></textarea>
									<div class="clear"></div>
									<?  $persLength = !empty($pers) ? strlen($pers) : 0; ?>
									<div align="right" class="note"> <span id="personalizationLength"><?= $persLength ?></span> of <?= $build['Product']['personalizationLimit'] ?> characters.  </div>
								</td>
							</tr>
						</table>
						<script>
						//j('#personalizationInput').ghostable('Type up to two lines\nfor a short greeting');
						j('#personalizationInput').ghostable('Type name, greeting,\netc up to 2 lines');
						</script>
					</td>
				</tr>
				<tr>
					<td height="50">
						<div class="bold">Font:</div>
						<div style="border: solid #CCC 1px; background: white; padding: 5px; width: 200px;">

						<div style="float: left; width: 100px;">
							<input type="radio" id="personalizationStyleScript" name="data[options][personalizationStyle]" value="block" <?= (empty($build['options']['personalizationStyle']) || $build['options']['personalizationStyle'] == 'block' ) ? 'checked="checked"' : "" ?> onClick="showPersonalization();" /><img src="/new-images/block-font.gif" alt="block font" height="20" align="top" />
						</div>
						<div style="float: left;">
							<input type="radio" id="personalizationStyleScript" name="data[options][personalizationStyle]" value="script" <?= (!empty($build['options']['personalizationStyle']) && $build['options']['personalizationStyle'] == 'script' ) ? 'checked="checked"' : "" ?> onClick="showPersonalization();"/><img src="/new-images/script-font.gif" alt="script font" height="20" align="top" />
						</div>

						<div class="clear"></div>

						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="bold">Text size: </div>
						<div style="border: solid #CCC 1px; background: white; padding: 5px; width: 200px;">

						<select name="data[options][personalizationSize]" onChange="showText();">
							<option value="Small" <?= !empty($build['options']['personalizationSize']) && $build['options']['personalizationSize'] == 'Small' ? 'selected="selected"' : "" ?> >Small</option>
							<option value="Medium" <?= !empty($build['options']['personalizationSize']) && $build['options']['personalizationSize'] == 'Medium' ? 'selected="selected"' : "" ?> >Medium</option>
							<option value="Large" <?= empty($build['options']['personalizationSize']) || $build['options']['personalizationSize'] == 'Large' ? 'selected="selected"' : "" ?> >Large</option>
						</select>

						<div class="clear"></div>

						</div>
					</td>
				</tr>
				<? if(!in_array($build['Product']['code'], array('RL')) && !empty($build['CustomImage'])) { ?>
				<tr id="persColorBox" style="<?= $build['template'] == 'standard' ? 'display:none;' : '' ?>">
					<td>
						<div class="bold">Color: </div>
						<div style="border: solid #CCC 1px; background: white; padding: 5px; width: 200px;">

						<div style="float: left; width: 100px;">
							<input id='persColorBlack' type="radio" name="data[options][personalizationColor]" <?= empty($build['options']['personalizationColor']) || $build['options']['personalizationColor'] == 'black' ? "checked='checked'" : "" ?> value="black" onChange="showPersonalization();"/>
							<span style="color: black; padding: 3px;">Black</span>
							<div class="clear"></div>
						</div>

						<div style="float: left; padding-bottom: 5px;">
							<input id='persColorWhite' type="radio" name="data[options][personalizationColor]" <?= !empty($build['options']['personalizationColor']) && $build['options']['personalizationColor'] == 'white' ? "checked='checked'" : "" ?> value="white" onChange="showPersonalization();"/>
							<span style="color: white; background-color: black; padding: 3px;"> White</span>
							<div class="clear"></div>
						</div>
						<br/>

						<div class="clear"></div>

						</div>
					</td>
				</tr>
				<? } ?>
			</table>
			</div>

			<br/>

			<div align='right'>
				<a href="Javascript:void(0)" onClick="showPersonalization();"><img src="/images/buttons/small/Preview-grey.gif"/></a>
			</div>

			</div>

			<div class="clear"></div>
		</td>
		<? if(false) { ?>
		<td class="center" valign="top" style="border-left: solid #CCC 1px;">
			<div class="bold">
			Or provide your own logo:
			</div>
			<br/>

			<div id="logoUpload" XXclass="<?= !empty($build['PersonalizationLogo']) ? "hidden":"" ?>">
			<input type="file" name="data[PersonalizationLogo][file]" size="20" onChange="$('personalizationInput').value = '';"/>
			<br/>

			<input type="image" src="/images/buttons/Preview.gif" onClick="showPleaseWait(); $('personalizationInput').value = ''; $('build_form').action = '/custom_images/add_build_logo'; return true;"/>
			<!-- REDIRECT TO CUSTOM_IMAGES/ADD, sayin we're a logo, so it knows to go back to build after done... -->
			<br/>
			<br/>

			<div id="personalizationLogoDetails">
			<? if(!empty($build['PersonalizationLogo'])) { ?>
				<input id="logo_id" type="hidden" name="data[options][personalization_logo_id]" value="<?= $build['PersonalizationLogo']['Image_ID'] ?>"/>
				<div id="logo_preview" align="center">
					<img height=50 src="<?= $build['PersonalizationLogo']['thumbnail_location'] ?>"/>
				</div>
			<? } ?>
			</div>
			</div>

		</td>
		<? } ?>
		</tr></table>
		<script>
		// TODO update when text changed.

		//j(document).ready(function() { showPersonalization(true); });
		j('#step_text').bind('showPart.personalization', function (e, dummy, load)
		{
			if(dbg) console.log("TEMPLp="+j('#template').val());
			if(dbg) console.log("PN="+j('#personalizationNone').is(':checked'));
			if(j('#template').val() == 'imageonly_nopersonalization' || (j('#template').val() == 'imageonly' && j('#personalizationNone').is(":checked"))) { 
				if(dbg) console.log("NONE PERS");
				hidePleaseWait('personalization'); // Just in case.
				return; 
			}
			if(dbg) console.log("SHOWPERS!!!!");
			showPleaseWait('personalization');
			showPersonalization(load);
		});

		j(document).ready(function() {
			j('#step_text').trigger('showPart.personalization', [null, true]);
		});

		</script>

</div>

