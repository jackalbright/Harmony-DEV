<div align="right" class="right"> <a href="Javascript:void(0);" onClick="updateBuildImage();"><img src="/images/buttons/small/Preview.gif"/> </div>
<div class="clear">
<!--<h2><?php echo $counter;?>. Frame your poster <span class="note">(Optional)</span></h2>-->
		<p class="note"> Adds $25 dollars to the cost of your poster.  </p>
		<div class="left padded">
			<input type="radio" id="posterframe" name="data[options][poster_frame]" value="Yes" onClick="update_build_pricing(); updateBuildImage();"/>
				<a rel="shadowbox;width=600;height=400" href="/parts/view/poster_frame">Frame</a> my matted poster.<br/>
              		<img src="/new-images/poster-frame-corner.jpg" width="55" height="54" border="0" align="left" />
		</div>

		<div class="left padded">
			<input type="radio" id="noposterframe" name="data[options][poster_frame]" checked='checked' value="No" onClick="update_build_pricing(); updateBuildImage();"/>
			 
				Don't frame.
		</div>

		<script>
			<? if(!empty($build['options']['poster_frame']) || (!empty($build['orig_prod']) && $build['orig_prod'] == 'PSF')) { 
				$id = (strtolower($build['options']['poster_frame']) == 'no') ? "noposterframe" : "posterframe";
			?>
				$('<?=$id?>').checked = 'checked';
			<? } ?>
		</script>

		<div class="clear"></div>


</div>

