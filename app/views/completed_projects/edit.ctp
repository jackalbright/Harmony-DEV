<script>
var products_by_id = <?= json_encode($products_by_id); ?>;
</script>
<? $id = !empty($this->data['CompletedProject']['id']) ? $this->data['CompletedProject']['id'] : null; ?>
<? if($id) { ?>
	<? $this->set("body_title", "Edit Your Information For Your Completed Project"); ?>
<? } else { ?>
	<? $this->set("body_title", "Send Your Completed Project"); ?>
<? } ?>
<div class="completedImages form"  position: relative;">
<?php echo $this->Form->create('CompletedProject', array('type'=>'file','onSubmit'=>'if(validate(this)) { return true; } else { j.unspin(); return false; }')); ?>

	<script>
	function validate(form)
	{
		if(verifyRequiredFields(form)) { 
			var sides = j('#CompletedProjectPrintingOnBack').val();
			if(!j('#CompletedImage0Id').val())
			{
				j('#CompletedImage0File').formerror('Please upload your art');
				return false;
			}
			if(sides == 'different' && !j('#CompletedImage1Id').val())
			{
				j('#CompletedImage0File').formerror('Please upload your art or choose a different option for print sides');
				return false;
			}

			if(!fullName()) { 
				return false;
			}
			j.spin(); return true; 
		}
		return false; 
	}
	</script>
	<!--
	<p style="color: #B82A2A; padding-left: 25px;">
	If you have completed art, fill out this online form and attach your completed design. We'll be in touch with you within 1-2 business days to discuss your project.
	</p>
	-->


	<script>
	function fullName()
	{
		if(!j('#CompletedProjectFullName').val().match(/\w\s+\w/))
		{
			alert("Please provide your full name");
			j('#CompletedProjectFullName').focus();
			return false;
		}
		return true;
	}
	</script>

<!--
	<p align="center" style="">Upload your finished design and we'll create your products.</p>
	-->

<h2>Upload Your Art</h2>
	
<div style=''>
	<? echo $this->Form->input('product_type_id', array('id'=>'ProductTypeId', 'class'=>'Product required','label'=>'Product','options'=>$products, 'default'=>!empty($product)?$product['Product']['product_type_id']:null,'empty'=>'Select a product:')); ?>
	<div class="" style="margin-left: 175px; padding-top: 5px; ">
		<a style="<?= empty($product['Product']['code']) ? "display:none;" : "" ?>" id="project_download_template" href="/products/template/<?= !empty($product) ? $product['Product']['code'] : null ?>">Template &amp; specifications</a> 
	</div>

	<div class="left">
	</div>
	<div class="clear"></div>
	<script>
	j('#ProductTypeId').change(function() {
		var pid = j(this).val();
		var prod = pid ? products_by_id[pid]['code'] : null;
		//console.log("P="+pid+", PROD="+prod);

		if(prod && prod.match(/^(B|BC|BB|BNT|RL|KC|SMKC)$/))
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
		j.get("/completed_projects/get_product/"+pid, null, function(response) {

			j('#quantityCol').show();
			if(response.minimum)
			{
				var quantity = parseInt(j('#CompletedProjectQuantity').val());
				//if(!quantity || response.minimum > quantity)
				if(quantity && response.minimum > quantity)
				{
					j('#CompletedProjectQuantity').val(response.minimum);
				}
				j('#minimum').val(response.minimum);
				j('#minimum_notice').html(response.minimum);
			}
		});
	});
	j(document).ready(function() { j('#ProductTypeId').change(); });
	</script>
<div id='quantityCol' style='<?= empty($this->data['CompletedProject']['product_type_id']) ? "display:none;" : "" ?>'>
	<div class="left">
	<?
		$min = $qty = !empty($product['Product']['minimum']) ? $product['Product']['minimum'] : 1;
		echo $this->Form->input('quantity',array('size'=>3, 'class'=>'required','style'=>'border: solid #B82A2A; background-color: #CCC; padding: 5px;','default'=>$qty));
	?>
	</div>
	<div class='left' style="padding-top: 15px;">&nbsp;&nbsp; Min is <span id='minimum_notice'><?= $min ?></span></div>
	<div class="clear"></div>
</div>
	<?= $this->Form->hidden("minimum", array('id'=>'minimum', 'value'=>$min)); ?>
	<script>
		j('#CompletedProjectQuantity').change(function() {
			var min = parseInt(j('#minimum').val());
			if(!min) { min = 1; }

			var qty = parseInt(j(this).val());

			if(qty < min)
			{
				alert("Minimum is "+min);
				j('#CompletedProjectQuantity').val(min);
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
			j('#side2').hide();
		} else if (setting == 'same') {
			j('#printing_costs').show();
			j('#side2').hide();
		} else if (setting == 'different') { 
			j('#printing_costs').show();
			j('#side2').show();
		}
	});
	j(document).ready(function() { j('#printing_back select').change(); });
	</script>
<div id="completed_image_upload_container">
	<?= $this->element("../completed_images/upload"); ?>
</div>

</div>

<h2>Project Information</h2>
<div style="position: relative;">


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
	<div style='padding: 0 25px; position: relative;'>
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
		<div style="overflow: hidden;">

	<?
		$first_name = !empty($customer['First_Name'])  ? $customer['First_Name'] : null;
		$last_name = !empty($customer['Last_Name'])  ? $customer['Last_Name'] : null;
		$full_name = $first_name . (!empty($last_name) ? " ".$last_name:"");

		if(!empty($customer['eMail_Address'])) { $this->Form->data['CompletedProject']['email'] = $customer['eMail_Address']; }
		if(!empty($customer['Phone'])) { $this->Form->data['CompletedProject']['phone'] = $customer['Phone']; }
		if(!empty($customer['Company'])) { $this->Form->data['CompletedProject']['company'] = $customer['Company']; }
	?>
		<?= $this->Form->input("company", array('label'=>'Your Organization','size'=>30)); ?>
		<div style="margin-left: 170px;">
			<?= $this->Form->input("wholesale_customer", array('label'=>'Wholesale/Reseller')); ?>
		</div>
		<?= $this->Form->input("full_name", array('label'=>'Your Full Name','size'=>30,'class'=>'required','default'=>$full_name)); ?>
		<?= $this->Form->input("email", array('label'=>'Your Email','size'=>30,'class'=>'required')); ?>
		<?= $this->Form->input("phone", array('label'=>'Your Phone','size'=>30,'class'=>'required')); ?>

		<?= $this->Form->input("address", array('label'=>'Your Address','size'=>30,'class'=>'required')); ?>
		<?= $this->Form->input("city", array('label'=>'Your City','size'=>30,'class'=>'required')); ?>
		<?= $this->Form->input("state", array('label'=>'Your State','size'=>30,'class'=>'required')); ?>
		<?
			$countries = array(
				'CA'=>'Canada',
				'EN'=>'England',
				'IE'=>"Ireland",
				"NB"=>"Northern Ireland",
				"US"=>"United States",
				"WL"=>"Wales"
			);
		?>
		<?= $this->Form->input("country", array('label'=>'Your Country','class'=>'required','options'=>$countries,'default'=>'US')); ?>
		<?= $this->Form->input("zip_code", array('label'=>'Your Zip Code','size'=>8,'class'=>'required','after'=>' <span style="font-size: 0.9em;">(For calculating accurate shipping costs)</span>')); ?>
		<?= $this->Form->hidden("customer_id",array('value'=>$customer['customer_id'])); ?>
		<div id='captcha' style="margin-left: 170px;">
			<?= $this->Captcha->show();?>
		</div>

		</div>

		<div class="clear"></div>

	</div>

		<div style="margin-left: 175px;" align="">
		<?= $this->Form->submit("/images/webButtons2014/blue/large/sendFinishedProject.png",array('onClick'=>'showPleaseWait();')); ?>

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
		display: inline-block;
		width: 160px;
		text-align: right;
		margin-right: 10px;
	}
	#captcha label
	{
		width: auto !important;
	}

	#main_column div.input
	{
		margin-top: 10px;
	}

	#main_column h2
	{
		margin-top: 10px;
		background-color: #CCC;
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

	#completed_image_upload_container #flashMessage
	{
		margin-left: 175px;
		margin-top: 25px;
	}
</style>
