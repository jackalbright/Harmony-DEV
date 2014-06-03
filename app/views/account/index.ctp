<style>
h3 { font-weight: bold; }
</style>
<div style="width: 600px;">
	<h3 align="center">
		<?= $customer['First_Name'] ?>
		<?= $customer['Last_Name'] ?>
		&mdash;
		<?= $customer['eMail_Address'] ?>
	</h3>

	<div class="grey_header_top"><span></span></div>
	<table cellspacing=15 style="background-color: #CCC;" width="100%">
	<tr>
		<td>
			<h3>Orders</h3>
			<ul>
				<li> <a href="/cart">View Cart</a>
				<li> <a href="/purchases">View Order History / Reorder</a> 
			</ul>
		</td>
		<td>
			<h3>Custom Items</h3>
			<ul>
				<li> <a href="/custom_images/add">View Saved Pictures</a>
				<li> <a href="/custom_images/add">Upload New Pictures</a>
				<li> <a href="/saved_items">View Saved Designs</a>
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			<h3>Account Management</h3>
			<ul>
				<li> <a href="/account/edit">Personal / Contact Information</a>
				<li> <a href="/account/change_password">Change Password</a>
				<li> <a href="/account/address_select">Addresses</a>
				<li> <a href="/account/payment_select">Update Payment Information</a>
			</ul>
		</td>
	</tr>
	</table>
	<div class="grey_header_bottom"><span></span></div>

</div>



