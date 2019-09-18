<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends MY_account_Controller{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('my_account/auth');
		}
		$this->load->library('sales_orders/sales_orders_list');
		$this->load->library('purchase_orders/purchase_orders_list');
	}
	public function index(){
		$data['active']='dashboard';
		$where['tbladmin_sales.admin_sales_id']=$this->session->userdata('admin_sales_id');
		$data['sale_order']=$this->sales_orders_list->select($where,10);
		$where2['purchase_orders.user_id']=$this->session->userdata('admin_sales_id');
		$data['purchase_order']=$this->purchase_orders_list->select($where2,10);
		$this->displayView('my_account/dashboard',$data);
	}
}