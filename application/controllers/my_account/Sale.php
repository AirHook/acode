<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Sale extends MY_account_Controller{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('my_account/auth');
		}
		$this->load->library('sales_orders/sales_orders_list');
	}
	public function index(){
		$data['active']='sales';
		$where['tbladmin_sales.admin_sales_id']=$this->session->userdata('admin_sales_id');
		$data['sale_order']=$this->sales_orders_list->select($where);
		$this->displayView('my_account/sales/sale_order_list',$data);
	}
}