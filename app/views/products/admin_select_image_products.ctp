<?= $this->element("steps/steps", array('step'=>'product')); ?>
<div class="hidden"><?= $this->element("products/preview_image"); ?></div>
<form method="POST" action="/admin/products/send_email">
	<a href="/products/select">Back to main site</a>
	<table width="100%">
	<tr>
		<td width="50%">
			<label>Send to:</label>
			<textarea style="width: 350px; height: 200px;" class="no_editor" name="data[emails]"></textarea>
			<div>
				List emails, one per line.
			</div>
		</td>
		<td width="50%" align="left">
			<label>Subject:</label>
			<?
				if(empty($image_name)) { $image_name = 'Harmony Designs'; }
			?>

			<input style="width: 350px;" type="text" name="data[subject]" value="<?= addslashes($image_name) ?> Products"/>
			<label>Message:</label>
			<textarea name="data[message]"></textarea>
			<input align="right" type="image" src="/images/buttons/Send-grey.gif"/>
		</td>
	</tr>
	</table>
</form>

<?= $this->element("products/product_grid", array('links'=>$this->element('gallery/switch_layout'))); ?>
