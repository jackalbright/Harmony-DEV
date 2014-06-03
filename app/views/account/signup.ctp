<div id="customer_signup" class="customers form">

<div class="form_sidebar_text hidden" id="members_signup_text">
</div>

<?php echo $form->create("Customer", array('url'=>array('controller'=>'account','action'=>'signup'),'onSubmit'=>'return verifyRequiredFields(this);')); 
?>
	<fieldset>
		<table class="editform">
	<?php
		echo $html->tableCells(array(
			#array(
				#$form->input('member_type',array('label'=>'Membership Type','options'=>$member_types,'onChange'=>'reloadSignupForm(this);')),
			#),
			array(
				$form->input('First_Name') ."<br/>".
				$form->input('Last_Name'),
			),
			array(
				$form->input('eMail_Address',array('label'=>'Email'))."<br/>".
				$form->input('Company', array('label'=>'Company (optional)')),
			),

			array(
				$form->input('Password',array('type'=>'password','value'=>'','class'=>'required','after'=>'<br/>Please create a password with 6 characters or more')) . "<br/>".
				$form->input('Password2',array('type'=>'password','value'=>'','label'=>'Re-Type Your Password','after'=>'','class'=>'required')),
			),
			array(
				$form->input('Mail_List',array('type'=>'checkbox','checked'=>'checked','label'=>'Mailing list subscription (optional)','after'=>'<br/>Join our mailing list to be contacted with new promotions, offers, products and additions to our catalog.')) ."<br/>".
				$html->link("Privacy Policy", "/info/privacy.php"),
			),

		));
	?>
		<tr><td colspan=2>
		</td></tr>

		</table>
	</fieldset>
	<input type="image" src="/images/buttons/Signup-Now.gif"/>
</form>
</div>
