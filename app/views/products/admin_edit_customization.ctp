<div class="products form">
<?= $this->element("admin/products/nav"); ?>


<table width="100%">
<tr><td>
	<fieldset>
	<?php echo $form->create('Product');?>
	<table>
	<?php
		echo $form->input('product_type_id');

		$child_product_links = array();
		foreach($this->data['AllRelatedProducts'] as $child_product)
		{
			$child_product_links[] = $html->link($child_product['name'], array('admin'=>true, 'action'=>'edit',$child_product['product_type_id']),array('target'=>'new'));
		}

		$parent_product_link = $this->data['Product']['parent_product_type_id'] ? $html->link("Edit Parent", array('admin'=>true, 'action'=>'edit',$this->data['Product']['parent_product_type_id']),array('target'=>'new')) : "";

		echo $html->tableCells(array(
			array(
				$form->input('name',array('after'=>'<br/>name within product list')),
				$form->input('code',array('label'=>'Product Code')),
				array( 
					#$form->input('image_type',array('options'=>$image_types,'multiple'=>'checkbox')), 
					#$form->input('stamp',array('options'=>$stamp_types,'label'=>'Image Types','after'=>'<br/>Both = All, Real = Real Only,<br/> Repro = Repro Only, Custom = Custom Only')),
					$form->input('image_type',array('type'=>'select','options'=>$image_types,'label'=>'Image Types','multiple'=>'checkbox')),
					array('rowspan'=>'1')
				),
			),
			array(
				$form->input('parent_product_type_id',array('options'=>$parent_product_types, 'label'=>'Parent Product','after'=>'<br/>If selected, this product will only show up on the parent details page')) . 
				$parent_product_link . 
				"<br/><br/><div><label>Related/Child Products</label>".join("<br/>", $child_product_links)."</div>",

				$form->input('prod',array('label'=>'URL Name','after'=>'<br/>All lowercase, no spaces. Affects where gallery is located. <b>REQUIRED</b>')),
				#array($form->input('description'), array('rowspan'=>2)),
				array(
					$form->input('CustomizationOptions.CustomizationOptions',array('label'=>'Customization/Parts', 'type'=>'select','multiple'=>'checkbox','options'=>$product_parts)), array('rowspan'=>2)),
				#$form->input('CustomizationOptions.CustomizationOptions'),
			),
			array(
				$form->input('minimum'),
				$form->input('base_price'),
			),
			#array(
			#),
			array(
				#$form->input('width',array('after'=>'<br/>of product, in mm')) .
				$form->input('width_in',array('after'=>'<br/>of product, in in')),
				#$form->input('height',array('after'=>'<br/>of product, in mm')) .
				$form->input('height_in',array('after'=>'<br/>of product, in in')),
			),
			array(
				#$form->input('weight',array('after'=>'<br/>of product, in grams<br/><b>REQUIRED for shipping</b>')) .
				$form->input('weight_oz',array('after'=>'')) .
				$form->input('weight_oz_count',array('options'=>array(1=>1,10=>10,100=>100,1000=>1000), 'after'=>'')),

				$form->input('pricing_name',array('after'=>'<br/>Name on pricing chart')) . "<br/>".
				$form->input('short_name',array('after'=>'<br/>Generic descriptive name for all related products (ie "Paperweight")')) ,
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
				$form->input('is_stock_item',array()),
			),
			array(
				#$form->input('popularity', array('options'=>$popularity_ranking_options)),
				$form->input('made_in_usa',array('options'=>array('1'=>'Yes','2'=>'No'),'after'=>'<br/>Country of origin of materials')),
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
				$form->input('normal_ship_time_days',array()),
				$form->input('max_per_10_days',array('label'=>'Qty. Processing','after'=>'<br/>How many can ship within 7-10 days')),
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
