<div id="build">
	<?
			 $action = "/build/step/$current_step";
			 if ($current_step == 'cart')
			 {
			 	$action = '/cart/addnew';
			 }
	?>

	<form id="build_form" name="build_form" method="POST" action="<?= $action ?>">

	<table width="100%">
	<!-- May have horizontal product someday, depends... -->

	<tr>
		<td style="width: 200px;" valign="top">
			<?= $this->element("build/preview"); ?>
		</td>
		<td valign="top">

		<div id="build_summary" style="border: solid #CCC 1px; padding: 2px; padding-bottom: 50px;">
			<input type="hidden" name="next_step" id="next_step" value=""/>
			<h2><?= $counter ?>. Summary</h2>
			<p>Confirm your choices and click 'add to cart'...
			</p>
			<?= $this->element("build/details_selected_new",array('summary'=>1)); ?>
			<div class="clear"></div>
		</div>

		</td>
		<td style="width: 200px;" valign="top">
			<?= $this->element("build/details_selected_new",array('no_summary'=>1)); ?>
		</td>

	</tr>
	</table>

	</form>

</div>
