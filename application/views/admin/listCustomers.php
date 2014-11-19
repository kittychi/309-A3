<h2>Customers Table</h2>

<?php 
		echo anchor("admin/deleteAllUsers",'Delete everything', "onClick='return confirm(\"Do you really want to delete all records? This cannot be undone!\");'");
		echo "<table class='table'>";
		echo "<tr><th>Name</th><th>Email</th><th>Username</th></tr>";
		
		foreach ($customers as $customer) {
			echo "<tr>";
			echo "<td>" . $customer->first . ' ' . $customer->last . "</td>";
			echo "<td>" . $customer->email . "</td>";
			echo "<td>" . $customer->login . "</td>";
				
			echo "<td>" . anchor("admin/userOrdersDetails/$customer->id",'View all order details') . "</td>";
				
			echo "</tr>";
		}
		echo "<table>";
?>	
