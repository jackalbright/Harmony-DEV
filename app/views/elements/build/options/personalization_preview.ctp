
<?
$persLength = !empty($build['options']['personalizationInput']) ? strlen($build['options']['personalizationInput']) : 0;
?>
<div id="personalization_checkbox" class="<?= $persLength > 0 ? "" : "hidden" ?> ">
	<img src="/images/icons/checkbox.png" height="50"/>
</div>

			<div class="note">
				<span id="personalizationLength"><?= $persLength ?></span> of <?= $this_product->personalizationLimit ?> characters.
			</div>
