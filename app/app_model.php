<?php
/* SVN FILE: $Id: app_model.php 6311 2008-01-02 06:33:52Z phpnut $ */

/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.app
 * @since			CakePHP(tm) v 0.2.9
 * @version			$Revision: 6311 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2008-01-01 22:33:52 -0800 (Tue, 01 Jan 2008) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package		cake
 * @subpackage	cake.app
 */
class AppModel extends Model
{
	#var $actsAs = array('Containable');

	var $errors = array();

	function get_config_value($name)
	{
		$config = $this->get_model("Config");
		$entry = $config->find("name = '$name' ");
		return !empty($entry) ? $entry['Config']['value'] : null;
	}

	function link($rel, $model)
	{
		$models = is_array($model) ? $model : array($model);
		#print_r($models);
		foreach($models as $m)
		{
			$config = !empty($this->otherAssociations[$rel][$m]) ? $this->otherAssociations[$rel][$m] : null;
			if ($config) { 
				$this->bindModel(array($rel=>array($m=>$config)));
			}
		}
	}
	function get_model($name)
	{
		$model = ClassRegistry::init($name);
		return $model;
	}

    function getDefaultValues()
    {
        //Get the name of the table
        $db =& ConnectionManager::getDataSource($this->useDbConfig);
        $tableName = $db->fullTableName($this, false);


        //Get the values for the specified column (database and version specific, needs testing)
        $result = $this->query("SHOW COLUMNS FROM {$tableName}");

        //figure out where in the result our Types are (this varies between mysql versions)

	for($i = 0; $i < count($result); $i++)
	{
        	$default = null;
		$is_null = null;
		$field = null;
        	if     ( isset( $result[$i]['COLUMNS']['Type'] ) ) { $field = $result[$i]['COLUMNS']['Field']; $default = $result[$i]['COLUMNS']['Default']; $is_null = $result[$i]['COLUMNS']['Null']; } //MySQL 5
        	elseif ( isset( $result[$i][0]['Type'] ) )         { $field = $result[$i][0]['Field']; $default = $result[$i][0]['Default']; $is_null = $result[$i][0]['Null']; } //MySQL 4

		if ($field && $is_null == 'NO' && $default != "NULL" && $default && $field != $this->primaryKey)
		{
			$data[$this->name][$field] = Inflector::humanize($default);
		}
	}
	return $data;

    } //end getDefaultValues()

    /**
     * Get Enum Values
     * Snippet v0.1.3
     * http://cakeforge.org/snippet/detail.php?type=snippet&id=112
     *
     * Gets the enum values for MySQL 4 and 5 to use in selectTag()
     */
    function getEnumValues($columnName=null, $respectDefault=false, $optionalValue = false)
    {
        if ($columnName==null) { return array(); } //no field specified


        //Get the name of the table
        $db =& ConnectionManager::getDataSource($this->useDbConfig);
        $tableName = $db->fullTableName($this, false);


        //Get the values for the specified column (database and version specific, needs testing)
        $result = $this->query("SHOW COLUMNS FROM {$tableName} LIKE '{$columnName}'");

        //figure out where in the result our Types are (this varies between mysql versions)
        $types = null;
        if     ( isset( $result[0]['COLUMNS']['Type'] ) ) { $types = $result[0]['COLUMNS']['Type']; $default = $result[0]['COLUMNS']['Default']; } //MySQL 5
        elseif ( isset( $result[0][0]['Type'] ) )         { $types = $result[0][0]['Type']; $default = $result[0][0]['Default']; } //MySQL 4
        else   { return array(); } //types return not accounted for

        //Get the values
        $values = explode("','", preg_replace("/(enum)\('(.+?)'\)/","\\2", $types) );

        if($respectDefault){
                $assoc_values = array("$default"=>Inflector::humanize($default));
                foreach ( $values as $value ) {
                        if($value==$default){ continue; }
                        $assoc_values[$value] = Inflector::humanize($value);
                }
        }
        else{
                $assoc_values = array();
		if ($optionalValue)
		{
			if ($optionalValue === true)
			{
				$assoc_values[''] = Inflector::humanize("None");
			} else if ($optionalValue !== false) {
				$assoc_values[''] = Inflector::humanize($optionalValue);
			}
		}
                foreach ( $values as $value ) {
                        $assoc_values[$value] = Inflector::humanize($value);
                }
        }

        return $assoc_values;

    } //end getEnumValues

    function getSetValues($columnName=null, $respectDefault=false, $optionalValue = false)
    {
        if ($columnName==null) { return array(); } //no field specified


        //Get the name of the table
        $db =& ConnectionManager::getDataSource($this->useDbConfig);
        $tableName = $db->fullTableName($this, false);


        //Get the values for the specified column (database and version specific, needs testing)
        $result = $this->query("SHOW COLUMNS FROM {$tableName} LIKE '{$columnName}'");

        //figure out where in the result our Types are (this varies between mysql versions)
        $types = null;
        if     ( isset( $result[0]['COLUMNS']['Type'] ) ) { $types = $result[0]['COLUMNS']['Type']; $default = $result[0]['COLUMNS']['Default']; } //MySQL 5
        elseif ( isset( $result[0][0]['Type'] ) )         { $types = $result[0][0]['Type']; $default = $result[0][0]['Default']; } //MySQL 4
        else   { return array(); } //types return not accounted for

        //Get the values
        $values = explode("','", preg_replace("/(set)\('(.+?)'\)/","\\2", $types) );

        if($respectDefault){
                $assoc_values = array("$default"=>Inflector::humanize($default));
                foreach ( $values as $value ) {
                        if($value==$default){ continue; }
                        $assoc_values[$value] = Inflector::humanize($value);
                }
        }
        else{
                $assoc_values = array();
		if ($optionalValue)
		{
			if ($optionalValue === true)
			{
				$assoc_values[''] = Inflector::humanize("None");
			} else if ($optionalValue !== false) {
				$assoc_values[''] = Inflector::humanize($optionalValue);
			}
		}
                foreach ( $values as $value ) {
                        $assoc_values[$value] = Inflector::humanize($value);
                }
        }

        return $assoc_values;

    } //end getSetValues

	function mm2in($mm)
	{
		# Rounds to nearest 8th.
		$nearest = 8;

		$in = $mm * 0.0393700787;
		#return round($in, 2);
		##return round($in*4)/4;
		return round($in*$nearest)/$nearest;
	}

	function in2mm($in)
	{
		$mm = $in / 0.0393700787;
		return ceil($mm);
	}

	function gm2oz($gm)
	{
		if ($gm <= 0) { return 0; }
		#error_log("GM2OZ=$gm");
		$count = 1;
		$oz = $gm * 0.0352739619;
		$iter = 1;
		while($oz < 1 && $iter++ < 10)
		{
			$oz *= 10;
			$count *= 10;
		}
		$oz = round($oz*4)/4;
		#echo "OZ=$oz, CO=$count";
		return array($oz, $count);
	}

	function oz2gm($oz, $count = 1)
	{
		$gm = $oz / ($count * 0.0352739619);
		return $gm;
	}

	function create_dropdown_list($display_field, $optional_title = '')
	{
		$values = $this->find('list',array('fields'=>array($display_field), 'order'=>$display_field));

		$options = array();
		#error_log("OPT_TITLE=$optional_title");
		if ($optional_title != "")
		{
			$options[''] = $optional_title;
			#$options[' '] = " "; # Spacer.
		}
		foreach($values as $key => $value)
		{
			$options[$key] = $value;
		}

		#print_r($options);
		#error_log("OPTIONS=".print_r($options, true));

		return $options;
	}

	function findAll($conditions = '', $fields = null, $order = null, $limit = null, $page = null, $recursive = null)
	{
		return $this->find('all', array('conditions'=>$conditions,'fields'=>$fields,'order'=>$order,'limit'=>$limit,'page'=>$page,'recursive'=>$recursive));
	}

	function findCount($conditions = '')
	{
		return $this->find('count', array('conditions'=>$conditions));
	}

	function del($id)
	{
		return $this->delete($id);
	}

	function fields($field, $conditions = array()) # One field of all desired records.
	{
		$results = $this->{$this->modelClass}->find('all', array(
			'recursive'=>-1,
			'conditions'=>$conditions,
			'fields'=>array($field),
		));
		return Set::extract("/{$this->modelClass}/$field", $results);
	}

	function getLog($sorted = false, $clear = true)
	{
		$dbo = $this->getDataSource();
		$log = $dbo->getLog($sorted, $clear);
		return isset($log['log']) ? $log['log'] : $log; 
	}
	function getSql($sorted = false, $clear = true) # As a string?
	{
		$log = $this->getLog();
		$lastLog = $log[count($log)-1];
		return $lastLog;
	}

	/*
	function beforeFind($query)
	{
		echo "PN=".$this->alias;
		if(!empty($this->virtualFields) && $this->name != $this->alias)
		{
			foreach($this->virtualFields as $k=>$vf)
			{
				$this->virtualFields[$k] = preg_replace("/{$this->name}[.]/", $this->alias.".", $vf);
			}
		}
		return $query;
	}
	*/

}
?>
