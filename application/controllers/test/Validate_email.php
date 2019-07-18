<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function index()
	{
		$domain = 'boomcom.cpm.boot';
		
		// remove the http protocol
		if(stripos($domain, 'http://') === 0)
		{
			$domain = str_replace('http://', '', $domain);
		}
		
		// remove the www prefix to be able to manipulate the domain name
		if(stripos($domain, 'www.') === 0)
		{
			$domain = str_replace('www.', '', $domain);
		}
		
		// Not even a single . this will eliminate things like abcd, since http://abcd is reported valid
		if( ! substr_count($domain, '.'))
		{
			// no dot at all
			return false;
		}
		
		// check for TLD validity
		$valid_tlds = array('com', 'net');
		$exp = explode('.', $domain);
		$tld = $exp[count($exp) - 1];
		if ( ! in_array($tld, $valid_tlds))
		{
			// not the correct tld
			return false;
		}
		
		$again = 'http://' . $domain;
		
		return filter_var ($again, FILTER_VALIDATE_URL);
	}
}
