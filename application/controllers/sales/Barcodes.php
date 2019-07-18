<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barcodes extends Sales_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->driver('session');

		$this->output->enable_profiler(FALSE);
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - Primary class function
	 *
	 * @return	void
	 */
    public function index($st_id=null)
    {
    	if($st_id!=null)
    	{
    		$this->_create_plugin_scripts();
			// load pertinent library/model/helpers
			$this->load->helper('metronic/create_category_treelist');
			$this->load->library('products/product_details');
			$this->load->library('products/products_list');
			$this->load->library('designers/designers_list');
			$this->load->library('categories/categories_tree');
			$this->load->library('users/vendor_users_list');
			$this->load->library('color_list');
			$this->load->library('form_validation');
			$this->load->library('facet_list');
			$this->data['product_detail']=$this->products_list->select(array('tbl_stock.st_id'=>$st_id));
    		$this->data['file'] = 'barcodes/barcode_variant';
			$this->data['page_title'] = 'Barcode';
			$this->data['page_description'] = 'Print Barcode';

			$this->load->view($this->config->slash_item('admin_folder').'metronic/'.'template/template', $this->data);
    	}
    }

	// ----------------------------------------------------------------------

    public function generatebarcode()
    {
    	$formData=$this->input->post();
    	$this->load->library('products/products_list');
    	$this->data['product_detail']=$this->products_list->select(array('tbl_stock.st_id'=>$formData['st_id']));
    	$field='size_'.$formData['size'];
    	if(isset($this->data['product_detail'][0]->{$field}) && $this->data['product_detail'][0]->{$field} > 0)
    	{

			$code=$formData['prod_no'].' '.$formData['color'].' '.'size'.$formData['size'];
			$this->data['barcode_code']=$code;
			$this->load->library('zend');
			$this->zend->load('Zend/Barcode');
			$barcodeOptions = array('text' => $code);
			$file = Zend_Barcode::draw('code128', 'image', $barcodeOptions , array());
			$store_image = imagepng($file,"assets/barcodes/{$code}.png");
			$this->data['barcode_img']=$code.'.png';
			$this->data['sizecode']='size'.$formData['size'];
    	}
    	else
    	{
    		$this->session->set_userdata('errors','The select size has 0 stock value');
			$this->session->set_flashdata('error', 'barcode_generation_error');
    	}
		$this->data['size']=$formData['size'];
		$this->data['file'] = 'barcodes/barcode_variant';
		$this->data['page_title'] = 'Barcode';
		$this->data['page_description'] = 'Print Barcode';
    	$this->load->view($this->config->slash_item('admin_folder').'metronic/'.'template/template', $this->data);
    }

	// ----------------------------------------------------------------------

    public function barcodes($prod_no=null,$color=null,$size=null)
	{
		if($prod_no!=null)
		{
			// $this->load->library('barcode');
			// $data['barcode_code']=$this->barcode->generate_barcode($code);
			$code=$prod_no.' '.$color.' '.$size;
			$this->data['barcode_code']=$code;
			$this->load->library('zend');
			$this->zend->load('Zend/Barcode');
			$barcodeOptions = array('text' => $code);
			$file = Zend_Barcode::draw('code128', 'image', $barcodeOptions , array());
			$store_image = imagepng($file,"assets/barcodes/{$code}.png");
			$this->data['barcode_img']=$code.'.png';
			$this->load->view($this->config->slash_item('admin_folder').'metronic/barcodes/print_barcode',$this->data);
		}
	}

	// ----------------------------------------------------------------------

	public function barcodesprint($code=null)
	{
		if($code!=null)
		{
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	// ----------------------------------------------------------------------

	public function printbarcode($code=null)
	{
		if($code!=null)
		{
			$this->load->library('barcode');
			$data['barcode_code']=$this->barcode->generate_barcode($code);
			$data['code']=$code;
			$this->load->view('admin/products/print_label',$data);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Print Barcode - print an item's barcode label (single)
	 *
	 * Supposedly an alias of barcodes() which send the barcode to a separate
	 * window with an auto print popup but uses st_id only as params
	 *
	 * @params	string
	 * @return	void
	 */
	public function print_barcode($st_id = '')
	{
		if ($st_id == '')
		{
			// nothing more to do...
			return FALSE;
		}

		// get query data
		$size_label = $this->input->get('size_label');

		// load Zend library
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');

		// get some data
		$size_names = $this->size_names->get_size_names();

		// initialize certain properties
		if (!$this->product_details->initialize(array('tbl_stock.st_id'=>$st_id)))
		{
			// nothing more to do...
			return FALSE;
		}

		$code_text = $this->product_details->prod_no.'-'.$size_label.'-'.$st_id;
		$imageResource = Zend_Barcode::draw(
			'code128',
			'image',
			//$barcodeOptions,
			// array('text' => $code_text,'drawText' => false ,'barThickWidth'=>3,'barThinWidth'=>1,'barHeight' => 30),
			array('text' => $code_text,'drawText' => false,'barHeight'=>25),
			//$rendererOptions
			array()
		);

		$store_image = imagepng($imageResource, "assets/barcodes/product_barcode_temp.png");
		// set data
		$this->data['barcode_code'] = $code_text;
		$this->data['barcode_img'] = 'product_barcode_temp.png';
		$this->data['color_name'] = $this->product_details->color_name;
		// echo '<pre>',print_r($size_names),'</pre>';exit();
		$this->data['size'] = $size_names[$size_label];
		$this->data['prod_no'] = $this->product_details->prod_no;
		$this->data['st_id'] = $st_id;

		// load view files
		$this->load->view($this->config->slash_item('admin_folder').'metronic/barcodes/print_barcode', $this->data);
	}

	// --------------------------------------------------------------------

	/**
	 * Print All - print an item's barcode label (multiples of size multiply by qty)
	 *
	 * Supposedly an alias of barcodes() which send the barcode to a separate
	 * window with an auto print popup but uses st_id only as params
	 *
	 * @params	string
	 * @return	void
	 */
	public function print_all($st_id = '', $qty='', $size_label='')
	{
		if ($st_id == '')
		{
			// nothing more to do...
			return FALSE;
		}

		// load Zend library
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');

		// get some data
		$size_names = $this->size_names->get_size_names();

		// initialize certain properties
		if ( ! $this->product_details->initialize(array('tbl_stock.st_id'=>$st_id)))
		{
			// nothing more to do...
			return FALSE;
		}

		$code_text = $this->product_details->prod_no.'-'.$size_label.'-'.$st_id;
		$imageResource = Zend_Barcode::draw(
			'code128',
			'image',
			//$barcodeOptions,
			// array('text' => $code_text,'drawText' => false ,'barThickWidth'=>3,'barThinWidth'=>1,'barHeight' => 30),
			array('text' => $code_text,'drawText' => false,'barHeight'=>25),
			//$rendererOptions
			array()
		);

		$store_image = imagepng($imageResource, "assets/barcodes/product_barcode_temp.png");
		// set data
		$this->data['barcode_code'] = $code_text;
		$this->data['barcode_img'] = 'product_barcode_temp.png';
		$this->data['color_name'] = $this->product_details->color_name;
		$this->data['prod_no'] = $this->product_details->prod_no;
		$this->data['st_id'] = $st_id;
		$this->data['size'] = $size_names[$size_label];
		$this->data['qty'] = $qty;

		// load view files
		$this->load->view($this->config->slash_item('admin_folder').'metronic/barcodes/print_all', $this->data);
	}

	// --------------------------------------------------------------------

	/**
	 * Print All Barcodes - print a item's barcode labels of all sizes for an item
	 *
	 * Supposedly an alias of barcodes() which send the barcode to a separate
	 * window with an auto print popup but uses st_id only as params
	 *
	 * @params	string
	 * @return	void
	 */
	public function print_all_barcodes($st_id='')
	{
		if ($st_id == '')
		{
			// nothing more to do...
			return FALSE;
		}

		// load Zend library
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');

		// get some data
		$size_names = $this->size_names->get_size_names();

		// initialize certain properties
		if ( ! $this->product_details->initialize(array('tbl_stock.st_id'=>$st_id)))
		{
			// nothing more to do...
			return FALSE;
		}

		// there are more than one size so we put barcode and data in an array
		$array=[];
		$i=0;
        foreach($_GET as $size_label => $qty)
        {
            $sizeLabel='';
            if ($size_label != 'color_name' && $size_label != 'vendor_price' && $size_label != 'prod_no' && $size_label != 'color_code' && $size_label != 'wholesale_price')
            {
                $code_text = $_GET['prod_no'].'-'.$size_label.'-'.$st_id;
                $imageResource = Zend_Barcode::draw(
                    'code128',
                    'image',
                    //$barcodeOptions,
					// array('text' => $code_text,'drawText' => false ,'barThickWidth'=>3,'barThinWidth'=>1,'barHeight' => 30),
                    array('text' => $code_text,'drawText' => false,'barHeight'=>25),
                    //$rendererOptions
                    array()
                );

				//$barcode_image_name = $_GET['prod_no'].'_'.$size_label.'_'.$st_id;
                //$store_image = imagepng($imageResource, "assets/barcodes/".$barcode_image_name.".png");
				$store_image = imagepng($imageResource, "assets/barcodes/product_barcode_temp_".$i.".png");

				$array[$i]['st_id'] = $st_id;
                $array[$i]['prod_no'] = $_GET['prod_no'];
                $array[$i]['color_name'] = $_GET['color_name'];
                $array[$i]['size'] = $size_names[$size_label];
                $array[$i]['qty'] = $qty;

        		$i++;
            }
        }
        // die();

		// set data
		// echo '<pre>',print_r($array),'</pre>';exit();
		// $this->data['barcode_code'] = $code_text;
		$this->data['qty']=$qty;
		$this->data['data']=$array;
		// load view files
		$this->load->view($this->config->slash_item('admin_folder').'metronic/barcodes/print_all_barcode', $this->data);
	}

	// --------------------------------------------------------------------

	/**
	 * Print PO Barcodes - print a PO's barcode labels of the entire set of items
	 *
	 * Supposedly an alias of barcodes() which send the barcode to a separate
	 * window with an auto print popup but uses st_id only as params
	 *
	 * @params	string
	 * @return	void
	 */
	public function print_po_barcodes($po_id='')
	{
		if ($po_id == '')
		{
			// nothing more to do...
			return FALSE;
		}

		// load Zend library
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
		$this->load->library('purchase_orders/purchase_order_details');
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');

		// get some data
		$size_names = $this->size_names->get_size_names();

		// initialize po details
		if ( ! $this->purchase_order_details->initialize(array('po_id'=>$po_id)))
		{
			// nothing more to do...
			return FALSE;
		}

		// get the po items and count
		$po_items = $this->purchase_order_details->items;

		$i=0;
		foreach ($po_items as $item => $size_qty)
		{
			// initialize certain properties
			$exp = explode('_', $item);
			$product = $this->product_details->initialize(
				array(
					'tbl_product.prod_no' => $exp[0],
					'color_code' => $exp[1]
				)
			);

			// there are more than one item and size so we put barcode and data in an array
			$array[$item]=[];
	        foreach($size_qty as $size_label => $qty)
	        {
	            $sizeLabel='';
	            if ($size_label != 'color_name' && $size_label != 'vendor_price' && $size_label != 'prod_no' && $size_label != 'color_code' && $size_label != 'wholesale_price')
	            {
	                $code_text = $product->prod_no.'-'.$size_label.'-'.$product->st_id;
	                $imageResource = Zend_Barcode::draw(
	                    'code128',
	                    'image',
	                    //$barcodeOptions,
						// array('text' => $code_text,'drawText' => false ,'barThickWidth'=>3,'barThinWidth'=>1,'barHeight' => 30),
	                    array('text' => $code_text,'drawText' => false,'barHeight'=>25),
	                    //$rendererOptions
	                    array()
	                );

					//$barcode_image_name = $_GET['prod_no'].'_'.$size_label.'_'.$st_id;
	                //$store_image = imagepng($imageResource, "assets/barcodes/".$barcode_image_name.".png");
					$store_image = imagepng($imageResource, "assets/barcodes/product_barcode_temp_".$i.".png");

					$array[$item][$i]['st_id'] = $product->st_id;
	                $array[$item][$i]['prod_no'] = $product->prod_no;
	                $array[$item][$i]['color_name'] = $product->color_name;
	                $array[$item][$i]['size'] = $size_names[$size_label];
	                $array[$item][$i]['qty'] = $qty;

	        		$i++;
	            }
	        }
		}

		// set data
		// echo '<pre>',print_r($array),'</pre>';exit();
		// $this->data['barcode_code'] = $code_text;
		$this->data['qty']=$qty;
		$this->data['data']=$array;
		// load view files
		$this->load->view($this->config->slash_item('admin_folder').'metronic/barcodes/print_po_barcodes', $this->data);
	}

	// --------------------------------------------------------------------

	/**
	 * Print PO Barcodes - print a PO's barcode labels of the entire set of items
	 *
	 * Supposedly an alias of barcodes() which send the barcode to a separate
	 * window with an auto print popup but uses st_id only as params
	 *
	 * @params	string
	 * @return	void
	 */
	public function print_so_barcodes($so_id='')
	{
		if ($so_id == '')
		{
			// nothing more to do...
			return FALSE;
		}

		// load Zend library
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
		$this->load->library('sales_orders/sales_order_details');
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');

		// get some data
		$size_names = $this->size_names->get_size_names();

		// initialize po details
		if ( ! $this->sales_order_details->initialize(array('sales_order_id'=>$so_id)))
		{
			// nothing more to do...
			return FALSE;
		}

		// get the po items and count
		$items = $this->sales_order_details->items;

		$i=0;
		foreach ($items as $item => $size_qty)
		{
			// initialize certain properties
			$exp = explode('_', $item);
			$product = $this->product_details->initialize(
				array(
					'tbl_product.prod_no' => $exp[0],
					'color_code' => $exp[1]
				)
			);

			// there are more than one size so we put barcode and data in an array
			$array[$item]=[];
	        foreach($size_qty as $size_label => $qty)
	        {
	            $sizeLabel='';
	            if ($size_label != 'color_name' && $size_label != 'vendor_price' && $size_label != 'prod_no' && $size_label != 'color_code' && $size_label != 'wholesale_price')
	            {
	                $code_text = $product->prod_no.'-'.$size_label.'-'.$product->st_id;
	                $imageResource = Zend_Barcode::draw(
	                    'code128',
	                    'image',
	                    //$barcodeOptions,
						// array('text' => $code_text,'drawText' => false ,'barThickWidth'=>3,'barThinWidth'=>1,'barHeight' => 30),
	                    array('text' => $code_text,'drawText' => false,'barHeight'=>25),
	                    //$rendererOptions
	                    array()
	                );

					//$barcode_image_name = $_GET['prod_no'].'_'.$size_label.'_'.$st_id;
	                //$store_image = imagepng($imageResource, "assets/barcodes/".$barcode_image_name.".png");
					$store_image = imagepng($imageResource, "assets/barcodes/product_barcode_temp_".$i.".png");

					$array[$item][$i]['st_id'] = $product->st_id;
	                $array[$item][$i]['prod_no'] = $product->prod_no;
	                $array[$item][$i]['color_name'] = $product->color_name;
	                $array[$item][$i]['size'] = $size_names[$size_label];
	                $array[$item][$i]['qty'] = $qty;

	        		$i++;
	            }
	        }
		}

		// set data
		// echo '<pre>',print_r($array),'</pre>';exit();
		// $this->data['barcode_code'] = $code_text;
		$this->data['qty']=$qty;
		$this->data['data']=$array;
		// load view files
		$this->load->view($this->config->slash_item('admin_folder').'metronic/barcodes/print_po_barcodes', $this->data);
	}

 	// --------------------------------------------------------------------

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
			// datepicker & date-time-pickers
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
			';
			// fancybox
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
			';
			// dropzone
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '';

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
			// pulsate
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
			';
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// datepicker & date-time-pickers
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
			';
			// fancybox
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
			';
			// dropzone
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
			';
			// form validation
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
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
			// dropzone
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-dropzone-products_edit.js" type="text/javascript"></script>
			';
			// datepicker & other compnents
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-products_edit.js" type="text/javascript"></script>
			';
	}
}
