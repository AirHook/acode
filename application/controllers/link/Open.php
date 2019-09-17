<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Image tag placed on email whose src tag is the url for this script.
 * Once email is opened, the tracker image tag sends a request to the server.
 * From that request, this script can then get information like the "id"
 * and considers that the email is opened and read.
 *
 * Sample tracker image tag:
 * <img src="<?php echo base_url(); ?>link/open.html?id=<?php echo @emailtracker_id; ?>" alt="" />
 *
 * sample tracker id:
 * 		id=1234wi0010t1234567890123456
 * breaks down into as follows:
 *		1234 - user id
 *		w - w/c(/a/s/v/d) - wholesale/consumer(/admin/sales/vendor/designer)
 *		i - just a separator used for processing data
 *		0010 - email type id -> activation email
 *		t - separator as timestamp ($ts)
 *		1234567890123456 - timestamp serving as unique email id
 *
 * email types id:
 *		0010 - activation
 *		0011 - onsale []['rotation of prod_ids']
 *		0012 - instock [][]
 *		0013 - general [][]
 * 		0014 - sales package [sp_ids]
 *		0015 - special sale invite
 *		0016 - product email
 *		0017 - vendor po
 *
 * saved to user option as:
 * option[emailtrack][0010][$ts] = <#oftimes>
 * option[emailtrack][0011][$ts] = <#oftimes>
 *
 * Helpfull link:
 * https://stackoverflow.com/questions/5448381/tracking-email-with-php-and-image
 *
 */
class Open extends MY_Controller {

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

		// return image
		/* */
		header("Content-Type: image/gif"); // it will return image
		readfile("./assets/images/blank.gif");
		// */

		/***********
		 * Code here...
		 */

		// grab and breakdown email id
		$id = $this->input->get('id');

		if ($id)
		{
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

			// load pertinent library/model/helpers
			$this->load->library('users/vendor_user_details');
			$this->load->library('users/consumer_user_details');
			$this->load->library('users/wholesale_user_details');

			// at the moment, tracking only for consumer and wholesale user
			switch ($user_code)
			{
				case 'v':
					$db_table = 'vendors';
					$id_label = 'vendor_id';
					$user_details = $this->vendor_user_details->initialize(
						array(
							'vendor_id' => $user_id
						)
					);
				break;
				case 'c':
					$db_table = 'tbluser_data';
					$id_label = 'user_id';
					$user_details = $this->consumer_user_details->initialize(
						array(
							'user_id' => $user_id
						)
					);
				break;
				case 'w':
					$db_table = 'tbluser_data_wholesale';
					$id_label = 'user_id';
					$user_details = $this->wholesale_user_details->initialize(
						array(
							'user_id' => $user_id
						)
					);
				break;
			}

			// get user options if any...
			$options = $user_details->options;

			// set email track option
			$options['emailtrack'][$email_type][$ts] =
				isset($options['emailtrack'][$email_type][$ts])
				? $options['emailtrack'][$email_type][$ts] + 1
				: 1
			;

			// connect to database
			$DB = $this->load->database('instyle', TRUE);
			$DB->set('options', json_encode($options));
			$DB->where($id_label, $user_id);
			$DB->update($db_table);
		}

		exit;
	}

	// ----------------------------------------------------------------------

}
