<div class="clear">
		<!--<h2><?php echo $counter;?>. Add personalization <span class="note">(Optional - Free)</span></h2>-->
		<p class="note">
			<!--Example: &#8220;Happy Birthday, John &#8212; Your friend, Mary.&#8221;-->
		</p>
		<table><tr>
		<td valign="top">
			<!--<textarea id="personalizationInput" name="data[options][personalizationInput]" rows="2" cols="35" onChange="$('personalization_checkbox').removeClassName('hidden'); updateBuildImage();" onkeyup="typingPersonalization(event);"><?= !empty($build['options']['personalizationInput']) ? $build['options']['personalizationInput'] : "" ?></textarea> -->
			<input type="text" id="personalizationInput" name="data[options][personalizationInput]" style="width: 100%;" maxlength="<?= $this_product->personalizationLimit ?>" onChange="updateBuild('<?=$i?>');" onChangeX="$('personalization_checkbox').removeClassName('hidden'); updateBuildImage();" onkeyup="typingPersonalization(event);" value="<?= !empty($build['options']['personalizationInput']) ? $build['options']['personalizationInput'] : "" ?>"/>
			<br/>

			<div>
			<input type="radio" id="personalizationStyleScript" name="data[options][personalizationStyle]" value="block" <?= (empty($build['options']['personalizationStyle']) || $build['options']['personalizationStyle'] == 'block' ) ? 'checked="checked"' : "" ?> onClick="updateBuildImage();" /><img src="/new-images/block-font.gif" alt="block font" width="96" height="25" align="middle" />
			<input type="radio" id="personalizationStyleScript" name="data[options][personalizationStyle]" value="script" <?= (!empty($build['options']['personalizationStyle']) && $build['options']['personalizationStyle'] == 'script' ) ? 'checked="checked"' : "" ?> onClick="updateBuildImage();"/><img src="/new-images/script-font.gif" alt="script font" width="96" height="25" align="middle" />
			</div>
			<div>
			Example: <span style="font-weight: bold; font-variant: small-caps;">Springfield History Museum</span>
			</div>
			<span class="note">Text will be centered</span>
		</td>
		</tr></table>
</div>

<?
$persLength = !empty($build['options']['personalizationInput']) ? strlen($build['options']['personalizationInput']) : 0;
?>

			<div class="note">
				<span id="personalizationLength"><?= $persLength ?></span> of <?= $this_product->personalizationLimit ?> characters.
			</div>
