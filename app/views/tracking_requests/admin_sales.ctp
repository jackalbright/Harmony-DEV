<?= $this->element("admin/tracking_requests/header"); ?>

<select onChange="load_chart(this.value)">
	<option value="1">1 week</option>
	<option value="4">1 month</option>
	<option value="13">3 months</option>
	<option value="26">6 months</option>
	<option value="52" selected='selected'>1 year</option>
	<option value="104">2 years</option>
	<option value="156">3 years</option>
	<option value="208">4 years</option>
	<option value="260">5 years</option>
	<option value="520">10 years</option>
	<option value="780">15 years</option>
</select>

<script type="text/javascript">
function load_chart(weeks)
{
	if(!weeks) { weeks = 52; }
	swfobject.embedSWF("/open-flash-chart.swf", "my_chart", "100%", "400", "9.0.0","expressInstall.swf",{"data-file":"/admin/tracking_requests/chart_sales/"+weeks});
}

load_chart(52);

</script>

</div>


<?= $ajax->link("Add update comment", array('controller'=>'update_comments','action'=>'add'),array('update'=>'comments')); ?>
<div align="left" id="comments" style="width: 400px;">
</div>
<div id="my_chart">Loading...</div>

<div class="trackingRequests index">
<h2><?php __('Web Site Sales');?> <?= date("m/d/y", strtotime($date_start)); ?> - <?= date("m/d/y", strtotime($date_end)); ?></h2>

	<h3><?= sprintf("$%.02f", $grand_total); ?> total sales</h3>

	<table>
	<tr>
		<th>Week's Sales</th>
		<? foreach($weeks as $week) { ?>
		<th >
			<div style="color: blue;">
			<?= sprintf("$%.02f", (!empty($weekly_sales[$week]) ? $weekly_sales[$week] : 0)) ?>
			</div>
		</th>
		<? } ?>
	</tr>
	<tr>
		<th>Product</th>
		<? foreach($weeks as $week) { 
			preg_match("/(\d{4})(\d{2})/", $week, $matches);
			$weekyear = $matches[1]; $weekweek = $matches[2];
			$weekname_start = date("m/d", strtotime("$weekyear-01-01")+($weekweek-1)*7*24*60*60 + 24*60*60);
			$weekname_end = date("m/d", strtotime("$weekyear-01-01")+($weekweek-1)*7*24*60*60 + 6*24*60*60 + 24*60*60);
		?>
		<th >
			<?= $weekname_start ?> - <?= $weekname_end ?>
		</th>
		<? } ?>
		<th>Product total</th>
	</tr>

	<? $i = 0; foreach($product_totals as $pid => $product_total) { 
		$sale_data = $product_sales[$pid];
	?>
	<tr style="background-color: <?= $i % 2 == 0 ? "#FFF":"#DDD"; ?>;" >
		<td><?= !empty($products_by_id[$pid]) ? $products_by_id[$pid]['Product']['name'] : $pid ?></td>
		<? foreach($weeks as $week) { 
			$week_sale = !empty($sale_data[$week]) ? $sale_data[$week] : 0;
		?>
		<td align="center">
			<? if($week_sale > 0) { ?>
			<div style="font-weight: bold; color: #009900;">
				<?= sprintf("$%.02f", $week_sale); ?>
			</div>
			<? } else { ?>
				&mdash;
			<? } ?>
		</td>
		<? } ?>
		<td>
			<?= sprintf("$%.02f", $product_total); ?>
		</td>
	</tr>
	<? $i++; } ?>
	</table>
</div>

