<div style="font-size: 11px;">
		<br/>
		<div class="bold"> 888.293.1109 </div>
		<br/>
		<a rel="shadowbox;width=500;height=700" href="/products/wholesale_pricing?prod=<?= $prod ?>">View wholesale pricing</a><br/>
					<? if(empty($product['Product']['is_stock_item'])) { ?>
					<a class="hidden" href="/pages/ordering">How to order</a>
					<? } ?>
					<a href="javascript:void(0);" onClick="mail(this, '<?= base64_encode("info@harmonydesigns.com?subject=Request Price Quote"); ?>');">Request price quote</a><br/>
					<? if(empty($product['Product']['is_stock_item'])) { ?>
					<a href="javascript:void(0);" onClick="mail(this, '<?= base64_encode("info@harmonydesigns.com?subject=Random Sample"); ?>');">Request random sample</a><br/>
					<? } ?>
					<!--
					<a href="#clientlist">A few of our customers...</a><br/>
					<a href="#comments">Customer comments</a><br/>
					-->
					<br/>
</div>
