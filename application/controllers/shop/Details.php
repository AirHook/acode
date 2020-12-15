<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Details extends Frontend_Controller
{
	/**
	 * DB Object
	 *
	 * @return	object
	 */
	protected $DB;


	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();

		// connect to database for use by model
		$this->DB = $this->load->database('instyle', TRUE);

	}

	// --------------------------------------------------------------------

	/**
	 * Primary method - index
	 *
	 * @return	void
	 */
	function index()
	{
		// load pertinent library/model/helpers
		$this->load->library('user_agent');
		$this->load->model('get_sizes_by_mode');
		$this->load->model('get_product_stocks');
		$this->load->library('designers/designer_details');
		$this->load->library('products/product_details');
		$this->load->library('products/product_clicks');
		$this->load->library('products/size_names');

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// tempoparis is a stand alone wholesale site
		// we need to apply same conditions for tempo items at shop7
		// and not show tempo items in general pages
		// only when user is logged in
		if (
			$this->uri->segment(3) == 'tempoparis'
			&& $this->session->userdata('user_cat') != 'wholesale'
		)
		{
			// set session
			$this->session->set_flashdata('error', 'tempoparis_must_login');

			// redirect user..
			redirect('account', 'location');
		}

		// get product details
		if (
			! $this->product_details->initialize(array(
				'tbl_product.prod_no' => $this->uri->segment(4),
				'tbl_stock.color_name' => str_replace('-',' ',strtoupper($this->uri->segment(5)))
			))
		)
		{
			// send user back to categories page on false
			redirect('shop/categories', 'location');
		}

		// there is an issue on phantom links where the product has not availabe
		// stocks on all sizes but when link is browsed, the product details
		// page is shown.  $this->product_details->with_stocks doesn't seem
		// to address this issue. will need to put code here to redirect to
		// home categories page with error='without_stocks'
		//
		// 20201124 Show Preorder, hence, show all items even without stocks
		// but with prices >= 695
		/* */
		if (
			$this->webspace_details->slug != 'tempoparis'
			&& (
				//! $this->product_details->with_stocks
				//OR $this->product_details->publish == '0'
				//OR $this->product_details->new_color_publish == '0'
				! $this->product_details->with_stocks
				&& $this->product_details->retail_price < 695
			)
		)
		{
			// set session
			$this->session->set_flashdata('error', 'without_stocks');

			// send user back to categories page on false
			if (@$this->webspace_details->options['site_type'] == 'hub_site')
			{
				redirect('shop/categories', 'location');
			}
			else redirect(site_url(), 'location');
		}
		// */

		// this next section of the program is necessary
		// to be able to draw up a correct category breadcrumb
		// we grab some data from url identifying the nth product
		// number of current select product detail
		$prod_list_seq = explode('of', $this->uri->segment(7));
		$this->data['nth_prod'] = $prod_list_seq[0];
		$this->data['total_products_in_list'] = @$prod_list_seq[1] ?: 1;

		// we then grab the query from the product list that referred to this product details page
		// to get its categories for breadcrumbs purposes
		if ($this->session->tempdata('prod_list_last_query'))
		{
			$this->data['prod_list_last_query'] = $this->session->tempdata('prod_list_last_query');
			$prev_qry = $this->DB->query($this->session->tempdata('prod_list_last_query'));
			// this current product record (deduct one from count as indeces start at 0)
			$this_row = $prev_qry->row($prod_list_seq[0] - 1);

			// we need to check if user came from a browse by category or browse by designer thumbs page
			// to capture the designer slug for breadcrumbs purposes
			if ($this->session->flashdata('browse_by') == 'sidebar_browse_by_designer')
			{
				$this->data['url_segs'][0] = array($this_row->designer, $this_row->d_url_structure);
				$this->session->keep_flashdata('browse_by');
			}

			// get the categories for breadcrumbs purposes
			$tempcategories = ($this_row->categories && $this_row->categories != '') ? json_decode($this_row->categories, TRUE) : array();
			$temp2categories = $this->categories_tree->treelist(
				array(
					'view_status' => '1',
					'with_products' => TRUE
				)
			);
			foreach ($temp2categories as $temp2cat)
			{
				if (in_array($temp2cat->category_id, $tempcategories))
				{
					// store category data (name and slug) with key as reference category ID
					$this->data['url_segs'][$temp2cat->category_id] = array($temp2cat->category_name, $temp2cat->category_slug);
				}
			}
		}
		else
		{
			// in case, the tempdata session expires due to inactivity
			// or, when browsing in another window
			// or, when coming from a page other than product thumbs list
			// we use the default general caregory list to for above

			// get the categories for breadcrumbs purposes
			$tempcategories = $this->product_details->categories;
			$temp2categories = $this->categories_tree->treelist(
				array(
					'view_status' => '1',
					'with_products' => TRUE
				)
			);
			foreach ($temp2categories as $temp2cat)
			{
				if (in_array($temp2cat->category_id, $tempcategories))
				{
					// store category data (name and slug) with key as reference category ID
					$this->data['url_segs'][$temp2cat->category_id] = array($temp2cat->category_name, $temp2cat->category_slug);
					$last_category = $temp2cat->category_id;
				}
			}

			// lets get the product listing query
			$str_qry = $this->_get_prod_listing_query($this->product_details->d_url_structure, $last_category);
			$prev_qry = $this->DB->query($str_qry);
		}

		$this->data['size_names'] = $this->size_names->get_size_names($this->product_details->size_mode);

		// we get prev's and next's products details for (< Prev & Next >)'s url link purposes
		if ($prod_list_seq[0] > 1)
		{
			// get product details
			$prev_row = $prev_qry->row($prod_list_seq[0] - 2);
			// set link
			$this->data['prev_link'] =
				'shop/details/'
				. $prev_row->d_url_structure . '/'	// designer
				. $prev_row->prod_no. '/'			// prod_no
				. str_replace(' ','-',strtolower(trim($prev_row->color_name))). '/'		// color_name
				. str_replace(' ','-',strtolower(trim(($prev_row->prod_name ?: $prev_row->prod_no)))). '/'	// prod_name
				. ($prod_list_seq[0] - 1).'of'.$prod_list_seq[1]					// some pagination identification
			;
		}
		if ($prod_list_seq[0] < @$prod_list_seq[1])
		{
			// get product details
			$next_row = $prev_qry->row($prod_list_seq[0]);
			// set link
			$this->data['next_link'] =
				'shop/details/'
				. $next_row->d_url_structure . '/'	// designer
				. $next_row->prod_no. '/'			// prod_no
				. str_replace(' ','-',strtolower(trim($next_row->color_name))). '/'		// color_name
				. str_replace(' ','-',strtolower(trim(($next_row->prod_name ?: $next_row->prod_no)))). '/'	// prod_name
				. ($prod_list_seq[0] + 1).'of'.$prod_list_seq[1]					// some pagination identification
			;
		}

		// cloud zoom is causing the page to load twice
		// we need the cloud zoom for the image zoom effect
		// we will need to use a flashdata session variable to circumvent this bug
		if (
			$this->session->prod_details_prod_no != $this->product_details->prod_no
		)
		{
			// at hub site...
			if (
				@$this->webspace_details->options['site_type'] == 'hub_site'
				&& isset($_SERVER['HTTP_REFERER'])
			)
			{
				// do not allow known user agent robots to pass...
				if ( ! $this->agent->is_robot())
				{
					// let us update product clicks
					$this->product_clicks->update(
						$this->product_details->prod_no,
						$this->product_details->designer_name,
						($this->session->user_cat == 'wholesale' ? TRUE : FALSE)
					);
				}
			}

			$_SESSION['prod_details_prod_no'] = $this->product_details->prod_no;

			// we also update the wholesale page visits and product clicks
			// this controller renders designer categories thumbs page
			if (
				$this->session->user_loggedin
				&& $this->session->user_cat == 'wholesale'
				&& $this->session->this_login_id
			)
			{
				// set page name
				$pagename = 'shop/details';

				// update login details
				if ( ! $this->wholesale_user_details->update_login_detail(array($pagename, 1), 'page_visits'))
				{
					// in case the update went wrong
					// i.e., cases where user id in session got lost, or,
					// the record with the id was removed from database table...
					// manually logout user here to remove previous records, and
					// redirect to signin page
					$this->wholesale_user_details->initialize();
					$this->wholesale_user_details->unset_session();

					// destroy any cart items
					$this->cart->destroy();

					// set flash data
					$this->session->set_flashdata('flashMsg', 'Something went wrong with your connection.<br />Please login again.');

					// redirect to categories page
					redirect(site_url('wholesale/signin'), 'location');
				}

				// if something went wrong above, this line forward will no longer be reached...
				$this->wholesale_user_details->update_login_detail(array($this->product_details->prod_no, 1), 'product_clicks');
			}
		}

		// we do all frontend calculations and setting of variables here before loading view file
		$this->_get_details();

		// set $file view file
		// this used to be simply 'product_details_regular' for sat_site
		// now joe wants to have it the same as tempo where users who
		// logs in at sat_site goes directly to the MY ACCOUNT on the sat_site
		/* *
		$this->data['file'] = $this->webspace_details->options['site_type'] == 'sat_site'
			//? 'product_detail_inquiry'
			? 'product_details_regular'
			: (
				$this->session->userdata('user_cat') == 'wholesale'
					? 'product_details_wholesale'
					//? 'product_details_regular'
					//: 'product_detail_order'
					: 'product_details_regular'
			);
		// */
		$this->data['file'] =
			$this->session->userdata('user_cat') == 'wholesale'
			? 'product_details_wholesale'
			: 'product_details_regular'
		;

		// set data variables to pass to view file
		$this->data['view_pane']		= @$_GET['vw'] ?: '';
		$this->data['product']		 	= ''; //$prod_qry->row();
		$this->data['search_by_style'] 	= FALSE;
		$this->data['search_result']	= FALSE;
		$this->data['jscript'] 			= @$jscript;
		$this->data['site_title']		= $this->product_details->prod_no.' - '.ucwords(strtolower($this->product_details->color_name)).' '.$this->product_details->prod_name;
		$this->data['site_keywords']	= '';
		$this->data['site_description']	= $this->product_details->prod_desc;
		$this->data['alttags']			= $this->product_details->prod_no.' - '.$this->product_details->prod_name;
		$this->data['footer_text']		= $this->product_details->prod_no.' - '.ucwords(strtolower($this->product_details->color_name)).' '.$this->product_details->prod_name;

		// load the view
		$this->load->view('metronic/template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Calculations and variables for view file
	 *
	 * @return	object
	 */
	private function _get_details()
	{
		// get available color list
		// used for different color main view image iteration,
		// color names, and colow swatches
		$this->data['get_color_list'] = $this->product_details->available_colors();

		// image path and names
		$color_code =
			$this->product_details->color_name == ''
			? $color_code = $this->product_details->primary_img_id
			: $color_code = $this->product_details->color_code
		;

		// prep for old folder structure url system
		$img_path = 'product_assets/WMANSAPREL/'.$this->product_details->d_folder.'/'.$this->product_details->sc_url_structure.'/';
		$img_name = $this->product_details->prod_no.'_'.$color_code;
		$this->data['img_path'] = $img_path;
		$this->data['img_name'] = $img_name;

		/**
		 * Thumb sizes
		private $size = array(
			'1' => array(140, 210),
			'2' => array(60, 90),
			'3' => array(340, 510),
			'4' => array(800, 1200) // removing use of this
		);
		*/

		// access to old folder structure url system
		$this->data['img_large'] =
			$this->product_details->primary_img
			? $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$img_name.'_f.jpg'
			: $this->config->item('PROD_IMG_URL').$img_path.'product_front/'.$img_name.'.jpg'
		;
		$this->data['img_thumb'] =
			$this->product_details->primary_img
			? $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$this->product_details->media_name.'_f3.jpg'
			: $this->config->item('PROD_IMG_URL').$img_path.'product_front/thumbs/'.$img_name.'_3.jpg'
		;
		$this->data['img_video_flv'] = $this->config->item('PROD_IMG_URL').$img_path.'product_video/'.$img_name.'.flv';
		$this->data['img_video_mp4'] = $this->config->item('PROD_IMG_URL').$img_path.'product_video/'.$img_name.'.mp4';
		$this->data['img_video_ogv'] = $this->config->item('PROD_IMG_URL').$img_path.'product_video/'.$img_name.'.ogv';
		$this->data['img_video_webm'] = $this->config->item('PROD_IMG_URL').$img_path.'product_video/'.$img_name.'.webm';

		// access to new media library system with fallback condition
		// resorting to old folder structure url system
		$this->data['img_inquiry'] =
			$this->product_details->primary_img
			? $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$img_name.'_f1.jpg'
			: $this->config->item('PROD_IMG_URL').$img_path.'product_front/thumbs/'.$img_name.'_1.jpg'
		;

		$this->data['img_front'] =
			$this->product_details->primary_img
			? $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$img_name.'_f1.jpg'
			: $this->config->item('PROD_IMG_URL').$img_path.'product_front/thumbs/'.$img_name.'_1.jpg'
		;
		$this->data['img_side'] =
			$this->product_details->primary_img
			? $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$img_name.'_s1.jpg'
			: $this->config->item('PROD_IMG_URL').$img_path.'product_side/thumbs/'.$img_name.'_1.jpg'
		;
		$this->data['img_back'] =
			$this->product_details->primary_img
			? $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$img_name.'_b1.jpg'
			: $this->config->item('PROD_IMG_URL').$img_path.'product_back/thumbs/'.$img_name.'_1.jpg'
		;

		$this->data['img_front_thumb'] =
			$this->product_details->primary_img
			? $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$img_name.'_f.jpg'
			: $this->config->item('PROD_IMG_URL').$img_path.'product_front/thumbs/'.$img_name.'_4.jpg'
		;
		$this->data['img_side_thumb'] =
			$this->product_details->primary_img
			? $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$img_name.'_s.jpg'
			: $this->config->item('PROD_IMG_URL').$img_path.'product_side/thumbs/'.$img_name.'_4.jpg'
		;
		$this->data['img_back_thumb']=
			$this->product_details->primary_img
			? $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$img_name.'_b.jpg'
			: $this->config->item('PROD_IMG_URL').$img_path.'product_back/thumbs/'.$img_name.'_4.jpg'
		;

		$this->data['img_front_3'] =
			$this->product_details->primary_img
			? $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$img_name.'_f3.jpg'
			: $this->config->item('PROD_IMG_URL').$img_path.'product_front/thumbs/'.$img_name.'_3.jpg'
		;
		$this->data['img_side_3'] =
			$this->product_details->primary_img
			? $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$img_name.'_s3.jpg'
			: $this->config->item('PROD_IMG_URL').$img_path.'product_side/thumbs/'.$img_name.'_3.jpg'
		;
		$this->data['img_back_3']=
			$this->product_details->primary_img
			? $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$img_name.'_b3.jpg'
			: $this->config->item('PROD_IMG_URL').$img_path.'product_back/thumbs/'.$img_name.'_3.jpg'
		;

		$this->data['img_front_large'] =
			$this->product_details->primary_img
			? $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$img_name.'_f.jpg'
			: $this->config->item('PROD_IMG_URL').$img_path.'product_front/'.$img_name.'.jpg'
		;
		$this->data['img_side_large'] =
			$this->product_details->primary_img
			? $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$img_name.'_s.jpg'
			: $this->config->item('PROD_IMG_URL').$img_path.'product_side/'.$img_name.'.jpg'
		;
		$this->data['img_back_large'] =
			$this->product_details->primary_img
			? $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$img_name.'_b.jpg'
			: $this->config->item('PROD_IMG_URL').$img_path.'product_back/'.$img_name.'.jpg'
		;

		return $this;
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Calculations and variables for view file
	 *
	 * @return	object
	 */
	private function _get_prod_listing_query($d_url_structure, $category_id)
	{
		// get the products list and total count based on parameters
		$params['wholesale'] = $this->session->userdata('user_cat') == 'wholesale' ? TRUE : FALSE;
		$params['show_private'] = $this->session->userdata('user_cat') == 'wholesale' ? TRUE : FALSE;
		if ($this->webspace_details->options['site_type'] != 'hub_site') $params['view_at_hub'] = FALSE;
		if ($this->webspace_details->options['site_type'] == 'hub_site') $params['view_at_satellite'] = FALSE;
		// show items even without stocks at all
		$params['with_stocks'] = FALSE;
		$params['group_products'] = TRUE;
		// set facet searching if needed
		$params['facets'] = @$_GET ?: array();
		// others
		$params['random_seed'] = FALSE;
		$this->load->library('products/products_list', $params);
		$this->products = $this->products_list->select(
			// where conditions
			array(
				'designer.url_structure' => $d_url_structure,
				'tbl_product.categories LIKE' => $category_id // last segment of category
			),
			// sorting conditions
			array('seque'=>'asc')
		);
		return $this->products_list->last_query;
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Create Plugin Scripts and CSS for the page
	 *
	 * This section is theme based.
	 * We will eventually need to come up with a system to load specific
	 * styles and scripts for each page as per selected theme
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

			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap tagsinput
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
			';
			// bs touchspin
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css" rel="stylesheet" type="text/css" />
			';
			// cloud zoom (old free plugin)
			$this->data['page_level_styles_plugins'].= '
				<link href="'.base_url().'assets/custom/jscript/cloud-zoom/cloud-zoom.css" rel="stylesheet" type="text/css" />
			';
			// slick
			$this->data['page_level_styles_plugins'].= '
				<link href="'.base_url().'assets/custom/jscript/slick/slick.css?z='.time().'" rel="stylesheet" type="text/css" />
				<link href="'.base_url().'assets/custom/jscript/slick/slick-theme.css" rel="stylesheet" type="text/css" />
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

			// unveil - lazy script for images
			$this->data['page_level_plugins'] = '
				<script src="'.base_url().'assets/custom/js/jquery.unveil.js" type="text/javascript"></script>
			';
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// bootstrap tagsinput
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
			';
			// bs touchspin
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/fuelux/js/spinner.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
			';
			// matchheight
			$this->data['page_level_plugins'].= '
				<script src="'.base_url().'assets/custom/jscript/matchheight/jquery.matchHeight.min.js" type="text/javascript"></script>
			';
			// slick
			$this->data['page_level_plugins'].= '
				<script src="'.base_url().'assets/custom/jscript/slick/slick.min.js" type="text/javascript"></script>
			';
			// panzoom
			$this->data['page_level_plugins'].= '
				<script src="'.base_url().'assets/custom/jscript/panzoom/jquery.panzoom.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
		 */
		$this->data['page_level_scripts'] = '';

			// handle bootstrap select - make select class '.bs-select' a boostrap select picker
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// cloud-zoom
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/themes/roden2/js/jquery-min.js" type="text/javascript"></script>
				<script src="'.base_url().'assets/custom/jscript/cloud-zoom/cloud-zoom.1.0.2.js" type="text/javascript"></script>
				<script>$.noConflict();</script>
			';
			// custom js
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/jstools.js" type="text/javascript"></script>
			';
			// handle scripts
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-frontend-product_details.js?z='.time().'" type="text/javascript"></script>
			';
	}

	// --------------------------------------------------------------------

}
