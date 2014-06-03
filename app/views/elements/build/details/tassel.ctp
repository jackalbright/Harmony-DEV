		<? if(!empty($build['options']['tassel']['tasselID_data'])) { ?>
			<a href="/build/step/tassel"><img height="50" src="/tassels/thumbs/<?= preg_replace("/ /", "-", $build['options']['tassel']['tasselID_data']['Tassel']['color_name'])?>.gif"/></a>
			<br/>
			<?= ucwords($build['options']['tassel']['tasselID_data']['Tassel']['color_name']) ?>
		<? } ?>

