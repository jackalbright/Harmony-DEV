<div id="build">
	<?
	 $action = "/build/step/$current_step";
	 if ($current_step == 'cart')
	 {
	 	$action = '/cart/add.php';
	 }
	?>

	<table width="100%" table=1">
	<tr>
		<td width="" rowspan=2 valign=top style="width: 200px;">
			<?= $this->element("build/preview"); ?>
			<?= $this->element("build/details_selected"); ?>
		</td>
		<td valign=top>
			<form id="build_form" name="build_form" method="POST" action="<?= $action ?>">
			<input type="hidden" name="next_step" id="next_step" value=""/>
				<?= $this->element("build/steps"); ?>
			</form>
		</td>
	</tr>
	</table>

</div>
