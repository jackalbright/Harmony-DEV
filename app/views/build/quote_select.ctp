<div class="">
	<script>
	/*	hidePleaseWait();*/
	</script>

		<form method="POST" id="quote_form" url="/build/quote_select/<?= $prod ?>/<?= $catalogNumber ?>" onSubmit="showPleaseWait();">
		<table>
		<tr>
			<td>
				<label class="bold alert2">Type a keyword:</label>
				<br/>
				<input type="text" name="data[keywords]" value="<?= !empty($this->data['keywords']) ? $this->data['keywords'] : "" ?>"/>
				<input type="hidden" name="data[browse_node_id]" value="1"/>
			</td>
			<td>
				<input type="image" src="/images/buttons/Search-grey.gif" height="25"/>
			</td>
			<td>
				<b class="alert2">Browse:</b>
				<br/>
				<!-- loop thru up until parent node id, trace back for trail... -->
				<? foreach($category_stack as $cat_id) { $cat = $categories_by_node_id[$cat_id]; ?>
					<a onClick="showPleaseWait();" href="/build/quote_select/<?= $prod ?>/<?= $catalogNumber ?>?browse_node_id=<?= $cat['GalleryCategory']['browse_node_id'] ?>">
						<?= $cat['GalleryCategory']['browse_name'] ?>
					</a> &raquo;
				<? } ?>
				<? if (!empty($categories_by_parent_id[$parent_node_id])) { ?>
				<div style="padding-left: 20px;">
					<? $i= 0; foreach($categories_by_parent_id[$parent_node_id] as $cat) { ?><?= $i++ > 0 ? ", " : "" ?>
						<a onClick="showPleaseWait();" href="/build/quote_select/<?= $prod ?>/<?= $catalogNumber ?>?browse_node_id=<?= $cat['GalleryCategory']['browse_node_id'] ?>"><?= $cat['GalleryCategory']['browse_name'] ?></a><? } ?>
				</div>
				<? } ?>
			</td>
		</tr>
		</table>
		</form>

		<? if(isset($quotes)) { ?>
			<hr/> 
		
			<h3>Search Results:</h3>
<div class="">
	<? $paginator->options(array('url' => array('keywords'=>$keywords), $this->passedArgs)); ?>
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
			<table class="clear padded">
			<?
			if (!empty($quotes))
			{
				foreach($quotes as $quote) { 
					if(empty($quote['Quote']['text'])) { continue; }
			?>
				<tr>
					<td valign="top" style="padding-top: 20px;">
						<a href="javascript:void(0);" onclick="build_choose_quote('<?= $quote['Quote']['quote_id'] ?>');"><img src="/images/buttons/small/Use-Quote-grey.gif"/></a>
					</td>
					<td valign="top" style="padding-top: 20px;">
						<div class="quoteText">
						<?= $quote['Quote']['text']; ?>
						</div>
						<? if(!empty($quote['Quote']['attribution'])) { ?>
						<div class="quoteAttribution">
						<br/><br/>
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
				?> <p>No quotes found.</p> <?
			}
			?>
			</table>
			<?
		} ?>

		<? if (!empty($browse_quotes)) { ?>
			<hr/> 

			<h3>Browse Results:</h3>
<div class="">
	<? $paginator->options(array('url' => array_merge(array('browse_node_id'=>$parent_node_id), $this->passedArgs))); ?>
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
		
			<table class="">
			<?
			foreach($browse_quotes as $quote) { 
				if(empty($quote['Quote']['text'])) { continue; }
			?>
				<tr>
					<td valign="top" style="padding-top: 20px;">
						<a href="javascript:void(0);" onclick="build_choose_quote('<?= $quote['Quote']['quote_id'] ?>');"><img src="/images/buttons/small/Use-Quote-grey.gif"/></a>
					</td>
					<td valign="top" style="padding-top: 20px;">
						<div class="quoteText">
						<?= $quote['Quote']['text']; ?>
						</div>
						<? if(!empty($quote['Quote']['attribution'])) { ?>
						<div class="quoteAttribution">
						<br/>- <?= $quote['Quote']['attribution']; ?>
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

		<? } ?>


		<? if(!empty($recommendedQuotes) || !empty($productQuotes)) { 
		?> 
			<hr/> 
		
			<h3>Suggested Quotes/Text:</h3>
			<table class="">
			<?

			foreach($recommendedQuotes as $quote) { 
				if(empty($quote['Quote']['text'])) { continue; }
			?>
				<tr>
					<td valign="top" style="padding-top: 20px;">
						<a href="javascript:void(0);" onclick="build_choose_quote('<?= $quote['Quote']['quote_id'] ?>');"><img src="/images/buttons/small/Use-Quote-grey.gif"/></a>
					</td>
					<td valign="top" style="padding-top: 20px;">
						<div class="quoteText">
						<?= $quote['Quote']['text']; ?>
						</div>
						<? if(!empty($quote['Quote']['attribution'])) { ?>
						<div class="quoteAttribution">
						<br/>- <?= $quote['Quote']['attribution']; ?>
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

			foreach($productQuotes as $quote) { 
				if(empty($quote['Quote']['text'])) { continue; }
			?>
				<tr>
					<td valign="top" style="padding-top: 20px;">
						<a href="javascript:void(0);" onclick="build_choose_quote('<?= $quote['Quote']['quote_id'] ?>');"><img src="/images/buttons/small/Use-Quote-grey.gif"/></a>
					</td>
					<td valign="top" style="padding-top: 20px;">
						<div class="quoteText">
						<?= $quote['Quote']['text']; ?>
						</div>
						<? if(!empty($quote['Quote']['attribution'])) { ?>
						<div class="quoteAttribution">
						<br/>- <?= $quote['Quote']['attribution']; ?>
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
			<?
		
		} ?>
</div>
