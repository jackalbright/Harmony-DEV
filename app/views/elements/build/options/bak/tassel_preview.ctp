<div class="clear">
			<? $img_tassels = $image->listTassels();
				$i = 0;
				$first_tassel = "black";
				$existing_tassels = array();
				if(!empty($img_tassels))
				{
					foreach($img_tassels as $tassel)
					{
						if(!$first_tassel) { $first_tassel = $tassel->color_name; }
					}

				}
				foreach ($tassels as $tassel)
				{
					if(!$first_tassel) { $first_tassel = $tassel->color_name; }
				}

				$first_tassel_url = "";

				foreach($tassels as $tassel)
				{
					if ($tassel->color_name == $first_tassel && !isset($build['options']['tasselID'])) 
					{
						$first_tassel_url = "/tassels/thumbs/".preg_replace('/ /', '-', $tassel->color_name) . ".gif";
					}
				}
			?>
		<? if($first_tassel_url) { ?>
	<img id="tassel_preview" height="50" src="<?= $first_tassel_url ?>"/>
		<? } ?>
		<script>
			<? if(!empty($build['options']['tasselID'])) { ?>
				changeOptionPreview('tassel', $('option_tassel').value, tassel_images);
			<? } ?>
		</script>
</div>

<div class="clear"></div>
