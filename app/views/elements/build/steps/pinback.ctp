<div class="clear">
	<!--<h2><?php echo $counter;?>. Choose your Pin Style</h2>-->
		<span class="pinSelect">
			<label>
				<?php
					$default = true;
					echo '<input type="radio" name="pinStyle" value="Bar"';
					if ( $default && ( !isset($currentItem->parts->pinStyle) || ( $currentItem->parts->pinStyle == 'Bar' ) ) ) {
						echo 'checked="checked" ';
						$default = false;
					}
					echo ' />';
				?>
				Bar Pin
				<br />
				<img src="/new-images/pinback.jpg" width="80" height="70" alt="pin back" />
			</label>
		</span>
  <span class="pinSelect">
			<label>
				<?php
					echo '<input type="radio" name="pinStyle" value="Tie Tack"';
					if ( $default && ( !isset($currentItem->parts->pinStyle) || ( $currentItem->parts->pinStyle == 'Tie Tack' ) ) ) {
						echo 'checked="checked" ';
						$default = false;
					}
					echo ' />';
				?>
				Tie Tack Pin
				<br />
				<img src="/new-images/tietacback.jpg" width="80" height="70" alt="tie tack back" />
			</label>
  </span>

</div>

