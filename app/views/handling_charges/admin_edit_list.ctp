<div class="productPricings form">
<form method="POST" action="/admin/handling_charges/edit_list">

	<fieldset>
 		<legend><?php __('Edit Handling Charges');?></legend>
	<?php
		#$pricings = !empty($this->data['HandlingCharge']) ? $this->data['HandlingCharge'] : array();
		$this->data['HandlingCharge'][] = array();
		$i = 0;
		echo "<div><table border=1 cellpadding=0 cellspacing=0>";
		foreach($this->data['HandlingCharge'] as $id => $charge)
		#for($i = 1; $i < count($pricings) + 2; $i++)
		{
			echo $form->hidden("HandlingCharge.$id.handlingChargeID");
			echo $html->tableCells(array(
				array($form->input("HandlingCharge.$id.weight",array('label'=>'Weight (lb)')), 
					$form->input("HandlingCharge.$id.price"),
				)
			));
		}
		echo "</table></div>";
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
