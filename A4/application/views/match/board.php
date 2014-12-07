<!DOCTYPE html>

<html>
	<head>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
	<script>

		var otherUser = "<?= $otherUser->login ?>";
		var user = "<?= $user->login ?>";
		var status = "<?= $status ?>";

		var base_url = "<?= base_url() ?>";
		
		
	</script>
	</head> 
<body>  
	<h1>Game Area</h1>

	<div>
	Hello <?= $user->fullName() ?>  <?= anchor('account/logout','(Logout)') ?>  
	
	</div>
	
	<div id='status'> 
	<?php 
		if ($status == "playing")
			echo "Playing " . $otherUser->login;
		else
			echo "Wating on " . $otherUser->login;
	?>
	</div>
	<canvas id="gameboard" width="780" height="800"></canvas>
	
	<canvas id="message" width="780" height="100"></canvas>
	<script>
	var canvas = document.getElementById('gameboard');
    var context = canvas.getContext('2d');
	var messagecan = document.getElementById("message"); 
	var messagectx = messagecan.getContext("2d"); 

	</script>
	<script src="<?= base_url()?>/js/arcade/board.js"></script>
	
	<p> game board goes here </p>
<?php 
	
	echo form_textarea('conversation'); 
	
	echo form_open();
	echo form_input('msg');
	echo form_submit('Send','Send');
	echo form_close();
	
?>
	
	
	
	
</body>

</html>
