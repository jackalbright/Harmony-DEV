<?
$product_name = $product['Product']['name'];
$gallery_title = "Sample " . $product_name;
if (!preg_match("/s$/", $gallery_title)) { $gallery_title .= "s"; }
if ($product['Product']['is_stock_item'])
{
	$gallery_title = "$product_name Ideas";
}

echo $this->element("products/sample_gallery",array('product'=>$product['Product'],'productSampleImages'=>$product['ProductSampleImages'], 'gallery_title'=>$gallery_title));

foreach($product['RelatedProducts'] as $subProduct) 
{ 
	if ($subProduct['available'] == 'yes')
	{
		$product_name = $subProduct['name'];
		$gallery_title = "Sample " . $product_name . "s";
		if ($subProduct['is_stock_item'])
		{
			$gallery_title = "$product_name Ideas" ;
		}
		echo $this->element("products/sample_gallery", array('product'=>$subProduct,'gallery_title'=>$gallery_title));
	}
}
?>

