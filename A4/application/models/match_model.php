<?php
class Match_model extends CI_Model {
	
	function getExclusive($id)
	{
		$sql = "select * from `match` where id=? for update";
		$query = $this->db->query($sql,array($id));
		if ($query && $query->num_rows() > 0)
			return $query->row(0,'Match');
		else
			return null;
	}

	function get($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('match');
		if ($query && $query->num_rows() > 0)
			return $query->row(0,'Match');
		else
			return null;
	}
	
	
	function insert($match) {
		return $this->db->insert('match',$match);
	}
	
	
	function updateMsgU1($id,$msg) {
		$this->db->where('id',$id);
		return $this->db->update('match',array('u1_msg'=>$msg));
	}
	
	function updateMsgU2($id,$msg) {
		$this->db->where('id',$id);
		return $this->db->update('match',array('u2_msg'=>$msg));
	}
	
	function updateStatus($id, $status) {
		$this->db->where('id',$id);
		return $this->db->update('match',array('match_status_id'=>$status));
	}
	
	function updateBoardState($id, $board) {
		$this->db->where('id', $id);
		$blob = serialize($board);
		return $this->db->update('match', array('board_state'=>$blob));
	}
	
	function getBoardState($id) {
		// get blob
		$query = $this->db->get_where('match', array('id' => $id));
		if ($query && $query->num_rows() > 0) {
			$result = $query->row(0);
			$blob = $result->board_state;
			// convert blob to board_state object
			$board = unserialize($blob);
					
			return $board;
		} else 
			return null;
		
		
	}
}
?>