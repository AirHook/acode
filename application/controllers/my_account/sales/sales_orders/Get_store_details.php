<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_store_details extends MY_Controller {

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

		// grab the post variable
		//$designer = 'basixblacklabel';
		$so_store_id = $this->input->post('so_store_id');

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');

		// get data
		$store_details = $this->wholesale_user_details->initialize(
			array(
				'user_id' => $so_store_id
			)
		);

		$html = '';
		if ($store_details)
		{
			$html.= $store_details->store_name
				.'<br />'
				.$store_details->address1
				.'<br />'
				.($store_details->address2 ? $store_details->address2.'<br />' : '')
				.$store_details->city.', '.$store_details->state.' '.$store_details->zipcode
				.'<br />'
				.$store_details->country
				.'<br />'
				.$store_details->telephone
				.'<br />ATTN: '
				.$store_details->fname.' '.$store_details->lname
				.' ('.$store_details->email.')'
			;

			// set session
			$this->session->set_userdata('so_user_id', $so_store_id);
			$this->session->set_userdata('so_user_cat', 'ws');
		}
		else
		{
			$html.= 'CUSTOMER NAME'
				.'<br />'
				.'Address1'
				.'<br />'
				.'Address2'
				.'<br />'
				.'City, State'
				.'<br />'
				.'Country'
				.'<br />'
				.'Telephone'
				.'<br />ATTN: Contact Name (email)'
			;

			// set session
			$this->session->unset_userdata('so_user_id');
			$this->session->unset_userdata('so_user_cat');
		}

		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
