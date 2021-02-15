<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add extends Admin_Controller {

	/**
	 * DB Reference
	 *
	 * @var	object
	 */
	protected $DB;

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - Activate Account
	 *
	 * @return	void
	 */
	public function index()
	{
		echo 'Processing...';

		// insert record
		$post_ary = $this->input->post();
		// set necessary variables
		//$post_ary['account_status'] = '1';
		// process some variables
		$post_ary['color_name'] = strtoupper($post_ary['color_name']);
		// unset unneeded variables
		//unset($post_ary['table']);

		// let us check if color_code already exists
		if ($this->_check_color_code($post_ary['color_code']))
		{
			// color code exists, return and set error
			// set flash data
			$this->session->set_flashdata('error', 'color_exists');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'products/color_variants');
		}

		// let us check if color_name already exists
		if ($this->_check_color_name($post_ary['color_name']))
		{
			// color code exists, return and set error
			// set flash data
			$this->session->set_flashdata('error', 'color_exists');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'products/color_variants');
		}

		$query = $this->DB->insert('tblcolor', $post_ary);

		// set flash data
		$this->session->set_flashdata('success', 'add');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'products/color_variants');
	}

	// ----------------------------------------------------------------------

	/**
	 * Private - Check Color Code
	 *
	 * @return	boolean
	 */
	private function _check_color_code($color_code)
	{
		$query = $this->DB->get_where('tblcolor', array('color_code'=>$color_code));

		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else return FALSE;
	}

	// ----------------------------------------------------------------------

	/**
	 * Private - Check Color Code
	 *
	 * @return	boolean
	 */
	private function _check_color_name($color_name)
	{
		$query = $this->DB->get_where('tblcolor', array('color_name'=>$color_name));

		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else return FALSE;
	}

	// ----------------------------------------------------------------------

}
