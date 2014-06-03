<p>Your <?= !empty($customer['is_wholesale']) ? "wholesale ":""?>account email address has been changed to the following:

<p><b>New Email:</b> <?= $customer['eMail_Address'] ?>

<p>Log into our site at: <a href="<?=HTTPHOST?>/"><?=HTTPHOST?></a>

