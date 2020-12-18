<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add extends Admin_Controller {

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
	 * Index - Add New Account
	 *
	 * @return	void
	 */
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('form_validation');
		$this->load->library('designers/designers_list');

		// set validation rules
		$this->form_validation->set_rules('name', 'Carousel Name', 'trim|required');
		$this->form_validation->set_rules('type', 'Carousel Type', 'trim|required');
		if ($this->input->post('date')) $this->form_validation->set_rules('date', 'Schedule', 'trim|required');
		if ($this->input->post('week')) $this->form_validation->set_rules('week', 'Schedule', 'trim|required');
		if ($this->input->post('month')) $this->form_validation->set_rules('month', 'Schedule', 'trim|required');
		$this->form_validation->set_rules('layout', 'Layout', 'trim|required');
		if ($this->input->post('layout') && $this->input->post('layout') != 'default')
		{
			$this->form_validation->set_rules('designer[]', 'Designer', 'trim|required');
		}
		$this->form_validation->set_rules('stock_condition', 'Stock Condition', 'trim|required');
		$this->form_validation->set_rules('users', 'Users', 'trim|required');
		//$this->form_validation->set_rules('subject[]', 'Email Subject/s', 'trim|required');
		//$this->form_validation->set_rules('message[]', 'Email Message/s', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// some pertinent data
			if (@$this->webspace_details->options['site_type'] == 'hub_site')
			{
				$this->data['designers'] = $this->designers_list->select();
			}
			else
			{
				$this->data['designers'] = '';
			}

			// set data variables...
			$this->data['file'] = 'carousel_add';
			$this->data['page_title'] = 'Carousel Add';
			$this->data['page_description'] = 'Add new email carousel';

			// load views...
			$this->load->view('admin/metronic/template/template', $this->data);
		}
		else
		{
			$now = time();
			$post_ary = $this->input->post();

			// let's first process the schecule
			// there are only two possible options:
			// a single 'data' and recurring schedules
			// and, there are 2 recurring schedules:
			// weekly and monthly
			$cron_data = array();
			if (@$post_ary['date'])
			{
				$post_ary['schedule'] = strtotime($post_ary['date']);
			}
			else
			{
				if (@$post_ary['week']) $cron_data['week'] = $post_ary['week'];
				if (@$post_ary['month']) $cron_data['month'] = $post_ary['month'];
				$post_ary['cron_data'] = json_encode($cron_data);
			}

			// process cron_data if any
			// save the next schedule at 'schedule'
			if ( ! empty($cron_data))
			{
				if (@$cron_data['week'])
				{
					$days_of_the_week = explode(',', $cron_data['week']);
					$ref_ts = array();
					foreach ($days_of_the_week as $day)
					{
						// strtotime automatically generates the timestamp of the coming day
						// and not the past day which means, all days will be in future
						array_push($ref_ts, strtotime($day));
					}
					// sort the array to get the first next coming day at index '0'
					sort($ref_ts);

					// save it
					$post_ary['schedule'] = $ref_ts[0];
				}

				if (@$cron_data['month'])
				{
					$days_of_the_month = explode(',', $cron_data['month']);
					$ref_ts = array();
					foreach ($days_of_the_month as $day)
					{
						$this_month = date('M', $now);
						$ts_today = strtotime('today');
						if (strtotime($this_month.$day) < $ts_today)
						{
							$_this_mo = date('n', $now); // numeric month
							$_next_mo = $_this_mo + 1;
							$next_month = date('M', mktime(0, 0, 0, $_next_mo, 10));
							if ($next_month == 'Jan')
							{
								$_this_yr = date('Y', $now);
								$yr = ', '.$_this_yr + 1;
							}
							else $yr = $_this_yr;
							array_push($ref_ts, strtotime($next_month.$day.$yr));
						}
						else
						{
							array_push($ref_ts, strtotime($this_month.$day));
						}
					}
					// sort the array to get the first next coming day at index '0'
					sort($ref_ts);

					// save it
					$post_ary['schedule'] = $ref_ts[0];
				}
			}

			// filter and jsonify designer, subject and mesesage
			if (@$post_ary['designer'])
			{
				$post_ary['designer'] = array_filter($post_ary['designer']);
				$post_ary['designer'] = json_encode($post_ary['designer']);
			}
			$post_ary['subject'] = array_filter($post_ary['subject']);
			$post_ary['message'] = array_filter($post_ary['message']);
			$post_ary['subject'] = json_encode($post_ary['subject']);
			$post_ary['message'] = json_encode($post_ary['message']);

			// add other variables
			$post_ary['date_created'] = $now;
			$post_ary['last_modified'] = $now;
			$post_ary['webspace_id'] = $this->webspace_details->id;

			// do all unsets last to ensure no error upon record insert
			unset($post_ary['files']);
			unset($post_ary['date']);
			unset($post_ary['week']);
			unset($post_ary['month']);

			// add record to database
			$DB = $this->load->database('instyle', TRUE);
			$query = $DB->insert('carousels', $post_ary);
			$insert_id = $DB->insert_id();

			// set flash data
			$this->session->set_flashdata('success', 'add');

			redirect('admin/marketing/carousels/edit/index/'.$insert_id, 'location');
			//redirect('admin/marketing/carousesl', 'location');
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
			$this->form_validation->set_message('validate_email', 'Please enter an email address on the Email field.');
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
	 * PRIVATE - Creaet Plugin Scripts and CSS for the page
	 *
	 * @return	void
	 */
	private function _create_plugin_scripts()
	{
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
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
			';
			// datepicker & date-time-pickers
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
			';
			// summernote wysiwyg
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '
		';

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
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// datepicker & date-time-pickers
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
			';
			// form validation
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
			';
			// summernote wysiwyg
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
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
			// handle bootstrap select - make select class '.bs-select' a boostrap select picker
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// handle datatable
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/admin-carousel_add.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
