<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_account_Controller extends MY_Controller
{
	public $current_user = null;
	public $upload_path = null;
	public $theme_css_path = null;
	protected $theme_name = null;
	protected $template = array();
	public $rs_path = null;
	public $js_path = null;
	public $css_path = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('my_account/general_helper');
		$this->rs_path = base_url().'assets/my-account/';
		$this->js_path = base_url().'assets/my-account/js/';
		$this->css_path = base_url().'assets/my-account/css/';
		// $this->theme_name = 'basic_theme';
		$this->theme_name = 'insapinia_theme';
		$this->theme_css_path = base_url().'assets/my-account/'.$this->theme_name.'/';
		$this->theme_js_path = base_url().'assets/my-account/'.$this->theme_name.'/';
		$this->load->model('my_account/common_model');
	}
	public function isLoggedIn()
	{
		$userID = $this->session->userdata('admin_sales_id');
		if($userID != null && $userID > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function upload_file($fieldName)
	{
		$config['upload_path']          = 'resources/user_upload/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;
        $this->load->library('upload', $config);
        if(! $this->upload->do_upload($fieldName))
        	return false;
        else
        	return $this->upload->data();
	}
	public function custom_upload_file($file) 
	{
		$name = time().'_'.$file['name'];
		$path = $this->upload_path.$name;
		if(file_exists($path))
			unlink($path);
		if(move_uploaded_file($file['tmp_name'], $path) === false)
			return false;
		else
			return $name;
	}
	public function getProjectScripts() 
	{
		return array(
			$this->js_path.'my_account.js'
		);
	}
	public function getProjectStyles() 
	{
		return array(
			$this->css_path.'custom.css'
		);
	}
	public function displayView($view = null, $data, $exclude = array(), $resources = array(), $return = false) 
	{
		$data['resources'] = $resources;
		$project_css_files = $this->getProjectStyles();
		if(isset($resources['css'])){
			foreach($resources['css'] as $css){
				array_push($project_css_files, $css);
			}
		}
		$data['resources']['css'] = $project_css_files;
		if(file_exists(FCPATH.'views/my_account/admin/themes/'.$this->theme_name.'/header.php') && !in_array('header', $exclude))
			$this->template['header'] = $this->load->view('my_account/admin/themes/'.$this->theme_name.'/header', $data, true);
		if(file_exists(FCPATH.'views/my_account/admin/themes/'.$this->theme_name.'/topbar.php') && !in_array('topbar', $exclude))
			$this->template['topbar'] = $this->load->view('my_account/admin/themes/'.$this->theme_name.'/topbar', $data, true);
		if(file_exists(FCPATH.'views/my_account/admin/themes/'.$this->theme_name.'/sidenav.php') && !in_array('sidenav', $exclude))
			$this->template['sidenav'] = $this->load->view('my_account/admin/themes/'.$this->theme_name.'/sidenav', $data, true);
		if($view != null) {
			if(is_array($view)) {
				$content = '';
				foreach ($view as $key => $value){
					$content .= $this->load->view($value, $data, true);
				}
				$this->template['content'] = $content;
			} else {
				$this->template['content'] = $this->load->view($view, $data, true);
			}
		}
		if(file_exists(FCPATH.'views/my_account/admin/themes/'.$this->theme_name.'/footer.php') && !in_array('footer', $exclude))
			$this->template['footer'] = $this->load->view('my_account/admin/themes/'.$this->theme_name.'/footer', $data, true);
		if($return)
			return $this->load->view('my_account/admin/themes/'.$this->theme_name.'/index', $this->template, true);
		else
			$this->load->view('my_account/admin/themes/'.$this->theme_name.'/index', $this->template);
	}
	public function displayHeader($data) {
		if(file_exists(FCPATH.'views/my_account/admin/themes/'.$this->theme_name.'/header.php'))
			$this->load->view('my_account/admin/themes/'.$this->theme_name.'/header', $data);
	}
	public function displayFooter($data) {
		if(file_exists(FCPATH.'views/my_account/admin/themes/'.$this->theme_name.'/footer.php'))
			$this->load->view('my_account/admin/themes/'.$this->theme_name.'/footer', $data);
	}
	public function pageNotFound() {
		if(file_exists(FCPATH.'views/my_account/admin/themes/'.$this->theme_name.'/header.php'))
			$this->load->view('my_account/admin/themes/'.$this->theme_name.'/header');
		if(file_exists(FCPATH.'views/my_account/admin/themes/'.$this->theme_name.'/404.php'))
			$this->load->view('my_account/admin/themes/'.$this->theme_name.'/404');
		else
			$this->load->view('admin/404');
		if(file_exists(FCPATH.'views/my_account/admin/themes/'.$this->theme_name.'/footer.php'))
			$this->load->view('my_account/admin/themes/'.$this->theme_name.'/footer');
	}
	public function showFlash(){
		  $error = $this->session->userdata('errors');
		  $success = $this->session->userdata('success');
		  if(isset($error)) {
		      echo '<div class="alert alert-danger alert-dismissable"> ';
	          echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
	          print_r($error);
	          echo '</span>';
	          echo'</div>';
	          unset($_SESSION['errors']);
		  } else if(isset($success)) {
	          echo '<div class="alert alert-success alert-dismissable"> ';
              echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
              print_r($success);
              echo '</span>';
              echo'</div>';
              unset($_SESSION['success']);
		  } 
	}
}