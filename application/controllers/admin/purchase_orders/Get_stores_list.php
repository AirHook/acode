<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_stores_list extends Admin_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		if ( ! $this->input->post('designer'))
		{
			// nothing more to do...
			echo '';
			exit;
		}

		// grab the post variable
		//$designer = 'basixblacklabel';
		$designer = $this->input->post('designer');

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_users_list');

		// get the list
		$stores = $this->wholesale_users_list->select(
			array(
				'tbluser_data_wholesale.reference_designer' => $designer
			)
		);

		$html = '';
		if ($stores)
		{
			$html.= '<option class="option-placeholder" value="">Select Store...</option>';

			foreach ($stores as $store)
			{
				$html.= '<option value="'
					.$store->user_id
					.'" data-subtext="<em>'
					.$store->email
					.'</em>" data-des_slug="'
					.$store->reference_designer
					.'" '
					.($store->user_id === $this->session->admin_po_store_id ? 'selected="selected"' : '')
					.'>'
					.ucwords(strtolower($store->store_name))
					.'</option>'
				;
			}
		}

		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
