<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Uploading product images are currently done via:
 *		1.0 via edit product details image tab
 *			using the following inputs:
 *				upload_images_st_id
 *				product_view
 *				des_id
 *				image_url
 *		2.0 via add multiple products image upload
 *			using the following inputs:
 *				add_product
 *				product_view
 *				des_id
 *				subcat_id
 *				category_slug
 *				designer_slug
 *				stock_qty
 *				view_status
 *				public
 *				publish
 *				color_publish
 *				new_color_publish
 *			and an additional item for tempoparis:
 *				events
 */

class Admin_test extends Admin_Controller {

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
				$media_id = '100'; //$this->prod_image_upload->insert_to_media_lib();
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
				// set image url to records fields
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
					//$this->DB->set($post_ary);
					//$this->DB->where('prod_id', $_prod_id);
					//$query2 = $this->DB->update('tbl_product');
					$prod_id = $_prod_id;
				}
				else
				{
					// insert the record...
					//$query3 = $this->DB->insert('tbl_product', $post_ary);
					$prod_id = 100; //$this->DB->insert_id();
				}
				// */

				/**
				 * Link designer and categories where necessary
				 *
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
					/*
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
					// */

					// new stock options: zero stock and default size S & M with 1 unit each
					if ($this->designer_details->webspace_options['size_mode'] == '0')
					{
						$post_ary_variant['size_ss'] = $this->input->post('stock_qty');
						$post_ary_variant_size['size_ss'] = $this->input->post('stock_qty');
						$post_ary_to_odoo['size_ss'] = $this->input->post('stock_qty');

						$post_ary_variant['size_sm'] = $this->input->post('stock_qty');
						$post_ary_variant_size['size_sm'] = $this->input->post('stock_qty');
						$post_ary_to_odoo['size_sm'] = $this->input->post('stock_qty');
					}
					// new stock options: zero stock and default size 2 & 4 with 1 unit each
					if ($this->designer_details->webspace_options['size_mode'] == '1')
					{
						$post_ary_variant['size_2'] = $this->input->post('stock_qty');
						$post_ary_variant_size['size_2'] = $this->input->post('stock_qty');
						$post_ary_to_odoo['size_2'] = $this->input->post('stock_qty');

						$post_ary_variant['size_4'] = $this->input->post('stock_qty');
						$post_ary_variant_size['size_4'] = $this->input->post('stock_qty');
						$post_ary_to_odoo['size_4'] = $this->input->post('stock_qty');
					}
					// new stock options: zero stock and default 1 unit
					if ($this->designer_details->webspace_options['size_mode'] == '2')
					{
						$post_ary_variant['size_sprepack1221'] = $this->input->post('stock_qty');
						$post_ary_variant_size['size_sprepack1221'] = $this->input->post('stock_qty');
						$post_ary_to_odoo['size_sprepack1221'] = $this->input->post('stock_qty');
					}
					if ($this->designer_details->webspace_options['size_mode'] == '3')
					{
						$post_ary_variant['size_ssm'] = $this->input->post('stock_qty');
						$post_ary_variant_size['size_ssm'] = $this->input->post('stock_qty');
						$post_ary_to_odoo['size_ssm'] = $this->input->post('stock_qty');

						$post_ary_variant['size_sml'] = $this->input->post('stock_qty');
						$post_ary_variant_size['size_sml'] = $this->input->post('stock_qty');
						$post_ary_to_odoo['size_sml'] = $this->input->post('stock_qty');
					}
					if ($this->designer_details->webspace_options['size_mode'] == '4')
					{
						$post_ary_variant['size_sonesizefitsall'] = $this->input->post('stock_qty');
						$post_ary_variant_size['size_sonesizefitsall'] = $this->input->post('stock_qty');
						$post_ary_to_odoo['size_sonesizefitsall'] = $this->input->post('stock_qty');
					}
				}

				/*
				// process data
				*/
				if ($new_variant)
				{
					// insert the record...
					//$this->DB->insert('tbl_stock', $post_ary_variant);
					$_st_id = 98; //$this->DB->insert_id();
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
					//$this->DB->where('st_id', $_st_id);
					//$this->DB->update('tbl_stock', $post_ary_variant_update_only);
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

	echo '<pre>';
	print_r($post_ary);
	print_r($post_ary_variant);
	print_r($post_ary_variant_update_only);
	print_r($post_ary_to_odoo);

					// pass to odoo
					//$odoo_response = $this->odoo->post_data($post_ary_to_odoo, 'products', ($new_variant === TRUE ? 'add' : 'edit'));

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
			$from = 'image'; // 'multiple', 'edit' image upload, 'actual_test_page'
			if ($from == 'edit')
			{ ?>
				<?php echo form_open($this->config->slash_item('admin_folder').'products/uploads', array(
					'class'=>'dropzone dropzone-file-area',
					'id'=>'my-dropzone-swatch',
					'enctype'=>'multipart/form-data'
				)); ?>
					<input type="hidden" name="upload_images_st_id" value="" />
					<input type="hidden" name="product_view" value="front" />
					<input type="hidden" name="des_id" value="5" />
					<input type="hidden" name="image_url" value="product_assets/WMANSAPREL/basixblacklabel/shorts/product_front/" />
					<h4 class="sbold"> Front Image </h4>
					<p>Drop files here or click to upload</p>
					<input type="file" name="file" /><br />
					<button type="sbumit" class="btn green mt-ladda-btn ladda-button" data-style="expand-left" id="btn-csv_upload">
						<span class="ladda-label">Upload</span>
						<span class="ladda-spinner"></span>
					</button>
				</form>
				<?php
			}
			elseif ($from == 'actual_test_page')
			{
				// generate the plugin scripts and css
				$this->_create_plugin_scripts();

				// load pertinent library/model/helpers
				$this->load->helper('metronic/create_category_treelist');
				$this->load->library('products/product_details');
				$this->load->library('categories/categories');
				$this->load->library('categories/categories_tree');
				$this->load->library('categories/category_details');
				$this->load->library('designers/designers_list');
				$this->load->library('designers/designer_details');
				$this->load->library('facet_list');

				// get some data
				$this->data['designers'] = $this->designers_list->select();
				$this->data['categories'] = $this->categories_tree->treelist();

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

				// initiate categories via select
				$this->categories_tree->select(array('d_url_structure LIKE'=>'%'.$this->data['active_designer'].'%'));

				// active category selection
				// changing active categories using id's in an array
				// from the old version using slugs
				$this->data['active_category'] =
					$this->session->userdata('active_category')
					?: $this->categories_tree->first_row->category_slug; // first category on list

				// active view default to front
				$this->data['select_product_view'] = $this->session->userdata('select_product_view') ?: 'front';

				// for tempo, get list of season facets and also get the default result season
				// will need to add these seasons to categories to accomodate tempo but will also
				// be availabe to other designers
				/*
				if (
					$this->webspace_details->slug == 'tempoparis'
					OR $this->data['active_designer'] == 'tempoparis'
				)
				{
					$this->data['seasons'] = $this->facet_list->get('events');
					$this->data['active_season'] = $this->session->userdata('active_season') ?: $this->facet_list->first_row->url_structure;
				}
				*/

				// set active details
				$this->data['active_designer_details'] = $this->designer_details->initialize(array('url_structure'=>$this->data['active_designer']));
				//$this->data['active_category_details'] = $this->category_details->initialize(array('category_slug'=>$this->data['active_category']));

				// de-initialize certain properties
				$this->product_details->deinitialize();

				// set page variables...
				$this->data['file'] = 'products_add_upload_images_new';
				$this->data['page_title'] = 'Add Multiple Product';
				$this->data['page_description'] = 'Add multiple new products by uploading images referencing the filenames';

				// load views...
				$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
			}
			else
			{
				?>
				<!-- BEGIN FORM-->
				<!-- FORM =======================================================================-->
				<?php echo form_open(
					$this->config->slash_item('admin_folder').'products/uploads/admin_test',
					array(
						'method'=>'POST',
						'enctype'=>'multipart/form-data',
						'class'=>'form-horizontal',
						'id'=>'form-test_upload_prod_images'
					)
				); ?>

				<input type="hidden" id="base_url" name="base_url" value="<?php echo base_url(); ?>" />

				<div class="modal-header">
					<button type="button" class="close modal-close_btn" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Test Upload Product Images</h4>
				</div>
				<div class="modal-body">

					<input type="hidden" name="add_product" value="1" />
					<input type="hidden" name="product_view" value="front" />
					<!--
					<input type="hidden" name="subcat_id" value="129" />
					<input type="hidden" name="category_slug" value="shorts" />
					-->
					<input type="hidden" name="categories" value="" />
					<input type="hidden" name="category_slugs" value="" />
					<input type="hidden" name="des_id" value="5" />
					<input type="hidden" name="designer_slug" value="basixblacklabel" />
					<input type="hidden" name="stock_qty" value="1" />
					<input type="hidden" name="view_status" value="Y" />
					<input type="hidden" name="public" value="Y" />
					<input type="hidden" name="publish" value="1" />
					<input type="hidden" name="color_publish" value="Y" />
					<input type="hidden" name="new_color_publish" value="1" />

					<br /><br />
					<div class="fileinput fileinput-new" data-provides="fileinput">
						<input type="file" name="file" />
					</div>
					<br />
				</div>
				<div class="modal-footer">
					<button type="sbumit" class="btn green mt-ladda-btn ladda-button" data-style="expand-left" id="btn-csv_upload">
						<span class="ladda-label">Upload</span>
						<span class="ladda-spinner"></span>
					</button>
				</div>

				</form>
				<!-- End FORM =======================================================================-->
				<!-- END FORM-->
				<?php
			}
		}

		echo '<br />Done.';
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
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
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
			// dropzone and form validation
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-dropzone_products_add_mulitple_images.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
