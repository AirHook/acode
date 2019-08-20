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
	public function index($st_id = '31', $size_label = 'size_2')
    {
    	if (
			$st_id != NULL
			&& $size_label != NULL
		)
    	{
			// load pertinent library/model/helpers
			$this->load->library('barcodes/upc_barcodes');

			$upcfg['st_id'] = $st_id;
			$upcfg['size_label'] = $size_label;
			$this->upc_barcodes->initialize($upcfg);
			$this->data['barcode'] = $this->upc_barcodes->generate();

			$this->load->view($this->config->slash_item('admin_folder').'metronic/barcodes/print_barcode', $this->data);
    	}
    }

 	// --------------------------------------------------------------------

}
