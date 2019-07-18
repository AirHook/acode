<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends Frontend_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	// --------------------------------------------------------------------

	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function index()
	{
		// load pertinent library/model/helpers
		$this->load->model('get_pages');
		
		// get data
		if (isset($_SESSION['user_cat']) && $_SESSION['user_cat'] == 'wholesale')
		{
			$this->data['wholesale_ordering'] = $this->get_pages->details('wholesale_ordering.php');
			$this->data['wholesale_shipping'] = $this->get_pages->details('wholesale_shipping.php');
			$this->data['wholesale_return_policy'] = $this->get_pages->details('wholesale_return_policy.php');
			$this->data['wholesale_privacy_notice'] = $this->get_pages->details('wholesale_privacy_notice.php');
			$this->data['wholesale_order_status'] = $this->get_pages->details('wholesale_order_status.php');
			$this->data['wholesale_faq'] = $this->get_pages->details('wholesale_faq.php');
		}
		else
		{
			$this->data['ordering'] = $this->get_pages->details('ordering.php');
			$this->data['shipping'] = $this->get_pages->details('shipping.php');
			$this->data['returns'] = $this->get_pages->details('return_policy.php');
			$this->data['privacy'] = $this->get_pages->details('privacy_notice.php');
			$this->data['faq'] = $this->get_pages->details('faq.php');
			$this->data['press'] = $this->get_pages->details('press.php');
			$this->data['terms_of_use'] = $this->get_pages->details('terms_of_use.php');
			$this->data['contact'] = $this->get_pages->details('contact.php');
			$this->data['made_to_order'] = $this->get_pages->details('made_to_order.php');
		}
		
		// set data variables...
		$this->data['file'] = 'page';
		$this->data['page'] = 'sitemap';
		$this->data['page_title'] = $this->webspace_details->name;
		$this->data['page_description'] = $this->webspace_details->site_description;
		
		// load views...
		//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
		$this->load->view('metronic/template/template', $this->data);
	}
	
	// ----------------------------------------------------------------------
	
}
