<?
if(isset($build['GalleryImage'])) { 
?>
	<div align="center" class="" style="border: solid #CCC 1px; margin: 5px; padding: 5px; float: right;">
		<img class="stamp_thumbnail" src="<?=$build['GalleryImage']['image_location']?>" height=75/>
		<br/>
		<a href="/gallery">Change image</a>
	</div>
	<div class="clear"></div>
	<br/>
<?
} else if (isset($build['CustomImage'])) { 
?>
	<div align="center" class="" style="border: solid #CCC 1px; margin: 5px; padding: 5px; float: right;">
		<img class="" src="<?=$build['CustomImage']['display_location']?>" height=75/>
		<br/>
		<a href="/custom_images">Change image</a>
	</div>
<?
}
?>
<!--
<p>
Create any of the products below using your image, your text (or suggestions from our quotation library) and your personalization, organization, company or museum name.
</p>
<p>
Need a non-standard layout? Want to add your logo? Please contact us: 888.293.1109 or <a href="/contact">email us</a>
</p>
<p>
Click on a product below to get started.
</p>
-->

<div class="clear"></div>
<? if(!empty($is_stamp)) { echo $this->element("products/availability_notice"); } ?>
