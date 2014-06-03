<?
?>
<table width="100%">
<tr>
<td valign="top">
<div id="shipping_calculator_table" style="border: solid #AAA 1px;">
<?= $form->create("Product",array('url'=>$_SERVER['REQUEST_URI'],'onSubmit'=>'return verifyRequiredFields(this);')); ?>
	<table style="width: 100%;" cellpadding=1><tr>
	<td>
		<label for="ProductZipCode">Zip Code</label>
		<?= $form->text('zipCode',array('size'=>8,'class'=>'required')); ?>
	</td>
	<td>
		<?= $form->input('isoCode',array('label'=>'Country','options'=>$countries,'default'=>'US','style'=>'width: 150px;')); ?>
	</td>
	<td>
		<? if(!empty($location)) { ?>
			<label>To:</label><?= $location['ZipCode']['city']; ?>, <?= $location['ZipCode']['state']; ?>
		<? } ?>
		&nbsp;
	</td>
	</tr>
</table>
<br/>
<table width="100%">
	<tr>
	<th align="left" colspan=2>
		<label>Product</label>
	</th>
	<th align="right">
		<label style="padding: 0px !important;">Quantity</label>
	</th>
	</tr>

	<? $x = 0; if(!empty($products)) { ?>
	<? foreach($products as $i => $product) { $code = $product['code']; ?>
	<tr>
		<td colspan=2>
			<?= $form->select("Products.$i.code",array_merge(array(''=>'[Choose a product]'), $all_products_map),$code,array(),false); ?>
			
			<? 
			#("Products.$i.code",$all_products_map,$code,array(),true); 
			?>
		</td>
		<td align="right">
			<?= $form->text("Products.$i.quantity", array('value'=>$quantities[$i],'size'=>5)); ?>
			<? if(!empty($params['admin'])) { ?>
			<?= sprintf("%.02f lb ea.", $hd->gm2lb($product['weight'])); ?>
			x <?= $quantities[$i] ?> = 
			<?= sprintf("%.02f lb", $hd->gm2lb($quantities[$i] * $product['weight'])); ?>
			<? } ?>
		</td>
	</tr>

	<? $x++; } ?>
	<? } ?>

	<? if(empty($products)) { echo $this->element("products/shipping_calculator_item", array('i'=>$x,'required'=>true)); } ?>

	<tr id="row_calculate">
		<td align="left" colspan=2>
			<a href="Javascript:void(0)" onClick="addRow($('shipping_calculator_table').getElementsByTagName('tr').length-3);">+ Add more products</a>
			<div style="font-size: 10px; margin-top: 0.5em;">
			<span class='alert'>* </span>Required fields
			</div>
		</td>
		<td align="right">
			<input type="image" valign="middle" src="/images/webButtons2014/grey/small/calculate.png" name="action" value="Calculate"/>
		</td>
	</tr>
	</table>
	</form>

	<script>
	function addRow(i) { new Ajax.Updater('row_calculate','/products/shipping_calculator_item/'+i, {asynchronous:true, evalScripts:true, insertion:Insertion.Before, requestHeaders:['X-Update', 'row_calculate']}) } 
	//addRow();
	</script>



	<? if(!empty($params['admin']) && !empty($shippingOptions)) { ?>
	<table style="width: 100%;">
	<tr>
		<th>Total Package Weight:</th>
		<td>
			<?= sprintf("%.02f lb", $shippingWeight); ?>
		</td>
	</tr>
	<tr>
		<th>Handling Charge:</th>
		<td>
			<?= sprintf("$%.02f", $handlingCharge); ?>
		</td>
	</tr>
	</table>
	<? } ?>

	<? if(!empty($shippingOptions)) { ?>
	<!--
	Ships by <?= date("D, M jS", $ships_by_time); ?>
		<div class="clear"></div>
	-->
	<br/>
	<br/>
	<table class="results" cellpadding=5 cellspacing=0 style="border: solid #AAA 1px; width: 100%;">
		<tr style="">
			<th align="left">
			Ship Via
			</th>
			<th>
			Product Cost
			</th>
			<th>
			Shipping 
			</th>
			<th>
			Rush Charge 
			</th>
			<? if(false && empty($params['admin'])) { ?>
			<th>
			Base Cost
			</th>
			<th>
			OLD BASE COST
			</th>
			<? } ?>
			<th>Grand Total</th>
		</tr>
		<? $i = 0; foreach($shippingOptions as $shippingOption) { ?>
		<tr class="<?= $i++ % 2 == 0 ? "even" : "odd" ?>">
			<td>
				<?
					$receive_date = $ships_by_time + $shippingOption['shippingMethod']['dayMax']*24*60*60;
					while(in_array(date("D", $receive_date), array('Sun','Sat')))
					{
						$receive_date += 24*60*60;
					}
					$dayMax = $days = $shippingOption['shippingMethod']['dayMax'];
					$dayMin = $shippingOption['shippingMethod']['dayMin'];

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
				<div style="font-weight: bold; color: #333333;">
					<!--<?= date("D, M jS", $receive_date); ?> -->
					<?= $daysname ?> <? if($daysname == 'Standard') { ?><br/>(<?= $dayMin ?> - <?= $dayMax ?> days) <? } ?>
					<? if(!empty($params['admin'])) { ?>
					(<?= $shippingOption['shippingMethod']['name']; ?>)
					<? } ?>
				</div>
			</td>
			<td>
				<?= sprintf("$%.02f", $subtotal); ?>
			</td>
			<td>
				<? if($shippingOption[0]['cost'] > 0) { ?>
					<?= sprintf("$%.02f", $shippingOption[0]['cost']); ?>
				<? } else { ?>
					<span style="text-decoration: line-through; "><?= sprintf("$%.02f", $shippingOption[0]['original_cost']) ?></span>
					<span style="font-weight: bold; color: red; ">FREE</span>

				<? } ?>
			</td>
			<td>
				<? if(empty($rush_cost)) { $rush_cost = 0; } ?>
				<?= !empty($rush_cost) ? sprintf("$%.02f", $rush_cost) : "N/A"; ?>
			</td>
			<? if(false && !empty($params['admin'])) { ?>
			<td>
				<?= sprintf("$%.02f", $shippingOption['shippingPricePoint']['cost']); ?>
			</td>
			<td>
				<?= sprintf("$%.02f", $shippingOption['shippingPricePoint']['cost_old']); ?>
			</td>
			<? } ?>
			<td>
				<?= sprintf("$%.02f", $rush_cost + $subtotal + $shippingOption[0]['cost']); ?>
			</td>
		</tr>
		<? } ?>

		<? foreach($rush_dates as $rush_date => $rush_cost) { ?>
		<tr class="<?= $i++ % 2 == 0 ? "even" : "odd" ?>">
			<td>
				<?
					$shippingOption = $shippingOptionsByID[$rush_shipping_method_id];
					$receive_date = strtotime($rush_date);
					while(in_array(date("D", $receive_date), array('Sun','Sat')))
					{
						$receive_date += 24*60*60;
					}

					$num2name = array('One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten');
					if($days == 5)
					{
						$daysname = 'Standard';
					} else {
						$daysname = $num2name[$days]. ' Day';
					}
				?>
				<div style="font-weight: bold; color: #333333;"><nobr style="color: black;">RUSH PROCESSING</nobr><br/><nobr>Receive by <?= date("D, M jS", $receive_date); ?></nobr></div>
				<!--(<?= $shippingOption['shippingMethod']['name']; ?>)-->
			</td>
			<td>
				<?= sprintf("$%.02f", $subtotal); ?>
			</td>
			<td>
				<? if($shippingOption[0]['cost'] > 0) { ?>
					<?= sprintf("$%.02f", $shippingOption[0]['cost']); ?>
				<? } else { ?>
					<span style="text-decoration: line-through; "><?= sprintf("$%.02f", $shippingOption[0]['original_cost']) ?></span>
					<span style="font-weight: bold; color: red; ">FREE</span>

				<? } ?>
			</td>
			<td>
				<? if(empty($rush_cost)) { $rush_cost = 0; } ?>
				<?= !empty($rush_cost) ? sprintf("$%.02f", $rush_cost) : "N/A"; ?>
			</td>
			<? if(false && !empty($params['admin'])) { ?>
			<td>
				<?= sprintf("$%.02f", $shippingOption['shippingPricePoint']['cost']); ?>
			</td>
			<td>
				<?= sprintf("$%.02f", $shippingOption['shippingPricePoint']['cost_old']); ?>
			</td>
			<? } ?>
			<td>
				<?= sprintf("$%.02f", $rush_cost + $subtotal + $shippingOption[0]['cost']); ?>
			</td>
		</tr>
		<? } ?>
	</table>
	<? } ?>

	<div style="color: #000; text-align: center;" class="">
		Please allow 1 - 5 business days for manufacture of your custom items.
	</div>

	<div class='shippingDisclaimer'>
        <p>Other charges may apply for added features or upgrades including setup for double-sided printing and printing on the back of bookmarks and rulers.</p>
    </div>
	<div style="position: relative; text-align: center;">
	<?=$this->element("shipfree"); ?>
	</div>
</div>

</td>
<td valign="top">
	<div>
		<img src="/images/Shipping_map.jpg"/>
	</div>
</td>
</tr>
</table>
<style>
.results
{
}
.results tr th 
{
	border-bottom: solid #AAA 1px;
}
</style>
