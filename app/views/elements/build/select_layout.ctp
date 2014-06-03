<?
if(empty($template)) { $template = 'standard'; }
if(!empty($fullbleed)) { $template = 'fullbleed'; }

?>
		<b style="color: #009900;">Select a layout style</b>
		<br/>
		<input type="hidden" name="data[options][fullbleed]" value="<?= !empty($build['options']['fullbleed']) || (!empty($build['template']) && ($build['template'] == 'fullbleed')) ? 1 : 0 ?>">
		<select name="data[template]" onChange="showPleaseWait(); document.location.href = '<?= $url ?>?step=layout&layout='+this.value;">
			<? if(empty($all_options_by_code) || !empty($all_options_by_code['quote'])) { ?>
			<option <?= $template == 'standard' ? "selected='selected'" : "" ?> value="standard">Image and text</option>
			<? } ?>

			<option <?= $template == 'imageonly' ? "selected='selected'" : "" ?>  value="imageonly">Image only (Fit image)</option>
			<? if(!empty($build['CustomImage'])) { ?>
			<option <?= $template == 'fullbleed' ? "selected='selected'" : "" ?>  value="fullbleed">Image only (Full bleed)</option>
			<? } ?>
		</select>

