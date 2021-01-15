<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_stocks extends Admin_Controller {

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

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('api/dsco/dsco_item');

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
	}

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * @return	void
	 */
	public function index($prod_id)
	{
		// initialize certain properties
		$this->product_details->initialize(
			array(
				'tbl_product.prod_id' => $prod_id,
				'tbl_stock.st_id' => $this->input->post('st_id')
			)
		);
		$stocks_options = $this->product_details->stocks_options;
		$size_mode = $this->product_details->size_mode;

		// set options last modified
		$stocks_options['last_modified'] = time();

		// grab post items
		$post_ary = $this->input->post();

		// unset items
		unset($post_ary['designer_slug']);
		unset($post_ary['color_name']);
		unset($post_ary['prod_no']);
		unset($post_ary['prod_id']);

		// do not forget to update stock options record
		//$this->DB->set('options', json_encode($stocks_options));

		// in this case of regular designer stocks, tbl_stock has
		// already been created during product add
		// only onorder and physical stocks are not yet created
		// although, create onorder and physical will also be
		// incorporated at the product add level
		// note: tbl_stocks_physical is depracted

		// unset some post data not needed
		unset($post_ary['st_id']);

		// from update stocks, only size array is what's left on $post_ary
		// let's process size data
		$size_ary = $post_ary;

		foreach($size_ary as $size_label => $qty)
		{
			// get physical and onorder stocks
			// actual $size_label is the physical stock
			$onorder_size_label = str_replace('size', 'onorder', $size_label);

			// re-calculate onorder based on new physical qty input
			$onorder[$size_label] =
				$qty > $this->product_details->$onorder_size_label
				? ($this->product_details->$onorder_size_label ?: '0')
				: $qty
			;

			// re-calculate available based on existing onorder stocks
			$available[$size_label] =
				$qty > $this->product_details->$onorder_size_label
				? $qty - $this->product_details->$onorder_size_label
				: 0
			;

			// physical is as per input
			$physical[$size_label] = $qty;

			// stocks influences DSCO items
			// each size is a single known unit at dsco
			// process dsco items here
			if ($stocks_options['post_to_dsco'])
			{
				switch ($size_label)
				{
					case 'size_sxs':
					case 'size_0':
					case 'size_sprepack1221':
					case 'size_ssm':
					case 'size_sonesizefitsall':
						$suffix = '1';
					break;
					case 'size_ss':
					case 'size_2':
					case 'size_sml':
						$suffix = '2';
					break;
					case 'size_sm':
					case 'size_4':
						$suffix = '3';
					break;
					case 'size_sl':
					case 'size_6':
						$suffix = '4';
					break;
					case 'size_sxl':
					case 'size_8':
						$suffix = '5';
					break;
					case 'size_sxxl':
					case 'size_10':
						$suffix = '6';
					break;
					case 'size_sxl1':
					case 'size_12':
						$suffix = '7';
					break;
					case 'size_sxl2':
					case 'size_14':
						$suffix = '8';
					break;
					case 'size_16':
						$suffix = '9';
					break;
					default:
						$suffix = '0';
				}

				// check if item exists at dsco
				$this->dsco_item->dsco_sku = trim($stocks_options['dsco_sku']).'_'.$suffix;
				$dsco_get = $this->dsco_item->get();

				if ($dsco_get['status'] != 'failure')
				{
					if ($available[$size_label] == '0')
					{
						// set action to DSCO
						$this->dsco_item->status = 'out-of-stock';
						$this->dsco_item->qty = 0;
					}
					else
					{
						// set action to DSCO
						$this->dsco_item->status = 'in-stock';
						$this->dsco_item->qty = $available[$size_label];
					}

					// process DSCO API (return is an array)
					$dsco_udpate = $this->dsco_item->update();
				}
			}
		}

		// insert/update available stock records where necessary
		// check if available stocks already has the record
		$q_av = $this->DB->get_where('tbl_stock_available', array('st_id'=>$this->input->post('st_id')));
		$r_av = $q_av->row();
		if ( ! isset($r_av))
		{
			// admin available stock record
			$this->DB->set($available);
			$this->DB->set('st_id', $this->input->post('st_id'));
			$this->DB->insert('tbl_stock_available');
		}
		else
		{
			// update available stock record
			$this->DB->set($available);
			$this->DB->where('st_id', $this->input->post('st_id'));
			$this->DB->update('tbl_stock_available');
		}

		// insert/update onorder stock records where necessary
		// check if onorder stocks already has the record
		$q_on = $this->DB->get_where('tbl_stock_onorder', array('st_id'=>$this->input->post('st_id')));
		$r_on = $q_on->row();
		if ( ! isset($r_on))
		{
			// admin onorder stock record
			$this->DB->set($onorder);
			$this->DB->set('st_id', $this->input->post('st_id'));
			$this->DB->insert('tbl_stock_onorder');
		}
		else
		{
			// update onorder stock record
			$this->DB->set($onorder);
			$this->DB->where('st_id', $this->input->post('st_id'));
			$this->DB->update('tbl_stock_onorder');
		}

		// update physical stocks record
		$this->DB->set($physical);
		$this->DB->set('options', json_encode($stocks_options));
		$this->DB->where('st_id', $this->input->post('st_id'));
		$this->DB->update('tbl_stock');

		// set flash data
		$this->session->set_flashdata('stock_updated', TRUE);
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'products/edit/index/'.$prod_id, 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * Admin method
	 *
	 * @return	void
	 */
	public function admin($prod_id)
	{
		// initialize certain properties
		$this->product_details->initialize(
			array(
				'tbl_stock.st_id' => $this->input->post('st_id')
			)
		);
		$stocks_options = $this->product_details->stocks_options;

		// set options last modified
		$stocks_options['last_modified_admin_stocks'] = time();

		// grab post items
		$post_ary = $this->input->post();

		// update stock options record
		$this->DB->set('options', json_encode($stocks_options));
		$this->DB->where('st_id', $this->input->post('st_id'));
		$this->DB->update('tbl_stock');

		// check if admin stocks already has the record
		$q_admin = $this->DB->get_where('tbl_stock_admin_physical', array('st_id'=>$this->input->post('st_id')));
		$r_admin = $q_admin->row();

		// insert/update admin stock records where necessary
		if ( ! isset($r_admin))
		{
			// admin physical stock record
			$this->DB->set($post_ary);
			$this->DB->insert('tbl_stock_admin_physical');

			// admin available stock record as this will be the same as new physical stock
			$this->DB->set($post_ary);
			$this->DB->insert('tbl_stock_admin');

			// create admin onorder record with no data at the moment
			$this->DB->set('st_id', $post_ary['st_id']);
			$this->DB->insert('tbl_stock_admin_onorder');
		}
		else
		{
			// unset some post data not needed
			unset($post_ary['st_id']);

			// from update admin stocks, only size array is what's left on $post_ary
			// let's process size data
			$size_ary = $post_ary;

			foreach($size_ary as $size_label => $qty)
			{
				$admin_available_size_label = str_replace('size', 'admin', $size_label);
				$admin_onorder_size_label = str_replace('size', 'admin_onorder', $size_label);
				$admin_physical_size_label = str_replace('size', 'admin_physical', $size_label);

				// re-calculate onorder based on new physical qty input
				$admin_onorder[$size_label] =
					$qty > $this->product_details->$admin_onorder_size_label
					? ($this->product_details->$admin_onorder_size_label ?: '0')
					: $qty
				;

				// re-calculate available based on existing onorder stocks
				$admin_available[$size_label] =
					$qty > $this->product_details->$admin_onorder_size_label
					? $qty - $this->product_details->$admin_onorder_size_label
					: 0
				;

				$admin_physical[$size_label] = $qty;
			}

			// update admin stocks available record
			$this->DB->set($admin_available);
			$this->DB->where('st_id', $this->input->post('st_id'));
			$this->DB->update('tbl_stock_admin');

			// update admin stocks onorder record
			$this->DB->set($admin_onorder);
			$this->DB->where('st_id', $this->input->post('st_id'));
			$this->DB->update('tbl_stock_admin_onorder');

			// update admin stocks physical record
			$this->DB->set($admin_physical);
			$this->DB->where('st_id', $this->input->post('st_id'));
			$this->DB->update('tbl_stock_admin_physical');
		}

		// set flash data
		$this->session->set_flashdata('stock_updated', TRUE);
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'products/edit/index/'.$prod_id, 'location');
	}

	// ----------------------------------------------------------------------

}
