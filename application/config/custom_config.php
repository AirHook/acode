<?php  if ( ! defined('BASEPATH')) exit('ERROR 404: Page not found');

/**
 * Custom Config
 *
 * This config file checks for available webspace configuration settings from database to
 * determine if the website is already an active webspace. If not, a default config settings
 * is put in place.
 */

	$CI =& get_instance();
	
	// connect to database
	$DBconf = $CI->load->database('instyle', TRUE);
	
	// get information if any...
	$DBconf->where('domain_name', DOMAINNAME);
	$DBconf->join('accounts', 'accounts.account_id = webspaces.account_id', 'left');
	$query = $DBconf->get('webspaces');
	
	if ($query->num_rows() > 0)
	{
		$row = $query->row();
		
		$config['site_name']		= $row->webspace_name OR $row->company_name;
		$config['site_slug']		= $row->webspace_slug;
		$config['site_domain']		= $row->domain_name;
		$config['site_address1']	= $row->address1;
		$config['site_address2']	= $row->address2;
		$config['site_phone']		= $row->phone;

		$config['site_title']		= $row->site_title OR $row->company_name;
		$config['site_keywords']	= 'Inner Concept Media';
		$config['site_description']	= 'Inner Concept Media';
		$config['footer_text']		= 'Inner Concept Media';

		$config['site_subject']		= 'Inner Concept Media';
		$config['info_email']		= 'help@innerconcept.com';
		$config['dev1_email']		= 'rsbgm@rcpixel.com';
		
		$config['currency']			= '$';
		$config['currency_char']	= 'USD';
	}
	else
	{
		$config['site_name']		= 'Inner Concept Media';
		$config['site_slug']		= 'innerconcept';
		$config['site_domain']		= 'www.innerconcept.com';
		$config['site_address1']	= '230 E. 17th Street';
		$config['site_address2']	= 'New York, NY 10018';
		$config['site_phone']		= '212.840.0846';

		$config['site_title']		= 'Inner Concept Media';
		$config['site_keywords']	= 'Inner Concept Media';
		$config['site_description']	= 'Inner Concept Media';
		$config['footer_text']		= 'Inner Concept Media';

		$config['site_subject']		= 'Inner Concept Media';
		$config['info_email']		= 'help@innerconcept.com';
		$config['dev1_email']		= 'rsbgm@rcpixel.com';
		
		$config['currency']			= '$';
		$config['currency_char']	= 'USD';

		// other items
		$config['hub_site']			= TRUE;
		$config['items_per_page']	= 48; // 99, 0 (all)
		$config['template']			= 'roden'; // default, roden
		$config['admin_template']	= 'metronic'; 	// metronic
		$config['PROD_IMG_URL'] 	= ENVIRONMENT === 'development' ? 'http://localhost/Websites/JoeTaveras/basixbridal/': 'http://www.shop7thavenue.com/';
	}

