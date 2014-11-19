<?php
		if ($loggedin) {
			echo '<h3>Welcome ' . $username . ' ' . $loggedin . '</h3>';
			echo anchor('account/logout', 'Logout', 'id="logoutbtn" class="btn btn-primary"');

		} else {

			// echo $username;

			$formattr = array('class' => 'form-inline');
			$labelattr = array('class' => 'sr-only');
			echo form_open('account/login', $formattr);
			echo form_label('Username', 'username', $labelattr);
			echo form_error('username');
			$username = array(
			             'name'        => 'username',
			             'id'          => 'username',
			             'placeholder' => 'Username', 
			             'required'    => 'true',
			             'type'        => 'text',
			             'class'       => 'form-control'
			           );
			echo form_input($username);
	
		    echo form_label('Password', 'password', $labelattr);
		    echo form_error('password');
		    $password = array(
		                 'name'        => 'password',
		                 'id'          => 'password',
		                 'placeholder' => 'Password', 
		                 'required'    => 'true',
		                 'class'       => 'form-control'
		               );
		    echo form_password($password);
		    // echo '<button type="submit" class="btn btn-default">Sign in</button>';
	
		    $submit = array(
	               'name'        => 'login',
	               'id'          => 'loginbtn',
	               'type'        => 'submit',
	               'class'       => 'btn btn btn-default',
	               'content'       => 'Login',
	             );
	
	  		echo form_button($submit);
			echo anchor('account/registerForm', 'Register', 'id="registerbtn" class="btn btn-primary"');
			echo form_close();
		}
?>