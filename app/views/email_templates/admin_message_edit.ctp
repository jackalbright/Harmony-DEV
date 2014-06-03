<?
echo $form->input("EmailMessage.subject", array('value'=>!empty($emailLetter['EmailLetter']['subject'])? $emailLetter['EmailLetter']['subject'] : $emailTemplate['EmailTemplate']['subject'],'style'=>'width: 500px;')); 
?>

<? echo $form->input("EmailMessage.custom_message", array('value'=>!empty($emailLetter['EmailLetter']['custom_message']) ? $emailLetter['EmailLetter']['custom_message'] : $emailTemplate['EmailTemplate']['message'],'style'=>'width: 500px;')); ?>

<script>
	loadEditor('EmailMessageCustomMessage');
</script>
