<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_seque extends Admin_Controller {

	/**
	 * DB Reference
	 *
	 * @var	object
	 */
	protected $DB;

	// ----------------------------------------------------------------------

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
	 * Index - default method
	 *
	 * @return	void
	 */
	public function index($prod_id, $new_seque)
	{
		$this->output->enable_profiler(FALSE);

		// update record
		$this->DB->set('seque', $new_seque);
		$this->DB->where('prod_id', $prod_id);
		$q = $this->DB->update('tbl_product');

		if ($q)
		{
			echo 'Success';
		}
		else echo 'ERROR: '.$this->DB->error();
	}

	// ----------------------------------------------------------------------

	/**
	 * Update seque
	 * ...via admin ajax call for each page of product list
	 *
	 * @return	void
	 */
	public function nl_seque()
	{
		$this->output->enable_profiler(FALSE);

		// sample post data with 'list_json'
		// {"page":1,"list_json":[{"seque":0,"prod_id":1847},{"seque":0,"prod_id":2925},...]}

		// grab the seque's of the series and put on an array and then sort
		$series = array();
		foreach ($this->input->post('list_json') as $key => $value)
		{
			array_push($series, $value['seque']);
		}
		sort($series);

		// update records
		foreach ($this->input->post('list_json') as $key => $value)
		{
			$this->DB->set('last_modified', time());
			$this->DB->set('seque', $series[$key]);
			$this->DB->where('prod_id', $value['prod_id']);
			$this->DB->update('tbl_product');
		}

		echo 'done';
    }

	// ----------------------------------------------------------------------

	/**
	 * Update seque
	 * ...via admin manual edit sequence btn under each item of product list
	 *
	 * @return	void
	 */
	public function nl_manual_seque()
	{
		//echo '<pre>';
		//print_r($this->input->post());
		//die();
		// post data
		/*
		Array
		(
		    [page_param] => all
		    [active_category_id] => 195
		    [active_designer] => basixblacklabel
		    [cur_seque] => 0
		    [prod_id] => 2928
		    [seque] => 2 // new seque
		)
		*/

		// get item's seque details (actual seque)
		$nseque = $this->_get_seque_item_details();

		// set product list where condition
		if ($this->input->post('active_designer'))
		{
			$where['designer.url_structure'] = $this->input->post('active_designer');
			if ($this->input->post('active_category_id'))
			{
				$where['tbl_product.categories LIKE'] = $this->input->post('active_category_id'); // of last segment category
			}
		}
		else $where['tbl_product.categories LIKE'] = $this->input->post('active_category_id');

		// including the covering sequencing
		if ($this->input->post('cur_seque') < $nseque)
		{
			$where['condition'] = "tbl_product.seque BETWEEN '".$this->input->post('cur_seque')."' AND '".$nseque."'";
			$operand = 'minus';
		}
		else
		{
			$where['condition'] = "tbl_product.seque BETWEEN '".$nseque."' AND '".$this->input->post('cur_seque')."'";
			$operand = 'plus';
		}

		// get the products list and total count
		$params['show_private'] = TRUE; // all items general public (Y) - N for private
		$params['view_status'] = 'ALL'; // all items view status (Y, Y1, Y2, N)
		$params['view_at_hub'] = TRUE; // all items general public at hub site
		$params['view_at_satellite'] = TRUE; // all items publis at satellite site
		$params['variant_publish'] = 'ALL'; // all items at variant level publish (view status)
		$params['variant_view_at_hub'] = TRUE; // variant level public at hub site
		$params['variant_view_at_satellite'] = TRUE; // varian level public at satellite site
		$params['with_stocks'] = FALSE; // Show all with and without stocks
		$params['group_products'] = TRUE; // group per product number or per variant
		$params['special_sale'] = FALSE; // special sale items only
		//$params['pagination'] = $this->data['page']; // get all in one query
		$this->load->library('products/products_list', $params);
		$products = $this->products_list->select(
			$where,
			array( // order conditions
				'seque'=>'asc',
				'tbl_product.prod_no' => 'desc'
			)
		);

		if ($products)
		{
			foreach ($products as $product)
			{
				if ($product->prod_id != $this->input->post('prod_id'))
				{
					if ($operand == 'minus') $n_seque = $product->seque - 1;
					else $n_seque = $product->seque + 1;
					$this->DB->set('last_modified', time());
					$this->DB->set('seque', $n_seque);
					$this->DB->where('prod_id', $product->prod_id);
					$this->DB->update('tbl_product');
				}
			}
		}

		// lastly update the actual affected item
		$this->DB->set('last_modified', time());
		$this->DB->set('seque', $nseque);
		$this->DB->where('prod_id', $this->input->post('prod_id'));
		$this->DB->update('tbl_product');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect($this->session->flashdata('thumbs_uri_string'), 'location');
    }

	// ----------------------------------------------------------------------

	/**
	 * Update seque
	 * ...via admin ajax call for each page of product list
	 *
	 * @return	void
	 */
	private function _get_seque_item_details()
	{
		// set product list where condition
		if ($this->input->post('active_designer'))
		{
			$where['designer.url_structure'] = $this->input->post('active_designer');
			if ($this->input->post('active_category_id'))
			{
				$where['tbl_product.categories LIKE'] = $this->input->post('active_category_id'); // of last segment category
			}
		}
		else $where['tbl_product.categories LIKE'] = $this->input->post('active_category_id');

		if ($this->input->post('page_param') == 'is_public')
		{
			$where['tbl_product.public'] = 'Y';
			$where['tbl_product.publish'] = '1';
		}

		if ($this->input->post('page_param') == 'not_public')
		{
			$where['tbl_product.public'] = 'N';
			$where['tbl_product.publish'] = '2';
		}

		if ($this->input->post('page_param') == 'clearance')
		{
			$where['tbl_product.clearance'] = '3';
		}

		if ($this->input->post('page_param') == 'clearance_cs_only')
		{
			$where['tbl_stock.custom_order'] = '3';
		}

		if ($this->input->post('page_param') == 'unpublish')
		{
			$where['tbl_product.publish'] = '0';
			$where['tbl_product.view_status'] = 'N';
		}

		// get the products list and total count
		$params['show_private'] = $this->input->post('page_param') == 'is_public' ? FALSE : TRUE; // all items general public (Y) - N for private
		$params['view_status'] = 'ALL'; // all items view status (Y, Y1, Y2, N)
		$params['view_at_hub'] = TRUE; // all items general public at hub site
		$params['view_at_satellite'] = TRUE; // all items publis at satellite site
		$params['variant_publish'] = 'ALL'; // all items at variant level publish (view status)
		$params['variant_view_at_hub'] = TRUE; // variant level public at hub site
		$params['variant_view_at_satellite'] = TRUE; // varian level public at satellite site
		$params['with_stocks'] = $this->input->post('page_param') == 'in_stock' ? TRUE : FALSE; // Show all with and without stocks
		$params['group_products'] = $this->input->post('page_param') == 'clearance_cs_only' ? FALSE : TRUE; // group per product number or per variant
		$params['special_sale'] = $this->input->post('page_param') == 'clearance' ? TRUE : FALSE; // special sale items only
		$params['pagination'] = 0; // get all in one query
		$this->load->library('products/products_list', $params);
		$products = $this->products_list->select(
			$where,
			array( // order conditions
				'seque'=>'asc',
				'tbl_product.prod_no' => 'desc'
			)
		);

		$new_seque = $this->input->post('seque') > 0 ? $this->input->post('seque') : 1;
		$this_seque = '';

		if ($products)
		{
			$i = 1;
			foreach ($products as $product)
			{
				if ($new_seque == $i)
				{
					$this_seque = $product->seque;
				}

				$i++;
			}
		}

		return $this_seque ?: FALSE;
    }

	// ----------------------------------------------------------------------

}
