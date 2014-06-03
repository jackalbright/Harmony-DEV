<?
if(empty($key) && $key === "") { $key = ""; }
if(empty($name)) { $name = ""; }
?>
<div id="<?= isset($id) ? $id : "" ?>" class="<?= isset($class) ? $class : "" ?>">
<?
if (isset($product['Product']))
{
	$product = $product['Product'];
}

$path = "charms";

if (!isset($gallery_title)) { $gallery_title = 'Sample Gallery'; }
$pathclass = "image_gallery_" . preg_replace("/\//", "_", $path);

#error_log("P=$path");

#print_r($product);
$file_count = count($charms);

if ($file_count > 0)
{
	$underpath = preg_replace("/\W+/", "_", $path);
?>
	<table width="100%" class="image_gallery_scroll_table <?= isset($tabbed) ? "image_gallery_scroll_table_tabbed" : "" ?>">
	<tr>
		<td>&nbsp; </td>
		<td colspan=1>
			<h3><?= $name ?> Charms</h3>
		</td>
		<td align="right">Click on a charm to view larger</td>
	</tr>
	<tr>
		<td>
			<a href="Javascript:void(0)" onClick="return image_gallery_album_scroll_left('image_gallery_scroll_row_<?=$key ?>');"><img src="/images/buttons/Circle-left.gif"/></a>
		</td>
		<td align=center>
			<div id="<?= !empty($rightbar_template) ? "image_gallery_scroll_container" : "image_gallery_scroll_container_full" ?>">
			<table id="image_gallery_scroll_table" class="image_gallery_scroll <?= $pathclass ?>" style="" cellpadding=0 cellspacing=0>
			<tr id="image_gallery_scroll_row_<?= $key ?>">
				<? 
				$i = 0;
				foreach($charms as $charm) 
				{ 
					#$hidden = $i++ > 0 ? "hidden" : "";
					$hidden = "";
					if (isset($charm["Charm"]))
					{
						$charm = $charm['Charm'];
					}
					#
				?>
				<td class="padded image" valign=top align=center>
					<a rel="shadowbox" title="<?= ucwords($charm['name']) ?>" href="/charms/large/<?= basename($charm['graphic_location']); ?>" onClick="selectCharm(this, '<?= $charm['charm_id'] ?>'); return false;"><img border="0" src="<?= $charm['graphic_location'] ?>" id="image_gallery_<?=$underpath?>" height="50"/></a>
					<a rel="shadowbox" title="<?= ucwords($charm['name']) ?>" href="/charms/large/<?= basename($charm['graphic_location']); ?>" onClick="selectCharm(this, '<?= $charm['charm_id'] ?>'); return false;"><?= $charm['name'] ?></a>
				</td>
				<?
				}
				?>
			</tr>
			</table>
			</div>
		</td>
		<td>
			<a href="Javascript:void(0)" onClick="return image_gallery_album_scroll_right('image_gallery_scroll_row_<?=$key ?>');"><img src="/images/buttons/Circle-right.gif"/></a>
		</td>
	</tr>
	</table>

<?
}
?>
</div>

