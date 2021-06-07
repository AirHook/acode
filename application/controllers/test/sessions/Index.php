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
		echo '<pre>';
		echo 'Start tests on sessions and cookies.<br />';

		/* *
		unset($_COOKIE['instylenewyork_cart']);
		unset($_COOKIE['_cart']);
		unset($_COOKIE['cart']);
		// */

		/* *
		if ( ! isset($_COOKIE['cart']))
		{
			$options['expires'] = time() + 60;
			$options['path'] = '/';
			if (setcookie('cart', 'cart items 2', $options))
			{
				echo 'New cart cookie set<br />';
			}
		}
		else echo 'Cart cookie is present<br />';
		// */

		// check session
		echo 'Are there sessions?<br />';
		if ($_SESSION)
		{
			print_r($_SESSION);
			echo 'Yes, there is session!<br />';
			echo 'Last generated at '.date('Y-m-d H:s', $_SESSION['__ci_last_regenerate']).'<br />';
			echo 'session_id: '.session_id().'<br />';
			echo 'ip_address: '.$_SERVER['REMOTE_ADDR'].'<br />';
			echo 'user_agent: '.$this->input->user_agent().'<br />';
		}
		else echo 'No, there seems to be no session at all!<br />';

		// check cookie
		echo 'Are there cookies?<br />';
		if ($_COOKIE)
		{
			print_r($_COOKIE);
			echo 'Yes, there is cookie!<br />';
			//echo 'Last generated at '.date('Y-m-d H:s', $_SESSION['__ci_last_regenerate']).'<br />';
		}
		else echo 'No, there seems to be no cookies at all!<br />';

		echo $this->config->item('sess_expiration');
	}
}
