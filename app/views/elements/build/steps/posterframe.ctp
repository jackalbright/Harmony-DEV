<div class="clear">
<h2><?php echo ++$counter;?>. Frame your poster <span class="note">(Optional)</span></h2>
		<p class="note">
			Adds $25 dollars to the cost of your poster.

              <blockquote><a href="/details/poster.php#frames"><img src="/new-images/poster-frame-corner.jpg" width="55" height="54" border="0" align="right" /></a> 
              </p>
		<p><label><span  style="background-color:#FFFFEE";>
			<input type="radio" id="posterframe" name="posterframe" value="Yes" <?php if ($itemPosterFrame == "Yes") echo "checked"; ?>/>
				<a href="/details/poster.php#frames">Frame</a> my matted poster.</span>
		</label>
		  <br /></p>
		<p><label>
			<span  style="background-color:#FFFFEE";><input type="radio" id="noposterframe" name="posterframe" value="No" <?php if ($itemPosterFrame != "Yes") echo "checked"; ?>/>
				Don't frame.</span>
		</label>
		</p></blockquote>

</div>

