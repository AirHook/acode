<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apparel extends MY_Controller {

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
	 * @return	void
	 */
	public function index()
	{
		redirect('shop/categories');
	}
}
