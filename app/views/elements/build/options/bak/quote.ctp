<?
	# Load data for this....

?>
<div class="right">
<div align="right" > <a href="Javascript:void(0);" onClick="updateBuildImage();"><img src="/images/buttons/small/Preview.gif"/> </div>
<a rel="shadowbox;width=800;height=400" href="/build/quote_select/<?= $build['Product']['code'] ?>/<?= !empty($build['GalleryImage']) ? $build['GalleryImage']['catalog_number'] : "" ?>">Suggested Text/Quotation Library</a>
</div>


<div class="clear">
	<textarea name="data[options][customQuote]" id="option_quote" style="width: 95%; height: 100px; " onchange="$('quote_checkbox').removeClassName('hidden'); changedQuote('<?= $product['Product']['quote_limit'] ?>'); typingQuote('<?= $product['Product']['quote_limit'] ?>'); updateBuildImage();" onblur="changedQuote('<?= $product['Product']['quote_limit'] ?>')" onkeyup="typingQuote('<?= $product['Product']['quote_limit'] ?>');"><?= !empty($build['options']['customQuote']) ? $build['options']['customQuote'] : "" ?></textarea>
	<br/>
	<span class="note">Omitting text will leave a large blank space and is not recommended.</span>
</div>
