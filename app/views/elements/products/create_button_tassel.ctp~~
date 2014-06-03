<div id="tassel_list">

<p class="bold">
Click on a tassel &gt; Choose your quantity &gt; Click 'ADD TO CART'
</p>

<? foreach($tassels as $tassel) { ?>
	<? if($tassel['Tassel']['available'] == 'Yes') { ?>
	<div id='tassel_<?= $tassel['Tassel']['tassel_id'] ?>' class="tassel" onClick="selectTassel(this, '<?= $tassel['Tassel']['tassel_id'] ?>', '<?= ucwords($tassel['Tassel']['color_name']) ?>', '/tassels/<?= preg_replace("/ /", "-", $tassel['Tassel']['color_name']) ?>.gif', '/tassels/thumbs/<?= preg_replace("/ /", "-", $tassel['Tassel']['color_name']) ?>.gif');">
		<img src="/tassels/thumbs/<?= preg_replace("/ /", "-", $tassel['Tassel']['color_name']); ?>.gif">
		<br/>
		<a href="#"><?= ucwords($tassel['Tassel']['color_name']) ?></a>
	</div>
	<? } ?>
<? } ?>
<div class="clear"></div>

</div>
