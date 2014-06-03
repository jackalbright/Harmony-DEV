<div>
	<h2>Top Visitors</h2>

	<?= count($visitors) ?> Landing Page Visitors: <?= $start ?> - <?= $finish ?>

	<pre>
		<? #print_r($visitors); ?>
	</pre>

	<table border=1 width="95%">
		<tr>
			<th> Visits </th>
			<th> IP Address </th>
			<th> City, State </th>
			<th> Company </th>
			<th> Pages </th>
			<th> Keywords </th>
			<th> Referers </th>
			<th> Sessions </th>
		</tr>
		<? foreach($visitors as $v) { 
			$others = array(); # Individuals.
			if((empty($v['whois']['OrgName']) || in_array($v['whois']['OrgName'], $others))) { continue; } # Hide unknowns.
		?>
		<tr>
			<td>
				<?= $v['visits'] ?>
			</td>
			<td>
				<?= $v['ip'] ?>
			</td>
			<td>
				<? if(!empty($v['geoip'])) { ?>
					<?= $v['geoip']['city'] ?>, <?= $v['geoip']['region'] ?>, <?= $v['geoip']['country_name'] ?>
				<? } else { ?>
					?
				<? } ?>
			</td>
			<td>
				<?= !empty($v['whois']['OrgName']) ? $v['whois']['OrgName'] : "?" ?>
			</td>
			<td>
				<? foreach($v['urls'] as $url) { 
					preg_match("@/details/(.*)[.]php@", $url, $match);
					$pagename = !empty($match[1]) ? $match[1] : $url;
				?>
					<?= $this->Html->link($pagename, $url, array('target'=>'_new')); ?>
				<? } ?>
				<b>(<?= $v['pages'] ?>)</b>
			</td>
			<td style="font-size: 14px; font-weight: bold; color: green;">
				<? foreach($v['keywords'] as $kw) { ?>
					<?= $kw ?>; <br/>
				<? } ?>
			</td>
			<td style="width: 500px;">
				<? foreach($v['referers'] as $ref) { ?>
					<?= $this->Html->link($ref, $ref, array('target'=>'_new')); ?><br/>
				<? } ?>
			</td>
			<td>
				<? foreach($v['sessions'] as $sess) { ?>
					<?= $this->Html->link($sess, "/admin/tracking_requests/session/$sess", array('target'=>'_new')); ?><br/>
				<? } ?>
			</td>
		</tr>
		<? } ?>
	</table>

	<? #print_r($visitors); ?>
</div>
