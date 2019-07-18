<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Syncing of shop7 product list to odoo
 * 
 */

class Sync_odoo extends Admin_Controller {

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
	 * Index - default method
	 *
	 * @return	void
	 */
	public function index()
	{
		// (Dont ask me but I'm just following those the I see in the internet and it seems to work just fine ">> /dev/null 2>&1"
		$exec = exec('php ./utilities/sync_odoo_products.php >> /dev/null 2>&1 &');
		
		exit();
		
		// load pertinent library/model/helpers
		$this->load->model('media_library');
		$this->load->library('products/product_details');
		$this->load->library('products/products_list');
		$this->load->library('designers/designer_details');
		$this->load->library('categories/category_details');
		$this->load->library('odoo');
		
		// get the product list first
		
		// upload the image
		if ( ! empty($_FILES))
		{
			/**
			 * Test input post
			 *
			header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
			echo '<pre>';
			print_r($this->input->post());
			die();
			// */
			
			// load pertinent library/model/helpers
			$this->load->model('media_library');
			$this->load->library('uploads/prod_image_upload');
			$this->load->library('products/product_details');
			$this->load->library('designers/designer_details');
			$this->load->library('designers/designer_details');
			$this->load->library('categories/category_details');
			$this->load->library('odoo');
			//$this->load->library('designers/designers_list');
			//$this->load->library('categories/categories_tree');
			
			// get some data
			//$designers = $this->designers_list->select();
			//$categories = $this->categories_tree->treelist(array('with_products'=>TRUE));
			
			$config['tempFile'] = $_FILES['file']['tmp_name']; // this also stores file object into a temporary variable
			$config['filename'] = $_FILES['file']['name'];
			$config['view']		= $this->input->post('product_view');
			$config['des_id'] 	= $this->input->post('des_id'); // used to identify the logo for the linesheet
			
			// Check if image file is a actual image or fake image
			$check = getimagesize($_FILES["file"]["tmp_name"]);
			if($check === false) 
			{
				header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
				echo 'Error reading image file. Please try uploading a new file.';
				exit;
			}
			
			if ($this->prod_image_upload->initialize($config))
			{
				// set field post items
				$post_ary['designer'] 		= $this->input->post('des_id');
				$post_ary['view_status'] 	= $this->input->post('view_status');
				$post_ary['public'] 		= $this->input->post('public');
				$post_ary['publish'] 		= $this->input->post('publish');
				// variant level
				$post_ary_variant['color_publish'] 		= $this->input->post('color_publish') ?: 'Y';
				$post_ary_variant['new_color_publish'] 	= $this->input->post('new_color_publish') ?: 1;
				
				// manually set some field posts
				$post_ary['prod_date'] 	= $this->input->post('prod_date') ?: @date('Y-m-d', time());
				
				// this is old category system
				//$post_ary['cat_id'] 	= '1'; // fashion default cat_id
				$post_ary['subcat_id'] 	= $this->input->post('subcat_id') ?: '';
				
				// applying new category system
				// NOTE: input field is already an array
				$categories = $this->input->post('categories') ? explode(',', $this->input->post('categories')) : array();
				$post_ary['categories']	= json_encode($categories);
				
				// other items
				$d_url_structure 	= $this->input->post('designer_slug');
				$c_url_structure 	= 'apparel';
				$sc_url_structure 	= $this->input->post('category_slug'); // returns NULL if not existing
				
				// process prod_no
				// this will change to existing data if product exists
				$post_ary['prod_no'] = $this->prod_image_upload->prod_no;
				$post_ary['prod_name'] = $this->prod_image_upload->prod_no;
				
				/**
				 * By initializing the product upload, color code and vendor code
				 * is already validated, and will return FALSE when an error occurs
				 * Error message to show accordingly.
				 * Here, we will need to verify the product first for
				 * existence and check it's categorization from the input post.
				 */
				// check for product existence and if with correct categorization
				if (
					$this->product_details->initialize(
						array(
							'tbl_product.prod_no' => $this->prod_image_upload->prod_no
						)
					)
				)
				{
					// return with error if with different desinger
					if (
						$this->input->post('designer_slug') !== $this->product_details->d_folder
						//OR $this->input->post('category_slug') !== $this->product_details->sc_folder
					)
					{
						// send error...
						header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
						echo 'ERROR: Product exists on another designer!';
						exit;
					}
					
					// set prod_id 
					$_prod_id = $this->product_details->prod_id;
					// note that we don't want to overwrite existing information
					// so we re-set some items here for existing products
					$post_ary['prod_no'] = $this->product_details->prod_no;
					$post_ary['prod_name'] = $this->product_details->prod_name;
					$post_ary['prod_date'] = $this->product_details->create_date;
					$post_ary['view_status'] = $this->product_details->view_status;
					$post_ary['public'] = $this->product_details->public;
					$post_ary['publish'] = $this->product_details->publish;
					
					// process the categories part
					$new_categories = array_unique(array_merge($this->product_details->categories, $categories), SORT_REGULAR);
					$post_ary['categories']	= json_encode($new_categories);
					
					// check color
					// expecting a single row result
					$prod_color_exists = $this->product_details->available_colors(
						array(
							'tbl_stock.color_name'=>$this->prod_image_upload->color_name
						)
					);
					if ($prod_color_exists === FALSE)
					{
						// new color... lets process it
						$new_variant = TRUE;
						$post_ary['colors'] = $this->product_details->colors.'-'.$this->prod_image_upload->color_name;
						// at product exists, new colors are not primary media
						$_old_media = '';
						// at product exists, certainly new colors are not primary
						$_is_primary_color = '0';
					}
					else 
					{
						// existing color so we don't post colors anymore
						$new_variant = FALSE;
						// product_detials function available colors returns object array
						// even if result set is single row only, we still need to iterate
						// and use of foreach
						foreach ($prod_color_exists as $color_exist)
						{
							// grab any old attached media
							$_old_media = $color_exist->image_url_path ?: '';
							$_is_primary_color = $color_exist->primary_color;
						}
					}
				}
				else 
				{
					$_prod_id = FALSE;
					
					// new product, new variant, new primary color
					$post_ary['colors'] = $this->prod_image_upload->color_name;
					$post_ary['primary_img_id'] = $this->prod_image_upload->color_code;
					$new_variant = TRUE;
					$_old_media = FALSE;
					$_is_primary_color = '1';
				}
				
				/**
				 * We now upload the image. A few errors that can occur on this are
				 * 'unable to create the uploads directory', 'there was an error in
				 * the file upload', 'error reading image info', 
				 * 'error creating coloricon', 'error creating main view image',
				 * 'error crunching image to thumbs', and 'error in craeting linesheet'.
				 */
				// upload image
				$upload = $this->prod_image_upload->upload();
				// return on error upload
				if ( ! $upload)
				{
					// deinitialize class
					$this->prod_image_upload->deinitialize();
					
					// send error...
					header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
					echo $this->prod_image_upload->error_message;
					exit;
				}
				// */
				
				/**
				 * We process a few more records fields.
				 */
				
				// set wholesale_price and retail price
				if ($this->prod_image_upload->wholesale_price !== FALSE)
				{
					$post_ary['wholesale_price'] = $this->prod_image_upload->wholesale_price;
					$post_ary['less_discount'] = $this->prod_image_upload->wholesale_price * 2;
				}
				
				// set the vendor code
				if ($this->prod_image_upload->vendor_id !== FALSE)
				{
					$post_ary['vendor_id'] = $this->prod_image_upload->vendor_id; 
				}
				
				// process seasons facets for tempoparis
				if ($this->input->post('events'))
				{
					if (
						$this->input->post('events')
						&& (
							$this->webspace_details->slug == 'tempoparis'
							OR $this->session->userdata('active_designer') == 'tempoparis'
						)
					)
					{
						if ( ! in_array($this->input->post('events'), $this->product_details->event_facets))
						{
							// change $season to add current product details set season
							$season_ary = $this->product_details->event_facets;
							array_push($season_ary, strtoupper($this->input->post('events')));
							//$season = implode('-', $season_ary);
							$post_ary['events'] = implode('-', $season_ary);
						}
						else //$season = implode('-', $this->product_details->event_facets);
						$post_ary['events'] = implode('-', $this->product_details->event_facets);
					}
					else $post_ary['events'] = $this->input->post('events');
				}
				
				/**
				 * Before finally adding or updating product records,
				 * we now add the main image to the media library database
				 * - media_library_products in this case...
				 * This is needed to get the media_id as a field on products db
				 */
				// add/update media library records
				$media_id = $this->prod_image_upload->insert_to_media_lib();
				// return if error
				if ( ! $media_id)
				{
					// deinitialize class
					$this->prod_image_upload->deinitialize();
					
					// send error...
					header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
					echo 'Error adding media to library';
					exit;
				}
				// */
				
				/**
				 * Also, "$this->prod_image_upload->media_lib_id" gets set only after
				 * $this->prod_image_upload->upload() method
				 */
				// set image url to recrods fields
				if ($_old_media === FALSE) 
				{
					$post_ary['primary_img'] = $media_id;
				}
				$post_ary_variant['image_url_path'] = $media_id;
				// */
				
				/**
				 * We then add or update product records
				 */
				
				/*
				// set records  	
				*/
				if ($_prod_id)
				{
					// update the record...
					$this->DB->set($post_ary);
					$this->DB->where('prod_id', $_prod_id);
					$query2 = $this->DB->update('tbl_product');
					$prod_id = $_prod_id;
				}
				else
				{
					// insert the record...
					$query3 = $this->DB->insert('tbl_product', $post_ary);
					$prod_id = $this->DB->insert_id();
				}
				// */
	
				/**
				 * Link designer and categories where necessary
				 */
				// for each category
				foreach ($post_ary['categories'] as $category_id)
				{
					// let us link product designer to all checked category
					$this->category_details->initialize(array('category_id' => $category_id));
					$linked_designers = 
						is_array($this->category_details->linked_designers) 
						? $this->category_details->linked_designers 
						: explode(',', $this->category_details->linked_designers)
					;
					
					// check if linked_designers is assoc
					$is_assoc = $this->_is_assoc($linked_designers);
					
					// let's link category to designer if it isn't so
					if ( ! array_search($d_url_structure, $linked_designers))
					{
						// set linked_designers
						if (empty($linked_designers))
						{
							if ($is_assoc) $linked_designers = array($d_url_structure => $d_url_structure);
							else $linked_designers = array($d_url_structure);
						}
						else
						{
							if ($is_assoc) $linked_designers[$d_url_structure] = $d_url_structure;
							else array_push($linked_designers, $d_url_structure);
						}
					
						$linked_designers = json_encode($linked_designers);
						
						// update records
						$this->DB->where('category_id', $category_id);
						$this->DB->update('categories', array('d_url_structure' => $linked_designers));
					}
				}
				// */
				
				/**
				 * Process the variant part of the product
				 */
				 
				// process color
				$post_ary_variant['prod_id'] = $prod_id;
				$post_ary_variant['prod_no'] = $this->prod_image_upload->prod_no;
				$post_ary_variant['color_name'] = $this->prod_image_upload->color_name;
				$post_ary_variant['primary_color'] = $_is_primary_color !== FALSE ? $_is_primary_color : '0';
				$post_ary_variant['stock_date'] = $post_ary['prod_date'];
				$post_ary_variant['des_id'] = $post_ary['designer'];
				
				// set array to pass to odoo here
				// this is necessary to capture the size stock qty below
				$post_ary_to_odoo = $post_ary;

				// set stock qty where necessary
				if ($this->input->post('stock_qty') && $this->input->post('stock_qty') != '0')
				{
					// initialize designer details
					//$this->designer_details->initialize(array('designer.url_structure'=>$this->product_details->d_folder));
					$this->designer_details->initialize(array('designer.url_structure'=>$this->input->post('designer_slug')));
					
					// get size mode
					$query1 = $this->DB->get_where('tblsize', array('size_mode'=>$this->designer_details->webspace_options['size_mode']));
					
					if ($query1->num_rows() > 0)
					{
						foreach ($query1->result() as $row)
						{
							if ($this->designer_details->webspace_options['size_mode'] == '1')
							{
								$post_ary_variant['size_'.strtolower($row->size_name)] = $this->input->post('stock_qty');
								$post_ary_variant_size['size_'.strtolower($row->size_name)] = $this->input->post('stock_qty');
								$post_ary_to_odoo['size_'.strtolower($row->size_name)] = $this->input->post('stock_qty');
							}
							if ($this->designer_details->webspace_options['size_mode'] == '0')
							{
								$post_ary_variant['size_s'.strtolower($row->size_name)] = $this->input->post('stock_qty');
								$post_ary_variant_size['size_'.strtolower($row->size_name)] = $this->input->post('stock_qty');
								$post_ary_to_odoo['size_s'.strtolower($row->size_name)] = $this->input->post('stock_qty');
							}
						}
					}
				}
				
				/*
				// process data		
				*/
				if ($new_variant)
				{
					// insert the record...
					$this->DB->insert('tbl_stock', $post_ary_variant);
					$_st_id = $this->DB->insert_id();
				}
				else
				{
					// If prod_no and color code exists, the product update above
					// took care any update on the wholesale_price and vendor_code
					// if any. Also, image is uploaded respectively. In this case,
					// we only need to update image url of the color.
					
					// get variant id
					$_st_id = $this->input->post('upload_images_st_id') ?: $this->product_details->variant_id($this->prod_image_upload->color_code);
					
					// but if size is set, we will need to update variant sizes as well...
					if ($this->input->post('stock_qty') && $this->input->post('stock_qty') != '0')
					{
						$post_ary_variant_update_only = $post_ary_variant_size;
					}
					$post_ary_variant_update_only['image_url_path'] = $media_id;
					
					// update the record...
					$this->DB->where('st_id', $_st_id);
					$this->DB->update('tbl_stock', $post_ary_variant_update_only);
				}
				// */
				
				/**
				 * Pass data to ODOO
				 */
				// process data to post to ODOO
				$post_ary_to_odoo['prod_id'] = $prod_id;
				$post_ary_to_odoo['cat_slug'] = $c_url_structure;
				$post_ary_to_odoo['designer_slug'] = $d_url_structure;
				$post_ary_to_odoo['subcat_slug'] = $sc_url_structure;
				// send all selected category slugs to odoo
				$post_ary_to_odoo['category_slugs']	= $this->input->post('category_slugs');
				if (isset($post_ary['less_discount'])) $post_ary_to_odoo['retail_price'] = $post_ary['less_discount'];
				$post_ary_to_odoo['st_id'] = $_st_id;
				$post_ary_to_odoo['color'] = $this->prod_image_upload->color_name;
				$post_ary_to_odoo['primary_color'] = $_is_primary_color !== FALSE ? $_is_primary_color : '0';
				$post_ary_to_odoo['image_url'] = $this->prod_image_upload->image_url;
				if ($this->prod_image_upload->vendor_code) 
				{
					$post_ary_to_odoo['vendor_id'] = $this->prod_image_upload->vendor_id;
					$post_ary_to_odoo['vendor_code'] = $this->prod_image_upload->vendor_code;
					$post_ary_to_odoo['vendor_name'] = $this->prod_image_upload->vendor_name;
				}
				// send color code
				$post_ary_to_odoo['color_code'] = $this->prod_image_upload->color_code;
				
				unset($post_ary_to_odoo['less_discount']);
				unset($post_ary_to_odoo['des_id']);
				unset($post_ary_to_odoo['colors']);
				unset($post_ary_to_odoo['primary_img']);
				unset($post_ary_to_odoo['primary_img_id']);
				unset($post_ary_to_odoo['cat_id']);
				unset($post_ary_to_odoo['cat_slug']);
				unset($post_ary_to_odoo['subcat_id']);
				unset($post_ary_to_odoo['subcat_slug']);
				
				if (
					ENVIRONMENT !== 'development'
					&& $post_ary_to_odoo['designer_slug'] === 'basixblacklabel'
				)
				{
					// pass to odoo
					$odoo_response = $this->odoo->post_data($post_ary_to_odoo, 'products', ($new_variant === TRUE ? 'add' : 'edit'));
				}
				
				// clear everything
				unset($post_ary);
				unset($post_ary_variant);
				unset($post_ary_to_odoo);
				// deinitialize classes
				$this->prod_image_upload->deinitialize();
				$this->product_details->deinitialize();
				
				echo '<br />Done';
			}
			else
			{
				// deinitialize class
				$this->prod_image_upload->deinitialize();
				
				// send error...
				header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
				echo 'ERROR: '.$this->prod_image_upload->error_message;
				exit;
			}
		}
		else
		{
			// send error...
			header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
			echo 'No FILE selected for upload';
			exit;
		}
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * PRIVATE - Get vendor id given vendor code
	 *
	 * @params	string
	 * @return	string/boolean FALSE
	 */
	private function _get_vendor_id($vendor_code)
	{
		// get recrods
		$this->DB->where('vendor_code', $vendor_code);
		$q = $this->DB->get('vendors');
		
		if ($q->num_rows() > 0)
		{
			return $q->row()->vendor_id;
		}
		else return FALSE;
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * PRIVATE - Get color name given color code
	 *
	 * @params	string
	 * @return	string/boolean FALSE
	 */
	private function _get_color_name($color_code)
	{
		// get recrods
		$this->DB->where('color_code', $color_code);
		$q = $this->DB->get('tblcolor');
		
		if ($q->num_rows() > 0)
		{
			return $q->row()->color_name;
		}
		else return FALSE;
	}
	
	// ----------------------------------------------------------------------
	
}
