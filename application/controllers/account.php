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
		try {
			$this->load->library('form_validation');

			$this->form_validation->set_message('is_unique', 'The %s is already taken');

			$this->form_validation->set_rules('firstname','First Name','required');
			$this->form_validation->set_rules('lastname','Last Name','required');
			$this->form_validation->set_rules('username','Username','required|is_unique[customers.login]|alpha_numeric');
			$this->form_validation->set_rules('password','Password','trim|required|matches[passwordconf]|alpha_numeric');
			$this->form_validation->set_rules('passwordconf', 'Confirm Password', 'trim|required|alpha_numeric');
			$this->form_validation->set_rules('email','E-mail','required|valid_email|is_unique[customers.email]');

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

	function login() {
		$this->load->model('customer_model');

		$username =$this->input->post('username');
		$password =$this->input->post('password');
		$result = $this->customer_model->login($username, $password);

		if($result) {
			$sess_array = array(
					'username' => $username,
					'logged_in' => TRUE, 
					);
			$this->session->set_userdata($sess_array);

			if ($username=='admin') {
				$this->session->set_userdata('isadmin', true);
			}
		}
		else
		{
			$this->form_validation->set_message('check_database', 'Invalid username or password');
		}
			redirect('store/index', 'refresh');
	}

	function logout() {
		if ($this->session->userdata('logged_in')) {
			$sess_array = array(
					'username' => '',
					'logged_in' => false, 
					'isadmin' => false,
					);
			$this->session->set_userdata($sess_array);
		}

		session_unset(); 
		session_destroy();
		
		redirect('store/index', 'refresh');
	}
}

?>