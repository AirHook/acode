<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends MY_Controller {

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
	 * Get any new line of text from file after an update
	 * Also returns the line count status of the file
	 */
	public function index($id = 0, $state = 0)
	{
		if ($id == 0)
		{
			// nothing more to do...
			$log['state'] = 0;
			$log['unread'] = 0;
			$log['text'] = FALSE;
			exit;
		}
		
		// get vital info for path purposes
		$y = @date('Y', $id);
		$m = @date('m', $id);
		$path = './chat_archive/'.$y.'/'.$m.'/';
		if ($_POST['admin_sales_id'] != 0)
		{
			$file = $path.'chat_'.$id.'_'.$_POST['admin_sales_id'].'.txt';
		}
		else
		{
			$file = $path.'chat_'.$id.'.txt';
		}
		
		if (file_exists($file))
		{
			// Get a file into an array
			$lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			$count =  count($lines);
		}
		else $count = 0;
		
		if ($state == $count)
		{
			$log['state'] = $state;
			$log['unread'] = 0;
			$log['text'] = FALSE;
		}
		else
		{
			$test = array();
			$log['state'] = $count;
			foreach ($lines as $line_num => $line)
			{
				if ($line_num >= $state)
				{
					$text[] = $line;
				}
			}
			$log['unread'] = count($text) / 2;
			$log['text'] = $text; 
		}
		
		// echo json data
		echo json_encode($log);
	}
	
	// ----------------------------------------------------------------------
	
}
