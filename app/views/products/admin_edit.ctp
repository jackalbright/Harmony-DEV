<div class="products form">
<h1><?= !empty($product['Product']['product_type_id']) ? "Edit {$product['Product']['name']}" : "Add a Product Landing Page"; ?></h1>

<? if(!empty($this->data['Product']['product_type_id'])) { ?>
<div align="right">
	<a href="/admin/products/editold/<?= !empty($this->data['Product']['product_type_id']) ? ($this->data['Product']['product_type_id']) : null ?>">OLD EDIT PAGE</a>
</div>
<?
	$ppid = !empty($this->data['Product']['parent_product_type_id']) ? $this->data['Product']['parent_product_type_id'] : $this->data['Product']['product_type_id'];
?>

<a href="/admin/product_options/edit/<?= $ppid ?>">Comparison Chart</a>

<? } ?>
<table border=1>
<tr>
</tr>
</table>
<style>
hr
{
	margin: 15px 0px;
}
</style>

<?php echo $form->create('Product',array('url'=>$this->here,'type'=>'file'));?>
<div>

	<div class="right">
	</div>
	<?= $form->input("product_type_id"); ?>
<table cellpadding=10>
	<tr>
		<td colspan=4 align="right">
			<?= $form->submit('Save Changes'); ?>
		</td>
	</tr>
	<tr>
		<th width="250">General Product Info</th>
		<th width="500">Content</th>
		<th>Options/Parts</th>
		<th width="300">Pricing</th>
	</tr>

	<!-- 3 col -->
	<tr>
		<td>
			<script>
			function setProductName(name)
			{
				if(!j('#ProductPageTitle').val())
				{
					j('#ProductPageTitle').val(name);
				}
				if(!j('#ProductBodyTitle').val())
				{
					j('#ProductBodyTitle').val(name);
				}
				if(!j('#ProductPricingName').val())
				{
					j('#ProductPricingName').val(name);
				}
				if(!j('#ProductShortName').val())
				{
					j('#ProductShortName').val(name);
				}
				if(!j('#ProductCode').val())
				{
					var code = "";
					var nameparts = name.split(/\s+/);
					for(var i = 0; i < nameparts.length; i++)
					{
						code += nameparts[i].substr(0,1).toUpperCase();
					}
					j('#ProductCode').val(code);
				}
				if(!j('#ProductProd').val())
				{
					var prod = name.toLowerCase().replace(/\s+/, "-");
					j('#ProductProd').val(prod);
				}
			}
			</script>
			<?= $form->input('name',array('label'=>'Product name','onChange'=>"setProductName(this.value)")); ?>

			<?= $form->input('code',array('size'=>5,'label'=>'Product Code','div'=>array('class'=>'input text left'))) ?>
			<div class="noparent" style="<?= !empty($this->data['Product']['parent_product_type_id']) ? "display:none;":""?>">
			<?= $form->input('sort_index',array('size'=>3,'label'=>'List Page Order','default'=>$maxSortIndex+1,'div'=>array('class'=>'input text left'))); ?>
			</div>
			<div class="clear"></div>

			<?= $form->input('short_name',array('label'=>'Common Name','after'=>'<br/>')); ?>

			<?= $form->input('product_category_id',array('options'=>$product_categories,'empty'=>'None')) ?>

			<br/>
			<?= $form->input('is_stock_item',array('label'=>'Is stock item?','onClick'=>"if(this.checked) { j('.stockitem').show(); j('.custom').hide(); } else { j('.stockitem').hide(); j('.custom').show(); }")); ?>
			<br/>
			<?= $form->input('new_build'); ?>

			<br/>

			<?= $form->input('parent_product_type_id',array('options'=>$parent_product_types, 'label'=>'Parent Product','empty'=>'None','onChange'=>"if(this.value) { j('.noparent').hide(); j('.parent').show(); } else { j('.noparent').show(); j('.parent').hide(); }")); ?>
			<? if(!empty($relatedProducts)) { ?>
				<br/>
				<div class="bold">Related Child Products:</div>
				<? foreach($relatedProducts as $rp) { ?>
					<a href="/admin/products/edit/<?= $rp['Product']['product_type_id'] ?>"><?= $rp['Product']['name'] ?></a><br/>
				<? } ?>
				<br/>
			<? } ?>
			<div class="parent" style="<?= empty($this->data['Product']['parent_product_type_id']) && empty($relatedProducts) ? "display: none;": "" ?> ">
			<?= $form->input('choose_index',array('label'=>'Related Comparison Order','size'=>3,'default'=>1)); ?>
			</div>
			<br/>
			<?##### already defaults to parent if self not there... #= $form->input("blank_product_type_id", array('label'=>'Use blank from other product', 'options'=>$parent_product_types,'empty'=>'N/A')); ?>


			<div class="required">
			<label class="">Weight (for shipping)</label>
			<?= $form->input('weight_oz',array('after'=>'oz per','size'=>4, 'label'=>false,'div'=>array('class'=>'input text required left'))); ?>
			<?= $form->input('weight_oz_count',array('options'=>array(1=>1,10=>10,100=>100,1000=>1000), 'label'=>false,'after'=>'','div'=>array('class'=>'input select left'))); ?>
			<div class="clear"></div>
			</div>

			<?= $form->input('available',array('options'=>array('yes'=>'Yes','no'=>'No'),'after'=>"<br/>Choose 'no' to disable")); ?>

			<?= $form->input('made_in_usa',array('options'=>array('manufactured'=>'Manufactured','designed'=>'Designed','no'=>'No'), 'onChange'=>"j('#madeInUsaText').toggle(j(this).val() != 'no'); ")); ?>

			<div class="custom" style="<?= !empty($this->data['Product']['is_stock_item']) ? "display: none;" : "" ?>">
			<hr/>
			<?= $form->input('buildable',array('options'=>array('yes'=>'Yes','no'=>'No'),'label'=>'Separate Buildable Item')); ?>
			<? if(!empty($this->data['Product']['product_type_id'])) { ?>
			<?= $form->input('image_type',array('type'=>'select','options'=>$image_types, 'label'=>'Allowed Image Types','multiple'=>'checkbox')) ?>
			<? } else { ?>
			<?= $form->input('image_type',array('type'=>'select','options'=>$image_types,'selected'=>array('real','repro','custom'), 'label'=>'Allowed Image Types','multiple'=>'checkbox')) ?>
			<? } ?>

			<h4>Layouts</h4>
			<? if(!isset($form->data['Product']['image_and_text'])) { $form->data['Product']['image_and_text'] = 1; } ?>
			<?= $form->input('image_and_text',array())  ?>
			<? if(!isset($form->data['Product']['imageonly'])) { $form->data['Product']['imageonly'] = 1; } ?>
			<?= $form->input('imageonly',array())  ?>
			<? if(!isset($form->data['Product']['fullbleed'])) { $form->data['Product']['fullbleed'] = 1; } ?>
			<?= $form->input('fullbleed',array('label'=>'Show full bleed (NO PERSONALIZATION)')); ?>


			</div>


			<hr/>

			<div class="stockitem" style="<?= empty($this->data['Product']['is_stock_item']) ? "display: none;" : "" ?>">
			<h4> Customizable Stock Items </h4>
			<?= $form->input('customizable',array('label'=>'Can add personalization/logo to stock item','options'=>array(''=>'No','text'=>'Personalization','logo'=>'Logo','both'=>'Both'),'onChange'=>"if(this.value) { j('#stock_item_customize').show(); } else { j('#stock_item_customize').hide(); } ")) ?>
			<div id="stock_item_customize" style="<?= empty($this->data['Product']['customizable']) ? "display: none;" : "" ?>">
				<?= $form->input('personalizationLimit',array('default'=>'30','label'=>'Personalization Limit','size'=>3,'div'=>array('class'=>'required text input'))) ?>
			</div>

			<div class="clear"></div>
			<hr/>

			<?= $form->input("semi_customizable", array('label'=>'Semi-Customizable?', 'options'=>array('No','Yes'),'onChange'=>"if(this.value) { j('#semiCustom').show(); } else { j('#semiCustom').hide(); }")); ?>
			<br/>
			<br/>

			<div id="semiCustom" style="<?= !empty($this->data['Product']['semi_customizable']) ? '':'display: none;' ?>">
				Customer can add personalization and choose from quotes:
				<?= $form->input("semi_customizable_catalog_number", array('label'=>'Semi-Customizable Stamp Number')); ?>
				<?= $form->input("semi_customizable_quotes", array('label'=>'Semi-Customizable Quote IDs','after'=>'<br/>One per line','rows'=>4,'class'=>'no_editor')); ?>
			</div>

			<div class="clear"></div>
			<hr/>



			</div>
			<?= $form->input('setup_charge',array('size'=>4,'default'=>0,'between'=>'<br/>$')); ?>

			<!-- still needed for cart! even if has a parent 
			<div class="noparent" style="<?= !empty($this->data['Product']['parent_product_type_id']) ? "display:none;":"" ?>">
			-->
			<h4>Thumbnail:</h4>
			<? if(!empty($this->data['Product']['code'])) { ?>
				<img src="/images/products/thumbnail/<?= $this->data['Product']['code'] ?>.png?rand=<?= time() ?>"/>
			<? } ?>
			<?= $form->input('thumbnail.file', array('type'=>'file','label'=>'Image')); ?>
			<br/>
			JPEG Format only (no transparent backgrounds)
			<!--
			</div>
			-->

		</td>
		<td>
			<div class="noparent" style="<?= !empty($this->data['Product']['parent_product_type_id']) ? "display:none;":"" ?>">
			<?= $form->input('prod',array('label'=>'URL','size'=>12,'between'=>'http://harmonydesigns.com/details/','after'=>'.php')); ?>
			<br/>

			<?= $form->input('page_title',array('label'=>'Browser Title')); ?>

			<?= $form->input('meta_keywords',array('class'=>'no_editor')); ?>
			<?= $form->input('meta_desc',array('class'=>'no_editor','label'=>'Meta Description')); ?>

			<?= $form->input('body_title',array('label'=>'Page Title')); ?>

			<hr/>
			<div id="madeInUsaText" style="<?= empty($this->data['Product']['made_in_usa']) ? "display:none;":""?>">
				<?= $form->input('made_in_usa_text'); ?>
			<hr/>
			</div>
			<table width="100%"><tr>
			<td width="50%" valign="top">
				<?= $form->input('description',array('label'=>'Overview')) ?>
			</td><td>
				<?= $form->input('free_with_your_order') ?>
			</td>
			</tr></table>

			<?= $this->element("../products/admin_descriptions"); ?>

			<hr/>

			<?= $this->Html->link("SHOW OLD CONTENT", "javascript:void(0)", array('onClick'=>"j('#oldcontent').show();", 'class'=>'red')); ?>

			<div id="oldcontent" style="display:none;">
				<?= $form->input('main_intro',array('label'=>'Introduction')); ?>
				<?= $form->input('main_desc',array('label'=>'OLD "Learn More" ','after'=>'<br/>(ignored if Introduction above has line break)')); ?>
			</div>

			</div>

			<?= $form->input('build_notes',array('label'=>'<img src="/images/icons/info.png"> Style description/notes for Build Page')) ?>
		</td>

		<td>
			<div id="parts" class="custom" style="padding: 5px 20px; <?= !empty($this->data['Product']['is_stock_item']) ? "display:none;": "" ?>">
				<?
					$partIDByCode = !empty($this->data['ProductPart']) ? Set::combine($this->data['ProductPart'], "{n}.Part.part_code", "{n}.product_part_id") : array();
					$partValueByCode = !empty($this->data['ProductPart']) ? Set::combine($this->data['ProductPart'], "{n}.Part.part_code", "{n}.optional") : array();
					#print_r($this->data['ProductPart']);
					#print_r($this->data['Part']);
					#print_r($partIDByCode);
				?>

				<? for($i = 0; $i < count($parts); $i++) { 
					$part = $parts[$i];
					$part_code = $part['Part']['part_code'];
					$product_part_id = !empty($partIDByCode[$part_code]) ? $partIDByCode[$part_code] : null;
					$part_value = !empty($partValueByCode[$part_code]) ? $partValueByCode[$part_code] : null;
					$onChange = null;
					if($part_code == 'quote')
					{
						$onChange = "if(this.value != 'None') { j('.quote').show(); } else { j('.quote').hide(); }";
						if(empty($this->data['Product']['product_type_id'])) { 
							$part_value = 'no';
						}
					} else if($part_code == 'personalization') {
						$onChange = "if(this.value != 'None') { j('.pers').show(); } else { j('.pers').hide(); }";
						if(empty($this->data['Product']['product_type_id'])) { 
							$part_value = 'no';
						}
					}
					#echo "PC=$part_code, PPID=$product_part_id, PV=$part_value, DEF=$default, ";
				?>
				<div class="left" style="width: 200px;">
					<input type="hidden" name="data[ProductPart][<?=$i?>][product_part_id]" value="<?= $product_part_id ?>"/>
					<input type="hidden" name="data[ProductPart][<?=$i?>][part_id]" value="<?= $part['Part']['part_id'] ?>"/>
					<div class="input select">
						<label><?= $part['Part']['part_name'] ?></label>
						<select name="data[ProductPart][<?=$i?>][optional]" onChange="<?= $onChange ?>">
							<option <?= empty($part_value) ? "selected='selected'" : "" ?> value="">-</option>
							<option <?= !empty($part_value) && $part_value == 'no' ? "selected='selected'" : "" ?> value="no">Included</option>
							<option <?= !empty($part_value) && $part_value == 'yes' ? "selected='selected'" : "" ?> value="yes">Optional/extra</option>
						</select>
					</div>
				</div>
				<div class="left">
					<? if($part_code == 'quote') { ?>
					<div class="quote" style="<?= !isset($this->data['ProductPart'][$i]['optional']) || $this->data['ProductPart'][$i]['optional'] != 'None' ? "":"display:none;" ?>">
						<?= $form->input('quote_limit',array('default'=>'300','label'=>'Quote/Text Limit','size'=>4,'div'=>array('class'=>'required text input'))) ?>
					</div>
					<? } else if($part_code == 'personalization') { ?>
					<div class="pers" style="<?= !isset($this->data['ProductPart'][$i]['optional']) || $this->data['ProductPart'][$i]['optional'] != 'None' ? "":"display:none;" ?>">
						<?= $form->input('personalizationLimit',array('default'=>'30','label'=>'Personalization Limit','size'=>3,'div'=>array('class'=>'required text input'))) ?>
					</div>
					<? } ?>
				</div>
				<div class="clear"></div>
				<? } ?>
			</div>
		</td>


		<td>
			<?= $form->input('minimum',array('default'=>1,'size'=>3,'div'=>array('class'=>'input text left'),'onChange'=>"j('#ProductPricing0Quantity').val(this.value)")) ?>
			<?= $form->input('pricing_name',array('size'=>15,'label'=>'Pricing Chart Name', 'div'=>array('class'=>'input text left'))); ?>
			<?= $form->input('pricing_description',array('size'=>15,'label'=>'Pricing Chart Description', 'div'=>array('class'=>'input text left'))); ?>
			<?#= $form->input('pricing_description',array('after'=>'<br/>Description on pricing chart')) ?>
			<div class="clear"></div>

			<hr/>

			<?
				$pricingCount = !empty($this->data['ProductPricing']) ? count($this->data['ProductPricing'])+1 : 5;
			?>

			<?= $form->input("free_shipping", array('label'=>"Free ground shipping on orders > $".$config['free_ground_shipping_minimum'])); ?>

			<h4> Pricing Chart </h4>

				<table width="75%">
				<tr>
					<th>Quantity</th>
					<th>Price</th>
				</tr>
				<? for($i = 0; $i < $pricingCount; $i++) { ?>
				<tr>
					<td>
						<?
						$onChange = ($i == 0 ? "j('#ProductMinimum').val(this.value)" : "");
						$default = ($i == 0 ? 1 : null);
						?>
						<?= $form->hidden("ProductPricing.$i.price_point_id"); ?>
						<?= $form->hidden("ProductPricing.$i.product_type_id"); ?>
						<?= $form->input("ProductPricing.$i.quantity",array('size'=>5,'onChange'=>$onChange,'default'=>$default)); ?>
					</td>
					<td>
						<?= $form->input("ProductPricing.$i.price",array('size'=>6)); ?>
					</td>
				</tr>
				<? } ?>
				</tr>
				</table>

				<? if(!empty($relatedProducts)) { ?>
				<? foreach($relatedProducts as $rp) { ?>
					<a href="/admin/products/edit/<?= $rp['Product']['product_type_id'] ?>"><?= $rp['Product']['name'] ?> Pricing</a><br/>
				<? } ?>
				<br/>
				<? } ?>
				
			<hr/>

			<? if($product['Product']['code'] == 'TS') { ?>
			<h4>Surcharge</h4>
			<table>
			<tr> <td> <?= $form->input("surcharge_YS"); ?> </td> </tr>
			<tr> <td> <?= $form->input("surcharge_YM"); ?> </td> </tr>
			<tr> <td> <?= $form->input("surcharge_YL"); ?> </td> </tr>
			<tr> <td> <?= $form->input("surcharge_YXL"); ?> </td> </tr>

			<tr> <td> <?= $form->input("surcharge_S"); ?> </td> </tr>
			<tr> <td> <?= $form->input("surcharge_M"); ?> </td> </tr>
			<tr> <td> <?= $form->input("surcharge_L"); ?> </td> </tr>
			<tr> <td> <?= $form->input("surcharge_XL"); ?> </td> </tr>

			<tr> <td> <?= $form->input("surcharge_XXL"); ?> </td> </tr>
			<tr> <td> <?= $form->input("surcharge_XXXL"); ?> </td> </tr>
			</table>
			<? } ?>

			<h4>MYOB Account IDs</h4>
			<div class="green">Required for importing orders</div>

			<?= $form->input('income_acct',array('div'=>array('class'=>'input text required left'), 'size'=>6)) ?>
			<?= $form->input('cust_invoice_acct',array('div'=>array('class'=>'input text required left'), 'size'=>6)) ?>

			<div class="clear"></div>

			<hr/>
			<h4>Production</h4>
			<?= $form->input('production_quantity_per_day',array('size'=>5,'default'=>100,'label'=>'Production Speed','after'=>'daily','div'=>array('class'=>'input text left'))) ?>
			<?= $form->input('rush_quantity_per_day',array('size'=>5,'default'=>200,'label'=>'Rush Production Speed','after'=>'daily','div'=>array('class'=>'input text left'))) ?>
			<?= $form->input('rush_cost_percentage',array('size'=>4,'label'=>'Rush Surcharge', 'default'=>25,'after'=>'%','div'=>array('class'=>'input text left'))) ?>
			<div class="clear"></div>
		</td>
	</tr>
	<tr>
		<td colspan=4 align="right">
			<?= $form->submit('Save Changes'); ?>
		</td>
	</tr>
	<tr>
		<? $product_id = !empty($product['Product']['product_type_id']) ? $product['Product']['product_type_id'] : null; ?>
		<? if(!empty($product_id)) { ?>
		<td colspan=4>
			<a name="sample_gallery">&nbsp;</a>
			<?= $this->requestAction("/admin/product_sample_images/index/{$product['Product']['product_type_id']}", array('return')); ?>

		<? if(!empty($relatedProducts)) { ?>
			<? foreach($relatedProducts as $rp) { ?>
				<?= $this->requestAction("/admin/product_sample_images/index/{$rp['Product']['product_type_id']}", array('return')); ?>
			<? } ?>
		<? } ?>

		</td>
		<? } ?>

	</tr>
</table>

</div>
<?= $form->end(); ?>

<? /* ?>

<hr/>

<?= $this->element("admin/products/nav"); ?>


<table width="100%">
<tr><td>
	<fieldset>
	<?php echo $form->create('Product');?>
	<table>
	<?php
		echo $form->input('product_type_id');

		$child_product_links = array();

		if(!empty($this->data['AllRelatedProducts']))
		{
			foreach($this->data['AllRelatedProducts'] as $child_product)
			{
				$child_product_links[] = $html->link($child_product['name'], array('admin'=>true, 'action'=>'edit',$child_product['product_type_id']),array('target'=>'new'));
			}
		}

		$parent_product_link = $this->data['Product']['parent_product_type_id'] ? $html->link("Edit Parent", array('admin'=>true, 'action'=>'edit',$this->data['Product']['parent_product_type_id']),array('target'=>'new')) : "";

		echo $html->tableCells(array(
			array(
				$form->input('name',array('after'=>'<br/>name within product list'))."<br/><br/>".
				$form->input('product_category_id',array('options'=>$product_categories,'empty'=>'None')),
				$form->input('code',array('label'=>'Product Code')).
				$form->input('image_and_text') . 
				$form->input('imageonly') . 
				$form->input('fullbleed',array('label'=>'Default to full bleed (vs fit) on image-only')) .
				$form->input('textonly',array('label'=>'Allow text-only')).
				$form->input('income_acct',array('after'=>'REQUIRED for MYOB item import','div'=>array('class'=>'input text required'))) .
				$form->input('cust_invoice_acct',array('after'=>'REQUIRED for MYOB item import','div'=>array('class'=>'input text required'))) .
				$form->input('free_sample'),
				$form->input('description',array('label'=>'Overview')).
				$form->input('free_with_your_order'),
			),
			array(
				$form->input('parent_product_type_id',array('options'=>$parent_product_types, 'label'=>'Parent Product','after'=>'<br/>If selected, this product will only show up on the parent details page')) . 
				$parent_product_link . 
				"<br/><br/><div><label>Related/Child Products</label>".join("<br/>", $child_product_links)."</div>",

				$form->input('prod',array('label'=>'URL Name','after'=>'<br/>All lowercase, no spaces. Affects where gallery is located. <b>REQUIRED</b>')),
				#array($form->input('description'), array('rowspan'=>2)),
				#array(
					#$form->input('CustomizationOptions.CustomizationOptions',array('label'=>'Customization/Parts', 'type'=>'select','multiple'=>'checkbox','options'=>$product_parts)), array('rowspan'=>2)),
				#$form->input('CustomizationOptions.CustomizationOptions'),
			),
			array(
				#$form->input('width',array('after'=>'<br/>of product, in mm')) .
				$form->input('width_in',array('after'=>'<br/>of product, in in')),
				#$form->input('height',array('after'=>'<br/>of product, in mm')) .
				$form->input('height_in',array('after'=>'<br/>of product, in in')),
				$form->input('minimum'),
			),
			array(
				#$form->input('weight',array('after'=>'<br/>of product, in grams<br/><b>REQUIRED for shipping</b>')) .
				$form->input('weight_oz',array('after'=>'')) .
				$form->input('weight_oz_count',array('options'=>array(1=>1,10=>10,100=>100,1000=>1000), 'after'=>'')),

				$form->input('pricing_name',array('after'=>'<br/>Name on pricing chart')) . "<br/>".
				$form->input('pricing_description',array('after'=>'<br/>Description on pricing chart')) . "<br/>".
				$form->input('short_name',array('label'=>'Common Name','after'=>'<br/>Generic descriptive name for all related products (ie "Paperweight")')) ,
				#$form->input('base_price',array('between'=>'$')).
				$form->input('choose_index',array('label'=>'Comparison Order'))
			),
			array(
				$form->input('quote_limit',array('after'=>'')),
				$form->input('personalizationLimit',array('after'=>''))
			),
			array(
				array( '<hr/>', array('colspan'=>3),),
			),
			array(
				array(
					(isset($this->data['Product']['parent_product_type_id']) && 
					$this->data['Product']['parent_product_type_id'] != null) ? 
					"<b>As this is a sub-product of another product, the information below is purely optional</b>" : "&nbsp;",

					array('colspan'=>3),
				),
			),
			array(
				$form->input('buildable',array('options'=>array('yes'=>'Yes','no'=>'No'),'after'=>"<br/>can be selected to enable Create button on details/parent page")),
				$form->input('available',array('options'=>array('yes'=>'Yes','no'=>'No'))),
				$form->input('is_stock_item',array())
			),
			array(
				#$form->input('popularity', array('options'=>$popularity_ranking_options)),
				$form->input('made_in_usa',array('options'=>array('No','Yes'),'after'=>'<br/>Country of origin of materials')).
				$form->input('is_popular',array()),
				$form->input('sort_index',array('after'=>'<br/>sort order on grid (lower number = nearer to top)')),
			),
			array(
				array($form->input('page_title',array('label'=>'Browser Title','after'=>'<br/>Browser window title')), array('class'=>'','after'=>'<br/>Browser window title')),
				array($form->input('body_title',array('label'=>'Page Header')), array('class'=>'')),
			),
			array(
				array($form->input('meta_keywords',array('class'=>'no_editor', 'rowspan'=>3)), array('rowspan'=>1)),
				array($form->input('meta_desc',array('class'=>'no_editor', 'rowspan'=>3)), array('rowspan'=>1)),
				array($form->input('build_notes',array('class'=>'', 'rowspan'=>3)), array('rowspan'=>1)),
			),
			array(
				array( '<hr/>', array('colspan'=>3),),
			),
			array(
				array($form->input('main_intro',array('label'=>'Introduction','after'=>'<br/>First paragraph')), array('rowspan'=>1,'after'=>'<br/>First paragraph')),
				array($form->input('main_desc',array('label'=>'Description','after'=>'<br/>Description bullet list')), array('rowspan'=>1,'after'=>'<br/>First bullet list, one per line')),
				$form->input('secondary_desc',array('label'=>'Options List')),
			),
			array(
				$form->input('quality_desc',array('label'=>'Quality Guarantee')),
				$form->input('normal_ship_time_days',array()) .  $form->input('max_per_10_days',array('label'=>'Qty. Processing','after'=>'<br/>How many can ship within 7-10 days')),

				$form->input('wholesale_info')
			),
		));
		#$form->input('plural_name'),
		#$form->input('rank'),
		#$form->input('image_type'),
	?>
	</table>
	<?php echo $form->end('Submit');?>
	</fieldset>
</td>
</tr>
</table>
</div>

<? 
#echo $this->element("admin/products/pricing_list", $this->viewVars); 
?>

<table border=1 width="100%">
<tr>
	<td>
		<? #echo $this->element("admin/products/product_diagram", $this->viewVars); ?>
	</td>
	<td>
	</td>
</tr>
</table>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Product.product_type_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Product.product_type_id'))); ?></li>
		<li><?php echo $html->link(__('List Products', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Product Customization Options', true), array('controller'=> 'product_customization_options', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product Customization Option', true), array('controller'=> 'product_customization_options', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Product Pricings', true), array('controller'=> 'product_pricings', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product Pricing', true), array('controller'=> 'product_pricings', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Product Testimonials', true), array('controller'=> 'product_testimonials', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product Testimonial', true), array('controller'=> 'product_testimonials', 'action'=>'add')); ?> </li>
	</ul>
</div>

<? */ ?>
