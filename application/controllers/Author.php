<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for all logged in users
 */
class Author extends Auth_Controller {	
	protected $access = ['author.getdata','author.index','author.index'];

	protected $_except = [];
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->template('modules/author/index');
	}

	public function getdata()
	{
		pr($this->session->all_userdata()); die;
	}
}