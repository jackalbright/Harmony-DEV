<? 
			$default = true;
?>
<div class="clear">
		<!--<h2><?php echo $counter;?>. Choose your ribbon color</h2>-->
		<br/>
		<? $img_ribbons = $image->listRibbons();
		if(count($img_ribbons)) { 
		?>
		<div>
		<h4>Recommended:</h4>
		<?php
			foreach ($img_ribbons as $record) {
				$checked = "";
				if ($default && (empty($currentItem->parts->ribbonID) || $currentItem->parts->ribbonID == $record->id)) {
					$checked = ' checked="checked"';
					$default = false;
				}
			?>
				<div class="left thick_padded center" style="width: 115px; float: left;">
				<label>
				<input type="radio" id="ribbon_<?= $record->id ?>" class="ribbonID" name="ribbonID" value="<?= $record->id ?>" <?= $checked ? $checked : "" ?> />
				<nobr><?= ucwords($record->name); ?></nobr><br/>
				</label>
				<img height=50 src="/ribbons/<?= preg_replace("/ /", '-', $record->name) ?>.png" onClick="$('ribbon_<?= $record->id ?>').checked = 1;"/>
				</a>
				</div>
			<?
				#echo '<span class="tasselSelect">' . "\n";
				#echo '<label>' . "\n";
				#echo '<input type="radio" id="ribbonID" name="ribbonID" value="';
				#echo $record->id;
				#echo '"';
				#if ( $default && ( !isset($currentItem->parts->ribbonID) || ( $currentItem->parts->ribbonID == $record->id ) ) ) {
				#	echo ' checked="checked"';
				#	$default = false;
				#}
				#echo ' /> ';
				#echo $record->name . "\n";
				#echo '<br />' . "\n";
				#echo '<span class="tassel" style="background-color: #';
				#echo $record->color;
				#echo ';">&nbsp;</span>' . "\n";
				#echo '</label>' . "\n";
				#echo '</span>' . "\n";
			}
		?>

		</div>
		<? } ?>
		<div class="clear"></div>

		<h4>All Ribbons:</h4>

		<div>
		<?
			foreach($ribbons as $record) {
				$checked = "";
				if ($currentItem->parts->ribbonID == $record->ribbon_id) {
					$checked = ' checked="checked"';
					$default = false;
				}
				?>
				<div class="left thick_padded center" style="width: 115px; float: left;">
				<label>
				<nobr>
				<input type="radio" id="ribbon_<?= $record->ribbon_id ?>" class="ribbonID" name="ribbonID" value="<?= $record->ribbon_id ?>" <?= $checked ? $checked : "" ?> />
				<?= ucwords($record->color_name); ?>
				</nobr>
				
				<br/>
				</label>
				<img height=50 src="/ribbons/<?= preg_replace("/ /", '-', $record->color_name) ?>.png" onClick="$('ribbon_<?= $record->ribbon_id ?>').checked = 1;"/>
				</a>
				</div>
			<? } ?>
		</div>

</div>

