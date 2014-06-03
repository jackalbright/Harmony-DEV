<div>
<h3>What are people looking for? (top searches)</h3>

<?= $date_start ?> - <?= $date_end ?>

<form method="POST" action="/admin/tracking_requests/top_search">
<input type="text" name="query" value="<?= !empty($_REQUEST['query']) ? $_REQUEST['query'] : "" ?>"/> <input type="submit" value="Search"/>
<a href="/admin/tracking_requests/top_search">Reset</a>
</form>

<p><?= $total ?> searches total</p>

	<table border=1>
	<tr>
		<td>%</td>
		<td>#</td>
		<td>Search</td>
		<? if($keywords) { ?>
		<td>Related Phrase</td>
		<? } ?>
		<td>Referer</td>
		<td>% Build</td>
		<td>% Add to Cart</td>
		<td>% Start Checkout</td>
		<td>% Complete Purchase</td>
	</tr>
	<? arsort($searches); foreach($searches as $search => $scount) { ?>
	<tr>
		<td>
			<?= sprintf("%u%%", $scount / $total * 100); ?>
		</td>
		<td>
			<?= $scount ?>
		</td>
		<td>
			<?= $search ?><br/>
			<a href="/admin/tracking_requests/trail_by_search?search=<?= urlencode($search) ?>">View Pages They Visited</a>
		</td>
		<? if($keywords) { ?>
		<td>
			<? arsort($phrases[$search]); foreach($phrases[$search] as $phrase => $count) { ?>
				<?= $phrase ?> (<?= $count ?>)<br/>
			<? } ?>
		</td>
		<? } ?>
		<td>
			<? arsort($referers[$search]); foreach($referers[$search] as $referer => $count) { ?>
				<?= $referer ?> (<?= $count ?>)<br/>
			<? } ?>
		</td>
		<td>
			<? if(!empty($builds[$search])) { ?>
			<?= sprintf("%.02f%%", ($builds[$search]) / $scount * 100); ?>
			<? } ?>
		</td>
		<td>
			<? if(!empty($carts[$search])) { ?>
			<?= sprintf("%.02f%%", ($carts[$search]) / $scount * 100); ?>
			<? } ?>
		</td>
		<td>
			<? if(!empty($checkouts[$search])) { ?>
			<?= sprintf("%.02f%%", ($checkouts[$search]) / $scount * 100); ?>
			<? } ?>
		</td>
		<td>
			<? if(!empty($purchases[$search])) { ?>
			<?= sprintf("%.02f%%", ($purchases[$search]) / $scount * 100); ?>
			<? } ?>
		</td>
	</tr>
	<? } ?>
	<tr>
		<td colspan=4>TOTAL:</td>
		<td> <?= array_sum($builds); ?> </td>
		<td> <?= array_sum($carts); ?> </td>
		<td> <?= array_sum($checkouts); ?> </td>
		<td> <?= array_sum($purchases); ?> </td>
	</tr>
	</table>
</div>
