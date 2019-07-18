<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crunch_images extends Admin_Controller {

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
	 * Index - Primary class function
	 *
	 * @return	void
	 */
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();
		
		// load pertinent library/model/helpers
		$this->load->library('categories/categories');
		$this->load->library('categories/category_details');
		$this->load->library('designers/designers_list');
		$this->load->library('designers/designer_details');
		
		// initialize some properties
		$this->designers_list->initialize(array('with_products'=>TRUE));
		
		// get some data
		$this->data['designers'] = $this->designers_list->select();
		$this->data['categories'] = $this->categories->treelist(array('with_products'=>TRUE));
		
		// let's do some defaults...
		$this->data['active_designer'] = 
			$this->session->userdata('active_designer') ?: 
			(
				(
					$this->config->item('site_slug') == 'basixblacklabel' 
					OR $this->webspace_details->slug == 'basixblacklabel'
				)
				? 'basix-black-label' // backwards compatibility for basix
				: (
					@$this->webspace_details->options['site_type'] === 'hub_site'
					? (
						@$this->webspace_details->options['primary_designer'] ?:
						$this->designers_list->first_row->url_structure
					)
					: ($this->webspace_details->slug ?: $this->config->item('site_slug')) // should default to the webspace slug for sat_sites
				)
			);
		$this->categories->select(array('d_url_structure LIKE'=>'%'.$this->data['active_designer'].'%'));
		$this->data['active_category'] = 
			$this->session->userdata('active_category') 
			?: $this->categories->first_row->category_slug; // first category on list
		
		// set active details
		$this->data['active_designer_details'] = $this->designer_details->initialize(array('url_structure'=>$this->data['active_designer']));
		$this->data['active_category_details'] = $this->category_details->initialize(array('category_slug'=>$this->data['active_category']));
		
		// set page variables...
		$this->data['file'] = 'crunch_images';
		$this->data['page_title'] = 'Crunch or Re-Crunch Product Images';
		$this->data['page_description'] = 'Crunch product images by designer and category basis';
		
		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Crunch function
	 *
	 * @return	void
	 */
	public function crunch()
	{
		// load pertinent library/model/helpers
		$this->load->library('categories/category_details');
		$this->load->library('designers/designer_details');
		
		// let's process input fields
		$designer = $this->designer_details->initialize(array('designer.url_structure'=>$this->input->post('designer')));
		$category = $this->category_details->initialize(array('categories.category_slug'=>$this->input->post('category')));
		
		// insert record
		//$post_ary = $this->input->post();
		// set necessary variables
		$post_ary['des_id'] = $designer->des_id;
		$post_ary['cat_id'] = '1';
		$post_ary['subcat_id'] = $category->category_id;
		// unset unneeded variables
		//unset($post_ary['passconf']);
		
		$this->DB->set('des_id', $designer->des_id);
		$this->DB->set('cat_id', '1');
		$this->DB->set('subcat_id', $category->category_id);
		$this->DB->where('id', '1');
		$this->DB->update('tbl_update_images');
		
		// create a new cURL resource
		$ch = curl_init();

		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, site_url('admin/products/crunch_go'));
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// grab URL and pass it to the browser
		curl_exec($ch);

		// close cURL resource, and free up system resources
		curl_close($ch);
		
		// set flashdata
		$_SESSION['success'] = 'crunching';
		$this->session->mark_as_flash('success');
		
		// redirect
		redirect($this->config->slash_item('admin_folder').'products/crunch_images', 'location');
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Crunch Go function
	 *
	 * @return	void
	 */
	public function crunch_go()
	{
		echo 'Crunching...<br />';
		
		$this->DB->set('cat_id', '400');
		$this->DB->where('id', '1');
		$this->DB->update('tbl_update_images');
		
		/*
		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('image_lib');
		
		$this->DB->where('id', '1');
		$q1 = $this->DB->get('tbl_update_images');
		$r1 = $q1->row();
		
		$this->DB->select('prod_no');
		$this->DB->where('cat_id', $r1->cat_id);
		$this->DB->where('subcat_id', $r1->subcat_id);
		$this->DB->where('designer', $r1->des_id);
		$q2 = $this->DB->get('tbl_product');
		
		//echo $this->DB->last_query(); die();
		
		if ($q2->num_rows() > 0)
		{
			foreach ($q2->result() as $r2)
			{
				// initialize product details
				$this->product_details->initialize(array('tbl_product.prod_no'=>$r2->prod_no));
				
				// set some params
				$d_folder = $this->product_details->d_folder;
				$category_slug = $this->product_details->sc_folder;
				$prod_no = $this->product_details->prod_no;
				
				// for each available color
				foreach ($this->product_details->available_colors() as $color)
				{
					$views = array('front', 'side', 'back');
					
					foreach ($views as $view)
					{
						// set the image path and filename
						$image_url = 'product_assets/WMANSAPREL/'.$d_folder.'/'.$category_slug.'/product_'.$view.'/';
						$img_name = $prod_no.'_'.$color->color_code;
						$targetFile = $image_url.$img_name.'.jpg';
					
						// given the $image_url, we now add directories where necessary
						// main product image directory
						if ( ! file_exists($image_url))
						{
							$old = umask(0);
							if ( ! mkdir($image_url, 0777, TRUE)) 
								die('Unable to create "'.$image_url.'" folder.');
							umask($old);
						}
						// thumbs directory
						if ( ! file_exists($image_url.'thumbs'))
						{
							$old = umask(0);
							if ( ! mkdir($image_url.'thumbs', 0777, TRUE)) 
								die('Unable to create "'.$image_url.'thumbs/" folder.');
							umask($old);
						}
						
						// set thumbs sizes
						$size = array(
							'1' => array(140, 210),
							'2' => array(60, 90),
							'3' => array(340, 510),
							'4' => array(800, 1200)
						);
						
						// crunch the image
						foreach ($size as $key => $val)
						{
							echo $targetFile.'<br />';
							echo $image_url.'thumbs/'.$img_name.'_'.$key.'.jpg<br />';
							
							$config['image_library']	= 'gd2';
							$config['quality']			= '100%';
							$config['source_image'] 	= $targetFile;
							$config['new_image'] 		= $image_url.'thumbs/'.$img_name.'_'.$key.'.jpg';
							$config['maintain_ratio'] 	= TRUE;
							$config['width']         	= $val[0];
							$config['height']       	= $val[1];
							$this->image_lib->initialize($config);
							if ( ! $this->image_lib->resize())
							echo $this->image_lib->display_errors();
							$this->image_lib->clear();
						}
						
						// prep for linesheet creation
						$img_path = str_replace('product_'.$view, '', $image_url);
						
						// get designer logo image
						// and resize it where necessary
						$this->DB->where('des_id', $r1->des_id);
						$query = $this->DB->get('designer')->row();
						if (isset($query))
						{
							if ($query->logo !== '') $des_logo = $query->logo;
							else 
							{
								// assuming roden theme assets
								$des_logo = 'assets/roden_assets/images/'.$query->logo_image;
							}
						}
						$config['image_library']	= 'gd2';
						$config['quality']			= '100%';
						$config['source_image'] 	= $des_logo;
						$config['new_image'] 		= $des_logo;
						$config['maintain_ratio'] 	= TRUE;
						$config['width']         	= 292;
						$config['height']       	= 47;
						$this->image_lib->initialize($config);
						if ( ! $this->image_lib->resize())
						echo $this->image_lib->display_errors();
						$this->image_lib->clear();
						
						// create linesheet
						$this->load->helper('create_linesheet');
						if ($img_info = GetImageSize($img_path.'product_front/'.$img_name.'.jpg'))
						{
							$create = create_linesheet(
								$img_info,
								$prod_no,
								$img_path,
								$img_name,
								$des_logo,
								$this->product_details->wholesale_price,
								$color->color_name
							);
						}
					}
				}
			}
		}
		else echo 'No records found<br />';
		
		echo 'Done<br />';
		exit;
		*/
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
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
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
			// form validation
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-validation-crunch_images.js" type="text/javascript"></script>
			';
	}
	
	// ----------------------------------------------------------------------
	
}
