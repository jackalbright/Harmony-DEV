<div >
<ul id='navcontainer'>
<li class='firstLevel'><a href="javascript:">Products</a>
<ul>
<li><?php echo $html->link("Products", array('controller'=>'products','action'=>'index')); ?></li>
<li><?php echo $html->link("Specialty Product Pages", array('controller'=>'specialty_pages','action'=>'index')); ?></li>
<li><?php echo $html->link("Parts", array('controller'=>'parts','action'=>'index')); ?></li>
<li><?php echo $html->link("Shipping Calculator", array('controller'=>'products','action'=>'shipping')); ?></li>
<li><?php echo $html->link("Handling Fees", array('controller'=>'handling_charges','action'=>'index')); ?></li>
<li><?php echo $html->link("Stamps", array('controller'=>'stamps','action'=>'index')); ?></li>
<li><?php echo $html->link("Coupons", array('controller'=>'coupons','action'=>'index') ); ?></li>
</ul>
</li>

<li class='firstLevel'><a href="javascript:">Customers</a>
<ul>
<li><?php echo $html->link("Customers", array('controller'=>'account','action'=>'index')); ?></li>
<li><?php echo $html->link("Custom Images", array('controller'=>'custom_images','action'=>'index')); ?></li>
<li><?php echo $html->link("Completed Art Submissions", array('controller'=>'completed_projects','action'=>'index')); ?></li>
<li><?php echo $html->link("Abandoned Carts", array('controller'=>'cart','action'=>'index')); ?></li>
<li><?php echo $html->link("Purchases", array('controller'=>'purchases','action'=>'index')); ?></li>
<li><?php echo $html->link("Saved Items", array('controller'=>'saved_items','action'=>'index')); ?></li>
<li><?php echo $html->link("Email Messages", array('controller'=>'email_messages','action'=>'index')); ?></li>
<li class=""><?php echo $html->link("Wholesale Customer Import", array('controller'=>'customers','action'=>'import')); ?></li>
<li class=""><?php echo $html->link("Wholesale Order Import", array('controller'=>'purchases','action'=>'import')); ?></li>
</ul>
</li>
<li class='firstLevel'><a href="javascript:">Requests</a>
<ul>
<li> <?php echo $html->link("Work Requests", array('controller'=>'work_requests','action'=>'index')); ?></li>
<li> <?php echo $html->link("Custom Quote Requests", array('controller'=>'quote_requests','action'=>'index')); ?></li>
<li> <?php echo $html->link("Sample Requests", array('controller'=>'sample_requests','action'=>'index')); ?></li>
<li> <?php echo $html->link("Template Requests", array('controller'=>'template_requests','action'=>'index')); ?></li>
<li> <?php echo $html->link("Specialty Inquiries", array('controller'=>'specialty_page_prospects','action'=>'index')); ?></li>
<li> <?php echo $html->link("FAQ Requests", array('controller'=>'faq_requests','action'=>'index')); ?></li>
</ul>
</li>
<li class='firstLevel'><a href="javascript:">Categorization</a>
<ul>
<li><?php echo $html->link("Product Categories", array('controller'=>'product_categories','action'=>'index')); ?></li>
<li><?php echo $html->link("Stamp/Gallery Categories", array('controller'=>'gallery_categories','action'=>'index')); ?></li>
<li><?php echo $html->link("Charm Categories", array('controller'=>'charm_categories','action'=>'index')); ?></li>
</ul>
</li>
<li class='firstLevel'><a href="javascript:">Credibility</a>
<ul>
<li><?php echo $html->link("Customer Comments/Testimonials", array('controller'=>'testimonials','action'=>'index')); ?></li>
<li><?php echo $html->link("Customer Types (for testimonial categorization)", array('controller'=>'customer_types','action'=>'index')); ?></li>
<li><?php echo $html->link("Client List", array('controller'=>'clients','action'=>'index')); ?></li>
<li><?php echo $html->link("Frequently Asked Questions", array('controller'=>'faqs','action'=>'index')); ?></li>
</ul>
</li>
<li class='firstLevel'><a href="javascript:">Content</a>
<ul>
<li><?php echo $html->link("Purchase Steps", array('controller'=>'purchase_steps','action'=>'index')); ?></li>
<li><?php echo $html->link("Content Snippets", array('controller'=>'content_snippets','action'=>'index')); ?></li>
<li><?php echo $html->link("Custom Web Pages", array('controller'=>'pages','action'=>'index')); ?></li>
<li><?php echo $html->link("Site Stats", array('controller'=>'tracking_requests','action'=>'index')); ?></li>
<li><?php echo $html->link("Click Tracking", array('controller'=>'tracking_links','action'=>'index')); ?></li>
<li><?php echo $html->link("Search Engine Landing Page Visits", array('controller'=>'tracking_requests','action'=>'landing_visits')); ?></li>
</ul>
</li>
<li class='firstLevel'><a href="javascript:">Other</a>
<ul>
<li><?php echo $html->link("Website Settings", array('controller'=>'configs','action'=>'index')); ?></li>
<li><?php echo $html->link("Tips", array('controller'=>'tips','action'=>'index')); ?></li>
</ul>
</li>
</ul>
</div>