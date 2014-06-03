<? 
$addClass = "addClassName";
$rmClass = "removeClassName";
?>

			<table id="prinav_wrapper" cellspacing=0 cellpadding=0 style=""> <tr><td style="">
			<div class="">
				<table class="dropdown_nav" id="prinav" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="dropdown_nav_button_left"><a href="/">Home</a></td>
					<td class="dropdown_nav_button relative">
						<div class="dropdown">
						<a href="/details">Products</a>

						<?
							$product_categories = get_db_records("product_categories");
							$pc_map = map_db_records($product_categories, "name","product_category_id");
							$custom_products = get_db_records("product_type", array("available"=>'yes','parent_product_type_id IS NULL','product_category_id'=>$pc_map['Custom Products']), "short_name");
							$crafter_products = get_db_records("product_type", array("available"=>'yes','parent_product_type_id IS NULL','product_category_id'=>$pc_map['For Crafters']), "short_name");
							$buyitnow_products = get_db_records("product_type", array("available"=>'yes','parent_product_type_id IS NULL','product_category_id'=>$pc_map['Ready Made']), "short_name");
							$stamp_products = get_db_records("product_type", array("available"=>'yes','parent_product_type_id IS NULL','product_category_id'=>$pc_map['Stamp Products']), "short_name");
						?>
						<table id="dropdown_nav_submenu_products" class="dropdown_nav_submenu dropdown_nav_submenu_hidden" border=0>
						<tr>
							<td valign="top">
								<table>
								<tr>
									<td class="dropdown_nav_subbutton dropdown_subheader top_border bottom_border black_border">Custom Products</td>
								</tr>
								<? foreach($custom_products as $cp) { ?>
								<tr>
									<td class="dropdown_nav_subbutton">
										<a href="/details/<?= $cp['prod'] ?>.php"><?= ucwords(pluralize(preg_replace("/^Custom/", "", $cp['short_name']))); ?></a>
									</td>
								</tr>
								<? } ?>
								</table>
							</td>
							<td class="left_border black_border" valign="top">
								<table>
								<tr>
									<td class="dropdown_nav_subbutton dropdown_subheader bold top_border bottom_border black_border">Do-It-Yourself</td>
								</tr>
								<? foreach($crafter_products as $cp) { ?>
								<tr>
									<td class="dropdown_nav_subbutton">
										<a href="/details/<?= $cp['prod'] ?>.php"><?= ucwords(pluralize($cp['short_name'])); ?></a>
									</td>
								</tr>
								<? } ?>
								</table>

								<? /*
								<table>
								<tr>
									<td class="dropdown_nav_subbutton black_text bold top_border bottom_border black_border">Stamp Products</td>
								</tr>
								<? foreach($stamp_products as $cp) { ?>
								<tr>
									<td class="dropdown_nav_subbutton">
										<a href="/details/<?= $cp['prod'] ?>.php"><?= ucwords(pluralize($cp['short_name'])); ?></a>
									</td>
								</tr>
								<? } ?>
								</table>
								*/ ?>

								<table>
								<tr>
									<td class="dropdown_nav_subbutton dropdown_subheader bold top_border bottom_border black_border">Ready Made</td>
								</tr>
								<? foreach($buyitnow_products as $cp) { ?>
								<tr>
									<td class="dropdown_nav_subbutton">
										<a href="/details/<?= $cp['prod'] ?>.php"><?= ucwords(pluralize($cp['short_name'])); ?></a>
									</td>
								</tr>
								<? } ?>
								</table>

								<table>
								<tr>
									<td class="dropdown_nav_subbutton dropdown_subheader bold top_border bottom_border black_border">Stamp Products</td>
								</tr>
								<? foreach($stamp_products as $cp) { ?>
								<tr>
									<td class="dropdown_nav_subbutton">
										<a href="/details/<?= $cp['prod'] ?>.php"><?= ucwords(pluralize($cp['short_name'])); ?></a>
									</td>
								</tr>
								<? } ?>
								</table>
							</td>
						</tr>
						</table>

						<div class="clear"></div>

						</div>



		
					</td>
					<td class="dropdown_nav_button">
						<div class="dropdown">
						<?
							$subjects = get_db_records("browse_node", " parent_node = 1 ", "browse_name");
						?>
						<a href="/gallery/browse">Stamp Subjects</a>
						<table id="dropdown_nav_submenu_subjects" class="dropdown_nav_submenu dropdown_nav_submenu_hidden" border=0>
						<? foreach($subjects as $subject) { ?>
						<tr>
							<td class="dropdown_nav_subbutton">
								<a href="/gallery/browse/<?= preg_replace("/ /", "_", $subject['browse_name']); ?>"><?= $subject['browse_name'] ?></a>
							</td>
						</tr>
						<? } ?>
						</table>
						</div>
					</td>
					<td class="dropdown_nav_button"> <a href="/info/testimonials.php">Reviews</a> </td>
					<td class="dropdown_nav_button"> <a href="/products/quantityPricing?prod=<?= !empty($product['Product']['code']) ? $product['Product']['code'] : (!empty($product['code']) ? $product['code']:null) ?>">Pricing</a> </td>
					<td class="dropdown_nav_button"> 
						<a href="/info/shippingCalculator.php">Shipping</a>
					</td>
					<td class="dropdown_nav_button">
						<div class="dropdown">
						<a href="/info/faq.php">FAQ</a>
						<table id="dropdown_nav_submenu_faq" class="dropdown_nav_submenu dropdown_nav_submenu_hidden" border=0>
						<tr>
							<td class="dropdown_nav_subbutton_top">
								<a href="/info/faq.php">General</a>
							</td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton">
								<a href="/services">Design Services</a>
							</td>
						</tr>
						<!--
						<tr>
							<td class="dropdown_nav_subbutton">
								<a href="/info/faq.php#production">Production Time</a>
							</td>
						</tr>
						-->
						<tr>
							<td class="dropdown_nav_subbutton">
								<a href="/guarantee">Guarantee / Returns</a>
							</td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton">
								<a href="/security">Security</a>
							</td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton">
								<a href="/privacy">Privacy Policy</a>
							</td>
						</tr>
						</table>

						</div>
					</td>
					<!--
					<td class="dropdown_nav_button"><a href="/info/testimonials.php">Testimonials</a></td>
					-->
					<td class="dropdown_nav_button"><a href="/info/contact_us.php">Contact Us</a></td>
					<td class="dropdown_nav_button" style="border-right: solid #333 1px;"><a href="/about">About Us</a></td>
				</tr>
				</table>
			</div>
			</td>
			</tr></table>


			<? if(!constant("APP")) { # Not cake, old page.... ?>

			<script src="/js/jquery-1.6.min.js"></script>
			<script>
				j = jQuery.noConflict();
			</script>

			<? } ?>

			<script>
			j(document).ready(function() {
				j('div.dropdown').hover(
					function() { j(this).find('table.dropdown_nav_submenu').removeClass('dropdown_nav_submenu_hidden'); },
					function() { j(this).find('table.dropdown_nav_submenu').addClass('dropdown_nav_submenu_hidden'); }
				);
			});
			</script>
