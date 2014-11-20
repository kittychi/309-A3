<h2>Your Cart</h2>
<?php 
	session_start();
	if (!isset($_SESSION['Cart']) || count($_SESSION['Cart']) <= 0) {
		echo "<p> Your Cart is Empty </p>";
	} else {
		echo "<table class='table'>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th><th>Quantity</th></tr>";
		echo form_open("store/editCart");
		$total = 0;
		foreach ($_SESSION['Cart'] as $Cart) {
			echo "<tr>";
			echo "<td>" . $Cart->prod->name . "</td>";
			echo "<td>" . $Cart->prod->description . "</td>";
			echo "<td>" . $Cart->prod->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $Cart->prod->photo_url . "' width='100px' /></td>";
			$cid = $Cart->prod->id;
			$quantbtn = array(
				             'name'        => 'quant' . $cid,
				             'value' 		=> $Cart->quant, 
				             'required'    => 'true',
				             'type'        => 'number',
				             'min'			=> "1", 
				             'class'	=> 'form-control'
				           );
			echo "<td>". form_input($quantbtn) . "</td>";
			echo "<td>" . anchor("store/rmCart/$cid",'Delete') . "</td>";
			echo "</tr>";
			$total += $Cart->prod->price * $Cart->quant;
		}
		echo "</table>";
		$submit = array(
			               'name'        => 'EditCart',
			               'id'          => 'EditCartbtn',
			               'type'        => 'submit',
			               'class'       => 'btn btn btn-default',
			               'content'       => 'Edit Quantites',
			             );
		echo "<div>";
		echo form_button($submit);
		echo form_close();
		echo anchor('store/cartToPurchase', 'Purchase', 'id="purchasebtn" class="btn btn-primary"');
		echo "<p> Total: $" . $total . "</p>";
	}
		
?>	

