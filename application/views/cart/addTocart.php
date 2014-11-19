<h2>Added To Cart</h2>
<?php 
	session_start();

	if (!isset($_SESSION['Cart'])) {
		$_SESSION['Cart'] = array()
	}

	array_push($_SESSION['Cart'], $product);
	$this->load->view('cart/viewCart');
		
?>	

