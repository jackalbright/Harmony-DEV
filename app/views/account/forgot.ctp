<?php 

echo $form->create('Customer', array('url'=>array('controller'=>'account', 'action'=>'forgot'))); 
?>

If your email address is in our database, you will receive an email shortly with a link so that you can change your password.

<table>
<tr>
<td>
	<?= $form->input('eMail_Address', array('label'=>'','value'=>'')); ?>
	<script>
	enableDefaultText($('CustomerEMailAddress'), 'Your email address');
	</script>
</td>
<td>
<input type="image" src="/images/buttons/Send-grey.gif" value="Send"/>
</td>
</tr>
</table>

</form>

<!-- foo -->

<div style="height: 300px;">&nbsp;</div>
