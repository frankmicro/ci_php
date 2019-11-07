<?php

class Permission_model extends CI_Model {
	private $table = "permissions";
	private $_data = [];

	function __construct()
	{
		parent::__construct();
	}

	public function getInactiveList()
	{
		$query = $this->db->select('name')->from($this->table)->where('status', 0)->get()->result_array();

		return $query[0];
	}

	public function getActiveList()
	{
		$query = $this->db->select('name')->from($this->table)->where('status', 1)->get()->result_array();

		return $query[0];	
	}

	public function store()
	{
		$arr = [
			'dashboard.index', 'dashboard.create'
		];
		$data = ['name' => json_encode($arr)];
		$this->db->insert($this->table, $data);
	}

}