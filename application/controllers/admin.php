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

	function userOrdersDetails($cid) {
		$this->load->model('customer_model');
		$this->load->model('order_model');
		$this->load->model('orderitem_model');

		$customer = $this->customer_model->get_cid($cid);
		$orders = $this->order_model->getOrders_cid($cid);
		$orderdetail = array(); 
		if ($orders) {
			foreach ($orders as $order) {
				$detail = new Orderdetail(); 
				$detail->order = $order;
				$detail->orderitems = $this->orderitem_model->getOrderItems_oid($order->id);
				$orderdetail[] = $detail; 
			}
		}
		$viewdata['customer'] = $customer; 
		$viewdata['orderdetails'] = $orderdetail; 
		$data['viewdata'] = $viewdata; 
		$data['view'] ='admin/listOrderDetails.php';

		$this->load->view('common/template.php', $data);
	}

	function deleteAllUsers() {
		$this->load->model('orderitem_model');
		$this->load->model('order_model');
		$this->load->model('customer_model');

		redirect('admin/allusers', 'refresh');
	}
}

?>