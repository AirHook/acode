<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Unsubscribe user.
 * Currently makes the user status inactive/suspended/optedout
 * In future, we will need to add the page 'Manage Subscription'
 *
 * Sample tracker image tag:
 * https="<?php echo base_url(); ?>link/unsubscribe.html?id=<?php echo @$emailtracker_id; ?>" alt="" />
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
 *
 * saved to user option as:
 * option[unsubscribe][0011][$ts] = <#oftimes>
 * option[unsubscribe][0012][$ts] = <#oftimes>
 *
 */
class Unsubscribe extends MY_Controller
{
	/**
	 * Email Type
	 *
	 *		0010 - activation
	 *		0011 - onsale []['rotation of prod_ids']
	 *		0012 - instock [][]
	 *		0013 - general [][]
	 * 		0014 - sales package [sp_ids]
	 *		0015 - special sale invite
	 *		0016 - product email
	 *
	 * @return	string
	 */
	private $email_type;

	/**
	 * User Details
	 *
	 * @return	object
	 */
	private $user_details;


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
			$email_type_code = array_pop($email_id_ary);
			$email_id_ary = implode('i', $email_id_ary);

			switch ($email_type_code)
			{
				case '0010': $this->email_type = 'Activation Email'; break;
				case '0011': $this->email_type = 'On Sale Products Email'; break;
				case '0012': $this->email_type = 'In Stock Products Email'; break;
				case '0013': $this->email_type = 'General Products Email'; break;
				case '0014': $this->email_type = 'Sales Pacakge Email'; break;
				case '0015': $this->email_type = 'Special Sale Invite Email'; break;
				case '0016': $this->email_type = 'Product Item Email'; break;
				default: $this->email_type = 'Newsletter Email';
			}

			// get the user code
			$user_code = $email_id_ary[strlen($email_id_ary) - 1];

			// get the user id
			$user_id = rtrim($email_id_ary, $user_code);

			// load pertinent library/model/helpers
			$this->load->library('users/wholesale_user_details');
			$this->load->library('users/consumer_user_details');

			// at the moment, tracking only for consumer and wholesale user
			switch ($user_code)
			{
				case 'w':
					$db_table = 'tbluser_data_wholesale';
					$this->user_details = $this->wholesale_user_details->initialize(
						array(
							'user_id' => $user_id
						)
					);
				break;

				case 'c':
					$db_table = 'tbluser_data';
					$this->user_details = $this->consumer_user_details->initialize(
						array(
							'user_id' => $user_id
						)
					);
				break;
			}

			// get user options if any...
			$options = $this->user_details->options;

			// set email track option
			$options['unsubscribe'][$email_type_code][$ts] =
				isset($options['unsubscribe'][$email_type_code][$ts])
				? $options['unsubscribe'][$email_type_code][$ts] + 1
				: 1
			;

			// connect to database
			$DB = $this->load->database('instyle', TRUE);
			$DB->set('is_active', '0');
			$DB->set('options', json_encode($options));
			$DB->where('user_id', $user_id);
			$DB->update($db_table);

			$this->_notify_admin();

			$this->load->view('unsubscribe_message');
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Notify Admin - Private
	 *
	 * @return	void
	 */
	private function _notify_admin()
	{
		// begin send email requet to isntyle admin
		$email_message = '
			<br /><br />
			Dear Admin,
			<br /><br />
			'.ucfirst($this->user_details->fname.' '.$this->user_details->lname).' ('.$this->user_details->email.') has UNSUBSCRIBED.<br />
			A click on an unsubscribe link has been detected from '.$this->email_type.'.<br />
			His or her status is now INACTIVE/SUSPENDED/OPTEDOUT.
			<br /><br />
			<br />
		';

		if (ENVIRONMENT == 'development') // ---> used for development purposes
		{
			// we are unable to send out email in our dev environment
			// so we check on the email template instead.
			// just don't forget to comment these accordingly
			echo $email_message;
			echo '<br /><br />';
		}
		else
		{
			// load email library
			$this->load->library('email');

			// notify admin
			$this->email->clear();

			$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);

			$this->email->to($this->webspace_details->info_email);

			$this->email->bcc($this->config->item('dev1_email')); // --> for debuggin purposes

			$this->email->subject('UNSUBSCRIBE Detected');
			$this->email->message($email_message);

			$this->email->send();
		}
	}

	// ----------------------------------------------------------------------

}
