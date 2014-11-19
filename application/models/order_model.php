<?php
class Order_model extends CI_Model {

	function getAll()
	{  
		$query = $this->db->get('orders');
		return $query->result('Order');
	}  

	function getOrders_cid($cid) {
		$query = $this->db->get_where('orders', array('customer_id' => $cid));
		if ($query->num_rows() == 0) {
			return false; 
		} 
		return $query->result('Order');
	}
}
?>