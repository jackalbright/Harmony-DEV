<h3 class='side<?=$side?>'><?=$i ?>. Select Orientation</h3>
<div class='side<?=$side?>'>
	<?
	$orient = array(
		'vertical'=>'Vertical',
		'horizontal'=>'Horizontal'
	);
	?>
	<? if(!isset($side)) { $side = 0; } ?>
	
	<?= $this->Form->input("DesignSide.$side.orientation", array('label'=>'Orientation','options'=>$orient)); ?>

<script>

j('#DesignSide<?=$side?>Orientation').bind('preview', function() {
	var orientation = j(this).val();
	j('#preview<?=$side?>').removeClass('horizontal vertical').addClass(orientation);
});
// operations on selected parts, or at least some of them.
</script>

<?= $this->element("../designs/next"); ?>

</div>
