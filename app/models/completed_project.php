<?php
class CompletedProject extends AppModel {
	var $name = 'CompletedProject';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $order = 'CompletedProject.id DESC';

	var $validate = array(
		'email'=>array(
			'allowEmpty'=>false,
			'rule'=>'email',
			'message'=>'Email is invalid.'
		),
		'phone'=>array(
			'allowEmpty'=>false,
			'rule'=>'phone',
			'message'=>'Phone number is invalid.'
		),
		'zip_code'=>array(
			'allowEmpty'=>false,
			'rule'=>array('many_postal'),
			'message'=>'Postal code (or country) is invalid.'
		),
	);

	var $hasMany = array(
		'CompletedImage' => array(
			'className' => 'CompletedImage',
			'foreignKey' => 'completed_project_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	var $belongsTo = array(
		'Product'=>array(
			'className'=>'Product',
			'foreignKey'=>'product_type_id',
		)
	);

	function many_postal($params)
	{
		$country = !empty($this->data['CompletedProject']['country']) ? strtolower($this->data['CompletedProject']['country']) : 'us';
		if(in_array($country, array('ie','en','nb','wl'))) { $country = 'uk'; }

		return Validation::postal($params['zip_code'], null, $country);
	}

	function beforeValidate() # Require image ot be attached. bots may not bother.
	{
		if(!isset($this->data['CompletedImage']) || empty($this->data['CompletedImage']))
		{
			return false;
		} else {
			return true;
		}
	}

	function beforeSave()
	{
		if(!empty($this->data[$this->alias]['needed_by']))
		{
			$this->data[$this->alias]['needed_by'] = date("Y-m-d", strtotime($this->data[$this->alias]['needed_by'])); # Format m/d/y => y-m-d
		}
		return true;
	}

	function afterFind($results)
	{
		if(!empty($results[0][$this->alias]['needed_by']))
		{
			$results[0][$this->alias]['needed_by'] = 
				date("m/d/Y", strtotime($results[0][$this->alias]['needed_by']));
		}
		return $results;
	}
}
