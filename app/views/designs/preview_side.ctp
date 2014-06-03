<? if(empty($side)) { $side = 1; } ?>
<div class='preview' id="preview<?= $side ?>">
	<!-- stuff goes where it goes, and movement is allowed/restricted on only some items... -->
	<div id="<?=$side?>_fullbleed" class="fullbleed">
		<? foreach($dragimg as $img) { ?>
		<div id="<?=$side?>_<?=$img['id']?>" class='<?= $img['id'] ?>'>
			<img src="/images/trans.gif"/>
		</div>
		<? } ?>
		<? foreach($dragrect as $rect) { ?>
		<div id='<?= $side.'_'.$rect['id'] ?>' class='<?= $rect['id'] ?>'>
			<? if ($rect['id'] == 'quote' || $rect['id'] == 'personalization') { # XXX LOAD ?>
			<p>
			</p>
			<? } ?>
		</div>
		<? } ?>
	</div>
	<!-- some parts have full access, some are internal to product -->
	<div id='<?=$side ?>_coords' class="coords">
	<? foreach($coords as $coord) { if($coord['id'] == 'fullbleed') { continue; } ?>
	<div id="<?=$side.'_'.$coord['id'] ?>" class='<?= $coord['id'] ?>' class='coord'>
	</div>
	<? } ?>
	</div>
	<div id="<?=$side?>_parts" class='parts'>
	<? foreach($parts as $part) { ?>
	<div id="<?=$side.'_'.$part['id'] ?>" class='<?= $part['id'] ?> part'>
		<img src="/images/trans.gif"/>
	</div>
	<? } ?>
	</div>
	<img src='/images/trans.gif' class='canvas_overlay'/>
</div>
<script>
j('#preview<?=$side?> .fullbleed img').bind('load', function() {
	console.log("LOAD IMAGE...="+j(this).attr('src'));
	var src = j(this).attr('src');
	if(src.match(/trans[.]gif$/)) { return; } // not for transparent pic.

	j(this).loadImageZoomAndDrag();
	// move out of 'preview' so only called once.
});
</script>

