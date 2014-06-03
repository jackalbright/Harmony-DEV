<div id="build_preview_options">

<? if(empty($summary)) { ?>
<div class="preview_option" style="border: solid black 2px;">
<div class="right_align hidden">
<? if($current_step != 'cart') { ?>
<input type="image" name="action" src="/images/buttons/Next.gif"/>
<? } else { ?>
	<? if(!empty($build['cart_item_id'])) { ?>
		<input type="image" name="action" src="/images/buttons/Update-grey.gif" onClick="showPleaseWait();"/>
	<? } else { ?>
		<input type="image" name="action" src="/images/buttons/Add-to-Cart.gif" onClick="showPleaseWait();"/>
	<? } ?>
<? } ?>
</div>

<?= $this->element("build/quantity", array('url'=>"/build/update_quantity/$current_step")); ?>

<? } ?>

<? if(empty($no_summary)) { ?>

<?
$steps = array();
foreach($options as $option)
{
	$option_name = $option['Part']['part_code'];
	$step_file = $option['Part']['part_code'];
	$step_title = $option['Part']['part_name'];
	$steps[$step_file] = $step_title;
}
$steps['comments'] = 'Comments';

foreach($steps as $step_file => $step_title) { 
	$step_filename = dirname(__FILE__)."/steps/{$step_file}.ctp";
	if (!file_exists($step_filename) && !file_exists($product_step_filename)) { continue; }
?>

<div class="preview_option preview_option_<?=$step_file ?> <?= $current_step == $step_file ? "preview_option_selected" : "" ?>">

<table width="100%" cellpadding=0 cellspacing=0>
<tr>
<td align="left">
		<div class="preview_option_title"><?= $step_title ?></div>
</td>
<td align="right">
		<a href="/build/step/<?= $step_file ?>" onClick="showPleaseWait();">Change</a>
</td>
</tr>
</table>
	<div class="preview_option_value_<?=$step_file?> preview_option_value">
	<? if (isset($build['options'][$step_file])) { ?>
		<?= $this->element("build/details/$step_file"); ?>
	<? } else { ?>
		<i>Not specified</i>
		<br/>
	<? } ?>
	</div>
</div>

<? } ?>

<? } ?>

<? if(empty($summary)) { ?>
<div class="right_align hidden">
<? if($current_step != 'cart') { ?>
<input type="image" name="action" src="/images/buttons/Next.gif"/>
<? } else { ?>
	<? if(!empty($build['cart_item_id'])) { ?>
		<input type="image" name="action" src="/images/buttons/Update-grey.gif" onClick="showPleaseWait();"/>
	<? } else { ?>
		<input type="image" name="action" src="/images/buttons/Add-to-Cart.gif" onClick="showPleaseWait();"/>
	<? } ?>
<? } ?>
</div>
<? } ?>

</div>
