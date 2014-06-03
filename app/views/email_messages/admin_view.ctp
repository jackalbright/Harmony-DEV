<div>
	<br/>
	<br/>

	<div><b>Sent:</b> <?= date("m/d/Y H:i:s", strtotime($emailMessage['EmailMessage']['created'])); ?> </div>
	<div><b>To:</b> <?= join(", ", split("\n", $emailMessage['EmailMessage']['recipients'])); ?> </div>
	<div><b>Account Created:</b> <?= !empty($emailMessage['EmailMessage']['create_account']) ? $emailMessage['EmailMessage']['create_account'] : 'No'; ?></div>
	<? if(!empty($emailMessage['EmailMessage']['create_account'])) { ?>
	<div><b>Billing Type:</b> <?= !empty($emailMessage['EmailMessage']['allow_billme']) ? 'BillMe' : 'Credit Card'; ?></div>
	<? } ?>
	<div><b>Subject:</b> <?php echo $emailMessage['EmailMessage']['subject']; ?> </div>
	<div><b>Message:</b>
		<?php echo $emailMessage['EmailMessage']['custom_message']; ?> 
	</div>

	<div>
		<?= $this->requestAction("/admin/email_templates/message_view/".$emailMessage['EmailMessage']['email_message_id'], array('return')); ?>
	</div>

</div>
