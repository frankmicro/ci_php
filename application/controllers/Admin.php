<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for all logged in users
 */
class Admin extends Auth_Controller {	
	protected $access = '*';

	protected $_except = [];
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->template('modules/admin/index');
	}

	public function getdata()
	{
		$request = $this->input->post();
		
		$draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search= $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o)
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc")
        {
            $dir = "desc";
        }
        $valid_columns = array(
            0=>'id',
            1=>'username',
            2=>'role',
            3=>'status'
        );

        if(!isset($valid_columns[$col]))
        {
            $order = null;
        }
        else
        {
            $order = $valid_columns[$col];
        }
        if($order !=null)
        {
            $this->db->order_by($order, $dir);
        }
        
        for ($i=0; $i < count($request['columns']); $i++) { 
        	if ($i != 3)
				$this->db->like($valid_columns[$i],$request['columns'][$i]['search']['value']);
		}

        $this->db->limit($length,$start);
        $user = $this->db->get("user");
        $data = array();
        foreach($user->result() as $rows)
        {

            $data[]= [
                'id' => $rows->id,
                'username' => $rows->username,
                'role' => $rows->role,
                'status' => '<a href="#" class="btn btn-warning mr-1 editor_edit">Edit</a>
                 <a href="#" class="btn btn-danger mr-1">Delete</a>'

            ];     
        }
        $totalUsers = $this->totalUsers();
        
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $totalUsers,
            "recordsFiltered" => $totalUsers,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}

	 public function totalUsers()
    {
        $query = $this->db->select("COUNT(*) as num")->get("user");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
    }
}