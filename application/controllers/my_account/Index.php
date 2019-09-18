<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index extends MY_account_Controller
{
	public function __construct()
	{
		parent::__construct();
    }
	// ----------------------------------------------------------------------
	public function index()
	{
		redirect(base_url('my_account/auth'));
	}
}
