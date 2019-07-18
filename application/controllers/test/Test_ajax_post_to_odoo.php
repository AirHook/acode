<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_ajax_post_to_odoo extends CI_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function index()
	{
		echo 'Processing... ';
		
		if ($this->input->post())
		{
			$data = array(
				'config_name' => 'post_for_odoo',
				'config_value' => json_encode($this->input->post())
			);
			$DB = $this->load->database('instyle', TRUE);
			$query = $DB->insert('config', $data);
			
			echo 'Done';
		}
		else echo 'Fail!';
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function show()
	{
		echo '<pre>';
		
		$DB = $this->load->database('instyle', TRUE);
		$query = $DB->get('config', array('config_name'=>'post_for_odoo'));
		$row = $query->row();
		
		if (isset($row)) print_r(json_decode($row->config_value, TRUE));
		
		echo 'Done!';
	}
	
	// ----------------------------------------------------------------------
	
}
