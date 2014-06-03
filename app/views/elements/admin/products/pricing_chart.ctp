<?
# Create 

echo $form->create("ProductPricing");
echo $form->hidden("ProductPricing.0.product_id", array("value"=>$this->data['Product']['product_id']));
echo $form->input("ProductPricing.0.max_quantity", array("value"=>$this->data['Product']['product_id']));
echo $form->input("ProductPricing.0.pricing", array("value"=>$this->data['Product']['product_id']));
echo "<br/>";
?>

WHJATEVER

<?
echo $form->end("Submit");

?>
