<h2>Product Table</h2>
<div class='row'>
<?php 	
	// echo "<table class='table'>";
	// echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
	
	foreach ($products as $product) { ?>
	<div class="col-sm-6 col-md-3">
		<div class="thumbnail">
	      <img class="resize" src=<?php echo "'" . base_url() . "images/product/" . $product->photo_url . "'"; ?>>
	      <div class="caption">
	        <h3><?php echo $product->name; ?></h3>
	        <h4>$<?php echo $product->price; ?></h4>
	        <p><?php echo $product->description; ?></p>
	        <p>
	        	<?php 
	        	if ($loggedin && !$isadmin) {
					echo anchor("",'Add to Cart', "class='btn btn-primary'");
				}
				?>
				<div class='btn-group'>
				<?php
				echo anchor("store/read/$product->id",'View', "class='btn btn-default'");
				if ($isadmin) {
					
					echo anchor("store/editForm/$product->id",'Edit', "class='btn btn-primary'");
					echo anchor("store/delete/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");' class='btn btn-primary'");
					
				}
				?>
				</div>
	        </p>
	      </div>
	    </div>
	</div>
<?php } ?>
</div>



