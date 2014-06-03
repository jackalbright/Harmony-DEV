<?php
class Coupon extends AppModel {
	var $name = 'Coupon';

	var $actsAs = array('Upload'); # Not required, optional

	function beforeSave()
	{
		if(!empty($this->data[$this->alias]['start']))
		{
			$this->data[$this->alias]['start'] = date("Y-m-d", strtotime($this->data[$this->alias]['start'])); # Format m/d/y => y-m-d
		}
		if(!empty($this->data[$this->alias]['end']))
		{
			$this->data[$this->alias]['end'] = date("Y-m-d", strtotime($this->data[$this->alias]['end'])); # Format m/d/y => y-m-d
		}
		return true;
	}

	function afterFind($results)
	{
		if(!empty($results[0][$this->alias]['start']))
		{
			$results[0][$this->alias]['start'] = 
				date("m/d/Y", strtotime($results[0][$this->alias]['start']));
		}
		if(!empty($results[0][$this->alias]['end']))
		{
			$results[0][$this->alias]['end'] = 
				date("m/d/Y", strtotime($results[0][$this->alias]['end']));
		}
		return $results;
	}
}
