<?php

class Account extends CI_Controller {

	function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	}

	function registerForm() {
		$this->load->view('common/scripts.html');
		$this->load->view('account/register.php');
	}

	function register() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('firstname','First Name','required');
		$this->form_validation->set_rules('lastname','Last Name','required');
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');
		// $this->form_validation->set_rules('passwordconf',)

		$this->form_validation->set_rules('email','E-mail','required');
		
		if ($this->form_validation->run()) {
			$this->load->model('customer_model');

			$customer = new customer();
			$customer->firstname = $this->input->get_post('firstname');
			$customer->lastname = $this->input->get_post('lastname');
			$customer->username = $this->input->get_post('username');
			$customer->password = $this->input->get_post('password');
			$customer->email = $this->input->get_post('email');
			
			$this->customer_model->insert($customer);
			//Then we redirect to the index page again
			redirect('store/index', 'refresh');
		}
		else {
			$customer = new customer();
			$customer->firstname = set_value('firstname');
			$customer->lastname = set_value('lastname');
			$customer->username = set_value('username');
			$customer->email = set_value('email');
			$data['customer']=$customer;
			$this->load->view('customer/register.php',$data);
		}
	}
}

?>