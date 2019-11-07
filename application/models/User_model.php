<?php

class User_model extends CI_Model {
	private $table = "user";
	private $_data = [];

	/**
	 * Constructs a new instance.
	 */
	function __construct()
	{
		parent::__construct();
	}

	public function store()
	{
		$permission = [
			'permission' => [
				['can'=>'read'],
				['can'=>'write']
			]

		];

		$arr = ['name'=>'admin','user_id'=>1,'permissions'=>json_encode($permission)];

		$this->db->insert('role',$arr);

		if ($this->db->affected_rows() > 0) {
		    // Code here after successful insert
		    return true; // to the controller
		}
	}

	public function validateUser()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$query = $this->db->select('id, username, password')->where("username", $username)->from($this->table)->get()->result_array();

		if ($query) {
			if ($query[0]['password'] == sha1($password)) {
				unset($query[0]['password']);
				$this->_data = $query[0];
				return ERR_NONE;
			}

			return ERR_INVALID_PASSWORD;
		} else {
			return ERR_INVALID_USERNAME;
		}
	}

	public function getUserData()
	{
 		// $this->db->select('id')->from('user')->where('id = '.$this->_data['id']);
    // $subQuery =  $this->db->get_compiled_select();
		//
		// // Main Query
		// $roleArr = $this->db->select('permissions')
    //      ->from('role')
    //      ->where("id IN ($subQuery)", NULL, FALSE)
    //      ->get()
    //      ->result_array();
		//
		// pr($subQuery->get()->result_array()); die;
		// pr($roleArr); die;

		$this->load->model('Role_model','role');
		$roleArr = $this->role->getUserWiseRole($this->_data['id']);
		return array_merge($this->_data, $roleArr);
	}

}
