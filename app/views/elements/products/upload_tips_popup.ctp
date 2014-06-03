<span class="relative" style="z-index: 1001;">
<a onClick="j('#upload_tips').toggle();" href="javascript:void(0)"><?= !empty($label) ? $label : "Formats"?></a>
<div id="upload_tips" style="padding: 5px; z-index: 1000; display: none; background-color: #FFF; border: solid #666 2px; color: #000; position: absolute; top: 35px; right: 0px; width: 450px;">
	<a class="right" onClick="j('#upload_tips').hide();" href="javascript:void(0)">Close</a>

	<?= $this->element("custom_images/tips"); ?>
	<div class="clear"></div>
</div>
</span>
