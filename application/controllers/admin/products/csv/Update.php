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
		// set id of vendor type slug
		$this->load->library('users/vendor_user_details');
		$this->load->library('categories/categories_tree');
		$this->load->library('designers/designer_details');

		$this->load->library('users/vendor_types_list');

		// process designer and convert to id
		// initialize designer details and get des_id
		$this->designer_details->initialize(array('url_structure'=>($this->input->post('designer') ?: 'basixblacklabel')));
		$designer = $this->designer_details->des_id;
		$des_id = $this->designer_details->des_id;

		// process categories
		// convert post slugs to id's
		$cat_ids = array();
		$the_input_cat_slugs = explode(',', ($this->input->post('categories') ?: 'womens_apparel,dresses,wedding_dresses'));
		foreach ($the_input_cat_slugs as $cat)
		{
			$cat_id = $this->categories_tree->get_id($cat);
			if ($cat_id) array_push($cat_ids, $cat_id);
		}
		$categories = json_encode($cat_ids);

		// process vendor details
		// initialize vendor details and get id
		$this->vendor_user_details->initialize(array('vendor_code'=>($this->input->post('vendor_code') ?: 'KP')));
		$vendor_id = $this->vendor_user_details->vendor_id;

		if ($this->input->post())
		{
			$data_product = array(
				'seque'	=> $this->input->post('seque'),
				'prod_no'	=> $this->input->post('prod_no'),
				'prod_name'	=> $this->input->post('prod_name'),
				'prod_desc'	=> $this->input->post('prod_desc'),
				'prod_date'	=> $this->input->post('prod_date'),
				'public'	=> $this->input->post('public'),
				'publish'	=> $this->input->post('publish'),
				'publish_date'	=> $this->input->post('publish_date'),
				'size_mode'	=> $this->input->post('size_mode'),
				'categories'	=> $categories,
				'less_discount'	=> $this->input->post('less_discount'),
				'catalogue_price'	=> $this->input->post('catalogue_price'),
				'wholesale_price'	=> $this->input->post('wholesale_price'),
				'wholesale_price_clearance'	=> $this->input->post('wholesale_price_clearance'),
				'designer'	=> $des_id,
				'vendor_id'	=> $vendor_id,
				'styles'	=> $this->input->post('styles'),
				'events'	=> $this->input->post('events'),
				'materials'	=> $this->input->post('materials'),
				'trends'	=> $this->input->post('trends'),
				'clearance'	=> $this->input->post('clearance')
			);

			$data_variant = array(
				'color_facets'	=> $this->input->post('color_facets'),
				'color_name'	=> $this->input->post('color_name'),
				'new_color_publish'	=> $this->input->post('new_color_publish'),
				'primary_color'	=> $this->input->post('primary_color'),
				'stock_date'	=> $this->input->post('stock_date')
			);

			if ($this->input->post('size_mode') == '1')
			{
				$data_variant['size_0'] = $this->input->post('size_0');
				$data_variant['size_2'] = $this->input->post('size_2');
				$data_variant['size_4'] = $this->input->post('size_4');
				$data_variant['size_6'] = $this->input->post('size_6');
				$data_variant['size_8'] = $this->input->post('size_8');
				$data_variant['size_10'] = $this->input->post('size_10');
				$data_variant['size_12'] = $this->input->post('size_12');
				$data_variant['size_14'] = $this->input->post('size_14');
				$data_variant['size_16'] = $this->input->post('size_16');
				$data_variant['size_18'] = $this->input->post('size_18');
				$data_variant['size_20'] = $this->input->post('size_20');
				$data_variant['size_22'] = $this->input->post('size_22');
			}
			if ($this->input->post('size_mode') == '0')
			{
				$data_variant['size_ss'] = $this->input->post('size_ss');
				$data_variant['size_sm'] = $this->input->post('size_sm');
				$data_variant['size_sl'] = $this->input->post('size_sl');
				$data_variant['size_sxl'] = $this->input->post('size_sxl');
				$data_variant['size_sxxl'] = $this->input->post('size_sxxl');
				$data_variant['size_sxl1'] = $this->input->post('size_sxl1');
				$data_variant['size_sxl2'] = $this->input->post('size_sxl2');
			}
			if ($this->input->post('size_mode') == '2')
			{
				$data_variant['size_sprepack1221'] = $this->input->post('size_sprepack1221');
			}
			if ($this->input->post('size_mode') == '3')
			{
				$data_variant['size_ssm'] = $this->input->post('size_ssm');
				$data_variant['size_sml'] = $this->input->post('size_sml');
			}
			if ($this->input->post('size_mode') == '4')
			{
				$data_variant['size_sonesizefitsall'] = $this->input->post('size_sonesizefitsall');
			}
		}

		//echo '<pre>';
		//echo $des_id.'<br />'.$categories.'<br />'.$vendor_id;
		//print_r($data_product);
		//print_r($data_variant);

		// ser posts params
		//$post_ary = $this->input->post();

		// update product record
		$this->DB->where('prod_id', $this->input->post('prod_id'));
		$upd1 = $this->DB->update('tbl_product', $data_product);
		if ($upd1) echo 'Successful!\n';
		else echo $this->DB->last_query();

		// update product variant record
		$this->DB->where('st_id', $this->input->post('st_id'));
		$upd2 = $this->DB->update('tbl_stock', $data_variant);
		//if ( ! $upd2) echo $this->db->error();

		exit;
	}

	// ----------------------------------------------------------------------

	/**
	 * Activate Vendor To Odoo via API
	 *
	 * @access 	private
	 * @return	void
	 */
	private function _add_vendor_to_odoo($post_ary)
	{
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		//
		$api_url = 'http://70.32.74.131:8069/api/create/vendors'; // base_url('test/test_ajax_post_to_odoo')
		$api_key = $this->config->item('odoo_api_key');
		if ($api_url != '')
		{
			// set post fields
			$post = array(
				"client_api_key" => $api_key,
				"vendor_id" => $odoo_post_ary['vendor_id'],
				"vendor_name" => $odoo_post_ary['vendor_name'],
				"vendor_email" => $odoo_post_ary['vendor_email'],
				"vendor_code" => $odoo_post_ary['vendor_code'],
				"contact_1" => $odoo_post_ary['contact_1'],
				"contact_email_1" => $odoo_post_ary['contact_email_1'],
				"contact_2" => $odoo_post_ary['contact_2'],
				"contact_email_2" => $odoo_post_ary['contact_email_2'],
				"contact_3" => $odoo_post_ary['contact_3'],
				"contact_email_3" => $odoo_post_ary['contact_email_3'],
				"address1" => $odoo_post_ary['address1'],
				"address2" => $odoo_post_ary['address2'],
				"city" => $odoo_post_ary['city'],
				"state" => $odoo_post_ary['state'],
				"country" => $odoo_post_ary['country'],
				"zipcode" => $odoo_post_ary['zipcode'],
				"telephone" => $odoo_post_ary['telephone'],
				"fax" => $odoo_post_ary['fax'],
				"reference_designer" => $odoo_post_ary['reference_designer'],
				"vendor_type_id" => $odoo_post_ary['vendor_type_id'],
				"vendor_type" => $odoo_post_ary['vendor_type_slug'],
				"is_acitve" => $odoo_post_ary['is_acitve']
			);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $api_url);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			// execute
			$response = curl_exec($ch);
			// for debugging purposes, check for response
			/*
			if($response === false)
			{
				//echo 'Curl error: ' . curl_error($ch);
				// set flash data
				$this->session->set_flashdata('error', 'post_data_error');
				$this->session->set_flashdata('error_value', curl_error($ch));

				redirect($this->config->slash_item('admin_folder').'users/vendor');
			}
			*/

			// close the connection, release resources used
			curl_close ($ch);
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Activate Vendor To Odoo via API
	 *
	 * @access 	private
	 * @return	void
	 */
	private function _update_vendor_to_odoo($odoo_post_ary)
	{
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		//
		$api_url = 'http://70.32.74.131:8069/api/update/vendor/'.$odoo_post_ary['vendor_id'];
		$api_key = $this->config->item('odoo_api_key');
		if ($api_url != '')
		{
			// set post fields
			$post = array(
				"client_api_key" => $api_key,
				"vendor_id" => $odoo_post_ary['vendor_id'],
				"vendor_name" => $odoo_post_ary['vendor_name'],
				"vendor_email" => $odoo_post_ary['vendor_email'],
				"vendor_code" => $odoo_post_ary['vendor_code'],
				"contact_1" => $odoo_post_ary['contact_1'],
				"contact_email_1" => $odoo_post_ary['contact_email_1'],
				"contact_2" => $odoo_post_ary['contact_2'],
				"contact_email_2" => $odoo_post_ary['contact_email_2'],
				"contact_3" => $odoo_post_ary['contact_3'],
				"contact_email_3" => $odoo_post_ary['contact_email_3'],
				"address1" => $odoo_post_ary['address1'],
				"address2" => $odoo_post_ary['address2'],
				"city" => $odoo_post_ary['city'],
				"state" => $odoo_post_ary['state'],
				"country" => $odoo_post_ary['country'],
				"zipcode" => $odoo_post_ary['zipcode'],
				"telephone" => $odoo_post_ary['telephone'],
				"fax" => $odoo_post_ary['fax'],
				"reference_designer" => $odoo_post_ary['reference_designer'],
				"vendor_type_id" => $odoo_post_ary['vendor_type_id'],
				"vendor_type" => $odoo_post_ary['vendor_type_slug'],
				"is_acitve" => $odoo_post_ary['is_acitve']
			);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $api_url);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			// execute
			$response = curl_exec($ch);
			// for debugging purposes, check for response
			/*
			if($response === false)
			{
				//echo 'Curl error: ' . curl_error($ch);
				// set flash data
				$this->session->set_flashdata('error', 'post_data_error');
				$this->session->set_flashdata('error_value', curl_error($ch));

				redirect($this->config->slash_item('admin_folder').'users/vendor/edit/index/'.$id, 'location');
			}
			*/

			// close the connection, release resources used
			curl_close ($ch);
		}
	}

	// ----------------------------------------------------------------------

}
