<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailgun
{
    /**
	 * Email header FROM - required
     *
     * Formats:
     *      you@your_domain.com
     *      Your Name <you@your_domain.com>
	 *
	 * @var	string
	 */
    public $from = '';

    /**
	 * Email header TO, CC, BCC
     *
     * Formats:
     *      you@your_domain.com
     *      Your Name <you@your_domain.com>
     * Can be comma separated for multiple addresses
	 *
	 * @var	string
	 */
    public $to;
    public $cc;
    public $bcc;

    /**
	 * Email Subject
	 *
	 * @var	string
	 */
	public $subject;

    /**
	 * Email Message
	 *
	 * @var	string
	 */
	public $message;

    /**
	 * Error Message
	 *
	 * @var	string
	 */
	public $error_message;

    /**
	 * Mailgun Text/HTML params
	 *
	 * @var	boolean
	 */
	public $ishtml = true;

    /**
	 * Mailgun API Key
	 *
	 * @var	string
	 */
	protected $key;

    /**
	 * Mailgun API Domain
	 *
	 * @var	string
	 */
	protected $domain;


    /**
	 * CI Instance
	 *
	 * @var	object
	 */
	protected $CI;

    /**
	 * Constructor
	 *
	 * @return	void
	 */
    public function __construct()
    {
        $this->CI = get_instance();

        // set some default properties
		$this->domain = $this->CI->config->item('mailgun_domain');
		$this->key = $this->CI->config->item('mailgun_api');

        log_message('info', 'Mailgun Class Loaded');
    }

    // ----------------------------------------------------------------------

    public function Send()
    {
        if (
            ! $this->from
            OR ! $this->to
        )
        {
            // nothing more to do...
            $this->error_message = 'FROM/TO field is required.'

            return FALSE;
        }

        if ( ! $this->message)
        {
            // nothing more to do...
            $this->error_message = 'MESSAGE field is required.'

            return FALSE;
        }

        // some non-required items
        if ($this->cc) $params['cc'] = $this->cc;
        if ($this->bcc) $params['bcc'] = $this->bcc;

        // set main email header params accordingly
        $params['from'] = $this->from;
        $params['to'] = $this->to;
        $params['subject'] = $this->subject;

        // the message
		if ($this->ishtml)
        {
			$params['html'] = $this->message;
		}
        else
        {
			$params['text']=$this->message;
		}

        // let do the curl
        $session = curl_init($this->domain.'/messages');

        // set settings
        curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($session, CURLOPT_USERPWD, 'api:'.$this->key);
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);

        // get response
        $response = curl_exec($session);

        // close curl
        curl_close($session);

        $results = json_decode($response, true);

        if ($results["message"] == "Queued. Thank you.")
        {
            // successful
        	return TRUE;
        }
        else
        {
            // check the error
            $this->error_message = $results["message"];

        	return FALSE;
        }
    }

    // ----------------------------------------------------------------------

}
