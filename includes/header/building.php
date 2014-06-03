<?php 

if(empty($in_cart) && empty($in_checkout) && empty($in_login) && !preg_match("/^\/design/", $_SERVER['REQUEST_URI'])) { ?>

	<? if(!empty($_SESSION['Design']['Product'])) { ?>
		<a style="float: right; padding: 2px; margin-left: 5px;" href="/design">
			<img src="/design/png/height:50"/>
		</a>
		Currently Building:<br/>
		<a href="/design"><?= preg_replace("/^Custom /", "", $_SESSION['Design']['Product']['name']) ?></a>

	<? } else if (!empty($_SESSION['Build']['Product']) && (!empty($_SESSION['Build']['CustomImage']) || !empty($_SESSION['Build']['GalleryImage']))) { ?>
		<div class="currently_building" style="width: 250px;">
			<?
			$name = "Your custom";
			$imgtype = "_";
			$imgid = "_";
			if (!empty($_SESSION['Build']['CustomImage']))
			{
				if (!empty($_SESSION['Build']['CustomImage']['Title'])) { $name = "&quot;".$_SESSION['Build']['CustomImage']['Title']."&quot;"; }
				$imgtype = "Custom";
				$imgid = $_SESSION['Build']['CustomImage']['Image_ID'];
				$imgsrc = $_SESSION['Build']['CustomImage']['display_location'];
			} else if (!empty($_SESSION['Build']['GalleryImage'])) {
				if (!empty($_SESSION['Build']['GalleryImage']['stamp_name'])) { $name = "&quot;".$_SESSION['Build']['GalleryImage']['stamp_name']."&quot;"; }
				$imgtype = "Gallery";
				$imgid = $_SESSION['Build']['GalleryImage']['catalog_number'];
				$imgsrc = $_SESSION['Build']['GalleryImage']['image_location'];
			}
			?>
			<a style="float: right; padding: 2px; margin-left: 5px;" href="/build/customize">
				<img class="<?= $imgtype == 'Gallery' ? "stamp_thumbnail":"" ?>" style="height: 50px; " src="<?= $imgsrc ?>"/>
			</a>
			Currently Building:<br/>
			<a href="/build/customize"><?= !empty($_SESSION['Build']['CustomImage']) ? "Custom ":"" ?><?= preg_replace("/^Custom /", "", $_SESSION['Build']['Product']['name']) ?></a>
		</div>
	<? } ?>

<? } 

?>
