<?= $this->element("inline_edit", array('code'=>"template_introduction")); ?>

<br/>
<br/>

<table width="100%" cellpadding=2 cellspacing=0>
<? $i = 0; foreach($products as $p) { 
	$c = $p['Product']['code'];
	#$relfile = preg_replace("/\s+/", "-", $p['Product']['pricing_name']). "-Template-Specifications.pdf";
	$relfile = "$c-Template-Specifications.pdf";
	$absfile = APP."/webroot/templates/$relfile";

	if(!file_exists($absfile)) { continue; }

	$filesize = filesize($absfile);
	$fileunit = 'B';
	if($filesize > 1024)
	{
		$fileunit = 'KB';
		$filesize /= 1024;
	}
	if($filesize > 1024)
	{
		$fileunit = 'MB';
		$filesize /= 1024;
	}

?>
<tr style="<?= $i++ % 2 ? "background-color: #DDD;":"" ?>">
	<td>
		<b><?= $p['Product']['pricing_name'] ?></b><br/>
		<?= $p['Product']['pricing_description'] ?>
		<!--
		<br/>
		<i><?= $relfile ?></i>
		-->
		<!-- (<b><?= sprintf("%0.1f %s", $filesize, $fileunit); ?></b>) -->
	</td>
	<td valign="middle" align="right" style="white-space: nowrap;">
		<?= $this->Html->link($this->Html->image("/images/buttons/Download-Now.png"), "/products/template_download?file=/templates/$relfile", array('escape'=>false)); ?>
		<img src="/images/icons/small/pdf.png" valign="middle"/>
	</td>
</tr>
<? } ?>
</table>
