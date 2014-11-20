<h2>Receipt</h2>
<?php 

	echo "<p>" . anchor('store/index','Back to Browse', 'class="btn btn-primary"') . "</p>";

	echo "<table>";
	echo "<tr><th>Card</th><th>Price</th><th>Quantity</th></tr>";
	
	$this->load->model('order_items_model');

	$Items = $this->order_items_model->getAllfromOrder($order_id);

	$this->load->model('product_model');
	
	foreach($Items as $order){
		$product = $this->product_model->get($order->product_id);
		echo "<tr><td>" . $product->name . "</td><td>" . $product->price . "</td><td>" . $order->quantity . "</td></tr>";
	}


	echo "</table>";
?>	

