<div class="">
		Click on a picture or name to choose your charm.

		<? if($build['Product']['code'] == 'PW') { ?>
			<p class="note">Please Note: The small ring shown on the charms is removed before placement in your paperweight.</p>
		<? } ?>
		<br/>

		<div class="left padded center" style="float: left;">
				<a href="Javascript:void(0);" onClick="build_choose('charm', '');">
				<img src="/charms/no-charm.jpg" class="" alt="no charm"/></a><br/>
				<a href="Javascript:void(0);" onClick="build_choose('charm', '');">No Charm</a>
		</div>

		<? 
		$img_charms = $image->listCharms();
		if(count($img_charms))
		{
		?>
			<? 
			foreach($img_charms as $record) {
				?>
				<div class="left padded center" style="float: left;">

				<a href="Javascript:void(0);" onClick="build_choose('charm', '<?= $record->id ?>');">
				<?= ucwords($record->name); ?></a><br/>

				<a href="Javascript:void(0);" onClick="build_choose('charm', '<?= $record->id ?>');">
				<img title="<?= ucwords($record->name) ?>" src="<?=$record->image ?>"/></a>
				</div>
			<? } ?>
		<? } ?>

			<?
			foreach($charms as $record) {
				?>
				<div class="left padded center" style="float: left;">


				<a href="Javascript:void(0);" onClick="build_choose('charm', '<?= $record->charm_id ?>');"><img height="50" title="<?= ucwords($record->name) ?>" src="<?=$record->graphic_location ?>"/></a><br/>
				<a href="Javascript:void(0);" onClick="build_choose('charm', '<?= $record->charm_id ?>');"><?= ucwords($record->name); ?></a><br/>
				</div>
			<? } ?>

</div>

