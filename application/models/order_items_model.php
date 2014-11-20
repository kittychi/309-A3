<?php
class Order_items_model extends CI_Model {

	function getAll()
	{  
		$query = $this->db->get('order_items');
		return $query->result('Order_items');
	}  
	
	function get($id)
	{
		$query = $this->db->get_where('order_items',array('id' => $id));
		
		return $query->row(0,'Order_items');
	}
	
	function delete($id) {
		return $this->db->delete("order_items",array('id' => $id ));
	}
	
	function insert($order_items) {
		return $this->db->insert("order_items", array('order_id' => $order_items->order_id,
				                                  'product_id' => $order_items->product_id,
												  'quantity' => $order_items->quantity));
	}
	 
	function update($order_items) {
		$this->db->where('id', $order_items->id);
		return $this->db->update("order_items", array('order_id' => $order_items->order_id,
				                                  'product_id' => $order_items->product_id,
												  'quantity' => $order_items->quantity));
	}
}
?>