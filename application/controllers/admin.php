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
		$this->load->view('common/scripts.html');
		$this->load->view('admin/listCustomers.php',$data);
	}
}

?>