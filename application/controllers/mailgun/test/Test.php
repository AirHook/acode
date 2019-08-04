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
		//$this->config->load('api');
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
			//Load library and send mail.  
			$this->load->library('mailgun/mailgun'); 
			$to = array('developer.ranjan88@gmail.com','joe@rcpixel.com','rsbgm@instylenewyork.com','rsbgm@rcpixel.com');
			$messageList = array(
				'message'=>array(
				'subject' => 'Campaign 5',
				'message' => 'Email sending number 005'
				)
			);
			$this->mailgun->SendMail($to,$messageList); 
		
		}
	}
}
