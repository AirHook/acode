<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chats_add extends Admin_Controller {

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

		if (
			! $this->input->post('message')
			&& ! $this->input->post('user_id')
		)
		{
			$this->session->set_flashdata('error', 'edit');

			// redirect user
			redirect('admin/task_manager/task_details/index/'.$this->input->post('task_id'), 'location');
		}

		// grab post data
		$post_ary = $this->input->post();
		// set necessary variables
		$post_ary['date_sent'] = time();
		// process some variables
		//$post_ary['date_end_target'] = strtotime($this->input->post('due_date'));
		// unset unneeded variables
		//unset($post_ary['due_date']);

		$query = $this->DB->insert('tm_chats', $post_ary);

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
		redirect('admin/task_manager/task_details/index/'.$this->input->post('task_id'), 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * Index - Activate Account
	 *
	 * @return	void
	 */
	public function aja_x()
	{
		// grab post data
		$post_ary = $this->input->post();

		//$post_ary['message'] = 'Testing';
		//$post_ary['user_id'] = '2';

		$data = array();

		if (
			! $post_ary['message']
			&& ! $post_ary['user_id']
		)
		{
			// error...
			$data['status'] = 'error';
			$data['error'] = 'No data post';
		}

		// set necessary variables
		$post_ary['date_sent'] = time();
		// process some variables
		//$post_ary['date_end_target'] = strtotime($this->input->post('due_date'));
		// unset unneeded variables
		//unset($post_ary['due_date']);

		$query = $this->DB->insert('tm_chats', $post_ary);

		// set flash data
		if (@$query)
		{
			$data['status'] = 'success';

			$q2 = $this->DB->get_where('tm_users', array('id'=>$post_ary['user_id']));
			$row = $q2->row();

			$data['name'] = $row->fname.' '.$row->lname;
			$data['message'] = $post_ary['message'];
			$data['date'] = date('g:i a', $post_ary['date_sent']).' Today';
		}
		else
		{
			$data['status'] = 'error';
			$data['error'] = 'DB Insert error';
			$data['details'] = $this->DB->error();
		}

		echo json_encode($data);
		exit;
	}

	// ----------------------------------------------------------------------

}
