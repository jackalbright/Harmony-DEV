<div class="customImage form">
<?
	#echo "<div class='right_align top_padded small_bottom_padded'>";
	#echo $html->link(__('View All Images', true), array('action'=>'index'));
	#echo "</div>";
?>

	<fieldset>
	<table border="0" width="100%">
	<tr>
		<td width="50%" align="center" valign="top">
			<div align="left">
			<p>
				Tips for uploading your completed art:
			</p>
			<ul>
				<li>
				<li> Include your name, phone number and email so we can contact you
				<li> The following formats can be uploaded: JPG, PNG, GIF, PDF, PSD, ZIP
				<li> Please limit file sizes to 2 MB, or otherwise send it <a href="Javascript:void(0);" onClick="mail(this,'graphics@harmonydesigns.com');">via email</a>

			</ul>
			</div>
		</td>
		<td valign="top" width="50%" style="padding-left: 100px;">
		<?php echo $form->create('CustomImage',array('url'=>array('action'=>'emailart'), 'type'=>'file')); ?>
			<? echo $form->input('name', array('class'=>'required')); ?>
			<? echo $form->input('email', array('class'=>'required')); ?>
			<? echo $form->input('phone', array('class'=>'required')); ?>
			<? echo $form->input('file',array('type'=>'file','label'=>"Upload File",'class'=>'required')); ?>
			<br/>

			<input type="image" src="/images/buttons/Send-grey.gif"/>

		<?php echo $form->end(); ?>
		</td>
	</tr>
	</table>
	</fieldset>
</div>
