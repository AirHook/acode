<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Units extends MY_Controller{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('auth');
		}
		$this->load->model('common_model');
	}
	public function index(){
	}
	public function getUnassignedunits(){
		if($this->input->post()){
			$product_id=$this->input->post('product_id');
			$company_id=$this->company_id;
			$query="SELECT * FROM tbl_uom WHERE company_id=$company_id AND id NOT IN (SELECT UOMId FROM tbl_purchasepricelist WHERE productName=$product_id)";
			$data=$this->common_model->universal($query)->result();
			echo json_encode($data);exit();
		}
	}
}