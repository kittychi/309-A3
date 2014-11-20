<!DOCTYPE html>
<html>
<head>
	<?php $this->load->view('common/scripts.html'); ?>
</head>
<body>
	<div class='container'>
	<?php 

	$headerdata['loggedin'] = $this->session->userdata('logged_in');
	$headerdata['username'] = $this->session->userdata('username');
	$headerdata['isadmin'] = $this->session->userdata('isadmin');
	?>
	<header> 
		<div id='banner'>
			<?php 
			$this->load->helper('html');
			$banner = img('images/Banner.jpg');
			echo anchor('store/index', $banner); 
			?> 
		</div>
		<?php $this->load->view('common/navbar.php', $headerdata); ?>	
	</header>
	
	<?php $this->load->view($view, $viewdata); ?>
	</div>
</body>
</html>