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
		$test = 0;
		echo $test ? date('F j, Y', $test) : '';

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		$time_record = time();

		$query = $DB->get_where(
			'online_users',
			array(
				'user_id' => (@$this->user_id ?: '6643'),
				'user_cat' => 'wholesale',
				'email' => (@$this->email ?: 'rsbgm@rcpixel.com'),
			)
		);

		echo '<pre>';
		print_r($query->result());
		echo '<br />';

		// record user as online
		if ( ! $DB->get_where(
				'online_users',
				array(
					'user_id' => (@$this->user_id ?: '6643'),
					'user_cat' => 'wholesale',
					'email' => (@$this->email ?: 'rsbgm@rcpixel.com'),
				)
			)->result()
		)
		{
			echo 'empty so insert...';
			die();

			$data = array(
				'user_id' => (@$this->user_id ?: '6643'),
				'user_cat' => 'wholesale',
				'email' => (@$this->email ?: 'rsbgm@rcpixel.com'),
				'lastonline' => $time_record
			);
			$this->insert('online_users', $data);
		}
		else
		{
			echo 'not empty so update...';
			die();

			$this->set('lastonline', $time_record);
			$this->where('user_id', (@$this->user_id ?: '6643'));
			$this->where('user_cat', 'wholesale');
			$this->where('email', (@$this->email ?: 'rsbgm@rcpixel.com'));
			$this->update('online_users');
		}

		die();

		echo time();
		echo '<br />';
		echo strtotime('-1 day');
		echo '<br />';
		echo date('Y-m-d', strtotime('yesterday'));
		echo '<br />';
		echo date('Y-m-d', strtotime('-2 days'));

		die();

		$year = date('Y', time());

		echo 'Year '.$year;
		echo '<br />';
		echo '10 years from now is '.($year + 10);
		echo '<br />';
		echo 'Next year is '.$year+=1;
		echo '<br />';

		?>
		<video style="border:1px solid #333;background:black;" autoplay="" loop="" width="60" height="90">
			<source src="http://localhost/Websites/acode/product_assets/WMANSAPREL/basixblacklabel/cocktail/product_video/D3090A_BLAC1.mp4" type="video/mp4">
			<source src="http://localhost/Websites/acode/product_assets/WMANSAPREL/basixblacklabel/cocktail/product_video/D3090A_BLAC1.ogv" type="video/ogg">
			<source src="http://localhost/Websites/acode/product_assets/WMANSAPREL/basixblacklabel/cocktail/product_video/D3090A_BLAC1.webm" type="video/webm">
			Your browser does not support the video tag.
		</video>
		<?php
	}
}
