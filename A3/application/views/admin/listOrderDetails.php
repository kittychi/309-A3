<h2>Customer Order Details Table</h2>

<div class="panel panel-default">
	<div class="panel-heading"><strong>Customer Information</strong></div>
	<div class="panel-body">

	<form class="form-horizontal" role="form">
		<div class="form-group">
			<label class="col-sm-2 control-label">Name</label>
			<p class="form-control-static"><?php echo $customer->first . ' ' . $customer->last; ?></p>	
			<label class="col-sm-2 control-label">Email</label>
			<p class="form-control-static"><?php echo $customer->email; ?></p>	
			<label class="col-sm-2 control-label">Username</label>
			<p class="form-control-static"><?php echo $customer->login; ?></p>	
		</div>
	</form>
	</div>
</div>


<?php 
	foreach ($orderdetails as $orderdetail) {
			$order = $orderdetail->order; 
			$items = $orderdetail->orderitems; 	?>

	<div class="panel panel-default">
	  <!-- Default panel contents -->
	  <div class="panel-heading"><strong>ORDER NUMBER <?php echo $order->id; ?></strong></div>
	  <div class="panel-body">
	  	<form class="form-horizontal" role="form">
			<div class="form-group">
				<label class="col-sm-2 control-label">Placed at</label>
				<p class="form-control-static"><?php echo $order->order_date . ' ' . $order->order_time; ?></p>	
				<label class="col-sm-2 control-label">Credit Card Number</label>
				<p class="form-control-static"><?php echo $order->creditcard_number; ?></p>	
				<label class="col-sm-2 control-label">Expiry Date (MM/YY)</label>
				<p class="form-control-static"><?php echo $order->creditcard_month . '/' . $order->creditcard_year; ?></p>	
			</div>
		</form>
	  </div>

	  <!-- Table -->
	  <table class="table table-striped">
	    <?php 
	    foreach ($items as $item) { ?>
			<tr>
			<?php echo "<td><img src='" . base_url() . "images/product/" . $item->photo_url . "' width='100px' /></td>";
			
			echo "<td><strong>Name</strong>: " . $item->name . 
			"<br><strong>Description</strong>: " . $item->description . 
			"<br><strong>Price</strong>: $" . $item->price . 
			"<br><strong>Quantity</strong>: " . $item->quantity . "</td>";
			echo "</tr>";
		}
	    ?>
	  </table>
	</div>
	<?php } ?>