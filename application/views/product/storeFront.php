<h2>Product Table</h2>
<?php 
		echo "<table class='table'>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th>";

		if ($loggedin && !$isadmin) {
			echo "<th>";
			echo anchor('', 'View Cart', 'id="addCartBtn" class="btn btn-primary"');
			echo "</th></tr>";
		} else {
			echo "</tr>"
		}
		
		foreach ($products as $product) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
			
			if ($loggedin && !$isadmin) {
				echo "<td>" . anchor("cart/addTocart/$product->id",'Add to Cart') . "</td>";
			}
			echo "<td>" . anchor("store/read/$product->id",'View') . "</td>";
			if ($isadmin) {
				echo "<td>" . anchor("store/editForm/$product->id",'Edit') . "</td>";
				echo "<td>" . anchor("store/delete/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</td>";
			}
			
			echo "</tr>";
		}
		echo "</table>";
?>