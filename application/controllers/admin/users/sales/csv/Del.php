<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Del extends Admin_Controller {

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
	public function index($user_id = '')
	{
		if ($user_id)
		{
			// update record
			$this->DB->where('admin_sales_id', $user_id);
			$this->DB->delete('tbladmin_sales');
			
			/***********
			 * Update ODOO
			 */
			 
			// pass data to odoo
			if (
				ENVIRONMENT !== 'development'
				&& $post_ary['designer_slug'] === 'basixblacklabel'
			) 
			{
				$odoo_response = $this->odoo->post_data(array('admin_sales_id'=>$user_id), 'sales_user', 'del');
			}
			
			//echo '<pre>';
			//print_r($post_ary);
			//echo $odoo_response;
			//die('<br />here');
			echo 'Deleted';
		}
	}
	
	// ----------------------------------------------------------------------
	
}