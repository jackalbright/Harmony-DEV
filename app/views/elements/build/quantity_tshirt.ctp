<div id="quantity_container">

<?
$discounted = ($build['retail_price_list']['total'] > $build['quantity_price_list']['total']);
?>

<table cellpadding=3 cellspacing=0>
<tr>
	<td align="left">

					<? if(empty($build['cart_item_id'])) { ?>
						<input type="image" src="/images/buttons/Add-to-Cart.gif" onClick="return assertMinimum_tshirt('<?= $build['Product']['minimum'] ?>');" onClickX="return confirmCompletedBuildForm();"/>
					<? } else { ?>
						<input type="image" src="/images/buttons/Update-Cart.gif" onClick="return assertMinimum_tshirt('<?= $build['Product']['minimum'] ?>');" onClickX="return confirmCompletedBuildForm();"/>
					<? } ?>
	</td>
</tr>
<tr>
	<td>
		<?= $this->element("build/estimate_tshirt"); ?>

					<? if(empty($build['cart_item_id'])) { ?>
						<input type="image" src="/images/buttons/Add-to-Cart.gif" onClick="return assertMinimum_tshirt('<?= $build['Product']['minimum'] ?>');" onClickX="return confirmCompletedBuildForm();"/>
					<? } else { ?>
						<input type="image" src="/images/buttons/Update-Cart.gif" onClick="return assertMinimum_tshirt('<?= $build['Product']['minimum'] ?>');" onClickX="return confirmCompletedBuildForm();"/>
					<? } ?>
	</td>
</tr>
</table>

	<br/>
	<br/>


</div>
