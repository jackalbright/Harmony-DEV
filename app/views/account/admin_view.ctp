<div class="customer view">
<h2><?php  __('View Customer');?></h2>
	<br/>
	<a href="/admin/tracking_requests/session/<?= $cust['Customer']['eMail_Address']; ?>"> Track </a>
		| <?php echo $html->link(__('Edit Customer', true), array('action'=>'edit', $cust['Customer']['customer_id'])); ?> </li>
		| <?php echo $html->link(__('Delete Customer', true), array('action'=>'delete', $cust['Customer']['customer_id']), array('style'=>'color: red;'), sprintf(__('Are you sure you want to delete # %s?', true), $cust['Customer']['customer_id'])); ?> </li>

	<br/>
	<br/>

	<table width="100%">
	<tr><td width="33%">

	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Customer Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cust['Customer']['customer_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('First Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cust['Customer']['First_Name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Last Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cust['Customer']['Last_Name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('EMail Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<a href="mailto:<?= $cust['Customer']['eMail_Address']; ?>" title="Send Email">
				<?php echo $cust['Customer']['eMail_Address']; ?>
			</a>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Password'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cust['Customer']['Password']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Company'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cust['Customer']['Company']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cust['Customer']['Phone']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cust['Customer']['dateAdded']; ?>
			&nbsp;
		</dd>
	</dl>

	</td>
	<td width="33%">
		<? if(!empty($cust['PreferredShippingAddress'])) { ?>
		<h3>Main Shipping Address</h3>
		<div>
			<? $sa = $cust['PreferredShippingAddress']; ?>
			<?= !empty($sa['Company']) ? $sa['Company'] : null ?><br/>
			<?= !empty($sa['In_Care_Of']) ? $sa['In_Care_Of'] : null?><br/>
			<?= $sa['Address_1'] ?><?= !empty($sa['Address_2']) ? ", ".$sa['Address_2'] : "" ?><br/>
			<?= $sa['City'] ?>, <?= $sa['State'] ?> <?= $sa['Zip_Code'] ?> <?= $sa['Country'] ?><br/>
		</div>
		<? } ?>
	</td><td>
		<? if(!empty($cust['PreferredBillingAddress'])) { ?>
		<h3>Main Billing Address</h3>
		<div>
			<? $sa = $cust['PreferredBillingAddress']; ?>
			<?= !empty($sa['Company']) ? $sa['Company'] : null ?><br/>
			<?= !empty($sa['In_Care_Of']) ? $sa['In_Care_Of'] : null?><br/>
			<?= $sa['Address_1'] ?><?= !empty($sa['Address_2']) ? ", ".$sa['Address_2'] : "" ?><br/>
			<?= $sa['City'] ?>, <?= $sa['State'] ?> <?= $sa['Zip_Code'] ?> <?= $sa['Country'] ?><br/>
		</div>
		<? } ?>
	</td>
	</tr></table>

<hr/>

<h3>Uploaded Art</h3>
	<? if(empty($custom_images)) { ?>
		<div class="bold">No art has been uploaded by this customer</div>
	<? } else { ?>
		<? foreach($custom_images as $image) { ?>
		<div class='left' style="padding: 10px;">
			<? $thumb = $this->Html->image($image['CustomImage']['thumbnail_location']); ?>
			<?= $this->Html->link($thumb, $image['CustomImage']['Image_Location'], array('escape'=>false)); ?>
		</div>
		<? } ?>
		<div class='clear'></div>
	<? } ?>

<h3 id='CartItems'>Cart Items</h3>
	<div><?= $html->link("ADD AN ITEM", "/admin/cart_items/add/customer_id:{$cust['Customer']['customer_id']}", array('style'=>'font-size: 24px; color: #B82A2A;')); ?></div>

	<? if(empty($shoppingCart)) { ?>
		<div class="bold">No items are in this customer's cart</div>
	<? } else { ?>
	<form id="CartForm" method="POST" action="/admin/cart/update">
		<?= $this->element("cart/cart", array('nosummary'=>1,'customer'=>$cust['Customer'])); ?>
	</form>
	<? } ?>

<hr/>

<h3 id="SavedOrders">Previously Saved Orders</h3>
<div>
	<?= $this->requestAction("/admin/purchases/by_customer/{$cust['Customer']['customer_id']}", array('return')); ?>
</div>

<hr/>


</div>
