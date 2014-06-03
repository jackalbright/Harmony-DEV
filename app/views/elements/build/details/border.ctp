		<? if(!empty($build['options']['border']['borderID_data'])) { ?>
			<a href="/build/step/border"><img src="<?= $build['options']['border']['borderID_data']['Border']['location']?>"/></a>
			<br/>
			<?= $build['options']['border']['borderID_data']['Border']['name']?>
		<? } else if ($build['options']['border']['borderID'] == 'None') { ?>
			None
		<? } ?>

