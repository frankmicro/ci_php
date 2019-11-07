<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for all logged in users
 */
class Dashboard extends Auth_Controller {	
	protected $access = ['dashboard.index','dashboard.create'];

	protected $_except = [];

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{   
		$this->load->template('dashboard');
	}

	public function create()
	{
		echo "dashboard.create";
	}

}