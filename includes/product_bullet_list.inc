<? function print_product_bullet_list($name = 'Your Custom', $append = '') { ?>

<div>
	<h4>Use <?= $name ?> Images on:</h4>
	<div>
		<a href="/details/bookmark.php?<?=$append?>">Bookmarks</a> &bull;
		<a href="/details/paperweight.php?<?=$append?>">Paperweights</a> &bull;
		<a href="/details/mug.php?<?=$append?>">Mugs</a> &bull;
		<a href="/details/magnet.php?<?=$append?>">Magnets</a> &bull;
		<a href="/details/keychain.php?<?=$append?>">Keychains</a> &bull;
		<a href="/details/framedstamp.php?<?=$append?>">Framed Stamps</a> &bull;
		<a href="/details/luggagetag.php?<?=$append?>">Luggage Tags</a> &bull;
		<a href="/details/ornament.php?<?=$append?>">Ornaments</a> &bull;
		<a href="/details/postcard.php?<?=$append?>">Postcards</a> &bull;
		<a href="/details/poster.php?<?=$append?>">Poster</a> &bull;
		<a href="/details/pin.php?<?=$append?>">Pins/Tie Tacks</a> &bull;
		<a href="/details/puzzle.php?<?=$append?>">Puzzles</a> &bull;
		<a href="/details/ruler.php?<?=$append?>">Custom Rulers</a> &bull;
		<a href="/details/stampcard.php?<?=$append?>">Stamp on Cards</a> &bull;
		<a href="/details/totebag.php?<?=$append?>">Tote Bags</a> &bull;
		<a href="/details/t-shirt.php?<?=$append?>">T-Shirts</a>
	</div>
</div>

<? } ?>
