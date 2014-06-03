<p>
Order #<?=$purchaseID?> has been received.
</p>

<p>

<a href="https://<?= $_SERVER['HTTP_HOST'] ?>/admin/purchases">Access admin to retrieve the order</a>.<br/>

</p>

<?

# XXX TODO WORK ON TEMPLATE FOR HTML EMAILS....

# NOW SHOW ORDER...
include_once(APP . "/../includes/order_details.php"); 

print_order_customer($purchaseID, $database, 'admin');#, $shippingOptions);
print_order_items($purchaseID, $database, 'admin');#, $shippingOptions);

?>
