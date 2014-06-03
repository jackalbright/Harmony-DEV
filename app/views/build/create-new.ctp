<div id="build">
	<table style="width: 700px;" align="center" border=1 cellspacing=0 cellpadding=0>
	<tr>
		<td style="width: 200px;" valign="top">
			<?= $this->element("build/preview",array('live'=>1)); ?>

			<div class="padded relative">	
				<br/>
				<a class="bold" href="/products/select">Select a different product</a>
				<br/>
				<br/>
				<a class="bold" href="/gallery">Select a different image</a>
				<br/>
				<br/>
				<a class="bold" href="Javascript:void(0);" onClick="$('press_ready_popup').removeClassName('hidden');">Have a "press-ready" layout/design?</a>
				<div class="hidden" id="press_ready_popup">
					<div align="right"><a href="Javascript:void(0)" onClick="$('press_ready_popup').addClassName('hidden');">Close</a></div>
					<p>A "press-ready" layout/design is a completed artwork for direct printing. 
					<p>To send us your "press-ready" design, attach it via email to <a href="mailto:graphics@harmonydesigns.com?subject=Completed Art">graphics@harmonydesigns.com</a>
					<br/>
					<br/>
				</div>
			</div>

			<div class="padded">
				<br/>
				<h4>Example Diagram:</h4>
				<img src="/images/products/diagram/<?= $build['Product']['code'] ?>.jpg"/>
			</div>
		</td>
		<td valign="top">
			<form id="build_form" name="build_form" method="POST" action="/cart/add_consolidated"/>
			<input type="hidden" name="data[cart_item_id]" value="<?= !empty($build['cart_item_id']) ? $build['cart_item_id'] : "" ?>"/>
			<input type="hidden" name="data[productCode]" value="<?= $build['Product']['code'] ?>"/>
			<input type="hidden" name="data[options][customImageID]" value="<?= !empty($build['CustomImage']) ? $build['CustomImage']['Image_ID'] : "" ?>"/>
			<input type="hidden" name="data[options][catalogNumber]" value="<?= !empty($build['GalleryImage']) ? $build['GalleryImage']['catalog_number'] : "" ?>"/>
			<table width="100%" border=0 cellspacing=0 cellpadding=5>
			<tr style="background-color: white;">
				<td colspan=2 valign="top">
					<?= $this->element("products/intro"); ?>

					<?= $this->element("products/pricing_grid_compact"); ?>
				</td>
			</tr>
			<? $i = 0; foreach($options as $option) { 
				$option_code = $option['Part']['part_code'];
				$i++;
			?>
			<tr>
				<td colspan=1 class="top_border grey_border" valign="top">
					<div class="right_padding bottom_padding left">
						<img src="/images/icons/<?= $i ?>.gif" height="25"/>
					</div>
					<?
					$extra_charge = !empty($option['Part']['price']) ? " extra charge" : "";
					?>
					<div class="left"><b><?= $option['Part']['part_name'] ?> <? if($option['ProductPart']['optional'] == 'yes') { echo "(opt.) $extra_charge"; } ?></b>&nbsp;&nbsp;</div>

					<? if(!empty($option['Part']['part_summary'])) { ?>
					<div class="part_summary">
						<?= $option['Part']['part_summary'] ?>
					</div>
					<? } ?>

					<?= $hd->product_element("build/options/$option_code", $build['Product']['prod'], array()); ?>
				</td>
				<td colspan=1 align="center" class="left_border top_border grey_border" valign="middle">
					<?= $hd->product_element("build/options/{$option_code}_preview", $build['Product']['code'], array(), true); ?>
				</td>
			</tr>
			<? } ?>

			<tr>
				<td colspan=1 class="top_border grey_border">
					<div class="right_padding bottom_padding left">
						<img src="/images/icons/<?= ++$i ?>.gif" height="25"/>
					</div>

					<div class="left"><b>Comments</b></div>

					<?= $this->element("build/options/comments"); ?>
				</td>
				<td colspan=1 align="center" class="left_border top_border grey_border">
				&nbsp;
				</td>
			</tr>

			<tr>
				<td colspan=2 class="top_border grey_border">
					<div class="right_padding bottom_padding left">
						<img src="/images/icons/<?= ++$i ?>.gif" height="25"/>
					</div>
					<? if(empty($build['cart_item_id'])) { ?>
						<div class=""><b>Add to Cart</b> </div>
						<i>(Click 'Add to Cart' to view shipping costs. Items can be removed later)</i>
					<? } else { ?>
						<div class=""><b>Update Cart</b> </div>
						<i>(Click 'Update Cart' to view shipping costs. Items can be removed later)</i>
					<? } ?>

					<div class="clear"></div>

					<table width="100%">
					<tr>
						<td width="33%" style="border-right: solid #ccc 1px;" valign="top">
							<h3><input type="radio" name="data[proof]" value="no" <? !empty($build['proof']) && $build['proof'] == 'no' ?> /> No Proof</h3>
							<div class="">
							Ordering without an email proof will speed up your order.
							</div>
							<br/>

							<?= $this->element("build/quantity_new", array('url'=>'')); ?>
						</td>
						<td width="33%" style="border-right: solid #ccc 1px;" valign="top">
							<h3><input type="radio" name="data[proof]" value="yes" <? !empty($build['proof']) && $build['proof'] == 'yes' ?> /> Email Proof</h3>
							<div class="">
							An email proof is free with your order.
							</div>
							<br/>

							<?= $this->element("build/quantity_new", array('url'=>'')); ?>
						</td>
						<td width="33%" style="" valign="top">
							<h3><input type="radio" name="data[proof]" value="only" <? !empty($build['proof']) && $build['proof'] == 'only' ?> /> Proof Only</h3>
							<div class="">
							Proof costs will be refunded upon order completion.
							</div>
							<br/>
							$25.00 your cost
							+ $x charged upon completion
						</td>
					</tr>
					<tr>
						<td valign="top">
							<div class="clear" align="">
							<? if(empty($build['cart_item_id'])) { ?>
								<input type="image" src="/images/buttons/Add-to-Cart.gif"/>
							<? } else { ?>
								<input type="image" src="/images/buttons/Update-Cart.gif"/>
							<? } ?>
							</div>
						</td>
						<td valign="top">
							<div class="clear" align="">
							<? if(empty($build['cart_item_id'])) { ?>
								<input type="image" src="/images/buttons/Add-to-Cart.gif"/>
							<? } else { ?>
								<input type="image" src="/images/buttons/Update-Cart.gif"/>
							<? } ?>
							</div>
						</td>
						<td valign="top">
							<div class="clear" align="">
							<? if(empty($build['cart_item_id'])) { ?>
								<input type="image" src="/images/buttons/Add-to-Cart.gif"/>
							<? } else { ?>
								<input type="image" src="/images/buttons/Update-Cart.gif"/>
							<? } ?>
							</div>
						</td>
					</tr>


						</td>
					</tr>
					</table>



				</td>

			</tr>
			</table>

			</form>
		</td>
	</tr>
	</table>

	<script>
		hidePleaseWait();
	</script>


</div>
