<table width="100%">
<tr>
	<td valign="bottom" width="50%">
		<form id="preview_form" method="GET">
		<select id="prod" name="browse_prod" onChange="showPleaseWait(); $('preview_form').submit();">
			<option value="">Stamp only</option>
			<? foreach($products as $p) { ?>
				<option value="<?= $p['Product']['code'] ?>" <?= (!empty($product['Product']['code']) && $product['Product']['code'] == $p['Product']['code']) ? "selected='selected'" : "" ?> ><?= ucwords($hd->pluralize($p['Product']['name'])); ?></option>
			<? } ?>
		</select>
		</form>
	</td>
	<td align=left valign=bottom colspan=1>
	<? echo $paginator->counter(array( 'format' => __('Items %start% - %end% of %count%', true))); ?>
	</td>
</tr>
</table>

<? if (!isset($cols_per_row)) { $cols_per_row = 5; } ?>

<table width="100%" id="stamp_browse_grid" cellpadding=0 border=0 cellspacing=10>
<? for($i = 0; $i < count($galleryImages); $i++) { 
	$image = $galleryImages[$i];
	?>
	<? if($i % $cols_per_row == 0 && $i > 0) { ?> </tr> <? } ?>
	<? if($i % $cols_per_row == 0) { ?> <tr> <? } ?>
	<td valign=top align=center class="stamp_browse_item" style="padding: 5px; ">
		<?= $this->element("gallery/image_grid_item", array('image'=>$image)); ?>
	</td>
<? } ?>
</table>

<div align="center" class="">
	<?php echo $paginator->options(array('url' => $this->passedArgs)); ?>
	<? if($paginator->hasPrev()) { ?>
	<?php echo $paginator->prev("<img align='absmiddle' src='/images/buttons/small/Prev-arrow.gif'/>", array('escape'=>false), null, array('class'=>'disabled inline','escape'=>false));?>
	&nbsp;
	<? } ?>
 	<?php echo $paginator->numbers();?>
	<? if($paginator->hasNext()) { ?>
	&nbsp;
 	<?php echo $paginator->next("<img align='absmiddle' src='/images/buttons/small/Next-arrow.gif'/>", array('escape'=>false), null, array('class'=>'disabled inline','escape'=>false));?>
 	<? } ?>
</div>
<br/>
<br/>
<br/>
<br/>
