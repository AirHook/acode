<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/accounting/ERPController.php");
class Dashboard extends ERPController{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('accounting/auth');
		}
	}
	public function index(){
		$data['active']='Dashboard';
		$data['module']='accounting';
		$this->load->model('sale_model');
		$data['sale_invoices'] = $this->sale_model->getAll('tbl_salesinvoicemaster',array('company_id'=>$this->session->userdata('company_id'), 'is_deleted' => 0),array('created_on','desc'), 10);
		$query="SELECT product_id,SUM(qty) AS total_qty  FROM tbl_stockdetails WHERE company_id = $this->company_id  GROUP BY product_id";
		$data['product_less_reorder_level']=$this->common_model->universal($query)->result();
		$products=[];
		$stock=[];
		if(!empty($data['product_less_reorder_level'])){
			foreach($data['product_less_reorder_level'] as $key => $value) {
				if(isset($value->product_id)){
					$query2="SELECT * FROM tbl_product WHERE id = $value->product_id AND company_id = $this->company_id AND reorder_level >= $value->total_qty";
					$product_details=$this->common_model->universal($query2)->row();
					if(!empty($product_details)){
						$products[$key]=$product_details;
						$products[$key]->stock_qty=$value->total_qty;
					}
					$query3="SELECT * FROM tbl_product WHERE id = $value->product_id AND company_id = $this->company_id AND minimumStock >= $value->total_qty";
					$product_stock_details=$this->common_model->universal($query3)->row();
					if(!empty($product_stock_details)){
						$stock[$key]=$product_stock_details;
						$stock[$key]->stock_qty=$value->total_qty;
					}
				}
			}
			$data['products']=$products;
			$data['stock']=$stock;
		}
		if(!$this->has_access_of('view_dashboard')){
			$this->displayView('accounting/has_not_access_dashboard',$data);
		}else{
			$this->displayView('accounting/dashboard',$data);
		}
	}
	public function getDashTabsData() {
		if($this->input->post('activeTab')) {
			$view = $this->input->post('activeTab');
			$labels = array();
			$sales = array();
			$purchases = array();
			$start = null;
			$end = null;
			if($view == 'day') {
				$start = date('Y-m-d');
				$end = $start;
			} else if($view == 'week') {
				$start = date("Y-m-d", strtotime('monday this week'));
				$end = date("Y-m-d", strtotime('sunday this week'));
			} else if($view == 'month')  {
				$start = date('Y-m-01');
				$end = date('Y-m-t');
			} else {
				$start = date('Y-01-01');
				$end = date('Y-12-31');
			}
			$this->load->model('reports_model');
			$data = array();
			$data['total_sales'] = $this->reports_model->sumTotal('tbl_salesinvoicemaster', "DATE_FORMAT(created_on, '%Y-%m-%d') >= '".$start."' AND DATE_FORMAT(created_on, '%Y-%m-%d') <= '".$end."' AND is_deleted = 0");
			$data['total_purchases'] = $this->reports_model->sumTotal('tbl_purchaseinvoicemaster', "DATE_FORMAT(created_on, '%Y-%m-%d') >= '".$start."' AND DATE_FORMAT(created_on, '%Y-%m-%d') <= '".$end."' AND is_deleted = 0");
			$expenses = $this->reports_model->sumExpenses("DATE_FORMAT(B.created_on, '%Y-%m-%d') >= '".$start."' AND DATE_FORMAT(B.created_on, '%Y-%m-%d') <= '".$end."'");
			$expenses = explode('-', $expenses);
			$expense_amount = $this->priceValue($expenses[0]);
			if(isset($expenses[1]))
				$expense_amount .= $expenses[1];
			
			$stock = $this->reports_model->getStockValue();
			$data['total_sales'] = $this->priceValue($data['total_sales']);
			$data['total_purchases'] = $this->priceValue($data['total_purchases']);
			$data['total_expenses'] = $expense_amount;
			$data['stock_value'] = $this->priceValue($stock);
			$this->load->model('sale_model');
			echo json_encode($data);
			exit();
		}
	}
	public function getSalePurchaseChartData() {
		if($this->input->post('activeTab')) {
			$view = $this->input->post('activeTab');
			$labels = array();
			$sales = array();
			$purchases = array();
			$start = null;
			$end = null;
			if($view == 'day') {
				$start = date('Y-m-d 00:00:00');
				$end = date('Y-m-d 23:59:59');
			} else if($view == 'week') {
				$start = date("Y-m-d", strtotime('monday this week'));
				$end = date("Y-m-d", strtotime('sunday this week'));
			} else if($view == 'month')  {
				$start = date('Y-m-01');
				$end = date('Y-m-t');
			} else {
				$start = date('Y-01-01');
				$end = date('Y-12-31');
			}
			$this->load->model('reports_model');
			$current = strtotime($start);
			$end = strtotime($end);
			while ($current <= $end) {
				if($view == 'year') {
					$month_start = date('Y-m-01', $current);
					$month_end = date('Y-m-t', $current);
					$sale = (float)$this->reports_model->sumTotal('tbl_salesinvoicemaster', "DATE_FORMAT(created_on, '%Y-%m-%d') >= '".$month_start."' AND DATE_FORMAT(created_on, '%Y-%m-%d') <= '".$month_end."'");
					$purchase = (float)$this->reports_model->sumTotal('tbl_purchaseinvoicemaster', "DATE_FORMAT(created_on, '%Y-%m-%d') >= '".$month_start."' AND DATE_FORMAT(created_on, '%Y-%m-%d') <= '".$month_end."'");
					array_push($sales, $sale);
					array_push($purchases, $purchase);
					array_push($labels, date('M', $current));
					$current = strtotime('+1 month', $current);
				} else if($view == 'day') {
					$sale = (float)$this->reports_model->sumTotal('tbl_salesinvoicemaster', "DATE_FORMAT(created_on, '%Y-%m-%d %H') = '".date('Y-m-d H', $current)."'");
					$purchase = (float)$this->reports_model->sumTotal('tbl_purchaseinvoicemaster', "DATE_FORMAT(created_on, '%Y-%m-%d %H') = '".date('Y-m-d H', $current)."'");
					array_push($sales, $sale);
					array_push($purchases, $purchase);
					array_push($labels, date('h A', $current));
					$current = strtotime('+1 hour', $current);
				} else {
					$sale = (float)$this->reports_model->sumTotal('tbl_salesinvoicemaster', "DATE_FORMAT(created_on, '%Y-%m-%d') = '".date('Y-m-d', $current)."'");
					$purchase = (float)$this->reports_model->sumTotal('tbl_purchaseinvoicemaster', "DATE_FORMAT(created_on, '%Y-%m-%d') = '".date('Y-m-d', $current)."'");
					array_push($sales, $sale);
					array_push($purchases, $purchase);
					array_push($labels, date('M d', $current));
					$current = strtotime('+1 day', $current);
				}
			}
			echo json_encode(array('sales' => $sales, 'purchases' => $purchases, 'labels' => $labels));
			exit();
		}
	}
	public function userProfile(){
		$data['active']='userProfile';
		$data['module']='accounting';
		$data['profile']=$this->common_model->getAll('users',array('id'=>$this->session->userdata('id')));
		$this->displayView('accounting/profile',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function contactUs(){
			$data['active']='contactUs';
			$data['module']='accounting';
			$this->displayView('accounting/contact_us',$data,array(),array(
					'js'=>array(),
					'css'=>array(),
				));
	}
	public function analytical(){
			$data['active']='analytical';
			$data['module']='accounting';
			$this->displayView('accounting/analytical',$data,array(),array(
					'js'=>array(),
					'css'=>array(),
				));
	}
}