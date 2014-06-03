<table width="100%">
<tr>
<td valign="top">
<?= $this->data['EmailMessage']['custom_message'] ?>
</td>
<? if(!empty($this->data['Customer'])) { ?>
<td valign="top">
	<div align="left" style="border: solid #888 1px; background-color: #CCC; width: 350px; padding: 5px; float: right;">
	For your convenience, an account has been created to view accurate pricing, place orders, and re-order conveniently in the future.<br/>
	Accessing your account is available by clicking on the 'Log In' button on the top right of any page.

	<br/>
	<br/>
	<b>Your Email:</b> <?= $this->data['Customer']['eMail_Address'] ?><br/>
	<b>Your Password:</b> <?= $this->data['Customer']['Password'] ?><br/>
	</div>
	<div class="clear"></div>
</td>
<? } ?>
</tr>
</table>

<?= $this->element("email_templates/".$emailTemplate['EmailTemplate']['name']); ?>
