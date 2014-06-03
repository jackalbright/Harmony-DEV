<? 
$i = 0;
foreach($quotes as $quote) { ?>
	<? if ( ($quote['attrib_length'] + $quote['text_length']) > $build['Product']['quote_limit']) { ?>
		<? continue; ?>
	<? } ?>
	<blockquote class="quoteSelect">
		<label>
			<input type="radio" id="quoteID" name="quoteID" value="<?= $quote['quote_id'] ?>" <? ($i == 0 ? "checked='checked'" : "") ?> />
			<? if (!empty($quote['title'])) { ?>
				<strong><?= $quote['title'] ?></strong><br />
			<? } ?>
			<? if (!empty($quote['text'])) {
				if ($quote['use_quote_marks']) {
					echo '&#8220;';
				} 
				echo nl2br($quote['text']);
				if ($quote['use_quote_marks']) {
					echo '&#8221;';
				} 
			}
			if ($quote['attribution']) {
			?>
			<br/>
			<span class="attribution">&#8211;<?= $quote['attribution'] ?></span>
			<? } ?>
		</label>
	</blockquote>
<? } ?>
<blockquote class="quoteSelect">
	<label>
		<input type="radio" id="customQuote" name="quoteID" value="Custom" />See our <a href="searchQuotes.php">Quotation/Text Library</a> to find more text options OR type in your own wording below.
	</label>
	<br />
	<textarea name="customQuote" id="customQuoteField" rows="6" cols="36" style="vertical-align: top" onchange="changedQuote(event)" onblur="changedQuote(event)" onkeyup="typingQuote(event);"><? isset($quoteText) ? $quoteText : isset($build['parts']['customQuote']) ? $build['parts']['customQuote'] : ""; ?></textarea>
	<br />
	<span class="note">Maximum quote length: <? $build['Product']['quote_limit'] ?> characters. Current Length <span id="customQuoteLength"><?php if (isset($quoteLength)){echo $quoteLength;} else {echo "0";} ?></span>.</span>
</blockquote>


<blockquote class="quoteSelect">
	<label>
		<input type="radio" id="noQuote" name="quoteID" value="1" /> No Text/Quote
		<br />
		<span class="note">Omitting text will leave a large blank space and is not recommended.</span>
	</label>
</blockquote>
