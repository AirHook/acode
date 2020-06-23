<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend_Controller extends MY_Controller {

	/**
	 * Core Controller for Frontend
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// load pertinent library/model/helpers
		$this->load->library('designers/designer_details');
		$this->load->library('categories/categories_tree');
		$this->load->library('designers/designers_list');
		$this->load->library('users/wholesale_user_details');

		// get the designers list
		// for hub sites, practically generates the designers list
		// 		- used also for header designer logo slider
		// for sat and sal sites, it just results to the one designer
		$this->data['designers'] =
			$this->designers_list->select((
				$this->webspace_details->options['site_type'] != 'hub_site'
				? array('designer.url_structure'=>$this->webspace_details->slug)
				: array(
					'designer.view_status' => 'Y'
				)
			));

		// get the category tree
		// for top nav, changes to designer specific category list
		// for side nav, list all categories and list on a per designer basis
		// each use can be filtered to accommodate the requirements like being
		//		designer specific
		// can be used for other purposes as well
		$cat_ary =
			$this->webspace_details->options['site_type'] != 'hub_site'
			? array(
				'd_url_structure' => $this->webspace_details->slug,
				'view_status' => '1',
				'with_products' => TRUE
			)
			: array(
				'view_status' => '1',
				'with_products' => TRUE
			)
		;
		$this->data['categories'] = $this->categories_tree->treelist(
			$cat_ary
		);
		// NOTE: use this variable for the total count of categories as
		// $this->categories_tree->row_count will be overwritten by succeeding
		// $this->categories_tree function/method calls below
		$this->data['number_of_categories'] = $this->categories_tree->row_count;

		// some category listing needed for the main menu lists
		$this->data['main_categories'] = $this->categories_tree->treelist(
			array(
				'category_level' => '1'
			)
		);
		// while we have identified the main categories under womens apparel
		// we will need to come up with a solution to decouple this system
		$this->data['dresses_subcats'] = $this->categories_tree->get_children('161');
		$this->data['bottoms_subcats'] = $this->categories_tree->get_children('185');
		$this->data['tops_subcats'] = $this->categories_tree->get_children('133');
		$this->data['outerwear_subcats'] = $this->categories_tree->get_children('187');
		$this->data['accessories_subcats'] = $this->categories_tree->get_children('174');

		// in the event that there are no categories available yet,
		// we redirect the user to contacts page and show a notice
		if (
			! $this->data['categories']
			&& $this->uri->uri_string() != 'contact'
		)
		{
			// set flash data
			$this->session->set_flashdata('flashMsg', 'There are no categories availabe yet. Please contact us here for further inquiries.');

			// redirect to categories page
			redirect('contact', 'location');
		}

		// if there is no categories with products, then we can't show the categories page
		// right now, categories page being home page is forces at contorller/index.php
		// we need to check webspace options if home page is set to product categories page
		// before we check for categories with products
		if (
			(
				$this->webspace_details->options['site_type'] == 'sat_site'
				OR $this->webspace_details->options['site_type'] == 'sal_site'
			)
			&& ! $this->categories_tree->treelist(array(
				'view_status' => '1',
				'd_url_structure' => $this->webspace_details->slug, // vital for sat and sal sites
				'with_products' => TRUE
			))
			&& $this->uri->uri_string() !== 'contact'
		)
		{
			// set flash data
			$this->session->set_flashdata('flashMsg', 'Something went wrong with the product listing. Please contact us here for querries.');

			redirect('contact');
		}

		// a work around on product details page cloud zoom causing page load twice
		if (
			$this->session->prod_details_prod_no != $this->uri->segment(4)
		)
		{
			if (isset($_SESSION['prod_details_prod_no'])) unset($_SESSION['prod_details_prod_no']);
		}


		// non accessible wholesale pages if not loggedin
		if (
			! $this->session->user_loggedin
			&& (
				// some wholesale pages
				$this->uri->uri_string() === 'wholesale/details'
				OR $this->uri->uri_string() === 'account/details'
			)
		)
		{
			// set flash notice
			$this->session->set_flashdata('sales_package_invalid_credentials', TRUE);

			// nothing more to do...
			redirect('account');
		}

		/**************
		 * Wholesale user loggedin snippets
		 */

		// Initialize wholesale user details for use widely on front end pages
		// Check for user inactivity, and, relapse or login user again accordingly
		// relapse uses the same logindata while login again uses a new logindata
		if (
			$this->session->user_loggedin
			&& $this->session->user_role == 'wholesale'
			// removing this exemption and considering all sites for wholesale logged in users
			/* *
			&& (
				$this->webspace_details->options['site_type'] == 'hub_site'
				OR $this->webspace_details->slug == 'tempoparis' // sal_site exemption
			)
			// */
		)
		{
			if ( ! $this->wholesale_user_details->initialize(array('user_id'=>$this->session->user_id)))
			{
				// in case re-initialization of wholesale user details went wrong
				// i.e., cases where user id in session got lost, or, the record was deleted
				// manually logout user here to remove previous records, and
				// redirect to signin page
				$this->wholesale_user_details->initialize();
				$this->wholesale_user_details->unset_session();

				// destroy any cart items
				$this->cart->destroy();

				// set flash data
				$this->session->set_flashdata('flashMsg', 'Something went wrong with your connection. Please login again');

				// redirect to categories page
				redirect(site_url('account'), 'location');
			}

			// NOTE: login details are recorded on a per page visits and product clicks
			// Thus, $this->wholesale_user_details->update_login_detail is called on
			// controllers and page controllers
			// For other pages, it is set within the class Frontend Controller

			// let us check for wholesale user inactivity lapse
			// otherwise, continue with activity and set
			// session variable ws_last_active_time to now
			$lapsed_time = time() - $this->session->ws_last_active_time;
			// if ($lapsed_time > $this->wholesale_user_details->session_lapse)

			// changing this $lapsed_time to daily
			// so that product clicks and page visits are recorded on a daily basis
			// so that it will reflect on report
			// in which case, we will need to relog the user
			$string_today = date('Y-m-d', time());
			$timestamp_today = strtotime($string_today);

			// if it's a new day...
			if ($this->session->ws_last_active_time < $timestamp_today)
			{
				// capture access uri
				//$_SESSION['access_uri'] = $this->uri->uri_string();
				$this->session->set_userdata('access_uri', $this->uri->uri_string());
				$this->session->mark_as_flash('access_uri');

				// if more than 3 days (259200), log out user
				if ($lapsed_time > $this->wholesale_user_details->days_lapse)
				{
					$this->session->set_flashdata('days_lapsed', TRUE);
					redirect('account/logout', 'location');
				}

				// show the ws lapse popup dailog
				//$_SESSION['popup_ws_lapse_dialog'] = TRUE;
				$this->session->set_userdata('popup_ws_lapse_dialog', TRUE);
				$this->session->mark_as_flash('popup_ws_lapse_dialog');
			}
			else
			{
				//$_SESSION['ws_last_active_time'] = time();
				$this->session->set_userdata('ws_last_active_time', time());
				$this->wholesale_user_details->update_login_detail(array($this->session->ws_last_active_time), 'active_time');
			}

			$this->data['logindata'] = $this->wholesale_user_details->get_logindata();
		}

		// if not within shop/ class directory,
		// we can add page visits for wholesale users for other pages here
		// this controller renders designer categories thumbs page
		if (
			$this->session->user_loggedin
			&& $this->session->user_role == 'wholesale'
			&& $this->session->this_login_id
			&& (
				$this->uri->segment(1) != ''
				&& $this->uri->segment(1) != 'shop'		// this will be handled by shop/index controller
				&& $this->uri->segment(1) != 'admin'
				&& $this->uri->segment(1) != 'cart'		// we will have something for this pages for stats
				&& $this->uri->segment(1) != 'cronjobs'
				&& $this->uri->segment(1) != 'resource'
				&& $this->uri->segment(1) != 'sales'
				&& $this->uri->segment(1) != 'test'
				&& $this->uri->segment(1) != 'wholesale'
				&& $this->uri->segment(1) != 'welcome'
			)
		)
		{
			// update login details
			if ( ! $this->wholesale_user_details->update_login_detail(array($this->uri->uri_string(), 1), 'page_visits'))
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
		}

		// this is a hard code
		// set occassions facet on DRESSES menu drop down
		// hence we need to get occassions facet universally
		$config['category_id'] = '161'; // cat_id of 'dresses'
		$this->load->library('facets', $config);
		$this->load->helper('facets');
		// to avoid collussion with 'occassion_array' on SHOP controller,
		// we use a differenct variable
		$this->data['occassion_ary'] = extract_facets($this->facets->get('events'), 'events');
    }

	// --------------------------------------------------------------------

}
