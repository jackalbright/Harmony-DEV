		<? if(!empty($build['options']['ribbon']['ribbonID_data'])) { ?>
			<img height="50" src="/ribbons/<?= preg_replace("/ /", '-', $build['options']['ribbon']['ribbonID_data']['Ribbon']['color_name']); ?>.png"/>
			<br/>
			<?= ucwords($build['options']['ribbon']['ribbonID_data']['Ribbon']['color_name']) ?>
		<? } ?>

