						<? if(count($related_products) > 1) { ?>
						<div>
							<b>Select a Product:</b>
							<br/>
							<select onChange="showPleaseWait(); document.location.href = '/build/customize/'+this.value;" name="prod">
							<? foreach($related_products as $rp) { ?>
								<option <?= $build['Product']['code'] == $rp['Product']['code'] ? "selected='selected'" : ""; ?> value="<?= $rp['Product']['code'] ?>"> <?= !empty($rp['Product']['pricing_name']) ? strip_tags($rp['Product']['pricing_name']) : strip_tags($rp['Product']['name']); ?></a><?= !empty($rp['Product']['pricing_description']) ? " &mdash; ".$rp['Product']['pricing_description'] : "" ?></option>
							<? } ?>
							</select>
						</div>
						<? } ?>

						<!--
						<div style="">
							<? if(!empty($build['CustomImage'])) { ?>
								<a style="font-size: 12px; font-weight: bold; color: #000099;" href="/custom_images/view/<?= $build['CustomImage']['Image_ID'] ?>">Order other products</a>
							<? } else { ?>
								<a style="font-size: 12px; font-weight: bold; color: #000099;" href="/gallery/view/<?= $build['GalleryImage']['catalog_number'] ?>">Order other products</a>
							<? } ?>
							<br/>
							<br/>
						</div>
						-->

						<? $min = $product['Product']['minimum']; ?>

						<table cellpadding=0 cellspacing=0>
						<tr>
							<td valign="bottom">
								<div class="bold">Quantity:</div>
								<input id="quantity2" type="text" size=3 value="<?= $quantity ?>" onChange="if(this.value < parseInt('<?=$min?>')) { alert('Minimum quantity is <?=$min?>'); this.value = '<?=$min?>'; }; $('quantity').value = this.value;"/>
								x <?= sprintf("$%.02f", $base_price); ?> ea = <?= sprintf("$%.02f", $base_price * $quantity); ?> 
							</td>
							<td valign="bottom">
								<div style="padding-left: 20px;">
									<a href="Javascript:void(0);" onClick="selectProductQuantity('<?= $product['Product']['code'] ?>', $('quantity2').value); "><img src="/images/buttons/small/Calculate-grey.gif"/></a>
								</div>
							</td>
						</tr>
						</table>
						<?=$this->element("shipfree"); ?>

<br/>

