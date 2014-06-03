<p>Welcome to Harmony Designs!

<p>Your <?= !empty($customer['is_wholesale']) ? "wholesale ":""?>account has been created. To log in, use the following account information:

<p><b>Email:</b> <?= $customer['eMail_Address'] ?>
<p><b>Password:</b> <?= $customer['Password'] ?>

<p>Log into our site at: <a href="<?=HTTPHOST?>/"><?=HTTPHOST?></a>

<p>From our site, you can now change personal and contact information, view past orders and reorder, and upload new custom images.

