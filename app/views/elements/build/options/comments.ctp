<div class="clear" style="width: 200px;">
	<div class="bold">Comments or questions</div>
	<textarea onChange="update_build_review('<?=$i?>');" id="itemComments" name="data[options][itemComments]" rows="5" style="width: 100%;"><?= !empty($build['options']['itemComments']) ? $build['options']['itemComments'] : "" ?></textarea>
	<div class="note">(This will not appear on your item.)</div>
</div>
