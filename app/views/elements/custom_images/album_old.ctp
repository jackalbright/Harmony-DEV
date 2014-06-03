<div>
	<? if(!empty($inline)) { ?>
		<div align="right">
			<a href="/custom_images/add">Upload image</a>
		</div>
	<? } ?>
	<?
		if(empty($images))
		{
	?>
			<!--<p style="color: #339900;" class="">You have not uploaded any images</p>-->

	<?
		} else {
	?>
			<b style="padding:5px;">OR Click on an existing image to personalize your gifts now</b>
			<div style="padding: 5px;">
	<? 
			#$unsaved_images = Set::extract("/CustomImage[customer_id='']", $images);
			function unsaved_images($a) { return empty($a['CustomImage']['Customer_ID']); }
			$unsaved_images = array_filter($images, "unsaved_images");
			function saved_images($a) { return !empty($a['CustomImage']['Customer_ID']); }
			$saved_images = array_filter($images, "saved_images");

			if(!empty($unsaved_images))
			{
				?>
				<div style="font-size: 12px;" class="alert2">You have unsaved images</div>
				<div style="background-color: #EEE; padding: 5px;">
				<?
				foreach($unsaved_images as $img)
				{
					echo $this->element("/custom_images/album_item", array('img'=>$img,'inline'=>!empty($inline) ? true:false,'product'=>(!empty($product)?$product:null)));
				}
				?>
				<div class="clear"></div>
				</div>
				<?
			}

			if(!empty($saved_images))
			{
				?>
				<div style="color: #339900; font-size: 12px;">Saved images</div>
				<div style="background-color: #FFF; padding: 5px;">
				<?
				foreach($saved_images as $img)
				{
					echo $this->element("/custom_images/album_item", array('img'=>$img,'inline'=>!empty($inline) ? true:false,'product'=>(!empty($product)?$product:null)));
				}
				?>
				<div class="clear"></div>
				</div>
				<?
			}
			?></div><?
		}

	?>
	<div class="clear"></div>
</div>

