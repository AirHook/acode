<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_thumb_price extends Admin_Controller {

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
	public function index($prod_no = '', $color_code = '')
	{
		if ($prod_no == '') 
		{
			die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
		}
		
		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		
		// intialize class
		$params = 
			$color_code != ''
			? array('tbl_product.prod_no'=>$prod_no, 'color_code'=>$color_code)
			: array('tbl_product.prod_no'=>$prod_no)
		;
		if ( ! $this->product_details->initialize($params))
		{
			echo 'false';
			exit;
		}
		
		// set image name
		$img_name = $this->product_details->prod_no.'_'.$this->product_details->color_code;
		
		// get thumb if color_code is specified as $param
		if ($color_code)
		{
			$thumb_icon = $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$img_name.'_f1.jpg';
		}
		else
		{
			// get available colors in array
			$colors = $this->product_details->available_colors();
			
			if ($colors && count($colors) == 1)
			{
				$thumb_icon = $this->config->item('PROD_IMG_URL').$this->product_details->media_path.$img_name.'_f1.jpg';
			}
			else $thumb_icon = '';
		}
		
		// collate data into an array
		$array = array(
			'thumb_icon' => $thumb_icon,
			'unit_price' => $this->product_details->wholesale_price
		);
		
		header('Content-Type: application/json');
		echo json_encode($array);
		exit;
	}
	
	// ----------------------------------------------------------------------
	
}