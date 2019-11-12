<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sa_date_create_to_timestamp extends CI_Controller {

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
		echo '<pre>';

		// select from old table
		$q1 = $this->DB->get('sales_packages');

		$i = 0;
		foreach ($q1->result() as $row)
		{
			$date = @strtotime($row->date_create);
			echo $i.' '.$row->date_create.' => '.$date.'<br />';

			// update to table
			/* */
			$this->DB->set('date_create', $date);
			$this->DB->where('sales_package_id', $row->sales_package_id);
			$this->DB->update('sales_packages');
			// */

			$i++;
		}

		echo '<br />';
		echo 'Done';
	}
}
