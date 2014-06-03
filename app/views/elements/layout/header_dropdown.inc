			<table width="100%" id="prinav_wrapper" cellspacing=0 cellpadding=0 style="height: 32px;"> <tr><td style="height: 32px;">
			<div class="">
				<table class="dropdown_nav" id="prinav" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="dropdown_nav_button_left"><a href="/">Home</a></td>
					<td class="dropdown_nav_button" onMouseOver="$('dropdown_nav_submenu_products').removeClass('dropdown_nav_submenu_hidden');" onMouseOut="$('dropdown_nav_submenu_products').addClass('dropdown_nav_submenu_hidden');">
						<a href="/">Products</a>
						<table id="dropdown_nav_submenu_products" class="dropdown_nav_submenu dropdown_nav_submenu_hidden" border=0>
						<tr>
							<td class="dropdown_nav_subbutton_left"><a href="/details/bookmark.php">Bookmarks</a></td>
							<td class="dropdown_nav_subbutton"><a href="/details/postcard.php">Postcards</a></td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton_left"><a href="/details/paperweight.php">Glass Paperweights</a></td>
							<td class="dropdown_nav_subbutton"><a href="/details/puzzle.php">Puzzles</a></td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton_left"><a href="/details/magnet.php">Magnets</a></td>
							<td class="dropdown_nav_subbutton"><a href="/details/customruler.php">Rulers (Custom)</a></td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton_left"><a href="/details/mug.php">Mugs</a></td>
							<td class="dropdown_nav_subbutton"><a href="/details/stamp-on-card.php">Stamps on Cards</a></td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton_left"><a href="/details/keychain.php">Keychains</a></td>
							<td class="dropdown_nav_subbutton"><a href="/details/t-shirt.php">T-Shirts</a></td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton_left"><a href="/details/framedstamp.php">Framed Stamps</a></td>
							<td class="dropdown_nav_subbutton"><a href="/details/totebag.php">Tote Bags</a></td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton_left"><a href="/details/bagtag.php">Luggage Tags</a></td>
							<td class="dropdown_nav_subbutton"><b>Stock Items:</b></td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton_left">&nbsp;</td>
							<!--<td class="dropdown_nav_subbutton_left"><a href="/details/mousepad.php">Mousepads</a></td>-->
							<td class="dropdown_nav_subbutton"><a href="/details/ruler.php">Presidents Rulers</a></td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton_left"><a href="/details/ornament.php">Ornaments</a></td>
							<td class="dropdown_nav_subbutton"><a href="/details/paperweightkit.php">Blank Paperweight Kits</a></td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton_left"><a href="/details/pin.php">Pins and Tie Tacks</a></td>
							<td class="dropdown_nav_subbutton"><a href="/details/tassel.php">Bookmark Tassels</a></td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton_left"><a href="/details/poster.php">Posters</a></td>
							<td class="dropdown_nav_subbutton"><a href="/details/charm.php">Charms</a></td>
						</tr>
						</table>
						<div class="clear"></div>



		
					</td>
					<!--
					<td class="dropdown_nav_button" onMouseOver="$('dropdown_nav_submenu_gallery').removeClass('dropdown_nav_submenu_hidden');" onMouseOut="$('dropdown_nav_submenu_gallery').addClass('dropdown_nav_submenu_hidden');">
						<a href="/product/browse.php">Image Gallery</a>
						<table id="dropdown_nav_submenu_gallery" class="dropdown_nav_submenu dropdown_nav_submenu_hidden" border=0>
						<?
							include_once("relatedSubjects.inc");
							global $database;
							$toplevel_categories = getSubjectSubcategories(1, $database);
							$i = 0;
							foreach($toplevel_categories as $category)
							{
								$topbutton = $i++ > 0 ? "" : "dropdown_nav_subbutton_top";
							?>
							<tr>
								<td class="dropdown_nav_subbutton <?= $topbutton ?>">
									<a href="/product/browse.php?nav=subject&browseNode=<?= $category['browse_node_id'] ?>&resultOffset=1"><?= $category['browse_name'] ?></a>
								</td>
							</tr>
							<?
							}


						?>
						</table>
					</td>
					-->
					<td class="dropdown_nav_button"> <a href="/info/testimonials.php">Testimonials</a> </td>
					<td class="dropdown_nav_button"> <a href="/info/quantityPricing.php">Pricing</a> </td>
					<td class="dropdown_nav_button" onMouseOver="$('dropdown_nav_submenu_faq').removeClass('dropdown_nav_submenu_hidden');" onMouseOut="$('dropdown_nav_submenu_faq').addClass('dropdown_nav_submenu_hidden');">
						<a href="/info/faq.php">FAQ</a>
						<table id="dropdown_nav_submenu_faq" class="dropdown_nav_submenu dropdown_nav_submenu_hidden" border=0>
						<tr>
							<td class="dropdown_nav_subbutton_top">
								<a href="/info/faq.php">General</a>
							</td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton">
								<a href="/info/shippingCalculator.php">Shipping Calculator</a>
							</td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton">
								<a href="/custom/designServices.php">Design Services</a>
							</td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton">
								<a href="/info/faq.php#production">Production Time</a>
							</td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton">
								<a href="/info/guarantee.php">Guarantee</a>
							</td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton">
								<a href="/info/security.php">Security</a>
							</td>
						</tr>
						<tr>
							<td class="dropdown_nav_subbutton">
								<a href="/info/privacy.php">Privacy Policy</a>
							</td>
						</tr>
						</table>
					</td>
					<!--
					<td class="dropdown_nav_button"><a href="/info/testimonials.php">Testimonials</a></td>
					-->
					<td class="dropdown_nav_button"><a href="/info/contact_us.php">Contact Us</a></td>
					<td class="dropdown_nav_button"><a href="/info/about.php">About Us</a></td>
				</tr>
				</table>
			</div>
			</td>
			<td style="white-space: nowrap;">
        		<form action="/product/search.php" method="get"  id="sidebarSearch" name="searchform" onsubmit="return preflightSearch();">
          <input type="text" id="header_search_field" name="q" value="<?= $_SESSION['searchString']?>" />
	  <input type="submit" name="submit" value="Search"/>
        		</form>
			</td></tr></table>

