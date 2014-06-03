<? $prod = $build['Product']['code']; ?>
<? $this->element("steps/steps",array('step'=>'options')); ?>
<? $template = !empty($build['template']) ? $build['template'] : null; ?>
<div id="build">

	<form id="build_form" name="build_form" method="POST" action="/cart/add_consolidated"/>
	<input type="hidden" name="data[cart_item_id]" value="<?= !empty($build['cart_item_id']) ? $build['cart_item_id'] : "" ?>"/>
	<input id="prod" type="hidden" name="data[productCode]" value="<?= $build['Product']['code'] ?>"/>
	<input id="CustomImageID" type="hidden" name="data[options][customImageID]" value="<?= !empty($build['CustomImage']) ? $build['CustomImage']['Image_ID'] : "" ?>"/>
	<input type="hidden" name="data[options][imageCrop]" value="<?= !empty($build['crop'][$template]) ? join(",", $build['crop'][$template]) : "" ?>"/>
	<input id="CatalogNumber" type="hidden" name="data[options][catalogNumber]" value="<?= !empty($build['GalleryImage']) ? $build['GalleryImage']['catalog_number'] : "" ?>"/>

	<input id="template" type="hidden" name="data[template]" value="<?= !empty($build['template']) ? $build['template'] : "imageonly"; ?>"/>
	<input id="personalizationNone" type="hidden" name="data[options][personalizationNone]" value="<?= !empty($build['options']['personalizationNone']) ? $build['options']['personalizationNone'] : null ?>"/> <!-- important here for imageonly-nopersonalization -->

	<table align="center" width="100%">
	<tr>
		<td>
			<div class="" align="right">
				<a class="bold" href="/details/<?= $build['Product']['prod'] ?>.php">More <?= strtolower($build['Product']['name']) ?> info</a>
			</div>
		</td>
	</tr>
	<tr>
	<td>
	<table align="center" cellspacing=5 cellpadding=0 width="100%">
	<tr>
		<td colspan=1 valign="top" align="center" style="height: 150px; width: 525px;">
			<div id="build_img_container" style="">
				<?#= $this->element("../build/preview_adjust"); ?>
				<?= $this->requestAction("/build/preview_adjust",array('return')); ?>
			</div>
			<?
				$option_codes = Set::extract($options, "{n}.Part.part_code");

				$i = count($options)+1;
				if(in_array('quote', $option_codes) && in_array('personalization', $option_codes)) { $i--; } # Combined now.

				$step = !empty($_REQUEST['step']) ? $_REQUEST['step'] : null;
			?>
			<? /* ?>
			<div align="left">
			<?= $this->element("build/proof", array('i'=>$i,'step'=>$step)); ?>
			<? $i++; ?>
			</div>
			<? */ ?>
			<div align="left">
			<?#= $this->element("build/cart", array('i'=>$i,'step'=>$step)); ?>
			</div>

		</td>
		<td valign="top" style="">
			<?= $this->element("build/options",array('vertical'=>1)); ?>
		</td>
	</table>
	</td>
	</tr>
	</table>

	</form>

	<script>
		hidePleaseWait();
	</script>

	<?= $this->element("clients/clientlist",array('cols'=>4,'notop'=>true)); ?>


</div>
