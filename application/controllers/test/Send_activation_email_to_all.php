<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 */
class Send_activation_email_to_all extends Frontend_Controller
{
	// --------------------------------------------------------------------

	/**
	 * Primary method - index
	 *
	 * @return	void
	 */
	public function index($des_slug = '')
	{
		$this->output->enable_profiler(FALSE);

		echo 'Processing...<br />';

		// parameters
		$des_slug = $des_slug; // des_slug is used as option for when at hub_site
		$user_status = '1'; // 1-active

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_users_list');
		$this->load->library('users/wholesale_activation_email_sending');

		// get data
		$custom_where = ''; // handles mixed designer or no designer query
		if (@$this->webspace_details->options['site_type'] != 'hub_site')
		{
			$where['tbluser_data_wholesale.reference_designer'] = $this->webspace_details->slug;
		}
		else
		{
			if ($des_slug == $this->webspace_details->slug)
			{
				$custom_where = "(
					tbluser_data_wholesale.reference_designer IS NULL
					OR tbluser_data_wholesale.reference_designer = ''
					OR tbluser_data_wholesale.reference_designer = 'instylenewyork'
					OR tbluser_data_wholesale.reference_designer = '".$des_slug."'
				)";
			}
			else $where['tbluser_data_wholesale.reference_designer'] = $des_slug ?: '';
		}
		$where['tbluser_data_wholesale.is_active'] = $user_status;
		$users = $this->wholesale_users_list->select(
			$where,
			array(),
			array(),
			$custom_where
		);

		$i = 1;
		foreach ($users as $user)
		{
			echo $i.'. '.$user->email;
			echo ' -> ';

			if ($i >= 302)
			{
				// send activation email
				$this->wholesale_activation_email_sending->initialize(array('users'=>array($user->email)));
				//$this->wholesale_activation_email_sending->initialize(array('users'=>array('reystore@chaarmfurs.com')));
				/* */
				if ( ! $this->wholesale_activation_email_sending->send())
				{
					echo $this->wholesale_activation_email_sending->error;
				}
				else
				{
					echo ' SENT';
				}
				// */
			}

			echo '<br />';
			$i++;
		}

		echo 'Done!';
	}

	// --------------------------------------------------------------------

}
