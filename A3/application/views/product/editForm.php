<h2>Edit Product</h2>
<div class='col-md-4 col-md-offset-4'>
<?php 
	echo "<p>" . anchor('store/index','Back') . "</p>";
	

	$formattr = array('role' => 'form');	
	echo form_open("store/update/$product->id", $formattr);
	?>
	<div class='form-group'>
	<?php
	echo form_label('Name'); 
	echo form_error('name');

	$name = array(	'name'        => 'name',
		             'id'          => 'name', 
		             'required'    => 'true',
		             'type'        => 'text',
		             'class'       => 'form-control',
		             'value'	=> $product->name);
	// echo form_input('name',$product->name,"required");
	echo form_input($name);
	?>
	</div>
	<div class='form-group'>
	<?php
	echo form_label('Description');
	echo form_error('description');

	$description = array('name'		=> 'description',
			             'id'       => 'description', 
			             'required'	=> 'true',
			             'type'		=> 'text',
			             'class'	=> 'form-control',
			             'value'	=> $product->description);
	// echo form_input('description',$product->description,"required");
	echo form_input($description);
	?>
	</div>
	<div class='form-group'>
	<?php
	echo form_label('Price');
	echo form_error('price');

	$price = array(	'name'		=> 'price',
					'id'       => 'price', 
					'required'	=> 'true',
					'type'		=> 'text',
					'class'	=> 'form-control',
					'value'	=> $product->price);
	// echo form_input('price',$product->price,"required");
	echo form_input($price);
	?>
	</div>
	<?php
	 $submit = array(
	               'name'       => 'save',
	               'id'         => 'savebtn',
	               'type'       => 'submit',
	               'class'      => 'btn btn-default',
	               'value'		=> 'Save' );
	echo form_submit($submit);
	echo form_close();
?>	
</div>
