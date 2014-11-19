<!DOCTYPE html>
<html>
<head>
	<?php $this->load->view('common/scripts.html'); ?>
</head>
<body>
	<?php 

	$headerdata['loggedin'] = $this->session->userdata('logged_in');
	$headerdata['username'] = $this->session->userdata('username');
	$headerdata['isadmin'] = $this->session->userdata('isadmin');

	$this->load->view('common/header.php', $headerdata); ?>

	<?php $this->load->view($view, $viewdata); ?>

</body>
</html>