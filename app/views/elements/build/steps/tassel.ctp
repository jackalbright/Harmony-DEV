<?
			$default = true;
?>
<div class="">
		<!--<h2><?php echo $counter;?>. Choose your tassel color</h2>-->

		<br/>

		<div>
		<? $img_tassels = $image->listTassels();
		if(count($img_tassels)) {
		?>
		<h4>Recommended:</h4>
		<?php
			foreach ($img_tassels as $record) {
				$tassel_code = preg_replace("/ /", "-", $record->name);
				$checked = "";
				if ( $default && ( !isset($currentItem->parts->tasselID) || ( $currentItem->parts->tasselID == $record->id ) ) ) {
					$checked = ' checked="checked"';
					$default = false;
				}
				?>
				<div class="left padded center" style="float: left;">
				<label>
				<input type="radio" id="tassel_<?= $tassel_code ?>" class="tasselID" name="tasselID" value="<?= $record->id ?>" <?= $checked ? $checked : "" ?> />
				<?= ucwords($record->name); ?><br/>
				</label>
				<a rel="shadowbox" title="<?=$record->name?>" href="/tassels/<?= $tassel_code ?>.gif" onClick="$('tassel_<?=$tassel_code?>').checked = 1;"/>
				<img src="/tassels/thumbs/<?= $tassel_code ?>.gif"/>
				</a>
				</div>
				<?
			}
		}
		?>
		<div class="clear"></div>
		</div>

		<h4>All Tassels:</h4>
		<div>
			<?
			foreach ($tassels as $record) {
				$tassel_code = preg_replace("/ /", "-", $record->color_name);
				$checked = "";
				if ( $default && ( !isset($currentItem->parts->tasselID) || ( $currentItem->parts->tasselID == $record->tassel_id ) ) ) {
					$checked = ' checked="checked"';
					$default = false;
				}
				?>
				<div class="left padded center" style="float: left;">
				<label>
				<input type="radio" id="tassel_<?= $tassel_code ?>" class="tasselID" name="tasselID" value="<?= $record->tassel_id ?>" <?= $checked ? $checked : "" ?> />
				<?= ucwords($record->color_name); ?><br/>
				</label>
				<a rel="shadowbox" title="<?=$record->color_name?>" href="/tassels/<?= $tassel_code ?>.gif" onClick="$('tassel_<?=$tassel_code?>').checked = 1;"/>
				<img src="/tassels/thumbs/<?= $tassel_code ?>.gif"/>
				</a>
				</div>
				<?
			}
			?>

		</div>
</div>

<div class="clear"></div>
