<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_item_new_price extends MY_Controller {

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
	 * Index - Sales Package View
	 *
	 * Open and view existing sales package for edit/sending
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		if ( ! $this->input->post())
		{
			// nothing more to do...
			echo 'There is no post data.';
			exit;
		}

		// grab the post variable
		$item = $this->input->post('item');
		$price = $this->input->post('price');
		$page = $this->input->post('page');

		// grab the options array
		$options_array =
			$page == 'create'
			$this->session->admin_sa_options
			? json_decode($this->session->admin_sa_options, TRUE)
			: array()
		;
		$options_array =
			$page == 'create'
			? json_decode($this->session->admin_lb_options, TRUE)
			: (
				$this->session->admin_lb_mod_items
				? json_decode($this->session->admin_lb_mod_options, TRUE)
				: array()
			)
		;

		// re-setting 'w_prices' options just to be sure
		$options_array['w_prices'] = '1';

		// save new edited price
		$options_array['e_prices'][$item] = $price;

		// reset session value for items array
		if ($this->input->post('page') == 'create')
		{
			$this->session->set_userdata('admin_lb_options', json_encode($options_array));
		}
		if ($this->input->post('page') == 'modify')
		{
			$this->session->set_userdata('admin_lb_mod_options', json_encode($options_array));
		}

		exit;
	}

	// ----------------------------------------------------------------------

}
