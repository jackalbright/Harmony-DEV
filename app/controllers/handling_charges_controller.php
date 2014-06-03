<?
class HandlingChargesController extends AppController
{
	var $uses = array('HandlingCharge');

	function admin_index()
	{
		$this->redirect(array('action'=>'edit_list'));
	}

	function admin_edit_list()
	{

		if (!empty($this->data['HandlingCharge']))
		{
			# Loop through and if any blank ones, remove if existing in db, ignore if blank.
			#
			$charge_data = array();
			foreach($this->data['HandlingCharge'] as &$charge)
			{
				if ($charge['price'] === '' || $charge['weight'] === '') # Allow '0'
				{
					if ($charge['handlingChargeID'] != "") # Delete from db.
					{
						$this->HandlingCharge->del($charge['handlingChargeID']);
					} else { # Blank, ignore.
						#
					}
				} else {
					$charge_data[] = $charge;
				}

			}
			$this->HandlingCharge->saveAll($charge_data);
			$this->Session->setFlash("Handling fees updated");
		}
		$charges = $this->HandlingCharge->find('all',array('order'=>'weight ASC'));
		$this->data['HandlingCharge'] = Set::combine($charges, '{n}.HandlingCharge.handlingChargeID', '{n}.HandlingCharge');  
	}
}

?>
