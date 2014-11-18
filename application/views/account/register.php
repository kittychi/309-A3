  <h2>Register for an account</h2>

  <div class='col-md-4 col-md-offset-4'>
<?php

  // echo validation_errors(); 

  echo form_open('account/register');

  echo form_label('First Name');
  echo form_error('firstname');
  $firstname = array(
               'name'        => 'firstname',
               'id'          => 'firstname',
               'class'       => 'form-control',
               'placeholder' => 'First Name', 
               'required'    => 'true',
               'type'        => 'text',
               'class'       => 'form-control'
             );
  echo form_input($firstname);

  echo form_label('Last Name', 'lastname');
  echo form_error('lastname');
  $lastname = array(
               'name'        => 'lastname',
               'id'          => 'lastname',
               'class'       => 'form-control',
               'placeholder' => 'last Name', 
               'required'    => 'true',
               'type'        => 'text',
               'class'       => 'form-control'
             );
  echo form_input($lastname);

  echo form_label('E-mail', 'email');
  echo form_error('email');
  $email = array(
               'name'        => 'email',
               'id'          => 'email',
               'class'       => 'form-control',
               'placeholder' => 'E-mail', 
               'required'    => 'true',
               'type'        => 'email',
               'class'       => 'form-control'
             );
  echo form_input($email);

  echo form_label('Username', 'username');
  echo form_error('username');
  $username = array(
               'name'        => 'username',
               'id'          => 'username',
               'class'       => 'form-control',
               'placeholder' => 'Userame', 
               'required'    => 'true',
               'type'        => 'text',
               'class'       => 'form-control'
             );
  echo form_input($username);

  echo form_label('Password', 'password');
  echo form_error('password');
  $password = array(
               'name'        => 'password',
               'id'          => 'password',
               'class'       => 'form-control',
               'placeholder' => 'Password', 
               'required'    => 'true',
               'type'        => 'password',
               'class'       => 'form-control'
             );
  echo form_password($password);

  echo form_label('Confirm Password', 'passwordconf');
  echo form_error('passwordconf');
  $passwordconf = array(
               'name'        => 'passwordconf',
               'id'          => 'passwordconf',
               'class'       => 'form-control',
               'placeholder' => 'Confirm Password', 
               'required'    => 'true',
               'type'        => 'password',
               'class'       => 'form-control'
             );
  echo form_password($password);

  if(isset($fileerror))
    echo $fileerror;


// <input name="submit" type="submit" value="Register" abp="15">
  $submit = array(
               'name'        => 'submit',
               'id'          => 'registerbtn',
               'placeholder' => 'Confirm Password',
               'type'        => 'submit',
               'class'       => 'btn btn-lg btn-primary btn-block',
               'value'       => 'Register',
             );
  echo form_submit($submit);
  echo form_close(); 
?>
</div>