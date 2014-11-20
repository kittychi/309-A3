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
    	$this->load->view('common/scripts.html');
   		$this->load->view('cart/creditCard.php');
    }

    function checkCredit(){
    	$num = $this->input->post("CCnumber");
    	$month = $this->input->post("CCmonth");
    	$year = $this->input->post("CCyear");

    	$CurMonth = intval(date("m"), 10);
    	$CurYear = intval(date("Y"), 10);

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
    			$data['order_id'] = $orders->id;
    			$data['total'] = $total;

    			$Items = $this->order_items_model->getAllfromOrder($data['order_id']);
				$Msg = "";

				foreach($Items as $order){
					$prod_id = $order->product_id;
					$product = $this->product_model->get($prod_id);
					$Msg += $product->name . "\t" . $product->price . "\t" . $order->quantity . "\n";
				}
				$Msg += "Total Price: " . $total;


    			require_once('class.phpmailer.php');
				//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

				$mail             = new PHPMailer();

				$body             = $Msg;
				//$body             = eregi_replace("[\]",'',$body);

				$mail->IsSMTP(); // telling the class to use SMTP
				$mail->Host       = "ssl://smtp.gmail.com"; // SMTP server
				$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
				                                           // 1 = errors and messages
				                                           // 2 = messages only
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
				$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
				$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
				$mail->Username   = "jonnu1818@gmail.com";  // GMAIL username
				$mail->Password   = "jasonm13";            // GMAIL password

				$mail->SetFrom('contact@prsps.in', 'PRSPS');

				//$mail->AddReplyTo("user2@gmail.com', 'First Last");

				$mail->Subject    = "Card Shop";

				//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

				$mail->MsgHTML($body);

				$address = $customer->email;
				$mail->AddAddress($address, "user2");

				//$mail->AddAttachment("images/phpmailer.gif");      // attachment
				//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

				if(!$mail->Send()) {
				  echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
				  echo "Message sent!";
				}

				#echo $this->email->print_debugger();

    			$this->load->view('cart/Receipt.php', $data);
    	}


    }
}

class Cart_item {
	public $prod;
	public $quant;
}

?>