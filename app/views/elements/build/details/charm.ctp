		<? if(!empty($build['options']['charm']['charmID_data'])) { ?>
			<a href="/build/step/charm"><img height="50" src="<?= $build['options']['charm']['charmID_data']['Charm']['graphic_location']?>"/></a>
			<br/>
			<?= ucwords($build['options']['charm']['charmID_data']['Charm']['name']) ?>
		<? } else { ?>
			<i>None</i>
		<? } ?>


