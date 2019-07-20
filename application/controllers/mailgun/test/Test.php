<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require '/var/www/html/mysite/mailgun/vendor/autoload.php';
//use Mailgun\Mailgun;
class Test extends CI_Controller {
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();
	}
	function index()
	{
		$this->load->view('test/test');
	}
	function sendmail(){
		$this->config->load('api');
		$campaignList = array(
			'campaign1' => array(
				'subject'=> 'Campaign 1',
				'message'=> 'Email sending number 001'
			),
			'campaign2' => array(
				'subject'=> 'Campaign 2',
				'message'=> 'Email sending number 002'
			),
			'campaign3' => array(
				'subject' => 'Campaign 3',
				'message' => 'Email sending number 003'
			),
			'campaign4' => array(
				'subject' => 'Campaign 4',
				'message' => 'Email sending number 004'
			),
			'campaign5' => array(
				'subject' => 'Campaign 5',
				'message' => 'Email sending number 005'
			),
		);
		if(isset($_POST)){
			foreach($campaignList as $campaign){	
				$array_data = array(
					'from'=> 'expertcoder04@gmail.com',
					'to'=>'rsbgm@rcpixel.com,rsbgm@instylenewyork.com,developer.ranjan88@gmail.com',
					'subject'=>$campaign['subject'],
				//'html'=>$html,
					'text'=>$campaign['message'],
				);
			
				$domain = $this->config->item('mailgun_domain');
				$key = $this->config->item('mailgun_api');
				
				
				$session = curl_init($domain.'/messages');
				curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($session, CURLOPT_USERPWD, 'api:'.$key);
				curl_setopt($session, CURLOPT_POST, true);
				curl_setopt($session, CURLOPT_POSTFIELDS, $array_data);
				curl_setopt($session, CURLOPT_HEADER, false);
				curl_setopt($session, CURLOPT_ENCODING, 'UTF-8');
				curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
				$response = curl_exec($session); 
				curl_close($session);  
				$results = json_decode($response, true);
				print_r($results);
			}
		}
	}
}
