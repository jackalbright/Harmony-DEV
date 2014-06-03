<?= $this->element("gallery/browse_intro"); ?>
<? if (!isset($browseurl)) { $browseurl = "/gallery/browse"; } ?>
<? if (!isset($cols_per_row)) { $cols_per_row = 3; } ?>

<div class="right_align">
	<a href="/gallery/browse">View All Subjects</a>
</div>
<div class="clear"></div>
<br/>


<div align=center>
<table width="100%" class="grid">
	<? for($i = 0; $i < count($categories); $i++) { 
		$cat = $categories[$i];?>
		<? if($i % $cols_per_row == 0 && $i > 0) { ?> </tr> <? } ?>
		<? if($i % $cols_per_row == 0) { ?> <tr> <? } ?>
		<td valign=top class="padded">
			<a href="<?=$browseurl?>/<?=preg_replace("/ /", "_", $cat['browse_name']); ?>" style="font-weight: bold;">
				<?= $cat['browse_name'] ?>
			</a>
			<div style="margin-left: 20px;">
			<? 
			#print_r($cat);
			for($j = 0; !empty($cat['Subcategories']) && $j < count($cat['Subcategories']); $j++)
			{
				$sc = $cat['Subcategories'][$j];
				if ($j > 2)
				{
					?>
					<br/>
					<a href="<?=$browseurl?>/<?=preg_replace("/ /", "_", $cat['browse_name']) ?>">more...</a>
					<?
					break;
				} else {
				?>
				<div>
				<a href="<?=$browseurl?>/<?= preg_replace("/ /", "_", $sc['browse_name']) ?>">
					<?= $sc['browse_name'] ?>
				</a>
				</div>
				<? } ?>
			<? } ?>
			</div>
			<br/>
	
		</td>
	<? } ?>
</table>
</div>
