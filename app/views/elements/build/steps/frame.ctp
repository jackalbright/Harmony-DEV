<div class="clear">
	<!--	<h2><?php echo $counter;?>. Choose your frame color</h2> -->
		<?php
			$result = mysql_query ("Select * from frame where available = 'yes' order by name", $database);
			$default = true;
			while ( $frame = mysql_fetch_object ($result) ) {
				echo '<span class="frameSelect">' . "\n";
				echo '<label>' . "\n";
				echo '<input type="radio" id="frameID" name="frameID"';
				if ( $default && ( !isset($currentItem->parts->frameID) || ( $currentItem->parts->frameID == $frame->frame_id ) ) ) {
					echo ' checked="checked"';
					$default = false;
				}
				echo ' value="';
				echo $frame->frame_id;
				echo '" />';
				echo $frame->name . "\n";
				echo '<br />' . "\n";
				echo '<img class="frame" src="';
				echo $frame->graphic_location;
				echo '" alt="';
				echo $frame->name;
				echo '"  />' . "\n";
				echo '</label>' . "\n";
				echo '</span>' . "\n";
			}
		?>
</div>

