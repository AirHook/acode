<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

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
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index()
	{
		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// Takes raw JSON data from the request
		$json = file_get_contents('php://input');

		if ($json)
		{
			echo '<pre>';
			echo $json.'<br />';
			// Converts it into a PHP array
			$data = json_decode($json, TRUE);
			print_r($data);
			echo '<br />';

			// segregate main indeces
			$params['signature'] = json_encode($data['signature']);
			$params['event_data'] = json_encode($data['event-data']);

			print_r($params);
			echo '<br />';
			// save post data
			$query = $DB->insert('mg_webhook', $params);

			echo $DB->affected_rows().'<br />';
			echo '<br />';
		}
		else
		{
			$query = $DB->get('mg_webhook');

			echo '<pre>';
			$i = 1;
			foreach ($query->result() as $row)
			{
				echo $i.' DB Records says:<br />';
				print_r(json_decode($row->signature, TRUE));
				echo '<br />';
				print_r(json_decode($row->event_data, TRUE));
				echo '<br />';

				$i++;
			}
		}

		echo 'done';
	}

	// ----------------------------------------------------------------------

}
