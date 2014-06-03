
<? if(!empty($product_options)) { ?>

<div id="features" class="sections <?=$default_hide && empty($no_accordian) ?"hidden":""?>" style="">

	<div class="product_subsection">
	<div class="right"><a name="compare" class="top" href="#">Top</a></div>
	<table align="center">
	<tr><td>
		<div class="product_subsection_header"> <?= count($compare_products > 1) ? "Compare {$product['Product']['short_name']}" : "" ?> Styles</div>
	</td><tr>
	<tr><td>
	<table id="feature_comparison" cellspacing=0 align="center">
	<tr>
		<th style="text-align: left; width: 125px;">Style</th>
		<? foreach($product_options as $i => $popt) { 
			$desc = $popt['ProductOption']['option_description'];
		?>
		<th width="150">
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
		</th>
		<? } ?>
	</tr>
	<? $p = 0; foreach($compare_products as $cp) { $pid = $cp['product_type_id']; ?>
	<tr style="background-color: <?= $p % 2 == 0 ? "#FFF" : "#DEDEDE"; ?>;">
		<td class="pricing_name">
			<?= $cp['pricing_name'] ?>
		</td>
		<? foreach($product_options as $feats) { 
			$feat = null; foreach($feats['ProductFeature'] as $f) { if($f['product_type_id'] == $pid) { $feat = $f; } }
		?>
		<td style="padding: 5px; text-align: center; vertical-align: middle;">
			<? if(!empty($feat['included'])) { ?>
				<img src="/images/icons/check.png"/>
			<? } else if (!empty($feat['text'])) { ?>
				<?= $feat['text']; ?>
			<? } else { ?>
				&nbsp;
			<? } ?>
		</td>
		<? } ?>
	</tr>
	<? $p++; } ?>
	</table>
	</td></tr></table>

	</div>
</div>
<? } ?>
