<? $this->Js->JqueryEngine->jQueryObject = 'j'; ?>
<div class="" style="width: 350px;">
	<script>

	</script>

		<div align="left">
		<table width="100%">
		<tr>
			<td>
				<select id="browse_node_id" style="width: 300px;" XXXonChange="return quoteBrowse('<?= $prod ?>', $('browse_node_id').value); ">
					<option value="">Browse</option>
					<? $i= 0; foreach($categories_by_parent_id[1] as $cat) { ?>
						<option value="<?= $cat['GalleryCategory']['browse_node_id'] ?>" <?= !empty($browse_node_id) && $browse_node_id == $cat['GalleryCategory']['browse_node_id'] ? "selected='selected'" : "" ?> ><?= $cat['GalleryCategory']['browse_name'] ?></option>
					<? } ?>
				</select>
			</td>
			<td>
				&nbsp;
				<a href="Javascript:void(0)" onClick="return quoteBrowse('<?= $prod ?>', $('browse_node_id').value); return false;">
				<img align="top" src="/images/buttons/small/Go-grey.gif" height="25"/>
				</a>
			</td>
		</tr>
		<tr>
			<td colspan=1 align="center" class="bold">
				- OR -
			</td>
		</tr>
		<tr>
			<td>
				<input id="quoteKeywords" type="text" name="data[keywords]" value="<?= !empty($keywords) ? $keywords : "Search by keyword" ?>" style="width: 294px;" onFocus="<?= empty($keywords) ? "this.value = '';" : "" ?>" onBlur="if(!this.value) { this.value = 'Search by keyword'; } "/>
			</td>
			<td>
				&nbsp;
				<a href="Javascript:void(0)" onClick="return quoteSearchSubmit('<?= $prod ?>'); return false;">
				<img align="top" src="/images/buttons/small/Go-grey.gif" height="25"/>
				</a>
			</td>
		</tr>
		</table>
		</div>

		<? if(!empty($current_quote)) { ?>
			<div class="bold">Currently Selected Quote:</div>
			<table class="clear padded">
				<tr>
					<td valign="top" style="padding-top: 10px;">
						<input id="quote<?= $current_quote['Quote']['quote_id'] ?>" type="radio" name="data[options][quoteID]" checked='checked' value="<?= $current_quote['Quote']['quote_id'] ?>" onClick="j('#option_quote').val(''); updateLayout(); showText();"/> 
					</td>
					<td valign="top" style="padding-top: 10px;">
						<div class="quoteText">
							<label for="quote<?= $current_quote['Quote']['quote_id'] ?>">
								<?= $current_quote['Quote']['text']; ?>
							</label>
						</div>
						<? if(!empty($current_quote['Quote']['attribution'])) { ?>
						<div class="quoteAttribution">
						- <?= $current_quote['Quote']['attribution']; ?>
						</div>
						<? } ?>
						<div class="hidden" id="quote_text_<?= $current_quote['Quote']['quote_id'] ?>"><?= preg_replace("/<br>/", "\n", $current_quote['Quote']['text']); ?><? if(!empty($current_quote['Quote']['attribution'])) { ?>

- <?= $current_quote['Quote']['attribution']; ?><? } ?></div>
					</td>
					<?
					?>
				</tr>
			</table>

		<? } ?>

		<? if(isset($quotes)) { ?>
		
			<div class="bold">Search Results:</div>
<div style="overflow: auto; max-height: 350px;">
<table width="100%">
<tr>
<td>
	<?= $paginator->counter(array( 'format' => __('Results %start% - %end% of %count%', true))); ?>
</td>
<td align="right">
<? if($paginator->hasPrev() || $paginator->hasNext()) { ?>
<div class="">
	<? $paginator->options(array('update'=>'#browse','indicator'=>'loading','url' => array('keywords'=>$keywords), $this->passedArgs)); ?>
	<? if($paginator->hasPrev()) { ?> <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?> | <? } ?>
 	<?php echo $paginator->numbers();?>
	<? if($paginator->hasNext()) { ?> | <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?> <? } ?>
</div>
<? } ?>
</td>
</tr>
</table>
			<table class="clear padded">
			<?
			if (!empty($quotes))
			{
				$i = 0; foreach($quotes as $quote) { 
					if(empty($quote['Quote']['text'])) { continue; }
			?>
				<tr style="background-color: <?= $i++ % 2 == 0 ? "#CCC" : "#FFF"; ?>;">
					<td valign="top" style="padding-top: 10px;">
						<input id="quote<?= $quote['Quote']['quote_id'] ?>" type="radio" name="data[options][quoteID]" value="<?= $quote['Quote']['quote_id'] ?>" onClick="j('#option_quote').val(''); updateLayout(); showText();"/> 
					</td>
					<td valign="top" style="padding-top: 10px;">
						<div class="quoteText">
							<label for="quote<?= $quote['Quote']['quote_id'] ?>">
								<?= $quote['Quote']['text']; ?>
							</label>
						</div>
						<? if(!empty($quote['Quote']['attribution'])) { ?>
						<div class="quoteAttribution">
						- <?= $quote['Quote']['attribution']; ?>
						</div>
						<? } ?>
						<div class="hidden" id="quote_text_<?= $quote['Quote']['quote_id'] ?>"><?= preg_replace("/<br>/", "\n", $quote['Quote']['text']); ?><? if(!empty($quote['Quote']['attribution'])) { ?>

- <?= $quote['Quote']['attribution']; ?><? } ?></div>
					</td>
					<?
					?>
				</tr>
			<?
				}
			} else {
				?> <br/><p>No quotes found.</p> <?
			}
			?>
			</table>
</div>
			<?
		} ?>

		<? if (isset($browse_quotes)) { ?>

<div class="bold">Browse Results:</div>
<div style="overflow-y: auto; overflow-x: hidden; max-height: 350px;">
<table width="100%">
<tr>
<td>
	<?= $paginator->counter(array( 'format' => __('Results %start% - %end% of %count%', true))); ?>
</td>
<td align="right">
<? if($paginator->hasPrev() || $paginator->hasNext()) { ?>
<div class="">
	<? $paginator->options(array('update'=>'#browse','indicator'=>'loading', 'url' => array_merge(array('browse_node_id'=>$parent_node_id), $this->passedArgs))); ?>
	<? if($paginator->hasPrev()) { ?> <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?> | <? } ?>
 	<?php echo $paginator->numbers();?>
	<? if($paginator->hasNext()) { ?> | <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?> <? } ?>
</div>
<? } ?>
</td>
</tr>
</table>
		<? if(!empty($browse_quotes)) { ?>
		
			<table class="" cellspacing=0>
			<?
			$i = 0;
			foreach($browse_quotes as $quote) { 
				if(empty($quote['Quote']['text'])) { continue; }
			?>
				<tr style="background-color: <?= $i++ % 2 == 0 ? "#CCC" : "#FFF"; ?>;">
					<td valign="top" style="padding-top: 10px;">
						<input id="quote<?= $quote['Quote']['quote_id'] ?>" type="radio" name="data[options][quoteID]" value="<?= $quote['Quote']['quote_id'] ?>" onClick="j('#option_quote').val(''); updateLayout(); showText();"/> 
					</td>
					<td valign="top" style="padding-top: 10px;">
						<div class="quoteText">
							<label for="quote<?= $quote['Quote']['quote_id'] ?>">
								<?= $quote['Quote']['text']; ?>
							</label>
						</div>
						<? if(!empty($quote['Quote']['attribution'])) { ?>
						<div class="quoteAttribution">
						- <?= $quote['Quote']['attribution']; ?>
						</div>
						<? } ?>
						<div class="hidden" id="quote_text_<?= $quote['Quote']['quote_id'] ?>"><?= preg_replace("/<br>/", "\n", $quote['Quote']['text']); ?><? if(!empty($quote['Quote']['attribution'])) { ?>

- <?= $quote['Quote']['attribution']; ?><? } ?></div>
					</td>
					<?
					?>
				</tr>
			<?
			}
			?>
		</table>
</div>

		<?  } else { ?> <br/><p>No quotes found.</p> <?  } ?>

		<? } ?>

		<? 
			if(empty($recommendedQuotes)) {
				$recommendedQuotes = array();
			}
			if(!empty($productQuotes)) { $recommendedQuotes += $productQuotes; }
			#if(!empty($recommendedImageQuotes)) { $recommendedQuotes += $recommendedImageQuotes; }

		?>


		<? if(!empty($recommendedQuotes)) { ?>
			<br/>
<div style="overflow-y: auto; overflow-x: hidden; max-height: 350px;">
			<div class="bold">Recommended Quotes:</div>
			<table class="" cellspacing=0>
			<?
			$i = 0;
			foreach($recommendedQuotes as $quote) { 
				if(empty($quote['Quote']['text'])) { continue; }
			?>
				<tr style="background-color: <?= $i++ % 2 == 0 ? "#CCC" : "#FFF"; ?>;">
					<td valign="top" style="padding-top: 10px;">
						<input id="quote<?= $quote['Quote']['quote_id'] ?>" type="radio" name="data[options][quoteID]" value="<?= $quote['Quote']['quote_id'] ?>" onClick="j('#option_quote').val(''); updateLayout(); showText();"/> 
					</td>
					<td valign="top" style="padding-top: 10px;">
						<div class="quoteText">
							<label for="quote<?= $quote['Quote']['quote_id'] ?>">
								<?= $quote['Quote']['text']; ?>
							</label>
						</div>
						<? if(!empty($quote['Quote']['attribution'])) { ?>
						<div class="quoteAttribution">
						- <?= $quote['Quote']['attribution']; ?>
						</div>
						<? } ?>
						<div class="hidden" id="quote_text_<?= $quote['Quote']['quote_id'] ?>"><?= preg_replace("/<br>/", "\n", $quote['Quote']['text']); ?><? if(!empty($quote['Quote']['attribution'])) { ?>

- <?= $quote['Quote']['attribution']; ?><? } ?></div>
					</td>
					<?
					?>
				</tr>
			<?
			}
			?>
		</table>
</div>
		<? } ?>

</div>
