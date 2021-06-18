<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_chaarm_user_csv extends Frontend_Controller {

	/**
	 * DB Object
	 *
	 * @var	object
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

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		if ( ! $_POST)
		{
			echo form_open(
				'test/csv/Upload_chaarm_user_csv',
				array(
					'enctype' => 'multipart/form-data'
				)
			);
			echo '<input type="file" name="file" /><br />';
			echo '<input type="submit" value="Upload File" name="submit">';
			echo '</form>';

			exit;
		}
		else
		{
			if ($_FILES)
			{
				// we done need to save the file upload
				// we just need to read it
				$filehandle = $_FILES['file']['tmp_name'];

				// if file is not a csv file
				/* */
				$fileType = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
				if ($fileType !== 'csv')
				{
					// nothing to do anymore, bring back to main page...
					echo 'Invalid file.';
					exit();
				}
				// */

				// let us open the file
				ini_set("auto_detect_line_endings", true);
				$myfile = fopen($filehandle, "r") OR die("Unable to open file!");

				// let's create the fields array
				$fields = array(
					'address1',
					'address2',
					'city',
					'state',
					'zipcode',
					'telephone',
					'telephone2',
					'telephone3',
					'telephone4',
					'name',
					'name2',
					'country',
					'email',
					'code',
					'store_name'
				);

				// Output one line until end-of-file
				$ctr = 0;
				$data = array();
				while ( ! feof($myfile))
				{
					// process the current row's data
					if ($row = fgets($myfile))
					{
						$values = explode(',', $row);

						foreach ($values as $key => $value)
						{
							if ($key == 15) break;

							if (substr(trim($fields[$key]), 0, 3) == chr(hexdec('EF')).chr(hexdec('BB')).chr(hexdec('BF')))
							{
								$fields[$key] = substr(trim($fields[$key]), 3);
							}

							$subdata[trim($fields[$key])] = trim($value);
						}

						array_push($data, $subdata);

						$ctr++;
						//if ($ctr === 10) break; //die('Count 10<br />');
					}
				}

				// let us not forget to close the file
				fclose($myfile);

				// if file is empty
				if (empty($data))
				{
					// nothing to do anymore, bring back to main page...
					echo 'File is empty.';
					exit();
				}

				// iterate through the data
				// process parameters
				// update database
				// update mailgun
				// send activation email
				foreach ($data as $row)
				{
					// if email is present
					if ($row['email'] != '')
					{
						// process some variables
						// set countires array
						$country_ary = array(
							'US' => 'United States',
							'us' => 'United States',
							'USA' => 'United States',
							'ARGENTINA' => 'Argentina',
							'GUATEMALA' => 'Guatemala',
							'BR' => 'Brazil',
							'BRAZIL' => 'Brazil',
							'CANADA' => 'Canada',
							'CHILE' => 'Chile',
							'NJ' => 'United States',
							'ISRAEL' => 'Israel',
							'BELGUEM' => 'Belgium',
							'COLOMBIA' => 'Colombia',
							'COL' => 'Colombia',
							'PERU' => 'Peru',
							'CHILE' => 'Chile',
							'BRazil' => 'Brazil',
							'ENGLAND' => '',
							'UAE' => 'United Arab Emiratees',
							'MEXICO D.F' => 'Mexico',
							'MEXICO' => 'Mexico',
							'MX' => 'Mexico',
							'SP' => 'Spain',
							'BRASIL' => 'Brazil',
							'PA' => '',
							'SWEDEN' => 'Sweden',
							'MA' => ''
						);

						// load wholesale user details class
						$this->load->library('users/wholesale_user_details');
						if (
							! $this->wholesale_user_details->initialize(
								array(
									'email' => trim($row['email'])
								)
							)
						)
						{
							// set first and last name
							$name = explode(' ', $row['name']);
							$lastname = ucwords(strtolower($name[count($name) - 1]));
							$firstname = '';
							foreach ($name as $key => $nm)
							{
								if ($key == count($name) - 1) break;
								$firstname.= $nm.' ';
							}
							$firstname = ucwords(strtolower(trim($firstname)));

							// sanitize email
							$email = strtolower($row['email']);

							// get the username part of email and set is as pass
							$email_exp = explode('@', $email);
							$password = $email_exp[0];

							// set user data
							$user_data = array(
								'address1' => $row['address1'],
								'address2' => $row['address2'],
								'city' => $row['city'],
								'state' => $row['state'],
								'zipcode' => $row['zipcode'],
								'country' => $row['country'],
								'telephone' => $row['telephone'],
								'telephone2' => $row['telephone2'],
								'telephone3' => $row['telephone3'],
								'firstname' => $firstname,
								'lastname' => $lastname,
								'email' => $email,
								'pword' => $password,
								'store_name' => $row['store_name'],
								'create_date' => '2021-06-09',
								'reference_designer' => 'chaarmfurs',
								'admin_sales_email' => 'forneman@gmail.com',
								'access_level' => '2',
								'is_active' => '1'
							);

							// udpate database
							$this->DB->insert('tbluser_data_wholesale', $user_data);

							// update mailgun
							/* */
							$params['address'] = $row['email'];
							$params['fname'] = $firstname;
							$params['lname'] = $lastname;
							$params_vars = array(
								// some hard coded items as this script is specific
								'designer' => 'Chaarm Furs',
								'designer_slug' => 'chaarmfurs',
								'store_name' => $row['store_name']
							);
							$params['vars'] = json_encode($params_vars);
							$params['description'] = 'Wholesale User';
							$params['list_name'] = 'ws_chaarmfurs@mg.shop7thavenue.com';
							$this->load->library('mailgun/list_member_add', $params);
							$res = $this->list_member_add->add();
							$this->list_member_add->clear();
							// */

							// send activation email
							// load and initialize wholesale activation email sending library
							/* *
							$this->load->library('users/wholesale_activation_email_sending');
							$this->wholesale_activation_email_sending->initialize(
								array(
									'users' => array(
										$row['email']
									)
								)
							);
							$this->wholesale_activation_email_sending->send();
							// */
						}
					}
				}

				/* *
				echo '<pre>';
				print_r($user_data_ary);
				die();
				// */
			}
		}

		echo 'Done!';
	}

	// ----------------------------------------------------------------------

}
