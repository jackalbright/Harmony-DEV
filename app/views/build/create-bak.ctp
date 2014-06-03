<?
$image_id = !empty($build['CustomImage']) ? $build['CustomImage']['Image_ID'] : "";
$catalog_number = !empty($build['GalleryImage']) ? $build['GalleryImage']['catalog_number'] : "";
?>
<div id="build">
	<table style="width: 700px;" align="center" border=1 cellspacing=0 cellpadding=0>
	<tr>
		<td style="width: 200px;" valign="top">
			<?= $this->element("build/preview",array('live'=>1,'hidedisclaimer'=>1)); ?>
		</td>
		<td valign="top">
			<table width="100%" border=0 cellspacing=0 cellpadding=5>
			<tr style="background-color: white;">
				<td colspan=1 valign="top">
					<?= $this->element("products/intro"); ?>

					<?= $this->element("products/pricing_grid_compact"); ?>

					<div align="center">
						<br/>
						<a href="/build/customize/<?= $build['Product']['code'] ?>?image_id=<?=$image_id?>&catalog_number=<?=$catalog_number?>">
						<img src="/images/buttons/Personalize.gif"/>
						</a>
					</div>
				</td>
			</tr>
			</table>

			</form>
		</td>
	</tr>
	</table>

	<script>
		hidePleaseWait();
	</script>


</div>
