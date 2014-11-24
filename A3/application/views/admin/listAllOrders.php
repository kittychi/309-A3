<h2>Orders Table</h2>

<?php 
		echo "<table class='table'>";
		echo "<tr><th>Order ID</th><th>Order placed</th><th>Total</th><th>Credit card number</th><th>Credit card expiry date</th></tr>";
		
		foreach ($orders as $order) {
			
			echo "<tr>";
			echo "<td>" . $order->id . '</td>';
			echo '<td>' . $order->order_date . " " . $order->order_time . "</td>";
			echo "<td>" . $order->total . "</td>";
			echo '<td>' . $order->creditcard_number . "</td>";
			echo "<td>" . $order->creditcard_month . "/". $order->creditcard_year . "</td>";
				
			echo "<td>" . anchor("admin/userOrdersDetails/$order->customer_id/$order->id",'View details for this order') . "</td>";
				
			echo "</tr>";
		}
		echo "<table>";
?>	
