<?
$defaultCharmID = $currentItem->parts->charmID;
			$default = true;
#print_r($currentItem->parts);

?>
<div class="clear">
	<table><tr>
	<td valign="top">
		<script>
			var charm_images = new Array();
			<? foreach($charms as $charm) { ?>
				charm_images[<?= $charm->charm_id ?>] = '/charms/<?= $charm->name ?>.gif';
			<? } ?>
		</script>
		<input type="hidden" name="charmID" id="charm_value" value=""/>
		<select name="charmID_master" onChange="updateBuildOption('charm', this.value); ">
			<option value=";/charms/no-charm.jpg">No Charm - Save $X.XX ea.</option>
		<? $img_charms = $image->listCharms();
			$i = 0;
			$first_charm = null;

			if(!empty($img_charms)) { 
				foreach($img_charms as $charm)
				{
					if($i++ == 0) { $first_charm = "/charms/".$charm->name.".jpg"; }
					?>
						<option value="<?= $charm->id ?>;/charms/<?= $charm->name ?>.jpg"><?= ucwords($charm->name); ?></option>
					<?
				}
			}
			foreach($charms as $charm)
			{
					if($i++ == 0) { $first_charm = "/charms/".$charm->name.".jpg"; }
					?>
						<option value="<?= $charm->charm_id ?>;/charms/<?= $charm->name ?>.jpg"><?= ucwords($charm->name); ?></option>
					<?
			}
		?>
		</select>
		<br/>
		<a href="/build/option_select/<?= $build['Product']['code'] ?>/charm">View All Charms</a>

		<? if($build['Product']['code'] == 'PW') { ?>
			<p class="note">Please Note: The small ring shown on the charms is removed before placement in your paperweight.</p>
		<? } ?>
	</td>
	<td>
		<div id="">
			<img id="charm_preview" height="50" src="<?= $first_charm ?>"/>
		</div>
	</td>
	</tr></table>

</div>

