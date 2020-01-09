<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merge_users_wholesale extends CI_Controller {

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
		echo 'Start...<br />';
		//die();

		// 20200107
		// Mergin wholesale users from instyle and from tempo to shop7
		// 1. Copy shop7 table to a new table <_new>
		// 2. Copy instyle and tempo table to shop7 with suffix '_instyle_<date>' & '_tempo_<date>'
		// 3. This is not necessary but you can make the columns and data types exacting to the shop7 table
		// 4. Use script below to copy from instyle and tempo table to shop7 without duplicates
		
		// select from old table
		$q1 = $this->DB->get('tbluser_data_wholesale_instyle_20200107');
		//$q1 = $this->DB->get('tbluser_data_wholesale_tempo_20200107');

		$i = 0;
		$dups = 0;
		foreach ($q1->result() as $r1)
		{
			// check if email already exists at shop7 and skip
			$q2 = $this->DB->get_where('tbluser_data_wholesale_new', array('email'=>$r1->email));
			$r2 = $q2->row();
			if (isset($r2))
			{
				// we found the email, it's a dupe
				$dups++;
			}
			else
			{
				// insert record to shop new
				$data = array(
					'email' => $r1->email,
					'email2' => $r1->email2,
					'pword' => $r1->pword,
					'store_name' => $r1->store_name,
					'firstname' => $r1->firstname,
					'lastname' => $r1->lastname,
					'fed_tax_id' => $r1->fed_tax_id,
					'address1' => $r1->address1,
					'address2' => $r1->address2,
					'city' => $r1->city,
					'country' => $r1->country,
					'state' => $r1->state,
					'zipcode' => $r1->zipcode,
					'telephone' => $r1->telephone,
					'fax' => $r1->fax,
					'create_date' => $r1->create_date,
					'active_date' => $r1->active_date,
					'access_level' => $r1->access_level,
					'is_active' => $r1->is_active,
					'comments' => $r1->comments,
					'form_site' => $r1->form_site,
					'admin_sales_id' => $r1->admin_sales_id,
					'admin_sales_email' => $r1->admin_sales_email,
					'reference_designer' => $r1->reference_designer,
					'options' => $r1->options
				);
				$this->DB->set($data);
				$q3 = $this->DB->insert('tbluser_data_wholesale_new');

				$i++;
			}
		}

		echo '<br />';
		echo 'Processed '.$i.' items.';
		echo '<br />';
		echo 'Duplicates count is '.$dups.'.';
		echo '<br />';
		echo 'Done';
	}
}
