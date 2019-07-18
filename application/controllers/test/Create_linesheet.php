<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_linesheet extends CI_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$img_name = 'AO111C_NAVY1';
		$img_path = 'product_assets/WMANSAPREL/andrewoutfitter/coats/';
		$prod_no = 'AO111C';
		$des_logo = 'assets/roden_assets/images/logo-andrewoutfitter.png';
		
				$this->load->library('image_lib');
				$config['image_library']	= 'gd2';
				$config['quality']			= '100%';
				$config['source_image'] 	= $des_logo;
				$config['new_image'] 		= $des_logo;
				$config['maintain_ratio'] 	= TRUE;
				$config['width']         	= 292;
				$config['height']       	= 47;
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();
				
		// create linesheet
		$this->load->helper('create_linesheet');
		if ($img_info = GetImageSize($img_path.'product_front/'.$img_name.'.jpg'))
		{
			$create = create_linesheet(
				$img_info,
				$prod_no,
				$img_path,
				$img_name,
				$des_logo
			);
		}
	}
}
