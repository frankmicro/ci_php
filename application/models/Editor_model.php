<?php

class Editor_model extends CI_Model {
	private $table = "user";
	private $_data = [];

	function __construct()
	{
		parent::__construct();
	}

	public function getData()
	{
		//$query = $this->db->select('*')->from($this->table)->get()->result_array();
		$this->db->from($this->table);
		$this->db->order_by("username", "desc");
		$this->db->limit(3,0);
		return $this->db->get()->result(); 
	}

}