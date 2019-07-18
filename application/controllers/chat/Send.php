<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send extends MY_Controller {

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
	 * Client - receives a message from client/user
	 *
	 * Message is processed and then written into the chat file
	 * Also returns the line count status of the file
	 */
	public function client($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			echo json_encode(array('FALSE'));
			exit;
		}
		
		// get vital info for path purposes
		$y = @date('Y', $id);
		$m = @date('m', $id);
		$path = './chat_archive/'.$y.'/'.$m.'/';
		if ($_POST['admin_sales_id'])
			$file = $path.'chat_'.$id.'_'.$_POST['admin_sales_id'].'.txt';
		else
			$file = $path.'chat_'.$id.'.txt';
		
		// craete directory where necessary
		if ( ! file_exists($path))
		{
			$old = umask(0);
			if ( ! mkdir($path, 0777, TRUE)) 
				header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
				echo 'Unable to create "'.$path.'" folder.';
				echo json_encode(array('status'=>'FALSE'));
				exit;
			umask($old);
		}
		
		// let's grab post data
		//$username = htmlentities(strip_tags($_POST['username']));
		$message = htmlentities(strip_tags(@$_POST['message']));
		
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		
		// process message
		if (($message) != "\n")
		{
			if (preg_match($reg_exUrl, $message, $url)) 
			{
       			$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
			}
			
			fwrite(fopen($file, 'a'), "client\r\n" . $message = str_replace("\n", " ", $message) . "\r\n");
		}
		else
		{
			echo json_encode(array('status'=>'FALSE'));
			exit;
		}
		
		// return
		echo json_encode(array('TRUE'));
	}

	// --------------------------------------------------------------------

	/**
	 * Admin - receives a message from admin
	 *
	 * Message is processed and then written into the chat file
	 * Also returns the line count status of the file
	 */
	public function admin($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			echo json_encode(array('status'=>'FALSE'));
			exit;
		}
		
		// get vital info for path purposes
		$y = @date('Y', $id);
		$m = @date('m', $id);
		$path = './chat_archive/'.$y.'/'.$m.'/';
		if ($_POST['admin_sales_id'])
			$file = $path.'chat_'.$id.'_'.$_POST['admin_sales_id'].'.txt';
		else
			$file = $path.'chat_'.$id.'.txt';
		
		// craete directory where necessary
		if ( ! file_exists($path))
		{
			$old = umask(0);
			if ( ! mkdir($path, 0777, TRUE)) 
				header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
				echo 'Unable to create "'.$path.'" folder.';
				echo json_encode(array('status'=>'FALSE'));
				exit;
			umask($old);
		}
		
		// let's grab post data
		//$username = htmlentities(strip_tags($_POST['username']));
		$message = htmlentities(strip_tags(@$_POST['message']));
		
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		
		// process message
		if (($message) != "\n")
		{
			if (preg_match($reg_exUrl, $message, $url)) 
			{
       			$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
			}
			
			fwrite(fopen($file, 'a'), "admin\r\n" . $message = str_replace("\n", " ", $message) . "\r\n");
		}
		else
		{
			echo json_encode(array('status'=>'FALSE'));
			exit;
		}
		
		// return
		echo json_encode(array('status'=>'TRUE'));
	}
	
	// --------------------------------------------------------------------

	/**
	 * WS NEW - receives a NEW message from client/user
	 *
	 * Message is processed and then written into a new chat file
	 * Awaiting response from admin
	 * Also returns the line count status of the file
	 */
	public function ws_new($user_id = '')
	{
		if ( ! $user_id)
		{
			// nothing more to do...
			echo json_encode(array('chat_id'=>FALSE));
			exit;
		}
		
		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		
		$ws_user = $this->wholesale_user_details->initialize(array('user_id'=>$user_id));
		if ( ! $ws_user)
		{
			// nothing more to do...
			echo json_encode(array('chat_id'=>FALSE));
			exit;
		}
		
		// get vital info for path purposes
		$id = time();
		$y = @date('Y', $id);
		$m = @date('m', $id);
		$path = './chat_archive/'.$y.'/'.$m.'/';
		$file = $path.'chat_'.$id.'_'.$_POST['admin_sales_id'].'.txt';
		
		// craete directory where necessary
		if ( ! file_exists($path))
		{
			$old = umask(0);
			if ( ! mkdir($path, 0777, TRUE)) 
				header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
				echo 'Unable to create "'.$path.'" folder.';
				echo json_encode(array('chat_id'=>FALSE));
				exit;
			umask($old);
		}
		
		// let's grab post data
		//$username = htmlentities(strip_tags($_POST['username']));
		$message = htmlentities(strip_tags(@$_POST['message']));
		
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		
		// process message
		if (($message) != "\n")
		{
			if (preg_match($reg_exUrl, $message, $url)) 
			{
       			$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
			}
			
			fwrite(fopen($file, 'a'), "client\r\n" . $message = str_replace("\n", " ", $message) . "\r\n");
		}
		else
		{
			echo json_encode(array('chat_id'=>FALSE));
			exit;
		}
		
		// set the chat_id for access by admin via logindata of wholesale user
		// load pertinent library/model/helpers
		$this->load->model('get_wholesale_login_details');
		if ($this->get_wholesale_login_details->check_id($_SESSION['this_login_id']))
		{
			// get current logindata (@return is always an array)
			$cur_logindata = $this->get_wholesale_login_details->get();
			
			// add/edit chat_is key value
			$cur_logindata['chat_id'] = $id;
			
			$this->get_wholesale_login_details->update($cur_logindata);
		}
		
		// set data to send back
		$data = array(
			'token' => $this->security->get_csrf_hash(),
			'chat_id' => $id
		);
		
		// return
		echo json_encode($data);
	}
	
	// ----------------------------------------------------------------------
	
	// --------------------------------------------------------------------

	/**
	 * ADMIN NEW - receives a NEW message from admin
	 *
	 * Message is processed and then written into a new chat file
	 * Awaiting response from client/user
	 * Also returns the line count status of the file
	 */
	public function admin_new($user_id = '')
	{
		if ( ! $user_id)
		{
			// nothing more to do...
			echo json_encode(array('chat_id'=>FALSE));
			exit;
		}
		
		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		
		$ws_user = $this->wholesale_user_details->initialize(array('user_id'=>$user_id));
		if ( ! $ws_user)
		{
			// nothing more to do...
			echo json_encode(array('chat_id'=>FALSE));
			exit;
		}
		
		// get vital info for path purposes
		$id = time();
		$y = @date('Y', $id);
		$m = @date('m', $id);
		$path = './chat_archive/'.$y.'/'.$m.'/';
		$file = $path.'chat_'.$id.'_'.$_POST['admin_sales_id'].'.txt';
		
		// craete directory where necessary
		if ( ! file_exists($path))
		{
			$old = umask(0);
			if ( ! mkdir($path, 0777, TRUE)) 
				header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
				echo 'Unable to create "'.$path.'" folder.';
				echo json_encode(array('chat_id'=>FALSE));
				exit;
			umask($old);
		}
		
		// let's grab post data
		//$username = htmlentities(strip_tags($_POST['username']));
		$message = htmlentities(strip_tags(@$_POST['message']));
		
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		
		// process message
		if (($message) != "\n")
		{
			if (preg_match($reg_exUrl, $message, $url)) 
			{
       			$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
			}
			
			fwrite(fopen($file, 'a'), "admin\r\n" . $message = str_replace("\n", " ", $message) . "\r\n");
		}
		else
		{
			echo json_encode(array('chat_id'=>FALSE));
			exit;
		}
		
		// set the chat_id for access by admin via logindata of wholesale user
		// load pertinent library/model/helpers
		$this->load->model('get_wholesale_login_details');

		// get current logindata (@return is always an array)
		$cur_logindata = $this->get_wholesale_login_details->admin_get_logindata($ws_user->email);
		
		// add/edit chat_is key value
		$cur_logindata['chat_id'] = $id;
		
		$this->get_wholesale_login_details->admin_chat_update($cur_logindata, $ws_user->email);
		
		// set data to send back
		$data = array(
			'chat_id' => $id
		);
		
		// return
		echo json_encode($data);
	}
	
	// ----------------------------------------------------------------------
	
}
