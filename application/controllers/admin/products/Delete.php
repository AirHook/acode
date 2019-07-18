<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete extends Admin_Controller {

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
		// load pertinent library/model/helpers
		$this->load->library('products/products_list');
		$this->load->library('products/del_unlink_prod');

		// initialize delet and unlink product class
		$config['prod_id'] = $prod_id;
		$config['st_id'] = ''; // if this is present, only the color variant will be deleted
		$this->del_unlink_prod->initialize($config);
		$this->del_unlink_prod->delunlink();

		// see if we need to change active variables
		// let us check if designer and catregory still has products
		$active_category = $this->session->active_category;
		$has_product = $this->products_list->select_products(
			array(
				'designer.url_structure' => $this->session->userdata('active_designer'),
				'tbl_product.categories LIKE' => (
					is_array($active_category)
					? '%"'.end($active_category).'"%'
					: '%"'.$active_category.'"%'
				)
			)
		);

		// if no more product, unset session
		if ( ! $has_product)
		{
			unset($_SESSION['active_category']);
		}

		// set flash data
		$this->session->set_flashdata('success', 'delete');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'products', 'location');
	}

	// ----------------------------------------------------------------------

}
