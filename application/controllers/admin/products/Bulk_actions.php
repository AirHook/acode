<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_actions extends Admin_Controller {

	/**
	 * DB Reference
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
	 * @return	void
	 */
	public function index()
	{
		// load pertinent library/model/helpers
		$this->load->library('products/product_details');

		// delete item from records
		// for anything else, use update
		if ($this->input->post('bulk_action') === 'del')
		{
			// iterate through the selected checkboxes
			foreach ($this->input->post('checkbox') as $key => $id)
			{
				// initialize product details
				$this->product_details->initialize(array('tbl_product.prod_id' => $id));

				$this->_del($id);
			}

			// set flash data
			$this->session->set_flashdata('success', 'delete');
		}
		else
		{
			// set database set clause based on bulk_action
			switch ($this->input->post('bulk_action'))
			{
				case '1':
					$post_ary['publish'] = '1';
					$post_ary['public'] = 'Y';
					$post_ary['view_status'] = 'Y';
				break;

				case '2':
					$post_ary['publish'] = '2';
					$post_ary['public'] = 'N';
					$post_ary['view_status'] = 'Y';
				break;

				case '0':
					$post_ary['publish'] = '0';
					$post_ary['public'] = 'N';
					$post_ary['view_status'] = 'N';
				break;
			}

			// iterate through the selected checkboxes
			foreach ($this->input->post('checkbox') as $key => $id)
			{
				$this->DB->where('prod_id', $id);
				$this->DB->update('tbl_product', $post_ary);

				// update product at odoo
				/* *
				if (
					ENVIRONMENT !== 'development'
					&& $this->product_details->d_url_structure == 'basixblacklabel'
				)
				{
					$this->_update_product_to_odoo($post_ary, $id);
				}
				// */
			}

			// set flash data
			$this->session->set_flashdata('success', 'edit');
		}

		$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->config->slash_item('admin_folder').'products';

		// redirect user
		redirect($referer, 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Delete item
	 *
	 * @params	string
	 * @return	void
	 */
	private function _del($prod_id)
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

		// if still has product, nothing more to do, else...
		if ( ! $has_product)
		{
			unset($_SESSION['active_category']);
		}
	}

	// ----------------------------------------------------------------------

}
