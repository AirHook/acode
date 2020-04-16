<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_add extends Admin_Controller {

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
		//$post_ary['color_name'] = strtoupper($post_ary['color_name']);
		// unset unneeded variables
		//unset($post_ary['table']);

		if (
			! $post_ary['email']
			&& ! $post_ary['fname']
			&& ! $post_ary['lname']
		)
		{
			$this->session->set_flashdata('error', 'edit');

			// redirect user
			redirect('admin/task_manager/users');
		}

		$query = $this->DB->insert('tm_users', $post_ary);

		// set flash data
		if ($query)
		{
			$this->session->set_flashdata('success', 'add');
		}
		else
		{
			$this->session->set_flashdata('error', 'add');
		}

		// redirect user
		redirect('admin/task_manager/users');
	}

	// ----------------------------------------------------------------------

}
