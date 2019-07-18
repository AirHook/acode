<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Returns extends Admin_Controller {

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
	public function index($id = '', $remarks = '')
	{
		if ( ! $id OR ! $remarks)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'orders');
		}
		
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		
		switch ($remarks)
		{
			case 'exchange':
				$DB->set('remarks', '1');
			break;
			case 'scredit':
				$DB->set('remarks', '2');
			break;
			case 'refund':
				$DB->set('remarks', '3');
			break;
			case 'others':
				$DB->set('remarks', '4');
				$DB->set('comments', $_POST['comments']);
			break;
			default:
				$DB->set('remarks', '0');
		}
		
		$DB->where('order_log_id', $id);
		$DB->update('tbl_order_log');
		
		// set flash data
		$this->session->set_flashdata('success', 'edit');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'orders/details/index/'.$id, 'location');
	}
	
	// ----------------------------------------------------------------------
	
}