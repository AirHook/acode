<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merge_users_consumer extends CI_Controller {

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
		// Mergin wholesale users from instyle to shop7
		// 1. Copy shop7 table to a new table <_new>
		// 2. Copy instyle and tempo table to shop7 with suffix '_instyle_<date>'
		// 3. This is not necessary but you can make the columns and data types exacting to the shop7 table
		// 4. Use script below to copy from instyle table to shop7 without duplicates

		// select from old table
		$q1 = $this->DB->get('tbluser_data_instyle_20200108');

		$i = 0;
		$dups = 0;
		foreach ($q1->result() as $r1)
		{
			// check if email already exists at shop7 and skip
			$q2 = $this->DB->get_where('tbluser_data_new', array('email'=>$r1->email));
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
					'firstname' => $r1->firstname,
					'lastname' => $r1->lastname,
					'company' => $r1->company,
					'company_web' => $r1->company_web,
					'product_items' => $r1->product_items,
					'resale_number' => $r1->resale_number,
					'resale_expiration' => $r1->resale_expiration,
					'telephone' => $r1->telephone,
					'cellphone' => $r1->cellphone,
					'fax' => $r1->fax,
					'address1' => $r1->address1,
					'address2' => $r1->address2,
					'city' => $r1->city,
					'country' => $r1->country,
					'state_province' => $r1->state_province,
					'zip_postcode' => $r1->zip_postcode,
					'email' => $r1->email,
					'password' => $r1->password,
					'how_hear_about' => $r1->how_hear_about,
					'receive_productupd' => $r1->receive_productupd,
					'register_status' => $r1->register_status,
					'comment' => $r1->comment,
					'dresssize' => $r1->dresssize,
					'is_active' => $r1->is_active,
					'site_ini' => $r1->site_ini,
					'create_date' => $r1->create_date,
					'active_date' => $r1->active_date,
					'admin_sales_email' => $r1->admin_sales_email,
					'reference_designer' => $r1->reference_designer,
					'options' => $r1->options
				);
				$this->DB->set($data);
				$q3 = $this->DB->insert('tbluser_data_new');

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
