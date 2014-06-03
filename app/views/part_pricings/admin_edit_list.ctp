<div class="partPricings form">
<?php 
#echo $form->create('PartPricing');
?>
<br/>
<a href="/admin/parts/edit/<?= $part_id ?>">Edit <?= $part_name?></a>
<form method="POST" action="/admin/part_pricings/edit_list/<?= $part_id ?>">

	<fieldset>
 		<legend><?php __("Edit $part_name Pricing");?></legend>
	<?php
		#$pricings = !empty($this->data['PartPricing']) ? $this->data['PartPricing'] : array();
		$this->data['PartPricing'][] = array();
		$i = 0;
		#print_r($this->data["PartPricing"]);
		echo "<div><table border=1 cellpadding=0 cellspacing=0>";
		foreach($this->data['PartPricing'] as $id => $pricing)
		#for($i = 1; $i < count($pricings) + 2; $i++)
		{
			if (!$id) { $id = 0; }
			#$pricing = $i < count($pricings) ? $pricings[$i] : array();
			echo $form->hidden("PartPricing.$id.part_price_point_id");
			echo $form->hidden("PartPricing.$id.part_type_id",array('value'=>$part_id));
			echo $html->tableCells(array(
				array($form->input("PartPricing.$id.quantity"), 
					$form->input("PartPricing.$id.price"),
					$form->input("PartPricing.$id.setup_charge"),
					#$form->input("PartPricing.$id.percent_discount"),
					#$price
				)
			));
		}
		echo "</table></div>";
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
