<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/***********
 * Sales Program Controller
 *
 * LINESHEET SENDING
 * 		Selected items are saved as:
 *			$this->sales_user_details->options['selected']
 * 		Edited prices for selected linesheets are saved sa:
 *			$this->sales_user_details->options['edited_prices']
 * 		Linesheet sending history is saved as:
 *			$this->sales_user_details->options['linesheet_history']
 *			with the following array arrangement:
 *				array['date']=>(
 *					array['items']=>'Item1, Item2, ...',
 *					array['name']=>'Name',
 *					array['email']=>'Email',
 *					array['store_name']=>'Store Name'
 *				)
 *
 *		On theme default, selected items (and edited prices) are directly used and is also stored
 *		on session $this->session->userdata('sales_package_items'). History is not used on this
 *		theme.
 *
 *		On roden2, all three are used. History is automatically loaded at view file.
 *
 *
 */
class Sales_Controller extends MY_Controller {

	/**
	 * Core Controller for Sales Program
	 */
	public function __construct()
	{
		parent::__construct();

		/***********
		 * sale program theme
		 * will need to make this editable via admin
		 * temporarily this is here only because this sales theme is still independent of webspace theme
		 * need to add an options['sales_theme'] to webspace details to take care of this.
		 * meantime, we set a default sales them variable such that in the process where no
		 * options['sales_theme'] is already available, we don't need to edit as much on all
		 * controller and view files
		 *
		 */
		// current options:
		//$this->data['sales_theme'] = $this->webspace_details->options['sales_theme']; // not yet available
		$this->data['sales_theme'] = 'metronic'; // 'metronic', 'default'
		//$this->data['sales_theme'] = $this->webspace_details->options['theme'];

		// load pertinent libraries/models/helpers
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('users/sales_user_details');
		$this->load->library('designers/designers_list');
		$this->load->library('categories/categories_tree');


		// ...is there a session for admin sales already?
		if ( ! $this->session->userdata('admin_sales_loggedin'))
		{
			// let us remember the page being accessed other than index
			$this->session->set_flashdata('access_uri', $this->uri->uri_string());

			// set flash message
			$this->session->set_flashdata('error', 'unauthenticated');

			// redirect user
			redirect('resource', 'location');
		}


		// initialize user via availabe session
		if (
			! $this->sales_user_details->initialize(array(
				'admin_sales_id' => $this->session->userdata('admin_sales_id')
			))
		)
		{
			// if something goes wrong with the session information
			// set flash message
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('resource', 'location');
		}

		// let's grab the uri segments
		$this->session->set_flashdata('thumbs_uri_string', $this->uri->uri_string());
		$this->data['url_segs'] = explode('/', $this->uri->uri_string());

		// let's remove the segments (up to controller class method/function)
		// and parameters from the resulting array
		if (
			$this->uri->segment(2) === 'dashboard'
			OR $this->uri->segment(2) === 'sales_package'
		)
		{
			array_shift($this->data['url_segs']); // sales
			array_shift($this->data['url_segs']); // dashboard
		}
		else
		{
			array_shift($this->data['url_segs']); // sales
			array_shift($this->data['url_segs']); // create
			array_shift($this->data['url_segs']); // step1
		}

		/*****
		 * Get the categories tree list for the side bar
		 */
		$cat_ary = array(
 			'd_url_structure' => $this->sales_user_details->designer,
 			'view_status' => '1',
 			'with_products' => TRUE
 		);
 		$this->data['categories'] = $this->categories_tree->treelist(
 			$cat_ary
 		);
		$this->data['number_of_categories'] = $this->categories_tree->row_count;

		/*****
		 * ...limiting session time
		 * # of days can be set at Sales User Details class - $this->sales_user_details->session_lapse
		 * or, you may use the $config['sess_expiration'] from config.php file
		 */
		if ((
				! $this->session->userdata('admin_sales_login_time')
				OR (($this->session->userdata('admin_sales_login_time') + $this->config->item('sess_expiration')) < time())
			)
			&& (
				$this->uri->uri_string() !== 'resource'
				&& $this->uri->uri_string() !== 'resource/forget_password'
			)
		)
		{
			// --> access not allowed when not logged in
			// destroy admin user session if any
			$this->sales_user_details->unset_session();
			$this->sales_user_details->set_initial_state();

			// let us remember the page being accessed other than index
			$this->session->set_flashdata('access_uri', $this->uri->uri_string());

			// set flash message
			$this->session->set_flashdata('error', 'time_lapse');

			// redirect user
			redirect('resource', 'location');
		}

		/*****
		 * Check for items in session
		 */
		// check for items in session
		$this->data['sa_items'] =
			$this->session->sa_items
			? json_decode($this->session->sa_items, TRUE)
			: array()
		;
		$this->data['sa_items_count'] = count($this->data['sa_items']);

		// check for po items in session
		$this->data['po_items'] =
			$this->session->po_items
			? json_decode($this->session->po_items, TRUE)
			: array()
		;
		$po_items_count = 0;
		foreach ($this->data['po_items'] as $key => $val)
		{
			if (is_array($val))
			{
				$po_items_count += array_sum($ary_val);
			}
			else $po_items_count += 1;
		}
		$this->data['po_items_count'] = $po_items_count;
		$this->data['po_size_qty'] =
			$this->session->po_size_qty
			? json_decode($this->session->po_size_qty, TRUE)
			: array()
		;







		/*****
		 * ...we need to check if the sales user's reference designer has products or not
		 * NOTE: as long as the sales user reference designer is not the hub site
		 */
		if (
			$this->uri->uri_string() !== 'sales/logout'
		)
		{
			// get the designers list
			// for hub sites, practically generates the designers list
			// 		- used also for header designer logo slider
			// for sat and sal sites, it just results to the one designer
			$this->data['designers'] =
				$this->designers_list->select((
					$this->webspace_details->options['site_type'] != 'hub_site'
					? array(
						'designer.url_structure' => $this->sales_user_details->designer
					)
					: array(
						'designer.view_status' => 'Y'
					)
				));

			if ( ! $this->data['designers'])
			{
				$this->data['is_with_products'] = FALSE;

				// nothing more to do...
				$this->session->userdata('error_no_products', 'no_products');

				if ($this->uri->uri_string() !== 'sales/dashboard') redirect('sales/dashboard');
			}
			else
			{
				$this->data['is_with_products'] = TRUE;
				$this->session->unset_userdata('error_no_products');
				if (isset($_SESSION['error_no_products'])) unset($_SESSION['error_no_products']);
			}
		}
    }

	// ----------------------------------------------------------------------

	/**
	 * Scripts for Search
	 *
	 * @return	void
	 */
	public function search_autocomplete_scripts()
	{
		// added autocomplete.js for search queries
		$autocomplete_ja = '
			<style>
				.ui-autocomplete {
					max-height: 200px;
					overflow-y: auto;
					overflow-x: hidden;
					padding-bottom: 5px;
				}
				.ui-autocomplete li:nth-child(even) {
					background: #dddddd;
				}
			</style>
			<link rel="stylesheet" type="text/css" href="'.base_url('assets/custom').'/jscript/jquery-ui.min.css" />
			<script type="text/javascript" src="'.base_url('assets/custom').'/jscript/jquery-ui.min.js"></script>
			<script type="text/javascript">
				$().ready(function() {
					$(".search_by_prod_no").autocomplete({
						source: "'.site_url('sales/autocomplete_prod_no').'"
					}).each(function(){
						$(this).data("uiAutocomplete")._renderItem = function(ul, item) {
							var newText = String(item.value).replace(
								new RegExp(this.term, "gi"),
								"<strong>$&</strong>");
							return $("<li>")
								.append("<div>" + newText + "</div>")
								.appendTo(ul);
						};
					});
					$(".search_by_prod_no").blur(function(){
						$(this).val("");
					});
				});
			</script>
		';

		return $autocomplete_ja;
	}

	// --------------------------------------------------------------------

}
