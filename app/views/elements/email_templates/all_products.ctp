<?

if(!empty($this->data['EmailMessage']['catalog_number']))
{
	$imgtype = 'Gallery';
	$imgid = $this->data['EmailMessage']['catalog_number'];
} 
else if(!empty($this->data['EmailMessage']['image_id']))
{
	$imgtype = 'Custom';
	$imgid = $this->data['EmailMessage']['image_id'];
}
else 
{
	$imgtype = 'Gallery';
	$imgid = 'C68';
}

echo $this->requestAction("/admin/products/product_grid/$imgtype/$imgid",array('return','data'=>$this->data)); 

?>

