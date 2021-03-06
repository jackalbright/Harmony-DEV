<?php
class GalleryCategory extends AppModel {

	var $name = 'GalleryCategory';
	var $useTable = 'browse_node';
	var $primaryKey = 'browse_node_id';
	var $order = 'GalleryCategory.browse_name';
	var $displayField = "browse_name";

	var $belongsTo = array(
		'ParentCategory'=>array(
			'className'=>'GalleryCategory',
			'foreignKey'=>'parent_node',
		),
	);

	var $hasAndBelongsToMany = array(
				'GalleryImage'=>array(
					'className'=>'GalleryImage',
					'joinTable'=>'browse_link',
					'foreignKey'=>'browse_node_id',
					'associationForeignKey'=>'catalog_number',
				),
				'GalleryFilterKeywords'=>array(
					'className'=>'GalleryFilterKeyword',
					'joinTable'=>'gallery_filters',
					'foreignKey'=>'browse_node_id',
					'associationForeignKey'=>'filter_id',
				),
	);

	var $hasMany = array(
		'GalleryFilters'=>array(
			'className'=>"GalleryFilter",
			"foreignKey"=>"browse_node_id",
		),
		'Subcategories'=>array(
			'className'=>'GalleryCategory',
			'foreignKey'=>'parent_node',
			'order'=>'Subcategories.browse_name',
		),
	);



	function get_self_and_ancestor_ids($id) # For getting stamps recursively...
	{
		$idlist = array($id);
		$this->recursive = -1;
		$entries = $this->find('all',array('conditions'=>array('parent_node'=>$id),'fields'=>array('browse_node_id')));
		foreach($entries as $entry)
		{
			$idlist[] = $child_id = $entry['GalleryCategory']['browse_node_id'];
			$child_idlist = $this->get_self_and_ancestor_ids($child_id);
			foreach($child_idlist as $child_id) { $idlist[] = $child_id; }
		}

		return $idlist;
	}

	function get_recursive_categories($id = 1)
	{
		$this->recursive = -1;
		$category = $this->read(null, $id);
		$category['Subcategories'] = $this->get_children_categories($id);
		return $category;
	}

	function get_children_categories($id)
	{
		$children_categories = $this->find("parent_node = '$id'");
		#foreach($children_categories as $cat)
		#{
		#	$cat['Subcategories'] = $this->get_children_categories($cat['GalleryCategory']['browse_node_id']);
		#}

		return $children_categories;
	}

	function generate_category_breadcrumb_trail($path, $id)
	{
		$crumbs = array();
		do
		{
			$this->recursive = -1;
			$category = $this->read(null, $id);
			$crumbs[$path."/".$category['GalleryCategory']['browse_node_id']] = $category['GalleryCategory']['browse_name'];
			$id = $category['GalleryCategory']['parent_node'];
		} while($id >= 1 && $category);
		return $crumbs;
	}

	function get_all_categories_options()
	{
		$this->recursive = -1;
		$options = array();
		#$options[0] = 'None';
		$category_options = $this->get_sub_categories_options();
		#print_r($category_options);
		foreach($category_options as $k => $v)
		{
			$options[$k] = $v;
		}
		#$options = array_merge($options, $category_options);
		return $options;
	}

	function get_sub_categories_options($parent_id = 0, $indent_count = 0)
	{
		$options = array();
		$categories = $this->find('all',array('fields'=>'parent_node, browse_node_id, browse_name','order'=>'parent_node, browse_name ASC','conditions'=>"parent_node = '$parent_id'"));
		foreach ($categories as $category)
		{
			$indent = str_repeat("---", $indent_count);
			$options[$category['GalleryCategory']['browse_node_id']] = $indent . $category['GalleryCategory']['browse_name'];# . "(". $category['GalleryCategory']['browse_node_id'] . ", ". $category['GalleryCategory']['parent_node'] . ")";

			$subcategory_options = $this->get_sub_categories_options($category['GalleryCategory']['browse_node_id'], $indent_count+1);
			foreach($subcategory_options as $sov => $son)
			{
				$options[$sov] = $son;
			}

			#$options = array_merge($options, $subcategory_options);
		}
		return $options;
	}

	function beforeSave()
	{
		if(isset($this->data[$this->modelClass]['parent_node']) && empty($this->data[$this->modelClass]['parent_node']) && (!isset($this->data[$this->modelClass]['browse_node_id']) || $this->data[$this->modelClass]['browse_node_id'] != 1))
		{ 
			$this->data[$this->modelClass]['parent_node'] = 1; # Default to root. Except for root itself.
		}
		return true;
	}

}
?>
