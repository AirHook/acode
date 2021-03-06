<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permanent_fail extends MY_Controller {

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
			if ($data['event-data']['event'] != 'failed')
			{
				echo 'Invalid event - '.$data['event-data']['event'];
				exit;
			}

			// there are two fails from mailgun - temporary and permanent
			// we get the permanent fail using the 'severity' index
			if ($data['event-data']['severity'] != 'permanent')
			{
				echo 'Invalid severity - '.$data['event-data']['severity'];
				exit;
			}

			// load pertinent library/model/helpers
			$this->load->library('users/consumer_user_details');

			if ($this->consumer_user_details->initialize(array('email'=>$data['event-data']['recipient'])))
			{
				// delete item from records
				$DB->where('email', $data['event-data']['recipient']);
				$DB->delete('tbluser_data');

				// remove user from mailgun list
				// only basix for now
				$params['address'] = $data['event-data']['recipient'];
				$params['list_name'] = 'consumers@mg.shop7thavenue.com';
				$this->load->library('mailgun/list_member_delete', $params);
				$res = $this->list_member_delete->delete();

				echo 'Records updated - '.$DB->affected_rows().' affected rows.';
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
            [timestamp] => 1582916161
            [token] => 8f581b6c143724e4a355be61e5cecc8fe3c8152d50003ca653
            [signature] => 1386fea9afc892905499e25c818aadee94b065ffbef68a7094167285e962ec11
        )

    [event-data] => Array
        (
            [severity] => permanent
            [tags] => Array
                (
                    [0] => my_tag_1
                    [1] => my_tag_2
                )

            [timestamp] => 1521233195.3756
            [storage] => Array
                (
                    [url] => https://se.api.mailgun.net/v3/domains/mg.shop7thavenue.com/messages/message_key
                    [key] => message_key
                )

            [log-level] => error
            [event] => failed
            [campaigns] => Array
                (
                )

            [reason] => suppress-bounce
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

            [recipient-domain] => example.com
            [envelope] => Array
                (
                    [sender] => bob@mg.shop7thavenue.com
                    [transport] => smtp
                    [targets] => alice@example.com
                )

            [message] => Array
                (
                    [headers] => Array
                        (
                            [to] => Alice <alice@example.com>
                            [message-id] => 20130503192659.13651.20287@mg.shop7thavenue.com
                            [from] => Bob <bob@mg.shop7thavenue.com>
                            [subject] => Test permanent_fail webhook
                        )

                    [attachments] => Array
                        (
                        )

                    [size] => 111
                )

            [recipient] => alice@example.com
            [id] => G9Bn5sl1TC6nu79C8C0bwg
            [delivery-status] => Array
                (
                    [code] => 605
                    [message] =>
                    [attempt-no] => 1
                    [description] => Not delivering to previously bounced address
                    [session-seconds] => 0
                )

        )
	*/

	// ----------------------------------------------------------------------

}
