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
									writeMessage("");
								}
								
						});
					} else {
						var url = base_url+"board/getMsg";
						$.getJSON(url, function (data,text,jqXHR){
							if (data && data.status=='success') {
								var conversation = $('[name=conversation]').val();
								var msg = data.message;
								if (msg.length > 0)
									$('[name=conversation]').val(conversation + "\n" + otherUser + ": " + msg);
							}
						});
						
						var url = base_url+"board/getBoard"; 
						$.getJSON(url, function (data, status, jqXHR) {
							if (data && data.status=='success'){
								// update board board and redraw it on the page. 
								updateBoard(data.board, data.turn);
								drawBoard(); 
								// check that game is over
								if (data.end) {
									if (confirm(data.message + " \nClick OK to start another game!")) {
										$.getJSON(base_url+'arcade/endgame',function(data, text, jqZHR){
											if (data && data.status == 'success') {
												window.location.href = base_url+'arcade/index';
											} 
										});	
									}
								}
							} 
						});
					}
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

		var board;
		var turn; 
		function updateBoard(board, turn) {
			this.board = board; 
			this.turn = turn; 
		}
		
		function drawBoard() {
			this.context.clearRect(0,0,this.canvas.width, this.canvas.height);
			drawBorder(); 
			drawHeader(); 
			for (var i = 0; i<this.board.length; i++) {
				for (var j = 0; j<this.board[i].length; j++) {
					if (this.board[i][j] == 1) {
						drawPiece(i, j, 'red');
					} else if (this.board[i][j] == 2){
						drawPiece(i, j, 'yellow');
					}
				}
				
			}
			
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
	            
	            // this doesn't really matter.. 
	            y: Math.floor(((evt.clientY-rect.top)/(rect.bottom-rect.top)*this.canvas.height)/100)-1
	          };
	        }
		
		var curColumnSelected = -1 ; 
		
		function setMouseOver(x) {
			// clear out message box if column changes
			if (curColumnSelected != x) {
				writeMessage("");
			}
			if (x < 0 || x > 7) {
				curColumnSelected = -1; 
			} else { 
				curColumnSelected = x; 
			}
		}
		
		function yourTurn() { 
			return this.turn == this.me; 
		}
		
		function drawHeader() {
			if (this.curColumnSelected >= 0 && this.curColumnSelected < 7) {
				if (!yourTurn()) {
					drawPiece(curColumnSelected, -1, "gray");
				} else {
					drawPiece(curColumnSelected, -1, this.colour);
				}
			}
		}

		function writeMessage(message) {
	          this.messagectx.clearRect(0, 0, this.messagecan.width, this.messagecan.height);
	          this.messagectx.font = '18pt Helvetica';
	          this.messagectx.fillStyle = 'black';
	          this.messagectx.textAlign = 'center';
	          this.messagectx.fillText(message, this.messagecan.width/2, this.messagecan.height/2);
	          
	        }
	    
        this.canvas.addEventListener('mousedown', function(evt) {
          var mousePos = getMousePos(evt);
          var url = base_url+"board/validateMove";
          $.post(url, {col:mousePos.x}, function(data, status, jqXHR) {
        	  var response = JSON.parse(data);
        	  if (response && response.status == 'failure') {
        		  writeMessage(response.message);
        	  } 
          });
        }, false);
        
        this.canvas.addEventListener('mousemove', function(evt) {
            var mousePos = getMousePos(evt);
            setMouseOver(mousePos.x);
          
          }, false);
        
        this.canvas.addEventListener('mouseout', function(evt) {
        	setMouseOver(-1);
        }, false);
