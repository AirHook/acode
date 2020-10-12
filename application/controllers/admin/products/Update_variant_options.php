<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_variant_options extends Admin_Controller {

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

		$this->output->enable_profiler(FALSE);

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * @return	void
	 */
	public function index()
	{
		if ($_POST)
		{
			$post_ary = $_POST;

			// check for $options posted
			if (@$post_ary['options'])
			{
				// get variant options data
				$this->DB->select('options');
				$this->DB->where('st_id', $post_ary['st_id']);
				$q1 = $this->DB->get('tbl_stock');
				$r1 = $q1->row();
				$options = json_decode($r1->options, TRUE);

				$stocks_options = array_merge($options, $post_ary['options']);

				$post_ary['options'] = json_encode($stocks_options);
			}

			// update stock record
			$this->DB->set($post_ary);
			$this->DB->where('st_id', $post_ary['st_id']);
			$q = $this->DB->update('tbl_stock');

			echo 'Success';
		}
		else echo 'Uh oh...';
	}

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * @return	void
	 */
	public function facets()
	{
		if ($_POST)
		{
			// update stock record
			$this->DB->set($_POST);
			$this->DB->where('prod_id', $_POST['prod_id']);
			$q = $this->DB->update('tbl_product');

			echo 'Done';
		}
		else echo 'Uh oh...';
	}

	// ----------------------------------------------------------------------

}
