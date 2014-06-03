<?php
class ProductOptionsController extends AppController {

	var $name = 'ProductOptions';
	var $helpers = array('Html', 'Form');
	var $uses = array('ProductOption','Product','ProductFeature');

	function admin_edit($pid) {
		$this->ProductOption->recursive = 0;
		$related_products = $this->Product->findAll(" Product.product_type_id = '$pid' OR Product.parent_product_type_id = '$pid'", null, "choose_index ASC");
		$related_products_by_id = Set::combine($related_products, "{n}.Product.product_type_id", "{n}");
		$pids = array_keys($related_products_by_id);

		if(!empty($this->data))
		{
		#	error_log("DATA=".print_r($_REQUEST,true));
			#echo "<pre>";
			#print_r($this->data);
			#echo "</pre>";
			$popt_ids = array();

			foreach($this->data['ProductOptions'] as $i => $popt)
			{
				if(empty($popt['ProductOption']['option_name'])) 
				{ 
					if(!empty($popt['ProductOption']['product_option_id']))
					{
						$this->ProductOption->del($popt['ProductOption']['product_option_id']);
					}
					continue; 
				}
				if(empty($popt['ProductOption']['product_option_id']))
				{
					$this->ProductOption->create();
				}
				$this->ProductOption->save($popt);
				
				$popt_id = $this->ProductOption->id;
				$popt_ids[] = $popt_id;

				#continue; # Skip features for now.
				#print_r($popt);

				foreach($popt['ProductFeature'] as $j => $pfeat)
				{
					if(empty($pfeat['text']) && empty($pfeat['included']))
					{
						if(!empty($pfeat['product_feature_id']))
						{
							$this->ProductFeature->del($pfeat['product_feature_id']);
						}
						continue; 
					}

					if(empty($pfeat['product_feature_id']))
					{
						$this->ProductFeature->create();
					}
					$pfeat['product_option_id'] = $popt_id;
					$this->ProductFeature->save(array('ProductFeature'=>$pfeat));

					$pfeat_id = $this->ProductFeature->id;
					$pfeat_ids[] = $pfeat_id;
				}

				#$this->ProductFeature->deleteAll("product_option_id = '$popt_id' AND product_feature_id NOT IN (".join(",",$pfeat_ids).")");
			}
			#if(!empty($popt_ids))
			#{
			#	$this->ProductOption->deleteAll('product_option_id NOT IN ('.join(",",$popt_ids).")");
			#}
		}

		$this->ProductOption->recursive = 1;

		$options = $this->ProductOption->findAll("ProductOption.product_type_id = '$pid'", null, "sort_index ASC, product_option_id ASC");
		$features = $this->ProductFeature->findAll(array('ProductFeature.product_type_id'=>$pids));

		$this->data = array('ProductOptions'=>$options);

		$this->set("options", $options);
		$this->set("features", $features);
		$this->set("related_products", $related_products);
		$this->set("pid", $pid);
	}

	function admin_resort($product_id = null)
	{
	#	error_log("FORM=".print_r($this->params['form'],true));
		$this->layout = 'ajax';
		if (!$product_id)
		{
			$this->Session->setFlash(__('Invalid Product.', true));
			$this->redirect(array('admin'=>true,'controller'=>'products','action'=>'index'));
		}
		$product = $this->Product->read(null, $product_id);
		$prod = $product['Product']['prod'];
		$this->ProductOptions->recursive = -1;
		$order = $this->params['form']['product_options'];

		if ($order && count($order))
		{
			foreach($order as $item_order => $option_id)
			{
				$option = $this->ProductOption->find("ProductOption.product_option_id = '$option_id'");
			#	error_log("$option_id = ".print_r($option,true));
				if (!empty($option))
				{
					$option['ProductOption']['sort_index'] = $item_order;
					$this->ProductOption->save($option);
				}
			}
		}
	}

	function admin_product_resort($product_id = null)
	{
		Configure::write("debug", 3);
	#	error_log("RESORT=".print_r($this->params,true));
		$this->layout = 'ajax';
		if (!$product_id)
		{
			$this->Session->setFlash(__('Invalid Product.', true));
			$this->redirect(array('admin'=>true,'controller'=>'products','action'=>'index'));
		}
		$product = $this->Product->read(null, $product_id);
		$prod = $product['Product']['prod'];
		$this->ProductOptions->recursive = -1;
		$order = $this->params['form']['product_ids'];

		if ($order && count($order))
		{
			foreach($order as $item_order => $pid)
			{
				$p = $this->Product->find("product_type_id = '$pid'");
				if (!empty($p))
				{
					$p['Product']['choose_index'] = $item_order+1;
					#$p['Product']['name'] += "2";
					#error_log("SETTING $pid to $item_order, P=".print_r($p,true));
					#$this->Product->id = $pid;
				#	error_log("PROD=".print_r($p,true));
					$this->Product->save($p,array());
				}
			}
		}
	}

}
?>
