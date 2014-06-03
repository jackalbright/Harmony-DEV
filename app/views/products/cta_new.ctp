
<? if(empty($product['Product']['is_stock_item'])) { ?>
<div align="left" style="margin: 5px; border: solid #AAA 1px; background-color: white;">
	<h6 style="background-color: #CCC; padding: 5px; font-weight: bold;">Build <?= Inflector::pluralize($product['Product']['short_name']) ?></h6>
	<div align="center" class="padded">

	<p align="left">
		Upload your art.
		Personalize it.
		See it and
		order in 10 minutes or less.
	</p>
	<div class="bold">
		Minimum: <?= $product['Product']['minimum'] ?>
	</div>
	<!--
	<p>Upload your art, personalize<br/>and order online in<br/> 10 minutes or less</p>
	-->

	<a href="/gallery?prod=<?= $product['Product']['code'] ?>"><img src="/images/buttons/Order-Online.gif"/></a>
	<br/>
	<br/>
	<div class="bold">
		Or order by phone:<br/>
		888.293.1109
	</div>
	</div>
</div>

<div align="left" style="margin: 5px; border: solid #AAA 1px; background-color: white;">
	<h6 style="background-color: #CCC; padding: 5px; font-weight: bold;">Learn more</h6>
	<div style="padding: 5px;">
		<div style="line-height: 150%;">
			<div> 
				<div class="right"><a title="Calculate pricing, shipping & production" rel="shadowbox;type=html;width=700;height=500" href="/products/calculator/<?= $prod ?>"><img src="/images/icons/calculator.png"/></a> </div>
				<a rel="shadowbox;type=html;width=700;height=500" href="/products/calculator/<?= $prod ?>">Calculate pricing/shipping &amp; production time</a>
				<div class="clear"></div>
			</div>
			<div> <a rel="shadowbox;type=html;width=525;height=600" href="/sample_requests/add/<?= $prod ?>">Request a random sample</a></div>
			<div> <a rel="shadowbox;type=html;width=500;height=600" href="/quote_requests/add/<?= $prod ?>">Request price quote</a></div>
			<? if(preg_match("/custom/", $product['Product']['image_type'])) { ?>
			<div> <a href="mailto:info@harmonydesigns.com?subject=Request a template">Request a template</a></div>
			<? } ?>
			<div> Call now for a free consultation:<br/>888.293.1109</div>
		</div>
	</div>
</div>

<div align="left" style="margin: 5px; border: solid #AAA 1px; background-color: white;">
	<h6 style="background-color: #CCC; padding: 5px; font-weight: bold;">In a hurry?</h6>
	<div style="padding: 5px;">
	<p>Rush service is our specialty.</p>
	<p>Specify 'Rush Processing' at checkout, or contact us for more info:</p>
	<div>
		888.293.1109<br/>
		<a href="mailto:info@harmonydesigns.com?subject=Rush Service">info@harmonydesigns.com</a>
	</div>
	</div>
</div>

<? } else { ?>
<div style="border: solid #AAA 1px; background-color: white; width: 225px;">
	<h6 align="left" style="background-color: #CCC; padding: 5px; font-weight: bold;">Order <?= Inflector::pluralize($product['Product']['short_name']) ?></h6>
	<?= $this->element("products/stock_calc_container",array('p'=>$product['Product'])); ?>
</div>
<br/>
<?= $this->element("build/pricing_chart_small",array('price_list'=>$price_lists[$product['Product']['code']])); ?>
<? } ?>
