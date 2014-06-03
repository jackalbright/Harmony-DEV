<h3 id='<?=$side ?>_header_background' class='step_header side<?=$side?>'><?=$i ?>. Select Background Color</h3>
<div id="<?=$side ?>_step_background" class='step side<?=$side?>'>
	<?= $this->Form->input("DesignSide.$side.background_color", array('label'=>false,'type'=>'text','default'=>'#FFF')); ?>
	<script>
	j(document).ready(function() {
		j('#DesignSide<?=$side?>BackgroundColor').colorpicker({
			flat: true,
			showPaletteOnly: true
		});
	});

	j('#DesignSide<?=$side?>BackgroundColor').change(function() {

		var bg = j(this).val();
		var dark = (colorBrightness(bg) <= 130);
		if(dark)
		{
			j('#DesignSide<?=$side?>QuoteColor, #DesignSide<?=$side?>PersonalizationColor').spectrum('set','#FFF').change();
		} else {
			j('#DesignSide<?=$side?>QuoteColor, #DesignSide<?=$side?>PersonalizationColor').spectrum('set','#000').change();
		}
	});
	</script>
<script>
j('#DesignSide<?=$side?>BackgroundColor').bind('preview', function() {
	var color = j(this).val();
	j('#preview<?=$side?> .fullbleed').css({backgroundColor: color});
});
</script>
<?= $this->element("../designs/next");#, array('skip'=>'No Color','skip_js'=>"j('#DesignSideBackgroundColor').val('#FFF').change();")); ?>
</div>
