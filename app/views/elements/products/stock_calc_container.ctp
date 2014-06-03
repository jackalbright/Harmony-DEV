<script type="text/javascript">
console.log('testPreviewItem');
var session = '(<?php echo $_SESSION['testPreviewItem'];?>';
 console.log(session);
 console.log('testCondition');
 var session = '(<?php echo $_SESSION['testCondition'];?>';
 console.log(session);
 
</script>

<div style="width: 235px;">
		<form id="chooseProductForm" method="POST" enctype="multipart/form-data" action="/cart/add.php" onSubmit="return (verifyRequiredFields(this.id) && assertMinimum('<?= $product['Product']['minimum'] ?>'));">
		<input type="hidden" name="productCode" value="<?= $prod ?>"/>


		<? if(!empty($product['Product']['customizable'])) { ?>
		<table width="100%">
		<tr>
			<td colspan=2 align="left">
			<? if(!empty($product['Product']['semi_customizable_catalog_number'])) { ?>
				<input type="hidden" name="catalogNumber" value="<?= $product['Product']['semi_customizable_catalog_number'] ?>"/>
			<? } ?>
			<? if(!empty($semi_customizable_quotes)) { ?>
				<div class="bold">Available quotes:</div>
				<div style="background-color: #DDD; padding: 2px;">
				<? $i = 0; foreach($semi_customizable_quotes as $quote) { ?>
				<input type="radio" name="quoteID" <?= $i++ == 0 ? "checked='checked'" : "" ?> value="<?= $quote['Quote']['quote_id'] ?>"/> 
					<?= $quote['Quote']['text'] ?>
					<? if(!empty($quote['Quote']['attribution'])) { ?>
					<div align="right" class="italic">
						&mdash; <?= $quote['Quote']['attribution'] ?>
					</div>
					<? } ?>
				<? } ?>
				</div>
			<br/>
			<br/>
			<? } ?>

			<? if(!empty($product['Product']['semi_customizable'])) { ?>
				<input type="hidden" name="customized" value="1"/>

			<? } else { ?>

			<div class="bold">Personalization Options:</div>

			<select id='customized' name="customized" onChange="
				if(this.value == 'logo') { $('perslogoform').show(); $('perstextform').hide();$('#personalizationInput').val(' '); } 
				else if (this.value == 'personalization') { $('perstextform').show(); }; 

				if(this.value != 'logo') { $('perslogoform').hide(); };
				if(this.value != 'personalization') { $('perstextform').hide(); };
				calculateStockSubtotal('<?= $product['Product']['code']?>','<?= !empty($_REQUEST['cart_item_id']) ? $_REQUEST['cart_item_id'] : null ?>');
				">
				<option value="">No personalization</option>
				<? if($product['Product']['customizable'] == 'both' || $product['Product']['customizable'] == 'logo') { ?>
				<option value="logo" <?= !empty($preview['options']['personalization_logo_id']) ? "selected='selected'" : "" ?> >Add logo <?= !empty($product['Product']['setup_charge']) ? "(+\${$product['Product']['setup_charge']})" : "" ?></option>
				<? } ?>
				<option value="personalization" <?= !empty($preview['options']['personalizationInput']) ? "selected='selected'" : "personalizationSelection" ?> >Add text personalization  <?= !empty($product['Product']['setup_charge']) ? "(+\${$product['Product']['setup_charge']})" : "" ?></option>
			</select>

			<div id="perslogoform" style="<?= !empty($preview['options']['personalization_logo_id']) ?"":"display:none;"?> background-color: #DDD; margin: 0px 0px 10px 0px; padding: 5px; ">
				<b>Add your own logo</b>
				<? if(!empty($preview['PersonalizationLogo'])) { ?>
				<div id="pers_logo_preview" class="center">
					<img id="pers_logo" src="<?= $preview['PersonalizationLogo']['thumbnail_location'] ?>"/>
					<input id="personalization_logo_id" type="hidden" name="data[options][personalization_logo_id]" value="<?= $preview['options']['personalization_logo_id'] ?>"/>
				</div>
				<? } ?>

				<div id="uploader">
					<input id="file" type="file" style="width: 200px;" size=14 name="data[PersonalizationLogo][file]" onChange="$('personalizationInput').value = ''; $('personalizationLength').innerHTML = '0';"/>
				</div>
				<div align="center">
					<a id="preview_button" href="Javascript:void(0)" onClick="previewImage(this);"><img src="/images/webButtons2014/grey/large/preview.png"/></a>
				</div>
			</div>

			<? } ?>

			<div id='perstextform' 
			style="<?= !empty($product['Product']['semi_customizable']) || !empty($preview['options']['personalizationInput']) ? "":"display: none;" ?> 
			background-color: #DDD; margin: 0px 0px 10px 0px; padding: 5px; "
			>
				<b>Type up to two lines of text</b>
				<div>
					<?
						$personalizationInput = !empty($preview['options']['personalizationInput']) ? $preview['options']['personalizationInput'] : null;
					?>

					<textarea rows=2 id="personalizationInput" name="data[options][personalizationInput]" 
						style="width: 95%; height: 3em; overflow: clip;" onChange="var file = $('file'); if(file) { file.value = ''; }; if($('pers_logo_preview')) { $('pers_logo_preview').update(); }"
						onkeyup="typingPersonalization(event, '<?= !empty($product['Product']['personalizationLimit']) ? $product['Product']['personalizationLimit'] : 30 ?>');"><?= $personalizationInput ?></textarea>
					Text will be centered
					<div align="right" class="note"> <span id="personalizationLength"><?= strlen($personalizationInput) ?></span> of <?= $product['Product']['personalizationLimit'] ?> characters.  </div>
					<div class="clear"></div>
				</div>
				<div align="center">
					<a id="preview_button" href="Javascript:void(0)" onClick="previewImage(this);"><img src="/images/webButtons2014/grey/large/preview.png"/></a>
				</div>
			</div>



				<!-- can't preview as it'll require uploading the logo; even if we did, where would it GO? and how would it keep the selection 
					and go some place else when we click ATC? -->

				<!-- 

				-->
				<script>
				function previewImage()
				{
					// Submit to iframe. once iframe is loaded, have it show and the other image hide.
					showPleaseWait();
					//$('preview_iframe').show();
					//$('master_link').hide();
					//$('master_larger').hide();
					$('chooseProductForm').action = '/product_image/preview';
					$('chooseProductForm').target = 'preview_iframe';
					$('chooseProductForm').submit();

				}
				</script>
				<iframe id="preview_iframe" name="preview_iframe" style="display: none;"></iframe>
				<div style="display: none;">
					<a id="preview_img" href="/product_image/stock_preview/-1200x1200.png?rand=<?= rand(1,50000) ?>" rel="shadowbox">View Larger</a>
				</div>


			</td>
		</tr>
		</table>
		<? } else { ?>

		<? } ?>

		<div id="stock_calc">
			<?= $this->element("products/stock_calc"); ?>
		</div>
				</form>
</div>

