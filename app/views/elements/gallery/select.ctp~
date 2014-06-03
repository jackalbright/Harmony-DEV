<div>
<? if(empty($prod)) { $prod = !empty($product['Product']['code']) ? $product['Product']['code'] : null; } ?>

<table style="background-color: white; position: relative; border: solid #CCC 1px; height: 200px; padding: 0px; margin: 0px;">
<tr>
	<td style="" align=center valign="top">
		<a href="/custom_images">
			<img border=0 src="/images/upload_image.jpg" alt="Upload Your Image">
		</a>
		<?php echo $form->create('CustomImage',array('type'=>'file'));?>
			<?= $form->input('file',array('type'=>'file','label'=>'')) ?>
			<input type="image" src="/images/buttons/Upload-Your-Image-grey.gif"/>
		</form>
		<div class="bold">- OR -</div>
		<a href="/custom_images">Select a previously uploaded image</a>
	</td>
	<td style="" valign="middle" style="font-weight: bold; font-size: 16px;">
		<nobr class="bold">- OR -</nobr>
	</td>
	<td style="" align=center valign="top">
		<a href="/gallery/browse?<?= empty($custom_only) ? "prod=$prod" : "clear_product=1" ?>">
			<img border=0 src="/images/choose_stamp.jpg" alt="Use One of Our Images">
		</a>
		<form method="POST" action="/gallery/browse">
			<? if(empty($custom_only)) { ?>
			<input type="hidden" name="prod" value="<?= $prod ?>">
			<? } else { ?>
			<input type="hidden" name="clear_product" value="1"/>
			<? } ?>
			<!--
			<input type='submit' value='Browse Our Images &gt;'/>
			-->
			<input type="image" src="/images/buttons/Browse-Our-Images-grey.gif"/>
		</form>
	</td>
</tr>
</table>

<? if(empty($short)) { ?>

<p style="padding-top: 40px; font-size: 16px;">
After you upload or choose an image, you will be able to add text and personalization with no setup or design charges.
</p>
<p style="padding-top: 20px; font-size: 16px;">
<b>Please note:</b> Your images are used for your gifts only. We never use customer art for any other purpose. Harmony Designs will request permission if we want to feature your product in our catalogs or on our website.
</p>

<? } ?>

</div>
