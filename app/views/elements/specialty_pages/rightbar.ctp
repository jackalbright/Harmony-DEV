<? echo $this->element("specialty_pages/sample_gallery",$this->viewVars); ?>
<? echo $this->element("specialty_pages/links",$this->viewVars); ?>

<? if (isset($specialtyPage['Testimonials'])) { echo $this->element("sidebars/testimonials", array('testimonials'=>$specialtyPage['Testimonials'])); } ?>
