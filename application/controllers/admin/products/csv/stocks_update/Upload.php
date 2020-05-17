<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends Admin_Controller {

	/**
	 * DB Object
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
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		if ($_FILES)
		{
			// we done need to save the file upload
			// we just need to read it
			$filehandle = $_FILES['file']['tmp_name'];

			// if file is not a csv file
			/* */
			$fileType = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			if ($fileType !== 'csv')
			{
				// nothing to do anymore, bring back to main page...
				echo 'Invalid file.';
				exit();
			}
			// */

			// let us open the file
			ini_set("auto_detect_line_endings", true);
			$myfile = fopen($filehandle, "r") OR die("Unable to open file!");

			// Output one line until end-of-file
			$ctr = 0;
			$data = array();
			while ( ! feof($myfile))
			{
				// process the current row's data
				if ($row = fgets($myfile))
				{
					// on first read, we capture the headers
					// this will allow us to accept any csv table provided the headers are the exact field name
					if ($ctr == 0)
					{
						$fields = explode(',', $row);
					}
					else
					{
						$values = explode(',', $row);

						foreach ($values as $key => $value)
						{
							if (substr(trim($fields[$key]), 0, 3) == chr(hexdec('EF')).chr(hexdec('BB')).chr(hexdec('BF')))
							{
								$fields[$key] = substr(trim($fields[$key]), 3);
							}

							$subdata[trim($fields[$key])] = trim($value);
						}

						array_push($data, $subdata);
					}

					$ctr++;
					//if ($ctr === 10) die('Count 10<br />');
				}
			}

			// let us not forget to close the file
			fclose($myfile);

			// if file is empty
			if (empty($data))
			{
				// nothing to do anymore, bring back to main page...
				echo 'File is empty.';
				exit();
			}

			// update database
			foreach ($data as $row)
			{
				if ($row['prod_no'] != '')
				{
					// get the onorder stocks
					// compare physical qty with onorder stocks
					// if physical is less than onorder, flag for insufficient stock
					// update stock[options] data for flag
					// otherwise, compute for available stock

					// initialize class
					$this->load->library('inventory/product_inventory_details');
					$this->product_inventory_details->initialize(
						array(
							'prod_no' => trim($row['prod_no']),
							'color_name' => trim($row['color_name'])
						)
					);

					// iterate through the row data
					foreach ($row as $size_label => $value)
					{
						if ($size_label != 'prod_no' && $size_label != 'color_name')
						{
							// extract size suffix
							$exp = explode('_', $size_label);
							$size_suffix = $exp[1];

							// get onorder stock if any
							$onorder_label = 'onorder_'.$size_suffix;
							$onorder_stock = $this->product_inventory_details->$onorder_label;

							// get stock options data particularly the onorder(orderId) array
							$stocks_options = $this->product_inventory_details->stocks_options;

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
										$qry1 = $this->DB->get_where(
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

											$this->DB->set('options', json_encode($options));
											$this->DB->where('order_log_detail_id', $row->order_log_detail_id);
											$qry2 = $this->DB->update('tbl_order_log_details');
										}
									}
								}

								// set new available stock
								$new_available_stock[$size_label] = 0;
							}
							else
							{
								// unset flag
								if (isset($stocks_options['stock'])) unset($stocks_options['stock']);

								if (isset($stocks_options['onorder']))
								{
									foreach ($stocks_options['onorder'] as $order_id)
									{
										$qry3 = $this->DB->get_where(
											'tbl_order_log_details',
											array(
												'order_log_id' => $order_id,
												'prod_sku' => $this->product_inventory_details->prod_no.'_'.$this->product_inventory_details->color_code
											)
										);
										$row = $qry3->row();

										if (isset($row))
										{
											$options = json_decode($row->options, TRUE);
											if (isset($options['stock'])) unset($options['stock']);

											$this->DB->set('options', json_encode($options));
											$this->DB->where('order_log_detail_id', $row->order_log_detail_id);
											$qry4 = $this->DB->update('tbl_order_log_details');
										}
									}
								}

								// set new available stock
								$new_available_stock[$size_label] = $value - $onorder_stock;
							}

							// set the data to update
							$new_physical_stock[$size_label] = $value;
						}
					}

					// set last modified time
					$last_modified = time();
					$stocks_options['last_modified'] = $last_modified;

					// update physical stock
					$this->DB->set($new_physical_stock);
					$this->DB->where('st_id', $this->product_inventory_details->stock_id);
					$q1 = $this->DB->update('tbl_stock_physical');

					if ( ! $q1)
					{
						// nothing to do anymore, bring back to main page...
						echo 'There was an error updating database - q1.<br />';
						echo '<pre>';
						print_r($this->DB->error());
						exit;
					}

					// update available stock
					$this->DB->set($new_available_stock);
					//$this->DB->set('custom_order', '3'); // setting item as clearance
					if ( ! empty($stocks_options)) $this->DB->set('options', json_encode($stocks_options));
					$this->DB->where('st_id', $this->product_inventory_details->stock_id);
					$q2 = $this->DB->update('tbl_stock');

					// hopefully, there are no database errors
					/* */
					if (! $q2)
					{
						// nothing to do anymore, bring back to main page...
						echo 'There was an error updating database - q2.<br />';
						echo '<pre>';
						print_r($this->DB->error());
						exit;
					}
					// */

					// needed to add this query to update item to public
					// this is for task dated 20190415 inventory update via CSV
					// disabling this as of 20200419
					/* *
					if (
						$row['size_0'] > 0
						OR $row['size_2'] > 0
						OR $row['size_4'] > 0
						OR $row['size_6'] > 0
						OR $row['size_8'] > 0
						OR $row['size_10'] > 0
						OR $row['size_12'] > 0
						OR $row['size_14'] > 0
						OR $row['size_16'] > 0
						OR $row['size_18'] > 0
						OR $row['size_20'] > 0
						OR $row['size_22'] > 0
					)
					{
						$upd_products = "
							UPDATE tbl_product
							SET
							    view_status = 'Y',
							    public = 'Y',
							    publish = '1'
							WHERE
							prod_no = '".trim($row['prod_no'])."'
						";
						$r = $this->DB->query($upd_products);
					}
					// */

					// if there are no affected rows, there must be something wrong with the params
					// on the where clause
					/* *
					if ( ! $r)
					{
						// can only assume either prod_no or color_name or both are invalid
						echo 'Invalid '.$row['prod_no'].' and/or '.$row['color_name'];
						//error_log('Invalid '.$row['prod_no'].' and/or '.$row['color_name']."\n", 3, FILE_NAME.'_log.log');
						$error_log .= 'Invalid '.$row['prod_no'].' and/or '.$row['color_name'].'<br />';
					}
					// */

				}
			}
		}

		// set flashdata
		$this->session->set_userdata('success', 'csv_udpated');
		$this->session->mark_as_flash('success');

		// send user back to csv page
		redirect($this->input->post('return_uri'), 'location');
	}

	// ----------------------------------------------------------------------

}
