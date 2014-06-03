<? $cols = 4; # fixed for easier display ?>
<!--<div style="border: solid 3px #CCC; margin-top: 15px; background-color: #EEE;">-->
<div class="albumContainer">
	<?  if(!empty($images)) { ?>
	<p style="padding: 17px 5px 5px 5px; font-weight: bold;">Click on a picture below to put it on a product</p>
			<div style="">
	<? 
			#$unsaved_images = Set::extract("/CustomImage[customer_id='']", $images);
			function unsaved_images($a) { return empty($a['CustomImage']['Customer_ID']); }
			$unsaved_images = array_filter($images, "unsaved_images");
			function saved_images($a) { return !empty($a['CustomImage']['Customer_ID']); }
			$saved_images = array_filter($images, "saved_images");

			if(false && empty($inline) && !empty($unsaved_images))
			{
				?> <div style="font-size: 12px;" class="alert2">You have unsaved images</div> <?
			}

			?>
			<table class="image_grid" cellspacing=0 cellpadding=10 border=0>
			<? for($i = 0; $i < count($images); $i++) { $img = $images[$i]; ?>
				<?= ($i % $cols == 0) ? "<tr>": "" ?>
					<?= $this->element("/custom_images/album_item", array('img'=>$img,'inline'=>!empty($inline) ? true:false,'product'=>(!empty($product)?$product:null))); ?>
				<?= ($i+1 % $cols == 0 || $i+1 == count($images)) ? "</tr>": "" ?>
			<? } ?>
			</table>
			<style>
			table.image_grid 
			{
				border-collapse: collapse;
			}
			table.image_grid tr + tr
			{
				border-top: solid #CCC 1px;
			}
			table.image_grid td + td
			{
				border-left: solid #CCC 1px;
			}
			</style>
			<div class="clear"></div></div>
		<? } ?>
	<div class="clear"></div>
</div>

