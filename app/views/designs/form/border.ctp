<?
$hasBorder = !$this->Session->check("DesignSide.$side.border_id") || $this->Session->read("DesignSide.$side.border_id");
//$defaultBorderId = $side > 1 ? null : -1; # No default border for second side.
$defaultBorderId = null;
?>
<h3 id='<?=$side?>_header_border' class='step_header side<?=$side?>'><?=$i ?>. Select Border</h3>
<div id='<?=$side?>_step_border' class='step side<?=$side?>'>
	<?= $this->Form->hidden("DesignSide.$side.border_id", array('empty'=>'[None]','options'=>$borders,'default'=>$defaultBorderId)); ?>

	<div id="BorderList<?=$side?>" class='BorderList'>
		<?= $this->Html->link("<div class='none'>None</div>", "javascript:void(0)", array('id'=>"{$side}_border_-1",'escape'=>false,'title'=>"No border", 'class'=>(!($defaultBorderId > 0) ? "selected":""))); ?>
	<? foreach($borderImages as $bid=>$url) { ?>
		<?= $this->Html->link("<div class='thumb'>".$this->Html->image($url)."</div>", "javascript:void(0)", array('id'=>"{$side}_border_$bid",'escape'=>false,'title'=>$borders[$bid], 'class'=>($defaultBorderId == $bid ? "selected":""))); ?>
	<? } ?>
	</div>

	<div class='tip'>
		Click &amp; drag border on product at right to reposition
	</div>


<?= $this->Form->hidden("DesignSide.$side.border1_y", array('id'=>"{$side}_border1_y",'div'=>false,'label'=>false,'size'=>4)); ?>
<?= $this->Form->hidden("DesignSide.$side.border2_y", array('id'=>"{$side}_border2_y",'div'=>false,'label'=>false,'size'=>4)); ?>
<style>
.BorderList
{
	max-height: 300px;
	overflow-y: auto;
}
.BorderList a
{
	position: relative;
	display: block;
	margin: 0 auto;
	text-align: center;
	text-decoration: none;
	color: black;
	font-weight: bold;
	display: block;
	float: left;
	margin: 1px;
	height: 32px;
	width: 48px;
	overflow: hidden;
	border: solid #DDD 2px;
}
.BorderList a div.none
{
	display: block;
	padding-top: 5px;
}
.BorderList a div.thumb
{
	display: inline-block;
	position: relative;
	right: -50%;
	height: 32px;
}
.BorderList a.selected
{
	border-color: #CC6633;
}
.BorderList a img
{
	display: block;
	position: relative;
	height: 32px;
	left: -50%;
}
</style>
<script>
var borders = <?= json_encode( !empty($borderImages) ? $borderImages : array() ); ?>;
var bordersHorizontal = <?= json_encode( !empty($borderHorizontalImages) ? $borderHorizontalImages : array() ); ?>;

j('#BorderList<?=$side?> a').click(function() {
	j('#BorderList<?=$side?> a').removeClass('selected');
	j(this).addClass('selected');
	var id = j(this).attr('id').replace(/^<?=$side?>_border_/, "");
	//console.log("ID="+id);
	j('#DesignSide<?=$side?>BorderId').val(id).change();
});

j('#DesignSide<?=$side?>BorderId').bind('preview', function() {
////console.log(borders);
//console.log(j(this).val());
//console.log(borders[j(this).val()]);
	var horiz = (j('#DesignOrientation').val() == 'horizontal');

	j('#preview<?=$side?> .border1').showPart(horiz?bordersHorizontal:borders, j(this).val());
	j('#preview<?=$side?> .border2').showPart(horiz?bordersHorizontal:borders, j(this).val());
});

j('#side<?=$side ?>').bind('visible', function() { // things sensitive to position.
	<?
	# border x,y,w,h etc are relative to container, not just fullbleed.
	$border1maxx = $border1minx = $items['border1']['x']-$fullbleed[0]['x'];
	$border1miny = $items['border1']['y']-$fullbleed[0]['y'];
	$border1maxy = $border1miny + $fullbleed[0]['height']/4; // Allow going down 1/4th

	$border2maxx = $border2minx = $items['border2']['x']-$fullbleed[0]['x'];
	$border2maxy = $items['border2']['y']-$fullbleed[0]['y'];
	$border2miny = $border2maxy - $fullbleed[0]['height']/4; // Allow going up 1/4th
	?>
	j('#preview<?=$side?> .border1').enableDraggable([<?= $border1minx ?>, <?= $border1miny ?>, <?= $border1maxx ?>, <?= $border1maxy ?>]);
	j('#preview<?=$side?> .border2').enableDraggable([<?= $border2minx ?>, <?= $border2miny ?>, <?= $border2maxx ?>, <?= $border2maxy ?>]);

	j('#preview<?=$side?> .border1, #preview<?=$side?> .border2').addClass('dynamic');
});
</script>
<?= $this->element("../designs/next");#, array('skip'=>'No Border','skip_js'=>"j('#BorderList a').removeClass('selected'); j('#DesignSideBorderId').val('').change();")); ?>
</div>
