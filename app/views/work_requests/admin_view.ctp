<div>
	<h2>Work Request #<?= $workRequest['WorkRequest']['work_request_id'] ?></h2>
	<table width="100%">
	<tr>
		<td>
			<h3>Customer Information:</h3>
			<div>
				<b>Name:</b> <?= $workRequest['WorkRequest']['name'] ?><br/>
				<b>Email:</b> <a href="mailto:<?= $workRequest['WorkRequest']['email'] ?>">
					<?= $workRequest['WorkRequest']['email'] ?>
					</a><br/>
				<b>Phone:</b> <?= $workRequest['WorkRequest']['phone'] ?><br/>
				<br/>
				<b>Ship Address:</b> <?= $workRequest['ShippingAddress']['Address_1'] ?><br/>
				<b>Ship City:</b> <?= $workRequest['ShippingAddress']['City'] ?><br/>
				<b>Ship State:</b> <?= $workRequest['ShippingAddress']['State'] ?><br/>
				<b>Ship Zip:</b> <?= $workRequest['ShippingAddress']['Zip_Code'] ?><br/>

			</div>
		</td>
		<td>
			<h3>Billing Information:</h3>
			<div>
				<? if($workRequest['WorkRequest']['paypal']) { ?>
					<b>Paypal</b>: <?= $workRequest['WorkRequest']['email'] ?>
					<div class="alert">This customer has NOT been automatically billed. You must login to PayPal and manually charge them for the order</div>
				<? } else { ?>
					<b>Card #:</b> <?= $hd->decryptCreditCard($workRequest['CreditCard']['Number']); ?><br/>
					<b>Expiration:</b> <?= !empty($workRequest['CreditCard']['Expiration']) ? date("m/Y", strtotime($workRequest['CreditCard']['Expiration'])) : null; ?><br/>
					<br/>
					<b>Bill Address:</b> <?= $workRequest['BillingAddress']['Address_1'] ?><br/>
					<b>Bill City:</b> <?= $workRequest['BillingAddress']['City'] ?><br/>
					<b>Bill State:</b> <?= $workRequest['BillingAddress']['State'] ?><br/>
					<b>Bill Zip:</b> <?= $workRequest['BillingAddress']['Zip_Code'] ?><br/>
				<? } ?>
				<? if($workRequest['WorkRequest']['wholesale']) { ?>
				<br/>
				<br/>
				<br/>
				<b>WHOLESALE</b>
				<? } ?>
				
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<h3>Product Order Information:</h3>
			<div>
				<b>Product:</b> <?= $workRequest['Product']['name']; ?><br/>
				<b>Image:</b> 
						<a href="<?= $workRequest['WorkRequest']['image_location']; ?>">
							<img height=100 src="<?php echo $workRequest['WorkRequest']['image_location']; ?>"/>
						</a>
						<br/>
						<a href="<?= $workRequest['WorkRequest']['image_location']; ?>">
							<?= $workRequest['WorkRequest']['image_location']; ?>
						</a>
						<br/>
				<b>Quantity:</b> <?= $workRequest['WorkRequest']['quantity']; ?><br/>
				<b>Comments/Details:</b>
						<?php echo $workRequest['WorkRequest']['comments']; ?>
						<br/>
				<b>Proof:</b>
						<? $proof_only = $workRequest['WorkRequest']['proof_only']; ?>
						<? if($proof_only == 2) { ?>
							No Proof
						<? } else if ($proof_only == 1) { ?>
							Proof WITHOUT order
						<? } else { ?>
							Proof with order
						<? } ?>
						<br/>

				<b>Pre-Production Sample:</b>
						<?= $workRequest['WorkRequest']['pre_production'] ? "Yes" : "No"; ?><br/>

				<b>Random Sample:</b>
						<?= $workRequest['WorkRequest']['random_sample'] ? "Yes" : "No"; ?><br/>
				
			</div>
		</td>
	</tr>
	</table>
</div>

<hr/>

<div class="workRequests view hidden">
<h2><?php  __('WorkRequest');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Work Request Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workRequest['WorkRequest']['work_request_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workRequest['WorkRequest']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workRequest['WorkRequest']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workRequest['WorkRequest']['phone']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($workRequest['Product']['name'], array('controller'=> 'products', 'action'=>'view', $workRequest['Product']['product_type_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workRequest['WorkRequest']['quantity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Image Location'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<a href="<?= $workRequest['WorkRequest']['image_location']; ?>">
				<img height=100 src="<?php echo $workRequest['WorkRequest']['image_location']; ?>"/>
			</a>
			<br/>
			<a href="<?= $workRequest['WorkRequest']['image_location']; ?>">
				<?= $workRequest['WorkRequest']['image_location']; ?>
			</a>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Credit Card'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($workRequest['CreditCard']['credit_card_id'], array('controller'=> 'credit_cards', 'action'=>'view', $workRequest['CreditCard']['credit_card_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Billing Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($workRequest['BillingAddress']['Contact_ID'], array('controller'=> 'contact_infos', 'action'=>'view', $workRequest['BillingAddress']['Contact_ID'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Shipping Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($workRequest['ShippingAddress']['Contact_ID'], array('controller'=> 'contact_infos', 'action'=>'view', $workRequest['ShippingAddress']['Contact_ID'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Proof Only'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workRequest['WorkRequest']['proof_only']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pre-Production Sample'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workRequest['WorkRequest']['pre_production']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Random Sample'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workRequest['WorkRequest']['random_sample']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Comments'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workRequest['WorkRequest']['comments']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions hidden">
	<ul>
		<li><?php echo $html->link(__('Edit WorkRequest', true), array('action'=>'edit', $workRequest['WorkRequest']['work_request_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete WorkRequest', true), array('action'=>'delete', $workRequest['WorkRequest']['work_request_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $workRequest['WorkRequest']['work_request_id'])); ?> </li>
		<li><?php echo $html->link(__('List WorkRequests', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New WorkRequest', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Products', true), array('controller'=> 'products', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product', true), array('controller'=> 'products', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Credit Cards', true), array('controller'=> 'credit_cards', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Credit Card', true), array('controller'=> 'credit_cards', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Contact Infos', true), array('controller'=> 'contact_infos', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Billing Address', true), array('controller'=> 'contact_infos', 'action'=>'add')); ?> </li>
	</ul>
</div>