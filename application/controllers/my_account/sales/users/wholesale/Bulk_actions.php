<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_actions extends Sales_user_Controller {

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
	 * Index - Bulk Actions
	 *
	 * Execute actions selected on bulk action dropdown to multiple selected
	 * sales pakcages
	 *
	 * @return	void
	 */
	public function index()
	{
		echo 'Processing...';

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// load pertinent library/model/helpers
		$this->load->library('user_agent');
		$this->load->library('users/wholesale_user_details');

		// set database set clause based on bulk_action for activate and suspend
		switch ($this->input->post('bulk_action'))
		{
			case 'ac':
				$status = '1';
				$DB->set('active_date', date('Y-m-d', time()));
				$DB->set('is_active', '1');
			break;

			case 'deac':
				$status = '0';
				$DB->set('active_date', '');
				$DB->set('is_active', '0');
			break;

			case 'su':
				$status = '2';
				$DB->set('active_date', '');
				$DB->set('is_active', '2');
			break;
		}

		// iterate through the selected checkboxes and where clause
		foreach ($this->input->post('checkbox') as $key => $id)
		{
			// set database query clauses
			if ($key === 0) $DB->where('user_id', $id);
			else $DB->or_where('user_id', $id);

			// get and set item details
			$this->wholesale_user_details->initialize(array('user_id'=>$id));

			// remove from recent items
			// update recent list for edited vendor users
			if ($this->input->post('bulk_action') === 'del')
			{
				// update recent items -> currently not used
				$this->webspace_details->update_recent_users(
					array(
						'user_type' => 'wholesale_users',
						'user_id' => $id,
						'user_name' => $this->wholesale_user_details->store_name
					),
					'remove'
				);
			}

			if (
				$this->input->post('bulk_action') == 'deac'
				OR $this->input->post('bulk_action') == 'su'
				OR $this->input->post('bulk_action') === 'del'
			)
			{
				// remove user from mailgun list
				// only basix for now
				$params['address'] = $this->wholesale_user_details->email;
				$params['list_name'] = 'wholesale_users@mg.shop7thavenue.com';
				$this->load->library('mailgun/list_member_delete', $params);
				$res = $this->list_member_delete->delete();
			}

			if ($this->input->post('bulk_action') == 'ac')
			{
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
			}
		}

		// note in comments
		$comments = 'Previously associated with '
			.$this->wholesale_user_details->reference_designer
			.' under sales agent '
			.$this->wholesale_user_details->admin_sales_email
			.'<br />'
		;

		// update or delete items from database
		if ($this->input->post('bulk_action') === 'del')
		{
			// all sales user cannot delete users
			// instead, remove sales user association with user
			$DB->set('admin_sales_id', NULL);
			$DB->set('admin_sales_email', NULL);
			$DB->set('reference_designer', NULL);
			$DB->set('is_active', '0');
			$DB->set('comments', $comments);

			// set flash data
			$this->session->set_flashdata('success', 'delete');
		}
		else
		{
			// set flash data
			$this->session->set_flashdata('success', 'edit');
		}

		// update records
		$DB->update('tbluser_data_wholesale');

		// redirect user
		if ($this->agent->is_referral())
		{
			redirect($this->agent->referrer(), 'location');
		}
		else redirect('my_account/sales/users/wholesale', 'location');
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
