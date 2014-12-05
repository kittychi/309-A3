<!DOCTYPE html>

<html>
	<head>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
	<script>

		var otherUser = "<?= $otherUser->login ?>";
		var user = "<?= $user->login ?>";
		var status = "<?= $status ?>";
		
		$(function(){
			$('body').everyTime(2000,function(){
					if (status == 'waiting') {
						$.getJSON('<?= base_url() ?>arcade/checkInvitation',function(data, text, jqZHR){
								if (data && data.status=='rejected') {
									alert("Sorry, your invitation to play was declined!");
									window.location.href = '<?= base_url() ?>arcade/index';
								}
								if (data && data.status=='accepted') {
									status = 'playing';
									$('#status').html('Playing ' + otherUser);
								}
								
						});
					}
					var url = "<?= base_url() ?>board/getMsg";
					$.getJSON(url, function (data,text,jqXHR){
						if (data && data.status=='success') {
							var conversation = $('[name=conversation]').val();
							var msg = data.message;
							if (msg.length > 0)
								$('[name=conversation]').val(conversation + "\n" + otherUser + ": " + msg);
						}
					});
			});

			$('form').submit(function(){
				var arguments = $(this).serialize();
				var url = "<?= base_url() ?>board/postMsg";
				$.post(url,arguments, function (data,textStatus,jqXHR){
						var conversation = $('[name=conversation]').val();
						var msg = $('[name=msg]').val();
						$('[name=conversation]').val(conversation + "\n" + user + ": " + msg);
						});
				return false;
				});	
		});

		
		function drawBorder(context) {
			//draw vertical lines
			var i; 
			for (i = 0; i<8; i++) {
				context.beginPath();
				context.strokStyle="blue"; 
				context.lineWidth=10; 
				context.moveTo(5+i*100, 0); 
				context.lineTo(5+i*100, 610); 
				context.stroke(); 
			}
			// draw horizontal lines
			for (i=0; i<7; i++) {
				context.beginPath(); 
				context.strokStyle="blue";
				context.lineWidth=10; 
				context.moveTo(0, 5+i*100); 
				context.lineTo(710, 5+i*100); 
				context.stroke(); 
			}
		}

		function getMousePos(canvas, evt) {
	          var rect = canvas.getBoundingClientRect();
	          return {
	            x: Math.floor(((evt.clientX-rect.left)/(rect.right-rect.left)*canvas.width)/100),
	            y: Math.floor(((evt.clientY-rect.top)/(rect.bottom-rect.top)*canvas.height)/100)
	          };
	        }
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
	<canvas id="gameboard" width="780" height="670"></canvas>
	
	<canvas id="message" width="780" height="100"></canvas>
	<script>
		var canvas = document.getElementById('gameboard');
	    var context = canvas.getContext('2d');
		var messagecan = document.getElementById("message"); 
		var messagectx = messagecan.getContext("2d"); 
	    drawBorder(context);

	      function writeMessage(canvas, message) {
	          var context = canvas.getContext('2d');
	          context.clearRect(0, 0, canvas.width, canvas.height);
	          context.font = '18pt Calibri';
	          context.fillStyle = 'black';
	          context.fillText(message, 10, 25);
	        }
	        
        canvas.addEventListener('mousedown', function(evt) {
          var mousePos = getMousePos(canvas, evt);
          var message = 'Mouse position: ' + mousePos.x + ',' + mousePos.y;
          writeMessage(messagecan, message);
        }, false);

	</script>
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
