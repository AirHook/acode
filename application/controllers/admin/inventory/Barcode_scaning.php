<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode_scaning extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('products/products_list');
    }

	// ----------------------------------------------------------------------

	public function index()
	{
		$this->data['file'] = 'barcodes/scan_barcode';
		$this->data['page_title'] = 'Barcode Scaning';
		$this->data['page_description'] = 'Scan Barcode';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template5/template', $this->data);
	}
	public function manage_stocks()
	{
		$formData=$this->input->post();
		$code='';
		$st_id='';
		$size='';
		if(isset($formData['code']))
		{
			$code=array_reverse(explode('-', $formData['code']));
			$st_id=$code[0];
			$size=$code[1];
		}
		if(isset($formData['submit']) && $formData['submit'] == 'inventory_in')
		{
			$this->inventory_in($st_id,1,$size);
		}
		else if(isset($formData['submit']) && $formData['submit'] == 'inventory_out')
		{
			$this->inventory_out($st_id,1,$size);
		}
		echo '<pre>',print_r($formData),'</pre>';exit();
	}
	public function inventory_in($st_id=null,$qty=0,$size=null)
	{
		if($st_id!=null)
		{
			$update=$this->products_list->inventory_in($st_id,$qty,$size);
			if($update)
			{
				$this->session->set_userdata('success','Inventory In  successfully');
			}
			else
			{
				$this->session->set_userdata('errors','Error occurred try later!');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function inventory_out($st_id=null,$qty=0,$size=null)
	{
		if($st_id!=null)
		{
			$update=$this->products_list->inventory_out($st_id,$qty,$size);
			if($update)
			{
				$this->session->set_userdata('success','Inventory Out successfully');
			}
			else
			{
				$this->session->set_userdata('errors','Error occurred try later!');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Creaet Plugin Scripts and CSS for the page
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
			// tabledit
			$this->data['page_level_plugins'].= '
				<script src="'.base_url().'/assets/custom/jscript/tabledit/jquery-tabledit-1.2.3/jquery.tabledit.min.js" type="text/javascript"></script>
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
			// handle datatable
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/tabledit-inventory-'.$this->data['size_mode'].'.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
