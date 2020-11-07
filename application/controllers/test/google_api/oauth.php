<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Oauth extends MY_Controller {

	/**
	 * Google Base URL
	 *
	 * @var	string
	 */
	protected $base_url = 'https://www.googleapis.com/content/v2.1/';

	/**
	 * Google Merchant ID
	 *
	 * @var	string
	 */
	protected $merchant_id = '6568666';


	/**
	 * DB Object
	 *
	 * @var	object
	 */
	protected $DB;

	// ----------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Create a Mailing List via API
	 *
	 * @return	void
	 */
	public function index()
	{
		// load pertinent library/model/helpers
		$this->load->library('api/google/google_api');
		//$this->load->library('accounts/account_details');

		// initialize google OAuth authorization
		$access_token = $this->google_api->initialize();

		// Google Content API v2.1 references (commands and request methods) for Products
		// https://developers.google.com/shopping-content/reference/rest/v2.1/products/list
		// query parameters
		//		maxResults (int) - The maximum number of products to return in the response, used for paging.
		//		pageToken (string) - The token returned by the previous request.
		$url1 = 'https://www.googleapis.com/content/v2.1/'
			.$this->merchant_id
			.'/products?maxResults=100'
		;
		$csess1 = curl_init($url1);

		$headers = array(
			'Authorization: Bearer '.$access_token,
			'Accept: application/json'
		);

		curl_setopt($csess1, CURLOPT_HTTPHEADER, $headers); // used for attachments
		curl_setopt($csess1, CURLOPT_RETURNTRANSFER, TRUE);

		// get response
        $response1 = curl_exec($csess1);

        // close curl
        curl_close($csess1);

		// convert to array
        $results1 = json_decode($response1, true);

		// get next page token
		// The token for the retrieval of the next page of products.
		$page_token = @$results1['nextPageToken'];

		echo '<pre>';
		print_r($results1);
		//echo count($results1['resources']);
		echo '<br />';
		echo '<br />';
		echo 'PAGE 1';
		echo '<br />';
		echo '<br />';

		$i = 2;
		while ($page_token)
		{
			$urlx = 'https://www.googleapis.com/content/v2.1/'
				.$this->merchant_id
				.'/products?pageToken='
				.$page_token
			;
			$csessx = curl_init($urlx);

			$headers = array(
				'Authorization: Bearer '.$access_token,
				'Accept: application/json'
			);

			//$params['pageToken'] = $page_token;

			//curl_setopt($csessx, CURLOPT_POST, true);
	        //curl_setopt($csessx, CURLOPT_POSTFIELDS, $params);
			curl_setopt($csessx, CURLOPT_HTTPHEADER, $headers); // used for attachments
			curl_setopt($csessx, CURLOPT_RETURNTRANSFER, TRUE);

			// get response
	        $responsex = curl_exec($csessx);

	        // close curl
	        curl_close($csessx);

			// convert to array
	        $resultsx = json_decode($responsex, true);

			// get next page token
			$page_token = @$resultsx['nextPageToken'];

			echo '<pre>';
			//print_r($resultsx);
			echo count($resultsx['resources']);
			echo '<br />';
			echo '<br />';
			echo 'PAGE '.$i;
			echo '<br />';
			echo '<br />';

			$i++;
		}


		echo 'Done';
	}

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Create a Mailing List via API
	 *
	 * @return	void
	 */
	public function update()
	{
		// load pertinent library/model/helpers
		$this->load->library('api/google/google_api');
		//$this->load->library('accounts/account_details');

		// initialize google OAuth authorization
		$access_token = $this->google_api->initialize();

		// Google Content API v2.1 references (commands and request methods) for Products
		// https://developers.google.com/shopping-content/reference/rest/v2.1/products/list
		// query parameters
		//		maxResults (int) - The maximum number of products to return in the response, used for paging.
		//		pageToken (string) - The token returned by the previous request.
		$url = 'https://www.googleapis.com/content/v2.1/'
			.$this->merchant_id
			.'/products'
		;
		$csess = curl_init($url);

		$headers = array(
			'Authorization: Bearer '.$access_token,
			'Content-Type: application/json'
		);

		// Image size requirements:
		// Non-apparel images: at least 100 x 100 pixels
		// Apparel images: at least 250 x 250 pixels
		// No image larger than 64 megapixels
		// No image file larger than 16MB


		$params['channel'] = 'online';
		$params['contentLanguage'] = 'en';
		$params['targetCountry'] = 'US';
		$params['offerId'] = 'D7806L';
		$params['title'] = 'Evening Dress by Basix Black Label';
		$params['description'] = 'Bugle beaded evening dresse by basix';
		$params['link'] = 'https://www.shop7thavenue.com/shop/details/basixblacklabel/D7806L/black-silver/d7806l/0of2.html';
		$params['imageLink'] = 'https://www.shop7thavenue.com/uploads/products/basixblacklabel/womens_apparel/dresses/evening_dresses/D7806L_BLACSILV1_f4.jpg';
		$params['availability'] = 'In Stock';
		$params['brand'] = 'Basix Black Label';
		$params['color'] = 'Black Silver';
		$params['material'] = 'Poly';
		$params['price'] = array(
			'value' => '395.00',
			'currency' => 'USD'
		);

		curl_setopt($csess, CURLOPT_POST, TRUE);
        curl_setopt($csess, CURLOPT_POSTFIELDS, json_encode($params));
		curl_setopt($csess, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($csess, CURLOPT_RETURNTRANSFER, TRUE);
		//curl_setopt($csess, CURLOPT_HEADER, TRUE);

		// get response
        $response = curl_exec($csess);

        // close curl
        curl_close($csess);

		// convert to array
        $results = json_decode($response, true);

		// get next page token
		// The token for the retrieval of the next page of products.
		//$page_token = @$results1['nextPageToken'];

		echo '<pre>';
		print_r($results);
		echo '<br />';
		echo '--';
		echo '<br />';
		echo '<br />';
		echo $response;
		echo '<br />';
		echo '<br />';

		echo 'Done';
	}

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Create a Mailing List via API
	 *
	 * @return	void
	 */
	public function original_test_code()
	{
		/*
		|   JWT explained
		|   https://developers.google.com/identity/protocols/oauth2/service-account
		|	A JWT is composed as follows:
		|	{Base64url encoded header}.{Base64url encoded claim set}.{Base64url encoded signature}
		*/

		//{Base64url encoded JSON header}
		$jwtHeader = $this->_base64url_encode(
			json_encode(
				array(
				    "alg" => "RS256",
				    "typ" => "JWT"
				)
			)
		);

		//{Base64url encoded JSON claim set}
		$now = time();
		$jwtClaim = $this->_base64url_encode(
			json_encode(
				array(
				    "iss" => $this->config->item('google_client_email'),
				    "scope" => $this->config->item('google_content_api_scope'),
				    "aud" => $this->config->item('google_token_uri'),
				    "exp" => strtotime(' + 5mins', $now),
				    "iat" => $now
				)
			)
		);

		// signature
		// The base string for the signature: {Base64url encoded JSON header}.{Base64url encoded JSON claim set}
		// get the private key from the content API key JSON file generated upon creating
		// the credentials for the service account as variable doesn't work
		openssl_sign(
		    $jwtHeader.".".$jwtClaim,
		    $jwtSig,
			"-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQC/PmV87yyWXcFY\nA+rsl/GetXXrc2XV3+PythPjghWAwTcmvtK1n8MobRtTFXG03s61uPPZS+XwPjqs\nC9VKByGscwTW24uSgQpCSqdgUJrUBFkcFdy7KHfqG9/hx2KfjnCIuJU9GZvJhw1c\nqdEpG84o7aVUEBaqo53nQ6DHlzY8asSrVTVobwr/gKQXoP/A3bwd9NqKiyV7Tm4q\nqqQbx0/HZVoD/vvvwr92KroyPCZmDU4hkJwHHBU7X50mM3J0Yt8x5S913q9K/HHa\nskMc1ttaeLdwISSfKLRg5f4/RZNyJAsJMwiTl5kXAKmoUvb/xDYak4SuxDhrNjGV\n/9++t0y9AgMBAAECggEAGgDS7dTbfCqNUnld5QOX79t+iCAttZH2vZayR5n1cIdV\nB2ik39s0Pvfu4jIlPtGYy661QVOHlU3wzlnhi2pC0t7kxo4dgTMYgQEDlx3+n1tj\n/mSembgb7fISU/G3YDiO5pgqep9Txmgdkf7pGKzWMEx30WFKo7MRklNothrCXh5u\nKTudta6PEgr9r0KpajNBsykZhrcK9ByJk4BkTVgOSykmRalfLn1lvlR2i2ux5AOx\nOrgYlG+xjNq8Kq2ZENltzstXhXUS3HS8Mx0Zxof5eZHQ35btfZgXNKaThV8G80vt\nHuoZfa6G0tC/clMDcy2mx5f7ySWhuowtWk1uVxYnxQKBgQDegMrq/dB/rOSPAWC2\nR8YDqnRH4LOZ4BgZ5//HgKPBHIPJPf8jBvV4hyvdb23kKWD7KVz88lgPGY9oMfxk\nraUq6k/XyBcRsvgY70w9Aqt+JyuBIUJdN23NMhxiLEfhB7px8FpJ/8Oa79D03aqY\nRE7sVkaceFom/geE9jplcEbyHwKBgQDcCOBzAFhAqy2STrFX11xFCWKAzLO6+ahV\nPG8rYyL+PjA2OfybANwYJILJktnT0BdcEI3ZYn9OQPJkqQKwZU7v09TwO65/aeP6\n7JFZgwHLL7PCoqX69TrsVSV6hVCZJ2vMUxoPveo20xw4goktZlx/Iys58QXd0yvc\nnZ967G59owKBgQCwcE740zZ/2BkSMZSAVx/1jjhROyUQkzxpZqhUinTQUI1MiqYE\nH6ON5RpqqM7qi8mEwUMkrgQYTTuD84diSrRb+JxBz0BD37iPBUteYfydt+/uoPIg\nOzEN83vAeb6x+k/lxCPE5FU3So5XbmO2BQzUqoGp2GIc43oQ/LRH9iW8HwKBgDrr\nUZbZ18fxTnGoCsr3yyhdW/gbWGFP6uhwF2Cp2jv0URqkKmUjNMxuMmthnFygkzC+\n6gz02BwPPhkAPM0ZQ6rqsVFm2dIae8a8RCuQ7hEHg/4xaXqq4g1Yu4F0Y2Gvcakz\n832VoDrwCtWC9tKmX0xYEYIhbS26FzurJYJX/zo7AoGAOuBry5ia55dIFWHaGODM\nQS+QkZlRrQ7EeMkC/XdXkBUJw0GOAC5glLyiYmh4boPfAIO+LZBMvO3IoxoCgCsl\nqbHV6GXO6UuSllPdaV9SXXOCcFZu4Mwcx157oeSKMeKiEDDDnn1yz0Pzsw5AnK5o\nN0urNN3O44FH/S+d702AnNk=\n-----END PRIVATE KEY-----\n",
		    "sha256WithRSAEncryption"
		);
		$jwtSig = $this->_base64url_encode($jwtSig);

		// post data
		// 'grant_type' from https://developers.google.com/identity/protocols/oauth2/service-account
		$params['grant_type'] = 'urn:ietf:params:oauth:grant-type:jwt-bearer';
		$params['assertion'] = $jwtHeader.'.'.$jwtClaim.'.'.$jwtSig;

		$url = 'https://oauth2.googleapis.com/token';
		$csess = curl_init($url);

        // set settings
        //curl_setopt($csess, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($csess, CURLOPT_USERPWD, 'api:'.$this->key);AIzaSyCM3r0fv-xCRPRJ8hIH1G4iVH_vQ9Wc-Ec
        curl_setopt($csess, CURLOPT_POST, true);
        curl_setopt($csess, CURLOPT_POSTFIELDS, $params);
        //curl_setopt($csess, CURLOPT_HEADER, TRUE); // TRUE to get HTTP header response, FALSE to get just the body
        //curl_setopt($csess, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); // used for attachments
        //curl_setopt($csess, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($csess, CURLOPT_RETURNTRANSFER, TRUE);
        //curl_setopt($csess, CURLOPT_SSL_VERIFYPEER, false);

        // get response
        $response = curl_exec($csess);

        // close curl
        curl_close($csess);

        // convert to array
        $results = json_decode($response, true);

		/*
		resulting to:
		Array
		(
		    [access_token] => ya29.c.Kp0B4wdu-g4FVh6lCLaLr2G4nt5TC9sZanAnZP9zeZyhyIocA_j8_HqG5mJ0ziTySdMr9OKFYU8RoOqdI-Jb1w7gnDFZjKo5zsxNiDf97xwTp4fk1ZdceZDH6VZHngPRtJcLM2neugjS-QvwXGR1TdpGk81iKozsAx0pcUtapdQ2VYg_Bnsuxz-xElF8bFXkuqLoGnRPSKhxUxkD6YhOgA
		    [expires_in] => 3599
		    [token_type] => Bearer
		)
		*/

		// get access token
		$access_token = $results['access_token'];

		/*
		GET product list
		curl \
  'https://shoppingcontent.googleapis.com/content/v2.1/[MERCHANTID]/products?key=[YOUR_API_KEY]' \
  --header 'Authorization: Bearer [YOUR_ACCESS_TOKEN]' \
  --header 'Accept: application/json' \
  --compressed
  		*/

		$url2 = 'https://shoppingcontent.googleapis.com/content/v2.1/'
			.$this->merchant_id
			.'/products?key='
			.$this->config->item('google_private_key_id')
		;
		$csess2 = curl_init($url2);

		$headers = array(
			'Authorization: Bearer '.$access_token,
			'Accept: application/json'
		);

		curl_setopt($csess2, CURLOPT_HTTPHEADER, $headers); // used for attachments
		curl_setopt($csess2, CURLOPT_RETURNTRANSFER, TRUE);

		// get response
        $response2 = curl_exec($csess2);

        // close curl
        curl_close($csess2);

		// convert to array
        $results2 = json_decode($response2, true);

		echo '<pre>';
		print_r($results);
		echo '<br />';
		print_r($results2);
		echo '<br />';
		echo '<br />';
		echo 'Done';
	}

	// ----------------------------------------------------------------------

	/**
	 * Base64URL encode
	 *
	 * @return	void
	 */
	private function _base64url_encode($data)
	{
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

	// ----------------------------------------------------------------------

}
