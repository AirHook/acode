<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_stores_list extends Sales_user_Controller {

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
			echo 'false';
			exit;
		}

		// grab the post variable
		$designer = $this->input->post('designer');

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_users_list');

		// get the list
		$stores = $this->wholesale_users_list->select(
			array(
				'reference_designer' => $designer
			)
		);

		if ($stores)
		{
			$html = '<option value="">Select Wholesale User...</option>';
			foreach ($stores as $user)
			{
				$subtext = '<em>'.ucwords(strtolower($user->firstname.' '.$user->lastname)).' ('.$user->email.')</em>';
				$html .= '<option value="'
					.$user->user_id
					.'" data-subtext="<em>'
					.$subtext
					.'</em>">'
					.ucwords(strtolower($user->store_name))
					.'</option>';
			}
		}
		else $html = 'false';

		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
