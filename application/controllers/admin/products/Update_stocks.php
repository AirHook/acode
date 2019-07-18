<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_stocks extends Admin_Controller {

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
	 * Index - default method
	 *
	 * @return	void
	 */
	public function index($prod_id)
	{
		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('odoo');

		// initialize certain properties
		$this->product_details->initialize(array('tbl_product.prod_id'=>$prod_id));

		// grab post items
		$post_ary = $this->input->post();
		$post_ary_to_odoo = $this->input->post();

		// unset items
		unset($post_ary['designer_slug']);

		// update stock record
		// lets remove primary color first
		$DB->set($post_ary);
		$DB->where('st_id', $this->input->post('st_id'));
		$DB->update('tbl_stock');

		/***********
		 * Update ODOO
		 *
		// pass data to odoo
		if (
			ENVIRONMENT !== 'development'
			&& $post_ary_to_odoo['designer_slug'] === 'basixblacklabel'
		)
		{
			$odoo_response = $this->odoo->post_data($post_ary_to_odoo, 'products', 'edit');
		}
		// */

		//echo '<pre>';
		//print_r($post_ary_to_odoo);
		//echo $odoo_response;
		//die('<br />here');

		// set flash data
		$this->session->set_flashdata('stock_udpated', TRUE);

		// redirect user
		redirect($this->config->slash_item('admin_folder').'products/edit/index/'.$prod_id, 'location');
	}

	// ----------------------------------------------------------------------

}
