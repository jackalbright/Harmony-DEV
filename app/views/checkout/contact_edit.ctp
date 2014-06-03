<div>
<?
#print_r($customer);
?>

<?= $form->create("Customer", array('url'=>"/checkout/contact_edit", 'onSubmit'=>'return verifyRequiredFields();', 'id'=>'CustomerForm')); ?>

<table cellpadding=5 width="100%">
<tr>
	<td valign="top">
		<!--Your contact information is required to properly<br/> follow up on your order if we have any questions. 
		<br/>
		-->
		<?= $form->input("eMail_Address", array('class'=>'required','after'=>'<br/><div class="alert2">For order questions and confirmation</div>','onChangeX'=>'assertEmail(this);')); ?>
		<?= $form->input("Phone", array('class'=>'required','after'=>'<br/><div class="alert2">Required for shipping and delivery</div>','onChangeX'=>'assertPhone(this);')); ?>

		<br/>
		None of the above information is used for other purposes

		<br/>
		<br/>
		<a href="Javascript:void(0)" onClick="popup('/info/privacy.php',1000,600);">Privacy Policy</a>
	</td>
	<? if(empty($customer['Customer']['Password'])) { ?>
	<td valign="top" align="">
		<div class="right" style="width: 350px; background-color: #EEE; border: solid #CCC 1px; margin-right: 100px; margin-top: 15px;">
		<?= $this->element("account/create_optional"); ?>
		</div>
	</td>
	<? } ?>
</tr>

<tr>
	<td colspan=2 align="center">
			<input type="image" src="/images/buttons/Next.gif" onClick="showPleaseWait();"/>
	</td>
</tr>
</table>

	<?= $this->element("cart/cart",array('checkout'=>1,'read_only_summary'=>1)); ?>
</form>

<div>
</div>

</div>
