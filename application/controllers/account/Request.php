<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends Frontend_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	// --------------------------------------------------------------------

	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function activation()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_validate_email');

		if ($this->form_validation->run() == FALSE)
		{
			// set data variables...
			$this->data['view'] = 'form';

			// set data variables...
			$this->data['file'] = 'account_activation';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;

			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
		}
		else
		{
			if ($this->wholesale_user_details->initialize(array('email'=>$this->input->post('email'))))
			{
				$user_cat = 'wholesale';
				$user_id = $this->wholesale_user_details->user_id;

			}
			elseif ($this->consumer_user_details->initialize(array('email'=>$this->input->post('email'))))
			{
				$user_cat = 'consumer';
				$user_id = $this->consumer_user_details->user_id;
			}
			else
			{
				// set flash notice
				$this->session->set_flashdata('error', 'no_id_passed');

				// rediect back to sign in page
				redirect('account');
			}

			// begin send email requet to isntyle admin
				$email_message = '
					Dear TEAM,
					<br /><br />

					User email: '.$this->input->post('email').'<br />
					'.($user_cat == 'wholesale' ? 'Store Name: '.$this->wholesale_user_details->store_name.'<br />' : '').'

					<br /><br />
					Above user requests his account to be activated.
					<br /><br />
					To view his account, click below link.
					<br /><br />
					<a href="'.site_url('admin/users/'.$user_cat.'/edit/index/'.$user_id).'" target="_blank">
						'.site_url('admin/users/'.$user_cat.'/edit/index/'.$user_id).'
						</a>
					<br />

					<p>Thanks,<br>'.$this->config->item('site_name').' Team.</p><br><br>
				';

				$this->load->library('email');

				// send email to admin
				$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
				$this->email->to($this->webspace_details->info_email);
				$this->email->bcc($this->config->item('dev1_email')); // --> for debuggin purposes

				$this->email->subject('User Request for Activation from '.$this->webspace_details->name);
				$this->email->message($email_message);

				$this->email->send();
			// end send email requet to isntyle admin

			// set data variables...
			$this->data['view'] = 'success-notice';

			// set data variables...
			$this->data['file'] = 'account_activation';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;

			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * User request for sales package
	 *
	 * @return	void
	 */
	public function sales_package($sales_package_id = '')
	{
		if ($sales_package_id == '')
		{
			// nothing more to do...
			// set flash notice
			$this->session->set_flashdata('sales_package_invalid_credentials', TRUE);

			// nothing more to do...
			redirect('account');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_validate_email');

		if ($this->form_validation->run() == FALSE)
		{
			// set data variables...
			$this->data['view'] = 'form';

			// set data variables...
			$this->data['file'] = 'account_sales_package_request';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;

			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
		}
		else
		{
			if ($this->wholesale_user_details->initialize(array('email'=>$this->input->post('email'))))
			{
				$user_cat = 'wholesale';
				$user_id = $this->wholesale_user_details->user_id;

			}
			elseif ($this->consumer_user_details->initialize(array('email'=>$this->input->post('email'))))
			{
				$user_cat = 'consumer';
				$user_id = $this->consumer_user_details->user_id;
			}
			else
			{
				// set flash notice
				$this->session->set_flashdata('error', 'no_id_passed');

				// rediect back to sign in page
				redirect('account');
			}

			// get sales package details
			$this->sales_package_details->initialize(array('sales_package_id'=>$sales_package_id));

			// begin send email requet to isntyle admin
				$email_message = '
					Dear TEAM,
					<br /><br />

					User email: '.$this->input->post('email').'<br />
					'.($user_cat == 'wholesale' ? 'Store Name: '.$this->wholesale_user_details->store_name.'<br />' : '').'

					<br /><br />
					Above user requests for sales package #'.$this->sales_package_details->sales_package_id.' - "'.$this->sales_package_details->sales_package_name.'".

					<br /><br />
					To send user the sales package,<br />
					please select his email in the link below:
					<br /><br />
					<a href="'.site_url('sales/sales_package/edit/step4/'.$this->sales_package_details->sales_package_id.'/'.$user_id).'" target="_blank">
						'.site_url('sales/sales_package/edit/step4/'.$this->sales_package_details->sales_package_id.'/'.$user_id).'
						</a>

					<br /><br />
					To view user account, click below link.
					<br /><br />
					<a href="'.site_url('sales/wholesale/edit/index/'.$user_id).'" target="_blank">
						'.site_url('sales/wholesale/edit/index/'.$user_id).'
						</a>
					<br />

					<p>Thanks,<br>'.$this->config->item('site_name').' Team.</p><br><br>
				';

				$this->load->library('email');

				// send email to admin
				$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
				$this->email->to($this->wholesale_user_details->admin_sales_email);
				$this->email->cc($this->webspace_details->info_email);
				$this->email->bcc($this->config->item('dev1_email')); // --> for debuggin purposes

				$this->email->subject('User Request for Sales Package from '.$this->webspace_details->name);
				$this->email->message($email_message);

				if (ENVIRONMENT == 'development') // ---> used for development purposes
				{
					// we are unable to send out email in our dev environment
					// so we check on the email template instead.
					// just don't forget to comment these accordingly
					echo $email_message;
					echo '<br /><br />';

					//echo '<a href="'.site_url('shop/designers/'.$this->reference_designer).'">Continue...</a>';
					echo '<br /><br />';
					exit;
				}
				else @$this->email->send();
			// end send email requet to isntyle admin

			// set data variables...
			$this->data['view'] = 'success-notice';

			// set data variables...
			$this->data['file'] = 'account_sales_package_request';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;

			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
		}
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
	 * PRIVATE - Create Plugin Scripts and CSS for the page
	 *
	 * This section is theme based.
	 * We will eventually need to come up with a system to load specific
	 * styles and scripts for each page as per selected theme
	 *
	 * @return	void
	 */
	private function _create_plugin_scripts()
	{
		//$assets_url = base_url('assets/themes/'.@$this->webspace_details->options['theme']);
		$assets_url = base_url('assets/metronic');

		/****************
		 * page styles plugins inserted at <head>
		 * after global mandatory styles, before theme global styles
		 */
		$this->data['page_level_styles_plugins'] = '';

			// ladda - show loading or progress bar on buttons
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '';

		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';

			// ladda - show loading or progress bar on buttons
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
			';
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
		 */
		$this->data['page_level_scripts'] = '';

			// button spinners for ladda
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/ui-buttons-spinners.min.js" type="text/javascript"></script>
			';
			// handle bootstrap select2
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'/assets/custom/js/metronic/pages/scripts/components-select2.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
