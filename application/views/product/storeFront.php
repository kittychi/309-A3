<h2>Product Table</h2>
<?php 
		echo "<p>" . anchor('account/registerForm', 'Register') . "</p>";

		echo "<table class='table'>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
		
		foreach ($products as $product) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
				
			echo "<td>" . anchor("",'Add to Cart') . "</td>";
			echo "<td>" . anchor("store/read/$product->id",'View') . "</td>";
			echo "</tr>";
		}
		echo "<table>";
?>