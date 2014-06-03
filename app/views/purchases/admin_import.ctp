<div>
	<?= $form->create("Purchase",array('type'=>'file','url'=>array('action'=>'import'))); ?>
	<?= $form->input('file',array('type'=>'file','label'=>'Upload CSV')); ?>
	<?= $form->submit("Upload"); ?>

	<style>
	tbody.ignore
	{
		background-color: red;
	}
	tbody.ignore *
	{
		text-decoration: line-through;
	}
	tbody.ignore .addresses
	{
		display: none;
	}

	</style>

	<? if(!empty($purchases)) { ?>
	<hr/>
	<b>Review and fix records as necessary</b>
	<table border=0 cellspacing=0>
		<? $i = 0; foreach($purchases as $p) { $purchase = $p['Purchase']; $customer = $p['Customer']; $orders = $p['OrderItem']; ?>
		<tbody id="myob_<?= $purchase['invoice_id'] ?>" style="background-color: <?= $i % 2 == 0 ? "#CCC" : "#FFF"; ?>; ">
		<tr>
			<td>
				<input type="checkbox" name="MYOBPurchase.<?= $i ?>.ignore" value="1" onClick="$('myob_<?= $purchase['invoice_id']?>').toggleClassName('ignore');"/> Ignore
			</td>
			<td>
				<label>MYOB Invoice #</label>
				<?= $form->text("MYOBPurchase.$i.invoice_id", array('size'=>10, 'value'=>$purchase['invoice_id'])); ?>
				<?= $form->text("MYOBPurchase.$i.Customer_ID", array('size'=>6, 'value'=>$customer['customer_id'])); ?>
				<?= $form->input("MYOBPurchase.$i.customer_po", array('value'=>$purchase['customer_po'])); ?>
				<?= $form->input("MYOBPurchase.$i.Order_Date", array('value'=>$purchase['Order_Date'])); ?>
				<?= $form->input("MYOBPurchase.$i.Charge_Amount", array('value'=>$purchase['Charge_Amount'])); ?>
			</td>
			<td colspan=2>
				<div> <? $order['line'] ?> </div>
				<b><?= $customer['Company'] ?> <?= $customer['eMail_Address'] ?></b>
				<table>
				<? $j = 0; foreach($orders as $order) { ?>
				<tr>
					<td>
						<?= $form->input("OrderItem.$i.$j.product_type_id", array('options'=>$products,'value'=>$order['product_type_id'],'empty'=>'CHOOSE A PRODUCT')); ?>
					</td>
					<td>
						<?= $form->input("OrderItem.$i.$j.item_code", array('value'=>$order['item_code'])); ?>
					</td>
				</tr>
				<tr>
					<td>
						<?= $form->input("OrderItem.$i.$j.Quantity", array('value'=>$order['Quantity'])); ?>
						<?= $form->input("OrderItem.$i.$j.Price", array('value'=>$order['Price'])); ?>
						<?= $form->input("OrderItem.$i.$j.reproduction", array('type'=>'checkbox','value'=>'Yes','checked'=>($order['reproduction'] == 'Yes'))); ?>
					</td>
					<td>
						<?= $form->input("OrderItem.$i.$j.description", array('value'=>$order['description'],'class'=>'no_editor')); ?>
					</td>
				</tr>
				<? $j++; } ?>
				</table>
			</td>
		</tr>
		</tbody>
		<? $i++; } ?>
	</table>
	<?= $form->submit("Save"); ?>
	<a href="<?= $url ?>">Start Over</a>
	<? } ?>

	<?= $form->end(); ?>
</div>
