<?= $hd->product_element("products/rightbar_top", $product['Product']['prod'], $this->viewVars); ?>

<?= $this->element("sidebars/testimonials", array('testimonials'=>$product['Testimonials'])); ?>
