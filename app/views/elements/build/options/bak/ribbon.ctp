<div class="clear">
		<script>
			var ribbon_images = new Array();
			<? foreach($ribbons as $ribbon) { ?>
				ribbon_images[<?= $ribbon->ribbon_id ?>] = '/ribbons/<?= preg_replace("/ /", '-', $ribbon->color_name) ?>.png';
			<? } ?>
		</script>
		<select id="option_ribbon" name="data[options][ribbonID]" onChange="updateBuild('<?=$i?>');" onChangeX="changeOptionPreview('ribbon', this.value, ribbon_images); updateBuildImage();">
		<? $img_ribbons = $image->listRibbons();
			$existing_ribbons = array();
			$first_ribbon = "";
			if (!empty($img_ribbons))
			{
				foreach($img_ribbons as $ribbon)
				{
					if(empty($first_ribbon)) { $first_ribbon = '/ribbons/'.preg_replace("/ /", '-', $ribbon->name) . '.png'; }
					$existing_ribbons[$ribbon->id] = true;
				?>
					<option value="<?= $ribbon->id ?>" ><?= ucwords($ribbon->name); ?></option>
				<?
					# LOAD DEFAULT???
				}
			}
			foreach($ribbons as $ribbon)
			{
				if(!empty($existing_ribbons[$ribbon->ribbon_id])) { continue; }
					if(empty($first_ribbon)) { $first_ribbon = '/ribbons/'.preg_replace("/ /", '-', $ribbon->color_name) . '.png'; }
				?>
					<option value="<?= $ribbon->ribbon_id ?>" ><?= ucwords($ribbon->color_name); ?></option>
				<?
			}
		?>
		</select>
		<script>
			<? if(!empty($build['options']['ribbonID'])) { ?>
				//Event.observe('window', 'load', function (event) { alert("BOR"); $('option_ribbon').value = '<?= $build['options']['ribbonID'] ?>'; $('option_ribbon').onchange(); });
				$('option_ribbon').value = '<?= $build['options']['ribbonID'] ?>'; 
				changeOptionPreview('ribbon', $('option_ribbon').value, ribbon_images);
			<? } ?>
		</script>
</div>
