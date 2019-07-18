<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_images extends Admin_Controller {

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
		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('designers/designer_details');
		$this->load->library('designers/designers_list');
		$this->load->library('categories/categories_tree');
		$this->load->library('image_lib');
		$this->load->library('color_list');

		// get some data
		$designers = $this->designers_list->select();
		$categories = $this->categories_tree->treelist(array('with_products'=>TRUE));

		// -----------------------------------------
		// ---> All Views
		if ( ! empty($_FILES))
		{
			/**
			 * There are two ways this class is used:
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
			 *			and for tempoparis:
			 *				events
			 */

			// let's grab the FILE array names
			$tempFile = $_FILES['file']['tmp_name']; // this also stores file object into a temporary variable
			$filename = $_FILES['file']['name'];

			// Check if image file is a actual image or fake image
			$check = getimagesize($_FILES["file"]["tmp_name"]);
			if($check === false)
			{
				header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
				echo 'Error reading image file. Please try uploading a new file.';
				exit;
			}

			die('died');

			// let's grab the posts
			// set the switches
			$view 			= $this->input->post('product_view');
			$add_product 	= $this->input->post('add_product');
			$stock_qty 		= $this->input->post('stock_qty');
			$image_url 		= $this->input->post('image_url');

			// field post items
			$post_ary['designer'] 		= $this->input->post('des_id');
			$post_ary['subcat_id'] 		= $this->input->post('subcat_id');
			$post_ary['view_status'] 	= $this->input->post('view_status');
			$post_ary['public'] 		= $this->input->post('public');
			$post_ary['publish'] 		= $this->input->post('publish');
			// variant level
			//$post_ary_variant['st_id'] 				= $this->input->post('upload_images_st_id'); // not used
			$post_ary_variant['color_publish'] 		= $this->input->post('color_publish');
			$post_ary_variant['new_color_publish'] 	= $this->input->post('new_color_publish');

			// manually set field posts
			$post_ary['cat_id'] 	= '1'; // fashion default cat_id
			$post_ary['prod_date'] 	= @date('Y-m-d', time());

			// other items
			$d_url_structure 	= $this->input->post('designer_slug');
			$c_url_structure 	= 'apparel';
			$sc_url_structure 	= $this->input->post('category_slug');

			// $image_url (image path) is either set from the form (way 1.0)
			// or, set it here from input posts (way 2.0)
			if ( ! $image_url)
			{
				$image_url = 'product_assets/WMANSAPREL/'.$d_url_structure.'/'.$sc_url_structure.'/product_'.$view.'/';
			}

			// set the path of the uploaded file destination
			// let's grab other parts of the filename and set the image name
			$filename_parts = explode('.', $filename);
			$exp = explode('_', $filename_parts[0]);

			// process prod_no
			$prod_no = strtoupper(trim($exp[0]));
			$post_ary['prod_no'] = $prod_no;
			$post_ary['prod_name'] = $prod_no;

				// if way 2.0, we need to check if prod_no already exists with different categorization
				if ($add_product && $this->product_details->initialize(array('tbl_product.prod_no'=>$prod_no)))
				{
					// return with error if with different categorization
					if (
						$d_url_structure !== $this->product_details->d_folder
						OR $sc_url_structure !== $this->product_details->sc_folder
					)
					{
						// send error...
						header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
						echo 'ERROR: Product exists and with different categorization!';
						exit;
					}

					// set prod_id and others if existing
					// we don't want to overwrite existing information
					$_prod_id = $this->product_details->prod_id;
					$post_ary['prod_no'] = $this->product_details->prod_no;
					$post_ary['prod_name'] = $this->product_details->prod_name;
					$post_ary['prod_date'] = $this->product_details->create_date;
					$post_ary['view_status'] = $this->product_details->view_status;
					$post_ary['public'] = $this->product_details->public;
					$post_ary['publish'] = $this->product_details->publish;
				}
				else $_prod_id = FALSE;
			// --

			// process color_code and get color_name
			$color_code = strtoupper(trim($exp[1])); // this is certain as by minimum, filenames has 2 parts

				// get color name of color code
				// if prod_no and color_code exists already,
				// we assume that the image is being updated
				$_color_name = $this->_get_color_name($color_code);

				if ( ! $_color_name)
				{
					// send error...
					header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
					echo 'ERROR: Product COLOR Code is invalid.';
					exit;
				}

				// if color name is correct
				if ($_prod_id)
				{
					$post_ary['colors'] = $this->product_details->colors.'-'.$_color_name;
					$_st_id = $this->product_details->st_id;
				}
				else
				{
					$post_ary['colors'] = $_color_name;
					$post_ary['primary_img_id'] = $color_code;
					$_st_id = FALSE;
				}
			// --

			// check and set prices
			if (isset($exp[2]))
			{
				$wholesale_price = strlen(trim($exp[2])) < 6 ? trim($exp[2]) : '0';
				$post_ary['wholesale_price'] = $wholesale_price;
				$post_ary['less_discount'] = $wholesale_price * 2;
			}
			else $wholesale_price = FALSE;

			// check and set vendor code
			if (isset($exp[3]))
			{
				$_vendor_code = strlen(trim($exp[3])) < 6 ? trim($exp[3]) : '0';
				$post_ary['vendor_id'] = $this->_get_vendor_id($_vendor_code);

				if ( ! $post_ary['vendor_id'])
				{
					// send error...
					header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
					echo 'ERROR: Product VENDOR Code is invalid.';
					exit;
				}
			}
			else $_vendor_code = FALSE;

			//$camera_capture_number = isset($exp[4]) ? $exp[4] : '0';

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

			// set image name
			$img_name = $prod_no.'_'.$color_code;

			// set target file
			if ($view === 'coloricon')
			{
				$targetFile = $image_url.$img_name.'.jpg';
			}
			else
			{
				$targetFile = $image_url.$filename;
			}

			// given the $image_url, we now add directories where necessary
			// main product image view directory
			if ( ! file_exists($image_url))
			{
				$old = umask(0);
				if ( ! mkdir($image_url, 0777, TRUE))
				{
					header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
					echo 'ERROR: Unable to create "'.$image_url.'" folder.';
					exit;
				}
				umask($old);
			}
			// thumbs directory
			if ( ! file_exists($image_url.'thumbs'))
			{
				$old = umask(0);
				if ( ! mkdir($image_url.'thumbs', 0777, TRUE))
				{
					header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
					echo 'ERROR: Unable to create "'.$image_url.'thumbs/" folder.';
					exit;
				}
				umask($old);
			}

			/**
			 * Move upload file to destination
			 *
			 */
			if ( ! move_uploaded_file($tempFile, $targetFile))
			{
				header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
				echo 'Error in uploading of "'.$tempFile.'" to target file "'.$targetFile.'"!';
				exit;
			}
			// */

			// set stock qty where necessary
			if ($stock_qty)
			{
				// initialize designer details
				$this->designer_details->initialize(array('designer.url_structure'=>$d_folder));

				// get size mode
				$query1 = $this->DB->get_where('tblsize', array('size_mode'=>$this->designer_details->webspace_options['size_mode']));

				if ($query1->num_rows() > 0)
				{
					foreach ($query1->result() as $row)
					{
						if ($this->designer_details->webspace_options['size_mode'] == '1')
						{
							$post_ary_variant['size_'.strtolower($row->size_name)] = $stock_qty;
						}
						if ($this->designer_details->webspace_options['size_mode'] == '0')
						{
							$post_ary_variant['size_s'.strtolower($row->size_name)] = $stock_qty;
						}
					}
				}
			}

			/**
			// for those filename with wholesale prices
			// make a copy of the image using default <prod_no>_<color_code> file name
			 */
			if ($wholesale_price !== FALSE && $view !== 'coloricon')
			{
				$img = @GetImageSize($targetFile);
				$config['image_library']	= 'gd2';
				$config['quality']			= '100%';
				$config['source_image'] 	= $targetFile;
				$config['new_image'] 		= $image_url.$img_name.'.jpg';
				$config['maintain_ratio'] 	= TRUE;
				$config['width']         	= $img[0];
				$config['height']       	= $img[1];
				$this->image_lib->initialize($config);
				if ( ! $this->image_lib->resize())
				{
					echo $this->image_lib->display_errors();
					// send error...
					header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
					echo 'ERROR: Copying image removing other parts of filename - '.$this->image_lib->display_errors();
					exit;
				}
				$this->image_lib->clear();
			}
			// */

			// process images
			if (
				$view == 'front'
				OR $view == 'back'
				OR $view == 'side'
			)
			{
				// set thumbs sizes
				$size = array(
					'1' => array(140, 210),
					'2' => array(60, 90),
					'3' => array(340, 510),
					'4' => array(800, 1200)
				);

				/**
				// crunch the image
				*/
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
						//echo $this->image_lib->display_errors();
						// send error...
						header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
						echo 'ERROR: Crunching image - '.$this->image_lib->display_errors();
						exit;
					}
					$this->image_lib->clear();
				}
				// */

				// prep for linesheet creation
				$img_path = str_replace('product_'.$view, '', $image_url);

				/**
				// get designer logo image
				// and resize it where necessary
				*/
				$this->DB->where('des_id', $des_id);
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
					//echo $this->image_lib->display_errors();
					// send error...
					header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
					echo 'ERROR: Preping Logo for linesheet - '.$this->image_lib->display_errors();
					exit;
				}
				$this->image_lib->clear();
				// */

				/**
				// create linesheet
				*/
				$this->load->helper('create_linesheet');
				if ($img_info = @GetImageSize($img_path.'product_front/'.$img_name.'.jpg'))
				{
					$create = create_linesheet(
						$img_info,
						$prod_no,
						$img_path,
						$img_name,
						$des_logo,
						$wholesale_price,
						$color_detail->color_name
					);
				}
				// */

				// add product to records
				if($add_product)
				{
					// process data
					if ($_prod_id)
					{
						// update the record...
						$this->DB->set($post_ary);
						$this->DB->where('prod_id', $_prod_id);
						$this->DB->update('tbl_product');
					}
					else
					{
						// insert the record...
						$this->DB->set($post_ary);
						$this->DB->insert('tbl_product');
						$_prod_id = $this->DB->insert_id();

						// update recent items after adding new product
						$this->load->library('sales_package/update_sales_package');
						$this->update_sales_package->update_recent_items(); // for multiple designer users
						$this->update_sales_package->update_designer_recent_items($post_ary['designer']); // singer designer users
					}
					// */

					if (@$_color_name)
					{
						$post_ary_variant['prod_id'] = $_prod_id;
						$post_ary_variant['prod_no'] = $post_ary['prod_no'];
						$post_ary_variant['color_name'] = $_color_name;
						$post_ary_variant['primary_color'] = @$post_ary['primary_img_id'] ? '1' : '0';
						$post_ary_variant['stock_date'] = $post_ary['prod_date'];
						$post_ary_variant['des_id'] = $post_ary['designer'];
						$post_ary_variant['color_publish'] = $post_ary_variant['color_publish'] ?: 'Y';
						$post_ary_variant['new_color_publish'] = $post_ary_variant['new_color_publish'] ?: 1;

						// process data
						if ($_st_id)
						{
							// update the record...
							$this->DB->set($post_ary_variant);
							$this->DB->where('st_id', $_st_id);
							$this->DB->update('tbl_stock');
						}
						else
						{
							// insert the record...
							$this->DB->insert('tbl_stock', $post_ary_variant);
							$_st_id = $this->DB->insert_id();
						}
						// */
					}

					// process data to post to ODOO
					$post_ary_to_odoo = $post_ary;
					$post_ary_to_odoo['prod_id'] = $_prod_id;
					$post_ary_to_odoo['cat_slug'] = $c_url_structure;
					$post_ary_to_odoo['designer_slug'] = $d_url_structure;
					$post_ary_to_odoo['subcat_slug'] = $sc_url_structure;
					if ($_vendor_code) $post_ary_to_odoo['vendor_code'] = $_vendor_code;
					if (@$_color_name)
					{
						$post_ary_to_odoo['stock_id'] = $_st_id;
						$post_ary_to_odoo['color'] = $_color_name;
						$post_ary_to_odoo['primary_color'] = @$post_ary_to_odoo['primary_img_id'] ? '1' : '0';
					}
					$post_ary_to_odoo['retail_price'] = $post_ary_to_odoo['less_discount'];
					$post_ary_to_odoo['prod_name'] = $post_ary_to_odoo['prod_no'];

					unset($post_ary_to_odoo['vendor_id']);
					unset($post_ary_to_odoo['less_discount']);
					unset($post_ary_to_odoo['des_id']);
					unset($post_ary_to_odoo['colors']);
					unset($post_ary_to_odoo['primary_img_id']);

					// send product to odoo
					/* *
					if (
						ENVIRONMENT !== 'development'
						&& $this->input->post('designer_slug') === 'basixblacklabel'
					)
					{
						$this->_send_product_to_odoo($post_ary_to_odoo);
					}
					// */

					// reset processed post_ary indeces
					unset($post_ary['colors']);
					unset($post_ary['primary_img_id']);
					unset($post_ary['wholesale_price']);
					unset($post_ary['less_discount']);
					unset($post_ary['vendor_id']);
					unset($post_ary['vendor_code']);
				}
			}

			// set session defaults where necessary
			if ($this->input->post('designer_slug'))
				$this->session->set_userdata('active_designer', $this->input->post('designer_slug'));
			if ($this->input->post('category_slug'))
				$this->session->set_userdata('active_category', $this->input->post('category_slug'));
			if ($this->input->post('product_view'))
				$this->session->set_userdata('select_product_view', $this->input->post('product_view'));
			if ($this->input->post('events'))
				$this->session->set_userdata('active_season', $this->input->post('events'));
		}
		else
		{
			$from = 'multiple'; // 'multiple', 'edit' image upload
			if ($from == 'edit')
			{ ?>
				<?php echo form_open(
					//$this->config->slash_item('admin_folder').'products/upload_images',
					$this->config->slash_item('admin_folder').'products/uploads',
					array(
						'class'=>'dropzone dropzone-file-area',
						'id'=>'my-dropzone-swatch',
						'enctype'=>'multipart/form-data'
					)
				); ?>
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
			else
			{
				?>
				<!-- BEGIN FORM-->
				<!-- FORM =======================================================================-->
				<?php echo form_open(
					//$this->config->slash_item('admin_folder').'products/upload_images',
					$this->config->slash_item('admin_folder').'products/uploads',
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
					<input type="hidden" name="subcat_id" value="129" />
					<input type="hidden" name="category_slug" value="shorts" />
					<input type="hidden" name="des_id" value="5" />
					<input type="hidden" name="designer_slug" value="basixblacklabel" />
					<input type="hidden" name="stock_qty" value="0" />
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
	}

	// ----------------------------------------------------------------------

	/**
	 * Add Product To Odoo via API
	 *
	 * @access 	private
	 * @return	void
	 */
	private function _send_product_to_odoo($post_ary)
	{
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		//
		$api_url = 'http://70.32.74.131:8069/api/create/single/product';
		$api_key = $this->config->item('odoo_api_key');
		if ($api_url != '')
		{
			// add api_key to post_ary
			$post_ary['client_api_key'] = $api_key;

			// set post fields
			$post = $post_ary;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $api_url);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			// execute
			$response = curl_exec($ch);

			// for debugging purposes, check for response
			/*
			if($response === false)
			{
				//echo 'Curl error: ' . curl_error($ch);
				// set flash data
				$this->session->set_flashdata('error', 'post_data_error');
				$this->session->set_flashdata('error_value', curl_error($ch));

				redirect($this->config->slash_item('admin_folder').'products/edit/index/'.$prod_id, 'location');
			}
			*/

			// close the connection, release resources used
			curl_close ($ch);
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
