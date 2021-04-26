<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset extends Admin_Controller {

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
	 * This method simply lists all lookbooks
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		if ($id)
		{
			// remove po mod details
			unset($_SESSION['admin_lb_mod_id']);
			unset($_SESSION['admin_lb_mod_items']);
			unset($_SESSION['admin_lb_mod_slug_segs']);
			unset($_SESSION['admin_lb_mod_options']);
			unset($_SESSION['admin_lb_mod_des_slug']);

			redirect($this->config->slash_item('admin_folder').'campaigns/lookbook/modify/index/'.$id, 'location');
		}
		else
		{
			// reset sessions
			unset($_SESSION['admin_lb_id']);
			unset($_SESSION['admin_lb_des_slug']);
			unset($_SESSION['admin_lb_slug_segs']);
			unset($_SESSION['admin_lb_items']);
			unset($_SESSION['admin_lb_name']);
			unset($_SESSION['admin_lb_email_subject']);
			unset($_SESSION['admin_lb_email_message']);
			unset($_SESSION['admin_lb_options']);

			redirect($this->config->slash_item('admin_folder').'campaigns/lookbook/create', 'location');
		}
	}

	// ----------------------------------------------------------------------

}
