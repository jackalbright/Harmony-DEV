<div class="">
		Click on a picture or name to choose your ribbon.
		<div>
		<? 
		$ribbons_found = array();

		$img_ribbons = $image->listRibbons();
		if(count($img_ribbons)) {
		?>
		<?php
			foreach ($img_ribbons as $record) {
				$ribbon_code = preg_replace("/ /", "-", $record->name);
				$ribbons_found[$ribbon_code] = true;
				?>
				<div class="left padded center" style="float: left;">
				<a href="Javascript:void(0);" onClick="build_choose('ribbon', '<?= $record->id ?>');"><img src="/ribbons/<?= $ribbon_code ?>.png" height="50"/></a><br/>
				<a href="Javascript:void(0);" onClick="build_choose('ribbon', '<?= $record->id ?>');"><?= ucwords($record->name); ?></a>
				</div>
				<?
			}
		}

			foreach ($ribbons as $record) {
				$ribbon_code = preg_replace("/ /", "-", $record->color_name);
				if (!empty($ribbons_found[$ribbon_code])) { continue; }
				?>
				<div class="left padded center" style="float: left;">

				<a href="Javascript:void(0);" onClick="build_choose('ribbon', '<?= $record->ribbon_id ?>');"><img src="/ribbons/<?= $ribbon_code ?>.png" height="50"/></a><br/>
				<a href="Javascript:void(0);" onClick="build_choose('ribbon', '<?= $record->ribbon_id ?>');"><?= ucwords($record->color_name); ?></a>

				</div>
				<?
			}
			?>

		</div>
</div>

