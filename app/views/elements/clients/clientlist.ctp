<? if(!empty($clients)) { ?>
<? if(empty($notitle)) { ?>
<? if(empty($vertical) && empty($notop)) { ?>
<div class="right"><a name="customers" href="#">Top</a></div>
<? } ?>
<? if(!isset($bare)) { ?>
<h3 class="grey_header" style=""> <span> A Few of Our Customers </span> </h3>
<? } ?>
<? } ?>
<div style="background-color: #FFFFEE;">
<? if(!empty($twocol)) { ?>
<div id="clientlist" class="<?= !isset($bare) ? "grey_border" :""?> clientlist" width="275" style="background-color: #FFFFEE;">
	<table width="100%">
	<? $i = 0; foreach($clients as $client) { 
		$c = !empty($client['Client']) ? $client['Client'] : $client;
		if (empty($c)) { continue; }
	?>
		<? if($i > 0 && $i % 2 == 0) { ?></tr><? } ?>
		<? if($i % 2 == 0) { ?><tr><? } ?>
		<td valign="bottom" align="center">
			<img src="/images/clients/small/<?= $c['client_id']?>.jpg" title="<?= $c['company'] ?>" width="125"/>
		</td>
	<? $i++; } ?>
	</table>
</div>
<? } else if (empty($vertical)) { if(empty($cols)) { $cols = 3; } ?>
<table width="100%">
<? for($i = 0; $i < count($clients); $i++) { $client = $clients[$i]; ?>
<? if($i % $cols == 0) { if($i > 0) { echo "</tr>"; } ?><tr><? } ?>
	<td valign="center">
		<?= $hd->scaledimg("/images/clients/{$client['Client']['client_id']}.jpg", array('width'=>'150','title'=>$client['Client']['company'])); ?>
	</td>
<? if($i+1 == count($clients)) { ?></tr><? } ?>
<? } ?>
</table>

<? } else { ?>
	<div id="clientlist" class="clientlist grey_border" align="center">
	
	<?php
	$i = 0;
	foreach ($clients as $client)
	{
		$c = !empty($client['Client']) ? $client['Client'] : $client;
		if (empty($c)) { continue; }
	?>
			<div style="<?= empty($vertical) ? "float: left;" : "margin: 0 auto;" ?>" class="padded" valign="top">
				<?= $hd->scaledimg("/images/clients/{$c['client_id']}.jpg", array('width'=>'150','title'=>$c['company'])); ?>
			</div>
	<? } ?>
	
		<div class="clear"></div>
	
	</div>
<? } ?>


</div>
<? } ?>
</div>
