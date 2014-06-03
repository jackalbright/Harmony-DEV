<div class='clear'></div>
<div style="margin-top: 10px;">
<?
$goto_next = " j(this).closest('.accordion').trigger('next'); j('#DesignForm').save();";

if(empty($next_js)) { $next_js = ""; }
if(empty($skip_js)) { $skip_js = ""; }
?>
<table width="100%" border=0 cellpadding=0 cellspacing=0>
<tr>
	<td width="75%">
		<? if(!empty($tip)) { ?>
		<div class='tip'>
			<?= $tip ?>
		</div>
		<? } ?>
		<? if(!empty($skip_js)) { ?>
		<? $skipimg = preg_match("/\//", $skip) ? $this->Html->image($skip) : $skip; # "/images/buttons/small/Skip.gif"); ?>
		<?= $this->Html->link($skipimg, "javascript:void(0)",
			array('onClick'=>$goto_next.$skip_js,'class'=>'alert2','escape'=>false)
		); ?>
		<? } ?>
	</td>
	<td align='right'>
		<?= $this->Html->link($this->Html->image("/images/webButtons2014/green/small/next.png"), "javascript:void(0)",
			array('onClick'=>$goto_next.$next_js, 'escape'=>false)
		); ?>
	</td>
</tr>
</table>
</div>
