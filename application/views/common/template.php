<!DOCTYPE html>
<html>
<head>
	<?php $this->load->view('common/scripts.html'); ?>
</head>
<body>
	<div class='container'>
		<div class='no-print'>
			<?php 

			$headerdata['loggedin'] = $this->session->userdata('logged_in');
			$headerdata['username'] = $this->session->userdata('username');
			$headerdata['isadmin'] = $this->session->userdata('isadmin');
			?>
			<header> 
				<div id='banner'>
					<?php 
					// $this->load->helper('html');
					// $banner = img('images/BaseballBanner1.png');
					// echo anchor('store/index', $banner); 
					?>
					<img src='<?php echo base_url(); ?>/images/BaseballBannerWide<?php echo rand(0, 2); ?>.png' width='1140px' class="img-responsive"/> 
				</div>
				<?php $this->load->view('common/navbar.php', $headerdata); ?>	
			</header>
		</div>
	<?php $this->load->view($view, $viewdata); ?>
	</div>
</body>
</html>