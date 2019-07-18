<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crunch_go extends CI_Controller {

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
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function index()
	{
		echo 'Crunching...<br />';
		
		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('image_lib');
		
		// we need to get the params
		$this->DB->where('id', '1');
		$q1 = $this->DB->get('tbl_update_images');
		$r1 = $q1->row();
		
		// get the products
		$this->DB->select('prod_no');
		$this->DB->where('cat_id', '1');
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
				
				echo $r2->prod_no.'<br />';
				
				// set some params
				$d_folder = $this->product_details->d_folder;
				$category_slug = $this->product_details->sc_url_structure;
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
								echo 'Unable to create "'.$image_url.'" folder.<br />';
							umask($old);
						}
						// thumbs directory
						if ( ! file_exists($image_url.'thumbs'))
						{
							$old = umask(0);
							if ( ! mkdir($image_url.'thumbs', 0777, TRUE)) 
								echo 'Unable to create "'.$image_url.'thumbs/" folder.<br />';
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
							$config['image_library']	= 'gd2';
							$config['quality']			= '100%';
							$config['source_image'] 	= $targetFile;
							$config['new_image'] 		= $image_url.'thumbs/'.$img_name.'_'.$key.'.jpg';
							$config['maintain_ratio'] 	= TRUE;
							$config['width']         	= $val[0];
							$config['height']       	= $val[1];
							$this->image_lib->initialize($config);
							if ( ! $this->image_lib->resize())
							{
								echo $this->image_lib->display_errors();
								echo $image_url.'thumbs/'.$img_name.'_'.$key.'.jpg<br /><br />';
							}
							$this->image_lib->clear();
						}
						
						// prep for linesheet creation
						$img_path = str_replace('product_'.$view.'/', '', $image_url);
						
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
						{
							echo $this->image_lib->display_errors();
							echo $des_logo.'<br />';
						}
						$this->image_lib->clear();
						
						// create linesheet
						$this->load->helper('create_linesheet');
						if ($img_info = @GetImageSize($img_path.'product_front/'.$img_name.'.jpg'))
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
						else echo 'Unabel to get image information.<br />';
					}
				}
			}
		}
		else echo 'No records found<br />';
		
		echo 'Done<br />';
	}
	
	// ----------------------------------------------------------------------
	
}
