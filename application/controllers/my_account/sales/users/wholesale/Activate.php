<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activate extends Sales_user_Controller {

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
	 * Index - Activate Account
	 *
	 * @return	void
	 */
	public function index($id = '', $page = '', $activation_email = '')
	{
		echo 'Processing...';

		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/sales/users/wholesale'.($page != 'search' ? '/'.$page : ''), 'location');
		}

		// udpate record
		$DB = $this->load->database('instyle', TRUE);
		$DB->set('active_date', date('Y-m-d', time()));
		$DB->set('is_active', '1');
		$DB->where('user_id', $id);
		$DB->update('tbluser_data_wholesale');

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');

		// get user details
		$this->wholesale_user_details->initialize(array('user_id' => $id));

		// basix only for now
		if ($this->wholesale_user_details->reference_designer == 'basixblacklabel')
		{
			// add user to mailgun list
			// no need to validate email as these are stores
			// force add users to mailgun
			$params['address'] = $this->wholesale_user_details->email;
			$params['fname'] = $this->wholesale_user_details->fname;
			$params['lname'] = $this->wholesale_user_details->lname;
			$params['vars'] = '{"store_name":"'.$this->wholesale_user_details->store_name.'"}';
			$params['description'] = 'Wholesale User';
			$params['list_name'] = 'wholesale_users@mg.shop7thavenue.com';
			$this->load->library('mailgun/list_member_add', $params);
			$res = $this->list_member_add->add();
			$this->list_member_add->clear();
		}

		// send activation email where necessary
		if ($activation_email)
		{
			// load and initialize wholesale activation email sending library
			$this->load->library('users/wholesale_activation_email_sending');
			$this->wholesale_activation_email_sending->initialize(array('users'=>array($this->wholesale_user_details->email)));

			if ( ! $this->wholesale_activation_email_sending->send())
			{
				echo $this->wholesale_activation_email_sending->error;
				$this->session->set_flashdata('error', 'error_sending_activation_email');
				$this->session->set_flashdata('error_message', $this->wholesale_activation_email_sending->error);

				// redirect user
				redirect('my_account/sales/users/wholesale/'.$page, 'location');
			}

			// set flash data
			$this->session->set_flashdata('success', 'acivation_email_sent');
		}

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect('my_account/sales/users/wholesale'.($page != 'search' ? '/'.$page : ''), 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * Request to validate all emails of the mailing list
	 *
	 * @return	void
	 */
	private function _add_user_to_mg($users_ary = array())
	{
		if (empty($users_ary))
		{
			// nothing more to do...
			return FALSE;
		}

		// set main email header params accordingly
		$params['upsert'] = TRUE;
		$params['members'] = json_encode($users_ary);

		// set vars per user to be able to access it as %recipient.yourvars%
		//$params['vars'] = '{"designer":"Basix Black Labe",...}'

		// let do the curl
		$csess = curl_init('https://api.mailgun.net/v3/lists/wholesale_users@mg.shop7thavenue.com/members.json');

		// set settings
		curl_setopt($csess, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($csess, CURLOPT_USERPWD, 'api:'.$this->key);
		curl_setopt($csess, CURLOPT_POST, true);
		curl_setopt($csess, CURLOPT_POSTFIELDS, $params);
		curl_setopt($csess, CURLOPT_HEADER, false);
		//curl_setopt($csess, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); // used for attachments
		curl_setopt($csess, CURLOPT_ENCODING, 'UTF-8');
		curl_setopt($csess, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($csess, CURLOPT_SSL_VERIFYPEER, false);

		// get response
		$response = curl_exec($csess);

		// close curl
		curl_close($csess);

		// convert to array
		$results = json_decode($response, true);

		return $response;
	}

	// ----------------------------------------------------------------------

}
