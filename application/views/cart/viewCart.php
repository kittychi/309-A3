<h2>Your Cart</h2>
<?php 
	session_start();
	echo "<p>" . anchor('store/index','Back') . "</p>";

	if (!isset($_SESSION['Cart']) || count($_SESSION['Cart']) <= 0) {
		echo "<p> Your Cart is Empty </p>";
	} else {
		echo "<table class='table'>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th>";
		foreach ($_SESSION['Cart'] as $product) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
			echo "</tr>";
		}
		echo "</table>";
	}
		
?>	

