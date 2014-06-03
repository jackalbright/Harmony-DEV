<?php
class SpecialtyPagesController extends AppController {

	var $name = 'SpecialtyPages';
	var $helpers = array('Html', 'Form');
	var $uses = array('SpecialtyPage','SpecialtyPageSectionContent','GalleryCategory','SpecialtyPageSampleImage','Client');
	var $section_names = array('intro','details','moreinfo');
	var $title = 'Specialty Services';
	var $controller_crumbs = false;
	#var $paginate = array('order'=>"enabled DESC, sort_index ASC, link_name ASC, page_title ASC");
	var $paginate = array('order'=>"sort_index ASC, link_name ASC, page_title ASC");


	function index() {
		#$this->redirect("/");
		#$this->SpecialtyPage->recursive = 0;
		#$this->set('specialtyPages', $this->paginate());
	}

	function beforeRender()
	{
		parent::beforeRender();
		$this->set("current_build_step", 1);
	}

	function view($id = null) {
		if(!empty($this->livesite))
		{
			$this->redirect("/"); # Block.
		}

		if (!$id) {
			$this->Session->setFlash(__('Invalid SpecialtyPage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$id = preg_replace("/[.]php$/", "", $id); # If routed.

		if (!is_numeric($id))
		{
			$specialtyPage = $this->SpecialtyPage->findByPageUrl($id);
		} else {
			$specialtyPage = $this->SpecialtyPage->read(null, $id);
		}

		$this->set('specialtyPage', $specialtyPage);

		# NOW SET META STUFF...
		if (!empty($specialtyPage['SpecialtyPage']['meta_keywords'])) { $this->meta_keywords = $specialtyPage['SpecialtyPage']['meta_keywords']; }
		if (!empty($specialtyPage['SpecialtyPage']['meta_desc'])) { $this->meta_description = $specialtyPage['SpecialtyPage']['meta_desc']; }

		$sections = array();
		foreach($specialtyPage['SpecialtyPageSectionContent'] as $section)
		{
			$sections[$section['page_section_name']] = $section;
		}
		$this->set('specialtyPageSections', $sections);

		$all_products = $this->Product->findAll("available = 'yes' AND is_stock_item = 0",array(),"is_stock_item,name");
		$products_by_id = Set::combine($all_products, '{n}.Product.product_type_id', '{n}');
		$this->set("all_products", $all_products);
		$this->set("products_by_id", $products_by_id);

		$this->set('rightbar_disabled', true);
		# NOw we're using new template.

		$sid = $specialtyPage['SpecialtyPage']['specialty_page_id'];

		$sample_images = $this->SpecialtyPageSampleImage->findAll(" SpecialtyPageSampleImage.specialty_page_id = '$sid' ");
		$this->set("sample_images", $sample_images);
		$image_products = array();
		foreach($sample_images as $si)
		{
			$pid = $si['SpecialtyPageSampleImage']['product_type_id'];
			$image_products[$pid] = $pid;
		}
		$this->set("image_products", $image_products);

		if (isset($_REQUEST['album']))
		{
			$this->set('rightbar_disabled', true);
			$this->set("sample_gallery_album", true);
			$this->action = "view_album";
			$this->body_title = $specialtyPage['SpecialtyPage']['body_title'] . ": Sample Gallery";
			$this->pageTitle = $specialtyPage['SpecialtyPage']['page_title'] . " Sample Gallery";
			$this->body_title_crumbs = false;
			$this->breadcrumbs[$this->params['url']['url']] = $specialtyPage['SpecialtyPage']['body_title'];
			$this->breadcrumbs[$this->params['url']['url']."?album=1"] = "Sample Gallery";
		} else {
			$this->body_title = $specialtyPage['SpecialtyPage']['body_title'];
			$this->pageTitle = $specialtyPage['SpecialtyPage']['page_title'];
			#$this->set('rightbar_disabled', true);
			$this->set('rightbar_template', "specialty_pages/rightbar");
		}
		#$this->set("products", $this->Product->create_dropdown_list('name', 'All Product'));
		$this->Product->recursive = 1;
		$products = $this->Product->findAll("available = 'yes' AND parent_product_type_id IS NULL AND is_stock_item = 0", array(), "is_stock_item ASC, sort_index ASC");
		$this->set("products", $products);

		if(!empty($specialtyPage['SpecialtyPage']['subjects']))
		{
			$browse_node_list = $specialtyPage['SpecialtyPage']['subjects'];
			$this->set("subjects", $this->GalleryCategory->findAll(" GalleryCategory.browse_node_id IN ($browse_node_list) "));
		} else {
			$browse_node_list = $specialtyPage['SpecialtyPage']['subjects'];
			$this->set("subjects", $this->GalleryCategory->findAll(" GalleryCategory.parent_node = 1"));
		}


		#if (!empty($_REQUEST['new']) || $this->hdtest || $this->malysoft)
		if (!empty($_REQUEST['new']))
		{
			$this->action = 'viewnew';
		}

		# WHOLESALE PRICING...

		$pricing = array();
		$quantity_breaks = array(12, 250, 500,1001);
		foreach($products as &$product)
		{
			$prod = $product['Product']['code'];
			$pricing[$prod] = array();
			foreach($quantity_breaks as $qty)
			{
				$effective_quantity = $qty < 100 ? 100 : $qty;
				foreach($product['ProductPricing'] as $pricing_level)
				{
					if ($pricing_level['quantity'] <= $effective_quantity && $pricing_level['price'] > 0) 
					{
						$pricing[$prod][$qty] = $pricing_level['price'];
					}

				}
			}
			if (empty($product['Product']['is_stock_item']) && !preg_match("/Custom/i", $product['Product']['name']))
			{
				$product['Product']['name'] = "Custom ".$product['Product']['name'];
			}
			
		}
		$this->set("quantity_breaks", $quantity_breaks);
		$this->set("pricing", $pricing);

	}

	function admin_index() {
		$this->SpecialtyPage->recursive = 0;
		$this->set('specialtyPages', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->SpecialtyPage->create();
			if ($this->SpecialtyPage->save($this->data)) {
				$specialty_page_id = $this->SpecialtyPage->id;

				# Create section entries too....

				#for($i = 0; $i < count($this->section_names); $i++)
				#{
				#	$this->section_data = array(
				#		'specialty_page_id'=>$specialty_page_id,
				#		'page_section_name'=>$this->section_names[$i],
				#	);
#
#					$this->SpecialtyPageSectionContent->create();
#					$this->SpecialtyPageSectionContent->save($this->section_data);
#				}

				$this->Session->setFlash(__('The SpecialtyPage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The SpecialtyPage could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid SpecialtyPage', true));
			$this->redirect(array('action'=>'index'));
		}

		#if (!empty($this->data['SpecialtyPageSectionContent']))
		if (!empty($this->data))
		{
			$this->data['SpecialtyPage']['subjects'] = join(",", !empty($this->data['SpecialtyPage']['subject_id']) ? $this->data['SpecialtyPage']['subject_id'] : array());
			$this->SpecialtyPage->save($this->data);

			if (!empty($this->data['SpecialtyPageSectionContent']))
			{
				# Loop through and if any blank ones, remove if existing in db, ignore if blank.
				#
				$pricing_data = array();
				foreach($this->data['SpecialtyPageSectionContent'] as &$content)
				{
					if ($content['content'] == "")
					{
						if ($content['specialty_page_section_content_id'] != "") # Delete from db.
						{
							$this->SpecialtyPageSectionContent->del($content['specialty_page_section_content_id']);
						} else { # Blank, ignore.
							#
						}
					} else {
						$specialty_content_data[] = $content;
					}
	
				}
				$this->SpecialtyPageSectionContent->saveAll($specialty_content_data);
				$this->Session->setFlash("Content updated");
			}
		}
		$contents = $this->SpecialtyPageSectionContent->findAllBySpecialtyPageId($id, array(), 'specialty_page_section_content_id');
		if (!$contents) { $contents = array(); }
		$this->data = $this->SpecialtyPage->read(null, $id);
		$this->data['SpecialtyPageSectionContent'] = Set::combine($contents, '{n}.SpecialtyPageSectionContent.specialty_page_section_content_id', '{n}.SpecialtyPageSectionContent');  

		$subjects = $this->GalleryCategory->findAll(null, null, "GalleryCategory.browse_node_id");
		$subjects_by_id = array();
		$subject_children = array();

		foreach($subjects as $subject)
		{
			$browse_node_id = $subject['GalleryCategory']['browse_node_id'];
			$parent_node_id = $subject['GalleryCategory']['parent_node'];
			$subjects_by_id[$browse_node_id] = $subject;

			if(empty($subject_children[$parent_node_id]))
			{
				$subject_children[$parent_node_id] = array();
			}
			$subject_children[$parent_node_id][] = $browse_node_id;
		}

		$this->set("subjects", $subjects_by_id);
		$this->set("subject_children", $subject_children);

		$this->set("specialty_page_id", $id);

	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for SpecialtyPage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SpecialtyPage->del($id)) {
			$this->Session->setFlash(__('SpecialtyPage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function admin_enable($id)
	{
	}

	function admin_resort()
	{
		$this->layout = 'ajax';

		$order = $this->params['form']['specialtyPage_sortable'];

		if ($order && count($order))
		{
			$renames = array();
			foreach($order as $item_order => $page_id)
			{
				$page = $this->SpecialtyPage->find("SpecialtyPage.specialty_page_id = '$page_id'");
				if ($page)
				{
					$page['SpecialtyPage']['sort_index'] = $item_order;
					$this->SpecialtyPage->save($page);
					# RENAME THE FILE....
				}
			}
		}
	}

}
?>
