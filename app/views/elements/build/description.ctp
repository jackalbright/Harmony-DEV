				<div class="right">
					<a href="/products/select?new=1">select a different product</a>
				</div>
				<h4><?= $product_name ?> Details:</h4>
				<div style="padding-left: 0px;">
					<? if(!empty($parent_product)) { ?>
						<?= $parent_product['Product']['main_intro'] ?>
					<? } else if (!empty($product['Product'])) { ?>
						<?= $product['Product']['main_intro'] ?>
					<? } else { ?>
					<?= $build['Product']['main_intro'] ?>
					<? } ?>
					<div class="right_align">
					<a href="/details/<?= $build['Product']['prod'] ?>.php">More <?= strtolower($build['Product']['name']) ?> information.
					</div>
				</div>
				<br/>
				<br/>

				<div class="right">
				<a href="/gallery/browse">select a different image</a> or <a href="/custom_images">use your own</a>
				</div>
				<h4>Image Details:</h4>
				<div style="padding-left: 0px;">
				<p>
					<? if(isset($build['CustomImage']['Description'])) { ?>
						<?= $build['CustomImage']['Description'] ?>
					<? } else if (isset($build['GalleryImage']['short_description'])) { ?>
						<?= $build['GalleryImage']['short_description'] ?>

						<br/>
						<div class="right">
						<a href="/gallery/view/<?= $build['GalleryImage']['catalog_number'] ?>">Image information</a>
						</div>
					<? } else { ?>
						<i>No description available</i>
					<? } ?>
				</p>

				</div>
