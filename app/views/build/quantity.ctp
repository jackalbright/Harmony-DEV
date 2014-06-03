<div id="build">
	<?
	 $action = "/build/quantity";
	?>
	<form method="POST" action="<?= $action ?>">

	<table width="100%" table=1">
	<tr>
		<td width="" rowspan=2 valign=top style="width: 200px;">
			<?= $this->element("build/preview"); ?>
			<?= $this->element("build/details_selected"); ?>
		</td>
		<td valign=top>
			<?= $this->element("build/quantity"); ?>
		</td>
	</tr>
	</table>

	</form>
</div>
