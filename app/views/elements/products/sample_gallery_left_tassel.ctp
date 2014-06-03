<b>Click on a tassel to select or to view larger:</b>

<div class="grey_border_top"><span></span></div>
<div class="grey_border_sides" style="padding: 5px; position: relative;">
<div class="clear"></div>
	<?
			foreach ($tassels as $tassel) {
				$tassel_code = preg_replace("/ /", "-", $tassel['Tassel']['color_name']);
				$onClick = "selectTassel(this, '".$tassel['Tassel']['tassel_id']."', '".ucwords($tassel['Tassel']['color_name'])."', '/tassels/$tassel_code.gif', '/tassels/thumbs/".preg_replace("/ /", "-", $tassel['Tassel']['color_name']).".gif'); ";
				?>
				<div class="left padded center" style="float: left;">

				<a rel="shadowbox" href="/tassels/<?= $tassel_code ?>.gif" onClick="<?= $onClick ?>">
				<img src="/tassels/thumbs/<?= $tassel_code ?>.gif"/></a><br/>
				<a rel="shadowbox" href="/tassels/<?= $tassel_code ?>.gif" onClick="<?= $onClick ?>"><?= ucwords($tassel['Tassel']['color_name']); ?></a>

				</div>
				<?
			}
		?>
<div class="clear"></div>
</div>
<div class="grey_border_bottom"><span></span></div>
