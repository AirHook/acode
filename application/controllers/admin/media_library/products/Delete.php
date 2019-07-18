<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete extends Admin_Controller {

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
	 * @return	void
	 */
	public function index($media_id, $attached = FALSE)
	{
		// load pertinent library/model/helpers
		$this->load->library('image_lib');
		$this->load->model('media_library');
		
		// get details
		if ($media_details = $this->media_library->get_media_details(array('media_id'=>$media_id)))
		{
			/*
			// unlink all related images
			*/
			
			// set path
			$year = date('Y', $media_details->timestamp);
			$mo = date('m', $media_details->timestamp);
			$image_path = 'uploads/products/'.$year.'/'.$mo.'/';
			
			// original file uploaded
			if (file_exists($image_path.$media_details->media_filename)) 
				unlink($image_path.$media_details->media_filename);
			if ($media_details->upload_version)
			{
				// thumb
				if (file_exists($image_path.$media_details->media_name.'_u'.$media_details->upload_version.'_thumb.jpg')) 
					unlink($image_path.$media_details->media_name.'_u'.$media_details->upload_version.'_thumb.jpg');
			}
			else
			{
				// thumb
				if (file_exists($image_path.$media_details->media_name.'_thumb.jpg')) 
					unlink($image_path.$media_details->media_name.'_thumb.jpg');
			}
			if ($attached)
			{
				// coloricon
				if (file_exists($image_path.$media_details->media_name.'_c.jpg')) 
					unlink($image_path.$media_details->media_name.'_c.jpg');
				// main view image
				if (file_exists($image_path.$media_details->media_name.'_'.strtolower($media_details->media_view[0]).'.jpg')) 
					unlink($image_path.$media_details->media_name.'_'.strtolower($media_details->media_view[0]).'.jpg');
				// crunched images
				if (file_exists($image_path.$media_details->media_name.'_'.strtolower($media_details->media_view[0]).'1.jpg')) 
					unlink($image_path.$media_details->media_name.'_'.strtolower($media_details->media_view[0]).'1.jpg');
				if (file_exists($image_path.$media_details->media_name.'_'.strtolower($media_details->media_view[0]).'2.jpg')) 
					unlink($image_path.$media_details->media_name.'_'.strtolower($media_details->media_view[0]).'2.jpg');
				if (file_exists($image_path.$media_details->media_name.'_'.strtolower($media_details->media_view[0]).'3.jpg')) 
					unlink($image_path.$media_details->media_name.'_'.strtolower($media_details->media_view[0]).'3.jpg');
				if (file_exists($image_path.$media_details->media_name.'_'.strtolower($media_details->media_view[0]).'4.jpg')) 
					unlink($image_path.$media_details->media_name.'_'.strtolower($media_details->media_view[0]).'4.jpg');
				// linesheet
				if (file_exists($image_path.$media_details->media_name.'_linesheet.jpg')) 
					unlink($image_path.$media_details->media_name.'_linesheet.jpg');
			}
			
			// connect to database
			$DB = $this->load->database('instyle', TRUE);
			
			// delete from record
			$q = $DB->delete('media_library_products', array('media_id' => $media_id));
			
			// set flash data
			$this->session->set_flashdata('success', 'delete');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'media_library/products', 'location');
		}
		else
		{
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'media_library/products', 'location');
		}
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Suspend Vendor To Odoo via API
	 *
	 * @access 	private
	 * @return	void
	 */
	private function _delete_product_to_odoo($id)
	{
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		// 
		$api_url = 'http://70.32.74.131:8069/api/delete/product/'.$id; // base_url('test/test_ajax_post_to_odoo')
		$api_key = $this->config->item('odoo_api_key');
		if ($api_url != '')
		{
			// set post fields
			$post['client_api_key'] = $api_key;
			$post['prod_id'] = $id;
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $api_url);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			// execute
			$response = curl_exec($ch);
			// for debugging purposes, check for response
			/*
			if($response === false)
			{
				//echo 'Curl error: ' . curl_error($ch);
				// set flash data
				$this->session->set_flashdata('error', 'post_data_error');
				$this->session->set_flashdata('error_value', curl_error($ch));
				
				redirect($this->config->slash_item('admin_folder').'users/vendor/edit/index/'.$id, 'location');
			}
			*/

			// close the connection, release resources used
			curl_close ($ch);
		}
	}
	
	// ----------------------------------------------------------------------
	
}
