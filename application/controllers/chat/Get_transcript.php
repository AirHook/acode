<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_transcript extends MY_Controller {

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
	 * Get the entire chat transcript in case a reconnection is needed
	 */
	public function index($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			$log['transcript'] = 0;
		}
		
		// get vital info for path purposes
		$y = @date('Y', $id);
		$m = @date('m', $id);
		$file = base_url().$y.'/'.$m.'/chat_'.$id.'.txt';
		
		if (file_exists($file)
		{
			// Get a file into an array
			$lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		}
		
		$log['transcript'] = $lines;
		
		// echo json data
		echo json_encode($log);
	}
	
	// ----------------------------------------------------------------------
	
}
