<?
$defaultCharmID = $currentItem->parts->charmID;
			$default = true;
#print_r($currentItem->parts);

?>
<div class="clear">
		<!--<h2><?php echo $counter;?>. Choose your charm</h2>-->
		<? if($build['Product']['code'] == 'PW') { ?>
			<p class="note">Please Note: The small ring shown on the charms is removed before placement in your paperweight.</p>
		<? } ?>
		<br/>

		<div>
			<div class="right">Click on a charm to view larger</div>
		<? $img_charms = $image->listCharms();
		if(count($img_charms))
		{
		?>
		<h4>Recommended:</h4>
			<? 
			foreach($img_charms as $record) {
				$checked = "";
				if ( $default && ( !isset($currentItem->parts->charmID) || ( $currentItem->parts->charmID == $record->id ) ) ) {
					$checked = ' checked="checked"';
					$default = false;
				}
				?>
				<div class="left padded center" style="float: left;">
				<label>
				<input type="radio" id="charm_<?= $record->id ?>" class="charmID" name="charmID" value="<?= $record->id ?>" <?= $checked ? $checked : "" ?> />
				<?= ucwords($record->name); ?><br/>
				</label>
				<a title="<?= ucwords($record->name) ?>" rel="shadowbox" href="/charms/large/<?= basename($record->image); ?>"><img title="<?= ucwords($record->name) ?>" src="<?=$record->image ?>" onClick="$('charm_<?= $record->id ?>').checked = 1;"/></a>
				</div>
			<? } ?>
		<? } ?>

			<div class="left padded center" style="float: left;">
				<input type="radio" id='charm_0' class="charmID" name="charmID" value="0" <?= ($default || $currentItem->parts->charmID == '0') ? "checked='checked'" : "" ?> />
				No Charm<br />
				<img src="/charms/no-charm.jpg" width="50" height="50" class="" alt="no charm" onClick="$('charm_None').checked = 1;"/>
			</div>
			<div class="clear"></div>
		</div>

		<h4>All Charms:</h4>
		<div style="height: 400px; overflow: scroll; background-color: #FAFAFA;">
			<?
			foreach($charms as $record) {
				$checked = "";
				if ( $default && ( !isset($currentItem->parts->charmID) || ( $currentItem->parts->charmID == $record->charm_id ) ) ) {
					$checked = ' checked="checked"';
					$default = false;
				}
				?>
				<div class="left padded center" style="float: left;">
				<label>
				<input type="radio" id="charm_<?= $record->charm_id ?>" class="charmID" name="charmID" value="<?= $record->charm_id ?>" <?= $checked ? $checked : "" ?> />
				<?= ucwords($record->name); ?><br/>
				</label>
				<a title="<?= ucwords($record->name) ?>" rel="shadowbox" href="/charms/large/<?= basename($record->graphic_location); ?>"><img height="50" title="<?= ucwords($record->name) ?>" src="<?=$record->graphic_location ?>" onClick="$('charm_<?= $record->charm_id ?>').checked = 1;"/></a>
				</div>
			<? } ?>

		</div>
			</label>
		</span>

</div>

