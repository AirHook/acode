<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Sales Package Controller Class
 *
 * This controller class' objective list the sale package items and show it as
 * thumbs page.
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 * @category	Sales Package
 * @author		WebGuy
 * @link
 */
class Link_cs extends Shop_Controller
{
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();
	}

	// --------------------------------------------------------------------

	/**
	 * Link
	 *
	 * Show the sales package items as thumbs page
	 */
	function index($sales_package_id = '', $consumer_user_id = '', $tc = '')
	{
		// sales packages are only for hub sites
		if (
			! isset($this->webspace_details->options['site_type'])
			&& $this->webspace_details->options['site_type'] !== 'hub_site'
		)
		{
			// set flash notice
			$this->session->set_flashdata('error', 'no_sales_package');

			// nothing more to do...
			redirect(site_url(), 'location');
		}

		// some params to initialize for the class
		$is_a_sales_package = TRUE; // this class is initially intended for saved sales packages

		// validate url segments and if sales package id is correct
		if ($sales_package_id == 'X')
		{
			// this link is from the wholesale email carousel
			// where package offer is not saved
			$is_a_sales_package = FALSE;
		}
		else if (
			! $tc
			OR ! $sales_package_id
			OR ! $wholesale_user_id
		)
		{
			// unset any or old sales package sessions
			$this->_unset_sa_session();

			// set flash notice
			$this->session->set_flashdata('error', 'sales_package_invalid_link');

			// nothing more to do...
			redirect('shop/categories', 'location');
		}

		// load pertinent library/model/helpers
		$this->load->library('user_agent');
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('designers/designer_details');
		$this->load->library('categories/category_details');
		$this->load->helpers('metronic/create_category_treelist_helper');

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		/****************
		 * Lets get the sales package
		 */
		if ($is_a_sales_package)
		{
			if ( ! $this->sales_package_details->initialize(array('sales_package_id'=>$sales_package_id)))
			{
				// unset any or old sales package sessions
				$this->_unset_sa_session();

				// set flash notice
				$this->session->set_flashdata('error', 'sales_package_invalid_link');

				// nothing more to do...
				redirect('shop/categories', 'location');
			}
		}

		/****************
		 * Lets get the wholesale user details
		 */
		// check for logged in users and verify link user id
		if ($this->session->user_loggedin && $this->session->user_role === 'consumer')
		{
			if (
				$this->session->user_id != $consumer_user_id
				OR (
					$consumer_user_id == '0'
					&& @$this->consumer_user_details->email != $this->input->get('email')
				)
			)
			{
				// unset any or old sales package sessions
				$this->_unset_sa_session();

				// set flash notice
				$this->session->set_flashdata('error', 'sa_diff_user_loggedin');

				// nothing more to do...
				redirect('account', 'location');
			}
		}
		else
		{
			// logged in user and sa user id/or email is valid, hence we already have
			// wholesale user details
			if (
				! $this->consumer_user_details->initialize(array('user_id'=>$consumer_user_id))
				&& ! $this->consumer_user_details->initialize(array('email'=>$this->input->get('email')))
			)
			{
				// unset any or old sales package sessions
				$this->_unset_sa_session();

				// set flash notice
				$this->session->set_flashdata('error', 'invalid_credentials');

				// nothing more to do...
				redirect('shop/basixblacklabel/womens_apparel/dresses.html?filter=&availability=onsale', 'location');
			}
		}

		// global catch all for inactive wholeslae users
		if (@$this->consumer_user_details->status != '1')
		{
			// set flash notice
			$this->session->set_flashdata('error', 'status_inactive');

			// send to request for activation page
			//redirect('account/request/activation', 'location');
			redirect('shop/basixblacklabel/womens_apparel/dresses.html?filter=&availability=onsale', 'location');
		}

		// auto sign in user if not already signed in
		// do notifications where necessary
		/* *
		if ( ! $this->session->this_login_id)
		{
			// auto activate user if he clicks on the sales package
			//if ($this->wholesale_user_details->status != '1') $this->wholesale_user_details->activate_user();
			// set wholesale user session
			$this->wholesale_user_details->set_session();
			// record login details
			$this->wholesale_user_details->record_login_detail();

			if (ENVIRONMENT !== 'development')
			{
				// notify sales user
				$this->wholesale_user_details->notify_sales_user_online();
				// notify admin user is online
				$this->wholesale_user_details->notify_admin_user_online();
			}
		}
		// */

		/****************
		 * Lets check for 1 click session
		 */
		// get the sales package options property
		if ($is_a_sales_package)
		{
			$options = $this->sales_package_details->options;

			// if click 1 is not yet set, we set it
			if ( ! isset($options[$wholesale_user_id][$tc]))
			{
				// this only means it's the user's firt time to click the link
				// set the [user_id][tc] = logid option indicating user now clicked on the link
				$this->sales_package_details->click_one(
					$wholesale_user_id,
					$tc,
					$this->session->this_login_id
				);

				// reload options
				$options = $this->sales_package_details->options;
			}

			// if click 1 is set, check for same session login id
			// if in different session already, sales package is already invalid
			/* *
			if (@$options[$wholesale_user_id][$tc] !== $this->session->this_login_id)
			{
				// unset any or old sales package sessions
				$this->_unset_sa_session();

				// set flash notice
				$this->session->set_flashdata('error', 'click_one_error');

				// nothing more to do...
				redirect('account/request/sales_package/'.$sales_package_id);
			}
			// */

			/****************
			 * Notify admin and sales that user clicked on sales package
			 */
			$this->_sa_click_notification();

			// set the sales packages session
			$this->sales_package_details->set_session();
			$this->session->set_userdata('sales_package_tc', $tc);
			$this->session->set_userdata('sales_package_link', json_encode($this->uri->segment_array()));
			if ( ! $this->session->userdata('sales_package_items')) $this->session->set_userdata('sales_package_items', $this->sales_package_details->sales_package_items);

			// we define the shop_controller sales_package_items properly
			$this->sales_package_items = json_decode($this->sales_package_details->sales_package_items, TRUE);
		}
		else
		{
			$this->sales_package_items = explode(',', $this->input->get('items_csv'));
		}

		// there is another page visit recording with the entire url recorded
		// holding this here for further evaluation
		/* *
		// set page name
		$pagename = 'sales_package/link';

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
		// */

		// other than shop/all, shop/categoreis, and shop/designers
		// shop/index is the main routing controller for both the
		// browse by category and browse by designer thumbs pages
		// we check if browse by designer or by general categories
		// we do this by checking the first segment after shop if it's a designer slug
		// in the sales package thumbs view, we use browse by category and set this manually
		$this->browse_by = 'sidebar_browse_by_category';
		$browse_by = 'sidebar_browse_by_category';
		$sc_url_structure = '';
		$d_url_structure = '';

			// let get the designer categories
			//$this->data['sales_package_designer_categories'] = $this->categories->treelist(array('d_url_structure'=>$d_url_structure));

			// footer text for SEO purposes
			// applicable to thumbs pages only
			//$this->data['footer_text'] = $this->set->get_footer_text($this->uri->uri_string(), $this->uri->segment(2));

		// check for query string for faceting
		$this->check_facet_query_string();

		// now we grab the product items
		$this->get_products();

		// set data variables to pass to view file
		$this->data['file'] 			= 'product_thumbs_sa'; //'product_details_sa';
		$this->data['view_pane']	 	= 'thumbs_list_sales_pacakge'; // used to indentify if sales package thumbs page
		$this->data['view_pane_sql'] 	= @$this->products ?: @$this->suggested_products; //$products;
		$this->data['left_nav'] 		= $this->browse_by;
		$this->data['left_nav_sql'] 	= @$sidebar_qry;
		$this->data['search_by_style'] 	= TRUE;
		$this->data['search_result']	= FALSE;
		$this->data['site_title']		= @$meta_tags['title'];
		$this->data['site_keywords']	= @$meta_tags['keyword'];
		$this->data['site_description']	= @$meta_tags['description'];
		$this->data['alttags']			= @$meta_tags['alttags'];

		$this->data['c_url_structure']	= 'apparel';
		$this->data['d_url_structure']	= $this->d_url_structure; //$d_url_structure;
		$this->data['sc_url_structure']	= $this->sc_url_structure; //$sc_url_structure;

		// get the product last query for use if user clicks on a product
		$this->session->set_tempdata('prod_list_last_query', $this->products_list->last_query, 1800);

		// load the view
		//$this->load->view($this->config->slash_item('template').'template', $this->data);
		//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
		$this->load->view('metronic/template/template', $this->data);
	}

	// --------------------------------------------------------------------

	/**
	 * PRIVATE unset sales packages session
	 *
	 * @return	void
	 */
	private function _unset_sa_session()
	{
		// unset any or old sales package sessions
		$sesdata = array(
			'sales_package' => FALSE,
			'sales_package_id' => ''
		);
		$this->session->unset_userdata($sesdata);

		// for redundancy purposes..
		unset($_SESSION['sales_package']);
		unset($_SESSION['sales_package_id']);
	}

	// ----------------------------------------------------------------------

	/**
	 * Notify admin of user being online
	 * only if it's a sales package click
	 *
	 * @return	void
	 */
	private function _sa_click_notification()
	{
		// begin send email requet to isntyle admin
		$email_message = '
			<br /><br />
			Dear '.ucwords($this->wholesale_user_details->admin_sales_user).',
			<br /><br />
			'.ucfirst($this->wholesale_user_details->fname.' '.$this->wholesale_user_details->lname).' just cliked on a sales package offer.<br />
			Sales Package Details  - ( ID# '.$this->sales_package_details->sales_package_id.' ) '.$this->sales_package_details->sales_package_name.'
			<br /><br />
			User Details:
			<br /><br />
			<table>
				<tr>
					<td>Store Name: &nbsp; </td>
					<td>'.$this->wholesale_user_details->store_name.'</td>
				</tr>
				<tr>
					<td>User Name: &nbsp; </td>
					<td>'.ucwords($this->wholesale_user_details->fname.' '.$this->wholesale_user_details->lname).'</td>
				</tr>
				<tr>
					<td>Telephone: &nbsp; </td>
					<td>'.$this->wholesale_user_details->telephone.'</td>
				</tr>
				<tr>
					<td>Email: &nbsp; </td>
					<td>'.$this->wholesale_user_details->email.'</td>
				</tr>
			</table>
			<br /><br />

			<br />
		';
		// *** removing below line from above bottom space while it doesn't work
		// Click <u>here</u> to chat with user. <span style="color:red">[ Not yet available. ]</span>

		if (ENVIRONMENT == 'development_') // ---> used for development purposes
		{
			// we are unable to send out email in our dev environment
			// so we check on the email template instead.
			// just don't forget to comment these accordingly
			echo $email_message;
			echo '<br /><br />';

			exit;
		}
		else
		{
			// let's send the email
			// load email library
			$this->load->library('email');

			// notify admin
			$this->email->clear();

			$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);

			$this->email->to($this->wholesale_user_details->admin_sales_email);
			$this->email->cc($this->webspace_details->info_email);

			//$this->email->bcc($this->CI->config->item('dev1_email')); // --> for debuggin purposes

			$this->email->subject('WHOLESALE USER IS ON LINE - '.strtoupper($this->webspace_details->name));
			$this->email->message($email_message);

			// email class has a security error
			// "idn_to_ascii(): INTL_IDNA_VARIANT_2003 is deprecated"
			// using the '@' sign to supress this
			// must resolve pending update of CI
			@$this->email->send();
		}
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
			// iCheck
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
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
				<link href="'.base_url().'assets/custom/jscript/slick/slick.css" rel="stylesheet" type="text/css" />
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
			// iCheck
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-frontend-product_details_sa.js" type="text/javascript"></script>
			';
	}

	// --------------------------------------------------------------------

}
