<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/accounting/ERPController.php");
class Index extends ERPController {
	public function __construct()
	{
		parent::__construct();
    }
	// ----------------------------------------------------------------------
	public function index()
	{
		redirect(base_url('accounting/auth'));
	}
}
