<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Live_edit extends Admin_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - Activate Account
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		// insert record
		$post_ary = $this->input->post();
		// set necessary variables
		//$post_ary['account_status'] = '1';
		// process/add some variables
		//$post_ary['domain_name'] = $domain;
		// unset unneeded variables
		unset($post_ary['action']);

					// debug...
					/* */
					$post_ary['st_id'] = '393-a_onorder';
					$post_ary['size_22'] = '0';
					// */

		// process the st_id and check for admin stock params
		$temp_st_id = $post_ary['st_id']; // e.g., $post_ary['st_id'] = '1191-physical';
		$expstid = explode('-', $temp_st_id); // separate st_id and params
		if (count($expstid) > 1)
		{
			$expparams = explode('_', $expstid[1]); // separate params (admin stock and/or just inv_prefix)
		}
		else $expparams = explode('_', $expstid[0]); // separate params (admin stock and/or just inv_prefix)

		// determine if admin stocks
		// and get inv_prefix
		if ($expparams[0] == 'a')
		{
			$admin_stocks = TRUE;
			$inv_prefix = $expparams[1];
		}
		else
		{
			$admin_stocks = FALSE;
			$inv_prefix = $expparams[0];
		}
		// finally get st_id
		$st_id = $expstid[0];
		// then unset post st_id
		unset($post_ary['st_id']);

		// extract key and value of the size being edited
		// it is always one pair only so grab it all here
		foreach ($post_ary as $size_label => $value)
		{
			$exp = explode('_', $size_label);
			$size_suffix = $exp[1];
		}

		// set new physical stock
		$new_physical_stock = $value;
		$new_admin_physical_stock = $value;

		// initialize class
		$this->load->library('inventory/product_inventory_details');
		$this->product_inventory_details->initialize(array('st_id'=>$st_id));

		// get onorder stock if any
		//$onorder_stock = $row['onorder_'.$size_suffix];
		$onorder_label = 'onorder_'.$size_suffix;
		$onorder_stock = $this->product_inventory_details->$onorder_label;
		$admin_onorder_label = 'admin_onorder_'.$size_suffix;
		$admin_onorder_stock = $this->product_inventory_details->$admin_onorder_label;

		// get stock options data particularly the onorder(orderId) array
		$stocks_options = $this->product_inventory_details->stocks_options;

		// set last modified time
		$last_modified = time();
		$stocks_options['last_modified'] = $last_modified;

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		if ($admin_stocks)
		{
			// check if affecting order stocks and flag it accordingly
			if (
				$admin_onorder_stock > 0
				&& (($value - $admin_onorder_stock) < 0) // new physical stock is lower than onorder
			)
			{
				// flag stocks
				$stocks_options['stock'] = 'insufficient';

				// flag orders
				if (isset($stocks_options['onorder']))
				{
					foreach ($stocks_options['onorder'] as $order_id)
					{
						$qry1 = $DB->get_where(
							'tbl_order_log_details',
							array(
								'order_log_id' => $order_id,
								'prod_sku' => $this->product_inventory_details->prod_no.'_'.$this->product_inventory_details->color_code
							)
						);
						$row = $qry1->row();

						if (isset($row))
						{
							$options = json_decode($row->options, TRUE);
							$options['stock'] = 'insufficient';

							$DB->set('options', json_encode($options));
							$DB->where('order_log_detail_id', $row->order_log_detail_id);
							$qry2 = $DB->update('tbl_order_log_details');
						}
					}
				}

				// set new available stock
				$new_admin_available_stock = 0;
			}
			else
			{
				// unset flag
				if (isset($stocks_options['stock'])) unset($stocks_options['stock']);

				if (isset($stocks_options['onorder']))
				{
					foreach ($stocks_options['onorder'] as $order_id)
					{
						$qry1 = $DB->get_where(
							'tbl_order_log_details',
							array(
								'order_log_id' => $order_id,
								'prod_sku' => $this->product_inventory_details->prod_no.'_'.$this->product_inventory_details->color_code
							)
						);
						$row = $qry1->row();

						if (isset($row))
						{
							$options = json_decode($row->options, TRUE);
							if (isset($options['stock'])) unset($options['stock']);

							$DB->set('options', json_encode($options));
							$DB->where('order_log_detail_id', $row->order_log_detail_id);
							$qry2 = $DB->update('tbl_order_log_details');
						}
					}
				}

				// set new available stock
				$new_admin_available_stock = $value - $admin_onorder_stock;
			}

			// update admin physical stock
			$DB->set($size_label, $new_admin_physical_stock);
			$DB->where('st_id', $st_id);
			$DB->update('tbl_stock_admin_physical');

			// update available
			$DB->set($size_label, $new_admin_available_stock);
			$DB->where('st_id', $st_id);
			$DB->update('tbl_stock_admin');
		}
		else
		{
			// check if affecting order stocks and flag it accordingly
			if (
				$onorder_stock > 0
				&& (($value - $onorder_stock) < 0) // new physical stock is lower than onorder
			)
			{
				// flag stocks
				$stocks_options['stock'] = 'insufficient';

				// flag orders
				if (isset($stocks_options['onorder']))
				{
					foreach ($stocks_options['onorder'] as $order_id)
					{
						$qry1 = $DB->get_where(
							'tbl_order_log_details',
							array(
								'order_log_id' => $order_id,
								'prod_sku' => $this->product_inventory_details->prod_no.'_'.$this->product_inventory_details->color_code
							)
						);
						$row = $qry1->row();

						if (isset($row))
						{
							$options = json_decode($row->options, TRUE);
							$options['stock'] = 'insufficient';

							$DB->set('options', json_encode($options));
							$DB->where('order_log_detail_id', $row->order_log_detail_id);
							$qry2 = $DB->update('tbl_order_log_details');
						}
					}
				}

				// set new available stock
				$new_available_stock = 0;
			}
			else
			{
				// unset flag
				if (isset($stocks_options['stock'])) unset($stocks_options['stock']);

				if (isset($stocks_options['onorder']))
				{
					foreach ($stocks_options['onorder'] as $order_id)
					{
						$qry1 = $DB->get_where(
							'tbl_order_log_details',
							array(
								'order_log_id' => $order_id,
								'prod_sku' => $this->product_inventory_details->prod_no.'_'.$this->product_inventory_details->color_code
							)
						);
						$row = $qry1->row();

						if (isset($row))
						{
							$options = json_decode($row->options, TRUE);
							if (isset($options['stock'])) unset($options['stock']);

							$DB->set('options', json_encode($options));
							$DB->where('order_log_detail_id', $row->order_log_detail_id);
							$qry2 = $DB->update('tbl_order_log_details');
						}
					}
				}

				// set new available stock
				$new_available_stock = $value - $onorder_stock;
			}

			// tbl_stock is now the physical stocks
			// update physical stock
			$DB->set($size_label, $new_physical_stock);
			$DB->where('st_id', $st_id);
			$DB->update('tbl_stock');

			// update available
			$DB->set($size_label, $new_available_stock);
			$DB->where('st_id', $st_id);
			$DB->update('tbl_stock_available');
		}

		// update tbl_stock for stocks_options
		if ( ! empty($stocks_options))
		{
			$DB->set('options', json_encode($stocks_options));
			$DB->where('st_id', $st_id);
			$DB->update('tbl_stock');
		}

		// let's return the key=>value pair in json
		echo json_encode($post_ary);
		exit;
	}

	// ----------------------------------------------------------------------

}
