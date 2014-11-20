<h2>Receipt</h2>
<?php 

	echo "<p>" . anchor('store/index','Back to Browse', 'class="btn btn-primary"') . "</p>";

	echo "<table>";
	echo "<tr><th>Card</th><th>Price</th><th>Quantity</th></tr>";
	;

	$Items = $this->order_items_model->getAllfromOrder($order_id);
	
	foreach($Items as $order){
		$prod_id = $order->product_id;
		$product = $this->product_model->get($prod_id);
		echo "<tr><td>" . $product->name . "</td><td>" . $product->price . "</td><td>" . $order->quantity . "</td></tr>";
	}

	echo "<tr><td> Total Price: </td><td>" . $total . "</td></tr>";
	echo "</table>";
?>	

