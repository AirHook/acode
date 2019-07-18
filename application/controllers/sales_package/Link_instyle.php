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
class Link extends Frontend_Controller
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
	function index($sales_package_id = '', $wholesale_user_id = '', $tc = '')
	{
		// sales packages are only for hub sites
		if (
			! isset($this->webspace_details->options['site_type'])
			&& $this->webspace_details->options['site_type'] !== 'hub_site'
		)
		{
			// set flash notice
			$this->session->set_flashdata('no_sales_package', TRUE);

			// nothing more to do...
			redirect(site_url(), 'location');
		}

		// check for time code and sales package id info
		if (
			! $tc
			OR ! $sales_package_id
		)
		{
			// unset any old sales package sessions
			$sesdata = array(
				'sales_package' => FALSE,
				'sales_package_id' => ''
			);
			$this->session->unset_userdata($sesdata);

			// for redundancy purposes..
			unset($_SESSION['sales_package']);
			unset($_SESSION['sales_package_id']);

			// set flash notice
			$this->session->set_flashdata('sales_package_expired', TRUE);

			// nothing more to do...
			redirect('shop/categories');
		}

		// check for wholesale user id info
		if ( ! $wholesale_user_id)
		{
			// unset any old sales package session
			$sesdata = array(
				'sales_package' => FALSE,
				'sales_package_id' => ''
			);
			$this->session->unset_userdata($sesdata);

			// for redundancy purposes..
			unset($_SESSION['sales_package']);
			unset($_SESSION['sales_package_id']);

			// set flash notice
			$this->session->set_flashdata('sales_package_invalid_credentials', TRUE);

			// nothing more to do...
			redirect('wholesale/signin');
		}

		// load pertinent library/model/helpers
		$this->load->library('user_agent');
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('users/wholesale_user_details');

		/****************
		 * Check for access link expiration using available $tc time code
		 */
		$day1 = md5(@date('Y-m-d', time())); // today
		$day2 = md5(@date('Y-m-d', time() - 60 * 60 * 24)); // yesterday
		$day3 = md5(@date('Y-m-d', time() - 60 * 60 * 48)); // the other day
		$days = array($day1, $day2, $day3); // 3 days expiration

		if ( ! in_array($tc, $days))
		{
			// unset any old sales package session
			$sesdata = array(
				'sales_package' => FALSE,
				'sales_package_id' => ''
			);
			$this->session->unset_userdata($sesdata);

			// for redundancy purposes..
			unset($_SESSION['sales_package']);
			unset($_SESSION['sales_package_id']);

			// set flash notice
			$this->session->set_flashdata('sales_package_expired', TRUE);

			// nothing more to do...
			redirect('shop/categories');
		}

		// now that everything is verified correct, let's get the user and
		// sales package details and set sessions accordingly

		/****************
		 * Get the sales pakage details
		 * No point in auto signin of user if there is no sales package
		 */
		// let's get the sales package first
		if ( ! $this->sales_package_details->initialize(array('sales_package_id'=>$sales_package_id)))
		{
			// unset any old sales package session
			$sesdata = array(
				'sales_package' => FALSE,
				'sales_package_id' => ''
			);
			$this->session->unset_userdata($sesdata);

			// for redundancy purposes..
			unset($_SESSION['sales_package']);
			unset($_SESSION['sales_package_id']);

			// set flash notice
			$this->session->set_flashdata('no_sales_package', TRUE);

			// nothing more to do...
			redirect('apparel');
		}

		// set sales package session
		$this->sales_package_details->set_session();
		$this->session->set_userdata('sales_package_tc', $tc);
		$this->session->set_userdata('sales_package_link', json_encode($this->uri->segment_array()));
		if ( ! $this->session->userdata('sales_package_items')) $this->session->set_userdata('sales_package_items', $this->sales_package_details->sales_package_items);

		/****************
		 * Get and initialize user details
		 * Auto signin user
		 */
		if ( ! $this->wholesale_user_details->initialize(array('user_id'=>$wholesale_user_id)))
		{
			// unset any old sales package session
			$sesdata = array(
				'sales_package' => FALSE,
				'sales_package_id' => ''
			);
			$this->session->unset_userdata($sesdata);

			// for redundancy purposes..
			unset($_SESSION['sales_package']);
			unset($_SESSION['sales_package_id']);

			// set flash notice
			$this->session->set_flashdata('sales_package_invalid_credentials', TRUE);

			// nothing more to do...
			redirect('wholesale/signin');
		}

		if ( ! isset($_SESSION['this_login_id']))
		{
			// auto activate user if he clicks on the sales package
			if ($this->wholesale_user_details->status != '1') $this->wholesale_user_details->activate_user();
			// set wholesale user session
			$this->wholesale_user_details->set_session();
			// record login details
			$this->wholesale_user_details->record_login_detail();
			// notify admin user is online
			$this->_notify_admin_user_online();
		}
		else
		{
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

			// update product clicks...
			//$this->wholesale_user_details->update_login_detail(array($this->product_details->prod_no, 1), 'product_clicks');
		}

		// other than shop/all, shop/categoreis, and shop/designers
		// shop/index is the main routing controller for both the
		// browse by category and browse by designer thumbs pages
		// we check if browse by designer or by general categories
		// we do this by checking the first segment after shop if it's a designer slug
		// in the sales package thumbs view, we use browse by category and set this manually
		$browse_by = 'sidebar_browse_by_category';
		$sc_url_structure = '';
		$d_url_structure = '';

			// let get the designer categories
			//$this->data['sales_package_designer_categories'] = $this->categories->treelist(array('d_url_structure'=>$d_url_structure));

			// footer text for SEO purposes
			// applicable to thumbs pages only
			//$this->data['footer_text'] = $this->set->get_footer_text($this->uri->uri_string(), $this->uri->segment(2));

		// now we grab the product items
		// get the products list and total count
		$params['wholesale'] = $this->session->userdata('user_cat') == 'wholesale' ? TRUE : FALSE;
		$params['show_private'] = $this->session->userdata('user_cat') == 'wholesale' ? TRUE : FALSE;
		// show items even without stocks at all
		$params['with_stocks'] = FALSE;
		$params['group_products'] = TRUE;
		// set facet searching if needed
		$params['facets'] = @$_GET ?: array();
		// others
		$this->load->library('products/products_list', $params);
		$products = $this->products_list->select(
			json_decode($this->session->userdata('sales_package_items'), TRUE)
		);
		$product_count = $this->products_list->count_all;

		// set data variables to pass to view file
		$this->data['file'] 			= 'product_thumbs_new';
		$this->data['view_pane']	 	= 'thumbs_list_sales_pacakge'; // not being used
		$this->data['view_pane_sql'] 	= $products;
		$this->data['left_nav'] 		= 'sidebar_browse_by_category';
		$this->data['left_nav_sql'] 	= @$sidebar_qry;
		$this->data['search_by_style'] 	= TRUE;
		$this->data['search_result']	= FALSE;
		$this->data['site_title']		= @$meta_tags['title'];
		$this->data['site_keywords']	= @$meta_tags['keyword'];
		$this->data['site_description']	= @$meta_tags['description'];
		$this->data['alttags']			= @$meta_tags['alttags'];

		$this->data['c_url_structure']	= 'apparel';
		$this->data['d_url_structure']	= $d_url_structure;
		$this->data['sc_url_structure']	= $sc_url_structure;

		// load the view
		//$this->load->view($this->config->slash_item('template').'template', $this->data);
		$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * Notify admin of user being online
	 *
	 * @return	void
	 */
	private function _notify_admin_user_online()
	{
		// begin send email requet to isntyle admin
		$email_message = '
			<br /><br />
			Dear '.ucwords($this->wholesale_user_details->admin_sales_user).',
			<br /><br />
			'.ucfirst($this->wholesale_user_details->fname.' '.$this->wholesale_user_details->lname).' is now online.<br />
			Total logged in visits  - ( '.$this->wholesale_user_details->total_visits().' ).
			<br /><br />
			<strong>Sale User Representative:</strong> &nbsp; &nbsp; '.$this->wholesale_user_details->admin_sales_user.' '.$this->wholesale_user_details->admin_sales_lname.'
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
			Click <u>here</u> to chat with user. <span style="color:red">[ Not yet available. ]</span>
			<br />
		';

		if (ENVIRONMENT !== 'development')
		{
			// let's send the email
			// load email library
			$this->load->library('email');

			// notify admin
			$this->email->clear();

			$this->email->from($this->wholesale_user_details->designer_info_email, $this->wholesale_user_details->designer);

			$this->email->to($this->webspace_details->info_email);

			//$this->email->bcc($this->config->item('dev1_email')); // --> for debuggin purposes

			$this->email->subject('WHOLESALE USER IS ON LINE - '.strtoupper($this->webspace_details->name));
			$this->email->message($email_message);

			// email class has a security error
			// "idn_to_ascii(): INTL_IDNA_VARIANT_2003 is deprecated"
			// using the '@' sign to supress this
			// must resolve pending update of CI
			@$this->email->send();
		}
	}

	// --------------------------------------------------------------------

}
