<div class='navbar navbar-default'>
	<div class='container-fluid'>
<?php
		if ($loggedin) { ?>
			<div class='navbar-header'>
				<a class='navbar-brand'>Welcome <?php echo $username; ?> </a>
			</div> 
			<ul class='nav navbar-nav navbar-right'>

				<li><?php echo anchor('account/logout', 'Logout', 'id="logoutbtn"'); ?> </li>
			</ul>
			<ul class='nav navbar-nav'>
				<li><?php echo anchor('store/index', 'Products', 'id="products"'); ?></li>
				<?php
				if ($isadmin) {
					?>
					<li><?php echo anchor('admin/allorders', 'Orders', 'id="allordersbtn"'); ?>
					<li><?php echo anchor('admin/allusers', 'Users', 'id="allusersbtn"'); ?> </li>
					<li class='dropdown'>
						 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Actions <span class="caret"></span></a>
						 <ul class="dropdown-menu" role="menu">
						  	<li><?php echo anchor('store/newForm', 'Add new product', 'id="addproductbtn"'); ?></li>
						  	<li><?php echo anchor('admin/deleteAllUsers','Delete all users and orders', "onClick='return confirm(\"Do you really want to delete all records? This cannot be undone!\");' id='deleteallsbtn'"); ?> </li>
						</ul>
					</li>
				<?php
				}
				?>
			</ul>
			
		<?php
		} else {

			// echo $username;

			$formattr = array('class' => 'form-inline navbar-form navbar-right');
			$labelattr = array('class' => 'sr-only');
			echo form_open('account/login', $formattr); ?>
			<div class='form-group'>
			<?php
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
			?>
			</div>
			<div class='form-group'>
			<?php
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
			?>
			</div>
			<?php
		    $submit = array(
	               'name'        => 'login',
	               'id'          => 'loginbtn',
	               'type'        => 'submit',
	               'class'       => 'btn btn btn-default',
	               'content'       => 'Login',
	             );
	
	  		echo form_button($submit);
	  		?>
	  		<div class='form-group'>
			<?php echo anchor('account/registerForm', 'Register', 'id="registerbtn" class="btn btn-primary"');?>
			</div>
			<?php
			echo form_close();
		}
?>
	</div>
</div>