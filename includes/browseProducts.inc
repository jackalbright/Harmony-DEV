<?


$addClass = "addClassName";
$rmClass = "removeClassName";
if (empty($prototype_js)) { 
	?> <script src="/js/scriptaculous/prototype.js" type="text/javascript"></script> <?
} ?>
<div class="sidebar_block">
	<div class="hidden sidebar_header">Products:</div>
	<div class="sidebar_content">
	<ul class="product_links">
		<?
			$categories = get_db_records("product_categories", null, "sort_index");
			foreach($categories as $category)
			{
				$pcid = $category['product_category_id'];
			?>
			<li style="border-top: solid black 1px; border-bottom: solid black 1px;">
				<b><?= $category['name'] ?></b>
			</li>
			<?
				$browse_products = get_db_records("product_type", array('available'=>'yes','parent_product_type_id IS NULL', 'product_category_id'=>$pcid), "short_name");
				foreach($browse_products as $bp)
				{
				?>
					<li><a href="/details/<?= $bp['prod'] ?>.php"><?= ucwords(pluralize($bp['short_name'])); ?></a></li>
				<?
				}
			}
		?>
	</ul>


	<ul class="product_links hidden">
		<?
			$custom_products = get_db_records("product_type", array("available"=>"yes","buildable"=>"yes","parent_product_type_id IS NULL", "is_stock_item"=>0), "short_name"); 
			$stock_products = get_db_records("product_type", array("available"=>"yes","is_stock_item"=>1,"parent_product_type_id IS NULL"), "short_name"); 
		?>
		<? foreach($custom_products as $bp) { ?>
			<li><a href="/details/<?= $bp['prod'] ?>.php"><?= ucwords(pluralize($bp['short_name'])); ?></a></li>
		<? } ?>

		<li>&nbsp;</li>
		<li><b>For Crafters:</b></li>
		<? foreach($stock_products as $sp) { ?>
			<li><a href="/details/<?= $sp['prod'] ?>.php"><?= ucwords(pluralize($sp['short_name'])); ?></a></li>
		<? } ?>
	</ul>

	<ul class="hidden product_links">
		<li><a href="/details/bookmark.php">Bookmarks</a></li> 
		<li><a href="/details/paperweight.php">Paperweights</a></li> 
		<li><a href="/details/mousepad.php">MousePads</a></li> 
		<li><a href="/details/mug.php">Mugs</a></li> 
		<li><a href="/details/magnet.php">Magnets</a></li> 
		<li><a href="/details/keychain.php">Keychains</a></li> 
	</ul>
	<ul id="products_other_list" class="hidden product_links Xhidden">
		<li><a href="/details/framedstamp.php">Framed Stamps</a></li> 
		<li><a href="/details/bagtag.php">Luggage Tags</a></li> 
		<li><a href="/details/ornament.php">Ornaments</a></li> 
		<li><a href="/details/postcard.php">Postcards</a></li> 
		<li><a href="/details/poster.php">Poster</a></li> 
		<li><a href="/details/pin.php">Pins/Tie Tacks</a></li> 
		<li><a href="/details/puzzle.php">Puzzles</a></li> 
		<li><a href="/details/customruler.php">Custom Rulers</a></li> 
		<li><a href="/details/stamp-on-card.php">Stamp on Cards</a></li> 
		<li><a href="/details/totebag.php">Tote Bags</a></li> 
		<li><a href="/details/t-shirt.php">T-Shirts</a></li>

		<li>&nbsp;</li>
		<li><b>Stock Items:</b></li>
		<li><a href="/details/tassel.php">Tassels</a></li> 
		<li><a href="/details/paperweightkit.php">Paperweight Kits</a></li> 
		<li><a href="/details/ruler.php">Presidents Rulers</a></li> 
		<li><a href="/details/charm.php">Charms</a></li> 
	</ul>
	</div>
	<!--
	<div class="right_align padded">
	<a id="products_view_more" class="sidebar_more" href="#" onClick="$('products_other_list').<?=$rmClass?>('hidden'); $('products_view_less').<?=$rmClass?>('hidden'); $('products_view_more').<?=$addClass?>('hidden');">view more...</a>
	<a id="products_view_less" class="sidebar_more hidden" href="#" onClick="$('products_other_list').<?=$addClass?>('hidden'); $('products_view_more').<?=$rmClass?>('hidden'); $('products_view_less').<?=$addClass?>('hidden');">view less...</a>
	</div>
	-->
</div>
