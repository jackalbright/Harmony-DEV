<div>
	<div id="preview" class="" align="left">
		<div class="bold">
		<label for="upload_image"><input id="upload_image" type="radio" name="" value="" checked='checked' onClick="$('image_form').removeClassName('hidden'); $('gallery_form').addClassName('hidden');"/> Upload My Image</label>
		<label for="browse_gallery"><input id="browse_gallery" type="radio" name="" value="" onClick="$('image_form').addClassName('hidden'); $('gallery_form').removeClassName('hidden');"/> Browse Stamp Gallery</label>
		</div>
		<br/>

		<form id="image_form" method="POST" enctype="multipart/form-data" action="/custom_images/add" align="center">
		<div align="center">
			<input type="file" name="data[CustomImage][file]" size="15"/>
			<div align="center">
			<b>ON</b><br/>
					<select name="prod" style="width: 150px;">
						<option value="">All Products</option>
						<? foreach($all_products as $p) { if(!preg_match("/custom/", $p['Product']['image_type'])) { continue; }; ?>
						<option value="<?= $p['Product']['code'] ?>"><?= $p['Product']['name'] ?></option>
						<? } ?>
					</select>
			</div>
			<div align="center">
					<input type="image" src="/images/webButtons2014/blue/large/getStarted.png"/>
			</div>
		</div>
		</form>

		<form id="gallery_form" method="POST" class="hidden" action="/gallery/browse">
		<div align='center'>
			<select name="browse_node_id" style="width: 150px;">
				<option value="">[All subjects]</option>
				<? foreach($subjects as $sub) { ?>
					<option value="<?= $sub['GalleryCategory']['browse_node_id'] ?>"><?= $sub['GalleryCategory']['browse_name'] ?></option>
				<? } ?>
			</select>
			<div class="bold" align="center">
				ON
			</div>
			<div>
			<select name="prod" style="width: 150px;">
				<option value="">All Products</option>
				<? foreach($all_products as $p) { ?>
					<? if(!preg_match("/(real|repro)/", $p['Product']['image_type'])) { continue; } ?>
				<option value="<?= $p['Product']['code'] ?>"><?= $p['Product']['name'] ?></option>
				<? } ?>
			</select>
			</div>
			<div align="center">
				<input type="image" src="/images/webButtons2014/blue/large/getStarted.png"/>
			</div>
		</div>
		</form>
	</div>

</div>

<? $direct_upload = true; ?>
<?if(empty($product['Product']['is_stock_item'])) { ?>
<? if(empty($prod)) { $prod = ''; } ?>

<div align="center" class="bold hidden">
<? if(empty($product) || preg_match("/custom/", $product['Product']['image_type'])) { ?>
<? if(!empty($direct_upload)) { ?>
	<form method="POST" action="/custom_images/add" enctype="multipart/form-data" onSubmit="showPleaseWait();">
		<input type="hidden" name="prod" value="<?= $product['Product']['code'] ?>"/>
		<div align="left" style="color: white;">
			<label class="bold white">Step 1. Choose image</label>
			<input type="file" name="data[CustomImage][file]" size="10"/> <br/>
			<label class="bold white">Step 2.</label>
			<div align="center">
				<input type="image" src="/images/buttons/Upload-Image.gif"/>
			</div>
		</div>
	</form>
<? } else { ?>
	<a href="/custom_images/add?prod=<?= $prod?>"><img src="/images/buttons/Upload-Image.gif"/></a>
<? } ?>
<br/>
or
<br/>
<? } ?>
<? if(empty($product) || preg_match("/(real|repro)/", $product['Product']['image_type'])) { ?>
<a href="/gallery/browse?prod=<?= $prod?>"><img src="/images/buttons/small/Browse-Our-Images.gif"/></a>
<br/>
<? if(empty($product) || preg_match("/custom/", $product['Product']['image_type'])) { ?>
or
<br/>
<? } ?>
<? } ?>
<? if(empty($product) || preg_match("/custom/", $product['Product']['image_type'])) { ?>
<a href="mailto:info@harmonydesigns.com?subject=Completed Art">Email your completed<br/>art as an attachment</a>
<br/>
<? } ?>

</div>

<? } else { ?>
<div align="left" class="">
	<form method="POST" action="/cart/add.php" onSubmit="return (verifyRequiredFields(this.id) && assertMinimum('<?= $product['Product']['minimum'] ?>'));">

	<div class="bold">Select a style:</div>
	<table cellpadding=0 cellspacing=0>
	<? $i = 0; foreach($compare_products as $cp) { ?>
	<tr>
		<td valign="top">
			<input type="radio" name="productCode" value="<?= $cp['code'] ?>" <?= empty($i) ? "checked='checked'" : "" ?> />
		</td>
		<td valign="top">
			<?= $cp['pricing_name'] ?>
			<br/>
			<br/>
		</td>
	</tr>
	<? $i++; } ?>
	</table>

	<div align="center">

	<b>Quantity:</b>
	<input value="<?= $product['Product']['minimum'] ?>" onchange="return assertMinimum(<?= $product['Product']['minimum'] ?>);" size="3" name="quantity" id="quantity">

		<br/>

		<input type="image" class="" src="/images/buttons/Add-to-Cart.gif">
	</div>
	</form>
</div>

<? } ?>
