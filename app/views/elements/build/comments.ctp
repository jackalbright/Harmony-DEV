<div class="clear">
<!--<h2><?php echo $counter;?>. Enter comments <span class="note">(Optional)</span></h2>-->
		<div id="comments">
			<p>
				Type your comments or special instructions below. <br />
				<span class="note">(This will not appear on your item.)</span>
			</p>
			<p>
				<textarea id="itemComments" name="data[options][itemComments]" rows="5" cols="40" ><?= !empty($build['options']['itemComments']) ? $build['options']['itemComments'] : "" ?></textarea>
			</p>
		</div>
</div>

