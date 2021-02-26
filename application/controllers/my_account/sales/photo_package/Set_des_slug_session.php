<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_des_slug_session extends MY_Controller {

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
	 * Index - Set As Default
	 *
	 * Sets selected sales package as default sales package for the Send Sales Package
	 * button on the Wholesale User list actions column
	 *
	 * @return	void
	 */
	public function index($slug = '')
	{
		$this->output->enable_profiler(FALSE);

		if ( ! $slug)
		{
			// nothing more to do...
			echo 'error';
			exit;
		}

		// set active designer slug and designer list
		// this is usually access by hub sites for active designer list
		// drop down to select designer thumbs
		$this->session->sa_pp_des_slug = $slug;
		if ($this->session->sa_pp_designers)
		{
			array_push($this->session->sa_pp_designers, $des_slug);
		}
		else $this->session->sa_pp_designers = array($des_slug);

		// return
		echo 'success';
		exit;
	}

	// ----------------------------------------------------------------------

}
