<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends Admin_Controller {

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
	public function index($designer_slug = '', $category_slug = '', $category_id = '')
	{
		$this->output->enable_profiler(FALSE);

		if ( ! $designer_slug OR ! $category_slug OR ! $category_id)
		{
			// nothing to do anymore...
			echo 'The page or file you are asking for does not exist. Please go back <a href="'.site_url('admin/products/csv/stocks_update').'">here</a>.';
			exit;
		}

		// Set the csv file name to use:
		$filename = 'shop7_stock_csv_master_'.$designer_slug.'_'.$category_slug.'.csv';

		/************
		 * We need to query the stocks referencing
		 * lets identify the appropriate header
		 * so staff can edi the csv and upload it after update
		 */
		$sel = "
			SELECT
				'prod_no', 		'color_name',
				'size_0', 		'size_2', 		'size_4', 		'size_6',
				'size_8', 		'size_10', 		'size_12', 		'size_14',
				'size_16', 		'size_18', 		'size_20', 		'size_22',
				't1' Orderkey
			UNION
			SELECT
				ts.prod_no, 	ts.color_name,
				ts.size_0, 		ts.size_2, 		ts.size_4, 		ts.size_6,
				ts.size_8, 		ts.size_10, 	ts.size_12, 	ts.size_14,
				ts.size_16, 	ts.size_18, 	ts.size_20, 	ts.size_22,
				't2' Orderkey
			FROM
				tbl_product tp
				LEFT JOIN tbl_stock ts ON ts.prod_no = tp.prod_no
				LEFT JOIN tblcolor tc ON tc.color_name = ts.color_name
				LEFT JOIN designer d ON d.des_id = tp.designer
			WHERE
				d.url_structure  = '".$designer_slug."'
				AND tp.categories LIKE '%".$category_id."%'
			ORDER BY Orderkey ASC, prod_no ASC, color_name ASC
		";
		$qry = $this->DB->query($sel);

		// let's grab the much needed content
		$content = '';
		foreach ($qry->result_array() as $row)
		{
			$content .= $row['prod_no'].",".$row['color_name'].",".$row['size_0'].",".$row['size_2'].",".$row['size_4'].",".$row['size_6'].",".$row['size_8'].",".$row['size_10'].",".$row['size_12'].",".$row['size_14'].",".$row['size_16'].",".$row['size_18'].",".$row['size_20'].",".$row['size_22']."\n";
		}

		// lets open file and write to it
		// this will automatically write file if not existing
		$file_handle = fopen('./csv/'.$filename,'wb');
		fwrite($file_handle, $content);
		fclose($file_handle);

		/**************
		 * Download the file
		 */
		header('Content-Disposition: attachment; filename='.$filename);
	 	header('Content-Type: text/plain');
	 	readfile('./csv/'.$filename);
	}

	// ----------------------------------------------------------------------

}
