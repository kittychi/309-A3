<?php

class Store extends CI_Controller {
     
     
    function __construct() {
		// Call the Controller constructor
    	parent::__construct();
    	
    	
    	$config['upload_path'] = './images/product/';
    	$config['allowed_types'] = 'gif|jpg|png';
/*	    $config['max_size'] = '100';
    	$config['max_width'] = '1024';
    	$config['max_height'] = '768';
*/
    		    	
    	$this->load->library('upload', $config);
    }

    function index() {
		$this->load->model('product_model');
		$products = $this->product_model->getAll();
		$data['products']=$products;

		$data['loggedin'] = $this->session->userdata('logged_in');
		$data['username'] = $this->session->userdata('username');
		$data['isadmin'] = $this->session->userdata('isadmin');

		// $data['loggedin'] = True;
		// $data['username'] = 'admin'; 

		$this->load->view('common/scripts.html');
		$this->load->view('common/header.php', $data);
		$this->load->view('product/storeFront.php',$data);
    }
    
    function viewProducts() { 
    	$this->load->model('product_model');
		$products = $this->product_model->getAll();
		$data['products']=$products;
		$this->load->view('product/list.php',$data);
    }

    function newForm() {
	    	$this->load->view('product/newForm.php');
    }
    
	function create() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required|is_unique[products.name]');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		$fileUploadSuccess = $this->upload->do_upload();
		
		if ($this->form_validation->run() == true && $fileUploadSuccess) {
			$this->load->model('product_model');

			$product = new Product();
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$data = $this->upload->data();
			$product->photo_url = $data['file_name'];
			
			$this->product_model->insert($product);

			//Then we redirect to the index page again
			redirect('store/index', 'refresh');
		}
		else {
			if ( !$fileUploadSuccess) {
				$data['fileerror'] = $this->upload->display_errors();
				$this->load->view('product/newForm.php',$data);
				return;
			}
			
			$this->load->view('product/newForm.php');
		}	
	}
	
	function read($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/read.php',$data);
	}
	
	function editForm($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/editForm.php',$data);
	}
	
	function update($id) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		if ($this->form_validation->run() == true) {
			$product = new Product();
			$product->id = $id;
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$this->load->model('product_model');
			$this->product_model->update($product);
			//Then we redirect to the index page again
			redirect('store/index', 'refresh');
		}
		else {
			$product = new Product();
			$product->id = $id;
			$product->name = set_value('name');
			$product->description = set_value('description');
			$product->price = set_value('price');
			$data['product']=$product;
			$this->load->view('product/editForm.php',$data);
		}
	}
    	
	function delete($id) {
		$this->load->model('product_model');
		
		if (isset($id)) 
			$this->product_model->delete($id);
		
		//Then we redirect to the index page again
		redirect('store/index', 'refresh');
	}
      
   	function viewCart(){
		$this->load->view('common/scripts.html');
   		$this->load->view('cart/viewCart.php');
   	}
    
    function addCart($id){
    	$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$quant = $this->input->post('quant' . $id);

    	session_start();
		
		if (!isset($_SESSION['Cart'])) {
			$_SESSION['Cart'] = array();
		}

		if (!isset($_SESSION['Cart'][$product->id])){
			$newCart = new Cart_item();
			$newCart->prod = $product;
			$newCart->quant = $quant;
			$_SESSION['Cart'][$product->id] = $newCart;
		} else {
			$_SESSION['Cart'][$product->id]->quant += $quant;
		}

		redirect('store/viewCart', 'refresh');
    }

    function editCart(){

    	redirect('store/viewCart', 'refresh');
    }
    
    function cartToPurchase(){
    	$this->load->view('common/scripts.html');
   		$this->load->view('cart/creditCard.php');
    }

    function CheckCredit(){
    	$num = $this->input->post("CCnumber");
    	$month = $this->input->post("CCmonth");
    	$year = $this->input->post("CCyear");

    	$CurMonth = intval(date("m"), 10);
    	$CurYear = intval(date("y"), 10);

    	if ($CurYear > $year) {
    		# invalid year

    		$this->load->view('cart/creditCard.php');

    	} elseif ($CurYear == $year && $CurMonth >= $month) {
    		# invalid month

    		$this->load->view('cart/creditCard.php');
    	} else {
    		#valid start checkout

    		session_start();
    		$total = 0;
			foreach ($_SESSION['Cart'] as $Cart) {
				$total += $Cart->prod->price * $Cart->quant;
			}

    		$this->load->library('form_validation');
    		# create orders
    		$this->form_validation->set_rules('order_date','Date');
    		$this->form_validation->set_rules('order_time','Time');
    		$this->form_validation->set_rules('total','Total','decimal');
    		$this->form_validation->set_rules('creditcard_number','CC number','numeric|exact_length[16]');
    		$this->form_validation->set_rules('creditcard_month','CC month','greater_than[0]|less_than[13]');
    		$this->form_validation->set_rules('creditcard_year','CC year','greater_than[2013]');

    		if ($this->form_validation->run() == true) {
				$this->load->model('customer_model');
				$customer = $this->customer_model->get($this->session->userdata('username'));

				$cdate = date("Y-m-d");
				$ctime = date("H:i:s");

				$orders = new Orders();
				$orders->customer_id = $customer->id;
		        $orders->order_date = $cdate;
		        $orders->order_time = $ctime;
		        $orders->total = $total;
		        $orders->creditcard_number = $num;
		        $orders->creditcard_month = $month;
			    $orders->creditcard_year = $year;

			    $this->load->model('orders_model');
			    $this->orders_model->insert($orders);
			    $orders = $this->orders_model->get($customer->id, $cdate, $ctime);

			    $this->load->model('order_items_model');
			    foreach ($_SESSION['Cart'] as $Cart) {

			    	$order_items = new Order_items();
			    	$order_items = $orders->id;
			    	$order_items = $Cart->prod->id;
			    	$order_items = $Cart->quant;

			    	$this->order_items_model->insert($order_items);
    			}

    			session_unset();
    			session_destroy();
			} else {

				redirect('store/index', 'refresh');
			}

    	}


    }

    function makeO_item(){
    	$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required|is_unique[products.name]');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		$fileUploadSuccess = $this->upload->do_upload();
		
		if ($this->form_validation->run() == true && $fileUploadSuccess) {
			$this->load->model('product_model');

			$product = new Product();
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$data = $this->upload->data();
			$product->photo_url = $data['file_name'];
			
			$this->product_model->insert($product);

			//Then we redirect to the index page again
			redirect('store/index', 'refresh');
		}
		else {
			if ( !$fileUploadSuccess) {
				$data['fileerror'] = $this->upload->display_errors();
				$this->load->view('product/newForm.php',$data);
				return;
			}
			
			$this->load->view('product/newForm.php');
		}	
    }
}

class Cart_item {
	public $prod;
	public $quant;
}

?>