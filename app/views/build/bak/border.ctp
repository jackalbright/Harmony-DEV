BORDERS GO HERE....

<form action="/build/border" method="POST">

<? foreach($imageRecommendedBorders as $border) { ?>
<span class="borderSelect">
	<label>
		<input type="radio" id="borderID" name="borderID" value="<?= $border['Border']['border_id'] ?>" checked="checked"/>
		<?= $border['Border']['name'] ?>
		<img src="<?= $border['Border']['location'] ?>" alt="" class="border"/>
	</label>
		<? if($quote['Quote']['text']) { 
			if ($quote['Quote']['use_quote_marks']) { echo '&#8220;'; }
			echo nl2br($quote['Quote']['text']);
			if ($quote['Quote']['use_quote_marks']) { echo '&#8221;'; }
		} 
		if ($quote['Quote']['attribution']) { echo '<br/><span class="attribution">&#8211;'.$quote['Quote']['attribution']."</span>"; }
		?>
	</label>
</span>
<? } ?>

<br/>

<? foreach($allBorders as $border) { ?>
<span class="borderSelect">
	<label>
		<input type="radio" id="borderID" name="borderID" value="<?= $border['Border']['border_id'] ?>" checked="checked"/>
		<?= $border['Border']['name'] ?>
		<img src="<?= $border['Border']['location'] ?>" alt="" class="border"/>
	</label>
		<? if($quote['Quote']['text']) { 
			if ($quote['Quote']['use_quote_marks']) { echo '&#8220;'; }
			echo nl2br($quote['Quote']['text']);
			if ($quote['Quote']['use_quote_marks']) { echo '&#8221;'; }
		} 
		if ($quote['Quote']['attribution']) { echo '<br/><span class="attribution">&#8211;'.$quote['Quote']['attribution']."</span>"; }
		?>
	</label>
</span>
<? } ?>


<blockquote class="quoteSelect">
	<label>
        	<input type="radio" id="customQuote" checked="checked" name="quoteID" value="Custom" />See our <a href="searchQuotes.php">Quotation/Text Library</a> to find more text options OR type in your own wording below.
        </label>
        <br />
        <textarea name="customQuote" id="customQuoteField" rows="6" cols="36" style="vertical-align: top" onchange="changedQuote(event)" onblur="changedQuote(event)" onkeyup="typingQuote(event);"><?php 
	#if($quoteText != ""){echo $quoteText;}else{echo $currentItem->parts->customQuote;} 
	?></textarea>
        <br />
        <span class="note">Maximum quote length: <?= $quote_limit ?> characters. Current Length <span id="customQuoteLength"><?php if ($quoteLength != ""){echo $quoteLength;} else {echo "0";} ?></span>.</span>
</blockquote>
<blockquote class="quoteSelect">
	<label>
              <input type="radio" id="noQuote" name="quoteID" value="1" /> No Text/Quote
              <br />
              <span class="note">Omitting text will leave a large blank space and is not recommended.</span>
       </label>
</blockquote>

</form>
