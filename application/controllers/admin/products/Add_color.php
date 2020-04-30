<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_color extends Admin_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * @return	void
	 */
	public function index($id)
	{
		// load pertinent library/model/helpers
		$this->load->library('form_validation');
		$this->load->library('odoo');

		// set validation rules
		$this->form_validation->set_rules('color_code', 'Color', 'trim|required');
		$this->form_validation->set_rules('color_name', 'Color', 'trim|required|callback_validate_color['.$id.']');

		if ($this->form_validation->run() == FALSE)
		{
			// set flash message
			$this->session->set_flashdata('color_exists', TRUE);
		}
		else
		{
			// initialize...
			$this->product_details->initialize(array('tbl_product.prod_id'=>$id));

			// let's check for existing record and/or process new color
			if ($this->product_details->colors)
			{
				$new_colors = $this->product_details->colors.'-'.$this->input->post('color_name');
			}
			else
			{
				$new_colors = $this->input->post('color_name');
			}

			// set primary_img_id
			$primary_img_id = $this->input->post('primary_color') ? $this->input->post('color_code') : $this->product_details->primary_img_id;

			// connect to database
			$DB = $this->load->database('instyle', TRUE);

			// update records
			$update_records = array(
				'colors' => $new_colors,
				'primary_img_id' => $primary_img_id
			);
			$DB->set($update_records);
			$DB->where('prod_no', $this->input->post('prod_no'));
			$q = $DB->update('tbl_product');
			$update_records['prod_id'] = $id;

			// check if new color is set as primary color
			if ($this->input->post('primary_color'))
			{
				// lets remove any primary color by setting all colors to not primary
				$DB->set('primary_color', '0');
				$DB->where('prod_no', $this->input->post('prod_no'));
				$qremove = $DB->update('tbl_stock');
			}

			// insert new color to stock list
			$post_ary = $this->input->post();
			$post_ary['image_url_path'] = '';
			$post_ary['prod_id'] = $id;
			$post_ary['des_id'] = $this->product_details->des_id;
			unset($post_ary['color_code']);
			$q = $DB->insert('tbl_stock', $post_ary);
			$stock_id = $DB->insert_id();
			$post_ary['st_id'] = $stock_id;

			// insert new color to physical stock list
			$DB->set('st_id', $stock_id);
			$DB->insert('tbl_stock_physical');

			// set flash data
			$this->session->set_flashdata('color_added', TRUE);
		}

		// redirect user
		redirect($this->config->slash_item('admin_folder').'products/edit/index/'.$id, 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Validate Color
	 *
	 * @params	string
	 * @return	boolean
	 */
	public function validate_color($color_name, $prod_id)
	{
		// initialize properties
		$this->product_details->initialize(array('tbl_product.prod_id'=>$prod_id));

		// check if color exists...
		//$colors = explode('-', $this->product_details->colors);
		$colors = $this->product_details->available_colors(array(), TRUE);

		if (in_array($color_name, $colors))
		{
			$this->form_validation->set_message('validate_color', 'Color already exists!');
			return FALSE;
		}
		else return TRUE;
	}

	// ----------------------------------------------------------------------

}
