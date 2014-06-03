<div style="border: solid #CCC 1px; background-color: white; padding: 2px; padding-bottom: 50px;">

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

if ($current_step == 'cart' || $all_steps_complete) { $steps['cart'] = 'Add to Cart'; }


?>
<p>
Fill in the form below to customize your <?= strtolower($product_name) ?>. 
</p>

					<div class="hidden">
						<? if($current_step == 'cart') { ?>
							<input type="image" name="action" src="/images/buttons/Add-to-Cart.gif"/>
						<? } else { ?>
							<input type="image" name="action" src="/images/buttons/Next.gif"/>
						<? } ?>
					</div>
					<div class="clear"></div>

					<table width="100%" cellspacing=0 class="build_tab_container hidden">
					<tr>
					<?
					$step_complete = false;
					foreach($steps as $step_file => $step_title) { 
						#$step_filename = dirname(__FILE__)."/../../../../product/build/{$step_file}.php";
						$step_filename = dirname(__FILE__)."/steps/{$step_file}.ctp";
						$product_step_filename = dirname(__FILE__)."/steps/{$step_file}_{$product['prod']}.ctp";
						if (!file_exists($step_filename) && !file_exists($product_step_filename)) { continue; }

						?>
						<td class="build_tab <?= $step_complete ? "build_tab_complete" : "" ?> <?= ($current_step == $step_file) ? 'selected_build_tab' : "" ?>">
							<? if ($step_file == 'cart') { ?>
								<a href="/build/cart"><?= $step_title ?></a>
							<? } else { ?>
								<a href="<?= $current_step == 'cart' ? "/build/step/$step_file" : "Javascript:build_next_step('$step_file');"?> ">
								<?= $step_title ?>
								</a>
							<? } ?>

						</td>
						<td class="spacer"></td>
						<?
					}
					?>
					</tr>
					</table>

					<div class="Xbuild_step_container">
					<? 
						echo $hd->product_element("build/steps/$current_step", $product['prod']);
						#$product_step_file = dirname(__FILE__)."/../../../../product/build/{$product_name}_{$current_step}.php";
						##echo "PSF=$product_step_file";
						#$step_file = dirname(__FILE__)."/../../../../product/build/{$current_step}.php";
						#if (file_exists($product_step_file))
						#{
						#	include($product_step_file);
						#} else {
						#	include($step_file);
						#}
					?>



					<div class="clear"></div>
					<div class="hidden">
						<? if($current_step == 'cart') { ?>
							<input type="image" name="action" src="/images/buttons/Add-to-Cart.gif"/>
						<? } else { ?>
							<input type="image" name="action" src="/images/buttons/Next.gif"/>
						<? } ?>
					</div>
					<div class="clear"></div>
				</div>


</div>
