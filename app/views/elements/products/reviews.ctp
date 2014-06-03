<table cellpadding=10 width="100%"><tr>
<td width="450" valign="top">
	<h3>Customer Reviews</h3>

	<?= $this->element("products/testimonials", array('testimonials'=>$product['Testimonials'])); ?>
</td>
<td valign="top">
	<h3>A Few of Our Customers</h3>

	<?= $this->element("clients/clientlist", array('clients'=>$client_list,'vertical'=>1,'bare'=>1)); ?>
</td>
</tr></table>
