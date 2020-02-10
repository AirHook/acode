<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_by_scan extends Admin_Controller {

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
	 * Primary method to call when no other methods are found in url segment
	 * This method simply shows order details
	 *
	 * @return	void
	 */
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('products/size_names');
		$this->load->library('products/product_details');

		// check if coming from removing item from list
		if ($this->session->flashdata('item_removed'))
		{
			$this->data['scan_count_items'] =
				$this->session->scan_count_items
				? json_decode($this->session->scan_count_items, TRUE)
				: array();
			;
		}
		else
		{
			// always remove any previous session data for scan count items
			unset($_SESSION['scan_count_items']);
		}

		// set data variables...
		$this->data['file'] = 'inventory_update_by_scan';
		$this->data['page_title'] = 'Inventory Count by Barcode Scan';
		$this->data['page_description'] = '';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply shows order details
	 *
	 * @return	void
	 */
	public function update_inventory()
	{
		// initialize items
		// scan_count_items data structure is as follows
		// $array[0] = array(<prod_no>, <size_lable>, <st_id>)
		/*
		$scan_count_items = array(
			array('D9945L_BLACGOLD1', 'size_2', '1314'),
			array('D9945L_BLACGOLD1', 'size_2', '1314'),
			array('D9945L_BLACGOLD1', 'size_4', '1314')
		);
		*/

		$scan_count_items =
			$this->session->scan_count_items
			? json_decode($this->session->scan_count_items, TRUE)
			: array();
		;

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// iterate through the items
		// and set a new array based on st_id, then size label, and count
		$items_array = array();
		foreach ($scan_count_items as $index => $item_size_label)
		{
			// breakdown $item_size_label
			$item = $item_size_label[0];
			$size_label = $item_size_label[1];
			$st_id = $item_size_label[2];

			if (isset($items_array[$st_id][$size_label]))
			{
				$items_array[$st_id][$size_label]+= 1;
			}
			else $items_array[$st_id][$size_label] = 1;
		}

		foreach ($items_array as $st_id => $data)
		{
			/*
			$data = Array
			(
			    [size_4] => 4
			    [size_2] => 2
			)
			*/

			// update physical stocks for all sizes
			$DB->set($data);
			$DB->where('st_id', $st_id);
			$DB->update('tbl_stock_physical');

			// get onorder qty info
			$size_keys = array_keys($data);
			$sizes = implode(', ', $size_keys);
			$DB->select($sizes);
			$DB->where("st_id = '".$st_id."'");
			$q2 = $DB->get('tbl_stock_onorder');
			$row = $q2->row_array();

			if (isset($row))
			{
				foreach ($size_keys as $size)
				{
					$new_available_stock = $data[$size] - $row[$size];
					$data_available[$size] = $new_available_stock < 0 ? 0 : $new_available_stock;
				}
			}
			else $data_available = $data;

			// update available stocks
			$DB->set($data_available);
			$DB->where('st_id', $st_id);
			$DB->update('tbl_stock');
		}

		// set flash data
		$this->session->set_flashdata('success', 'inventory_updated');

		// redirect user
		redirect('admin/inventory/update_by_scan', 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Create Plugin Scripts and CSS for the page
	 *
	 * @return	void
	 */
	private function _create_plugin_scripts()
	{
		$assets_url = base_url('assets/metronic');

		/****************
		 * page styles plugins inserted at <head>
		 * after global mandatory styles, before theme global styles
		 */
		$this->data['page_level_styles_plugins'] = '';

			// ladda - show loading or progress bar on buttons
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap table css
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '
		';

		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';

			// ladda - show loading or progress bar on buttons
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
			';
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// bootstrap table plugin
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-table/bootstrap-table.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
		 */
		$this->data['page_level_scripts'] = '';

			// button spinners for ladda
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/ui-buttons-spinners.min.js" type="text/javascript"></script>
			';
			// handle bootstrap select - make select class '.bs-select' a boostrap select picker
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// handle page scripts
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/admin-inventory_update_by_scan-components.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
