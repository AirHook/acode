<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailgun_maillist
{
	private $CI;
	private $key;
	private $url;
	
	public $mailing_list_name,$mailing_list_description,$mailing_list_address,$member_list;
	
	//private $member_suburl = "lists/$mailing_list_address/members.json";
	
	public function __construct()
    {		
        $this->CI = get_instance();
		$this->CI->config->load('api');
		$this->url = $this->CI->config->item('mailgun_api_url');
		$this->key = $this->CI->config->item('mailgun_api');		
    }
	
	/*****CREATE MAILLING LIST*******/
	
	public function Create_MailingList(){
		$array_data = array(
			'address'=> $this->mailing_list_address,
			'name'=>$this->mailing_list_name,//'developer.ranjan88@gmail.com',//rsbgm@rcpixel.com,rsbgm@instylenewyork.com,
			'description'=>$this->mailing_list_description,
		);
		$session = curl_init($this->url.'/lists');
		curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($session, CURLOPT_USERPWD, 'api:'.$this->key);
		curl_setopt($session, CURLOPT_POST, true);
		curl_setopt($session, CURLOPT_POSTFIELDS, $array_data);
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_ENCODING, 'UTF-8');
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($session);
		if (curl_errno($session)) {
			echo 'Error:' . curl_error($session); 
		}		
		curl_close($session);  
		$results = json_decode($response, true);
		print_r($results); 
	}
	
	/**********END****************/
	/*****GET MAILLING LIST*******/
	public function GetMailingList(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url.'/lists/pages');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_USERPWD, 'api' . ':' . $this->key);
		$result1 = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		echo "<pre>"; print_r($result1);
		
	}
	/**********END****************/
	/*********Add Members ********/
	
	public function AddMembers(){
		$array_data = array(
		"members"=>$this->member_list,
		'upsert' => true
		); 
		$session = curl_init($this->url.'/lists/'.$this->mailing_list_address.'/members.json');
		curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($session, CURLOPT_USERPWD, 'api:'.$this->key);
		curl_setopt($session, CURLOPT_POST, true);
		curl_setopt($session, CURLOPT_POSTFIELDS, $array_data);
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_ENCODING, 'UTF-8');
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($session);
		if (curl_errno($session)) {
			echo 'Error:' . curl_error($session); 
		}		
		curl_close($session);  
		$results = json_decode($response, true); 
		print_r($results); 
	}
}