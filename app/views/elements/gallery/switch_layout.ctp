<? if(!empty($build['CustomImage'])) { ?>
<? 
$template = !empty($build['preview_layout']) ? $build['preview_layout'] : $build['template']; 
if(empty($template)) { $template = 'standard'; }
if(!empty($fullbleed)) { $template = 'fullbleed'; }
?>

<input type="hidden" name="data[options][fullbleed]" value="<?= !empty($build['options']['fullbleed']) || (!empty($build['template']) && ($build['template'] == 'fullbleed')) ? 1 : 0 ?>">

<table cellpadding=0 cellspacing=0 border=0>
<tr>
<td>
<span style="font-weight: bold; color: #009900;">Show me: </span>
</td>
<td>
<label for="template_standard"><input id="template_standard" type="radio" name="data[template]" value="standard" <?= $template == 'standard' ? "checked='checked'" : "" ?> onClick="showPleaseWait(); document.location.href = '<?= $url ?>?step=layout&layout='+this.value;"/> Image + text</label>
</td>
<td>
<label for="template_imageonly"><input id="template_imageonly" type="radio" name="data[template]" value="imageonly" <?= $template == 'imageonly' ? "checked='checked'" : "" ?> onClick="showPleaseWait(); document.location.href = '<?= $url ?>?step=layout&layout='+this.value;"/> Image without text</label>
</td>
</tr>

</table>
<? } ?>
