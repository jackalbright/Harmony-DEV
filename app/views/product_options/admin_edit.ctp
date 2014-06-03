<div>
	<form method="POST" action="/admin/product_options/edit/<?=$pid?>">
	<table border=1>
	<tr id="product_ids">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<? foreach($related_products as $rp) { ?>
		<th id="product_ids_<?= $rp['Product']['product_type_id'] ?>" class="product_sort_handle">
			<?= $rp['Product']['pricing_name'] ?>
		</th>
		<? } ?>
	</tr>
	<tbody id="product_options">
	<? for ($i = 0; $i < count($options)+2; $i++) { 
		$features_by_pid = !empty($this->data['ProductOptions'][$i]['ProductFeature']) ? Set::combine($this->data['ProductOptions'][$i]['ProductFeature'], '{n}.product_type_id', '{n}') : array();
		$id = !empty($this->data['ProductOptions'][$i]['ProductOption']['product_option_id']) ? $this->data['ProductOptions'][$i]['ProductOption']['product_option_id'] : null;
	?>
	<tr id="product_options_<?= $id ?>">
		<td>
			<? if(!empty($id)) { ?>
			<img class="sort_handle" src="/images/icons/up-down.png"/>
			<? } ?>
		</td>
		<td>
			<input type="hidden" name="data[ProductOptions][<?=$i?>][ProductOption][product_option_id]" value="<?= !empty($this->data['ProductOptions'][$i]['ProductOption']['product_option_id']) ? $this->data['ProductOptions'][$i]['ProductOption']['product_option_id'] : null?>"/>
			<input type="hidden" name="data[ProductOptions][<?=$i?>][ProductOption][product_type_id]" value="<?= $pid ?>"/>
			<input type="text" width="100%" name="data[ProductOptions][<?=$i?>][ProductOption][option_name]" value="<?= !empty($this->data['ProductOptions'][$i]['ProductOption']['option_name']) ? htmlspecialchars($this->data['ProductOptions'][$i]['ProductOption']['option_name']) : null?>"/>
			<br/>
			<textarea name="data[ProductOptions][<?=$i?>][ProductOption][option_description]"><?= !empty($this->data['ProductOptions'][$i]['ProductOption']['option_description']) ? $this->data['ProductOptions'][$i]['ProductOption']['option_description'] : null?></textarea>
		</td>
		</td>
		<? $j = 0; foreach($related_products as $rp) { $rprod = $rp['Product']['code']; $rpid = $rp['Product']['product_type_id']; 
			$feature = !empty($features_by_pid[$rpid]) ? $features_by_pid[$rpid] : null;
		?>
		<td>
			<input type="hidden" name="data[ProductOptions][<?=$i?>][ProductFeature][<?=$j?>][product_option_id]" value="<?= !empty($feature['product_option_id']) ? $feature['product_option_id'] : null; ?>"/>
			<input type="hidden" name="data[ProductOptions][<?=$i?>][ProductFeature][<?=$j?>][product_feature_id]" value="<?= !empty($feature['product_feature_id']) ? $feature['product_feature_id'] : null; ?>"/>

			<input type="hidden" name="data[ProductOptions][<?=$i?>][ProductFeature][<?=$j?>][product_type_id]" value="<?= $rpid ?>"/>
			<input type="checkbox" name="data[ProductOptions][<?=$i?>][ProductFeature][<?=$j?>][included]" value=1 <?= !empty($feature['included']) ? "checked='checked'" : "" ?> />
			<input type="text" name="data[ProductOptions][<?=$i?>][ProductFeature][<?=$j?>][text]" value="<?= !empty($feature['text']) ? htmlspecialchars($feature['text']) : null?>"/>
		</td>
		<? $j++; } ?>
	</tr>
	<? } ?>
	</tbody>
	</table>
	<input type="submit" name="submit" value="Update"/>
	</form>

	<script>
	function sortProducts()
	{
		new Ajax.Request("/admin/product_options/product_resort/<?=$pid?>", {asynchronous:true, evalScripts:true, parameters:Sortable.serialize('product_ids'), onSuccess: function() { window.location.href = window.location.href;} });


	}
	</script>

	<?
	echo $ajax->sortable("product_options", array('tag'=>'tr','url'=>"/admin/product_options/resort/$pid",'handle'=>'sort_handle'));
	echo $ajax->sortable("product_ids", array('tag'=>'th','handle'=>'product_sort_handle','onUpdate'=>"sortProducts"));
	?>
</div>
