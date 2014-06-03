<?

# If /images/blanks/$name dir exists....

$name = $this_product->code;
$base_path = dirname(__FILE__)."/../images/blanks/$name";

if (false && ($name && is_dir($base_path)))
{
?>
		<h3><?php echo $this_product->name; ?> Preview</h3>
			<div class="center" style="margin: 0px auto 0px auto;">
				<table border=0 cellpadding=0 cellspacing=0 style="border: solid black 1px;">
				<tr>
					<td colspan=3>
						<img src="/images/blanks/<?= $name ?>/top.gif">
					</td>
				</tr>
				<tr>
					<td colspan=1>
						<img src="/images/blanks/<?= $name ?>/left.gif">
					</td>
					<td colspan=1 style="background-color: white; height: 90px; vertical-align: middle; text-align: center; background-image: url('/images/blanks/<?= $name ?>/center.gif'); ">
						<div style="overflow: hidden; width: 90px; height: 90px;">
						<table style="width: 100%; height: 100%;" border=0 cellpadding=0 cellspacing=0>
						<tr>
							<td valign=middle align=center>
								<img style="border: solid #444 2px;" id="thumbnail" src="<?= $image->displayThumb() ?>" alt="<?= $image->name ?>" />
							</td>
						</tr>
						</table>
						</div>
					</td>
					<td colspan=1>
						<img src="/images/blanks/<?= $name ?>/right.gif">
					</td>
				</tr>
				<tr>
					<td colspan=3>
						<img src="/images/blanks/<?= $name ?>/bottom.gif">
					</td>
				</tr>
				</table>
			</div>

<? } else { ?>
			<div class="center">
				<a id="stampEnlarge" href="<?= $image->displayImg(); ?>" onclick="return displayDetailImage('<?= $image->displayImg() ?>')">
					<img id="thumbnail" src="<?= $image->displayThumb() ?>" alt="<?= $image->name ?>" />
				</a>
			</div>

<? } ?>
	<br/>
	<p class="center">
			<a id="stampEnlarge" href="<?= $image->displayImg(); ?>" onclick="return displayDetailImage('<?= $image->displayImg() ?>')">
					<img src="/images-icons/magnifying-glass.gif" width="19" height="14" align="top" />view larger
				</a>
	</p>
			<hr class="divider" />
