<div class="clear">
	<select name="data[options][reproductionStamp]" onChangeXX="updateBuild('<?=$i?>');" onChange="update_build_pricing();">
		<option <?= (empty($build['options']['reproductionStamp']) || $build['options']['reproductionStamp'] == 'yes') ? "selected='selected'" : "" ?> value="yes">Licensed Reproduction (FREE)</option>
		<option <?= (!empty($build['options']['reproductionStamp']) && $build['options']['reproductionStamp'] == 'no') ? "selected='selected'" : "" ?> value="no">Genuine Postage Stamp <?= !empty($surcharge) ? sprintf("+$%.02f ea.", $surcharge) : "" ?></option>
	</select>
	<br/>
	Using a reproduction may speed the production of your order.
	<a href="/info/reproduction.php">Learn more</a>

</div>

<div align="right">
Catalog #<?= $build['GalleryImage']['catalog_number']; ?>
</div>
