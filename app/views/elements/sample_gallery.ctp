<?
$pathclass = "image_gallery_" . preg_replace("/\//", "_", $path);
$file_count = count($images);
if (!isset($sample_gallery_album)) { $sample_gallery_album = false; }


if ($file_count > 0)
{
	$underpath = preg_replace("/\W+/", "_", $path);

		if (isset($group_by)) {
			$available_group_options = array();
			$found = array();

			foreach($images as $image)
			{
				$key = $image[$group_by];
				if (!isset($found[$key])) { $found[$key] = 1; } else { $found[$key]++; }
			}
			foreach ($group_options as $option_key => $option_value)
			{
				if ($option_key == "" || isset($found[$option_key])) { $available_group_options[$option_key] = $hd->pluralize($group_options[$option_key]); }
			}

			# 
		} else {
			$available_group_options[""] = $group_options;
		}

		$image_gallery_class = $sample_gallery_album ? "image_gallery_album" : "image_gallery";

	?> 
	<div id="image_gallery_<?= $underpath ?>" class="<?= $image_gallery_class ?> <?= $underpath ?>">
		<? 
		
		if (isset($gallery_title) && $gallery_title != "") { ?> <div class="subtitle"><div><?= $gallery_title ?></div></div> <? } 
			if (empty($sample_gallery_album)) { 
				echo $html->link("View as Album", "/".$this->params['url']['url']."?album=1");
			} else {
				echo $html->link("View Full Page", "/".$this->params['url']['url']);
			}
	
			echo $form->input('product_type_id', array('label'=>'<b>Filter:</b> ','between'=>' ','after'=>'<br/>','before'=>'<br/>', 'options'=>$available_group_options,'onChange'=>"return sample_gallery_select_filter(this, 'image_gallery_$underpath')"));



		if (count($available_group_options))
		{
			$i = 0;
			foreach($available_group_options as $optkey => $optlabel)
			{
				#Now create a 'filtered' list of images.
	
				$filtered_images = array();
				foreach($images as $image)
				{
					if($optkey == '' || $image['product_type_id'] == $optkey)
					{
						$filtered_images[] = $image;
					}
				}
	
				$container_class = $i++ > 0 ? "hidden" : ""; # Hide all groups but first.
				echo $this->element("sample_gallery_set", array('images'=>$filtered_images, 'container_class'=>"$container_class image_gallery_$underpath", 'underpath'=>$underpath."_".$optkey,'image_key'=>$image_key,'path'=>$path,'sample_gallery_album'=>$sample_gallery_album));
			}
		} else { # No grouping...
				echo $this->element("sample_gallery_set", array('images'=>$images, 'underpath'=>$underpath,'image_key'=>$image_key,'path'=>$path,'sample_gallery_album'=>$sample_gallery_album));
		}

		?>

	</div>

<?
}
?>
