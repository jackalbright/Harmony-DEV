<script>
var product = "<?= $this_product->name ?>";

<? if (isset($this_product->quote_limit)) { ?> var quoteLimit = '<?= $this_product->quote_limit ?>'; <? } ?>
<? if (isset($this_product->personalizationLimit)) echo 'var personalizationLimit = ' . $this_product->personalizationLimit . ';' . "\n"; ?>
<? if (isset($this_product->address_length)) echo 'var addressLimit = ' . $this_product->address_length . ';' . "\n"; ?>

partDisplayLookup = new Array();
partDisplayLookup["borders"] = new Array();
partDisplayLookup["charms"] = new Array();
partDisplayLookup["ribbons"] = new Array();
partDisplayLookup["tassels"] = new Array();

<?
if(!empty($borders)) {
	foreach ($borders as $border) {
		echo 'partDisplayLookup["borders"][';
		echo $border->border_id;
		echo '] = "';
		echo $border->location;
		echo '";';
		echo "\n";
	}
}
if(!empty($charms)) {
	foreach ($charms as $charm) {
		echo 'partDisplayLookup["charms"][';
		echo $charm->charm_id;
		echo '] = "';
		echo $charm->graphic_location;
		echo '";';
		echo "\n";
	}
}
if (!empty($tassels)) {
	foreach ($tassels as $tassel) {
		echo 'partDisplayLookup["tassels"][';
		echo $tassel->tassel_id;
		echo '] = "';
		echo $tassel->color_code;
		echo '";';
		echo "\n";
	}
}
if (!empty($ribbons)) {
	foreach ($ribbons as $ribbon) {
		echo 'partDisplayLookup["ribbons"][';
		echo $ribbon->ribbon_id;
		echo '] = "';
		echo $ribbon->color_code;
		echo '";';
		echo "\n";
	}
}
?>
</script>
