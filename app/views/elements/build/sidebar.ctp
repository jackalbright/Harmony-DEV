<div align="center" style="">
<!--
	<div>
		<a style="color: #009900; font-weight: bold;" href="/info/testimonials.php">Read Reviews</a> <a href="/info/testimonials.php"><img src="/images/icons/5stars.png"/></a>
	</div>
	<br/>
	-->

	<div align="left">
	<div class="bold" align="center" style="">I want to:</div>
	<ul>
	<li><a href="/build/save" onClick="saveBuild(); return true;">Save this design for later</a>
	<? if(!empty($build['CustomImage'])) { ?>
		<li><a href="/custom_images/select/<?= $build['CustomImage']['Image_ID'] ?>?clear=1">Choose another product</a>
	<? } else if(!empty($build['GalleryImage'])) { ?>
		<li><a href="/gallery/view/<?= $build['GalleryImage']['catalog_number'] ?>">Choose another product</a>
	<? } ?>
	<li><a href="/gallery"><?= $build['template'] == 'textonly' ? "Add an image" : "Choose another image" ?></a>
	<li><a href="/build_emails/add" title="Email this product preview" rel="shadowbox;width=500;height=600;title= ">Email this design <img src="/images/icons/email.jpg" align="middle" height="25"></a>
	</ul>
	</div>

	<br/>

	<?= $this->element("clients/clientlist",array('vertical'=>true)); ?>
</div>
