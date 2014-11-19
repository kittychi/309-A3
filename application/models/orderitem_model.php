<?php
class Orderitem_model extends CI_Model {

	function getAll()
	{  
		$query = $this->db->get('order_items');
		return $query->result('Orderitem');
	}  

	function getOrderItems_oid($oid) {
		$items = $this->db->get_where('order_items', array('order_id' => $oid));

		if ($items->num_rows() == 0) {
			return false; 
		}

		$items = $items->result('Orderitem');
		$this->load->model('product_model');
		foreach ($items as $item) {
			$prod = $this->product_model->get($item->product_id);
			$item->name = $prod->name; 
			$item->description = $prod->description; 
			$item->price = $prod->price; 
			$item->photo_url = $prod->photo_url; 

		}
		return $items;
	}

	function deleteAll() {
		$this->db->empty_table('order_items'); 
	}
}
?>