<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed 
 * for all logged in users
 */
class Editor extends Auth_Controller {	
	protected $access = ['editor.getdata','editor.index'];

	protected $_except = ['editor.index'];
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('Editor_model','editor');
		$data = $this->editor->getData();
		$this->load->template('modules/editor/index');
	}

	public function getdata()
	{
		pr($this->session->all_userdata()); die;
	}
}