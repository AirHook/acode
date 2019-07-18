<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_clicks_daily_report extends MY_Controller {

	/**
	 * DB Object
	 *
	 * @return	object
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
		
		// connect to database for use by model
		$this->DB = $this->load->database('instyle', TRUE);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Primary method - index
	 *
	 * @return	void
	 */
	public function index()
	{
		// load pertinent library/model/helpers
		$this->load->model('get_product_clicks');
		
		// get product clicks
		//$this->data['date'] = '2018-03-29';
		$this->data['date'] = @date('Y-m-d', strtotime('today'));
		$product_clicks = $this->get_product_clicks->daily($this->data['date']);

		// iterate through product clicks
		$total_cs_clicks = 0;
		$total_ws_clicks = 0;
		$overall_total = 0;
		$clicks = array();
		if ($product_clicks)
		{
			foreach ($product_clicks as $row) 
			{ 
				// let us compute for cs and ws clicks
				// and the total clicks
				
				// grab the click data
				$temp = $row->click_data != '' ? json_decode($row->click_data , TRUE) : array();
				
				// iterate through the product cliks
				foreach ($temp as $prod_no => $cclick) 
				{
					// combine same key elements
					if (array_key_exists($prod_no, $clicks))
					{
						// add the clicks
						$clicks[$prod_no][0] += $cclick[0];
						$clicks[$prod_no][1] += $cclick[1];
						$clicks[$prod_no][2] = $cclick[2];
						
						$clicks[$prod_no][3] = @$cclick[3] ?: '';
						$clicks[$prod_no][4] = @$cclick[4] ?: '';
						
						// sort array to remove numeric indexes
						array_values($clicks[$prod_no]);
					}
					else
					{
						// new key element, set the clicks
						$clicks[$prod_no] = array(
							$cclick[0], 
							$cclick[1], 
							$cclick[2], 
							(@$cclick[3] ?: ''), 
							(@$cclick[4] ?: '')
						);
					}
					
					// add the total clicks continuously
					$total_cs_clicks += $cclick[0];
					$total_ws_clicks += $cclick[1];
					$overall_total += ($cclick[0] + $cclick[1]);
				}
				
				// some debugging snippets to investigate the current product clicks
				// it seems to many for a site that is not yet known
				// let's check length of the data
				$click_data_length = strlen($row->click_data);
			}
		}
		
		function sort_clicks($a, $b)
		{
			if (($a[0] + $a[1]) == ($b[0] + $b[1])) return 0;
			return (($a[0] + $a[1]) < ($b[0] + $b[1])) ? 1 : -1;
		}
		
		uasort($clicks, 'sort_clicks');
		
		// set data variables to pass to view file
		$this->data['product_clicks'] = $clicks;
		$this->data['total_cs_clicks'] = $total_cs_clicks;
		$this->data['total_ws_clicks'] = $total_ws_clicks;
		$this->data['overall_total'] = $overall_total;
		
		// let start sending email
		// save the view file as message
		$message = $this->load->view('templates/daily_product_clicks_report', $this->data, TRUE);
		
		if (ENVIRONMENT == 'development') // ---> used for development purposes
		{
			// we are unable to send out email in our dev environment
			// so we check on the email template instead.
			// just don't forget to comment these accordingly
			echo $message;
			echo '<br /><br />';
			
			echo '<a href="javascrtip:;">Done...</a>';
			echo '<br /><br />';
			exit;
		}
		else
		{
			// let's send the email
			// load email library
			$this->load->library('email');
			
			$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);

			//$this->email->to($this->webspace_details->info_email);
			
			$this->email->to($this->config->item('dev1_email'));
			
			$this->email->subject($this->webspace_details->name.' - Test Email Sending');
			$this->email->message($message);
			
			// email class has a security error
			// "idn_to_ascii(): INTL_IDNA_VARIANT_2003 is deprecated"
			// using the '@' sign to supress this 
			// must resolve pending update of CI
			//@$this->email->send(FALSE);

			// to print any debugger even after sending, set FALSE;
			/*
			@$this->email->send(FALSE);
			echo $this->email->print_debugger();
			echo '<br /><br />';
			echo '<a href="javascrtip:;">Done...</a>';
			echo '<br /><br />';
			*/
			echo $message;
			echo '<br /><br />';
			echo 'Done!';
		}
		
		// data size alert notification to developer
		if ($click_data_length >= 1000000)
		{
			echo '<br /><br />';
			echo 'Product Clicks current data size is now at '.$click_data_length;
		}
		
		exit;
	}
}
