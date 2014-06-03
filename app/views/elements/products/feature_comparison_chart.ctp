<?  $default_hide = false;#(count($compare_products) > 1); ?>
<? if(!empty($product_options)) { ?>
<div>
	<? if(empty($no_accordian)) { ?>
	<div class='accordian_header'>
	<table width="100%" cellpadding=0 cellspacing=0>
	<tr>
		<td align="left">
			<a href="Javascript:void(0);" onClick="accordianClick('features','sections'); track('products','features',{prod: '<?= $prod ?>'});">
				<img src="/images/icons/white_arrow_down.gif" id="features_arrow_show" align="bottom" class="<?=$default_hide?"hidden":""?>"/>
				<img src="/images/icons/white_arrow_right.gif" id="features_arrow_hide" align="top" class="<?=$default_hide?"":"hidden"?>"/>
				<?= !empty($product['Product']['short_name']) ? $product['Product']['short_name'] : $product['Product']['name'] ?> Features
			</a>
		</td>

		<? if(count($product_options) > 1) { ?>
		<td align="right">
			<a href="Javascript:void(0);" onClick="accordianClick('features','sections'); track('products','features',{prod: '<?= $prod ?>'}); ">Compare</a>
			</a>
		</td>
		<? } ?>
	</tr>
	</table>
	</div>
	<? } ?>
<div class="">
<div id="features" class="sections <?=$default_hide && empty($no_accordian) ?"hidden":""?>" OLDstyle="margin: 0 auto; width: 600px;">
	<table id="feature_comparison" cellspacing=0>
	<tr>
		<th style="text-align: left; width: 200px; color: #009900; background-color: #DDD;"><?= $product['Product']['short_name'] ?> Options</th>
		<? foreach($compare_products as $cp) { ?>
		<th class="pricing_name" style="width: 90px;">
			<?= $cp['pricing_name'] ?>
		</th>
		<? } ?>
	</tr>
	<? foreach($product_options as $i => $popt) { 
		$features_by_pid = Set::combine($popt['ProductFeature'], '{n}.product_type_id', '{n}');
		$desc = $popt['ProductOption']['option_description'];
	?>
	<tr>
		<td class="option" style="width: 200px; background-color: #DDD;">
			<?if(!empty($desc) && preg_match("/^(http|\/|@)/", strip_tags($desc))) { ?>
			<a rel='shadowbox;width=500;height=400' href='<?= strip_tags($desc) ?>'>
				<?= $popt['ProductOption']['option_name'] ?>
			</a>
			<? } else if (!empty($desc)) { ?>
			<a rel="shadowbox;weight=500;height=400" href="#optiondesc_<?= $i?>"><?= $popt['ProductOption']['option_name'] ?></a>
				<div id="optiondesc_<?=$i?>" class="hidden">
					<div style="padding: 20px;">
						<h3><?= $popt['ProductOption']['option_name'] ?></h3> 
						<br/>
						<?= $desc ?>
					</div>
				</div>
			<? } else { ?>
				<?= $popt['ProductOption']['option_name'] ?>
			<? } ?>
		</td>
		<? foreach($compare_products as $cp) { $pid = $cp['product_type_id']; $feat = !empty($features_by_pid[$pid]) ? $features_by_pid[$pid] : null; ?>
		<td style="padding: 5px; text-align: center; vertical-align: middle;">
			<? if (!empty($feat['text'])) { ?>
				<?= $feat['text']; ?>
			<? } else if(!empty($feat['included'])) { ?>
				<img src="/images/icons/small/check_cream.png"/>
			<? } else { ?>
				&nbsp;
			<? } ?>
		</td>
		<? } ?>
	</tr>
	<? } ?>
	</table>
</div>
</div>
</div>
<? } ?>
