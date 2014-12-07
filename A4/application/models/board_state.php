<?php
class Board_State { 
	const U1 = 1; 
	const U2 = 2; 
	
	public $turn; 
	public $board;

	public function newBoard() {
		$this->$turn = 1;
		$this->$board = array(
			array(0,0,0,0,0,0,0),
			array(0,0,0,0,0,0,0),
			array(0,0,0,0,0,0,0),
			array(0,0,0,0,0,0,0),
			array(0,0,0,0,0,0,0),
			array(0,0,0,0,0,0,0)
			);
	}
}