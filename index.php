<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 */
	//define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');
	//$root = dirname(__FILE__);
	//var_dump($root); die(); // ----> to check on dirname(__FILE___);
	switch (dirname(__FILE__))
	{
		// change to your development environment
		case 'C:\Users\Bongbong\Documents\Websites\acode': // BB Lenovo
		case '/Users/admin1/Sites/acode': // BB Mac
			define('ENVIRONMENT', 'development');
			define('LOCALHOSTPATH', dirname(__FILE__));
		break;

		default:
			define('ENVIRONMENT', 'production');
	}
	//echo ENVIRONMENT; die();
	//define('ENVIRONMENT', 'development');

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
switch (ENVIRONMENT)
{
	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
	break;

	case 'testing':
	case 'production':
		error_reporting(-1);
		ini_set('display_errors', 1);
	break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_ERROR
}

/*
 *---------------------------------------------------------------
 * SYSTEM DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" directory.
 * Set the path if it is not in the same directory as this file.
 */
	$system_path = 'system';

/*
 *---------------------------------------------------------------
 * APPLICATION DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * directory than the default one you can set its name here. The directory
 * can also be renamed or relocated anywhere on your server. If you do,
 * use an absolute (full) server path.
 * For more info please see the user guide:
 *
 * https://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 */
	$application_folder = 'application';

/*
 *---------------------------------------------------------------
 * VIEW DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * If you want to move the view directory out of the application
 * directory, set the path to it here. The directory can be renamed
 * and relocated anywhere on your server. If blank, it will default
 * to the standard location inside your application directory.
 * If you do move this, use an absolute (full) server path.
 *
 * NO TRAILING SLASH!
 */
	$view_folder = 'views';


/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normally you will set your default controller in the routes.php file.
 * You can, however, force a custom routing by hard-coding a
 * specific controller class/function here. For most applications, you
 * WILL NOT set your routing here, but it's an option for those
 * special instances where you might want to override the standard
 * routing in a specific front controller that shares a common CI installation.
 *
 * IMPORTANT: If you set the routing here, NO OTHER controller will be
 * callable. In essence, this preference limits your application to ONE
 * specific controller. Leave the function name blank if you need
 * to call functions dynamically via the URI.
 *
 * Un-comment the $routing array below to use this feature
 */
	// The directory name, relative to the "controllers" directory.  Leave blank
	// if your controller is not in a sub-directory within the "controllers" one
	// $routing['directory'] = '';

	// The controller class file name.  Example:  mycontroller
	// $routing['controller'] = '';

	// The controller function you wish to be called.
	// $routing['function']	= '';


/*
 * -------------------------------------------------------------------
 *  CUSTOM ITEMS
 * -------------------------------------------------------------------
 *
 * The custom items and/or constants
 *
 * For example:
 *
 * define('SITESLUG', 'basixbridal');
 * or any other code necessary to run the application
 *
 */
	// SITESLUG
	// ====================================================
	if (ENVIRONMENT === 'development')
	{
		/*********************
		 * Need to manually change this to test code on all sites
		 */
		//define('SITESLUG', 'newdomain');

		//define('SITESLUG', 'issuenewyork');	// still company operated

		//define('SITESLUG', 'instylenewyork');
		//define('SITESLUG', 'basixblacklabel');
		//define('SITESLUG', 'basix-black-label');
		//define('SITESLUG', 'basixbridal');	// forwarded to instylenewyork
		//define('SITESLUG', 'basixprom');	// forwarded to instylenewyork
		//define('SITESLUG', 'junnieleigh');
		//define('SITESLUG', 'chaarmfurs');

		//define('SITESLUG', 'tempo-paris');

		define('SITESLUG', 'shop7thavenue');
		//define('SITESLUG', 'issueny');
		//define('SITESLUG', 'andrewoutfitter');
		//define('SITESLUG', 'storybookknits');
		//define('SITESLUG', 'tempoparis');	// .com company operated .net shop7 operated

		//define('SITESLUG', 'salesuser');

		define('DOMAINNAME', SITESLUG.'.com'); // --> used for domains with .NET and .COM
	}
	else
	{
		/*********************
		 * We just need to get the domainname portion of the HTTP HOST
		 * SERVER NAME to use as the live site SITESLUG
		 */
		define('DOMAINNAME', ltrim($_SERVER['HTTP_HOST'], 'www.'));
		define('SITESLUG', strstr(DOMAINNAME, '.', TRUE));

		// odoo system, temporarily using iframe for access to actual odoo services
		//require('odoo.php');
	}

	switch (SITESLUG)
	{
		case 'tempo-paris':
		case 'tempoparis':
			if (DOMAINNAME == 'tempoparis.com') define('PROD_IMG_URL','https://www.tempoparis.com/');
			if (DOMAINNAME == 'tempo-paris.com') define('PROD_IMG_URL','https://www.shop7thavenue.com/');
			if (DOMAINNAME == 'tempoparis.net') define('PROD_IMG_URL','https://www.shop7thavenue.com/');
		break;

		case 'issuenewyork':
			define('PROD_IMG_URL','https://www.issuenewyork.com/');
		break;

		case 'instylenewyork':
			define('PROD_IMG_URL','https://www.instylenewyork.com/');
		break;

		case 'salesuser':
		case 'storybookknits':
		case 'andrewoutfiiter':
		case 'basixblacklabel':
			case 'basix-black-label':
			case 'basixbridal':
			case 'basixprom':
		case 'issueny':
		case 'junnieleigh':
		case 'chaarmfurs':
		case 'shop7thavenue':
		default:
			define('PROD_IMG_URL','https://www.shop7thavenue.com/');
			//define('PROD_IMG_URL','https://www.instylenewyork.com/');
		break;
	}


/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 *
 * The $assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config
 * items or override any default config values found in the config.php file.
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different
 * config values.
 *
 * Un-comment the $assign_to_config array below to use this feature
 */
	// $assign_to_config['name_of_config_item'] = 'value of config item';

	$assign_to_config['PROD_IMG_URL'] = PROD_IMG_URL;
	$assign_to_config['admin_folder'] = 'admin';
	$assign_to_config['dev1_email'] = 'rsbgm@rcpixel.com';
	$assign_to_config['currency'] = '$';
	$assign_to_config['odoo_api_key'] = 'RaYgtlugt2vk68L3Goe9BnzAYPWwQlwa89K44I0bagQrj9xkiVoTGk_BCMx_mr6R7XsP_ANkcOK';

	if (defined('ENVIRONMENT'))
	{
		switch (ENVIRONMENT)
		{
			case 'development':
				$assign_to_config['base_url'] = 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).'/';
				//echo $assign_to_config['base_url']; die();
			break;

			case 'testing': // change to your staging or testing server root where necessary
			case 'production':
				$host = $_SERVER['SERVER_NAME'];
				if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
				{
					$assign_to_config['base_url'] = 'https://'.$host.'/';
				}
				else
				{
					$assign_to_config['base_url'] = 'http://'.$host.'/';
				}
			break;

			default:
				exit('The application environment is not set correctly.');
		}
	}

	if (defined('ENVIRONMENT'))
	{
		switch (ENVIRONMENT)
		{
			case 'development':
				$assign_to_config['sess_save_path'] = LOCALHOSTPATH.DIRECTORY_SEPARATOR.'sessions';
			break;

			case 'testing': // change to your staging or testing server root where necessary
			case 'production':
				$assign_to_config['sess_save_path'] = '/var/www/vhosts/'.str_replace('www.', '', $_SERVER['SERVER_NAME']).'/sessions/';
			break;

			default:
				exit('The application environment is not set correctly.');
		}
	}

	// session settings
	$assign_to_config['sess_regenerate_destroy'] = TRUE;
	$assign_to_config['sess_cookie_name'] = 'ci_sess_'.SITESLUG;
	$assign_to_config['sess_expiration'] = 259200;
		// (30 * 24 * 60 * 60) 30 days 2592000
		// (3 * 24 * 60 * 60) 3 days 259200

	// cookie settings
	$assign_to_config['cookie_prefix']	= SITESLUG."_";
	$assign_to_config['cookie_domain']	= str_replace('www', '', $_SERVER['SERVER_NAME']);

	// csrf settings
	if (isset($_SERVER["REQUEST_URI"]))
	{
		if(
			stripos($_SERVER["REQUEST_URI"],'/test/test_ajax_post_to_odoo') === FALSE
			&& stripos($_SERVER["REQUEST_URI"],'/admin/dcn/upload_image') === FALSE
			&& stripos($_SERVER["REQUEST_URI"],'/admin/inventory/live_edit') === FALSE
			&& stripos($_SERVER["REQUEST_URI"],'/sales/sales_orders/rem_item') === FALSE
		)
		{
			$assign_to_config['csrf_protection'] = TRUE;
		}
		else
		{
			$assign_to_config['csrf_protection'] = FALSE;
		}
	}
	else
	{
		$assign_to_config['csrf_protection'] = TRUE;
	}
	//$assign_to_config['csrf_protection'] = TRUE;
	$assign_to_config['csrf_token_name'] = 'csrf_token_'.SITESLUG;
	$assign_to_config['csrf_cookie_name'] = 'csrf_cookie_'.SITESLUG;
	$assign_to_config['csrf_expire'] = 259200;
	$assign_to_config['csrf_regenerate'] = FALSE;

	// Link: http://randomkeygen.com/
	switch(SITESLUG)
	{
		case 'salesuser':
			$assign_to_config['encryption_key'] = 'S20C0LQU4AJAxVzG6U0WZ8Z2Ab7fSyJO';
			$assign_to_config['primary_category'] = 'evening_dresses';
		break;
		case 'instylenewyork':
			$assign_to_config['encryption_key'] = '12PN5TGgxMScFw8ArsFIqVck08Lg02W9';
			$assign_to_config['primary_category'] = 'evening_dresses';
		break;
		case 'basix-black-label':
		case 'basixblacklabel':
			$assign_to_config['encryption_key'] = 'v1ogPPhkQJ53yPpoGjUc4KIyaOxK2zPi';
			$assign_to_config['primary_category'] = 'evening_dresses';
		break;
		case 'basixbridal':
			$assign_to_config['encryption_key'] = '4iSsFBdanKQ2QbW3tHYILyR6sv0tIxcn';
			$assign_to_config['primary_category'] = 'bridal_dresses';
		break;
		case 'basixprom':
			$assign_to_config['encryption_key'] = '8h9E2GijpI51pSEkkZxGOn6yh2atHAm4';
			$assign_to_config['primary_category'] = 'bridal_dresses';
		break;
		case 'issuenewyork':
		case 'issueny':
			$assign_to_config['encryption_key'] = '1ngh6YkP7jRXSI6S66gZrd24vIZUWbIN';
			$assign_to_config['primary_category'] = 'long_dresses';
		break;
		case 'tempoparis':
			$assign_to_config['encryption_key'] = 'xVAe61LqDjkdZ74Ya9b0Wei9AnL9OH1d';
			$assign_to_config['primary_category'] = 'tops';
		break;
		case 'tempo-paris':
			$assign_to_config['encryption_key'] = 'sPj8Pa63Oq820ortNshtC8lDpWmnTnrA';
			$assign_to_config['primary_category'] = 'tops';
		break;
		case 'junnieleigh':
			$assign_to_config['encryption_key'] = '7I7089DewN2or9cy7rgA652Tfsgj0cjv';
			$assign_to_config['primary_category'] = 'tops';
		break;
		case 'andrewoutfitter':
			$assign_to_config['encryption_key'] = 'Si27P9xmminCFE0HTM5mxh591hTE1w0p';
			$assign_to_config['primary_category'] = 'sweaters';
		break;
		case 'linens':
			$assign_to_config['encryption_key'] = '46rDFUZ6o55Ka4J489K0I3m7oanDIY6j';
			$assign_to_config['primary_category'] = 'beds';
		break;
		case 'shop7thavenue':
			$assign_to_config['encryption_key'] = '3488HDocYrJxZV8Nm8tWy2HvgPVA97Kq';
			$assign_to_config['primary_category'] = 'long_dresses';
		break;
		case 'storybookknits':
			$assign_to_config['encryption_key'] = '8f75K040Ug7WHc3788Pae0T1Al9jjWEO';
			$assign_to_config['primary_category'] = 'novelty_sweaters';
		break;
	}


// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

	// Set the current directory correctly for CLI requests
	if (defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if (($_temp = realpath($system_path)) !== FALSE)
	{
		$system_path = $_temp.DIRECTORY_SEPARATOR;
	}
	else
	{
		// Ensure there's a trailing slash
		$system_path = strtr(
			rtrim($system_path, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		).DIRECTORY_SEPARATOR;
	}

	// Is the system path correct?
	if ( ! is_dir($system_path))
	{
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
		exit(3); // EXIT_CONFIG
	}


	// codeigniter legacy 2++ version compatibility
	define('EXT', '.php');

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
	// The name of THIS file
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

	// Path to the system directory
	define('BASEPATH', $system_path);

	// Path to the front controller (this file) directory
	define('FCPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

	// Name of the "system" directory
	define('SYSDIR', basename(BASEPATH));

	// The path to the "application" directory
	if (is_dir($application_folder))
	{
		if (($_temp = realpath($application_folder)) !== FALSE)
		{
			$application_folder = $_temp;
		}
		else
		{
			$application_folder = strtr(
				rtrim($application_folder, '/\\'),
				'/\\',
				DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
			);
		}
	}
	elseif (is_dir(BASEPATH.$application_folder.DIRECTORY_SEPARATOR))
	{
		$application_folder = BASEPATH.strtr(
			trim($application_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		);
	}
	else
	{
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3); // EXIT_CONFIG
	}

	define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);

	// The path to the "views" directory
	if ( ! isset($view_folder[0]) && is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR))
	{
		$view_folder = APPPATH.'views';
	}
	elseif (is_dir($view_folder))
	{
		if (($_temp = realpath($view_folder)) !== FALSE)
		{
			$view_folder = $_temp;
		}
		else
		{
			$view_folder = strtr(
				rtrim($view_folder, '/\\'),
				'/\\',
				DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
			);
		}
	}
	elseif (is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR))
	{
		$view_folder = APPPATH.strtr(
			trim($view_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		);
	}
	else
	{
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3); // EXIT_CONFIG
	}

	define('VIEWPATH', $view_folder.DIRECTORY_SEPARATOR);

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 */
require_once BASEPATH.'core/CodeIgniter.php';
