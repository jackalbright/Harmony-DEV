<?
function printProductStep($stepnum)
{
	?>
		<a href="/details">
			Choose your product
		</a>
	<?
}

function printImageStep($stepnum)
{
	?>
		<a href="/build/build_select.php">Select your image</a>
	<?
}


function printBuildProcess($stepname, $substepname)
{
	$_SESSION['build']['current_step'] = $stepname;
	$firststep = 'product';
	if ($stepname == 'image' && !isset($_SESSION['build']['product']))
	{
		$firststep = 'image';
	}

?>
<table style="border: solid black 1px; width: 100%;">
	<tr>
		<td>
			<?
				if($firststep == 'product') { printProductStep(1); }
				else { printImageStep(2,$substepname); }
			?>
		</td>
		<td>
			<?
				if($firststep != 'product') { printImageStep(1,$substepname); }
				else { printProductStep(2); }
			?>
		</td>
		<td>
			<a href="/product/build.php">
				Add text &amp; other options
			</a>
		</td>
	</tr>
	<tr>
		<td colspan="5">
			<?
				if($stepname == 'image')
				{

				} else if ($stepname == '') {
				}
			?>
		</td>
	</tr>
</table>
<?
}
?>
