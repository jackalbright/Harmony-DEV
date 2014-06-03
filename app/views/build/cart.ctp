<div id="build">
	<?
			 $action = "/build/step/$current_step";
			 if ($current_step == 'cart')
			 {
			 	$action = '/cart/addnew';
			 }
	?>


	<table width="100%">
	<!-- May have horizontal product someday, depends... -->

	<tr>
		<td style="width: 200px;" valign="top">
			<?= $this->element("build/preview"); ?>
		</td>
		<td valign="top">

		<div id="build_summary" style="border: solid #CCC 1px; padding: 2px; padding-bottom: 50px;">
			<form id="build_form" name="build_form" method="POST" action="<?= $action ?>">
			<input type="hidden" name="next_step" id="next_step" value=""/>
			<h2><?= $counter ?>. Summary</h2>
					<div class="right">
						<? if(!empty($build['cart_item_id'])) { ?>
							<input type="image" name="action" src="/images/buttons/Update-Cart.gif" onClick="showPleaseWait();"/>
						<? } else { ?>
							<input type="image" name="action" src="/images/buttons/Add-to-Cart.gif" onClick="showPleaseWait();"/>
						<? } ?>
					</div>
					<div class="clear"></div>

			<?= $this->element("build/details_selected",array('summary'=>1)); ?>
			<div class="clear"></div>

					<div class="right">
						<? if(!empty($build['cart_item_id'])) { ?>
							<input type="image" name="action" src="/images/buttons/Update-Cart.gif" onClick="showPleaseWait();"/>
						<? } else { ?>
							<input type="image" name="action" src="/images/buttons/Add-to-Cart.gif" onClick="showPleaseWait();"/>
						<? } ?>
					</div>
					<div class="clear"></div>
			</form>
		</div>

		</td>
		<td style="width: 200px;" valign="top">
			<?= $this->element("build/details_selected",array('no_summary'=>1)); ?>
		</td>

	</tr>
	</table>

	<script>
		/* hidePleaseWait(); */
	</script>

</div>