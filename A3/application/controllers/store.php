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
		$viewdata['products']=$products;

		$data['viewdata'] = $viewdata; 
		$data['view'] = 'product/storeFront.php';
		$this->load->view('common/template.php',$data);
    }
    
    function viewProducts() { 
    	$this->load->model('product_model');
		$products = $this->product_model->getAll();
		$viewdata['products']=$products;

		$data['viewdata'] = $viewdata; 
		$data['view'] = 'product/list.php';
		$this->load->view('common/template.php',$data);
    }

    function newForm() {
    	$data['view']='product/newForm.php';
    	$data['viewdata']='';
    	$this->load->view('common/template.php', $data);
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

			$data['view']='product/newForm.php';
	    	$data['viewdata']='';
	    	$this->load->view('common/template.php', $data);
		}	
	}
	
	function read($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$viewdata['product']=$product;
		
		$data['view']='product/read.php';
    	$data['viewdata']=$viewdata;
    	$this->load->view('common/template.php', $data);
	}
	
	function editForm($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$viewdata['product']=$product;
		
		$data['view']='product/editForm.php';
    	$data['viewdata']=$viewdata;
    	$this->load->view('common/template.php', $data);
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
			$viewdata['product']=$product;
		
			$data['view']='product/editForm.php';
	    	$data['viewdata']=$viewdata;
	    	$this->load->view('common/template.php', $data);
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
   		$data['view'] ='cart/viewCart.php';
   		$data['viewdata'] = '';
   		$this->load->view('common/template.php', $data);
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

    	session_start();
    	foreach ($_SESSION['Cart'] as $Cart) {
    		$Cart->quant = $this->input->post("quant" . $Cart->prod->id);
    	}
    	redirect('store/viewCart', 'refresh');
    }

    function rmCart($id){

    	session_start();
    	unset($_SESSION['Cart'][$id]);
    	redirect('store/viewCart', 'refresh');
    }
    
    function cartToPurchase(){
    	$data['view'] = 'cart/creditCard.php';
    	$data['viewdata'] = '';
   		$this->load->view('common/template.php', $data);
    }

    function checkCredit(){
    	$num = strval($this->input->post("CCnumber"));
    	$month = $this->input->post("CCmonth");
    	$year = $this->input->post("CCyear");

    	$this->load->library('form_validation');
		$this->form_validation->set_rules('CCnumber', 'Credit Card Number', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('CCmonth', 'Month', 'trim|required|numeric|xss_clean|callback_check_expiry');
		$this->form_validation->set_rules('CCyear', 'Year', 'trim|required|numeric|xss_clean');
 
    	if (!$this->form_validation->run()) {
    		$data['view'] = 'cart/creditCard.php';
			$data['viewdata'] = '';
			$this->load->view('common/template.php', $data);

    	} else{
    		#valid start checkout
    		
    		session_start();
    		$total = 0;
			foreach ($_SESSION['Cart'] as $Cart) {
				$total += $Cart->prod->price * $Cart->quant;
			}
			$UN = $this->session->userdata('username');

				$this->load->model('customer_model');
				$customer = $this->customer_model->get($UN);

				$cdate = date("Y-m-d");
				$ctime = date("H:i:s");
				$this->load->model('orders_model');
				
				$orders = new Orders();
				$orders->customer_id = $customer->id;
		        $orders->order_date = $cdate;
		        $orders->order_time = $ctime;
		        $orders->total = $total;
		        $orders->creditcard_number = $num;
		        $orders->creditcard_month = $month;
			    $orders->creditcard_year = $year;

			    
			    $this->orders_model->insert($orders);
			    
			    $orders = $this->orders_model->get($customer->id, $cdate, $ctime);
			    $this->load->model('order_items_model');
			    foreach ($_SESSION['Cart'] as $Cart) {

			    	$order_items = new Order_items();
			    	$order_items->order_id = intval($orders->id,10);
			    	$order_items->product_id = intval($Cart->prod->id, 10);
			    	$order_items->quantity = intval($Cart->quant, 10);

			    	$this->order_items_model->insert($order_items);
    			}

    			session_unset();
    			session_destroy();

    			$this->load->model('product_model');
    			$viewdata['order_id'] = $orders->id;
    			$viewdata['total'] = $total;

    			$Items = $this->order_items_model->getAllfromOrder($viewdata['order_id']);
				$Msg = "Name\t Price\t Quantity \n";

				foreach($Items as $order){
					$prod_id = $order->product_id;
					$product = $this->product_model->get($prod_id);
					$Msg = $Msg . $product->name . "\t" . $product->price . "\t" . $order->quantity . "\n";
				}
				$Msg = $Msg . "Total Price: " . $total;

				// Pear Mail Library
				include_once "Mail.php";

				$from = "email@domain"; // this should be changed the email that you wish to send the receipt from 
				$to = $customer->email;
				$subject = "Card Shop";
				$body = $Msg;

				$headers = array(
				    'From' => $from,
				    'To' => $to,
				    'Subject' => $subject
				);

				// the following needs to be changed to whatever email smtp you're using
				$smtp = @Mail::factory('smtp', array(
				        'host' => 'ssl://smtp.mail.yahoo.com', 
				        'port' => '465',
				        'auth' => true,
				        'username' => "email@domain",
				        'password' => ""
				    ));

				$mail = @$smtp->send($to, $headers, $body);

				if (PEAR::isError($mail)) {
				    echo('<p>' . $mail->getMessage() . '</p>');
				} else {
				    echo('<p>Message successfully sent!</p>');
				}

    			$data['view'] = 'cart/Receipt.php';
    			$data['viewdata'] = $viewdata;
    			$this->load->view('common/template', $data);
    	}
    }

    function check_expiry($month) {

    	$year = $this->input->post("CCyear");

    	$CurMonth = intval(date("m"), 10);
    	$CurYear = intval(date("Y"), 10);


    	if ($CurYear > $year) {
    		# invalid year
    		$this->form_validation->set_message('check_expiry', 'Invalid year');
    		return false; 

    	} elseif ($CurYear == $year && $CurMonth >= $month) {
    		# invalid month
    		$this->form_validation->set_message('check_expiry', 'Invalid month');
    		return false;
    	} else {
    		return true; 
    	}
    }
}



class Cart_item {
	public $prod;
	public $quant;
}

?>
