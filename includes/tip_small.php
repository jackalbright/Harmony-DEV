<? if(!empty($tips[$tip_code])) { ?>
<a style="font-size: 2em; font-weight: bold;" href="Javascript:void(0)" onClick="$('tip_<?= $tip_code ?>').toggleClassName('hidden');">?</a>
<div id="tip_<?= $tip_code ?>" class="hidden" style="position: absolute; z-index: 999; padding: 10px; background-color: white; border: #CCC 1px;">
	<div class="right"><a href="Javascript:void(0)" onClick="$('tip_<?= $tip_code ?>').addClassName('hidden');">[CLOSE]</a></div>
	<div class="clear"></div>

	<div class="bold nobr"><?= $tips[$tip_code]['title'] ?></div>
	<br/>

	<p>
		<?= $tips[$tip_code]['content'] ?>
	</p>
</div>
<? } ?>
