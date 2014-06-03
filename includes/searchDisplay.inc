<?php
	include_once ('database.inc');

// Create Product arrays for reproducible and non-reproducible items
	#$result = mysql_query ("Select product_type.* from product_type, product_part, part_type where part_type.part_name='image' and part_type.part_id = product_part.part_id and product_part.product_type_id = product_type.product_type_id and product_type.buildable='yes' and product_type.available='yes' and product_type.image_type REGEXP '(real|repro)' order by product_type.name", $database);
	$result = mysql_query ("Select product_type.* from product_type WHERE product_type.is_stock_item = 0 AND product_type.buildable='yes' and product_type.available='yes' and product_type.image_type REGEXP '(real|repro)' order by product_type.name", $database);
	$allProducts = array();
	while ($temp = mysql_fetch_object($result) ) {
		$allProducts[] = $temp;
	}

	$reproProducts = array();
	#$result = mysql_query ("Select product_type.* from part_type, product_part, product_type where part_type.part_name = 'image' and part_type.part_id = product_part.part_id and product_part.product_type_id = product_type.product_type_id and product_type.available = 'yes' and product_type.buildable = 'yes' and product_type.image_type REGEXP '(repro)' order by product_type.name", $database);
	$result = mysql_query ("Select product_type.* from product_type where product_type.is_stock_item = 0 AND product_type.available = 'yes' and product_type.buildable = 'yes' and product_type.image_type REGEXP '(repro)' order by product_type.name", $database);
	while ($temp = mysql_fetch_object($result)) {
		$reproProducts[] = $temp;
	}

	#$result = mysql_query ("Select product_type.* from product_type, product_part, part_type where part_type.part_name='image' and part_type.part_id = product_part.part_id and product_part.product_type_id = product_type.product_type_id and product_type.buildable='yes' and product_type.available='yes' AND product_type.image_type REGEXP '(real)' order by product_type.name", $database);
	$result = mysql_query ("Select product_type.* from product_type where product_type.is_stock_item = 0 AND product_type.buildable='yes' and product_type.available='yes' AND product_type.image_type REGEXP '(real)' order by product_type.name", $database);

	$stampProducts = array();
	while ($temp = mysql_fetch_object($result) ) {
		$stampProducts[] = $temp;
	}
	
	function listStamp ($stamp, $prod = '') {
		global $allProducts, $stampProducts, $reproProducts;

		$products = $allProducts;
		#foreach($products as $p) { echo "P=".$p->name.", "; }
		if($stamp->reproducible == 'Only') { $products = $reproProducts; }
		if($stamp->reproducible == 'No') { $products = $stampProducts; }

		?>
		<div>
		<form method="GET" action="/build/customize" onSubmit="if(!j(this).find('.prod').val()) { this.action = '/gallery/view/<?= $stamp->catalog_number; ?>'; } else { this.action = '/build/customize'; }">
		<input type="hidden" name="catalog_number" value="<?= $stamp->catalog_number ?>"/>
		<input type="hidden" name="new" value="1"/>
		<table width="830" cellspacing=5>
		<tr>
			<td style="width: 100px;" valign="top" align="center">
				<a href="/gallery/view/<?= $stamp->catalog_number ?>"><img class="stamp_thumbnail" height="50" src="<?= $stamp->image_location ?>"/></a>
				<div class="link"><a rel="shadowbox" href="/gallery_image/view/<?= $stamp->catalog_number ?>.gif">View Larger</a></div>
			</td>
			<td valign="top" align="center" style="width: 200px;">
				<div class="" style="">
					<div>View this stamp on</div>
					<select name="prod" class='prod' style="width: 175px;">
						<option value="">All Products</option>
						<? foreach($products as $p) { ?>
						<option value="<?= $p->code ?>" <?= (!empty($_SESSION['Build']['Product']['code']) && $_SESSION['Build']['Product']['code'] == $p->code) ? "selected='selected'" : "" ?> ><?= preg_replace("/s$/","", $p->name).'s'; ?></option>
						<? } ?>
					</select>
				</div>
					<input type="image" src="/images/buttons/Select-teal.gif"/>
			</td>
			<td valign="top">
				<h3 class=""><?= $stamp->stamp_name ?></h3>
				<div class="clear"></div>
				<div class="">
					<p><?= $stamp->short_description ?></p>
					<div style="float: right;">
						<? if(!empty($stamp->issue_date)) { ?>
						<span class='catNum'>Issue date <?= date('M jS, Y', strtotime($stamp->issue_date)) ?></span>
						<? } ?>
					</div>
					<span class="catNum">Catalog # <?= $stamp->catalog_number ?></span>
				</div>
				<? if($stamp->reproducible == 'No') { ?>
					<p class="note">Due to copyright, this stamp is not available on <a style='text-decoration: underline;' href="/info/reproduction.php">items requiring reproductions</a>.</p>
				<? } else if ($stamp->reproducible == 'Only') { ?>
					<p class="note">This stamp is only available as a licensed reproduction.  Because of this, we cannot create <a href="/details/stamp-on-card.php">stamps-on-cards</a> or <a href="/details/pin.php">pins/tie-tacks</a> with this image.</p>
				<? } ?>
			</td>
		</tr>
		</table>
		</form>
		</div>
	<?
	}
?>
