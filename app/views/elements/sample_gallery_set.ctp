<? 
if (!isset($container_id)) { $container_id = ''; } 
if (!isset($container_class)) { $container_class = ''; } 
if (!isset($sample_gallery_album)) { $sample_gallery_album = false; } 

?>


<div class="right_align">Click image to view larger</div>
	<div id="image_gallery_<?= $underpath ?>" class="<?= $container_class ?>">
		<? if (!$sample_gallery_album) { ?>
		<table class="image_gallery_nav" width="100%">
		<tr><td align=left>
			<button class="image_gallery_button" onClick="sample_image_gallery_previous('<?= $underpath ?>');">&laquo; Previous</button>
		</td>
		<td align=center id="image_gallery_counter_<?=$underpath?>">1 of <?= count($images) ?></td>
		<td align=right>
			<button class="image_gallery_button" onClick="sample_image_gallery_next('<?= $underpath ?>');">Next &raquo;</button>
		</td></tr>
		</table>
		<br/>
		<? } ?>


	<?
		$i = 0;
		foreach($images as $image) 
		{ 
			$display = $i++ > 0 ? "hidden" : "";
			if ($sample_gallery_album) { $display = "float_left padded"; } # Float instead.
		?>
			<div class="sample_image sample_image_<?=$underpath ?> <?= $display ?>">
				<a title="<?= $image['title'] ?>" rel="shadowbox[<?=$underpath?>]" id="image_gallery_largelink1_<?=$underpath?>" href="/images/galleries/<?= $path ?>/<?= $image[$image_key] ?>.<?=$image['file_ext'] ?>">
					<img border="0" src="/images/galleries/<?= $path ?>/display/<?= $image[$image_key] ?>.<?=$image['file_ext'] ?>" id="image_gallery_<?=$underpath?>"/>
				<br/>+ View Larger</a>
			</div>
		<?
		}
	?>

	</div>
	<div class="clear"></div>
