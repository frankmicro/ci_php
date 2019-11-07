<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	protected $_currentUrl;
	/**
	 * Constructs a new instance.
	 */
	function __construct()
	{
	    parent::__construct();

	    $this->_currentUrl = $this->router->fetch_class().'.'.$this->router->fetch_method();

	    define('TITLE', genStr($this->_currentUrl));

	}
}