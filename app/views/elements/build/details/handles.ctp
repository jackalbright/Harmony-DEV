		<? if(!empty($build['options']['handles']['handleColor'])) { ?>
				<? if ($build['options']['handles']['handleColor'] == 'Black') { ?>
					<img src="/images/blacktotehandles_verysm.jpg"/>
				<? } else if ($build['options']['handles']['handleColor'] == 'Navy') { ?>
					<img src="/images/navy-blue-tote-handles-small.jpg"/>
				<? } else if ($build['options']['handles']['handleColor'] == 'Red') { ?>
					<img src="/images/red-tote-handles-small.jpg"/>
				<? } ?>
			<br/>
			<?= ucwords($build['options']['handles']['handleColor']); ?>
		<? } ?>

