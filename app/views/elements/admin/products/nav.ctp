<br/>
<br/>

<? 
if (!empty($this->data['Product'])) { 
	$product = $this->data;
}
if (empty($product)) { ?>
New Product
<? } else { ?>
<div>
	<b><?= $product['Product']['name']?>:</b>
	<a target="_new" href="/products/view/<?=$product['Product']['prod']?>">View</a> | 
	<a href="/admin/products/edit/<?=$product['Product']['product_type_id']?>">Edit</a> |
	<a href="/admin/product_parts/edit_list/<?=$product['Product']['product_type_id']?>">Customization Options</a> |
	<a href="/admin/product_pricings/edit_list/<?=$product['Product']['product_type_id']?>">Pricing Discount</a> |
	<a href="/admin/products/testimonials/<?=$product['Product']['product_type_id']?>">Testimonials</a> |
	<a href="/admin/products/image_upload/<?=$product['Product']['product_type_id']?>">Product Thumbnail/Diagram</a> |
	<a href="/admin/product_sample_images/index/<?=$product['Product']['product_type_id']?>">Sample Gallery</a> |
	<a href="/admin/product_quotes/index/<?=$product['Product']['product_type_id']?>">Product Quotes</a> |
	<a href="/admin/faqs/product/<?=$product['Product']['code']?>">Common Questions</a> |
	<a href="/admin/product_options/edit/<?=$product['Product']['product_type_id']?>">Comparison Chart</a>
</div>
<? } ?>
