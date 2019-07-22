<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends Admin_Controller {

	/**
	 * DB Object
	 *
	 * @var	object
	 */
	protected $DB;

	
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index()
	{
		// load pertinent library/model/helpers
		$this->load->library('odoo');
		
		// ser posts params
		$post_ary = $this->input->post();
		unset($post_ary['admin_sales_id']);
		unset($post_ary['designer']);
		
		if ($this->input->post('admin_sales_id'))
		{
			// update record
			$this->DB->where('admin_sales_id', $this->input->post('admin_sales_id'));
			$this->DB->update('tbladmin_sales', $post_ary);
			
			// process some data before sending to odoo
			$odoo_post_ary = $this->input->post();
			
			/***********
			 * Update ODOO
			 */
			 
			// pass data to odoo
			if (
				ENVIRONMENT !== 'development'
				&& $post_ary['designer_slug'] === 'basixblacklabel'
			) 
			{
				$odoo_response = $this->odoo->post_data($odoo_post_ary, 'sales_user', 'edit');
			}
			
			//echo '<pre>';
			//print_r($post_ary);
			//echo $odoo_response;
			//die('<br />here');
		}
		else
		{
			// insert record
			$this->DB->set($post_ary);
			$this->DB->insert('tbladmin_sales');
			$insert_id = $this->DB->insert_id();
			
			// process some data before sending to odoo
			$odoo_post_ary = $this->input->post();
			$odoo_post_ary['admin_sales_id'] = $insert_id;
			
			/***********
			 * Update ODOO
			 */
			 
			// pass data to odoo
			if (
				ENVIRONMENT !== 'development'
				&& $post_ary['designer_slug'] === 'basixblacklabel'
			) 
			{
				$odoo_response = $this->odoo->post_data($odoo_post_ary, 'sales_user', 'add');
			}
			
			//echo '<pre>';
			//print_r($post_ary);
			//echo $odoo_response;
			//die('<br />here');
			
			echo $insert_id;
		}
	}
	
	// ----------------------------------------------------------------------
	
}