<?
$quoteLength = !empty($build['options']['customQuote']) ? strlen($build['options']['customQuote']) : 0;
?>

<div id="quote_checkbox" class="<?= $quoteLength > 0 ? "" : "hidden" ?> ">
	<img src="/images/icons/checkbox.png" height="50"/>
</div>


<div class="note">
		<span id="customQuoteLength"><?= !empty($quoteLength) ? $quoteLength : "0" ?></span> of <?= $this_product->quote_limit ?> characters.
</div>
