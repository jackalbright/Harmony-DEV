<?
	
	$prod = $build['Product']['code'];
?>
<div style="padding: 10px;">
	<div>
			<?=$this->element("shipfree"); ?>

	</div>
<table width="100%">
<tr>
<td width="50%" valign="top">
	<?= $this->element("build/review"); ?>
	<?= $this->element("build/options/comments",array('i'=>'comments')); ?>
</td>
<td valign="top" align="left">

<div style="margin-left: 20px; padding-left: 20px; width: 200px; border-left: solid #DDD 1px;">
	<? if($prod == 'TS') { ?>
		<?= $this->element("build/quantity_tshirt", array('url'=>'')); ?>
	<? } else { ?>
		<?= $this->element("build/quantity_new", array('url'=>'')); ?>
	<? } ?>
</div>

</td>
</tr>
</table>

</div>

