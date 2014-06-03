<?
$default_hide = (count($compare_products) > 1);
?>
	<style>
	#product_compare ul
	{
		margin-left: 0px;
	}
	</style>

		<table width="100%" style="border-collapse: collapse;" id="product_compare">

		<?if(count($compare_products) > 1) { ?>
		<tr style="background-color: #339933; color: white; text-align: center; font-size: 14px; font-weight: bold;" class="">
		<? foreach($compare_products as $cp) { ?>
			<th align="left" width="<?= floor(100/count($compare_products)); ?>%">
				<?= $cp['pricing_name'] ?> 
				<? if(count($compare_products) == 1) { ?>
				<?= !empty($cp['pricing_description']) ? " &mdash; " . $cp['pricing_description'] : null; ?>
				<? } ?>
			</th>
		<? } ?>
		</tr>
		<? } ?>
		<tr>
		<? foreach($compare_products as $cp) { ?>
		<td style="padding: 5px; font-size: 12px;" valign="top">
			<?php echo $cp['description'] ?>
		</td>
		<? } ?>
		</tr>
		<tr>
		<? foreach($compare_products as $cp) { ?>
		<td style="padding: 5px; font-size: 12px;" valign="top">
			<?= $cp['free_with_your_order'] ?>
		</td>
		<? } ?>
		</tr>

		</table>

