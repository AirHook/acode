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
			$to = 	array('developer.ranjan88@gmail.com'); //,'joe@rcpixel.com','rsbgm@instylenewyork.com','rsbgm@rcpixel.com'
			$this->mailgun->to =implode(',', $to); //,'joe@rcpixel.com','rsbgm@instylenewyork.com','rsbgm@rcpixel.com'
			$this->mailgun->messageList = array(
				'message'=>array(
				'subject' => 'Campaign 5',
				'message' => 'Email sending number 005'
				)
			);
			
			$this->mailgun->Send(); 
			$this->mailgun->clear();
		}
	}
	function SendMailToMailingList(){
		$this->load->library('mailgun/mailgun');			
		$this->mailgun->to ="devs@mg.shop7thavenue.com"; 
		$this->mailgun->messageList = array(
			'message'=>array(
			'subject' => 'Campaign 5',
			'message' => 'Email sent using Mailing List'
			)
		);
		$this->mailgun->Send(); 
		$this->mailgun->clear();
		
	}
	function CreateMailingList(){		
		if(isset($_POST)){			
			$this->load->library('mailgun/mailgun_maillist');
			$this->mailgun_maillist->mailing_list_address = "devs@mg.shop7thavenue.com";
			$this->mailgun_maillist->mailing_list_name = "Developers";
			$this->mailgun_maillist->mailing_list_description = "Developers Testing Mailing List";
			$this->mailgun_maillist->Create_MailingList();
		}		
	}
	function GetMailingList(){
		if(isset($_POST)){			
			$this->load->library('mailgun/mailgun_maillist');
			$this->mailgun_maillist->GetMailingList();
		}
	}
	
	function AddMembersToMailingList(){
		if(isset($_POST)){			
			$this->load->library('mailgun/mailgun_maillist');//'joe@rcpixel.com','rsbgm@instylenewyork.com','rsbgm@rcpixel.com'
			$this->mailgun_maillist->mailing_list_address = "devs@mg.shop7thavenue.com";
			$this->mailgun_maillist->member_list = '[{"name":"Joe","address": "Joe <joe@rcpixel.com>"},{"name": "Ray", "address": "Ray <rsbgm@instylenewyork.com>"},{"Name":"Ray 1","address":"Ray1<rsbgm@rcpixel.com>"},{"Name":"Hardeep","address":"Harddep<developer.ranjan88@gmail.com>"}]';
			$this->mailgun_maillist->AddMembers();
		}
		
	}
	
}
