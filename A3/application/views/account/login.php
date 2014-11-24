  <h2>Login</h2>

  <div class='col-md-4 col-md-offset-4'>

<?php
  // echo anchor('store/index', 'Back', 'id="backbtn" class="btn btn-primary"');
  // echo validation_errors(); 

  echo form_open('account/login');
  
  echo form_error('password');

  echo form_label('Username', 'username');
  $username = array(
               'name'        => 'username',
               'id'          => 'username',
               'placeholder' => 'Username', 
               'required'    => 'true',
               'type'        => 'text',
               'class'       => 'form-control'
             );
  echo form_input($username);

  echo form_label('Password', 'password');
  $password = array(
               'name'        => 'password',
               'id'          => 'password',
               'placeholder' => 'Password', 
               'required'    => 'true',
               'class'       => 'form-control'
             );
  echo form_password($password);

// <input name="submit" type="submit" value="Register" abp="15">
  $submit = array(
               'name'        => 'submit',
               'id'          => 'registerbtn',
               'type'        => 'submit',
               'class'       => 'btn btn-lg btn-primary btn-block',
               'value'       => 'Login',
             );
  echo form_submit($submit);
  echo form_close(); 
?>
</div>