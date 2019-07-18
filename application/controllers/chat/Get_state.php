<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_state extends MY_Controller {

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
	 * Get the number of lines in the chat transcript text file
	 * chat_XXXXXXXXXXXXXX - where XXXXXXXXXXXXXX is time()
	 */
	public function index($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			$log['state'] = 0;
			echo json_encode($log);
			exit;
		}
		
		// get vital info for path purposes
		$y = @date('Y', $id);
		$m = @date('m', $id);
		$path = './chat_archive/'.$y.'/'.$m.'/';
		$file = $path.'chat_'.$id.'.txt';
		
		if (file_exists($file))
		{
			// Get a file into an array
			$lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			$log['state'] = count($lines);
		}
		else $log['state'] = 0;
		
		// echo json data
		echo json_encode($log);
	}
	
	// ----------------------------------------------------------------------
	
}
