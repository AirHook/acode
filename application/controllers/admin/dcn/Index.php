<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		// set data variables...
		$this->data['file'] = 'dcn_dashboard';
		$this->data['page_title'] = 'Dcomentation';
		$this->data['page_description'] = '';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template5/template', $this->data);
	}
}
