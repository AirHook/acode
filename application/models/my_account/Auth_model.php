<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth_model extends CI_Model{
	protected $DB;
	
	
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();
		
		// connect to database for use by model
		$this->DB = $this->load->database('instyle', TRUE);
	}
	public function add($table, $data){
		$this->DB->insert($table,$data);
		if($this->DB->insert_id() > 0)
			return $this->DB->insert_id();
		return false;
	}
	public function getById($table,$where=null){
		$query=$this->DB->select()->from($table)->where($where)->get();
		if($query->num_rows() > 0)
			return $query->row();
		return false;
	}
	 public function login() {
        $result = $this->input->post("password"); 
       // print_r($result);die;       
        $this->DB->select();
        $this->DB->from('tbladmin_sales');
        $array = array('admin_sales_email' => $this->input->post("email"), 'admin_sales_password' => $result);
        $this->DB->where($array);
        $query = $this->DB->get();
        if($query)
        	return $query->result_array();
        else
			return false;
    }
}