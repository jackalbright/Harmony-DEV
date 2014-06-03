<div class="clear">
	<?
		$pinstyles = array(
			'Bar'=>"/new-images/pinback.png",
			"Tie Tack"=>"/new-images/tietacback.png",
		);

	?>
	<script>
		var pinstyles = new Array();
		<? foreach($pinstyles as $style=>$img) { ?>
			pinstyles['<?=$style?>'] = '<?=$img?>';
		<? } ?>
	</script>
	<div align="left">
	<table width="350">
	<tr>
		<td align="center">
			<a href="Javascript:void(0)" onClick="$('pinStyle_bar').checked='checked'; update_build_pricing();">
				<img src="/new-images/pinback.png"/>
			</a>
			<br/>
			<input id="pinStyle_bar" type="radio" name="data[options][pinStyle]" value="Bar" <?= empty($build['options']['pinStyle']) || $build['options']['pinStyle'] == 'Bar' ? "checked='checked'":'' ?> onClick="update_build_pricing();" /> Bar Pin
		</td>
		<td align="center">
			<a href="Javascript:void(0)" onClick="$('pinStyle_tietack').checked='checked'; update_build_pricing();">
				<img src="/new-images/tietacback.png"/>
			</a>
			<br/>
			<input id="pinStyle_tietack" type="radio" name="data[options][pinStyle]" value="Tie Tack" <?= !empty($build['options']['pinStyle']) && $build['options']['pinStyle'] == 'Tie Tack' ? "checked='checked'":'' ?> onClick="update_build_pricing();"/> Tie Tack
		</td>
	</tr>
	</table>
	</div>
		<script>
			<? if(!empty($build['options']['pinStyle'])) { ?>
				$('option_pinback').value = '<?= $build['options']['pinStyle'] ?>'; 
				changeOptionPreview('pinback', $('option_pinback').value, pinstyles);
			<? } ?>
		</script>
</div>
