<?php
class PartPricingsController extends AppController {

	var $name = 'PartPricings';
	var $helpers = array('Html', 'Form');
	var $uses = array('PartPricing','Part');
	#var $uses = array('PartPricing','PricingDiscount');

	function admin_edit_list($part_id = null)
	{
		#Configure::write('debug', 0);

		if ($part_id == null)
		{
			$this->Session->setFlash("Please select a part first.");
			$this->redirect("/admin/parts");
		}


		#if (!$pricings) { $pricings = array(); }
		$this->set("part_id", $part_id);
		#echo "DATA1=".print_r($this->data,true);
		$part = $this->Part->read(null, $part_id);
		$part_code = $part['Part']['part_code'];
		$part_name = $part['Part']['part_name'];
		$this->set("part", $part);
		$this->set("part_name", $part_name);

		$this->title = "Edit $part_name Pricing";

		if (!empty($this->data['PartPricing']))
		{
			# Loop through and if any blank ones, remove if existing in db, ignore if blank.
			#
			$pricing_data = array();
			foreach($this->data['PartPricing'] as &$pricing)
			{
				if (empty($pricing['price']) && empty($pricing['percent_discount']))
				{
					if ($pricing['part_price_point_id'] != "") # Delete from db.
					{
						$this->PartPricing->del($pricing['part_price_point_id']);
					} else { # Blank, ignore.
						#
					}
				} else {
					$pricing['part_code'] = $part_code;
					$pricing_data[] = $pricing;
				}

			}
			$this->PartPricing->saveAll($pricing_data);
			$this->Session->setFlash("Pricing updated");
		}
		$pricings = $this->PartPricing->findAllByPartTypeId($part_id, array(), 'quantity');
		if (!$pricings) { $pricings = array(); }
		foreach($pricings as &$pricing)
		{
			if (empty($pricing['PartPricing']['percent_discount']))
			{
				$percent = $pricing['PartPricing']['price']  / $pricings[0]['PartPricing']['price'] * 100;
				$pricing['PartPricing']['percent_discount'] = round($percent,2);
				# Calculate!
			}
		}
		$this->data['PartPricing'] = Set::combine($pricings, '{n}.PartPricing.part_price_point_id', '{n}.PartPricing');  
		$this->data['Part'] = $part['Part'];
		#echo "DAT=".print_r($this->data,true);
		#$this->set("pricings", $pricings);
	}


}
?>
