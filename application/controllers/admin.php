<?php

class Admin extends CI_Controller {

	function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	}

	function allusers() {
		$this->load->model('customer_model');
		$customers = $this->customer_model->getAll();
		$data['customers']=$customers;
		$data['loggedin'] = $this->session->userdata('logged_in');
		$data['username'] = $this->session->userdata('username');
		$data['isadmin'] = $this->session->userdata('isadmin');
		
		$this->load->view('common/scripts.html');
		$this->load->view('common/header.php', $data);	
		$this->load->view('admin/listCustomers.php',$data);
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
		$data['customer'] = $customer; 
		$data['orderdetails'] = $orderdetail; 

		$data['loggedin'] = $this->session->userdata('logged_in');
		$data['username'] = $this->session->userdata('username');
		$data['isadmin'] = $this->session->userdata('isadmin');

		$this->load->view('common/scripts.html');
		$this->load->view('common/header.php', $data);
		$this->load->view('admin/listOrderDetails.php', $data);
	}
}

?>