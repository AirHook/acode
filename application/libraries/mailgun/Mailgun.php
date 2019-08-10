<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailgun
{
    private $CI;
	private $key;
	private $domain;
	public $to = array(), $messageList = array(),$ishtml = false;
	

    public function __construct()
    {		
        $this->CI = get_instance();
		$this->CI->config->load('api');
		$this->domain = $this->CI->config->item('mailgun_domain');
		$this->key = $this->CI->config->item('mailgun_api');		
    }

    public function Send()
    {	
		foreach($this->messageList as $campaign){	
		$array_data = array(
			'from'=> 'expertcoder04@gmail.com',
			'to'=>$this->to,//'developer.ranjan88@gmail.com',//rsbgm@rcpixel.com,rsbgm@instylenewyork.com,
			'subject'=>$campaign['subject'],
		);
		if($this->ishtml){
			$array_data['html']=$campaign['message'];
		}else{
			$array_data['text']=$campaign['message'];
		}		
		$session = curl_init($this->domain.'/messages');
		//$this->key;
		//$this->domain.'/messages'; 
		curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($session, CURLOPT_USERPWD, 'api:'.$this->key);
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
		// if(count($messageList)==1){
			// $this->sendSingleMail($to,$messageList['message'],$ishtml = true);
		// }
		// if(count($messageList)>1){			
			// $this->sendMultipleMails($to,$messageList,$ishtml = true);
		//}
    }
	public function clear(){
		foreach ($this as $key => $value) {
            unset($this->$key);
        }
	}
	private function sendSingleMail($to,$messageList,$ishtml = true){
		//TODO handle $to elements to start batch processing incase $to exceeds limit.
 
		$array_data = array(
			'from'=> 'expertcoder04@gmail.com',
			'to'=>$to,//'developer.ranjan88@gmail.com',//rsbgm@rcpixel.com,rsbgm@instylenewyork.com,
			'subject'=>$messageList['subject'],
		);
		if($ishtml){
			$array_data['html']=$messageList['message'];
		}else{
			$array_data['text']=$messageList['message'];
		}
		
		$session = curl_init($this->domain.'/messages');
		$this->key;
		$this->domain.'/messages'; 
		curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($session, CURLOPT_USERPWD, 'api:'.$this->key);
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
	private function sendMultipleMails($to,$messageList,$ishtml = true){
		//TODO handle $to elements to start batch processing incase $to exceeds limit.
		foreach($messageList as $campaign){	
			$array_data = array(
				'from'=> 'expertcoder04@gmail.com',
				'to'=>$to,//'developer.ranjan88@gmail.com',//rsbgm@rcpixel.com,rsbgm@instylenewyork.com,
				'subject'=>$campaign['subject'], 
			);
			if($ishtml){
				$array_data['html']=$campaign['message'];
			}else{
				$array_data['text']=$campaign['message'];
			}
			
			$session = curl_init($this->domain.'/messages');
			curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($session, CURLOPT_USERPWD, 'api:'.$this->key);
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