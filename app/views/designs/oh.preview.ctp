<? if(empty($side)) { $side = 1; } ?>
<? $sides = $this->Session->read("Design.Design.sides"); ?>
<div class='absolute'>
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
			<p class='text' style='display:none;'>
			</p>
			<? } ?>
			<? if ($rect['id'] == 'quote') { ?>
			<p class='attribution' style='display:none;'>
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
<div class='clear'></div>
<div id="side<?=$side?>label" class="active sidelabel">
	<h3 class='left' style="<?= $side == 1 && $sides < 2 ? "display:none;" : "" ?>">Side <?= $side ?></h3>
	<?= $this->Html->link($this->Html->image("/images/buttons/small/Start-Over.gif"), "javascript:void(0)", array('id'=>"start_over$side",'escape'=>false,'title'=>'Start this side over')); ?>
	<div class='clear'></div>
</div>
<script>
j('#start_over<?=$side?>').click(function() {
	j('#DesignForm').resetSide('<?= $side ?>');
});

j('#preview<?=$side?> .fullbleed img').bind('reset', function() {
	j(this).resetImageZoomAndDrag('<?= !empty($product['fullbleed']) ?>');
	// Only considers fullbleed of original/parent product....
});

j('#preview<?=$side?> .fullbleed img').bind('load', function() {
	var src = j(this).attr('src');
	//console.log("LOADING...="+src);
	if(src.match(/trans[.]gif$/)) { return; } // not for transparent pic.

	j(this).loadImageZoomAndDrag(false,'<?= !empty($product['fullbleed']) ?>');
	// move out of 'preview' so only called once.

	// if we want fullbleed default, we have to set those coordinates...
	// we need to know the difference between loading initially and loading once done. - coords are set or not.
	// fullbleed must then be designated from uploading/choosing picture.
});
j('#preview<?= $side?> .canvas_overlay').draggable_overlay(); // This proxies movement to 'dynamic' items
</script>

