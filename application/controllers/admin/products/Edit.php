<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends Admin_Controller {

	/**
	 * Properties that are used between view files
	 *
	 * @var	object
	 */
	public $cat_slugs; // used for category_slugs input(s) (edit product and upload images)

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
	public function index($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'products');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('products/product_details');
		$this->load->library('designers/designers_list');
		$this->load->library('categories/categories_tree');
		$this->load->library('users/vendor_users_list');
		$this->load->library('color_list');
		$this->load->library('products/size_names');
		$this->load->library('form_validation');
		$this->load->library('facet_list');
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');

		// get some data
		$this->data['color_facets'] = $this->facet_list->get('color_facets');

		// initialize certain properties
		if ( ! $this->product_details->initialize(array('tbl_product.prod_id'=>$id)))
		{
			//echo 'there is product but no data... but...';
			//die();

			// uh oh... no product on record???
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'products');
		}

		// get size names
		// for now, the following sizes are not used anymore XL1 and XL2 (size_sxl1 and size_sxl2)
		$size_names = $this->size_names->get_size_names($this->product_details->size_mode);
		unset($size_names['size_sxl1']);
		unset($size_names['size_sxl2']);
		$this->data['size_names'] = $size_names;

		// set some active parameters
		$this->session->set_userdata('active_designer', $this->product_details->d_url_structure);
		$this->session->set_userdata('active_category', array_slice($this->product_details->categories, -1));

		// set validation rules
		$this->form_validation->set_rules('publish_date', 'Publish Date', 'trim|required');
		$this->form_validation->set_rules('prod_no', 'Product No (SKU)', 'trim|alpha_numeric|required');
		$this->form_validation->set_rules('prod_name', 'Product Name', 'trim|alpha_numeric_spaces|required');
		$this->form_validation->set_rules('designer', 'Desginer', 'trim|required');
		$this->form_validation->set_rules('categories[]', 'Categories', 'required');
		$this->form_validation->set_rules('less_discount', 'Retail Price', 'trim|required');
		$this->form_validation->set_rules('wholesale_price', 'Wholesale Price', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// check for default tab
			$this->data['active_tab'] = $this->session->userdata('active_tab') ?: 'general';

			// set data variables
			$this->data['designers'] = $this->designers_list->select();
			// categories now are no longer dependent on designer
			//$this->data['categories'] = $this->categories_tree->treelist(array('d_url_structure'=>$this->product_details->d_url_structure));
			$this->data['categories'] = $this->categories_tree->treelist(array('view_status'=>'1'));
			$this->data['vendors'] = $this->vendor_users_list->select(array('designer.des_id'=>$this->product_details->des_id));
			$this->data['colors'] = $this->color_list->select();
			$this->data['styles'] = $this->facet_list->get('styles');
			$this->data['color_facets'] = $this->facet_list->get('color_facets');
			$this->data['events'] = $this->facet_list->get('events');
			$this->data['materials'] = $this->facet_list->get('materials');
			$this->data['trends'] = $this->facet_list->get('trends');
			$this->data['seasons'] = $this->facet_list->get('seasons');

			$front_image =
				$this->product_details->primary_img
				? $this->product_details->media_path.$this->product_details->media_name.'_f.jpg'
				: 'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_url_structure.'/product_front/'.$this->product_details->prod_no.'_'.$this->product_details->primary_img_id.'.jpg'
			;

			// set some switches for incomplete items
			$this->data['inc_general'] = $this->product_details->complete_general;
			//$this->data['inc_general'] = ( ! $this->product_details->subcat_id OR 0)
			//	+ ( ! $this->product_details->retail_price OR 0)
			//	+ ( ! $this->product_details->wholesale_price OR 0);
			$this->data['inc_colors'] = $this->product_details->complete_colors;
			//$this->data['inc_colors'] = ( ! $this->product_details->primary_img_id OR 0)
			//	+ (empty($this->product_details->colors) OR 0);
			$this->data['inc_images'] = ENVIRONMENT === 'development'
				? ( ! @getimagesize($this->config->item('PROD_IMG_URL').$front_image) OR 0)
				: (
					@$this->webspace_details->options['site_type'] == 'hub_site'
					? ( ! file_exists($front_image) OR 0)
					: ( ! @getimagesize($this->config->item('PROD_IMG_URL').$front_image) OR 0)
				);

			// unpublish when any of the above switches is true
			if ($this->data['inc_general'] OR $this->data['inc_images'] OR $this->data['inc_colors'])
			{
				$this->DB->set('publish', '0');
				$this->DB->set('view_status', 'N');
				$this->DB->where('prod_id', $id);
				//$q = $this->DB->update('tbl_product');

				// let's give this switch to unpublish a time before panning out fully...
			}

			// set page variables...
			$this->data['file'] = 'products_edit';
			$this->data['page_title'] = 'Edit Product';
			$this->data['page_description'] = 'Edit product details';

			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			// process variables
			$post_ary = $this->input->post();
			$post = $this->input->post();

			// process post to tbl_product
			$post_to_tbl_product = $this->_post_to_tbl_product($post, $id);

			/***********
			 * Update tbl_product
			 */
			// lets go ahead and update tbl_product record
			$this->DB->set('last_modified', time());
			$this->DB->set($post_to_tbl_product);
			$this->DB->where('prod_id', $id);
			$q = $this->DB->update('tbl_product');
			// */

			// process post per variant
			// includes updating of variant
			// and sending of data to odoo
			$post_to_variant = $this->_post_to_variant($post, $id, $post_to_tbl_product);

			/***********
			 * Update Recent Items
			 */
			// update records
			if ($q)
			{
				// update Recent Items sales package with new item
				$this->load->library('sales_package/update_sales_package');
				$this->update_sales_package->update_recent_items();

				// set flash data
				$this->session->set_flashdata('success', 'edit');

				// redirect user
				redirect($this->config->slash_item('admin_folder').'products/edit/index/'.$id, 'location');
			}
			else
			{
				// set flash data
				$this->session->set_flashdata('error', 'database_update');

				// redirect user
				redirect($this->config->slash_item('admin_folder').'products/edit/index/'.$id, 'location');
			}

		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Update Product To Odoo via API
	 *
	 * @access 	private
	 * @return	void
	 */
	private function _post_to_tbl_product($post_ary, $prod_id)
	{
		// process "publish" state on product item level
		if ($post_ary['publish'] == '1')
		{
			if (@$post_ary['publish_at_hub'] && ! @$post_ary['publish_at_satellite'])
			{
				$post_ary['publish'] = '11';
				$post_ary['view_status'] = 'Y1';
			}
			elseif ( ! @$post_ary['publish_at_hub'] && @$post_ary['publish_at_satellite'])
			{
				$post_ary['publish'] = '12';
				$post_ary['view_status'] = 'Y2';
			}
			else $post_ary['view_status'] = 'Y';

			$post_ary['public'] = 'Y';
		}
		elseif ($post_ary['publish'] == '2') // private
		{
			$post_ary['public'] = 'N';
			$post_ary['view_status'] = 'Y';
		}
		elseif ($post_ary['publish'] == '0') // unpublish
		{
			$post_ary['public'] = 'N';
			$post_ary['view_status'] = 'N';
		}
		else // this is presumably PENDING
		{
			$post_ary['publish'] == '1';
			$post_ary['public'] = 'Y';
			$post_ary['view_status'] = 'Y';
		}

		// clearance/custom_order
		if ( ! isset($post_ary['clearance']))
		{
			$post_ary['clearance'] = '0';
		}

		// process categorization
		$post_ary['cat_id'] = '1';
		$post_ary['cat_slug'] = 'apparel';
		$post_ary['subcat_id'] = $post_ary['categories'][1]; // taking the first subcat child of tree
		$post_ary['subcat_slug'] = $this->categories_tree->get_slug($post_ary['categories'][1]);
		// new categorization system
		$post_ary['categories'] = json_encode($post_ary['categories']);

		// process facets
		if ($this->input->post('styles')) $post_ary['styles'] = strtoupper(implode('-', $this->input->post('styles')));
		if ($this->input->post('events')) $post_ary['events'] = strtoupper(implode('-', $this->input->post('events')));
		if ($this->input->post('materials')) $post_ary['materials'] = strtoupper(implode('-', $this->input->post('materials')));
		if ($this->input->post('trends')) $post_ary['trends'] = strtoupper(implode('-', $this->input->post('trends')));
		if ($this->input->post('seasons')) $post_ary['seasons'] = strtoupper(implode('-', $this->input->post('seasons')));

		// unset unnecessary variables
		unset($post_ary['publish_at_hub']);
		unset($post_ary['publish_at_satellite']);

		unset($post_ary['st_id']);
		unset($post_ary['color_name']);
		unset($post_ary['color_code']);
		unset($post_ary['primary_color']);
		unset($post_ary['image_url_path']);
		unset($post_ary['image_url']);
		unset($post_ary['new_color_publish']);
		unset($post_ary['new_color_publish_at_hub']);
		unset($post_ary['new_color_publish_at_satellite']);
		unset($post_ary['color_publish']);
		unset($post_ary['stock_date']);
		unset($post_ary['custom_order']);
		unset($post_ary['custom_order_old']);
		unset($post_ary['clearance_consumer_only']);
		unset($post_ary['clearance_consumer_only_old']);
		unset($post_ary['warehouse_code']);
		unset($post_ary['admin_warehouse_code']);
		unset($post_ary['color_facets']);
		unset($post_ary['styles']);
		unset($post_ary['events']);

		unset($post_ary['clearance_old']);
		unset($post_ary['cat_slug']);
		unset($post_ary['subcat_slug']);
		unset($post_ary['designer_slug']);
		unset($post_ary['vendor_code']);
		unset($post_ary['vendor_price']);
		unset($post_ary['category_slugs']);

		// precautions
		unset($post_ary['admin_stocks_only']);
		unset($post_ary['post_to_goole']);
		unset($post_ary['post_to_dsco']);
		unset($post_ary['dsco_sku']);

		return $post_ary;
	}

	// ----------------------------------------------------------------------

	/**
	 * Update Product To Odoo via API
	 *
	 * @access 	private
	 * @return	void
	 */
	private function _post_to_variant($post_ary, $prod_id, $post_to_tbl_product)
	{
		foreach ($post_ary['st_id'] as $st_id)
		{
			// check if primary color and folor main product options
			if ($post_ary['primary_color'][$st_id]) // publish
			{
				// new_color_publish (publish, at hub, at sat, or not)
				if ($post_ary['publish'] == '1')
				{
					if (@$post_ary['publish_at_hub'] && ! @$post_ary['publish_at_satellite'])
					{
						$post_to_color_ary['new_color_publish'] = '11';
					}
					elseif ( ! @$post_ary['publish_at_hub'] && @$post_ary['publish_at_satellite'])
					{
						$post_to_color_ary['new_color_publish'] = '12';
					}

					$post_to_color_ary['new_color_publish'] = '1';
					$post_to_color_ary['color_publish'] = 'Y';
				}
				elseif ($post_ary['publish'] == '2') // private
				{
					$post_to_color_ary['new_color_publish'] = '2';
					$post_to_color_ary['color_publish'] = 'N';
				}
				elseif ($post_ary['publish'] == '0') // unpublish
				{
					$post_to_color_ary['new_color_publish'] = '0';
					$post_to_color_ary['color_publish'] = 'N';
				}
				else // default: publish public
				{
					$post_to_color_ary['new_color_publish'] = '1';
					$post_to_color_ary['color_publish'] = 'Y';
				}

				// clearance/custom_order
				if ( ! isset($post_ary['clearance']))
				{
					$post_ary['clearance'] = '0';
				}
				// primary color variant takes on main product clearance
				$post_to_color_ary['custom_order'] = $post_ary['clearance'];
			}
			else
			{
				if ($post_ary['publish'] == '2') // private
				{
					$post_to_color_ary['new_color_publish'] = '2';
					$post_to_color_ary['color_publish'] = 'N';
				}
				elseif ($post_ary['publish'] == '0') // unpublish
				{
					$post_to_color_ary['new_color_publish'] = '0';
					$post_to_color_ary['color_publish'] = 'N';
				}
				// main product should be publish public in order for color options to work
				else
				{
					// new_color_publish
					if (@$post_ary['new_color_publish'][$st_id] == '1')
					{
						if (@$post_ary['new_color_publish_at_hub'][$st_id] && ! @$post_ary['new_color_publish_at_satellite'][$st_id])
						{
							$post_to_color_ary['new_color_publish'] = '11';
						}
						elseif ( ! @$post_ary['new_color_publish_at_hub'][$st_id] && @$post_ary['new_color_publish_at_satellite'][$st_id])
						{
							$post_to_color_ary['new_color_publish'] = '12';
						}
						elseif (@$post_ary['new_color_publish_at_hub'][$st_id] && @$post_ary['new_color_publish_at_satellite'][$st_id])
						{
							$post_to_color_ary['new_color_publish'] = '1';
						}
					}
					elseif (@$post_ary['new_color_publish'][$st_id] == '0') // unpublish
					{
						$post_to_color_ary['new_color_publish'] = '0';
					}

					// color_publish
					if (@$post_ary['color_publish'][$st_id] == '1') // public
					{
						$post_to_color_ary['color_publish'] = 'Y';
					}
					else $post_to_color_ary['color_publish'] = 'N'; // private

					// stock_date
					if (@$post_ary['stock_date'][$st_id] != '')
					{
						$post_to_color_ary['stock_date'] = $post_ary['stock_date'][$st_id];
					}

					// clearance/custom_order
					if ( ! isset($post_ary['clearance']))
					{
						$post_ary['clearance'] = '0';
					}
					// check if main clearance was change on this edit
					if ($post_ary['clearance'] != $post_ary['clearance_old'])
					{
						$post_to_color_ary['custom_order'] = $post_ary['clearance'];
					}
					else
					{
						if ( ! isset($post_ary['custom_order'][$st_id]))
						{
							$post_ary['custom_order'][$st_id] = '0';
						}
						// check if there are changes to variant level clearance
						if ($post_ary['custom_order'][$st_id] != $post_ary['custom_order_old'][$st_id])
						{
							$post_to_color_ary['custom_order'] = $post_ary['custom_order'][$st_id];
						}
					}
				}

			}

			$product_details = $this->product_details->initialize(
				array(
					'tbl_stock.st_id' => $st_id
				)
			);

			// variant options
			$options = $product_details->stocks_options;
			// ----
			// insert options here
			// clearance for consumer only checkbox (first of all options)
			if ( ! isset($post_ary['clearance_consumer_only'][$st_id]))
			{
				$options['clearance_consumer_only'] = '0';
			}
			else
			{
				$options['clearance_consumer_only'] = $post_ary['clearance_consumer_only'][$st_id];
			}
			// admin stocks only
			if ( ! isset($post_ary['admin_stocks_only'][$st_id]))
			{
				$options['admin_stocks_only'] = '0';
			}
			else
			{
				$options['admin_stocks_only'] = $post_ary['admin_stocks_only'][$st_id];
			}
			// post to goole
			// check for previous record of 'post_to_goole'
			// and increment value for image link purposes
			// range starts from 1 to 5
			$google_action = FALSE;
			if ( ! isset($post_ary['post_to_goole'][$st_id]))
			{
				//$options['post_to_goole'] = '0';
				unset($options['post_to_goole']);

				// post delete from google
				$google_action = 'DELETE';
			}
			else
			{
				$post_to_goole_index_val =
					($post_ary['post_to_goole'][$st_id] + 1) > 5
					? 1
					: $post_ary['post_to_goole'][$st_id] + 1
				;

				$options['post_to_goole'] = $post_to_goole_index_val;

				// post insert/update to google
				$google_action = 'UPSERT';
			}
			// warehouse_code
			// warehouse_code - 6 boxes
			if (isset($post_ary['warehouse_code'][$st_id]))
			{
				$warehouse_code_ary = $post_ary['warehouse_code'][$st_id];
				$warehouse_code_ary = array_values(array_filter($warehouse_code_ary, 'strlen'));
				$options['warehouse_code'] = $warehouse_code_ary;
			}
			// admin warehouse_code - 6 boxes
			if (isset($post_ary['admin_warehouse_code'][$st_id]))
			{
				$admin_warehouse_code_ary = $post_ary['admin_warehouse_code'][$st_id];
				$admin_warehouse_code_ary = array_values(array_filter($admin_warehouse_code_ary, 'strlen'));
				$options['admin_warehouse_code'] = $admin_warehouse_code_ary;
			}
			// ----
			// set options
			$post_to_color_ary['options'] = json_encode($options);

			// color_facets
			if ( ! empty($post_ary['color_facets'][$st_id]))
			{
				$post_to_color_ary['color_facets'] = strtoupper(implode('-', $post_ary['color_facets'][$st_id]));
			}

			// additional variables
			$post_to_color_ary['prod_id'] = $prod_id;
			$post_to_color_ary['prod_no'] = $post_ary['prod_no'];
			$post_to_color_ary['color_name'] = $post_ary['color_name'][$st_id];
			$post_to_color_ary['primary_color'] = $post_ary['primary_color'][$st_id];
			$post_to_color_ary['image_url_path'] = $post_ary['image_url_path'][$st_id];
			$post_to_color_ary['des_id'] = $post_ary['designer'];

			/***********
			 * Update tbl_product
			 */
			// update variant
			$this->DB->set($post_to_color_ary);
			$this->DB->where('st_id', $st_id);
			$this->DB->update('tbl_stock');
			// */

			// process google API if any after record update
			if ($google_action == 'UPSERT') $this->_post_to_google($post_to_goole_index_val, $st_id);
			if ($google_action == 'DELETE') $this->_remove_from_google();
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * POST TO GOOGLE
	 *
	 * @return	void
	 */
	private function _post_to_google($post_to_goole_index_val, $st_id)
	{
		// google merchant center requires a main image link and add'l image links
		// create google image is already added to class Prod_image_upload
		// we just need to check if there are old items taht do not have the new images

		// load library and get product details
		$product_details = $this->product_details->initialize(
			array(
				'tbl_stock.st_id' => $st_id
			)
		);

		// check for available stocks
		// load library and get available sizes
		$this->load->model('get_sizes_by_mode');
		$get_size = $this->get_sizes_by_mode->get_sizes($product_details->size_mode);
		$this->load->model('get_product_stocks');
		$check_stock = $this->get_product_stocks->get_stocks($product_details->prod_no, $product_details->color_name);
		$available_sizes = array();
		foreach ($get_size as $size)
		{
			// we need to set the prefix for the size lable
			if($size->size_name == 'XS' || $size->size_name == 'S' || $size->size_name == 'M' || $size->size_name == 'L' || $size->size_name == 'XL' || $size->size_name == 'XXL' || $size->size_name == 'XL1' || $size->size_name == 'XL2' || $size->size_name == 'S-M' || $size->size_name == 'M-L' || $size->size_name == 'ONE-SIZE-FITS-ALL')
			{
				$size_stock = 'available_s'.strtolower($size->size_name);
				$admin_size_stock = 'admin_s'.strtolower($size->size_name);
			}
			else
			{
				$size_stock = 'available_'.$size->size_name;
				$admin_size_stock = 'admin_'.$size->size_name;
			}
			$max_available =
				(
					@$product_details->stocks_options['clearance_consumer_only'] == '1'
					OR @$product_details->stocks_options['admin_stocks_only'] == '1'
				)
				? $check_stock[$size_stock] + $check_stock[$admin_size_stock]
				: $check_stock[$size_stock]
			;

			if ($max_available > 0) array_push($available_sizes, $size->size_name);
		}
		if (empty($available_sizes))
		{
			echo "Not enough stock quantity.<br />";

			return FALSE;
		}

		// make sure product is public
		if (
			$product_details->publish != '1'
			OR $product_details->new_color_publish != '1'
		)
		{
			echo "Item not PUBLIC.<br />";

			return FALSE;
		}

		// check images for all views
		$views = array('f', 'b', 's');
		foreach ($views as $view)
		{
			// set source image
			$src_image =
				$product_details->media_path
				.$product_details->prod_no.'_'.$product_details->color_code
				.'_'
				.$view
				.'.jpg'
			;

			// set new image
			$new_image =
				$product_details->media_path
				.$product_details->prod_no.'_'.$product_details->color_code
				.'_'
				.$view
				.'g'
				.$post_to_goole_index_val
				.'.jpg'
			;

			/* */
			if (ENVIRONMENT != 'development')
			{
				$this->load->helper('create_google_images');
				if ($img_info = @GetImageSize($src_image))
				{
					$create = create_google_images(
						$img_info,
						$src_image,
						$new_image
					);
				}
			}
			// */
		}

		/* */
		// load library and post to google
		if (ENVIRONMENT != 'development')
		{
			$this->load->library('api/google/upsert');
			$this->upsert->initialize(
				array(
					'prod_no' => $product_details->prod_no,
					'color_code' => $product_details->color_code
				)
			);
			$response = $this->upsert->go();
		}
		// */
	}

	// ----------------------------------------------------------------------

	/**
	 * POST TO GOOGLE
	 *
	 * @return	void
	 */
	private function _remove_from_google()
	{
		// load library and post to google
		if (ENVIRONMENT != 'development')
		{
			$this->load->library('api/google/delete');
			$this->delete->initialize(
				array(
					'prod_no' => $this->product_details->prod_no,
					'color_code' => $this->product_details->color_code
				)
			);
			$response = $this->delete->go();
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-products_edit.js?z='.time().'" type="text/javascript"></script>
			';
	}
}
