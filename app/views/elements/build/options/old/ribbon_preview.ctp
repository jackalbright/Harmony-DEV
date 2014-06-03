<div>
		<? $img_ribbons = $image->listRibbons();
			if(!empty($img_ribbons)) { 
				foreach($img_ribbons as $ribbon)
				{
					if(empty($first_ribbon)) { $first_ribbon = '/ribbons/'.preg_replace("/ /", '-', $ribbon->name) . '.png'; }
				}
			}
			foreach($ribbons as $ribbon)
			{
					if(empty($first_ribbon)) { $first_ribbon = '/ribbons/'.preg_replace("/ /", '-', $ribbon->color_name) . '.png'; }
			}
		?>
	<img id="ribbon_preview" src="<?= $first_ribbon ?>"/>
	<script>
			<? if(!empty($build['options']['ribbonID'])) { ?>
				changeOptionPreview('ribbon', $('option_ribbon').value, ribbon_images);
			<? } ?>
	</script>
</div>

