<div>
	<?= $this->element("admin/products/nav"); ?>
	<h2><?= $product['Product']['name'] ?> Quotes (<?= sprintf("%01u", $product['Product']['quote_limit']) ?> character limit)</h2>


	<form method="POST" action="/admin/product_quotes/index/<?= $product['Product']['product_type_id'] ?>">

	<label>Find Quote:</label>
	<input type="text" name="data[keywords]" value="<?= !empty($this->data['keywords']) ? $this->data['keywords'] : "" ?>"/>
	<input type="submit" name="action" value="Search"/>

	</form>

	<hr/>

	<form method="POST" action="/admin/product_quotes/update/<?= $product['Product']['product_type_id'] ?>">

	<? $i = 0; if(!empty($this->data['keywords'])) { ?>
	<h4>Search Results:</h4>
	<? if(empty($quotes)) { ?>No quotes found.<? } ?>
	<table border=1 width="100%">
	<? foreach($quotes as $quote) { ?>
	<tr>
		<td>
			<input type="checkbox" name="data[quote_id][<?=$i++?>]" value="<?= $quote['Quote']['quote_id'] ?>"/>
		</td>
		<td>
			<?= $quote['Quote']['text'] ?>
			<? if(!empty($quote['Quote']['attribution'])) { ?>
			<div align="right" class="italic">
			- <?= $quote['Quote']['attribution'] ?>
			</div>
			<? } ?>
		</td>
	</tr>
	<? } ?>
	</table>
	<? } ?>

	<? if(!empty($product_quotes)) { ?>
	<h4>Existing Quotes:</h4>
	<table border=1 width="100%">
	<? foreach($product_quotes as $quote) { ?>
	<tr>
		<td>
			<input type="checkbox" name="data[quote_id][<?=$i++?>]" checked='checked' value="<?= $quote['Quote']['quote_id'] ?>"/>
		</td>
		<td>
			<?= $quote['Quote']['text'] ?>
			<? if(!empty($quote['Quote']['attribution'])) { ?>
			<div align="right" class="italic">
			- <?= $quote['Quote']['attribution'] ?>
			</div>
			<? } ?>
		</td>
	</tr>
	<? } ?>
	</table>
	<? } ?>

	<input type="submit" name="action" value="Update"/>

	</form>
</div>

