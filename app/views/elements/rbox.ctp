<?
	$name = preg_replace("@/@", "_", $element);

?>
<div id="<?=$name?>_rbox">
	<table id="<?= $name?>_table" border=0 cellpadding=0 cellspacing=0 width="100%">
	<tr>
		<td id="<?=$name?>_tl"></td>
		<td rowspan=2 align="left" valign="top" id="<?=$name?>_t" style="font-weight: bold; <?= !empty($title_style) ? $title_style : "" ?>"><?= !empty($title) ? "$title" : "" ?>&nbsp;</td>
		<td id="<?=$name?>_tr"></td>
	</tr>
	<tr id="<?= $name ?>_content">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	</table>
	<div colspan=3 id="<?= $name ?>_content">
			<?= $this->element($element); ?>
	</div>
	<table id="<?= $name?>_table" border=0 cellpadding=0 cellspacing=0 width="100%">
	<tr>
		<td id="<?=$name?>_bl"></td>
		<td id="<?=$name?>_b">&nbsp;</td>
		<td id="<?=$name?>_br"></td>
	</tr>
	</table>
</div>

