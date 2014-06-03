<div id="build_preview_options">

<? if(isset($build['quantity'])) { ?>
<div class="preview_option">
	<div class="preview_option_title"><a href="/build/quantity">Quantity</a></div>
	<div class="preview_option_quantity preview_option_value">
		<?= $build['quantity'] ?>
		<? if(isset($build['quantity_price'])) { ?>
			@ <?= sprintf("$%.02f", $build['quantity_price']); ?> ea =
			<?= sprintf("$%.02f", $build['quantity'] * $build['quantity_price']); ?> total
		<? } ?>
		<br/>
		Minimum: <?= $build["Product"]['minimum'] ?>
		<br/>
		<br/>
		<? if(!empty($stamp_surcharge['StampSurcharge']) && preg_match("/real/", $build["Product"]['image_type'])) { ?>
		<i>Note: 
		Prices may be slightly higher for <a href="/info/about-us.php#StampPrices">rare and high value stamps.</a></i>
		<? } ?>
	</div>
</div>
<? } ?>

<? if(isset($build['options']['quote'])) { ?>
<div class="preview_option">
	<div class="preview_option_title"><a href="/build/step/quote">Quote</a></div>
	<div class="preview_option_quote preview_option_value">
		<? if(!empty($build['options']['quote']['quoteID_data'])) { ?>
			<? if(!empty($build['options']['quote']['quoteID_data']['Quote']['title'])) { ?>
			<div class="quote_title"><b><?= $build['options']['quote']['quoteID_data']['Quote']['title']; ?></b></div>
			<? } ?>
			<div class="quote_text"><?= $build['options']['quote']['quoteID_data']['Quote']['text']; ?></div>
			<? if(!empty($build['options']['quote']['quoteID_data']['Quote']['attribution'])) { ?>
			<div class="quote_attrib"><?= $build['options']['quote']['quoteID_data']['Quote']['attribution']; ?></div>
			<? } ?>
		<? } else if (!empty($build['options']['quote']['customQuote'])) { ?>
			<div class="quote_text"><?= $build['options']['quote']['customQuote']; ?></div>
		<? } else { ?>
			<i>No quote</i>
		<? } ?>
	</div>
</div>
<? } ?>

<? if(isset($build['options']['border'])) { ?>
<div class="preview_option">
	<div class="preview_option_title"><a href="/build/step/border">Border</a></div>
	<div class="preview_option_quote preview_option_value">
		<? if(!empty($build['options']['border']['borderID_data'])) { ?>
			<a href="/build/step/border">
			<img src="<?= $build['options']['border']['borderID_data']['Border']['location']?>"/>
			</a>
			<br/>
			<?= $build['options']['border']['borderID_data']['Border']['name']?>
		<? } else if ($build['options']['border']['borderID'] == 'None') { ?>
			None
		<? } ?>
	</div>
</div>
<? } ?>

<table border=0 cellpadding=0 cellspacing=0>
<tr>

<? if(isset($build['options']['tassel'])) { ?>
<td width="50%">
<div class="preview_option">
	<div class="preview_option_title"><a href="/build/step/tassel">Tassel</a></div>
	<div class="preview_option_quote preview_option_value">
		<? if(!empty($build['options']['tassel']['tasselID_data'])) { ?>
			<a href="/build/step/tassel">
			<img height="50" src="/tassels/thumbs/<?= preg_replace("/ /", "-", $build['options']['tassel']['tasselID_data']['Tassel']['color_name'])?>.gif"/>
			</a>
			<br/>
			<?= ucwords($build['options']['tassel']['tasselID_data']['Tassel']['color_name']) ?>
		<? } ?>
	</div>
</div>
</td>
<? } ?>

<? if(isset($build['options']['charm'])) { ?>
<td width="50%">
<div class="preview_option">
	<div class="preview_option_title"><a href="/build/step/charm">Charm</a></div>
	<div class="preview_option_quote preview_option_value">
		<? if(!empty($build['options']['charm']['charmID_data'])) { ?>
			<a href="/build/step/charm">
			<img height="50" src="<?= $build['options']['charm']['charmID_data']['Charm']['graphic_location']?>"/>
			</a>
			<br/>
			<?= ucwords($build['options']['charm']['charmID_data']['Charm']['name']) ?>
		<? } ?>
	</div>
</div>
</td>
<? } ?>

</tr>
</table>

<? if(isset($build['options']['frame'])) { ?>
<div class="preview_option">
	<div class="preview_option_title"><a href="/build/step/frame">Frame</a></div>
	<div class="preview_option_quote preview_option_value">
		<? if(!empty($build['options']['frame']['frameID_data'])) { ?>
			<a href="/build/step/frame">
			<img height="50" src="<?= $build['options']['frame']['frameID_data']['Frame']['graphic_location']?>"/>
			</a>
			<br/>
			<?= ucwords($build['options']['frame']['frameID_data']['Frame']['name']) ?>
		<? } ?>
	</div>
</div>
<? } ?>

<? if(isset($build['options']['handles'])) { ?>
<div class="preview_option">
	<div class="preview_option_title"><a href="/build/step/handles">Handles</a></div>
	<div class="preview_option_quote preview_option_value">
		<? if(!empty($build['options']['handles']['handleColor'])) { ?>
				<? if ($build['options']['handles']['handleColor'] == 'Black') { ?>
					<img src="/images/blacktotehandles_verysm.jpg"/>
				<? } else if ($build['options']['handles']['handleColor'] == 'Navy') { ?>
					<img src="/images/navy-blue-tote-handles-small.jpg"/>
				<? } else if ($build['options']['handles']['handleColor'] == 'Red') { ?>
					<img src="/images/red-tote-handles-small.jpg"/>
				<? } ?>
			<br/>
			<?= ucwords($build['options']['handles']['handleColor']); ?>
		<? } ?>
	</div>
</div>
<? } ?>

<? if(isset($build['options']['pinback'])) { ?>
<div class="preview_option">
	<div class="preview_option_title"><a href="/build/step/pinback">Pin Style</a></div>
	<div class="preview_option_quote preview_option_value">
		<? if(!empty($build['options']['pinback']['pinStyle'])) { ?>
				<? if ($build['options']['pinback']['pinStyle'] == 'Bar') { ?>
					<img src="/new-images/pinback.jpg"/>
				<? } else if ($build['options']['pinback']['pinStyle'] == 'Tie Tack') { ?>
					<img src="/new-images/tietacback.jpg"/>
				<? } ?>
		<? } ?>
	</div>
</div>
<? } ?>

<? if(isset($build['options']['size'])) { ?>
<div class="preview_option">
	<div class="preview_option_title"><a href="/build/step/size">Size</a></div>
	<div class="preview_option_quote preview_option_value">
		<? if(!empty($build['options']['size']['shirtSize'])) { 
			$size_map = array(
				'S'=>'Small',
				'M'=>'Medium',
				'L'=>'Large',
				'XL'=>'X-Large',
				'XXL'=>'XX-Large',
				'YS'=>'Youth Small',
				'YM'=>'Youth Medium',
				'YL'=>'Youth Large',
				'YXL'=>'Youth X-Large'
			);
		?>
			<?= ucwords($size_map[$build['options']['size']['shirtSize']]) ?>
		<? } ?>
	</div>
</div>
<? } ?>

<? if(isset($build['options']['printside'])) { ?>
<div class="preview_option">
	<div class="preview_option_title"><a href="/build/step/printside">Print Side</a></div>
	<div class="preview_option_quote preview_option_value">
		<? if(!empty($build['options']['printside']['printSide'])) { ?>
			<?= ucwords($build['options']['printside']['printSide']) ?>
		<? } ?>
	</div>
</div>
<? } ?>

<? if(isset($build['options']['ribbon']['ribbonID_data'])) { ?>
<div class="preview_option">
	<div class="preview_option_title"><a href="/build/step/ribbon">Ribbon</a></div>
	<div class="preview_option_quote preview_option_value">
		<? if(!empty($build['options']['ribbon']['ribbonID_data'])) { ?>
			<img height="50" src="/ribbons/<?= preg_replace("/ /", '-', $build['options']['ribbon']['ribbonID_data']['Ribbon']['color_name']); ?>.png"/>
			<br/>
			<?= ucwords($build['options']['ribbon']['ribbonID_data']['Ribbon']['color_name']) ?>
		<? } ?>
	</div>
</div>
<? } ?>


<? if(!empty($build['options']['personalization']['personalizationInput'])) { ?>
<div class="preview_option">
	<div class="preview_option_title"><a href="/build/step/personalization">Personalization</a></div>
	<div class="preview_option_personalization preview_option_value">
		<?= $build['options']['personalization']['personalizationInput'] ?>
		<? if(!empty($build['options']['personalization']['personalizationStyle'])) { ?>
			<i>(<?= $build['options']['personalization']['personalizationStyle'] ?>)</i>
		<? } ?>
	</div>
</div>
<? } ?>

<? if(isset($build['options']['comments'])) { ?>
<div class="preview_option">
	<div class="preview_option_title"><a href="/build/step/comments">Comments</a></div>
	<div class="preview_option_personalization preview_option_value">
		<?= $build['options']['comments']['itemComments'] ?>
	</div>
</div>
<? } ?>

</div>
