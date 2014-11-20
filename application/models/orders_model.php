<?php
class Orders_model extends CI_Model {

	function getAll()
	{  
		$query = $this->db->get('orders');
		return $query->result('Orders');
	}  
	
	function get($cid, $date, $time)
	{
		$query = $this->db->get_where('orders',array('customer_id' => $cid,
													'order_date' => $date,
													'order_time' => $time));
		
		return $query->row(0,'Orders');
	}
	
	function delete($id) {
		return $this->db->delete("orders",array('id' => $id ));
	}
	
	function insert($orders) {
		return $this->db->insert("orders", array('customer_id' => $orders->customer_id,
				                                  'order_date' => $orders->order_date,
				                                  'order_time' => $orders->order_time,
				                                  'total' => $orders->total,
				                                  'creditcard_number' => $orders->creditcard_number,
				                                  'creditcard_month' => $orders->creditcard_month,
												  'creditcard_year' => $orders->creditcard_year));
	}
	 
	function update($orders) {
		$this->db->where('id', $orders->id);
		return $this->db->update("orders", array('customer_id' => $orders->customer_id,
				                                  'order_date' => $orders->order_date,
				                                  'order_time' => $orders->order_time,
				                                  'total' => $orders->total,
				                                  'creditcard_number' => $orders->creditcard_number,
				                                  'creditcard_month' => $orders->creditcard_month,
												  'creditcard_year' => $orders->creditcard_year));
	}
	
	
}
?>