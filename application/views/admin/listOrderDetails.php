<h2>Customer Order Details Table</h2>
<?php 	
		
	echo '<h2>Customer Name ' . $customer->first . ' ' . $customer->last . '</h2>';
	echo '<h2>Customer Email ' . $customer->email . '</h2>';
	echo '<h2>Customer Username ' . $customer->login . '</h2>';

	echo "<div class='table'>";
	
	foreach ($orderdetails as $orderdetail) {
		$order = $orderdetail->order; 
		$items = $orderdetail->orderitems; 
		echo "<div>";
		echo "<p>Order placed: " . $order->order_date . " " . $order->order_time . "</p>";
		echo "<p>Credit card info: " . $order->creditcard_number . " expires on: ". $order->creditcard_month . "/" . $order->creditcard_year . "</p>";
		echo "<p>Total: $" . $order->total . "</p>";

		echo "<table class='table'>";
		echo "<h2>Items included in this order</h2>";
		echo "<tr><th>Card</th><th>Card Info</th></tr>";

		foreach ($items as $item) {
			echo "<tr>";
			echo "<td><img src='" . base_url() . "images/product/" . $item->photo_url . "' width='100px' /></td>";
			echo "<td>Name: " . $item->name . 
			"<br>Description: " . $item->description . 
			"<br>Price: $" . $item->price . 
			"<br>Quantity: " . $item->quantity . "</td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "</div>";
	}
	echo "</div>";
?>