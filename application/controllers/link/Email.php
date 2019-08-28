<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Links embeded on email campaigns will be sent here for processing.
 * Campaigns include activation, email invites, product emails, sales pacakge,
 * or special offers, and other product related emails and newsletters.
 * Clicktracks are always for product pages link to either thumbs or product
 * details page.
 *
 * Email campaigns usually includes 30 items of a certain collection (onsale/
 * instock/general), and is rotated to next 30 items on next email. This can
 * be tracked on user options as follows:
 *
 * 		$items = array(30 items);
 *		options[campaign][0011][$ts] = $items;
 *		where:
 *			0011 - onsale
 *			0012 - instock
 *			0013 - general
 *			ts - timestamp (to coincide with the "t" query variable on clicktrack link)
 *
 * This is based on front end sequencing. Saving items is in anticipation of
 * frontend sequencing is changed.
 *
 * Links are generated as follows:
 * Sample link:
 * href="<?php echo base_url(); ?>link/email.html?id=<?php echo @clicktracker_id; ?>"
 * href="<?php echo base_url(); ?>link/email.html?id=<?php echo @clicktracker_id; ?>&item=<prod_no>_<color_code>"
 *
 * sample tracker id:
 * 		id=1234wi0010t1234567890123456&item=<>
 * breaks down into as follows:
 *		1234 - user id
 *		w - w/c(/a/s/v/d) - wholesale/consumer(/admin/sales/vendor/designer)
 *		i - just a separator used for processing data
 *		0010 - email type id -> activation email
 *		t - separator as timestamp ($ts)
 *		1234567890123456 - timestamp serving as unique email id
 *			if item is present:
 *		item - <prod_no>_<color_code> click on thumbs to product details page
 *
 * email types id:
 *		0010 - activation
 *		0011 - onsale []['rotation of prod_ids']
 *		0012 - instock [][]
 *		0013 - general [][]
 * 		0014 - sales package [sp_ids]
 *		0015 - special sale invite
 *		0016 - product email
 *
 * saved to user option as:
 * option[clicktrack][0011][$ts] = <#oftimes>
 * option[clicktrack][0012][$ts] = <#oftimes>
 *
 *
 *
 * Helpfull link:
 * https://stackoverflow.com/questions/5448381/tracking-email-with-php-and-image
 *
 */
class Email extends MY_Controller {

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
	 * Index - default method
	 *
	 * Add/Remove selected items to Sales Package
	 * Using session
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		/***********
		 * Code here...
		 */

		// grab and breakdown email id and then some...
		$id = $this->input->get('id');
		$item = $this->input->get('item');
		$uri = $this->input->get('uri');

		if ($id)
		{
			// load pertinent library/model/helpers
			$this->load->library('users/wholesale_user_details');
			$this->load->library('users/consumer_user_details');
			$this->load->library('products/product_details');

			// get timestamp
			$email_id_ary = explode('t', $id);
			$ts = array_pop($email_id_ary);
			$email_id_ary = implode('t', $email_id_ary);

			// get email type id
			$email_id_ary = explode('i', $email_id_ary);
			$email_type = array_pop($email_id_ary);
			$email_id_ary = implode('i', $email_id_ary);

			// get the user code
			$user_code = $email_id_ary[strlen($email_id_ary) - 1];

			// get the user id
			$user_id = rtrim($email_id_ary, $user_code);

			// at the moment, tracking only for consumer and wholesale user
			switch ($user_code)
			{
				case 'w':
					$db_table = 'tbluser_data_wholesale';
					$user_details = $this->wholesale_user_details->initialize(
						array(
							'user_id' => $user_id
						)
					);
				break;

				case 'c':
					$db_table = 'tbluser_data';
					$user_details = $this->consumer_user_details->initialize(
						array(
							'user_id' => $user_id
						)
					);
				break;
			}

			// get user options if any...
			$options = $user_details->options;

			// set clicktrack option
			$options['clicktrack'][$email_type][$ts] =
				isset($options['clicktrack'][$email_type][$ts])
				? $options['clicktrack'][$email_type][$ts] + 1
				: 1
			;

			// connect to database
			$DB = $this->load->database('instyle', TRUE);
			$DB->set('options', json_encode($options));
			$DB->where('user_id', $user_id);
			$DB->update($db_tablel);

			if ($item)
			{
				// send to product details page
				// get product details
				$exp = explode('_', $item);
				$product = $this->product_details->initialize(
					array(
						'tbl_product.prod_no' => $exp[0],
						'color_code' => $exp[1]
					)
				);

				// redired user...
				rediect(
					'shop/details/'
					.$product->designer_slug
					.'/'.$product->prod_no
					.'/'.$product->color_name
					.'/'.$product->prod_desc,
					'location'
				);
			}
			else
			{
				switch ($email_type)
				{
					case '0011':
						$param = 'onsale';
					break;
					case '0012':
						$param = 'instock';
					break;
					case '0013':
					default:
						$param = '';
				}

				redirect('shop/womens_apparel.html?filter=&availability=onsale');
			}
		}
	}

	// ----------------------------------------------------------------------

}
