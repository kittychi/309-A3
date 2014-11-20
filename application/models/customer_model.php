<?php
class Customer_model extends CI_Model {

	function getAll()
	{  
		$query = $this->db->get_where('customers', array('login !=' => 'admin'));
		return $query->result('Customer');
	}  
	
	function get($username)
	{
		$query = $this->db->get_where('customers',array('username' => $username));
		
		return $query->row(0,'Customer');
	}

	function get_cid($cid) {
		$query = $this->db->get_where('customers', array('id' => $cid));
		return $query->row(0, 'Customer');
	}
	
	function insert($customer) {
		return $this->db->insert("customers", array('first' => $customer->first,
				                                  'last' => $customer->last,
											      'login' => $customer->login,
											      'password'=> $customer->password,
												  'email' => $customer->email));
	}
	 
	function update($customer) {
		$this->db->where('login', $customer->login);
		return $this->db->update("customers", array('first' => $customer->first,
				                                  'last' => $customer->last,
				                                  'password' => $customer->password,
											      'email' => $customer->email));
	}
	
	function login($username, $password) {
		$query = $this->db->get_where('customers', array('login'=>$username, 'password'=> $password));
		return $query->num_rows() == 1;
	}
	
	function deleteAll() {
		$this->db->delete('customers', array('login !=' => 'admin')); 
	}
}
?>
