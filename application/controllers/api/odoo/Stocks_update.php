<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stocks_update extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
    }
	
	// ----------------------------------------------------------------------
	
	public function index()
	{
		// set data variables...
		$this->data['file'] = 'dashboard';
		$this->data['page_title'] = 'Dashboard';
		$this->data['page_description'] = 'A summary of recent activities';
		
		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
	}
}
