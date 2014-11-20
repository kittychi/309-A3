<h2>Product Table</h2>
<?php 
		echo "<table class='table'>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th><th id=\"quant\">Quantity</th>";

		if ($loggedin && !$isadmin) {
			echo "<th>" . anchor('store/viewCart', 'View Cart', 'id="ViewCartBtn" class="btn btn-primary"') . "</th></tr>";
		} else {
			echo "</tr>";
		}
		
		foreach ($products as $product) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";

			echo "<td id=\"quant\">";
			echo form_open('store/addCart');
			echo form_error('quant');
			$quant = array(
			             'name'        => 'quant' . $product->id,
			             'value' 		=> '1', 
			             'required'    => 'true',
			             'type'        => 'number',
			             'min'			=> "1"
			           );
			echo form_input($quant);
			echo form_close();
			echo "</td>"; 
			
			if ($loggedin && !$isadmin) {
				echo "<td>" . anchor("store/addCart/$product->id",'Add to Cart') . "</td>";
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