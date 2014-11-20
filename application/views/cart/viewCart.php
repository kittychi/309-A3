<h2>Your Cart</h2>
<?php 
	session_start();
	echo "<p>" . anchor('store/index','Back') . "</p>";

	if (!isset($_SESSION['Cart']) || count($_SESSION['Cart']) <= 0) {
		echo "<p> Your Cart is Empty </p>";
	} else {
		echo "<table class='table'>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th><th>Quantity</th></tr>";
		foreach ($_SESSION['Cart'] as $Cart) {
			echo "<tr>";
			echo "<td>" . $Cart->prod->name . "</td>";
			echo "<td>" . $Cart->prod->description . "</td>";
			echo "<td>" . $Cart->prod->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $Cart->prod->photo_url . "' width='100px' /></td>";
			echo "<td>" . $Cart->quant . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
		
?>	

