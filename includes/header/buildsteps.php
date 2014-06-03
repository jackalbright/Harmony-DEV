<? $sn = 1; ?>
<?
$tips = map_db_records(get_db_records("tips"), 'tip_code');

$is_stock_item = (!empty($build['Product']['is_stock_item']) || ($stepname == 'product' && !empty($product['Product']['is_stock_item'])));
$image_first = (!$is_stock_item &&!empty($build['image_first']) && ($stepname == 'image' || (!empty($build['CustomImage']) || !empty($build['GalleryImage'])) ));
if (!empty($product) && !empty($product['Product']))
{
	$build['Product'] = $product['Product'];
}

if(empty($build['Product']) && (!empty($image)) && (!empty($build['CustomImage']) || !empty($build['GalleryImage'])) && $stepname == 'image') 
{
	$image_first = true;
}
#if( (!empty($build['CustomImage']) || !empty($build['GalleryImage'])) && $stepname == 'product')
#{
#	echo "NCG";
#	$image_first = true;
#}
$step1name = !$image_first ? "product" : "image";
$step2name = $image_first ? "product" : "image";
?>
<table border=0 id="buildsteps" cellpadding=0 cellspacing=0 border=0>
<tr>
	<td id="step<?= $sn ?>" valign="top" class="step <?= $stepname == $step1name ? "currentstep" : "" ?> <?= in_array($stepname, array('cart',$step2name,'options')) ? 'previousstep' : "" ?>">
	<div class="steptext">
		<div class="stepnum"><?=$sn++?>. </div>
			<? if(!$image_first) { ?>
				<a class="bold" href="<?= (!empty($build['CustomImage']) || !empty($build['GalleryImage'])) ? "/products/select?change=1" : "/products/select&change=1" ?>"><?= !empty($build['Product']['code']) ? "Change" : "Select" ?> Product</a>
				<div class="stepdetails" XonMOuseOver="$(this).addClassName('stepdetails_hover');" XonMOuseOut="$(this).removeClassName('stepdetails_hover');">
					<? if(!empty($build['Product']['name'])) { ?><a href="/details/<?= $build['Product']['prod']?>.php"><?= $build["Product"]['name'] ?></a><? } ?>
				</div>
			<? } else { ?>
				<a class="bold" href="/gallery?prod=<?= !empty($build['Product']) ? $build['Product']['code']:"" ?>" ><?= !empty($build['GalleryImage']) || !empty($build['CustomImage']) ? "Change" : "Select" ?> Image</a>
				<div class="stepdetails" XonMOuseOver="$(this).addClassName('stepdetails_hover');" XonMOuseOut="$(this).removeClassName('stepdetails_hover');">
					<? if(!empty($build['CustomImage']['Title'])) { ?> <?= $build['CustomImage']['Title'] ?> <? } ?>
					<? if(!empty($build['GalleryImage']['stamp_name'])) { ?> <?= $build['GalleryImage']['stamp_name'] ?> <? } ?>
				</div>
			<? } ?>
	</div></td>
	<? if(!$is_stock_item) { ?>
	<td id="step<?= $sn ?>" valign="top" class="step <?= $stepname == $step2name ? "currentstep" : "" ?> <?= in_array($stepname, array('cart','options')) ? 'previousstep' : "" ?>">
	<div class="steptext ">
		<div class="stepnum"><?=$sn++?>. </div>
			<? if($image_first) { ?>
				<a class="bold" href="<?= (!empty($build['CustomImage']) || !empty($build['GalleryImage'])) ? "/products/select" : "/products/select" ?>"><?= !empty($build['Product']['code']) ? "Change" : "Select" ?> Product</a>
				<div class="stepdetails" XonMOuseOver="$(this).addClassName('stepdetails_hover');" XonMOuseOut="$(this).removeClassName('stepdetails_hover');">
					<? if(!empty($build['Product']['name'])) { ?><a href="/details/<?= $build['Product']['prod']?>.php"><?= $build["Product"]['name'] ?></a><? } ?>
				</div>
			<? } else { ?>
				<a class="bold" href="/gallery?prod=<?= !empty($build['Product']) ? $build['Product']['code']:"" ?>" ><?= !empty($build['CustomImage']) || !empty($build['GalleryImage']) ? "Change" : "Select" ?> Image</a>
				<div class="stepdetails" XonMOuseOver="$(this).addClassName('stepdetails_hover');" XonMOuseOut="$(this).removeClassName('stepdetails_hover');">
					<? if(!empty($build['CustomImage']['Title'])) { ?> <?= $build['CustomImage']['Title'] ?> <? } ?>
					<? if(!empty($build['GalleryImage']['stamp_name'])) { ?> <?= $build['GalleryImage']['stamp_name'] ?> <? } ?>
				</div>
			<? } ?>
	</div></td>
	<td id="step<?= $sn ?>" valign="top" class="step <?= $stepname == 'options' ? "currentstep" : "" ?> <?= $stepname == 'cart' ? 'previousstep' : "" ?>">
	<div class="steptext">
		<div class="right"> <? $tip_code = 'build_step_options'; include("includes/tip_small.php"); ?> </div>
		<div class="stepnum"><?=$sn++?>. </div>
		<a class="bold" <?= !empty($build['Product']) && (!empty($build['CustomImage']) || !empty($build["GalleryImage"])) ? 'href="/build/customize"' : "" ?> >Select Options</a>
		<? /* 
		<div class="stepdetails" XonMOuseOver="$(this).addClassName('stepdetails_hover');" XonMOuseOut="$(this).removeClassName('stepdetails_hover');">
			<? if(!empty($build['Product']) && (!empty($build['CustomImage']) || !empty($build["GalleryImage"]))) { ?>
			<? if(empty($build['saved'])) { ?>
			<a style="color: #FFF;" class="bold" href="/build/save">Save for later?</a>
			<? } else { ?>
			<div style="color: #009900; font-weight: bold;">SAVED</div>
			<? } ?>
			<? } ?>
		</div>
		*/ ?>
	</div></td>
	<? } ?>
	<td id="step<?= $sn ?>" valign="top" class="step <?= $stepname == 'cart' ? "currentstep" : "" ?>">
	<div class="steptext">
		<div class="stepnum"><?=$sn++?>. </div>
		<a class="bold">Add to Cart</a>
		<div class="stepdetails" XonMOuseOver="$(this).addClassName('stepdetails_hover');" XonMOuseOut="$(this).removeClassName('stepdetails_hover');"></div>
	</div></td>
</tr>
</table>

<table class="hidden">


					<? if (!empty($stock) || (!empty($build['Product']) && $build['Product']['is_stock_item']) || (!empty($product['Product']) && $product['Product']['is_stock_item'])) { ?>
						<td id="" class="step1 step <?= $stepname == 'product' ? 'step1_selected_step selected_step' : 'step1_previous_step previous_step'; ?>" valign="top">
							<a href="<? !empty($build['CustomImage']) || !empty($build['GalleryImage']) ? "/products/select" : "/products" ?>">Choose<br/>Product</a>
							<div class="step_subtext"><?= strip_tags($purchase_steps['product']['text']); ?></div>
						</td>
						<td id="" class="step2 step <?= $stepname == 'cart' ? 'step2_selected_step selected_step' : ''; ?>" valign="top">
							<nobr><?= $purchase_steps['cart']['title'] ?></nobr>
							<div class="step_subtext"><?= strip_tags($purchase_steps['cart']['text']); ?></div>
						</td>
			
					<? } else { ?>
			
						<? if(empty($build['image_first'])) { ?>
						<td id="" class="step1 step <?= $stepname == 'product' ? 'step1_selected_step selected_step' : 'step1_previous_step previous_step'; ?>" valign="top">
							<a href="<? (!empty($build['CustomImage']) || !empty($build['GalleryImage'])) ? "/products/select" : "/products" ?>"><?= $purchase_steps['product']['title'] ?></a> <span class="arrow"></span>
							<div class="step_subtext"><?= strip_tags($purchase_steps['product']['text']); ?></div>
						</td>
						<td id="" class="step2 step <?= $stepname == 'image' ? 'step2_selected_step selected_step' : (!empty($build['CustomImage']) || !empty($build['GalleryImage']) ? "step2_previous_step previous_step" : "") ?>" valign="top">
							<? if($stepname == 'image' || !empty($build['CustomImage']) || !empty($build['GalleryImage'])) { ?>
								<a href="/gallery"><?= $purchase_steps['image']['title'] ?></a> <span class="arrow"></span>
							<? } else { ?>
								<nobr><?= $purchase_steps['image']['title'] ?></nobr> <span class="arrow"></span>
							<? } ?>
							<div class="step_subtext"><?= strip_tags($purchase_steps['image']['text']); ?></div>
						</td>
						<? } else { ?>
						<td id="" class="step1 step <?= $stepname == 'image' ? 'step1_selected_step selected_step' : 'step1_previous_step previous_step'; ?>" valign="top">
							<? if($stepname == 'image' || !empty($build['CustomImage']) || !empty($build['GalleryImage'])) { ?>
								<a href="/gallery"><?= $purchase_steps['image']['title'] ?></a> <span class="arrow"></span>
							<? } else { ?>
								<nobr><?= $purchase_steps['image']['title'] ?></nobr> <span class="arrow"></span>
							<? } ?>
							<div class="step_subtext"><?= strip_tags($purchase_steps['image']['text']); ?></div>
						</td>
						<td id="" class="step2 step <?= $stepname == 'product' ? 'step2_selected_step selected_step' : ( (!empty($build['CustomImage']) || !empty($build['GalleryImage'])) ? "step2_previous_step previous_step" : ""); ?>" valign="top">
							<? if ($stepname == 'product' || !empty($product) || !empty($build['Product'])) { ?>
								<a href="/products/select"><?= $purchase_steps['product']['title'] ?></a> <span class="arrow"></span>
							<? } else { ?>
								<nobr><?= $purchase_steps['product']['title'] ?></nobr> <span class="arrow"></span>
							<? } ?>
							<div class="step_subtext"><?= strip_tags($purchase_steps['product']['text']); ?></div>
						</td>
						<? } ?>
				
						<? if (empty($build['GalleryImage']) && empty($gallery)) { ?>
						<td id="" class="step3 step <?= $stepname == 'layout' ? 'step3_selected_step selected_step' : (!empty($build['template']) ? "step3_previous_step previous_step" : ""); ?>" valign="top">
							<? if (!empty($build['Product']) && (!empty($build['CustomImage']) || !empty($build['GalleryImage']))) { ?>
								<a href="/build/create"><?= $purchase_steps['layout']['title'] ?></a> <span class="arrow"></span>
							<? } else { ?>
								<nobr><?= $purchase_steps['layout']['title'] ?></nobr> <span class="arrow"></span>
							<? } ?>
							<div class="step_subtext"><?= strip_tags($purchase_steps['layout']['text']); ?></div>
						</td>
				
						<td id="" class="step4 step <?= $stepname == 'options' ? 'step4_selected_step selected_step' : ''; ?>" valign="top">
							<? if ($stepname == 'options' || $stepname == 'cart' || !empty($build['template'])) { ?>
								<a href="/build/customize"><?= $purchase_steps['options']['title'] ?></a> <span class="arrow"></span>
							<? } else { ?>
								<nobr><?= $purchase_steps['options']['title'] ?></nobr> <span class="arrow"></span>
							<? } ?>
							<div class="step_subtext"><?= strip_tags($purchase_steps['options']['text']); ?></div>
						</td>
						<td id="" class="step5 step <?= $stepname == 'cart' ? 'step5_selected_step selected_step' : ''; ?>" valign="top">
							<nobr><?= $purchase_steps['cart']['title'] ?></nobr> 
							<div class="step_subtext"><?= strip_tags($purchase_steps['cart']['text']); ?></div>
						</td>
						<? } else { ?>
						<td id="" class="step3 step <?= $stepname == 'options' ? 'selected_step' : ''; ?>" valign="top">
							<? if ($stepname == 'options' || $stepname == 'cart') { ?>
								<a href="/build/customize"><?= $purchase_steps['options']['title'] ?></a> <span class="arrow"></span>
							<? } else { ?>
								<nobr><?= $purchase_steps['options']['title'] ?></nobr> <span class="arrow"></span>
							<? } ?>
							<div class="step_subtext"><?= strip_tags($purchase_steps['options']['text']); ?></div>
						</td>
						<td id="" class="step4 step <?= $stepname == 'cart' ? 'step4_selected_step selected_step' : ''; ?>" valign="top">
							<nobr><?= $purchase_steps['cart']['title'] ?></nobr>
							<div class="step_subtext"><?= strip_tags($purchase_steps['cart']['text']); ?></div>
						</td>
						<? } ?>
					<? } ?>
				</tr>
</table>

<?
$stepcodes = array( $step1name, $step2name, 'options');#, 'cart');
$current_step_num = array_search($stepname, $stepcodes);
if($stepcodes[$current_step_num] == 'product' && !empty($product)) { $current_step_num = false; }
if($current_step_num !== false) { $current_step_num++; }
?>

