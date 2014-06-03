<? if($build['Product']['code'] == 'TS') { ?>
	<?= $this->element("build/estimate_tshirt"); ?>
<? } else { ?>
	<?= $this->element("build/estimate"); ?>
<? } ?>

<script>
/*hidePleaseWait();*/
</script>
