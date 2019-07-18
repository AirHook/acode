<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete extends Admin_Controller {

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
	 * Index - Delete Item
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'categories');
		}
		
		// load libraries/models/helpers
		$this->load->library('categories/categories_tree');
		
		// change levels of children where necessary
		// negative number means level down, otherwise level up
		$this->categories_tree->children_change_level($id, $levels = 1, TRUE);
		
		// delete item from records
		$this->DB->where('category_id', $id);
		$this->DB->delete('categories');
		
		// set flash data
		$this->session->set_flashdata('success', 'delete');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'categories');
	}
	
	// ----------------------------------------------------------------------
	
}