<div>

<? if(empty($savedItems)) { ?>
<b>You have no saved items. Create saved items by clicking on 'Save For Later' as you customize your product.</b>
<? } else { ?>
To view, modify, or add to cart, click on the link below.
<table width="75%" cellspacing=0>
	<? $i = 0; foreach($savedItems as $item) { ?>
	<tr style="background-color: <?= $i++ % 2 ? "#FFF" : "#EEE"; ?>;">
		<td valign="top" width="100">
			<?= date("m/d/Y", strtotime($item['SavedItem']['created'])); ?>
		</td>
		<td valign="top" width="125">
			<a href="/saved_items/view/<?= $item['SavedItem']['saved_item_id'] ?>">
				<? if(!empty($item['SavedItem']['new_build'])) { ?>
					<img src="/designs/png/width:100/saved_item_id:<?= $item['SavedItem']['saved_item_id'] ?>.png"/>
				<? } else { ?>
					<img src="/product_image/saved_view/<?= $item['SavedItem']['saved_item_id'] ?>/-100x100.png"/>
				<? } ?>
			</a>
		</td>
		<td valign="top">
			
			<a href="/saved_items/view/<?= $item['SavedItem']['saved_item_id'] ?>">
			<?= $item['name'] ?>
			</a>
		</td>
		<td valign="top">
			<a href="/saved_items/delete/<?= $item['SavedItem']['saved_item_id'] ?>" onClick="return confirm('Are you sure you want to remove this item?');">Remove</a>
		</td>
	</tr>
	<? } ?>
</table>
<? } ?>
</div>
