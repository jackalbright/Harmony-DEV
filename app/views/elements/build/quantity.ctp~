
<h4>Select a Quantity:</h4>
<div>
	<!--<? echo $ajax->Javascript->event('window','load',
	$ajax->remoteFunction( array('url'=>"/products/calculator/".$product['Product']['code']."/build", 'update'=>"pricing_calculator_holder")));
	?>
	<div id="pricing_calculator_holder"></div>
	-->
	<b>Quantity:</b> 
	<input type="text" id="quantity" name="quantity" value="<?= $quantity ?>" size="5" onChange="return checkMinimum(this.value, <?php echo $minimum; ?>);"/>
	<br/>
	Minimum: <?= $minimum ?>

	<br/>
	<br/>
	<br/>
	
					<div class="">
						<? if($current_step == 'cart') { ?>
							<input type="image" name="action" src="/images/buttons/addtocart.gif"/>
						<? } else { ?>
							<input type="image" name="action" src="/images/buttons/Next.gif"/>
						<? } ?>
					</div>
					Click on the "Next" button to choose your options.
					<div class="clear"></div>

	<hr/>

	<h3>Pricing Chart:</h3>
	<?= $this->element("products/pricing_grid"); ?>
</div>
