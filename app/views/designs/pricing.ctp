<div class='widget'>
<h3><?= Inflector::singularize($pricing['Product']['name']) ?> Pricing</h3>
<? $design = $this->Session->read("Design"); ?>
<? $sides = $this->Session->read("Design.Design.sides"); ?>
<!--<div>-->
<div id="estimate_container">
<?php
  $quantity = !empty($pricing['quantity']) ? $pricing['quantity'] : null;#$pricing['Product']['minimum'];
  #echo "Q=$quantity";
?>

		<div class="preview_option_quantity preview_option_value">
			<table cellpadding=2 cellspacing=0 width="100%" border=0>
			<tr>
			<td class='leftPricingColumn'>
			<strong>Quantity:</strong>
			<br/>
			(Min: <?php echo $pricing["Product"]['minimum'] ?>)
			</td>
			<td class='rightPricingColumn'>
					<input style="border: solid #B82A2A 1px; background-color: #FFF; padding: 5px; text-align: right; width: 3em;" id="quantity" type="text" name="data[Design][quantity]" value="<?= $quantity ?>" size="4"/>
					
			</td>
			
			<!-- <td colspan=2 align='right' class='bold' valign='top'>
			<div id="AddToCart" class='cta' align="right">
						<? if(!empty($design['Design']['cart_item_id'])) { ?>
							<?= $this->Form->submit("/images/webButtons2014/orange/large/updateCart.png",array('value'=>'cart','onClick'=>"j.loading(); return j('#DesignForm').assertMinimum();",'div'=>false)); ?>
						<? } else { ?>
							<?= $this->Form->submit("/images/webButtons2014/orange/large/addToCart.png",array('value'=>'cart','onClick'=>"j.loading(); return j('#DesignForm').assertMinimum();",'div'=>false)); ?>
						<? } ?>
					<div class='clear'></div>
					<br/>

				</div>
				</td>-->
				
			</tr>

			<? if(empty($quantity)) { ?>
			<tr>
				<td  class='leftPricingColumn'>
					<i>Type your quantity to calculate pricing</i>
				</td>
			</tr>
			<? } ?>
			<? if(!empty($quantity)) { ?>
			<tr>
				<td  class='leftPricingColumn'>
					<b>Unit Price</b>
				</td>
				<td   class='rightPricingColumn'>
					<?php echo sprintf("$%.02f", $pricing['quantity_price_list']['base']); ?> 
				</td>
			</tr>
			<tr>
			<td colspan=2>
			
			</td>
			</tr>
			
			<? if(!empty($pricing['quantity_price_list'])) { ?>
				<?
				foreach($pricing['quantity_price_list'] as $option => $option_cost)
				{
					# option_cost may be calculated based upon per item....

					if ($option == 'base' || $option == 'total' || $option == 'setup') { continue; }
					$option_name = $option;
					if (!empty($options))
					{
						foreach($options as $opt)
						{
							if ($opt['Part']['part_code'] == $option && !empty($opt['Part']['part_name']))
							{
								$option_name = $opt['Part']['part_name'];
							}
							
						}
					}
					if($option == 'stamp') { $option_name = (in_array($pricing['Product']['code'], array('ST','P')) ? 'Surcharge <span style="font-size: 10px;">(High Value Stamp)</span>' : 'Surcharge <span style="font-size: 10px;">(Genuine Stamp)</span>'); }
				?>
				<tr>
					<td  class='leftPricingColumn'> 
						<b>
						<? if ($option_cost < 0) { ?>
						No 
						<? } ?>
						<? if(false && in_array($option, $option_list)) { ?>
						<?php echo ucwords($option_name) ?> (optional) 
						<? } else { ?>
						<?php echo ucwords($option_name) ?>
						<? } ?>
						</b>
						<nobr>
						(<?php echo ($option_cost < 0) ? sprintf("-$%.02f", -$option_cost) : sprintf("+$%.02f", $option_cost); ?> ea)
						</nobr>
					</td>
					<? if ($option_cost < 0) { ?>
					<td valign='top'>
						-
					</td>
					<td align="right">
						<?= sprintf("$%.02f", -$option_cost*$quantity); ?>
					</td>
					<? } else { ?>
					<td valign='top'>
						+
					</td>
					<td align="right">
						<?= sprintf("$%.02f", $option_cost*$pricing['quantity']); ?>
					</td>
					<? } ?>
				</tr>
				<? } ?>
			<? } ?>

			<?
			$setup = !empty($pricing['quantity_price_list']['setup']) ? $pricing['quantity_price_list']['setup'] : 0;
			?>

			<? if(!empty($setup)) { ?>
			<tr>
				<td  class='leftPricingColumn'>
					<b>Setup Charge</b>
				</td>
				<td valign='top'>
					+
				</td>
				<td valign="middle" align="right">
					<?= sprintf("$%.02f", $setup); ?>
					<input id="setupCharge" type="hidden" name="data[Design][setupPrice]" value="<?= $setup ?>"/>
				</td>
			</tr>
			<? } ?>

			<?
			?>
			</table>
		<!--</div>-->  <!-- preview_option_quantity -->
		<hr class='pricing_divider'>

		<!--<div class='preview_option_value'>-->
			<table width='100%' border=0>
			<tr >
				<td  class="leftPricingColumn" valign='top'>
				<?php 
				
				$discounted = ($pricing['retail_price_list']['total'] > $pricing['quantity_price_list']['total']);
				$subtotal = $pricing['quantity'] * $pricing['quantity_price_list']['total'] + $setup;
				//echo "rpl : " . $pricing['retail_price_list']['total'] .  "<br>";
				//echo "qpl: ". $pricing['quantity_price_list']['total']	 ;
				
				if (empty($is_wholesale) && $discounted) { ?>
				     List Price:
				<?php
				}else{
				?>
				<div id="priceLabel">
				     Subtotal:
				</div>
				<?php
				 }
				 ?>
				</td>
				
				<td class="rightPricingColumn" >
				<?php 
				if (empty($is_wholesale) && $discounted) { ?>
				
					<div id="estimate_retail" class="estimate_retail" >
					<?php
					   echo sprintf("$%.02f", $retail = $pricing['quantity'] * $pricing['retail_price_list']['total'] + $setup);
					 ?>
					</div>
					
				<? }else{ ?>
					<div id="estimate_total" >
					<?php echo sprintf("$%.02f", $estimate = (!empty($pricing['proof_only']) ? $proof_cost : $pricing['quantity'] * $pricing['quantity_price_list']['total'] + $setup)); 
					?>
					</div>
					<?php
					}
					?>
</td>
</tr>

				<?php
				if(empty($is_wholesale) && $discounted){
				?>
					<tr>
					<td class="leftPricingColumn">
					<div id="priceLabel">
					Price
					</div>
					</td>
					<td class="rightPricingColumn">
						<div id="estimate_total" >
					<?php 
						echo sprintf("$%.02f", $estimate = (!empty($pricing['proof_only']) ? $proof_cost : $pricing['quantity'] * $pricing['quantity_price_list']['total'] + $setup)); 
					?>
					</div>
					</td>
					</tr>
				<?php
				}
				
				 if (empty($is_wholesale) && $discounted) { ?>
				 	<tr>
					<td class="leftPricingColumn">
					You Save
					</td>
					<td class="rightPricingColumn">
					<div id="estimate_retail_discount">
					<?php 
						//echo "e: $estimate r: $retail<br>";
						echo sprintf("$%01.2f <br>(%u%%)",($retail - $estimate), 100-($estimate/$retail*100)); ?>
					</div>
					</td>
					</tr>
				<? } ?>
			
			<?php
			 if(!empty($pricing['Product']['setup_charge'])) { 
			 ?>
			<tr>
				<td class="leftPricingColumn">
				Setup charge
				</td>
				<td class="rightPricingColumn">
					<?php echo sprintf("$%.02f", $pricing['Product']['setup_charge']); ?>
				</td>
			</tr>
			<?php
			 }
			if(!empty($pricing['Product']['setup_charge'])) { 
			?>
			<tr>
				<td class="leftPricingColumn">
				Total
				</td>
				<td class="rightPricingColumn">
					<b ><?= sprintf("$%.02f", (!empty($pricing['proof_only']) ? $proof_cost : $pricing['quantity'] * $pricing['quantity_price_list']['total'])+$pricing['Product']['setup_charge'] ); ?></b>
				</td>
			</tr>

			<?php 
			} 
			?>

			<!--
			<tr>
				<td class="leftPricingColumn">
					Zip Code
				</td>
				<td class="rightPricingColumn">
					<?= $this->Form->input("zip_code", array('name'=>'data[zip_code]','size'=>7,'label'=>false,'align'=>'right','div'=>false)); ?>
				</td>
				<td colspan=2 align='right'>
				</td>
			</tr>
			-->
			<? } ?>
			
			<!--<tr>
			<td colspan=4>
			Save more when you order 100+
			</td>
			</tr>-->
		</table>


		
		</div>
		
	<? if(false && !empty($next_tier)) { ?>
	<div class="green" style="font-size: 10px;">
		Save more when you order <?= $next_tier ?> or more.
	</div>
	<? } ?>

<!--estimate container
</div>-->
<?php 
		if(!empty($quantity)) { 
			echo "<div class='preview_option_text'>\n";
			echo "<p>You'll be able to calculate shipping costs on the next page.</p>";
			
			echo "<p class='emphasis'>Save more when you order more!</p>";
			echo "</div>\n";
			
		} 
		?>
		
<br style="clear:both">	
<!-- S A V E     F O R     L A T E R     B U T T O N -->
  <div id='estimate_container_left'>
	  <?php
	  // we only want to show Save For Later on the DEV  site for now, until it works on LIVE
	  // since DEV site's domain is hdtest.com, this code will only show the button on DEV
	  $pos = strpos($_SERVER['HTTP_HOST'], 'harmonydesign');
	  if($pos === false){
	  echo $this->Form->submit("/images/buttons/small/Save-For-Later-teal.gif",array('id'=>'SaveForLater','onClick'=>"j.loading();",'name'=>'data[form_submit]','value'=>'save','div'=>false)); 
	  }
	  ?>
  
  </div>


<!--  A D D     T O      C A R T     B U T T O N-->
 <!--<div id="AddToCart" class='cta ' align="right">-->
 <div id="estimate_container_right" class='cta ' align="right">
 
						<? if(!empty($design['Design']['cart_item_id'])) { ?>
							<?= $this->Form->submit("/images/webButtons2014/orange/large/updateCart.png",array('value'=>'cart','onClick'=>"j.loading(); return j('#DesignForm').assertMinimum();",'div'=>false)); ?>
						<? } else { ?>
							<?= $this->Form->submit("/images/webButtons2014/orange/large/addToCart.png",array('value'=>'cart','onClick'=>"j.loading(); return j('#DesignForm').assertMinimum();",'div'=>false)); ?>
						<? } ?>
<br style="clear:both">

</div><!--estimate_container_right-->



	</div><!-- estimate_container -->
</div><!-- widget -->


<script>
j('#quantity').changeup(function() {
	if(j('#DesignForm').assertMinimum())
	{
		j.update_pricing(false, true);
	}
}, 1500);

j('.update_button').bind('click', function() { // get updated totals from qty
	if(j('#DesignForm').assertMinimum())
	{
		j.update_pricing(false, true);
		//j.update_pricing();
	}
});

j('#DesignForm :input').change(function() {
	j('#DesignForm').addClass('dirty');
});

j('#DesignForm input[type=image]').click(function() {
	j("input[type=image]", j(this).parents("form")).removeAttr('clicked');
	j(this).attr('clicked',true);
	j('#DesignForm').removeClass('dirty'); // ok to continue.
});
j('#DesignForm').submit(function() {
	j(this).data('submitted');
	var value = j('input[type=image][clicked=true]').val();

	j(this).attr('action', (value == 'save' ? "/designs/save_later" : "/designs/cart"));
});
</script>



