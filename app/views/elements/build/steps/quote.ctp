<?
	# Load data for this....

?>
<div class="clear">
	<!--<h2> <?php echo $counter;?>. Choose your Quote or Text </h2>-->
	<?php
		$default = true;
		foreach ( array_merge( $productQuotes, $image->listQuotes() ) as $record) {

			if ( ($record->attributionLength + $record->textLength) > $this_product->quote_limit ) {
				#error_log("TOO LONG!");
				continue;
			}
			if (get_class($image) != 'stamp' && ( (strpos($record->title . $record->text, 'stamp') !== false) || (strpos($record->title . $record->text, 'Stamp') !== false) ) ) {
				#error_log("HERESY!, CL");
				#continue;
			}
			echo '<blockquote class="quoteSelect">' . "\n";
			echo '<label>' . "\n";
			echo '<input type="radio" id="quoteID" name="quoteID" value="';
			echo $record->id;
			echo '"';
			if ( $default && ( empty($currentItem->parts->quoteID) || ($currentItem->parts->quoteID == $record->id ) ) ) {
				echo ' checked="checked" ';
				$default = false;
			}
			echo ' />' . "\n";
			if ($record->title != '') {
				echo '<strong>';
				echo $record->title;
				echo '</strong>';
				echo '<br />';
			}
			if ($record->text != '') {
				if ($record->useQuoteMarks)
					echo '&#8220;';
				echo nl2br($record->text);
				if ($record->useQuoteMarks)
					echo '&#8221;';
			}
			if ($record->attribution != '') {
				echo '<br />' . "\n";
				echo '<span class="attribution">&#8211;';
				echo $record->attribution;
				echo '</span>' . "\n";
			}
			echo '</label>' . "\n";
			echo "\n" . '</blockquote>' . "\n";
		}
	?>
	<blockquote class="quoteSelect">
		See our <a href="/product/searchQuotes.php">Quotation/Text Library</a> to find more text options 
		<br/>
		<br/>
		<label>
			<input type="radio" id="customQuote"<?php if ( ($default && !isset($currentItem->parts->quoteID)) || ($quoteText != "") ) { echo ' checked="checked"'; $default = false; } ?>name="quoteID" value="Custom" />
			Type in your own wording below.
		</label>
		<br />
		<textarea name="customQuote" id="customQuoteField" rows="6" cols="36" style="vertical-align: top" onchange="changedQuote(event)" onblur="changedQuote(event)" onkeyup="typingQuote(event);"><?php if($quoteText != ""){echo $quoteText;}else{echo $currentItem->parts->customQuote;} ?></textarea>
		<br />
		<span class="note">Maximum quote length: <?php echo $this_product->quote_limit; ?> characters. Current Length <span id="customQuoteLength"><?php if ($quoteLength != ""){echo $quoteLength;} else {echo "0";} ?></span>.</span>
	</blockquote>
	<blockquote class="quoteSelect">
		<label>
			<input type="radio" id="noQuote" name="quoteID" value="1" <?php if ($default && isset($currentItem->parts->quoteID) && $currentItem->parts->quoteID == 1) echo 'checked="Checked"'; ?> /> No Text/Quote
			<br />
			<span class="note">Omitting text will leave a large blank space and is not recommended.</span>
		</label>
	</blockquote>
</div>
