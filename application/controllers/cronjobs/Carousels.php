<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carousels extends MY_Controller {

	/**
	 * Mailgun API Key
	 *
	 * @var	string
	 */
	protected $key;

    /**
	 * Mailgun API Domain
	 *
	 * @var	string
	 */
	protected $domain;

	/**
	 * Now
	 *
	 * @var	int
	 */
	protected $now;


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

		// set some default properties
		$this->domain = $this->config->item('mailgun_domain');
		$this->key = $this->config->item('mailgun_api');
		$this->now = time();
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * Daily checks database for scheduled carousels
	 *
	 * @return	void
	 */
	public function index($test = '')
	{
		if ($test && ! $this->input->get('email'))
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'invalid_email');

			// redirect user
			redirect('admin/marketing/carousels/edit/index/'.$test, 'location');
		}

		//echo 'Processing...<br />';
		//echo 'Not done...';
		//die();

		// load pertinent library/model/helpers
		//$this->load->library('webspaces/webspace_details');
		$this->load->library('carousel/carousels_list');
		$this->load->library('products/product_details');
		$this->load->library('designers/designer_details');

		// initialize webspace_details (since extending directly on CI_Controller)
		//$this->webspace_details->initialize(array('domain_name'=>DOMAINNAME));

		// get carousel list that are scheduled for today
		// update 'schedule' field on carousels that are recurring after Processing
		// the update ensures that each recurring carousels are processed accordingly
		if ($test)
		{
			$carousels = @$this->carousels_list->select(
				array('carousel_id'=>$test)
			);
		}
		else
		{
			$today = strtotime('today');
			$carousels = @$this->carousels_list->select(
				array(
					'schedule'=>$today,
					'status'=>'1'
				)
			);
		}

		if ($carousels)
		{
			foreach ($carousels as $carousel)
			{
				echo 'Processing...<br />';

				/**
				// GET PRIVACY NOTICE
				*/
				// first, using the new pages_new table used at admin PAGES MANAGER
				if ($carousel->users == 'all' OR $carousel->users == 'consumers')
				{
					$q_privy = $this->DB->get_where(
						'pages_new',
						array(
							'url_structure' => 'privacy_notice',
							'user_tag' => 'consumer',
							'view_status' => 'Y',
							'webspace_id' => $this->webspace_details->id
						)
					)->row();
				}
				else
				{
					$q_privy = $this->DB->get_where(
						'pages_new',
						array(
							'url_structure' => 'privacy_notice',
							'user_tag' => 'wholesale',
							'view_status' => 'Y',
							'webspace_id' => $this->webspace_details->id
						)
					)->row();
				}

				if ($q_privy)
				{
					$data['privacy_policy'] = $q_privy->content;
				}
				else
				{
					// using the old table for privay notice
					$this->DB->select('text');
					$this->DB->where('title_code', 'wholesale_privacy_notice');
					$q = $this->DB->get('pages')->row();
					$data['privacy_policy'] = str_replace(
						array(
							'instylenewyork',
							'Instylenewyork',
							'shop7thavenue',
							'Shop7thavenue',
							'Shop 7th Avenue',
							'Instyle New York'
						),
						array(
							$this->webspace_details->slug,
							$this->webspace_details->slug,
							$this->webspace_details->slug,
							$this->webspace_details->slug,
							ucwords(strtolower($this->webspace_details->site)),
							ucwords(strtolower($this->webspace_details->site))
						),
						$q->text
					);
				}
				// */

				/**
				// GET CAROUSEL LAYOUT DATA
				// 'carousel_layout' for use on the email template
				// 'designers' for separation of thumbs where necessary as well as using designer logos
				// 'products' -> the thumbs
				*/
				// this determines the necessary iteration for the products and designers where necessary
				switch ($carousel->layout)
				{
					case 'single_designer':

						$data['carousel_layout'] = 'carousel_layout02';

						// this requires single designer and product list
						$data['designers'] =
							($carousel->designer && ! is_null($carousel->designer))
							? json_decode($carousel->designer, TRUE)
							: array()
						;

						// let's get some thumbs
						foreach ($data['designers'] as $designer)
						{
							// returned as items in an array (<prod_no>_<color_code>)
							$data['products'][$designer] = $this->_get_thumbs(
								$carousel->stock_condition,
								$carousel->thumbs_sent,
								$designer,
								$carousel->carousel_id,
								$carousel->layout,
								$test
							);
							// record proudct into a csv format for use on access link url
							// as reference to show same thumbs which needs to different
							// specially for multi designer carousel
							$data['items_csv'][$designer] = implode(',', $data['products'][$designer]);
						}

					break;
					case 'multi_designer':

						$data['carousel_layout'] = 'carousel_layout03';

						// this requires multiple designer and product lists per designer
						$data['designers'] =
							($carousel->designer && ! is_null($carousel->designer))
							? json_decode($carousel->designer, TRUE)
							: array()
						;

						// let's get some thumbs per designer
						$data['items_csv']['mixed'] = '';
						foreach ($data['designers'] as $key => $designer)
						{
							// returned as items in an array (<prod_no>_<color_code>)
							$data['products'][$designer] = $this->_get_thumbs(
								$carousel->stock_condition,
								$carousel->thumbs_sent,
								$designer,
								$carousel->carousel_id,
								$carousel->layout,
								$test
							);
							// record proudct into a csv format for use on access link url
							// as reference to show same thumbs which needs to different
							// specially for multi designer carousel
							if ($data['products'][$designer])
							{
								$data['items_csv'][$designer] = implode(',', $data['products'][$designer]);
								$data['items_csv']['mixed'] =
									empty($data['items_csv']['mixed'])
									? $data['items_csv']['mixed'].implode(',', $data['products'][$designer])
									: $data['items_csv']['mixed'].','.implode(',', $data['products'][$designer])
								;
							}
							else
							{
								// meaning there may be no products onsale or such circumstance
								// unset the respective designer accordingly
								unset($data['designers'][$key]);
								unset($data['products'][$designer]);
							}
						}

					break;
					default:

						$data['carousel_layout'] = 'carousel_layout01';

						// mixed designer data
						$data['designers'] = array('mixed');

						// let's get some thumbs regardless of designer
						// returned as items in an array (<prod_no>_<color_code>)
						$data['products']['mixed'] = $this->_get_thumbs(
							$carousel->stock_condition,
							$carousel->thumbs_sent,
							'mixed',
							$carousel->carousel_id,
							$carousel->layout,
							$test
						);
						// record proudct into a csv format for use on access link url
						// as reference to show same thumbs which needs to different
						// specially for multi designer carousel
						$data['items_csv']['mixed'] = implode(',', $data['products']['mixed']);
				}
				// */

				/**
				// UPDATE 'schedule' FIELD
				*/
				// updates the 'schedule' field on the database table for the next day's iteration
				// only for recurring carousels
				if ($carousel->cron_data)
				{
					$cron_data = json_decode($carousel->cron_data, TRUE);

					if (@$cron_data['week'])
					{
						$days_of_the_week = explode(',', $cron_data['week']);
						$ref_ts = array();
						foreach ($days_of_the_week as $day)
						{
							// strtotime automatically generates the timestamp of the coming day
							// and not the past day which means, all days will be in future
							// except for today
							array_push($ref_ts, strtotime($day));
						}
						// sort the array to get the first next coming day at index '0'
						sort($ref_ts);

						// save the next day to schedule
						$schedule = $ref_ts[1];
					}

					if (@$cron_data['month'])
					{
						$days_of_the_month = explode(',', $cron_data['month']);
						$ref_ts = array();
						foreach ($days_of_the_month as $day)
						{
							$this_month = date('M', $this->now);
							$ts_today = strtotime('today');
							if (strtotime($this_month.$day) < $ts_today)
							{
								$_this_mo = date('n', $this->now); // numeric month
								$_next_mo = $_this_mo + 1;
								$next_month = date('M', mktime(0, 0, 0, $_next_mo, 10));
								if ($next_month == 'Jan')
								{
									$_this_yr = date('Y', $this->now);
									$yr = ', '.($_this_yr + 1);
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

						// save the next day to schedule
						$schedule = $ref_ts[1];
					}

					// update schedule field
					if ($test == '')
					{
						/* */
						$this->DB->set('schedule', $schedule);
						// */
					}
				}
				else
				{
					// this means the carousel is a 'once' carousel
					// simply disable carousel when done
					// but, double check for type -> 'once'
					if ($carousel->type == 'once' && $test == '')
					{
						$this->DB->set('status', '0');
					}
				}
				// */

				/**
				// SUBJECTS AND MESSAGES
				// and whether to set new random key for subject and message index
				*/
				// get subjects
				$subject =
					($carousel->subject && ! is_null($carousel->subject))
					? json_decode($carousel->subject, TRUE)
					: array()
				;

				// get messages
				$message =
					($carousel->message && ! is_null($carousel->message))
					? json_decode($carousel->message, TRUE)
					: array()
				;

				// get the carousel type
				// determine whether to rotate on email subject and body message
				if ($carousel->type == 'recurring')
				{
					// get options
					$options =
						($carousel->options && ! is_null($carousel->options))
						? json_decode($carousel->options, TRUE)
						: array()
					;

					// we need to rotate on a list of email subjects
					// grab last random key used
					$last_rand_subject_key =
						isset($options['last_rand_subject_key'])
						? $options['last_rand_subject_key']
						: 0
					;

					// set new random key
					while(in_array($new_rand_subject_key = mt_rand(0, 4), array($last_rand_subject_key)));
					$options['last_rand_subject_key'] = $new_rand_subject_key;

					// set email subject
					$data['subject'] = $subject[$new_rand_subject_key];

					// we need to rotate on a list of email body messages
					// grab last random key used
					$last_rand_message_key =
						isset($options['last_rand_message_key'])
						? $options['last_rand_message_key']
						: 0
					;

					// set new random key
					while(in_array($new_rand_message_key = mt_rand(0, 4), array($last_rand_message_key)));
					$options['last_rand_message_key'] = $new_rand_message_key;

					// set email message
					$data['message'] = $message[$new_rand_message_key];

					// update previous rand key option
					if ($test == '')
					{
						/* */
						$this->DB->set('options', json_encode($options));
						$this->DB->set('last_modified', $this->now);
						$this->DB->where('carousel_id', $carousel->carousel_id);
						$this->DB->update('carousels');
						// */
					}
				}
				else
				{
					// set email subject and message
					$data['subject'] = $subject[0];
					$data['message'] = $message[0];
				}
				// */

				/**
				// USERS
				*/
				switch ($carousel->users)
				{
					case 'wholesale':
						if ($carousel->webspace_id == '4') $users = array('ws_tempo@mg.shop7thavenue.com');
						else $users = array('wholesale_users@mg.shop7thavenue.com');
						$data['user_role'] = 'ws';
					break;

					case 'consumers':
						$users = array('consumers@mg.shop7thavenue.com');
						$data['user_role'] = 'cs';
					break;

					case 'all':
					default:
						$users = array(
							'consumers@mg.shop7thavenue.com',
							'wholesale_users@mg.shop7thavenue.com',
							'ws_tempo@mg.shop7thavenue.com'
						);
						$data['user_role'] = 'cs';
				}

				// set the webspace id for use on the view file
				$data['webspace_id'] = $carousel->webspace_id;

				// lets set the hashed time code used for the access_link so that the batch holds the same tc only
				$data['tc'] = md5(@date('Y-m-d', $this->now));

				// set test email accordingly
				if ($test && $this->input->get('email'))
				{
					$data['test_email'] = $this->input->get('email');
				}
				else $data['test_email'] = '';

				// load and set the view file
				$content_body = $this->load->view('templates/carousel_wrapper', $data, TRUE);
			}
		}
		else
		{
			// nothing more to do...
			echo 'Nothing to do...';
			exit;
		}

		/**
		// SEND the carousel via MAILGUN
		*/
		// load pertinent library/model/helpers
		$this->load->library('mailgun/mailgun');

		// set up properties
		/* */
		if ($data['designers'] == array('mixed'))
		{
			$this->mailgun->vars = array("designer" => $this->webspace_details->name, "des_slug" => $this->webspace_details->slug);
		}
		else
		{
			$the_designers = implode(', ', $data['designers']);
			$this->mailgun->vars = array("designer" => $the_designers);
		}
		$this->mailgun->o_tag = $carousel->name;
		$this->mailgun->from = $this->webspace_details->name.' <'.$this->webspace_details->info_email.'>';

		if ($this->input->get('email'))
		{
			$this->load->library('email');

			$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
			$this->email->to($this->input->get('email'));

			$this->email->subject($data['subject'].' - TEST ONLY');
			$this->email->message($content_body);

			if ( ! $this->email->send())
			{
				/* */
				$error = 'Unable to send.<br />';
				$error.= $this->email->print_debugger();

				echo $error;
				exit;
				// */

				/* *
				// set flash data
				$this->session->set_flashdata('error', 'test_unsent');

				// redirect user
				redirect('admin/marketing/carousels/edit/index/'.$test, 'location');
				// */
			}

			// set flash data
			$this->session->set_flashdata('success', 'test_sent');

			// redirect user
			redirect('admin/marketing/carousels/edit/index/'.$test, 'location');
		}
		else
		{
			foreach ($users as $user_grp)
			{
				//$this->mailgun->to = $user_grp;
				$this->mailgun->to = 'test@mg.shop7thavenue.com';

				//$this->mailgun->cc = $this->webspace_details->info_email;
				//$this->mailgun->bcc = $this->CI->config->item('dev1_email');
				$this->mailgun->subject = $data['subject'];
				$this->mailgun->message = $content_body;

				if ( ! $this->mailgun->Send())
				{
					$error = 'Unable to send.<br />';
					$error .= $this->mailgun->error_message;

					echo $error;

					echo '<br />';
					echo $data['subject'];

					echo '<br /><br />';
					echo $content_body;
					exit;
				}

				$this->mailgun->clear();
				// */
			}
		}

		echo 'Done<br />';
		exit;
	}

	// --------------------------------------------------------------------

	/**
	 * Get activation emai product thumbs suggestion
	 *
	 * @params	string
	 * @return	array
	 */
	private function _get_thumbs($str, $thumbs_sent, $designer, $carousel_id, $layout, $test = '')
	{
		// set previous thumbs sent
		$thumbs = ($thumbs_sent && ! is_null($thumbs_sent)) ? json_decode($thumbs_sent, TRUE) : array();
		if ( ! isset($thumbs[$designer])) $thumbs[$designer] = array();
		$number_of_items_previous_sent = count($thumbs[$designer]);

		// set condition to pick thumbs not in previous thumbs sent
		$where = array();
		if ($number_of_items_previous_sent > 0)
		{
			$thumbs_csv = "'".@implode("','", $thumbs)."'";
			$where['condition'][] = "tbl_product.prod_no NOT IN (".$thumbs_csv.")";
		}

		// set designer(s) if any
		if ($designer != 'mixed') $where['designer.url_structure'] = $designer;

		// primary param
    	if ($str != 'mixed') $params['facets'] = array('availability'=>$str);

		// get the products list
		// show items even without stocks at all
		$params['with_stocks'] = TRUE;	// FALSE for including no stock items
		$params['group_products'] = TRUE; // FALSE for all variants
		// load and initialize class
		$this->load->library('products/products_list');
		$this->products_list->initialize($params);
		$products = $this->products_list->select(
			// where conditions
			$where,
			// sorting conditions
			array(
				'seque' => 'asc',
				'tbl_product.prod_no' => 'desc'
			)
		);
		$list_count = $this->products_list->row_count;

		//echo $this->products_list->last_query; die();

		// this 'if' condition only means that we have used all items for sending
		// thus, we need to reset the 'thumbs_sent' to empty
		if ($list_count == 0)
		{
			// reset $thumbs of specific designer (or mixed)
			$thumbs[$designer] = array();

			// unset where condition for previous thumbs sent
			unset($where['condition']);

			// redo query
			$this->products_list->initialize($params);
			$products = $this->products_list->select(
				// where conditions
				$where,
				// sorting conditions
				array(
					'seque' => 'asc',
					'tbl_product.prod_date' => 'desc',
					'tbl_product.prod_no' => 'desc'
				)
			);
		}

		// capture product numbers and set items array
		if ($products)
		{
			$cnt = 0;
			$items_array = array();
			foreach ($products as $product)
			{
				if ( ! in_array($product->prod_no, $thumbs[$designer]))
				{
					array_push($items_array, $product->prod_no.'_'.$product->color_code);
					array_push($thumbs[$designer], $product->prod_no);
					$cnt++;
				}

				if ($layout == 'multi_designer')
				{
					if ($cnt == 6) break;
				}
				else if ($cnt == 30) break;
			}

			// update previous thumbs sent
			if ($test == '')
			{
				/* */
				$DB = $this->load->database('instyle', TRUE);
				$DB->set('thumbs_sent', json_encode($thumbs));
				$DB->where('carousel_id', $carousel_id);
				$DB->update('carousels');
				// */
			}

			return $items_array;
		}
		else return FALSE;
	}

	// ----------------------------------------------------------------------

}
