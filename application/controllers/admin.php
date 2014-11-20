<?php

class Admin extends CI_Controller {

	function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	}

	function allusers() {
		$this->load->model('customer_model');
		$customers = $this->customer_model->getAll();

		$viewdata['customers']=$customers;

		$data['view'] = 'admin/listCustomers.php'; 
		$data['viewdata'] = $viewdata; 
		$this->load->view('common/template.php',$data);
	}

	function allorders() { 
		$this->load->model('order_model');
		$this->load->model('customer_model');
		

		$orders = $this->order_model->getAll();
		// $orderdetails = 
		// $viewdata['orders'] = $this->getOrderDetails($orders); 
		$viewdata['orders'] = $orders;
		$data['viewdata'] = $viewdata; 
		$data['view'] = 'admin/listAllOrders.php'; 

		$this->load->view('common/template.php', $data);
	}

	function userOrdersDetails($cid, $oid=false) {
		$this->load->model('customer_model');
		$this->load->model('order_model');
		$this->load->model('orderitem_model');

		$customer = $this->customer_model->get_cid($cid);
		if (!$oid) {
			$orders = $this->order_model->getOrders_cid($cid);
		} else {
			$orders = $this->order_model->getOrders_oid($oid);
		}


		$viewdata['customer'] = $customer; 
		$viewdata['orderdetails'] = $this->getOrderDetails($orders); 
		$data['viewdata'] = $viewdata; 
		$data['view'] ='admin/listOrderDetails.php';

		$this->load->view('common/template.php', $data);
	}

	function getOrderDetails($orders) { 

		$this->load->model('orderitem_model');

		$orderdetail = array(); 
		if ($orders) {
			foreach ($orders as $order) {
				$detail = new Orderdetail(); 
				$detail->order = $order;
				$detail->orderitems = $this->orderitem_model->getOrderItems_oid($order->id);
				$orderdetail[] = $detail; 
			}
		}

		return $orderdetail;
	}

	function deleteAllUsers() {
		$this->load->model('orderitem_model');
		$this->load->model('order_model');
		$this->load->model('customer_model');

		$this->orderitem_model->deleteAll();
		$this->order_model->deleteAll();
		$this->customer_model->deleteAll();

		redirect('admin/allusers', 'refresh');
	}


}

?>