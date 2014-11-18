<?php
class Product_model extends CI_Model {

	function getAll()
	{  
		$query = $this->db->get('customers');
		return $query->result('Customers');
	}  
	
	function get($username)
	{
		$query = $this->db->get_where('customers',array('username' => $username));
		
		return $query->row(0,'Customers');
	}
	
	function insert($customer) {
		return $this->db->insert("customers", array('firstname' => $customer->firstname,
				                                  'lastname' => $customer->lastname,
											      'login' => $customer->login,
												  'email' => $customer->email));
	}
	 
	function update($customer) {
		$this->db->where('login', $customer->login);
		return $this->db->update("customers", array('firstname' => $customer->firstname,
				                                  'lastname' => $customer->lastname,
											      'email' => $customer->email));
	}
	
	function login($username, $password) {
		$query = $this->db->get_where('login', $username, 'password', $password);

	}
	
}
?>
