<script>
var products_by_id = <?= json_encode($products_by_id); ?>;
</script>
<? $id = !empty($this->data['CompletedImage']['id']) ? $this->data['CompletedImage']['id'] : null; ?>
<? if($id) { ?>
	<? $this->set("body_title", "Edit Your Information For Your Completed Project"); ?>
<? } else { ?>
	<? $this->set("body_title", "Send Your Completed Project"); ?>
<? } ?>
<div class="completedImages form" style="background-color: white;">
<?php echo $this->Form->create('CompletedImage', array('type'=>'file','onSubmit'=>'if(verifyRequiredFields(this)) { if(fullName()) { j.spin(); return true; } else { return false;} } else { j.unspin(); return false; }'));?>

	<p style="color: #B82A2A;">
	If you have completed art, fill out this online form and attach your completed design. We'll be in touch with you within 1-2 business days to discuss your project.
	</p>


	<script>
	function fullName()
	{
		if(!j('#CompletedImageFullName').val().match(/\w\s+\w/))
		{
			alert("Please provide your full name");
			j('#CompletedImageFullName').focus();
			return false;
		}
		return true;
	}
	</script>

<!--
	<p align="center" style="">Upload your finished design and we'll create your products.</p>
	-->

	
	<h2>Project Information</h2>

	<? echo $this->Form->input('product_type_id', array('id'=>'ProductTypeId', 'class'=>'Product required','label'=>'Product','options'=>$products, 'default'=>!empty($product)?$product['Product']['product_type_id']:null,'empty'=>'Select a product:')); ?>
	<div class="" style="margin-left: 175px; padding-top: 5px; ">
		<a style="<?= empty($product['Product']['code']) ? "display:none;" : "" ?>" id="project_download_template" href="/products/template/<?= !empty($product) ? $product['Product']['code'] : null ?>">Template &amp; specifications</a> 
	</div>

<? if(!empty($id)) { ?>
	<div class='right' style="width: 375px;">
	<table width="100%"><tr>
	<td width="50%" valign="top">
	<? $printing = !empty($this->data['CompletedImage']['printing_on_back']) ? $this->data['CompletedImage']['printing_on_back'] : null; ?>

	<? if(!empty($this->data['CompletedImage']['filename'])) { ?>
	<div class='right'>
		<? if(!empty($this->data['CompletedImage']['file2_filename'])) { ?>
			<b>Side 1:</b><br/>
		<? } ?>
		<img src='/completed_images/thumb/<?= $id ?>' style="max-width: 150px; max-height: 200px;"/>
	</div>
	<? } ?>
	</td><td valign="top">
	<div id="side2_box">
	<? if($printing == 'same') { ?>
		<b>Side 2:</b><br/>
		<img id='side2_thumb' src='/completed_images/thumb/<?= $id ?>' style="max-width: 150px; max-height: 200px;" />
	<? } else if($printing == 'different') { ?>
		<b>Side 2:</b><br/>
		<img id='side2_thumb' src='/completed_images/thumb/<?= $id ?>/side2' style="max-width: 150px; max-height: 200px;" />
	<? } ?>
	</div>
	</td></tr></table>
	</div>
<? } ?>
	<div style="overflow: hidden;">


	<div class="left">
	</div>
	<div class="clear"></div>
	<script>
	j('#ProductTypeId').change(function() {
		var pid = j(this).val();
		var prod = pid ? products_by_id[pid]['code'] : null;
		//console.log("P="+pid+", PROD="+prod);

		if(prod && prod.match(/^(B|BC|BB|BNT|RL)$/))
		{
			j('#printing_back').show();
			j('#printing_back select').change();
		} else {
			j('#printing_back').hide();
			j('#printing_back select').change();
		}

		if(!pid) { 
			j('#project_download_template').hide();
			j('#quantityCol').hide();
			return; 
		}

		j('#project_download_template').attr('href', "/products/template/"+pid).show();
		j.get("/completed_images/get_product/"+pid, null, function(response) {

			if(response.minimum)
			{
				j('#quantityCol').show();
				j('#CompletedImageQuantity').val(response.minimum);
				j('#minimum').val(response.minimum);
				j('#minimum_notice').html(response.minimum);
			}
		});
	});
	j(document).ready(function() { j('#ProductTypeId').change(); });
	</script>
<div id='quantityCol' style='<?= empty($this->data['CompletedImage']['product_type_id']) ? "display:none;" : "" ?>'>
	<div class="left">
	<?
		$min = $qty = !empty($product['Product']['minimum']) ? $product['Product']['minimum'] : 1;
		echo $this->Form->input('quantity',array('size'=>3, 'class'=>'required','default'=>$qty));
	?>
	</div>
	<div class='left' style="padding-top: 15px;">&nbsp;&nbsp; Min is <span id='minimum_notice'><?= $min ?></span></div>
	<div class="clear"></div>
</div>
	<?= $this->Form->hidden("minimum", array('id'=>'minimum', 'value'=>$min)); ?>
	<script>
		j('#CompletedImageQuantity').change(function() {
			var min = parseInt(j('#minimum').val());
			if(!min) { min = 1; }

			var qty = parseInt(j(this).val());

			if(qty < min)
			{
				alert("Minimum is "+min);
				j('#CompletedImageQuantity').val(min);
				return false;
			}
			return true;
		});

	j('#project_download_template').click(function (e) {
		var href = j(this).prop('href');
		e.stopPropagation();
		j('#modal').load(href, null, function()
		{
			j('#modal').dialog({
				width: 700,
				title: "Download Templates",
				modal: true,
				resizable: false,
				draggable: false
			});

			j('.ui-widget-overlay').click(function() {
				j('#modal').dialog('close');
			});
		});

		return false;

	});
	</script>

	<div id="printing_back" style="display: none;">
		<?
		$print_options = array(
			'none'=>'Print on one side',
			'same'=>'Print on two sides - Same art both sides',
			'different'=>'Print on two sides - Different art on each side',
		);
		?>
		<?= $this->Form->input('printing_on_back',array('type'=>'select','options'=>$print_options, 'label'=>'Print Side(s)')); ?>
		<p id='printing_costs' style="margin-left: 175px; font-weight: bold; padding-top: 5px;">For this service there is a 
			20&cent; print charge for each item<br/> +
			one-time $30 set-up charge
	</div>
	<script>
	j('#printing_back select').change(function() {
		var pid = j('#ProductTypeId').val();
		var prod = pid ? products_by_id[pid]['code'] : null;

		/*
		if(prod && prod.match(/^(B|BC|BB|BNT|RL|KC|SMKC|ORN-CER|ORN|MG)$/)) {
			j('#side2_upload').show();
		} else { 
			j('#side2_upload').hide();
		}
		*/

		var setting = j(this).val();

		if(setting == 'none')
		{
			j('#printing_costs').hide();
			j('#side2_upload').hide();
		} else if (setting == 'same') {
			j('#printing_costs').show();
			j('#side2_upload').hide();
			j('#side2_box').hide();
		} else if (setting == 'different') { 
			j('#printing_costs').show();
			j('#side2_upload').show();
			j('#side2_box').show();
		}
	});
	j(document).ready(function() { j('#printing_back select').change(); });
	</script>

	<?  $limit = "2M"; ?>

	<? echo $this->Form->input('file',array('type'=>'file','label'=>(!empty($id)?'Replace Existing Art (optional)':'Upload Your Art'),'class'=>(empty($id)?'required':''))); ?>
	<div style="padding-left: 200px; color: grey;">JPG, PNG, GIF, TIF, PSD, PDF, EPS. <?= $limit ?> limit</div>

	<div id="side2_upload" style="<?= empty($this->data['CompletedImage']['printing_back']) || $this->data['CompletedImage']['printing_back'] != 'different' ? "display:none;" : "" ?>">
		<? echo $this->Form->input('file2',array('type'=>'file','label'=>(!empty($id)?'Replace Side 2 Art (optional)':'Upload Side 2 Art'))); ?>
		<div style="padding-left: 200px; color: grey;">JPG, PNG, GIF, TIF, PSD, PDF, EPS. <?= $limit ?> limit</div>
	</div>

		<br/>



	<?= $this->Form->hidden('id'); ?>

		<?= $this->Form->input("project_reference", array('label'=>'Project Name (optional)', 'size'=>30)); ?>

	<?  echo $this->Form->input('needed_by', array('id'=>'NeededBy', 'type'=>'text', 'label'=>'Needed by (mm/dd/yy)','size'=>'14','class'=>'required','div'=>array('class'=>'input left text pointer'))); ?>
	<?  echo $this->Form->input('needed_by_strict', array('label'=>'This project has a strict deadline','div'=>array('class'=>'left checkbox input', 'style'=>'padding-left: 8px;'))); ?>
	<div class='clear'></div>

	<script>
	j('#NeededBy').datepicker({
		showOn: "both",
		buttonImage: "/images/cal.gif",
		buttonImageOnly: true,
		dateFormat: "mm/dd/yy"

	});
	</script>

	<div class='text input'>
		<label>Services Needed</label>
		<div class="" style="margin-left: 170px;">
			<div style="font-size: 10px;">(Check all that apply)</div>
			<?= $this->Form->input('free_consultation',array('type'=>'checkbox','label'=>'Free consultation')); ?>
			<?= $this->Form->input('free_email_proof',array('type'=>'checkbox','label'=>'Email proof with your paid order (FREE) &bull; Includes one free revision if needed')); ?>
			<?= $this->Form->input('proof_without_order',array('type'=>'checkbox','label'=>'Email proof without an order ($25) &bull; Includes one free revision if needed')); ?>
			<?= $this->Form->input('free_quote',array('type'=>'checkbox','label'=>'Price quote')); ?>

		</div>
	</div>
	<div class="clear"></div>

		<div class='left'>
		<?  echo $this->Form->input('comments', array('cols'=>40,'label'=>'Comments / <br/>Special Instructions')); ?>
		</div>
		<div class='clear'></div>
	</div>


	<h2>Your Information</h2>
	<div>
		<div style="padding-bottom: 25px; width: 400px; float: right; margin-top: 5px; margin-right: 50px;">
			<div class="grey_border_top"><span><h3 class="bold" style="padding-top: 5px;">Your Privacy</h3></span></div>
			<div class="grey_border_sides" style="padding: 10px;">
			<br/>
			<ul style="">
				<li>Your art, photos, logos, images are your property. They are used to create products for you alone. 
				<li>If we are interested in featuring your design in our sample gallery or catalog, we ask for your permission.
			</ul>
			</div>
			<div class="grey_border_bottom"><span></span></div>
		</div>

	<?
		$first_name = !empty($customer['First_Name'])  ? $customer['First_Name'] : null;
		$last_name = !empty($customer['Last_Name'])  ? $customer['Last_Name'] : null;
		$full_name = $first_name . (!empty($last_name) ? " ".$last_name:"");

		if(!empty($customer['eMail_Address'])) { $this->Form->data['CompletedImage']['email'] = $customer['eMail_Address']; }
		if(!empty($customer['Phone'])) { $this->Form->data['CompletedImage']['phone'] = $customer['Phone']; }
		if(!empty($customer['Company'])) { $this->Form->data['CompletedImage']['company'] = $customer['Company']; }
	?>
		<?= $this->Form->input("company", array('label'=>'Your Organization','size'=>30)); ?>
		<div style="margin-left: 170px;">
			<?= $this->Form->input("wholesale_customer", array('label'=>'Wholesale/Reseller')); ?>
		</div>
		<?= $this->Form->input("full_name", array('label'=>'Your Full Name','size'=>30,'class'=>'required','default'=>$full_name)); ?>
		<?= $this->Form->input("email", array('label'=>'Your Email','size'=>30,'class'=>'required')); ?>
		<?= $this->Form->input("phone", array('label'=>'Your Phone','size'=>30,'class'=>'required')); ?>
		<?#= $this->Form->input("zip_code", array('label'=>'Your Zip Code','size'=>8,'class'=>'required','after'=>'So we can provide accurate shipping costs')); ?>
		<?= $this->Form->hidden("customer_id",array('value'=>$customer['customer_id'])); ?>

		<div class="clear"></div>

	</div>

		<div style="margin-left: 175px;" align="">
		<? if(!empty($id)) { ?>
			<?= $this->Form->submit("/images/buttons/Update-project-details-teal.gif",array('onClick'=>'j.spin();')); ?>
			<b> OR </b>
			<a href="/completed_images/reset"><img src='/images/buttons/Start-Over.gif'/></a>
		<? } else { ?>
			<?= $this->Form->submit("/images/buttons/Continue-teal.gif", array('onClick'=>'j.spin();')); ?>
			<br/>You'll be able to confirm your information before sending.
			<br/>
		<? } ?>
		<br/>
		<div class='' style='font-size: 14px; font-weight: bold; text-align: left;'>
			Questions? 888.293.1109
		</div>

		</div>

<?php echo $this->Form->end(); ?>
</div>
<style>
	#main_column form .text > label,
	#main_column form .select > label,
	#main_column form .file > label,
	#main_column form .textarea > label
	{
		display: block;
		float: left;
		width: 160px;
		text-align: right;
		margin-right: 10px;
	}

	#main_column div.input
	{
		margin-top: 10px;
	}

	#main_column h2
	{
		margin-top: 10px;
		background-color: #AAA;
		padding: 5px;
	}
	#main_column .section
	{
		padding: 5px;
	}

	#main_column .formerror
	{
		margin-left: 175px;
	}
</style>
