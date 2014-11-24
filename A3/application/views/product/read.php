<h2>Product Details</h2>
<div class="row">
	<div class="col-md-12">
		<div class="thumbnail">
			<img  src=<?php echo "'" . base_url() . "images/product/" . $product->photo_url . "'"; ?>>
			<div class="caption">
			    <h3 class='text-center'><?php echo $product->name; ?></h3>
			    <h4 class='text-center'>$<?php echo $product->price; ?></h4>
			    <p class='text-center'><?php echo $product->description; ?></p>
			    <div class='text-center'>
				    <?php 
		        	if ($loggedin && !$isadmin) {
						echo anchor("",'Add to Cart', "class='btn btn-primary'");
					}?>
				</div>
		    </div>
		</div>
	</div>
</div>