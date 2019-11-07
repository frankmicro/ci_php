<?php

class Role_model extends CI_Model {
	private $table = "role";
	private $_data = [];

	function __construct()
	{
		parent::__construct();
	}

	public function getUserWiseRole($userId = false)
	{
		$query = $this->db->select('name, permissions')->from($this->table)->where('user_id', $userId)->get()->result_array();

		return $query[0];
	}

}