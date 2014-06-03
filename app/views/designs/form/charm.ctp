<?
$defaultCharmId = 17;
?>
<h3 id='<?=$side?>_header_charm' class='step_header side<?=$side?>'><?=$i ?>. Select Charm</h3>
<div id='<?=$side?>_step_charm' class='step side<?=$side?>'>
	<?= $this->Form->hidden("DesignSide.$side.charm_id", array('empty'=>'[None]','options'=>$charms,'default'=>$defaultCharmId)); ?>

	<div id="CharmList<?=$side?>" class='CharmList'>
	<? foreach($charmThumbs as $tid=>$url) { ?>
		<?= $this->Html->link($this->Html->image($url), "javascript:void(0)", array('id'=>"{$side}_charm_$tid",'escape'=>false,'title'=>$charms[$tid], 'class'=>($defaultCharmId == $tid ? "selected":""))); ?>
	<? } ?>
	</div>

<script>

j('#CharmList<?=$side?> a').click(function() {
	j('#CharmList<?=$side?> a').removeClass('selected');
	j(this).addClass('selected');
	var id = j(this).attr('id').replace(/^<?=$side?>_charm_/, "");
	j('#DesignSide<?=$side?>CharmId').val(id).change();
});
var charms = <?= json_encode( !empty($charmImages) ? $charmImages : array() ); ?>;

j('#DesignSide<?=$side?>CharmId').bind('preview', function() {
	j('#preview<?=$side?> .parts .charm').showPart(charms, j(this).val());
});

</script>
<?= $this->element("../designs/next");#, array('skip'=>'No Charm','skip_js'=>"j('#DesignSideCharmId').val('').change();")); ?>

<style>
.CharmList
{
	max-height: 300px;
	overflow-y: auto;
}
.CharmList a
{
	display: block;
	float: left;
	margin: 2px;
	height: 50px;
	border: solid #EEE 2px;
	background-color: black;
}
.CharmList a.selected
{
	border-color: #CC6633;
}
.CharmList a img
{
	height: 50px;
}
</style>
</div>
