<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This class describes a login.
 */
class Login extends Auth_Controller {
	protected $access = ['login.create'];

	protected $_except = ['login.logout','login.index'];

	/**
	 * Constructs a new instance.
	 */
	function __construct()
	{
		parent::__construct();
	}

	public function checkLogin()
	{
		if (isset($this->_auth['logged_in']) && $this->_auth['logged_in']) {
			redirect('dashboard');
		}
	}

	/**
	 * { function_description }
	 */
	public function index()
	{
		$this->checkLogin();

		$this->load->library('form_validation');
		$this->form_validation->set_rules("username", "Username", "trim|required");
		$this->form_validation->set_rules("password", "Password", "trim|required");

		if ($this->form_validation->run() == true) {

			$this->load->model('User_model','user');
			// check the username & password of user
			$status = $this->user->validateUser();

			if ($status == ERR_INVALID_USERNAME) {
				$this->session->set_flashdata("error", "Username is invalid");
			}
			elseif ($status == ERR_INVALID_PASSWORD) {
				$this->session->set_flashdata("error", "Password is invalid");
			}
			else {	
				// success
				// store the user data to session
				$this->session->set_userdata($this->user->getUserData());
				$this->session->set_userdata("logged_in", true);

				// redirect to dashboard
				redirect("dashboard");
			}
		}
			$this->load->template('modules/auth/login');
	}

	public function logout()
	{
		$this->session->unset_userdata("logged_in");
		$this->session->sess_destroy();
		redirect("login");
	}
}
