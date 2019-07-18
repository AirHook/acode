<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_import extends CI_Controller {

	/**
	 * DB Reference
	 *
	 * @var	object
	 */
	protected $DB;

	
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function index()
	{
		echo 'Importing...<br />';
		
		// the imports
		//$q1 = $this->DB->get('tbl_product_tempo');
		$q1 = $this->DB->get_where('tbl_product_instyle', array('designer'=>'64')); // getting chaarm furs and junnie products
		
		//echo '<pre>';
		//print_r($q1->result());
		//die();
		
		foreach ($q1->result() as $r1)
		{
			// set correct subcat id for tempo imports
			//$subcat_id = $this->set_correct_subcat_id($r1->subcat_id);
			
			$data1 = array(
				'prod_name' => $r1->prod_name,
				'prod_no' => $r1->prod_no,
				'view_status' => $r1->view_status,
				'cat_id' => $r1->cat_id,
				//'subcat_id' => $subcat_id, // used for tempo imports
				'subcat_id' => $r1->subcat_id,
				'prod_date' => $r1->prod_date,
				'prod_desc' => $r1->prod_desc,
				'catalogue_price' => $r1->catalogue_price,
				'less_discount' => $r1->less_discount,
				'wholesale_price' => $r1->wholesale_price,
				'wholesale_price_clearance' => $r1->wholesale_price_clearance,
				'designer' => '64', // 66 - tempo, 64 - chaarm
				'primary_img_id' => $r1->primary_img_id,
				'colors' => $r1->colors,
				'colornames' => $r1->colornames,
				'materials' => $r1->materials,
				'trends' => $r1->trends,
				'events' => $r1->events,
				'styles' => $r1->styles,
				'new_arrival' => $r1->new_arrival,
				'clearance' => $r1->clearance,
				'public' => $r1->public,
				'publish' => $r1->publish,
				'size_mode' => $r1->size_mode
			);
			$this->DB->insert('tbl_product', $data1);
			$prod_id = $this->DB->insert_id();
			
			// let's get the stock respective of prod_no
			//$q2 = $this->DB->get_where('tbl_stock_tempo', array('prod_no'=>$r1->prod_no)); // for tempo imports
			$q2 = $this->DB->get_where('tbl_stock_instyle', array('prod_no'=>$r1->prod_no)); // importing chaarm and junnie
			
			foreach ($q2->result() as $r2)
			{
				$data2 = array(
					'prod_id' => $prod_id,
					'prod_no' => $r2->prod_no,
					'color_name' => $r2->color_name,
					'color_facets' => $r2->color_facets,
					'color_publish' => $r2->color_publish,
					'new_color_publish' => $r2->new_color_publish,
					'primary_color' => $r2->primary_color,
					//'size_0' => $r2->size_0,
					//'size_2' => $r2->size_2,
					//'size_4' => $r2->size_4,
					//'size_6' => $r2->size_6,
					//'size_8' => $r2->size_8,
					//'size_10' => $r2->size_10,
					//'size_12' => $r2->size_12,
					//'size_14' => $r2->size_14,
					//'size_16' => $r2->size_16,
					//'size_18' => $r2->size_18,
					//'size_20' => $r2->size_20,
					//'size_22' => $r2->size_22
					'size_ss' => $r2->size_ss,
					'size_sm' => $r2->size_sm,
					'size_sl' => $r2->size_sl,
					'size_sxl' => $r2->size_sxl,
					'size_sxxl' => $r2->size_sxxl,
					'size_sxl1' => $r2->size_sxl1,
					'size_sxl2' => $r2->size_sxl2
				);
				$this->DB->insert('tbl_stock', $data2);
			}
		}
		
		echo '<br />';
		echo 'Done';
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function set_correct_subcat_id($subcat_id)
	{
		switch ($subcat_id)
		{
			case '208':
				$new_subcat_id = '162';	// -> coats
				break;
			case '206':
				$new_subcat_id = '161';	// -> dresses
				break;
			case '218':
				$new_subcat_id = '163';	// -> jackets
				break;
			case '201':
				$new_subcat_id = '132';	// -> pants
				break;
			case '204':
				$new_subcat_id = '91';	// -> skirts
				break;
			case '205':
				$new_subcat_id = '133';	// -> tops
				break;
			case '219':
				$new_subcat_id = '178';	// -> wraps
				break;
				
			default:
				$new_subcat_id = '0';
		}
		
		return $new_subcat_id;
		
		/**
		 * Records
		 
		 // tempo items
			categories
			tempo + instyle (existing & new)
				coats	208		162
				dresses	206		161
				jackets	218		163
				pants	201		132
				skirts	204		91
				tops	205		133
				wraps	219		-		
		 
		 // issue items
			case '28':
				$subcat_id = '177';
				break;
			case '32':
				$subcat_id = '176';
				break;
			case '220':
				$subcat_id = '130';
				break;
				
		 // chaarm items
			case '162':
				$subcat_id = '162'; // coats
				break;
			case '163':
				$subcat_id = '163'; // jackets
				break;
			case '174':
				$subcat_id = '174'; // accessories
				break;
			case '175':
				$subcat_id = '175'; // shawls
				break;
				
		 */
	}
	
	// ----------------------------------------------------------------------
	
}
