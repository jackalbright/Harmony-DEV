		<? if (!empty($build['options']['personalization']['personalizationInput'])) { ?>

		<?= $build['options']['personalization']['personalizationInput'] ?>
		<? if(!empty($build['options']['personalization']['personalizationStyle'])) { ?>
			<i>(<?= $build['options']['personalization']['personalizationStyle'] ?>)</i>
		<? } ?>

		<? } else { ?>
			<i>None</i>
		<? } ?>

