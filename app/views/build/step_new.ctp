<div id="build">
	<?
			 $action = "/build/step/$current_step";
			 if ($current_step == 'cart')
			 {
			 	$action = '/cart/add.php';
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
			<input type="hidden" name="next_step" id="next_step" value=""/>
				<?= $this->element("build/steps_new"); ?>
		</td>
		<td style="width: 200px;" valign="top">
			<?= $this->element("build/details_selected_new"); ?>
		</td>

	</tr>
	</table>

	</form>

</div>
