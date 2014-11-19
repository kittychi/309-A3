<?php

class Account extends CI_Controller {

	function __autoload($class_name) {
    include $class_name . '.php';
	}


	function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	}

	function registerForm() {
		$this->load->view('common/scripts.html');
		$this->load->view('account/register.php');
	}

	function register() {

		try {
			$this->load->library('form_validation');

			$this->form_validation->set_rules('firstname','First Name','required');
			$this->form_validation->set_rules('lastname','Last Name','required');
			$this->form_validation->set_rules('username','Username','required|is_unique[customers.login]');
			$this->form_validation->set_rules('password','Password','trim|required|matches[passwordconf]');
			$this->form_validation->set_rules('passwordconf', 'Confirm Password', 'trim|required');
			$this->form_validation->set_rules('email','E-mail','required|valid_email');

			$password = $this->input->get_post('password');
			$passwordconf = $this->input->get_post('passwordconf');

			if ($this->form_validation->run() == true) {
				// redirect('store/index', 'refresh');

				$this->load->model('customer_model');

				$customer = new Customer();
				$customer->first = $this->input->get_post('firstname');
				$customer->last = $this->input->get_post('lastname');
				$customer->login = $this->input->get_post('username');
				$customer->password = $this->input->get_post('password');
				$customer->email = $this->input->get_post('email');
				 
				$this->customer_model->insert($customer);
				//Then we redirect to the index page again
				redirect('store/index', 'refresh');
			}
			else {

				$this->load->model('customer_model');

				$customer = new Customer();
				$customer->first = set_value('firstname');
				$customer->last = set_value('lastname');
				$customer->login = set_value('username');
				$customer->email = set_value('email');
				$data['customer']=$customer;

				$this->load->view('common/scripts.html');
				$this->load->view('account/register.php', $data);
			}
		} catch (Exception $e) {

		log_message('debug',$e->getMessage()); // use codeigniters built in logging library
        show_error($e->getMessage()); // or echo $e->getMessage()
      }


	}
}

?>