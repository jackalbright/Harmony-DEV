<? if(!empty($snippets['free_with_order_custom']) || !empty($build['Product']['free_with_your_order']) ) { ?>

<div style="font-weight: bold; color: #009900;">Free with your order</div>


<? if(!empty($snippets['free_with_order_custom'])) { ?>
<?= $snippets['free_with_order_custom']; ?>
<? } ?>

<? if(!empty($build['Product']['free_with_your_order'])) { ?>
	<?= $build['Product']['free_with_your_order'] ?>
<? } ?>

<? } ?>
