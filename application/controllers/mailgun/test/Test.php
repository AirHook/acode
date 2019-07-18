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
		if(isset($_POST)){
			print_r($_POST);
			$array_data = array(
		'from'=> ' expertcoder04@gmail.com',
		'to'=>'developer.ranjan88@gmail.com',
		'subject'=>$_POST['name'],
		//'html'=>$html,
		'text'=>$_POST['message'],
    );
    $session = curl_init('https://api.mailgun.net/v3/sandbox2eed136e964a4da6bdc8cb8761d8a85d.mailgun.org/messages');
    curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  	curl_setopt($session, CURLOPT_USERPWD, 'api:39f733fa0bb3e120eab364505ae06692-afab6073-9c4e4342');
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
