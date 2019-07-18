<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Preset extends Sales_Controller {

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
	 * Index - Sales Package View
	 *
	 * Open and view existing sales package for edit/sending
	 *
	 * @return	void
	 */
	public function index($preset = '')
	{
		if ( ! $preset)
		{
			// nothing more to do...
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('sales/sales_package', 'location');
		}

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// load pertinent library/model/helpers
		$this->load->library('sales_package/sales_package_details');

		// if sales package preset is present on sales user options, use it

		// primary item that is changed for the preset salespackages
    	$params['facets'] = array('availability'=>$preset) ?: array();

		// get the products list
		$params['show_private'] = TRUE; // all items general public (Y) - N for private
		$params['view_status'] = 'ALL'; // ALL items view status (Y, Y1, Y2, N)
		$params['variant_publish'] = 'ALL'; // ALL variant level color publish (view status)
		$params['group_products'] = FALSE; // group per product number or per variant
		// show items even without stocks at all
		$params['with_stocks'] = FALSE;
		// others
		$this->load->library('products/products_list', $params);
		$products = $this->products_list->select(
			array(
				'designer.url_structure' => $this->sales_user_details->designer
			),
			array( // order conditions
				'seque' => 'asc',
				'tbl_product.prod_no' => 'desc'
			),
			6
		);

		// if not product results...
		if ($this->products_list->row_count == 0)
		{
			// nothing more to do...
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('sales/create/step2', 'location');
		}

		// capture product numbers and set items array
		$cnt = 0;
		$items_array = array();
		foreach ($products as $product)
		{
			array_push($items_array, $product->prod_no.'_'.$product->color_code);
		}

		// some other items...
		switch ($preset)
		{
			case 'preorder':
				$sales_package_name = 'Pre Order Sales Offer';
				$email_subject = 'Pre Order Sales Offer';
				$email_message = 'Here are designs that are not available on stock. Pre order as early as you can.';
			break;

			case 'instock':
				$sales_package_name = 'In Stock Sales Offer';
				$email_subject = 'In Stock Sales Offer';
				$email_message = 'Here are designs that are available and resdy for devliery. Order now while stocks lasts.';
			break;

			case 'onsale':
				$sales_package_name = 'Off Price Sales Offer';
				$email_subject = 'Off Price Sales Offer';
				$email_message = 'Here are designs that are available at a very discounted price. Choose what is best for your stores.';
			break;
		}

		// capture existing items and option and set flags to indicate
		// coming from existing sales package
		$this->session->set_userdata('sa_preset', $preset);
		$this->session->set_userdata('sa_items', json_encode($items_array));
		$this->session->set_userdata('sa_name', $sales_package_name);
		$this->session->set_userdata('sa_email_subject', $email_subject);
		$this->session->set_userdata('sa_email_message', $email_message);

		// redirect user
		redirect('sales/create/step2', 'location');
	}

	// ----------------------------------------------------------------------

}
