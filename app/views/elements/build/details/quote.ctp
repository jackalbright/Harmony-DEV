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
			<i>No quotation</i>
		<? } ?>

