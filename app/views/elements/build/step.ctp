
<? if(!empty($option['Part']['part_summary'])) { ?>
						<div class="part_summary">
							<?= $option['Part']['part_summary'] ?>
						</div>
<? } ?>
	
<?= $hd->product_element("build/options/$option_code", $build['Product']['prod'], array('i'=>$option_code,'option_code'=>$option_code)); ?>
	
<? if((!isset($next) || $next !== false) && (!isset($bottom_next) || $bottom_next !== false)) { ?>
<div style="padding-right: 100px; " align="right">
	<a href="Javascript:void('<?= $option_code ?>');" onClick="showBuildStepNext('<?= $option_code ?>');"><img src="/images/buttons/small/Next-green.gif"></a>
</div>
<? } ?>

