<?php
	class OrderReportController extends AppController{

		public function index(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));
			// debug($orders);exit;

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
			// debug($portions);exit;


			// To Do - write your own array in this format
			$order_reports = array('Order 1' => array(
										'Ingredient A' => 1,
										'Ingredient B' => 12,
										'Ingredient C' => 3,
										'Ingredient G' => 5,
										'Ingredient H' => 24,
										'Ingredient J' => 22,
										'Ingredient F' => 9,
									),
								  'Order 2' => array(
								  		'Ingredient A' => 13,
								  		'Ingredient B' => 2,
								  		'Ingredient G' => 14,
								  		'Ingredient I' => 2,
								  		'Ingredient D' => 6,
								  	),
								);

			
			$order_list_with_details = array();
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));
			foreach($orders as $details):
				if(!isset($order_list_with_details[$details['Order']['id']])) {
					$order_list_with_details[$details['Order']['id']] = array('order_id' => $details['Order']['id'], 'name' => $details['Order']['name']);
				}

				if(isset($order_list_with_details[$details['Order']['id']])) {
					foreach($details['OrderDetail'] as $item_details):
						$order_list_with_details[$details['Order']['id']]['items'][] = array('item_id' => $item_details['item_id'], 'quantity' => $item_details['quantity'], 'name' => $item_details['Item']['name']);
					endforeach;
				}
			endforeach;

			$items_list = array();
			$this->loadModel('Item');			
			$items = $this->Item->find('all', array('conditions' => array('Item.valid' => 1)));
			//echo '<pre>'; print_r($items); echo '</pre>';
			foreach($items as $item):
				if(!isset($items_list[$item['Item']['id']])) {
					$items_list[$item['Item']['id']] = array('item_id' => $item['Item']['id'], 'name' => $item['Item']['name']);
				}
			endforeach;

			$this->loadModel('Portion');			
			$portions = $this->Portion->find('all', array('conditions' => array('Portion.valid' => 1),'recursive'=>2));
			foreach($portions as $portion):
				foreach($portion['PortionDetail'] as $portion_details):
					$items_list[$portion_details['Portion']['item_id']]['ingredients'][$portion_details['Part']['id']] = array('value' => $portion_details['value'], 'id' => $portion_details['Part']['id'], 'name' => $portion_details['Part']['name']);
				endforeach;
			endforeach;


			$order_options = $this->Order->find('list', ['keyField' => 'id', 'valueField' => 'name']);
			$this->set(compact('order_options'));

			$this->set('order_reports',$order_reports);
			$this->Set('order_list_with_details', $order_list_with_details);
			$this->Set('item_list_with_ingredients', $items_list);

			$this->set('title',__('Orders Report'));
		}

		public function Question(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

			// debug($orders);exit;

			$this->set('orders',$orders);

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
				
			// debug($portions);exit;

			$this->set('portions',$portions);

			$this->set('title',__('Question - Orders Report'));
		}

	}