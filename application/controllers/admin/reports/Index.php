<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	public function index()
	{
		// set data variables...
		$this->data['file'] = 'blank_page';
		$this->data['page_title'] = 'Reports';
		$this->data['page_description'] = 'Everything your need to know';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template5/template', $this->data);
	}
}
