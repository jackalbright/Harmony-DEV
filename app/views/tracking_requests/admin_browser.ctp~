<?= $this->element("admin/tracking_requests/header"); ?>

<div class="trackingRequests index">
<h2><?php __('TrackingRequests');?></h2>

<p>Browser stats</p>


<table>
<tr>
	<th> Browser </th>
	<th> Version </th>
	<th> Count </th>
	<th> Percent</th>
</tr>
<? arsort($browser_vendors); foreach($browser_vendors as $vendor => $vendor_count) { ?>
<tr>
	<td>
		<b><?= $vendor ?></b>
	</td>
	<td>
		&nbsp;
	</td>
	<td>
		<b><?= $vendor_count ?></b>
	</td>
	<td>
		<b><?= sprintf("%.02f%%", $vendor_count / $total_count * 100); ?></b>
	</td>
</tr>
	<?  if(isset($browser_versions[$vendor]) && is_array($browser_versions[$vendor])) { 
		arsort($browser_versions[$vendor]);
		foreach($browser_versions[$vendor] as $version => $version_count) { ?>
<tr>
	<td>
		&nbsp;
	</td>
	<td>
		<?= $version ?>
	</td>
	<td style="padding-left: 30px;">
		<?= $version_count ?>
	</td>
	<td style="padding-left: 30px;">
		<?= sprintf("%.02f%%", $version_count / $total_count * 100); ?>
	</td>
</tr>

	<? 
		} 
	}
	
	?>
<? } ?>
<tr>
	<td colspan=2 align=right>
		Total:
	</td>
	<td colspan=1 align=left>
		<b><?= $total_count ?></b>
	</td>
</tr>

</table>

</div>
