$(function(){
			$('body').everyTime(1000,function(){
					if (status == 'waiting') {
						$.getJSON(base_url+'arcade/checkInvitation',function(data, text, jqZHR){
								if (data && data.status=='rejected') {
									alert("Sorry, your invitation to play was declined!");
									window.location.href = base_url+'arcade/index';
								}
								if (data && data.status=='accepted') {
									status = 'playing';
									$('#status').html('Playing ' + otherUser);
								}
								
						});
					}
					var url = base_url+"board/getMsg";
					$.getJSON(url, function (data,text,jqXHR){
						if (data && data.status=='success') {
							var conversation = $('[name=conversation]').val();
							var msg = data.message;
							if (msg.length > 0)
								$('[name=conversation]').val(conversation + "\n" + otherUser + ": " + msg);
						}
					});
					
//					var url = base_url+"board/getBoard"; 
//					$.getJSON(url, function (data, status, jqXHR) {
//						if (data && data.status=='success'){
//						// update board status
//							drawBoard(); 
//						// update who's turn it is
//						} else {
//						// display the error
//						}		
//					});
					
					// redrawing the board -- comment out when getBoard is in use
					drawBoard();
			});

			$('form').submit(function(){
				var arguments = $(this).serialize();
				var url = base_url+"board/postMsg";
				$.post(url,arguments, function (data,textStatus,jqXHR){
						var conversation = $('[name=conversation]').val();
						var msg = $('[name=msg]').val();
						$('[name=conversation]').val(conversation + "\n" + user + ": " + msg);
						});
				return false;
				});	
		});

		function drawBoard() {
			this.context.clearRect(0,0,this.canvas.width, this.canvas.height);
			drawBorder(); 
			drawHeader(); 
		}

		function drawBorder() {
			//draw vertical lines
			var i; 
			for (i = 0; i<8; i++) {
				this.context.beginPath();
				this.context.strokeStyle="blue"; 
				this.context.lineWidth=10; 
				this.context.moveTo(5+i*100, 110); 
				this.context.lineTo(5+i*100, 720); 
				this.context.stroke(); 
			}
			// draw horizontal lines
			for (i=1; i<8; i++) {
				this.context.beginPath(); 
				this.context.strokStyle="blue";
				this.context.lineWidth=10; 
				this.context.moveTo(0, 15+i*100); 
				this.context.lineTo(710, 15+i*100); 
				this.context.stroke(); 
			}
		}
		
		function drawPiece(col, row, colour) {
			
			//calculate the center of the piece
			var y = row*100+165;
			var x = col*100+55;
			if (row == -1) {
				y = 55; 
			} 
			
			this.context.beginPath(); 
			this.context.arc(x, y, 40, 0, Math.PI * 2);
//			this.context.fillStyle=colour;
			var grd = this.context.createLinearGradient(x-45, y-45, x+40, y+40);
			grd.addColorStop(0, colour);   
			grd.addColorStop(1, "white");
			this.context.fillStyle = grd;
			this.context.fill();
			this.context.strokeStyle = colour; 
			this.context.lineWidth=5;
			this.context.stroke();
		}

		function getMousePos(evt) {
	          var rect = this.canvas.getBoundingClientRect();
	          return {
	            x: Math.floor(((evt.clientX-rect.left)/(rect.right-rect.left)*this.canvas.width)/100),
	            y: Math.floor(((evt.clientY-rect.top)/(rect.bottom-rect.top)*this.canvas.height)/100)-1
	          };
	        }
		
		var curColumnSelected = -1 ; 
		
		function setMouseOver(x) {
			if (x < 0 || x > 7) {
				curColumnSelected = -1; 
			} else { 
				curColumnSelected = x; 
			}
		}
		
		function isFull(col) {
			return col == 3; 
		}
		
		function yourTurn() { 
			return true; 
		}
		
		function drawHeader() {
			if (this.curColumnSelected >= 0 && this.curColumnSelected < 7) {
				if (isFull(curColumnSelected) || !yourTurn() ) {
					drawPiece(curColumnSelected, -1, "gray");
				} else {
					drawPiece(curColumnSelected, -1, "yellow");
				}
			}
		}

		function writeMessage(message) {
	          this.messagectx.clearRect(0, 0, this.messagecan.width, this.messagecan.height);
	          this.messagectx.font = '18pt Calibri';
	          this.messagectx.fillStyle = 'black';
	          this.messagectx.fillText(message, 10, 25);
	        }
	        
        this.canvas.addEventListener('mousedown', function(evt) {
          var mousePos = getMousePos(evt);
          drawPiece(mousePos.x, mousePos.y, "yellow");
          var url = base_url+"board/validateMove";
          $.post(url, {col:mousePos.x}, function(data, status, jqXHR) {
        	  //show error message if any (not your turn or can't add to column)
        	  //http://www.dyn-web.com/tutorials/php-js/json/multidim-arrays.php
          });
        }, false);
        
        this.canvas.addEventListener('mousemove', function(evt) {
            var mousePos = getMousePos(evt);
            var message = 'Mouse position: ' + mousePos.x + ',' + mousePos.y;
            writeMessage(message);
            setMouseOver(mousePos.x);
          
          }, false);
