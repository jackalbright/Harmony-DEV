		<? if(!empty($build['options']['size']['shirtSize'])) { 
			$size_map = array(
				'S'=>'Small',
				'M'=>'Medium',
				'L'=>'Large',
				'XL'=>'X-Large',
				'XXL'=>'XX-Large',
				'YS'=>'Youth Small',
				'YM'=>'Youth Medium',
				'YL'=>'Youth Large',
				'YXL'=>'Youth X-Large'
			);
		?>
			<?= ucwords($size_map[$build['options']['size']['shirtSize']]) ?>
		<? } ?>

