		<? if(!empty($build['options']['frame']['frameID_data'])) { ?>
			<a href="/build/step/frame"><img height="50" src="<?= $build['options']['frame']['frameID_data']['Frame']['graphic_location']?>"/></a>
			<br/>
			<?= ucwords($build['options']['frame']['frameID_data']['Frame']['name']) ?>
		<? } ?>
