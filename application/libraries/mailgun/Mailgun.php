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
    public $to = '';
    public $cc = '';
    public $bcc = '';

    /**
	 * Email Subject
	 *
	 * @var	string
	 */
	public $subject = '';

    /**
	 * Email Message
	 *
	 * @var	string
	 */
	public $message = '';

    /**
	 * Attachment
	 *
	 * @var	mixed
	 */
	public $attachment;

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
	public $ishtml = TRUE;

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
            $this->error_message = 'FROM/TO field is required.';

            return FALSE;
        }

        if ( ! $this->message)
        {
            // nothing more to do...
            $this->error_message = 'MESSAGE field is required.';

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
			$params['text'] = $this->message;
		}

        // attachments
        if ($this->attachment) $params['attachment'] = $this->attachment;

        // let do the curl
        $csess = curl_init($this->domain.'/messages');

        // set settings
        curl_setopt($csess, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($csess, CURLOPT_USERPWD, 'api:'.$this->key);
        curl_setopt($csess, CURLOPT_POST, true);
        curl_setopt($csess, CURLOPT_POSTFIELDS, $params);
        curl_setopt($csess, CURLOPT_HEADER, true);
        curl_setopt($csess, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
        curl_setopt($csess, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($csess, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($csess, CURLOPT_SSL_VERIFYPEER, false);

        // get response
        $response = curl_exec($csess);

        // close curl
        curl_close($csess);

        // convert to array
        $results = json_decode($response, true);

        // check for message error
        if ($results["message"] == "Queued. Thank you.")
        {
            // clear properties
            $this->clear();

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

    public function clear()
    {
        $this->from = '';
        $this->to = '';
        $this->cc = '';
        $this->bcc = '';
        $this->subject = '';
        $this->message = '';
        $this->ishtml = TRUE;
        $this->key = '';
        $this->domain = '';

        return $this;
    }

    // ----------------------------------------------------------------------

}
