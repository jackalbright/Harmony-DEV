<p>
Your order, #<?=$purchaseID?>, has been submitted for processing. If you have any questions about your order, please feel free to contact us. We look forward to serving you again.

</p>

<?

# XXX TODO WORK ON TEMPLATE FOR HTML EMAILS....

# NOW SHOW ORDER...
include_once(APP . "/../includes/order_details.php"); 

print_order_customer($purchaseID, $database, 'customer');#, $shippingOptions);
print_order_items($purchaseID, $database, 'customer');#, $shippingOptions);

?>
