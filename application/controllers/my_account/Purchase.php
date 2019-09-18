<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Purchase extends MY_account_Controller{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('my_account/auth');
		}
		$this->load->library('purchase_orders/purchase_orders_list');
	}
	public function index(){
		$data['active']='purchase';
		$where['purchase_orders.user_id']=$this->session->userdata('admin_sales_id');
		$data['purchase_order']=$this->purchase_orders_list->select($where);
		// debug($data['purchase_order']);
		$this->displayView('my_account/purchase/purchase_order_list',$data);
	}
	public function detail($po_id='')
	{
		if (!$po_id)
		{
			$this->session->set_userdata('errors', 'Purchase order ID is required');
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['active']='purchase';
		// load pertinent library/model/helpers
		$this->load->library('products/size_names');
		$this->load->library('products/product_details');
		$this->load->library('purchase_orders/purchase_order_details');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('users/vendor_user_details');
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
		// initialize purchase order properties and items
		$data['po_details'] = $this->purchase_order_details->initialize(
			array(
				'po_id' => $po_id
			)
		);
		// get po items and other array stuff
		$data['po_items'] = $this->purchase_order_details->items;
		$data['po_options'] = $this->purchase_order_details->options;
		// get vendor details
		$data['vendor_details'] = $this->vendor_user_details->initialize(
			array(
				'vendor_id' => $this->purchase_order_details->vendor_id
			)
		);
		// get author details
		$data['author'] = $this->sales_user_details->initialize(
			array(
				'admin_sales_id' => $this->purchase_order_details->author
			)
		);
		// get ship to details
		if (isset($data['po_options']['po_store_id']))
		{
			$data['store_details'] = $this->wholesale_user_details->initialize(
				array(
					'user_id' => $data['po_options']['po_store_id']
				)
			);
		}
		else
		{
		 $data['store_details'] = $this->wholesale_user_details->deinitialize();
		}
		// debug($data['store_details']);
		$data['page_title'] = 'Purchase Order Details';
		$this->displayView('my_account/purchase/purchase_order_detail',$data);
	}
}