<a name="included"></a>
<?  $default_hide = 0;#(count($compare_products) > 1); ?>

<table width="100%" cellpadding=5 style="" align="center" border=0>
<tr>
<? if(!empty($product['Product']['description'])) { ?>
<td width="50%" style="<?= !empty($product['Product']['free_with_your_order']) ? "border-right: solid #CCC 1px;" : "" ?>" valign="top">
	<?= $product['Product']['description'] ?>
</td>
<? } ?>
<? if(!empty($product['Product']['free_with_your_order'])) { ?>
<td valign="top">
	<?= $product['Product']['free_with_your_order'] ?>
</td>
<? } ?>
</tr>
</table>


