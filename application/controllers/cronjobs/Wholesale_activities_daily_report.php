<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wholesale_activities_daily_report extends MY_Controller {

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
		// for debuggin purposes, set $test to TRUE;
		$test = FALSE;

		// for manual purposes, set dat here or leave it '' empty..
		if (ENVIRONMENT == 'development' OR $test === TRUE)
		{
			$this->data['date'] = date('Y-m-d', time()); // today
		}
		else $this->data['date'] = date('Y-m-d', @time()-86400); // yesterday

		// load pertinent library/model/helpers
		$this->load->model('get_wholesale_login_details');
		$this->load->library('users/sales_users_list');

		// lets get the active sales user list
		$sales_users = $this->sales_users_list->select(array('is_active'=>'1'));

		// send report per sales user
		if ($sales_users)
		{
			foreach ($sales_users as $sales_user)
			{
				$loggedin_users = $this->get_wholesale_login_details->get_loggedin($this->data['date'], $sales_user->admin_sales_email);

				// set the data variable to pass to view file
				$this->data['sales_user'] = $sales_user->admin_sales_email;
				$this->data['loggedin_users'] = $loggedin_users;

				$message = $this->load->view('templates/daily_wholesale_activities_report', $this->data, TRUE);

				// let send out sales user wholesale user activity report only if there is activity
				if ($loggedin_users)
				{
					if (ENVIRONMENT == 'development' OR $test === TRUE) // ---> used for development purposes
					{
						// we are unable to send out email in our dev environment
						// so we check on the email template instead.
						// just don't forget to comment these accordingly
						echo $message;
						echo '<br /><br />';
					}
					else
					{
						// let's send the email
						// load email library
						$this->load->library('email');

						$this->email->clear();

						$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);

						$this->email->to($this->webspace_details->info_email);

						$this->email->bcc($this->config->item('dev1_email'));

						$this->email->subject($this->webspace_details->name.' - Daily Wholesale Activity');
						$this->email->message($message);

						// email class has a security error
						// "idn_to_ascii(): INTL_IDNA_VARIANT_2003 is deprecated"
						// using the '@' sign to supress this
						// must resolve pending update of CI
						@$this->email->send();

						// print any debugger even after sending, set FALSE;
						/*
						@$this->email->send(FALSE);
						echo $this->email->print_debugger();
						echo '<br /><br />';
						echo '<a href="javascrtip:;">Done...</a>';
						echo '<br /><br />';
						*/
					}
				}
				else
				{
					if (ENVIRONMENT == 'development' OR $test === TRUE) // ---> used for development purposes
					{
						// we are unable to send out email in our dev environment
						// so we check on the email template instead.
						// just don't forget to comment these accordingly
						echo $message;
						echo '<br /><br />';
					}
				}
			}
		}

		// get the wholesale users who logged in (based on the date supplied)
		// joined by wholesale user details and a couple of sales admin info
		// defaults to yesterday if no date is supplied
		$loggedin_users = $this->get_wholesale_login_details->get_general($this->data['date']);

		// set the data variable to pass to view file
		$this->data['sales_users'] = $loggedin_users;

		// let start sending email
		// save the view file as message
		$message = $this->load->view('templates/daily_wholesale_activities_report_general', $this->data, TRUE);

		if (ENVIRONMENT == 'development' OR $test === TRUE) // ---> used for development purposes
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

			$this->email->clear();

			$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);

			$this->email->to($this->webspace_details->info_email);

			$this->email->bcc($this->config->item('dev1_email'));

			$this->email->subject($this->webspace_details->name.' - Daily General Wholesale Activity');
			$this->email->message($message);

			// email class has a security error
			// "idn_to_ascii(): INTL_IDNA_VARIANT_2003 is deprecated"
			// using the '@' sign to supress this
			// must resolve pending update of CI
			@$this->email->send();

			// print any debugger even after sending, set FALSE;
			/*
			@$this->email->send(FALSE);
			echo $this->email->print_debugger();
			echo '<br /><br />';
			echo '<a href="javascrtip:;">Done...</a>';
			echo '<br /><br />';
			exit;
			*/
		}

		echo 'Done!';
		exit;
	}

	// --------------------------------------------------------------------
}
