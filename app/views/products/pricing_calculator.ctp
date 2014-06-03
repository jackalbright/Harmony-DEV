<?= $ajax->form("pricing_calculator",'post', array('update'=>'pricing_calculator','url'=>array('action'=>'pricing_calculator',$prod))); ?>
<? 
$quantity = !empty($this->data['Product']['quantity']) ? $this->data['Product']['quantity'] : 1;
?>
<div>
<?=$this->element("shipfree"); ?>
<table width="100%">
<? if(count($related_products) > 1) { ?>
<tr>
	<td colspan=2>
		<label>Select a style</label>
		<div align="right">
		<?

		?>
		<select name="data[Product][prod]">
		<? foreach($related_products as $rp) { 
			$rpname = $rp['Product']['pricing_name'];
			$rpname = preg_replace("/<br.*/", "", $rpname);
		?>
			<option value="<?= $rp['Product']['product_type_id'] ?>"><?= $rpname ?></option>
		<? } ?>
		</select>
		</div>
	</td>
	<td valign="top" colspan=2>
	</td>
</tr>
<? } ?>
<tbody class="">
<tr>
	<td valign="top" colspan=1>
		<label>Quantity</label>
	</td>
	<td valign="top" colspan=1 align="right">
		<input type="text" name="data[Product][quantity]" value="<?= $quantity ?>" size="5"/>
		<br/>
		<input type="image" src="/images/buttons/small/Calculate-grey.gif"/>
	</td>
</tr>
<tr>
	<td valign="top" colspan=1>
		<label>Price each</label>
	</td>
	<td valign="top" colspan=1 align="right">
		<?= sprintf("$%.2f", $pricing['total']); ?>
	</td>
</tr>
<tr>
	<td valign="top" colspan=1 class="bold">
		<label>Total</label>
	</td>
	<td valign="top" colspan=1 align="right" class="bold">
		<?= sprintf("$%.2f", $pricing['total']*$quantity); ?>
		<br/>
		<br/>
	</td>
</tr>
<tbody style="padding-top: 10px;">
<tr>
	<td valign="top" colspan=1>
		<label>Ship to Zip</label>
	</td>
	<td valign="top" colspan=1 align="right">
		<input type="text" name="data[Product][zipCode]" value="<?= !empty($this->data['Product']['zipCode']) ? $this->data['Product']['zipCode'] : '' ?>" size="6"/>
	</td>
</tr>
<? if(!empty($shippingOptions)) { ?>
<tr>
	<td valign="top" colspan=2>
	<? foreach($shippingOptions as $so) { ?>
	<table width="100%">
		<?
			$old_shipcost = $so['shippingPricePoint']['cost'];
			$shipcost = $so[0]['cost'];
			$days = $so['shippingMethod']['dayMax'];
			$num2name = array('','One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten');
			if($days == 1)
			{
				$daysname = 'Overnight';
			}
			else if($days == 5)
			{
				$daysname = 'Standard';
			} else {
				$daysname = $num2name[$days]. ' Day';
			}
		?>
		<tr>
			<td style="color: #009900; font-weight: bold;"><?= $daysname ?> Shipping
			</td>
			<td align="right">
				<? if($shipcost <= 0) { ?>
					<span style="text-decoration: line-through;"><?= sprintf("$%.02f", $old_shipcost); ?></span>
					<span style="font-weight: bold; color: #FF0000;">FREE</span>
				<? } else { ?>
					<?= sprintf("$%.02f", $shipcost); ?>
				<? } ?>
			</td>
	</table>
	<? } ?>
	</td>
</tr>
<? } ?>
</tbody>

</table>
</div>
</form>
