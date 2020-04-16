<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_product extends Frontend_Controller {

	/**
	 * DB Object
	 *
	 * @return	object
	 */
	protected $DB;


	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// connect to database for use by model
		$this->DB = $this->load->database('instyle', TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function index()
	{
		// no index function for now...
		// as product inquiry is done through popup at produt details page
		// and is submitted to the inquiry() function below
	}

	// --------------------------------------------------------------------

	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function inquiry()
	{
		//echo '<pre>';
		//print_r($this->input->post());
		//die();

		if ( ! $this->input->post())
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect(site_url(), 'location');
		}

		// grab the input posts
		$the_time = $this->input->post('the_time');
		$return_url = $this->input->post('return_url');
		$prod_no = $this->input->post('prod_no');
		$color_code = $this->input->post('color_code');

		$name = $this->input->post('name');
		$dress_size = $this->input->post('dress_size');
		$email = $this->input->post('email');
		$opt_type = $this->input->post('opt_type');
		$u_type = $this->input->post('u_type');
		$message = $this->input->post('message');
		$imahe = $this->input->post('image');
		$email1 = htmlspecialchars($this->input->post('email'));

		$no_stocks_at_all = $this->input->post('no_stocks_at_all');

		// let's check for $prod_no
		if (trim($prod_no) == '')
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect(site_url(), 'location');
		}

		// check for time interval
		if ($the_time < (time() - 180) // to far in the past (more than 3 mins (180 secs))
			OR $the_time > time() // in the future
			OR $the_time == '' // if empty (a clear sign of manipulation by a bot)
			OR $name == ''
			OR $email == ''
			OR $dress_size == ''
			OR $u_type == '')
		{
			$destination = $return_url ? base_url().$return_url.'.html' : site_url();
			$invalid = TRUE;
			$errtype = 1;
		}

		// valid email
		if ( ! preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email1))
		{
			$destination = $return_url ? base_url().$return_url.'.html' : site_url();
			$invalid = TRUE;
			$errtype = 2;
		}

		// valid dress size
		if ( preg_match("/[DD]/", $dress_size))
		{
			$destination = $return_url ? base_url().$return_url.'.html' : site_url();
			$invalid = TRUE;
			$errtype = 3;
		}

		// blocked emails
		if (in_array($email1, array('test@test.com')))
		{
			$destination = $return_url ? base_url().$return_url.'.html' : site_url();
			$invalid = TRUE;
			$errtype = 4;
		}

		// send the user back
		if (@$invalid)
		{
			echo '
				<script>
					alert("Please fill up the fields properly.");
					window.location.href="'.$destination.'";
				</script>
			';
			exit;
		}

		/*
		| ------------------------------------------------------------------------------
		| Get the backurl (link to the product detai page at instylenewyork.com)
		| Set image filename base on standard coding - <prod_no>_<color_code>.jpg

		$prod_query = $this->query_product->get_product_detail($prod_no,$color_code);
		$prod_query = $prod_query->row();
		*/
		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->product_details->initialize(array('tbl_product.prod_no'=>$prod_no,'color_code'=>$color_code));

		// ---> return path
		//$backurl_path = $this->product_details->d_url_structure.'/'.$prod_no.'/'.str_replace(array(' ','_'), array('-','-'), strtolower(trim($this->product_details->color_name))).'/'.str_replace(' ','-',$this->product_details->prod_name).'.html';
		$backurl_path = $return_url;

		if (DOMAINNAME === 'tempoparis.net')
		{
			$backdomain = 'https://www.shop7thavenue.com/';
		}
		else
		{
			switch ($this->webspace_details->slug)
			{
				case 'if-any':
					$backdomain = 'https://www.shop7thavenue.com/';
				break;

				case 'basix-black-label':
				case 'basixblacklabel':
					case 'basixprom':
					case 'basixbridal':
				case 'chaarmfurs':
				case 'junnieleigh':
				case 'andrewoutfitter':
				case 'storybookknits':
				case 'issuenewyork':
				case 'issueny':
				default:
					$backdomain = 'https://www.shop7thavenue.com/';
			}
		}

		// ---> to the hub site
		$backurl = $backdomain.$backurl_path;

		/*
		| ------------------------------------------------------------------------------
		| Create the HTML email content
		*/
		$email_message = '
			<div style="font-family: arial,sans-serif;">
				<br />
				An inquiry generated from:
				<table width="650" border="0" cellspacing="0" cellpadding="5">
					<tr style="background-color:'.($this->webspace_details->slug == 'basixbridal' ? '#e0b2aa;' : 'black;').'">
						<td>
							<img src="'.base_url().'assets/roden_assets/images/logo-'.$this->webspace_details->slug.'.png" alt="'.$this->webspace_details->name.'" style="border:none;margin:2px;width:292px;" width="292" />
						</td>
						<td align="right">
							<a href='.$backurl.' style="color:red;text-decoration:none;vertical-align:middle;font-family:Arial;font-size:10px;">CLICK PHOTO TO SEE PRICING AND ORDER OPTIONS</a>
						</td>
					</tr>
					<tr>
						<td width="340" style="border: 1px solid #efefef;">'
							.anchor(
								$backurl,
								img(
									array(
										'src'=>$imahe,
										'style'=>'border:none;',
										'alt'=>'CLICK HERE TO VIEW AND ORDER',
										'title'=>'CLICK HERE TO VIEW AND ORDER'
									)
								)
							)
						.'</td>
						<td bgcolor="'.($this->webspace_details->slug == 'basixbridal' ? '#f8ede9' : '#efefef').'" valign="top" style="font-family:Arial;font-size:14px;">
							<p>Style Number: '.$prod_no.'</p>
							<p>Dress Size: '.$dress_size.'</p>
							<p>Name: '.$name.'</p>
							<p>Email Address: '.$email.'</p>
							<p>Send me offers on clearance items: '.($opt_type == '1' ? 'YES' : 'NO').'</p>
							<p>I am a: '.$u_type.'</p>
							<p>Message or Comments: '.$message.'</p>
						</td>
					</tr>
				</table>
				<br />
				<table width="650" border="0" cellsapcing="0" cellpadding="0">
					<tr><td>
						<img src="'.base_url().'images/basix_size_chart-web.jpg" alt="'.$this->webspace_details->name.' Size Chart" style="border:none;" width="600" />
					</td></tr>
				</table>
			</div>
		';

		// break name into 2 parts
		$name_exp = explode(' ', trim($name));
		$cnt = count($name_exp);
		$lname = $name_exp[$cnt - 1];
		$fname = '';
		for ($i = 0; $i < ($cnt - 1); $i++)
		{
			$fname .= $name_exp[$i].' ';
		}
		$fname = substr($fname, 0, -1);

		// set query string
		$query_string_ary = array(
			'user_fname' => $fname,
			'user_lname' => $lname,
			'user_email' => $email,
			'user_size' => $dress_size,
			'url' => $backurl_path,
			'comment' => $message,
			'type' => $u_type,
			'opt_type' => $opt_type,
			'prod_no' => $prod_no,
			'color_code' => $color_code,
			'form' => 'inquiry',
			'no_stocks_at_all' => $no_stocks_at_all,
			'sc_url' => $this->product_details->sc_url_structure,
			'site_referrer' => $this->webspace_details->slug
		);
		$query_string = http_build_query($query_string_ary);

		/*
		| ------------------------------------------------------------------------------
		| Initiate email class and set headers
		*/
		if (ENVIRONMENT == 'development') // ---> used for development purposes
		{
			// we are unable to send out email in our dev environment
			// so we check on the email template instead.
			// just don't forget to comment these accordingly
			echo $email_message;
			echo '<br /><br />';

			//redirect(site_url($this->uri->uri_string()).'?'.http_build_query($_GET));
			echo '<a href="'.site_url('about_product/validate').'?'.$query_string.'">Continue...</a>';
			echo '<br /><br />';
			exit;
		}
		else
		{
			// let's send the email
			// load email library
			$this->load->library('email');

			// notify admin
			$this->email->clear();

			$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
			$this->email->reply_to($email);

			$this->email->to($this->webspace_details->info_email);
			$this->email->cc($email, 'help@instylenewyork.com');

			//$this->email->bcc($this->config->item('dev1_email')); // --> for debugging purposes

			$this->email->subject(strtoupper($this->webspace_details->name).' ORDER INQUIRY RESPONSE: STYLE NUMBER: '.$prod_no);
			$this->email->message($email_message);

			$sendby = @$this->webspace_details->options['email_send_by'] ?: 'default'; // options: mailgun, default (CI native emailer)

			if ($sendby == 'mailgun')
			{
				// load pertinent library/model/helpers
				$this->load->library('mailgun/mailgun');
				$this->mailgun->from = $this->webspace_details->name.' <'.$this->webspace_details->info_email.'>';
				$this->mailgun->to = $this->webspace_details->info_email;
				$this->mailgun->cc = $email.',help@instylenewyork.com,help@shop7thavenue.com';
				$this->mailgun->bcc = $this->config->item('dev1_email');
				$this->mailgun->subject = strtoupper($this->webspace_details->name).' ORDER INQUIRY RESPONSE: STYLE NUMBER: '.$prod_no;
				$this->mailgun->message = $email_message;

				if ( ! $this->mailgun->Send())
				{
					// capturing error but the error message it not captured from MG class
					// the return info is still a bug to fix
					$error = 'Unable to MG send to - "'.$email.'"<br />';
					$error .= '-'.$this->mailgun->error_message;
				}

				$this->mailgun->clear();
			}
			else
			{
				// email class has a security error
				// "idn_to_ascii(): INTL_IDNA_VARIANT_2003 is deprecated"
				// using the '@' sign to supress this
				// must resolve pending update of CI
				if ( ! @$this->email->send())
				{
					$error = 'Unable to CI send to - "'.$email.'"<br />';
				}
			}
		}

		/*
		| ------------------------------------------------------------------------------
		| Redirect user
		*/

		// what needs to happen...
		// regardless of user verification, we need to send user to hub site's same
		// product details page:
		//
		//		$this->config->item('PROD_IMG_URL').'shop/details/'.$backurl_path
		//
		// where the $backurl_path is actually the uri strings
		// however, we need to validate the user and capture records for consumer
		// and re-evaluate wholesale users as well
		//
		// And we validate user using 'about_product/validate' controller function

		// deprecated
		//if ($u_type == 'Store') $destination = $backdomain."wholesale/register.html";
		//if ($u_type == 'Consumer') $destination = $backdomain."validate_".$this->webspace_details-slug.".php".$query_string;

		if ($u_type == 'Store') redirect($this->config->slash_item('PROD_IMG_URL').'account/register/wholesale.html');
		if ($u_type == 'Consumer') redirect($this->config->slash_item('PROD_IMG_URL').'about_product/validate.html?'.$query_string);

		// deprecated
		/*
		echo '
			<script>
				window.location.href="'.$destination.'";
			</script>
		';
		*/
	}

	// --------------------------------------------------------------------

	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function inquiry_instyle()
	{
		// we follow the old for for now...

		// grab the input posts
		$the_spinner = $this->input->post(md5('the_spinner')); // ---> used to identify the random hashed fields
		$the_time = $this->input->post(md5($the_spinner.'the_time'));
		$the_honeypot = $this->input->post(md5($the_spinner.'the_honeypot'));

		$return_url = $this->input->post(md5($the_spinner.'the_return_url'));
		$prod_no = $this->input->post(md5($the_spinner.'the_prod_no'));
		$color_code = $this->input->post(md5($the_spinner.'the_color_code'));

		$name = $this->input->post(md5($the_spinner.'the_name'));
		$dress_size = $this->input->post(md5($the_spinner.'the_dress_size'));
		$email = $this->input->post(md5($the_spinner.'the_email'));
		$opt_type = $this->input->post(md5($the_spinner.'the_opt_type'));
		$u_type = $this->input->post(md5($the_spinner.'the_u_type'));
		$message = $this->input->post(md5($the_spinner.'the_message'));
		$imahe = $this->input->post(md5($the_spinner.'the_image'));
		$email1 = htmlspecialchars($this->input->post(md5($the_spinner.'the_email')));

		$no_stocks_at_all = $this->input->post('no_stocks_at_all');

		// check for time interval
		if ($the_time < (time() - 180) // to far in the past (more than 3 mins (180 secs))
			OR $the_time > time() // in the future
			OR $the_time == '' // if empty (a clear sign of manipulation by a bot)
			OR $the_honeypot != '' // if honeypot is not empty (a clear sign of bot filling up form)
			OR $name == ''
			OR $email == ''
			OR $dress_size == ''
			OR $u_type == '')
		{
			$destination = $return_url ? base_url().$return_url : site_url();
			$invalid = TRUE;
		}

		// valid email
		if ( ! preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email1))
		{
			$destination = $return_url ? base_url().$return_url : site_url();
			$invalid = TRUE;
		}

		// valid dress size
		if ( preg_match("/[DD]/", $dress_size))
		{
			$destination = $return_url ? base_url().$return_url : site_url();
			$invalid = TRUE;
		}

		// blocked emails
		if (in_array($email1, array('test@test.com')))
		{
			$destination = $return_url ? base_url().$return_url : site_url();
			$invalid = TRUE;
		}

		// send the user back
		if (@$invalid)
		{
			echo '
				<script>
					alert("Please fill up the fields properly.");
					window.location.href="'.$destination.'";
				</script>
			';
			exit;
		}

		/*
		| ------------------------------------------------------------------------------
		| Get the backurl (link to the product detai page at instylenewyork.com)
		| Set image filename base on standard coding - <prod_no>_<color_code>.jpg

		$prod_query = $this->query_product->get_product_detail($prod_no,$color_code);
		$prod_query = $prod_query->row();
		*/
		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->product_details->initialize(array('tbl_product.prod_no'=>$prod_no,'color_code'=>$color_code));

		// ---> return path
		$backurl_path = $this->product_details->d_url_structure.'/'.$prod_no.'/'.str_replace(array(' ','_'), array('-','-'), strtolower(trim($this->product_details->color_name))).'/'.str_replace(' ','-',$this->product_details->prod_name).'.html';

		if (DOMAINNAME === 'tempoparis.net')
		{
			$backdomain = 'http://www.shop7thavenue.com/';
		}
		else
		{
			switch ($this->webspace_details->slug)
			{
				case 'if-any':
					$backdomain = 'http://www.shop7thavenue.com/';
				break;

				case 'basix-black-label':
				case 'basixblacklabel':
					case 'basixprom':
					case 'basixbridal':
				case 'chaarmfurs':
				case 'junnieleigh':
				case 'andrewoutfitter':
				case 'storybookknits':
				case 'issuenewyork':
				case 'issueny':
				default:
					$backdomain = 'http://www.instylenewyork.com/';
			}
		}

		// ---> to the hub site
		$backurl = $backdomain.$backurl_path;

		/*
		| ------------------------------------------------------------------------------
		| Create the HTML email content
		*/
		$email_message = '
			<div style="font-family: arial,sans-serif;">
				<br />
				An inquiry generated from:
				<table width="650" border="0" cellspacing="0" cellpadding="5">
					<tr style="background-color:'.($this->webspace_details->slug == 'basixbridal' ? '#e0b2aa;' : 'black;').'">
						<td>
							<img src="'.base_url().'assets/roden_assets/images/logo-'.$this->webspace_details->slug.'.png" alt="'.$this->webspace_details->name.'" style="border:none;margin:2px;width:292px;" width="292" />
						</td>
						<td align="right">
							<a href='.$backurl.' style="color:red;text-decoration:none;vertical-align:middle;font-family:Arial;font-size:10px;">CLICK PHOTO TO SEE PRICING AND ORDER OPTIONS</a>
						</td>
					</tr>
					<tr>
						<td width="340" style="border: 1px solid #efefef;">'
							.anchor(
								$backurl,
								img(
									array(
										'src'=>$imahe,
										'style'=>'border:none;',
										'alt'=>'CLICK HERE TO VIEW AND ORDER',
										'title'=>'CLICK HERE TO VIEW AND ORDER'
									)
								)
							)
						.'</td>
						<td bgcolor="'.($this->webspace_details->slug == 'basixbridal' ? '#f8ede9' : '#efefef').'" valign="top" style="font-family:Arial;font-size:14px;">
							<p>Style Number: '.$prod_no.'</p>
							<p>Dress Size: '.$dress_size.'</p>
							<p>Name: '.$name.'</p>
							<p>Email Address: '.$email.'</p>
							<p>Send me special offers on future on-sale items: '.($opt_type == '1' ? 'YES' : 'NO').'</p>
							<p>I am a: '.$u_type.'</p>
							<p>Message or Comments: '.$message.'</p>
						</td>
					</tr>
				</table>
				<br />
				<table width="650" border="0" cellsapcing="0" cellpadding="0">
					<tr><td>
						<img src="'.base_url().'images/basix_size_chart-web.jpg" alt="'.$this->webspace_details->name.' Size Chart" style="border:none;" width="600" />
					</td></tr>
				</table>
			</div>
		';

		// break name into 2 parts
		$name_exp = explode(' ', trim($name));
		$cnt = count($name_exp);
		$lname = $name_exp[$cnt - 1];
		$fname = '';
		for ($i = 0; $i < ($cnt - 1); $i++)
		{
			$fname .= $name_exp[$i].' ';
		}
		$fname = substr($fname, 0, -1);

		// set query string
		$query_string_ary = array(
			'user_fname' => $fname,
			'user_lname' => $lname,
			'user_email' => $email,
			'user_size' => $dress_size,
			'url' => $backurl_path,
			'comment' => $message,
			'type' => $u_type,
			'opt_type' => $opt_type,
			'prod_no' => $prod_no,
			'color_code' => $color_code,
			'form' => 'inquiry',
			'no_stocks_at_all' => $no_stocks_at_all,
			'sc_url' => $this->product_details->sc_url_structure,
			'site_referrer' => $this->webspace_details->slug
		);
		$query_string = http_build_query($query_string_ary);

		/*
		| ------------------------------------------------------------------------------
		| Initiate email class and set headers
		*/
		if (ENVIRONMENT == 'development') // ---> used for development purposes
		{
			// we are unable to send out email in our dev environment
			// so we check on the email template instead.
			// just don't forget to comment these accordingly
			echo $email_message;
			echo '<br /><br />';

			//redirect(site_url($this->uri->uri_string()).'?'.http_build_query($_GET));
			echo '<a href="'.site_url('about_product/validate').'?'.$query_string.'">Continue...</a>';
			echo '<br /><br />';
			exit;
		}
		else
		{
			// let's send the email
			// load email library
			$this->load->library('email');

			// notify admin
			$this->email->clear();

			$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
			$this->email->reply_to($email);

			$this->email->to($this->webspace_details->info_email);
			$this->email->cc($email);

			$this->email->bcc($this->config->item('dev1_email')); // --> for debugging purposes

			$this->email->subject(strtoupper($this->webspace_details->name).' ORDER INQUIRY RESPONSE: STYLE NUMBER: '.$prod_no);
			$this->email->message($email_message);

			// email class has a security error
			// "idn_to_ascii(): INTL_IDNA_VARIANT_2003 is deprecated"
			// using the '@' sign to supress this
			// must resolve pending update of CI
			@$this->email->send();
		}

		/*
		| ------------------------------------------------------------------------------
		| Redirect user
		*/

		// what needs to happen...
		// regardless of user verification, we need to send user to hub site's same
		// product details page:
		//
		//		$this->config->item('PROD_IMG_URL').'shop/details/'.$backurl_path
		//
		// where the $backurl_path is actually the uri strings
		// however, we need to validate the user and capture records for consumer
		// and re-evaluate wholesale users as well
		//
		// And we validate user using 'about_product/validate' controller function

		// deprecated
		//if ($u_type == 'Store') $destination = $backdomain."wholesale/register.html";
		//if ($u_type == 'Consumer') $destination = $backdomain."validate_".$this->webspace_details-slug.".php".$query_string;

		if ($u_type == 'Store') redirect($this->config->item('PROD_IMG_URL').'wholesale/signin.html');
		if ($u_type == 'Consumer') redirect($this->config->item('PROD_IMG_URL').'about_product/validate.html?'.$query_string);

		// deprecated
		/*
		echo '
			<script>
				window.location.href="'.$destination.'";
			</script>
		';
		*/
	}

	// --------------------------------------------------------------------

	/**
	 * Form Validation Callback Functions
	 *
	 * @return	boolean
	 */
	function validate()
	{
		if ( ! $this->input->get())
		{
			// nothing more to do...
			// return user to referring site
			// lets change the $_SERVER['HTTP_REFERER'] in future
			// for security purposes
			redirect($_SERVER['HTTP_REFERER'], 'location');
		}

		// load pertinent library/model/helpers
		$this->load->library('users/consumer_user_details');
		$this->load->library('users/wholesale_user_details');

		if ($this->input->get('form') != 'inquiry')
		{
			// nothing more to do...
			// return user to referring site
			// lets change the $_SERVER['HTTP_REFERER'] in future
			// for security purposes
			redirect($_SERVER['HTTP_REFERER'], 'location');
		}

		// lets verify 'user_email' per 'type' (user type)
		if ($this->input->get('type') == 'Consumer')
		{
			if ($valid_user = $this->consumer_user_details->initialize(array('email'=>$this->input->get('user_email'))))
			{
				// double check optin status

				// lets update consumer product interest 'product_items'
				$this->DB->set('product_items', $valid_user->product_items.','.$this->input->get('prod_no').'_'.$this->input->get('color_code'));
				$this->DB->where('email', $this->input->get('user_email'));
				$this->DB->update('tbluser_data');

				if ($this->input->get('site_referrer') == 'basixblacklabel' && $this->input->get('opt_type') == '1')
				{
					$params['address'] = $this->input->get('user_email');
					$params['fname'] = $this->input->get('user_fname');
					$params['lname'] = $this->input->get('user_lname');
					$params['description'] = 'Basix Black Label Consumer User';
					$params['list_name'] = 'consumers@mg.shop7thavenue.com';
					$params['vars'] = '{"designer":"Basix Black Label"}';
					$this->load->library('mailgun/list_member_add', $params);
					$this->list_member_add->add();
				}
			}
		}

		if ($this->input->get('type') == 'Store')
		{
			if ($valid_user = $this->wholesale_user_details->initialize(array('tbluser_data_wholesale.email'=>$this->input->get('user_email'))))
			{
				// set logged in session
				$this->wholesale_user_details->set_session();
				// update login details
				$this->wholesale_user_details->record_login_detail();

				// notify admin user is online
				$this->_notify_admin_user_online();
			}
		}

		if ($valid_user)
		{
			// redirect to product details page here at hub site
			//redirect('shop/details/'.$this->input->get('url'), 'location');
			redirect($this->input->get('url'), 'location');
		}

		// lets process the user (add to recors where necessary)
		if ($this->input->get('type') == 'Consumer') $this->_add_inquiring_consumer();
		if ($this->input->get('type') == 'Store') $this->_add_inquiring_wholesale();

		// redirect to product details page here at hub site
		//redirect('shop/details/'.$this->input->get('url'), 'location');
		redirect($this->input->get('url'), 'location');
	}

	// --------------------------------------------------------------------

	/**
	 * Form Validation Callback Functions
	 *
	 * @return	boolean
	 */
	function validate_comments($str)
	{
		// regular expression filter
		//$reg_exUrl = "%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i";
			// problem with above filter is texts before
			// and/or after links causes the links to pass
			// using below reg_ex to check for links within a text
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

		// check...
		if (preg_match($reg_exUrl, $str))
		{
			$this->form_validation->set_message('validate_comments', 'Invalid characters found in COMMENTS field.');
			return FALSE;
		}
		else return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Form Validation Callback Functions
	 *
	 * @return	boolean
	 */
	function validate_email($str)
	{
		if ($str == '')
		{
			$this->form_validation->set_message('validate_email', 'Please enter an email address of the Email field.');
			return FALSE;
		}
		else
		{
			if ( ! filter_var($str, FILTER_VALIDATE_EMAIL))
			{
				$this->form_validation->set_message('validate_email', 'The Email field must contain a valid email address.');
				return FALSE;
			}
			else return TRUE;
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Notify admin of user being online
	 *
	 * @return	void
	 */
	private function _notify_admin_user_online()
	{
		// begin send email requet to isntyle admin
		$email_message = '
			<br /><br />
			Dear '.ucwords($this->wholesale_user_details->admin_sales_user).',
			<br /><br />
			'.ucfirst($this->wholesale_user_details->fname.' '.$this->wholesale_user_details->lname).' is now online.<br />
			Total logged in visits  - ( '.$this->wholesale_user_details->total_visits().' ).
			<br /><br />
			<strong>Sale User Representative:</strong> &nbsp; &nbsp; '.$this->wholesale_user_details->admin_sales_user.' '.$this->wholesale_user_details->admin_sales_lname.'
			<br /><br />
			User Details:
			<br /><br />
			<table>
				<tr>
					<td>Store Name: &nbsp; </td>
					<td>'.$this->wholesale_user_details->store_name.'</td>
				</tr>
				<tr>
					<td>User Name: &nbsp; </td>
					<td>'.ucwords($this->wholesale_user_details->fname.' '.$this->wholesale_user_details->lname).'</td>
				</tr>
				<tr>
					<td>Telephone: &nbsp; </td>
					<td>'.$this->wholesale_user_details->telephone.'</td>
				</tr>
				<tr>
					<td>Email: &nbsp; </td>
					<td>'.$this->wholesale_user_details->email.'</td>
				</tr>
			</table>
			<br /><br />
			Click <u>here</u> to chat with user. <span style="color:red">[ Not yet available. ]</span>
			<br />
		';

		// this _notify_admin_user_online function has been tested from 'wholesale/authenticated'
		// let's send the email
		// load email library
		$this->load->library('email');

		// notify admin
		$this->email->clear();

		$this->email->from($this->wholesale_user_details->designer_info_email, $this->wholesale_user_details->designer);

		$this->email->to($this->webspace_details->info_email);

		//$this->email->bcc($this->config->item('dev1_email')); // --> for debuggin purposes

		$this->email->subject('WHOLESALE USER IS ON LINE - '.strtoupper($this->webspace_details->name));
		$this->email->message($email_message);

		// email class has a security error
		// "idn_to_ascii(): INTL_IDNA_VARIANT_2003 is deprecated"
		// using the '@' sign to supress this
		// must resolve pending update of CI
		@$this->email->send();
	}

	// ----------------------------------------------------------------------

	/**
	 * Process inquiring consumer user
	 *
	 * @return	void
	 */
	private function _add_inquiring_consumer()
	{
		// insert user
		$data1 = array(
			'firstname' => $this->input->get('user_fname'),
			'lastname' => $this->input->get('user_lname'),
			'email' => $this->input->get('user_email'),
			'product_items' => $this->input->get('prod_no').'_'.$this->input->get('color_code'),
			'dresssize' => $this->input->get('user_size'),
			'password' => $this->webspace_details-slug,
			'comment' => $this->input->get('comment'),
			'receive_productupd' => $this->input->get('opt_type'),
			'is_active' => ($this->input->get('opt_type') == '0' ? '3' : '1'),
			'site_ini' => $this->input->get('site_referrer'),
			'reference_designer' => $this->input->get('site_referrer'),
			'admin_sales_email' => $this->webspace_details->info_email,
			'create_date' => @date('Y-m-d', @time()),
		);
		$this->DB->insert('tbluser_data', $data1);
		$user_id = $this->DB->insert_id();

		// update login details
		// will need to figure out a way to record login details of consumers
		// for now, lets just keep adding a record for every inquiry
		$data2 = array(
			'user_id' => $user_id,
			'session_id' => '',
			'create_date' => @date('Y-m-d', @time()),
			'create_time' => @date('H:i:s', @time()),
			'email' => $this->input->get('user_email'),
			'logindata' => json_encode(array('product_clicks'=>$this->input->get('prod_no')))
		);
		$this->DB->insert('tbl_login_detail');

		// add new consumer to mailgun
		// basix only for now
		if ($this->input->get('site_referrer') == 'basixblacklabel' && $this->input->get('opt_type') == '1')
		{
			$params['address'] = $this->input->get('user_email');
			$params['fname'] = $this->input->get('user_fname');
			$params['lname'] = $this->input->get('user_lname');
			$params['description'] = 'Basix Black Label Consumer User';
			$params['list_name'] = 'consumers@mg.shop7thavenue.com';
			$params['vars'] = '{"designer":"Basix Black Label"}';
			$this->load->library('mailgun/list_member_add', $params);
			$this->list_member_add->add();
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Process inquiring wholesale user
	 *
	 * @return	void
	 */
	private function _add_inquiring_wholesale()
	{
		// insert user
		$data1 = array(
			'email' => $this->input->get('user_email'),
			'pword' => $this->webspace_details-slug,
			'store_name' => '',
			'firstname' => $this->input->get('user_fname'),
			'lastname' => $this->input->get('user_lname'),
			'address1' => '',
			'address2' => '',
			'city' => '',
			'country' => '',
			'state' => '',
			'zipcode' => '',
			'telephone' => '',
			'comments' => $this->input->get('comment'),
			'form_site' => $this->input->get('site_referrer'),
			'reference_designer' => $this->input->get('site_referrer'),
			'admin_sales_email' => $this->webspace_details->info_email,
			'create_date' => @date('Y-m-d', @time()),
			'is_active' => '0'
		);
		$this->DB->insert('tbluser_data_wholesale', $data1);
		$user_id = $this->DB->insert_id();

		// update the user's first ever login details
		$data2 = array(
			'user_id' => $user_id,
			//'session_id' => '',	// no longer used on new table
			'create_date' => @date('Y-m-d', @time()),
			'create_time' => @date('H:i:s', @time()),
			'email' => $this->input->get('user_email'),
			'logindata' => ''
		);
		$this->DB->insert('tbl_login_detail');
	}

	// ----------------------------------------------------------------------

}
