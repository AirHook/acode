<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_preset extends Admin_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - Sales Package View
	 *
	 * Open and view existing sales package for edit/sending
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		if ( ! $this->input->post())
		{
			// nothing more to do...
			echo 'There is no post data.';
			exit;
		}

		// grab the post variable
		//$des_slug = 'basixblacklabel';
		$des_slug = $this->input->post('des_slug');

		// load pertinent library/model/helpers
		$this->load->library('categories/categories_tree');

		// get the designer category tree
		$this->data['des_subcats'] = $this->categories_tree->treelist(
			array(
				'd_url_structure' => $des_slug,
				'with_products' => TRUE
			)
		);
		$this->data['row_count'] = $this->categories_tree->row_count;
		$this->data['max_level'] = $this->categories_tree->max_category_level;

		// generate category tree list




		// capture existing items and option and set flags to indicate
		// coming from existing sales package
		$this->session->set_userdata('admin_sa_items', json_encode($items_array));
		$this->session->set_userdata('admin_sa_name', $sales_package_name);
		$this->session->set_userdata('admin_sa_email_subject', $email_subject);
		$this->session->set_userdata('admin_sa_email_message', $email_message);

		// capture data to send back
		$array['sales_package_name'] = $sales_package_name;
		$array['email_subject'] = $email_subject;
		$array['email_message'] = $email_message;

		echo json_encode($array);
		exit;
	}

	// ----------------------------------------------------------------------

}
