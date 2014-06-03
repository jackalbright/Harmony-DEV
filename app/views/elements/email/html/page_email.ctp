<p>
	A link to harmonydesigns.com has been sent to you<?= !empty($your_name) ? " by $your_name":""?>.
</p>

<? if(!empty($custom_message)) { ?>
<p>
	Sender's comment: <?= nl2br($custom_message) ?>
</p>
<? } ?>

Click on the link below to view:
<p>
<a href="<?= $url ?>"><?= $url ?></a>
</p>
