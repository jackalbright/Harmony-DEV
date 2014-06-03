<?
$all_steps_complete = false;
$product_name = $build['Product']['name'];

$steps_complete = array();
$steps_incomplete = array();

$steps = array();
foreach($options as $option)
{
	$option_name = $option['Part']['part_code'];
	$step_file = $option['Part']['part_code'];
	$step_title = $option['Part']['part_name'];
	$steps[$step_file] = $step_title;
}
$steps['comments'] = 'Comments';

foreach($steps as $step => $stitle)
{
	if(!empty($build['options'][$step]))
	{
		$steps_complete[$step] = 1;
	} else {
		$steps_incomplete[$step] = 1;
	}
}

if(!count($steps_incomplete))
{
	$all_steps_complete = true;
}


$progress_percent = round(count($steps_complete) / count($steps) * 100);

?>
<table width="100%" style="border: solid #CCC 1px; background-color: #EEE; margin-top: 5px;">
<tr>
<td width="40%">
	<div class="progress_bar">
		<table width="100%" cellpadding=1 cellspacing=2>
		<tr>
			<td>
				<b>Design Progress:</b>
				(Step <?=!empty($counter) ? $counter : 1 ?> of <?= count($steps)+1 ?>)
			</td>
		</tr>
		<tr>
			<td>
				<div class="progress_bar_outer">
					<div class="progress_bar_inner" style="width: <?= $progress_percent ?>%;"></div>
				</div>
			</td>
			<td style="width: 25px;">
				<div class="progress_bar_label" style="">
					<?= $progress_percent ?>%
				</div>
			</td>
		</tr>
		</table>
	</div>

</td>
<td align="right" valign="bottom">
	<a href="/build/step?clear=1">Start over</a> |
	<a href="/products/select?new=1">Change product</a> |
	<a href="/gallery">Change image</a>

	<br/>
	<a href="/details/<?= $parent_product ? $parent_product['Product']['prod'] : $product['prod']?>.php">
	<br/>More <?= strtolower($product_name); ?> information</a>
	<? if(!empty($build['GalleryImage'])) { ?>| <a href="/gallery/view/<?= $build['GalleryImage']['catalog_number']?>">More image information</a><? } ?>
</td>
</tr>
</table>
