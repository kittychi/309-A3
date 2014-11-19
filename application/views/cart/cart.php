<h2>Cart</h2>
<?php 
	session_start();

	if (!isset($_SESSION['cart'])) {
		$_SESSION['cart'] = array()
	}

	echo "<p>" . anchor('store/index','Back') . "</p>";

	echo "<p> ID = " . $product->id . "</p>";
	echo "<p> NAME = " . $product->name . "</p>";
	echo "<p> Description = " . $product->description . "</p>";
	echo "<p> Price = " . $product->price . "</p>";
	echo "<p><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px'/></p>";
		
?>	

