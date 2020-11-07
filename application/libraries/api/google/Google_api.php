<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Google API for Content Shopping Access Token
 *
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	API, Google API
 * @author		WebGuy
 * @link
 */
class Google_api
{

	/**
	 * CI Singleton
	 *
	 * @var	object
	 */
	protected $CI;

	// ----------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		$this->CI = get_instance();
    }

	// ----------------------------------------------------------------------

	/**
	 * Initialize Access Token
	 *
	 * To initialize OAuth authorization from google API
	 *
	 * @return	boolean/string
	 */
	public function initialize()
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
				    "iss" => $this->CI->config->item('google_client_email'),
				    "scope" => $this->CI->config->item('google_content_api_scope'),
				    "aud" => $this->CI->config->item('google_token_uri'),
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
        curl_setopt($csess, CURLOPT_POST, true);
        curl_setopt($csess, CURLOPT_POSTFIELDS, $params);
        curl_setopt($csess, CURLOPT_RETURNTRANSFER, TRUE);

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

		return $access_token;
	}

	// ----------------------------------------------------------------------

	/**
	 * Base64URL encode
	 *
	 * @return	string
	 */
	private function _base64url_encode($data)
	{
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

	// ----------------------------------------------------------------------

}
