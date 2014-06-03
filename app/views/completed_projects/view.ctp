<? if(true || !empty($sent)) { ?>
	<? $this->set("body_title", "Your Completed Project Has Been Sent"); ?>
<? } else { ?>
	<? $this->set("body_title", "Review Your Information For Your Completed Project"); ?>
<? } ?>
<? $id = !empty($completedProject['CompletedProject']['id']) ? $completedProject['CompletedProject']['id'] : null; ?>
<div class="completedImages form" style="background-color: white;">
	<div class="right">
<? if(false && empty($sent)) { ?>
		<table><tr><td>
			<a href="/completed_projects/edit/<?= $id ?>"><img src="/images/buttons/Edit-info-picture.gif"/></a>
		</td><td width="50" align="center">
		<b>OR</b></td><td>
			<a href="/completed_projects/send/<?= $id ?>"><img src="/images/webButtons2014/blue/large/sendFinishedProject.png"/></a>
		</table>
<? } else { ?>
		<? if(!empty($product)) { ?>
			<a href="/details/<?= $product['Product']['prod'] ?>.php"><img src="/images/buttons/Continue-Shopping-grey.gif"/></a>
		<? } else { ?>
			<a href="/products"><img src="/images/buttons/Continue-Shopping-grey.gif"/></a>
		<? } ?>
<? } ?>
	</div>
<? if(false && empty($sent)) { ?>
	<p style='padding-left: 15px; color: #0369A7; padding-bottom: 15px;'>Review the information below to make sure project details<br/>are accurate, then click 'Send Finished Project'. 
	</p>
<? } ?>

<div class='clear'></div>

	<h2>Your Information</h2>
	<div class='items'>

	<label>Your Organization</label>
	<div><?= $completedProject['CompletedProject']['company'] ?>&nbsp;</div>

	<label>Account Type</label>
	<div class=''>
		<?= !empty($completedProject['CompletedProject']['wholesale_customer']) ? "Wholesale/Reseller" : "Personal/Retail"; ?>
	</div>

	<label>Your Full Name</label>
	<div><?= $completedProject['CompletedProject']['full_name'] ?>&nbsp;</div>

	<label>Your Email</label>
	<div><?= $completedProject['CompletedProject']['email'] ?>&nbsp;</div>

	<label>Your Phone</label>
	<div><?= $completedProject['CompletedProject']['phone'] ?>&nbsp;</div>

	</div>
	
	<h2>Project Information</h2>

	<? $printing = $completedProject['CompletedProject']['printing_on_back']; ?>
	<? $images = $completedProject['CompletedImage']; ?>
	<div class='right' style="width: 375px;">
	<table width="100%"><tr>
	<td width="50%" valign="top">
		<? if(!empty($images[0]['id'])) { ?>
			<? if($printing != 'none') { ?>
				<b>Side 1:</b><br/>
			<? } ?>
			<img src='/completed_images/thumb/<?= $images[0]['id'] ?>' style="max-width: 150px; max-height: 200px;"/>
		<? } ?>
	</td>
	<td valign="top">
	<? if($printing == 'same') { ?>
		<b>Side 2:</b><br/>
		<img src='/completed_images/thumb/<?= $images[0]['id'] ?>' style="max-width: 150px; max-height: 200px;" />
	<? } else if($printing == 'different') { ?>
		<b>Side 2:</b><br/>
		<img src='/completed_images/thumb/<?= $images[1]['id'] ?>' style="max-width: 150px; max-height: 200px;" />
	<? } ?>
	</td>
	</tr></table>
	</div>

	<div class='items' style="overflow: hidden;">

		<label>Product</label>
		<div style='overflow: hidden;'><?= $completedProject['Product']['long_name'] ?>&nbsp;</div>
	
		<label>Quantity</label>
		<div><?= $completedProject['CompletedProject']['quantity'] ?>&nbsp;</div>
	
		<label>Project Name</label>
		<div><?= $completedProject['CompletedProject']['project_reference'] ?>&nbsp;</div>
	
		<label>Needed By</label>
		<div><?= date("m/d/Y", strtotime($completedProject['CompletedProject']['needed_by'])) ?> <?= !empty($completedProject['CompletedProject']['needed_by_strict']) ? "(Strict deadline)":"" ?> &nbsp;</div>
	
		<label>Services Needed</label>
		<div class='' style='margin-left: 225px; '>
			<?= !empty($completedProject['CompletedProject']['free_consultation']) ? "Free consultation<br/><br/>":"" ?>
			<?= !empty($completedProject['CompletedProject']['free_email_proof']) ? "Email proof with your paid order (FREE) &bull; Includes one free revision if needed<br/><br/>":"" ?>
			<?= !empty($completedProject['CompletedProject']['proof_without_order']) ? "Email proof without an order ($25) &bull; Includes one free revision if needed<br/><br/>":"" ?>
			<?= !empty($completedProject['CompletedProject']['free_quote']) ? "Free quote<br/><br/>":"" ?>
			<? $printing_back = $completedProject['CompletedProject']['printing_on_back']; ?>
			<? if($printing_back == 'same') { ?>
				Print on two sides &ndash; Same art both sides
			<? } else if($printing_back == 'different') { ?>
				Print on two sides &ndash; Different art on each side
			<? } ?>
		</div>
		<div class='clear'></div>
	
		<label>Comments/Instructions</label>
		<div><?= nl2br($completedProject['CompletedProject']['comments']) ?>&nbsp;</div>
		<br/>
		<br/>


	</div>
	<div class='clear'></div>

	<div style="margin-left: 190px;">
<? if(false && empty($sent)) { ?>
		<table><tr><td>
			<a href="/completed_projects/edit/<?= $id ?>"><img src="/images/buttons/Edit-info-picture.gif"/></a>
		</td><td width="50" align="center">
		<b>OR</b></td><td>
			<a href="/completed_projects/send/<?= $id ?>"><img src="/images/webButtons2014/blue/large/sendFinishedProject.png"/></a>
		</table>
<? } else { ?>
		<? if(!empty($product)) { ?>
			<a href="/details/<?= $product['Product']['prod'] ?>.php"><img src="/images/webButtons2014/grey/large/continueShopping.png"/></a>
		<? } else { ?>
			<a href="/products"><img src="/images/webButtons2014/grey/large/continueShopping.png"/></a>
		<? } ?>
<? } ?>
	</div>
	<br/>
	<br/>
	<br/>
	<br/>

</div>
<style>
	.items > * 
	{
		padding-top: 15px;
		font-size: 14px;
	}
	#main_column .form label,
	#main_column .form .text label,
	#main_column .form .select label,
	#main_column .form .file label,
	#main_column .form .textarea label
	{
		clear: left;
		font-size: 14px;
		display: block;
		float: left;
		width: 175px;
		text-align: right;
		margin-right: 50px;
	}

	#main_column div.input
	{
		font-size: 14px;
		margin-top: 10px;
	}

	#main_column h2
	{
		margin-top: 10px;
		background-color: #CCC;
		padding: 5px;
		font-size: 18px;
	}
	#main_column .section
	{
		padding: 5px5
	}

	#main_column .formerror
	{
		margin-left: 200px;
	}

</style>
