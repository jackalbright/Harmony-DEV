<?
if(!empty($product['Product'])) { $product = $product['Product']; }

$default_layout = !empty($config['default_custom_image_layout']) ? $config['default_custom_image_layout'] : 'standard';
?>
<? if(file_exists(APP."/webroot/".$img['CustomImage']['display_location'])) { ?>
<td width="125" valign="bottom" align="center">
	<a href="/custom_images/select/<?= $img['CustomImage']['Image_ID'] ?>?layout=<?=$default_layout?>&prod=<?=!empty($product)?$product['code']:"&new=1" ?>" onClick="showPleaseWait();">
	<img src="<?= $img['CustomImage']['display_location'] ?>" width="100" />
	</a>
	<div align="center">
		<? if(empty($inline)) { ?>
		<? if(empty($img['CustomImage']['Customer_ID'])) { ?>
		<a style="font-weight: bold; color: #FF3300;" href="/custom_images/save/<?= $img['CustomImage']['Image_ID'] ?>?savegoto=<?= $_SERVER['REQUEST_URI'] ?>">SAVE</a> |
		<? } ?>

		<a href="/custom_images/delete/<?= $img['CustomImage']['Image_ID'] ?>" onClick="return confirm('Are you sure you want to delete this image?');">Delete</a>
		<? } ?>
	</div>
</td>
<? } ?>
