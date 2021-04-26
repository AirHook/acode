<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 *
 *
 */
class Resize extends MY_Controller
{
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();
	}

	// --------------------------------------------------------------------

	/**
	 * Primary method - index
	 *
	 * @return	void
	 */
	function index($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			//echo 'An order ID# is needed...';
			//exit;
		}

		// load pertinent library/model/helpers
		$this->load->library('image_lib');

		/**
		// GALLERY THUMBS
		// crunch the image
		*/
		$config['image_library']	= 'gd2';
		$config['quality']			= '80%';
		$config['source_image'] 	= 'uploads/products/basixblacklabel/womens_apparel/dresses/evening_dresses/D7806L_BLACSILV1_f.jpg';
		$config['new_image'] 		= 'uploads/products/basixblacklabel/womens_apparel/dresses/evening_dresses/D7806L_BLACSILV1_f6a1.jpg';
		$config['maintain_ratio'] 	= TRUE;
		$config['width']         	= 600;
		$config['height']       	= 900;
		$this->image_lib->initialize($config);
		if ( ! $this->image_lib->resize())
		{
			// catch errors
			echo 'An error occurred crunching images.';
			exit;
		}
		$this->image_lib->clear();
		// */

		echo 'success';
	}

	// --------------------------------------------------------------------

}
