<?
$defaultTasselId = 41;
?>
<h3 id="<?=$side?>_header_tassel" class="step_header side<?=$side?>"><?=$i ?>. Select Tassel</h3>
<div id="<?=$side?>_step_tassel" class='step side<?=$side?>'>
	<?= $this->Form->hidden("DesignSide.$side.tassel_id", array('empty'=>'[None]','options'=>$tassels,'default'=>$defaultTasselId)); ?>

	<div id="TasselList<?=$side?>" class='TasselList'>
	<? foreach($tasselThumbs as $tid=>$url) { ?>
		<?= $this->Html->link($this->Html->image($url), "javascript:void(0)", array('id'=>"{$side}_tassel_$tid",'escape'=>false,'title'=>$tassels[$tid], 'class'=>($defaultTasselId == $tid ? "selected":""))); ?>
	<? } ?>
	</div>

<script>

jQuery('#TasselList<?=$side?> a').click(function() {
	j('#TasselList<?=$side?> a').removeClass('selected');
	j(this).addClass('selected');
	var id = j(this).attr('id').replace(/^<?= $side?>_tassel_/, "");
	j('#DesignSide<?=$side?>TasselId').val(id).change();
});
var tassels = <?= json_encode( !empty($tasselImages) ? $tasselImages : array() ); ?>;
var tasselsHorizontal = <?= json_encode( !empty($tasselHorizontalImages) ? $tasselHorizontalImages : array() ); ?>;

jQuery('#DesignSide<?=$side?>TasselId').bind('preview', function() {
	var horiz = (j('#DesignOrientation').val() == 'horizontal');
	j('#preview<?=$side?> .parts .tassel').showPart(horiz?tasselsHorizontal:tassels, j(this).val());
});


</script>
<?= $this->element("../designs/next");#, array('skip'=>'No Tassel','skip_js'=>"j('#DesignSideTasselId').val('').change();")); ?>

<style>
.TasselList
{
	max-height: 300px;
	overflow-y: auto;
}
.TasselList a
{
	display: block;
	float: left;
	margin: 2px;
	height: 50px;
	width: 30px;
	overflow: hidden;
	background-color: white;
	border: solid #EEE 2px;
}
.TasselList a.selected
{
	border-color: #CC6633;
}
.TasselList a img
{
	height: 50px;
}
</style>
</div>
