
<?
if (empty($step)) { $step = ''; } # Show 5 steps without any highlighting...

?>
<div id="steps_container" align="" class="hidden">
	<table border=0 id="steps" cellpadding=0 cellspacing=0>
	<tr>
		<? if (!empty($stock) || (!empty($build['Product']) && $build['Product']['is_stock_item']) || (!empty($product['Product']) && $product['Product']['is_stock_item'])) { ?>
			<td id="" class="step1 step <?= $step == 'product' ? 'selected_step' : ''; ?>" valign="top">
				<nobr><?= $purchase_steps['product']['title'] ?></nobr>
				<div class="step_subtext"><?= strip_tags($purchase_steps['product']['text']); ?></div>
			</td>
			<td id="" class="step2 step <?= $step == 'cart' ? 'selected_step' : ''; ?>" valign="top">
				<nobr><?= $purchase_steps['cart']['title'] ?></nobr>
				<div class="step_subtext"><?= strip_tags($purchase_steps['cart']['text']); ?></div>
			</td>

		<? } else { ?>

			<? if(empty($build['image_first'])) { ?>
			<td id="" class="step1 step <?= $step == 'product' ? 'selected_step' : ''; ?>" valign="top">
				<nobr><?= $purchase_steps['product']['title'] ?></nobr>
				<div class="step_subtext"><?= strip_tags($purchase_steps['product']['text']); ?></div>
			</td>
			<td id="" class="step2 step <?= $step == 'image' ? 'selected_step' : ''; ?>" valign="top">
				<nobr><?= $purchase_steps['image']['title'] ?></nobr>
				<div class="step_subtext"><?= strip_tags($purchase_steps['image']['text']); ?></div>
			</td>
			<? } else { ?>
			<td id="" class="step1 step <?= $step == 'image' ? 'selected_step' : ''; ?>" valign="top">
				<nobr><?= $purchase_steps['image']['title'] ?></nobr>
				<div class="step_subtext"><?= strip_tags($purchase_steps['image']['text']); ?></div>
			</td>
			<td id="" class="step2 step <?= $step == 'product' ? 'selected_step' : ''; ?>" valign="top">
				<nobr><?= $purchase_steps['product']['title'] ?></nobr>
				<div class="step_subtext"><?= strip_tags($purchase_steps['product']['text']); ?></div>
			</td>
			<? } ?>
	
			<? if (empty($build['GalleryImage']) && empty($gallery)) { ?>
			<td id="" class="step3 step <?= $step == 'layout' ? 'selected_step' : ''; ?>" valign="top">
				<nobr><?= $purchase_steps['layout']['title'] ?></nobr>
				<div class="step_subtext"><?= strip_tags($purchase_steps['layout']['text']); ?></div>
			</td>
	
			<td id="" class="step4 step <?= $step == 'options' ? 'selected_step' : ''; ?>" valign="top">
				<nobr><?= $purchase_steps['options']['title'] ?></nobr>
				<div class="step_subtext"><?= strip_tags($purchase_steps['options']['text']); ?></div>
			</td>
			<td id="" class="step5 step <?= $step == 'cart' ? 'selected_step' : ''; ?>" valign="top">
				<nobr><?= $purchase_steps['cart']['title'] ?></nobr>
				<div class="step_subtext"><?= strip_tags($purchase_steps['cart']['text']); ?></div>
			</td>
			<? } else { ?>
			<td id="" class="step3 step <?= $step == 'options' ? 'selected_step' : ''; ?>" valign="top">
				<nobr><?= $purchase_steps['options']['title'] ?></nobr>
				<div class="step_subtext"><?= strip_tags($purchase_steps['options']['text']); ?></div>
			</td>
			<td id="" class="step4 step <?= $step == 'cart' ? 'selected_step' : ''; ?>" valign="top">
				<nobr><?= $purchase_steps['cart']['title'] ?></nobr>
				<div class="step_subtext"><?= strip_tags($purchase_steps['cart']['text']); ?></div>
			</td>
			<? } ?>
		<? } ?>
	</tr>
	</table>
	<div class="clear"></div>
</div>
