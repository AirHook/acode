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
					$upd = "
						UPDATE tbl_stock
						SET
							size_0 = '".$row['size_0']."',
							size_2 = '".$row['size_2']."',
							size_4 = '".$row['size_4']."',
							size_6 = '".$row['size_6']."',
							size_8 = '".$row['size_8']."',
							size_10 = '".$row['size_10']."',
							size_12 = '".$row['size_12']."',
							size_14 = '".$row['size_14']."',
							size_16 = '".$row['size_16']."',
							size_18 = '".$row['size_18']."',
							size_20 = '".$row['size_20']."',
							size_22 = '".$row['size_22']."'
						WHERE
							prod_no = '".trim($row['prod_no'])."'
							AND color_name = '".trim($row['color_name'])."'
					";

					$qry = $this->DB->query($upd);

					// hopefully, there are no database errors
					/* */
					if ( ! $qry)
					{
						// nothing to do anymore, bring back to main page...
						echo 'There was an error updating database.';
						exit();
					}
					// */

					// needed to add this query to update item to public
					// this is for task dated 20190415 inventory update via CSV
					/* */
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
					/* */
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
