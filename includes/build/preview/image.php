<div class="border top_margin">

<table width="100%" class="border_bottom small_bottom_margin"><tr>
	<td valign=top>
		<h3 class="">Image:</h3>
	</td>
	<td valign=top align=right>
		<? if (isset($build['GalleryImage']) || isset($build['CustomImage'])) { ?>
			[<a href="/gallery?new=1">Change image</a>]
		<? } else { ?>
			[<a href="/gallery?new=1">Select an image</a>]
		<? } ?>
	</td>
</tr> </table>
<div class="padded">
<? if (!empty($build['GalleryImage'])) { ?>
	<? include(dirname(__FILE__)."/gallery_image.php"); ?>
<? } else if (!empty($build['CustomImage'])) { ?>
	<? include(dirname(__FILE__)."/custom_image.php"); ?>
<? } else { ?>
	<b>(No image selected)</b>
	<br/>
	<br/>
<? } ?>
</div>

</div>
