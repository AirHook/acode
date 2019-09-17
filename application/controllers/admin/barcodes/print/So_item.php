<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class So_item extends Admin_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - Primary class function
	 *
	 * @return	void
	 */
    //public function index($st_id = NULL, $size_label = NULL)
	public function index($st_id = '', $size_label = '')
    {
    	if (
			$st_id != NULL
			OR $size_label != NULL
		)
    	{
			// load pertinent library/model/helpers
			$this->load->library('barcodes/upc_barcodes');
			$this->load->library('products/product_details');
			$this->load->library('products/size_names');

			// initialize purchase order properties and items
			$product = $this->product_details->initialize(
				array(
					'tbl_stock.st_id' => $st_id
				)
			);

			// set params where necessary
			$prod_no = $product->prod_no;
			$color_code = $product->color_code;
			$color_name = $product->color_name ?: $this->product_details->get_color_name($color_code);
			$size_mode = $product->size_mode ?: @$this->designer_details->webspace_options['size_mode'];

			// get size names
			$size_names = $this->size_names->get_size_names($size_mode);

			$upcfg['prod_no'] = $prod_no;
			$upcfg['st_id'] = $st_id;
			$upcfg['size_label'] = $size_label;
			$this->upc_barcodes->initialize($upcfg);

			// generate array to pass to view file
			//array_push($barcodes, $this->upc_barcodes->generate());
			$barcodes[$this->upc_barcodes->generate()] = array(
				'prod_no' => $prod_no,
				'color_name' => $color_name,
				'size' => $size_names[$size_label]
			);

			$this->data['barcodes'] = $barcodes;

			$this->load->view($this->config->slash_item('admin_folder').'metronic/barcodes/print_barcodes', $this->data);
    	}
    }

 	// --------------------------------------------------------------------

}
