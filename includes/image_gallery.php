<?
function display_gallery($path = '', $class = '', $gallery_title = '')
{
if ($gallery_title == '') { $gallery_title = 'Sample Gallery'; }
$ext = 'jpg';
$pathclass = "image_gallery_" . preg_replace("/\//", "_", $path);

if (!$path)
{
	$path = preg_replace("/[.]\w+$/", "", $_SERVER['REQUEST_URI']); # Autogenerated from page path.
	$path = preg_replace("/^\//", "", $path);
}
#error_log("P=$path");

$file_count = get_gallery_file_count($path, $ext);
if ($file_count > 0)
{
	$underpath = preg_replace("/\W+/", "_", $path);
?>
	<div class="image_gallery <?= $class ?> <?= $pathclass ?>">
		<div class="subtitle"><div><?= $gallery_title ?></div></div>
		<table class="image_gallery_nav" width="100%">
		<tr><td align=left>
			<button class="image_gallery_button" onClick="image_gallery_previous('<?=$path?>', <?= $file_count ?>, '<?=$ext?>');">&laquo; Previous</button>
		</td>
		<td align=center id="image_gallery_counter_<?=$underpath?>">1 of <?= $file_count ?></td>
		<td align=right>
			<button class="image_gallery_button" onClick="image_gallery_next('<?=$path?>', <?= $file_count ?>, '<?=$ext?>');">Next &raquo;</button>
		</td></tr>
		</table>
		<br/>
		<a class="smoothbox" id="image_gallery_largelink1_<?=$underpath?>" href="/images/galleries/<?= $path ?>/large/0.<?=$ext?>">
			<img border="0" src="/images/galleries/<?= $path ?>/0.<?=$ext?>" id="image_gallery_<?=$underpath?>"/>
		</a>
		<br/>
		<a class="smoothbox" id="image_gallery_largelink2_<?=$underpath?>" href="/images/galleries/<?= $path ?>/large/0.<?=$ext?>">
		+ View Larger</a>
	</div>
<?
}

}
function get_gallery_file_count($path, $ext)
{
	$d;
	$dir = dirname(__FILE__)."/../images/galleries/$path";
	#echo "D=$dir";
	if (!file_exists($dir))
	{
		return 0;
	}
	$d = opendir($dir);
	$count = 0;
	while($f = readdir($d))
	{
		if (preg_match('/^\d+[.]'.$ext.'$/i', $f))
		{
			$count++;
		}

	}
	closedir($d);
	return $count;
}
?>
