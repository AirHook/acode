<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Roles extends MY_Controller{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('auth');
		}
		$this->load->model('common_model');
		$this->load->model('user_model');

	}
	public function index($id=null, $type = null){
		if($type=='ng'){
		}else{
			
			$data['active']='User Roles';
			$data['module']='accounting';
			$data['roles']=$this->common_model->getAll('tbl_user_roles', array('company_id' => $this->company_id));
			if($id != null) {
				$data['model'] = $this->common_model->getOne('tbl_user_roles', array('id' => $id));
			}
			$this->displayView('accounting/users/user_roles',$data,array(),array(
					'js'=>array(),
					'css'=>array(),
				));
		}
	}
	public function saveUserRole() {
		if($this->input->post('submit')) {
			$postData = $_POST;
			unset($postData['submit']);
			
			$response = false;
			if(isset($postData['id'])) {
				$response = $this->common_model->update('tbl_user_roles', array('id' => $postData['id']), $postData);
			} else {
				$postData['company_id'] = $this->company_id;
				$response = $this->db->insert('tbl_user_roles', $postData);
			}
			if($response)
	  			$this->session->set_flashdata('success', 'User Role Save successfully');
	  		else
	  			$this->session->set_flashdata('error', 'Error occurred');
	  		redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function deleteUserRole($id = null) {
		$delete=$this->common_model->delete('tbl_user_roles',array('id'=>$id));
		if($delete){
			$this->session->set_flashdata('success','User Role deleted successfully');
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('errors','Error occurred try later');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function permissions(){
		$result['active']='User Permissions';
		$result['module']='accounting';
		// $result['all_users'] = $this->common_model->getAll('users' , array('is_admin'=>0, 'is_customer' => 0),array('created_on','desc'));
		$result['permissions_page'] = true;
		$result['groups'] = $this->common_model->getAll('tbl_user_roles', array('is_active' => 1, 'company_id' => $this->company_id));
		$this->displayView('accounting/users/user_permissions',$result,array(),array(
			'js'=>array(),
			'css'=>array(),
		));
	}

	public function get_user_roles_html() {
		$group_id = $this->input->post('group_id');
		$result['user_roles'] = array();
		if($group_id > 0) {
			$user_roles = $this->common_model->getOne('tbl_user_roles', array('id' => $group_id));
			$result['user_roles'] = explode(',', $user_roles->permissions);
		}
		$result['permisions'] = array('View', 'Add', 'Edit', 'Delete', 'Approve','Print','Import','Export','Edit Price', 'Edit Date', 'Allow Disc');
		$result['modules'] = $this->common_model->getAll('tbl_modules', null, array('order_id', 'ASC'));
		if(!empty($result['modules'])) {
			foreach ($result['modules'] as &$module) {
				if(isset($module->id)) {
					$roles = $this->common_model->getAll('tbl_user_permissions', array('module_id' => $module->id));
					$return_roles = array();
					if(!empty($roles)) {
						foreach ($roles as &$value) {
							$return_roles[$value->order_id] = $value;
						}
					}
					$module->roles = $return_roles;
				}
			}
			// debug($module);
		}
		$this->load->view('accounting/users/permissions_table', $result);
	}

	public function save_roles() {
		if($this->input->post('user_permissions_submit')) {
			$group_id = $this->input->post('group');
			$roles = $this->input->post('roles');
		
			$roles = array_keys($roles);
			$roles = implode(',', $roles);
			$this->session->set_flashdata('group_id', $group_id);
			if($this->common_model->update('tbl_user_roles', array('id' => $group_id), array('permissions' => $roles))) {
				$this->session->set_flashdata('success', 'User permissions updated successfully');
	  		} else {
	  			$this->session->set_flashdata('error', 'Error occurred');
	  		}
	  		redirect($_SERVER['HTTP_REFERER']);
		}
	}
}