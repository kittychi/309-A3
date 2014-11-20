  <h2>Credit Card Info</h2>

  <div class='col-md-4 col-md-offset-4'>

<?php
  echo anchor('store/index', 'Back', 'id="backbtn" class="btn btn-primary"');
  // echo validation_errors(); 
	session_start();

	if (!isset($_SESSION['Cart']) || count($_SESSION['Cart']) <= 0) {
		echo "<p> Your Cart is Empty </p>";
	} else {
		echo form_open("store/CheckCredit");
		$total = 0;
		foreach ($_SESSION['Cart'] as $Cart) {
			$total += $Cart->prod->price * $Cart->quant;
		}

		echo form_label('Credit Card Number');
		echo form_error('creditcard_number');
		$CCnumber = array(
	             'name'        => 'CCnumber', 
	             'id'          => 'CCnumber',
		         'placeholder' => '0000000000000000', 
	             'required'    => 'true',
	             'type'        => 'text',
	             'maxlength'	=> '16',
	             'class'       => 'form-control'
	           );
		echo form_input($CCnumber);

		echo form_label('Expire Date');
		echo form_error('creditcard_month');
		$CCmonth = array(
	             'name'        => 'CCmonth', 
	             'id'          => 'CCmonth',
		         'placeholder' => 'MM', 
	             'required'    => 'true',
	             'type'        => 'number',
	             'min'	=> '1',
	             'max'	=> '12'
	           );
		echo form_input($CCmonth);

		echo form_error('creditcard_year');
		$CCyear = array(
	             'name'        => 'CCyear', 
	             'id'          => 'CCyear',
		         'placeholder' => 'YYYY', 
	             'required'    => 'true',
	             'type'        => 'number',
	             'min'	=> '2014',
	             'max'	=> '9999'
	           );
		echo form_input($CCyear);

		$submit = array(
			               'name'        => 'Purchase',
			               'id'          => 'EditCartbtn',
			               'type'        => 'submit',
			               'class'       => 'btn btn btn-default',
			               'content'       => 'Purchase',
			             );
		echo "<p> Total: $" . $total . "</p>";
		echo form_button($submit);
		echo form_close();
	}
		
?>	

</div>