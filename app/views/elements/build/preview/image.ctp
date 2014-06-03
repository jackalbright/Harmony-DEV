<div class="border top_margin">

<table width="100%" class="border_bottom small_bottom_margin"><tr>
	<td valign=top>
		<h3 class="">Image:</h3>
	</td>
	<td valign=top align=right>
		<? if (isset($build['catalog_number']) || isset($build['imageID'])) { ?>
			[<a href="/gallery">Change image</a>]
		<? } else { ?>
			[<a href="/gallery">Select an image</a>]
		<? } ?>
	</td>
</tr> </table>
<div class="padded">
<? if (isset($build['catalog_number'])) { ?>
	<?= $this->element("build/preview/gallery_image"); ?>
<? } else if (isset($build['imageID'])) { ?>
	<?= $this->element("build/preview/custom_image"); ?>
<? } else { ?>
	<b>(No image selected)</b>
	<br/>
	<br/>
<? } ?>
</div>

</div>
