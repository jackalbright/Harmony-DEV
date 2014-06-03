<div>
	<?= $form->create("Customer",array('type'=>'file','url'=>array('action'=>'import'))); ?>
	<?= $form->input('file',array('type'=>'file','label'=>'Upload CSV')); ?>
	<?= $form->submit("Upload"); ?>

	<style>
	tbody.ignore
	{
		background-color: red;
	}
	tbody.ignore *
	{
		text-decoration: line-through;
	}
	tbody.ignore .addresses, tbody.ignore .account
	{
		display: none;
	}

	</style>

	<? if(!empty($customers)) { ?>
	<hr/>
	<h2>Review and fix records as necessary, then click 'Save' at the bottom</h2>
	<input id="master_ignore" type="checkbox" onClick="$$('.myob_record').each(function(t) { t.toggleClassName('ignore'); }); $$('.myob_ignore').each(function(c){c.checked = $('master_ignore').checked;}); "/> IGNORE ALL
	<table border=0 cellspacing=0>
		<? $i = 0; foreach($customers as $customer) { ?>
		<tbody class="myob_record" id="myob_<?= $customer['Record ID']?>" style="background-color: <?= $i % 2 == 0 ? "#CCC" : "#FFF"; ?>; ">
		<tr>
			<td rowspan=1>
				<input class="myob_ignore" type="checkbox" name="MYOBCustomer.<?= $i ?>.ignore" value="1" onClick="$('myob_<?= $customer['Record ID']?>').toggleClassName('ignore');"/> Ignore
			</td>
			<td>
				<label>MYOB Record ID</label>
				<?= $form->text("MYOBCustomer.$i.myob_record_id", array('size'=>5, 'value'=>$customer['Record ID'])); ?>
			</td>
			<td colspan=2>
				<?= $form->input("MYOBCustomer.$i.Company", array('value'=>$customer['Co./Last Name'],'size'=>100)); ?>
			</td>
		</tr>
		<tr class="account">
			<td colspan=1>&nbsp;</td>
			<td>
				<?= $form->input("MYOBCustomer.$i.customer_type", array('size'=>6, 'value'=>$customer['Identifiers'])); ?>
			</td>
			<td colspan=2>
				<table style="background-color: <?= $i % 2 == 0 ? "#CCC" : "#FFF"; ?>; "><tr><td width="10%">
					<?= $form->input("MYOBCustomer.$i.billme", array('type'=>'checkbox', 'value'=>1, 'checked'=>'checked', 'label'=>'BillMe Net-30')); ?>
				</td><td width="45%">
					<?= $form->input("MYOBCustomer.$i.eMail_Address", array('value'=>$customer['Addr 1 - Email'],'size'=>35)); ?>
					<?= $form->input("MYOBCustomer.$i.Password", array('value'=>"password2")); ?>
				</td><td>
					<?= $form->input("MYOBCustomer.$i.Phone", array('value'=>$customer['Addr 1 - Phone # 1'],'size'=>20)); ?>
				</td></tr></table>
			</td>
		</tr>
		<tr class="addresses">
			<td colspan=2>&nbsp;</td>
			<td>
				<b>Billing:</b>
				<?
					# FIX address and figure what's what.
					$b_in_care_of = $customer['Addr 1 - Line 1'];
					$b_address1 = $customer['Addr 1 - Line 2'];
					$b_address2 = $customer['Addr 1 - Line 3'];
					$b_address3 = $customer['Addr 1 - Line 4'];
					$b_city = $customer['Addr 1 - City'];
					$b_state = $customer['Addr 1 - State'];
					$b_zip = $customer['Addr 1 - ZIP Code'];

					if(!empty($b_in_care_of) && empty($b_address1))
					{
						$b_address1 = $b_in_care_of;
						$b_in_care_of = '';
					}
				?>
				<?= $form->input("BillingAddress.$i.In_Care_Of", array('value'=>$b_in_care_of,'size'=>50)); ?>
				<?= $form->input("BillingAddress.$i.Address1", array('value'=>$b_address1,'size'=>50)); ?>
				<?= $form->input("BillingAddress.$i.Address2", array('value'=>$b_address2,'size'=>50)); ?>
				<?= $form->input("BillingAddress.$i.City", array('value'=>$b_city)); ?>
				<?= $form->input("BillingAddress.$i.State", array('value'=>$b_state)); ?>
				<?= $form->input("BillingAddress.$i.Zip_Code", array('value'=>$b_zip)); ?>
			</td>
			<td>
				<b>Shipping:</b>
				<?
					# FIX address and figure what's what.
					$s_in_care_of = $customer['Addr 2 - Line 1'];
					$s_address1 = $customer['Addr 2 - Line 2'];
					$s_address2 = $customer['Addr 2 - Line 3'];
					$s_address3 = $customer['Addr 2 - Line 4'];
					$s_city = $customer['Addr 2 - City'];
					$s_state = $customer['Addr 2 - State'];
					$s_zip = $customer['Addr 2 - ZIP Code'];

					if(empty($s_in_care_of) && empty($s_address1))
					{
						$s_in_care_of = $b_in_care_of;
						$s_address1 = $b_address1;
						$s_address2 = $b_address2;
						$s_address3 = $b_address3;
						$s_city = $b_city;
						$s_state = $b_state;
						$s_zip = $b_zip;
					}

					if(!empty($s_in_care_of) && empty($s_address1))
					{
						$s_address1 = $s_in_care_of;
						$s_in_care_of = '';
					}
				?>
				<br/>
				<?= $form->input("ShippingAddress.$i.In_Care_Of", array('value'=>$s_in_care_of,'size'=>50)); ?>
				<?= $form->input("ShippingAddress.$i.Address1", array('value'=>$s_address1,'size'=>50)); ?>
				<?= $form->input("ShippingAddress.$i.Address2", array('value'=>$s_address2,'size'=>50)); ?>
				<?= $form->input("ShippingAddress.$i.City", array('value'=>$s_city)); ?>
				<?= $form->input("ShippingAddress.$i.State", array('value'=>$s_state)); ?>
				<?= $form->input("ShippingAddress.$i.Zip_Code", array('value'=>$s_zip)); ?>
			</td>
		</tr>
		</tbody>
		<? $i++; } ?>
	</table>
	<?= $form->submit("Save"); ?>
	<a href="<?= $url ?>">Start Over</a>
	<? } ?>

	<?= $form->end(); ?>
</div>
