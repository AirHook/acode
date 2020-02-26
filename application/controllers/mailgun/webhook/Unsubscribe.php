<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unsubscribe extends MY_Controller {

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
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index()
	{
		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// Takes raw JSON data from the request
		$json = file_get_contents('php://input');

		if ($json)
		{
			// Converts into a PHP array
			// see sample raw JSON data request at the bottom
			$data = json_decode($json, TRUE);

			if ( ! $this->_verify_signature($data['signature']['token'], $data['signature']['timestamp'], $data['signature']['signature']))
			{
				echo 'Invalid signatures.';
				exit;
			}

			// this class is to capture unsubscribed users via mailgun webhook
			// even if this class is only for unsubscribes, we ensure by checking event being 'unsubscribed'
			if ($data['event-data']['event'] != 'unsubscribed')
			{
				echo 'Invalid event - '.$data['event-data']['event'];
				exit;
			}

			// load pertinent library/model/helpers
			$this->load->library('users/consumer_user_details');

			if ($this->consumer_user_details->initialize(array('email'=>$data['event-data']['recipient'])))
			{
				// set user to optout
				$DB->set('receive_productupd', '0');
				$DB->set('is_active', '3');
				$DB->where('email', $data['event-data']['recipient']);
				$DB->update('tbluser_data');

				// remove user from mailgun list
				// only basix for now
				$params['address'] = $data['event-data']['recipient'];
				$params['list_name'] = 'consumers@mg.shop7thavenue.com';
				$this->load->library('mailgun/list_member_delete', $params);
				$res = $this->list_member_delete->delete();

				echo 'Record updated - '.$DB->affected_rows().' affected rows.';
				exit;
			}
			else
			{
				echo 'No records found.';
				exit;
			}
		}
		else
		{
			echo 'There was no json data passed.';
			exit;
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Verify Mailgun Signature Token
	 * To prevent replay attacks
	 *
	 * @return	void
	 */
	private function _verify_signature($token, $timestamp, $signature)
	{
		// check if the timestamp is fresh
		/*
			// we need to verify timezone difference between server and mailgun
			// this may affect php function time() which invalidates this check
	    if (abs(time() - $timestamp) > 15) {
	        return false;
	    }
		*/

	    // returns true if signature is valid
	    return hash_hmac('sha256', $timestamp . $token, $this->config->item('mailgun_webhook_signinkey')) === $signature;
	}

	// ----------------------------------------------------------------------

	/*
	[signature] => Array
	(
	    [timestamp] => 1581957875
	    [token] => c226fa727a4641b34bb26a0958550175fa4ac9133f099bf6b7
	    [signature] => cecfb3612dd30cbea0aac11ddd944d4b4e5c967fb3396ac3d1689120967345ae
	)

	[event-data] => Array
	(
	    [tags] => Array
	        (
	            [0] => my_tag_1
	            [1] => my_tag_2
	        )

	    [timestamp] => 1521472262.9082
	    [storage] => Array
	        (
	            [url] => https://se.api.mailgun.net/v3/domains/mg.shop7thavenue.com/messages/message_key
	            [key] => message_key
	        )

	    [envelope] => Array
	        (
	            [sending-ip] => 209.61.154.250
	            [sender] => bob@mg.shop7thavenue.com
	            [transport] => smtp
	            [targets] => alice@example.com
	        )

	    [recipient-domain] => example.com
	    [id] => CPgfbmQMTCKtHW6uIWtuVe
	    [campaigns] => Array
	        (
	        )

	    [user-variables] => Array
	        (
	            [my_var_1] => Mailgun Variable #1
	            [my-var-2] => awesome
	        )

	    [flags] => Array
	        (
	            [is-routed] =>
	            [is-authenticated] => 1
	            [is-system-test] =>
	            [is-test-mode] =>
	        )

	    [log-level] => info
	    [message] => Array
	        (
	            [headers] => Array
	                (
	                    [to] => Alice
	                    [message-id] => 20130503182626.18666.16540@mg.shop7thavenue.com
	                    [from] => Bob
	                    [subject] => Test delivered webhook
	                )

	            [attachments] => Array
	                (
	                )

	            [size] => 111
	        )

	    [recipient] => alice@example.com
	    [event] => delivered
	    [delivery-status] => Array
	        (
	            [tls] => 1
	            [mx-host] => smtp-in.example.com
	            [attempt-no] => 1
	            [description] =>
	            [session-seconds] => 0.43319892883301
	            [utf8] => 1
	            [code] => 250
	            [message] => OK
	            [certificate-verified] => 1
	        )

	)
	*/

	// ----------------------------------------------------------------------

}
