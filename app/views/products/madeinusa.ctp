<div>
	<?if(!empty($snippets['made_in_usa'])) { ?>
	<div>
		<?= $snippets['made_in_usa'] ?>
	</div>
	<? } ?>

	<table width="100%" cellspacing=5>
	<? $colsperrow = 2; ?>
	<? $i = 0; foreach($products as $product) { if($product['Product']['made_in_usa'] != 'manufactured') { continue; } ?>
	<? if($i % $colsperrow == 0) { ?>
	<tr>
	<? } ?>
	<td valign="top" style="border: solid #CCC 1px; padding: 10px;" width="<?= 100 / $colsperrow ?>%">
		<div style="float: left; width: 150px;">
			<a href="/details/<?= $product['Product']['prod'] ?>.php">
				<img src="/images/products/thumbnail/<?= $product['Product']['code'] ?>.png"/>
			</a>
		</div>
		<div style="margin-left: 150px;">
			<div class="right"><a href="/details/<?= $product['Product']['prod'] ?>.php"><img alt="Made in USA" src="/images/icons/small/made-in-usa.png"/></a></div>
			<h3><a href="/details/<?= $product['Product']['prod'] ?>.php"><?= $hd->pluralize($product['Product']['short_name']); ?></a></h3>
			<p>
				<?= !empty($product['Product']['made_in_usa_text']) ? $product['Product']['made_in_usa_text'] : null ?>
			</p>
		</div>
		<div class="clear"></div>
	</td>
	<? if($i+1 % $colsperrow == 0) { ?>
	</tr>
	<? } ?>
	<? $i++; } ?>
	</table>

	<h1 id="title"><?= !empty($snippet_titles['designed_in_usa']) ? $snippet_titles['designed_in_usa'] : "Designed in USA"; ?></h1>
	<?if(!empty($snippets['designed_in_usa'])) { ?>
	<div>
		<?= $snippets['designed_in_usa'] ?>
	</div>
	<? } ?>

	<table width="100%" cellspacing=5>
	<? $colsperrow = 2; ?>
	<? $i = 0; foreach($products as $product) { if($product['Product']['made_in_usa'] != 'designed') { continue; } ?>
	<? if($i % $colsperrow == 0) { ?>
	<tr>
	<? } ?>
	<td valign="top" style="border: solid #CCC 1px; padding: 10px;" width="<?= 100 / $colsperrow ?>%">
		<div style="float: left; width: 150px;">
			<a href="/details/<?= $product['Product']['prod'] ?>.php">
				<img src="/images/products/thumbnail/<?= $product['Product']['code'] ?>.png"/>
			</a>
		</div>
		<div style="margin-left: 150px;">
			<!--<div class="right"><a href="/details/<?= $product['Product']['prod'] ?>.php"><img alt="Made in USA" src="/images/icons/small/made-in-usa-grey.png"/></a></div>-->
			<h3><a href="/details/<?= $product['Product']['prod'] ?>.php"><?= $hd->pluralize($product['Product']['short_name']); ?></a></h3>
			<p>
				<?= !empty($product['Product']['made_in_usa_text']) ? $product['Product']['made_in_usa_text'] : null ?>
			</p>
		</div>
		<div class="clear"></div>
	</td>
	<? if($i+1 % $colsperrow == 0) { ?>
	</tr>
	<? } ?>
	<? $i++; } ?>
	</table>
</div>
