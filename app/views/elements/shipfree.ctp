<? if(empty($customer['is_wholesale']) && !empty($config['free_ground_shipping_minimum'])) { ?>
<? if(!empty($ul)) { ?><ul><li><? } ?>
<div class="" style="color: #B82A2A; margin: 5px 0px; position: relative;">
	Free standard shipping (continental U.S.) with web orders <?= sprintf("$%u+", $config['free_ground_shipping_minimum']); ?>.
	<?= empty($nobr)?"<br/>":" " ?>(Excludes paperweights, paperweight kits, budget bookmarks and mugs.)

</div>
<? if(!empty($ul)) { ?></li></ul><? } ?>
<? } ?>
