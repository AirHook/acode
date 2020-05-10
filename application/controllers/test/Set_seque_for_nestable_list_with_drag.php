<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_seque_for_nestable_list_with_drag extends CI_Controller {

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
		echo 'Processing...<br />';

		// get the data
		$q1 = $this->DB->query("
			SELECT *
			FROM
			    `tbl_product`
			    LEFT JOIN `designer` ON `designer`.`des_id` = `tbl_product`.`designer`
			    LEFT JOIN `tbl_stock` ON `tbl_stock`.`prod_no` = `tbl_product`.`prod_no`
			WHERE
			    `tbl_product`.`categories` LIKE '%1%' ESCAPE '!'
			    AND (`tbl_product`.`public` = 'Y' OR `tbl_product`.`public` = 'N')
			    AND `designer`.`view_status` = 'Y'
			GROUP BY
			    `tbl_product`.`prod_no`
			ORDER BY
			    `seque` ASC,
			    `tbl_product`.`prod_no` DESC,
			    `tbl_product`.`prod_id` DESC,
			    `tbl_stock`.`primary_color` DESC
		");

		//echo $this->DB->last_query(); die();

		$i = 1;
		foreach ($q1->result() as $r1)
		{
			$this->DB->set('seque', $i);
			$this->DB->where('prod_id', $r1->prod_id);
			$this->DB->update('tbl_product');

			$i++;
		}

		echo 'Done';
	}

	// ----------------------------------------------------------------------

}
