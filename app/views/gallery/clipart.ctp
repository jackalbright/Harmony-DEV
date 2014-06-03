<div>

<table border=0 width="100%">
<tr>
	<td width="25%" valign="top">
		<h4>1. Search Clipart.com&trade;</h4>
		<p>
		Search over 10 million downloadable images from Clipart.com&trade; for use on Harmony Designs&trade; products.
		</p>

		<form method="GET" action="http://www.clipart.com/en/search/split" target="results" onSubmit="$('results_pane').removeClassName('hidden');"/>
		<table><tr>
			<td> <input type="text" name="q" size="15"/> </td>
			<td> <input type="image" src="/images/buttons/Search-grey.gif" /> </td>
		</tr></table>
		</form>
	</td>
	<td width="25%" valign="top">
		<h4>2. Select an Image</h4>
		<p>
		etc
		</p>
	</td>
	<td width="25%" valign="top">
		<h4>3. Drag and Drop Your Image</h4>
		<p>
		Click on an image to view larger, then <b>drag and drop the full-sized image to desktop</b>.
		</p>
	</td>
	<td width="25%" valign="top">
		<h4>4. Upload Image</h4>
		<p>
		Upload your Clipart.com&trade; image to view it on our products. Please note: We will download a full-sized royalty-free copy of this image without the watermark for your final product.
		</p>
				<?php echo $form->create('CustomImage',array('type'=>'file'));?>
				<? echo $form->input('file',array('type'=>'file','label'=>"Upload File",'class'=>'required')); ?>
				<input type="image" src="/images/buttons/Upload-Image.gif"/>
				</form>
	</td>
</tr>
</table>

	<div class="hidden" id="results_pane">
		<iframe name="results" style="width: 100%; height: 400px; overflow: scroll;">Please enter in a keyword and click 'Search' above.</iframe>
	</div>

</div>
