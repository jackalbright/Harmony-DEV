<?= $this->element("steps/steps",array('step'=>'image', 'gallery'=>1)); ?>
<?= $this->element("gallery/browse_intro"); ?>
<? if (!isset($browseurl)) { $browseurl = "/gallery/browse"; } ?>
<? if (!isset($cols_per_row)) { $cols_per_row = 3; } ?>

<table width="100%" border=0>
<? for($i = 0; $i < count($categories); $i++) { 
	$cat = $categories[$i]; ?>
	<? if ($i % $cols_per_row == 0) { ?>
		<? if($i > 0) { ?>
			</tr>
		<? } ?>
	<tr>
	<? } ?>
	<td valign="top" align="center" style="width: 200px; height: 150px; border: solid #ccc 1px; background-color: #FEFEFE; padding: 5px;">
		<? if(!empty($cat['thumb_catalog_number'])) { ?>
		<a href="<?=$browseurl?>/<?=preg_replace("/ /", "_", $cat['browse_name']); ?>" style="font-weight: bold;">
			<img class="stamp_thumbnail" src="/gallery/image/<?= $cat['thumb_catalog_number'] ?>" height="50"/></a>
		<br/>
		<? } ?>
		<a href="<?=$browseurl?>/<?=preg_replace("/ /", "_", $cat['browse_name']); ?>" style="font-weight: bold;">
			<?= $cat['browse_name'] ?>
		</a>
		<br/>
		<br/>
		<? if(!empty($cat['Subcategories'])) { ?>
		<div id="subcat_lead_<?= $cat['thumb_catalog_number'] ?>">
		<? for($j = 0; !empty($cat['Subcategories']) && $j < count($cat['Subcategories']) && $j < 5; $j++) { 
				$sc = $cat['Subcategories'][$j];
				?><?= $j > 0 ? ", " : "" ?>
				<a href="<?=$browseurl?>/<?= $cat['browse_name'] ?>;<?= preg_replace("/ /", "_", $sc['browse_name']) ?>"><?= $sc['browse_name'] ?></a><? } ?><? if (!empty($cat['Subcategories']) && count($cat['Subcategories']) > 5) { ?>, 
				<a class="bold" href="Javascript:void(0)" onClick="showGallerySubcategories('<?= $cat['thumb_catalog_number'] ?>');"> more...</a>
		<? } ?>
		</div>

		<div id="subcat_all_<?= $cat['thumb_catalog_number'] ?>" class="hidden">
			<? for($j = 0; !empty($cat['Subcategories']) && $j < count($cat['Subcategories']); $j++)
			{
				$sc = $cat['Subcategories'][$j];
				?><?= $j > 0 ? ", " : "" ?>
				<a href="<?=$browseurl?>/<?= $cat['browse_name'] ?>;<?= preg_replace("/ /", "_", $sc['browse_name']) ?>"><?= $sc['browse_name'] ?></a><? } ?>, 
				<a class="bold" href="Javascript:void(0)" onClick="hideGallerySubcategories('<?= $cat['thumb_catalog_number'] ?>');"> show less...</a>
		</div>

		<? } ?>
	</td>
<? } ?>
</table>

<div class="hidden" align=left>
<table width="100%" cellpadding=5>
<? for($i = 0; $i < count($categories); $i++) { 
	$cat = $categories[$i]; ?>
<tr>
	<td valign="top">
		<? if(!empty($cat['thumb_catalog_number'])) { ?>
		<a href="<?=$browseurl?>/<?=preg_replace("/ /", "_", $cat['browse_name']); ?>" style="font-weight: bold;">
			<img class="stamp_thumbnail" src="/gallery/image/<?= $cat['thumb_catalog_number'] ?>" height="50"/></a>
		<? } ?>
	</td>
	<td valign="top">
		<a href="<?=$browseurl?>/<?=preg_replace("/ /", "_", $cat['browse_name']); ?>" style="font-weight: bold;">
			<?= $cat['browse_name'] ?>
		</a>
		<div style="padding-left: 20px;">
			<? for($j = 0; !empty($cat['Subcategories']) && $j < count($cat['Subcategories']); $j++)
			{
				$sc = $cat['Subcategories'][$j];
				?><?= $j > 0 ? ", " : "" ?>
				<a href="<?=$browseurl?>/<?= $cat['browse_name'] ?>;<?= preg_replace("/ /", "_", $sc['browse_name']) ?>"><?= $sc['browse_name'] ?></a>
			<? } ?>
			</div>
		</div>
	</td>
</tr>
<? } ?>
</table>
</div>
