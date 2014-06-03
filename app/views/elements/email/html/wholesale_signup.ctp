<p>
<?= $customer['First_Name'] ?> <?= $customer['Last_Name'] ?> <?= !empty($customer['Company']) ? "from ".$customer['Company'] : "" ?> has requested a wholesale account.

<p>Click on the link below to set their password and enable their account

<p><?= $html->link(HTTPHOST."/admin/account/edit/".$customer['customer_id']); ?>

