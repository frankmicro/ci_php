<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controls the data flow into an auth object and updates the view whenever data changes.
 */
class Auth_Controller extends MY_Controller {
	
	/**
	 * '*' all user
	 * '@' logged in user
	 * 'Admin' for admin
	 * 'Editor' for editor group
	 * 'Author' for author group
	 * @var string
	 */
	protected $access = "*";

	protected $_auth = null;

	public function __construct()
	{
		parent::__construct();

		$this->_auth = $this->setSession();
		
		$this->login_check();
	}

	final function setSession()
	{	
		return $this->session->all_userdata();
	}

	final function login_check()
	{	
		if ($this->access != "*") 
		{ 	
			if (! $this->permission_check()) {
				die("<h4>Access denied</h4>");
			} 
			
			if (isset($this->_auth['logged_in']) && !$this->_auth['logged_in']) {  
				redirect("dashboard");
			} 

			if (!isset($this->_auth['logged_in']) && $this->_currentUrl != 'login.index') { 
				redirect("login");
			}
		}
	}

	final function permission_check()
	{ 	
		if ($this->access == "@") { 
			return true;
		}
		else
		{ 
			if (in_array($this->_currentUrl, $this->_except)) { 
				return true;
			}
						
			if (isset($this->_auth['logged_in'])) { 
				$access = is_array($this->access) ? $this->access : explode(",", $this->access); 
				//pr($this->_auth); die;
				if (in_array($this->_currentUrl, $access)) {  
					if(!in_array($this->_currentUrl, json_decode($this->_auth['permissions']))) { 
						return false;
					}
				} else { 
					return false;
				}
			}

			return true;
		}
	}

}