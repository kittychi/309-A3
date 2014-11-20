<header>
<div id='banner'>

	<?php 

	$this->load->helper('html');
	$banner = img('images/Banner.jpg');
	echo anchor('store/index', $banner); 
	
	?> 
</div>
<?php
		if ($loggedin) {
			echo '<h3>Welcome ' . $username  . '</h3>';
			echo anchor('account/logout', 'Logout', 'id="logoutbtn" class="btn btn-primary"');

			if ($isadmin) {
				?>
				<div class='btn-group'>
				<?php
				echo anchor('admin/allorders', 'List All Orders', 'id="allordersbtn" class="btn btn-primary"');
				echo anchor('admin/allusers', 'List All Users', 'id="allusersbtn" class="btn btn-primary"');
				echo anchor('admin/deleteAllUsers','Delete all users and orders', "onClick='return confirm(\"Do you really want to delete all records? This cannot be undone!\");' id='deleteallsbtn' class='btn btn-primary'");
		
				echo anchor('store/newForm', 'Add new product', 'id="addproductbtn" class="btn btn-primary"'); 
				?>
			</div>
			<?php
			}
		} else {

			// echo $username;

			$formattr = array('class' => 'form-inline');
			$labelattr = array('class' => 'sr-only');
			echo form_open('account/login', $formattr);
			echo form_label('Username', 'username', $labelattr);
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
</header>