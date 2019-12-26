<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Common_model extends CI_Model{
	protected $DB;
	function __Construct()
	{
		parent::__Construct();
		
		// connect to database for use by model
		$this->DB = $this->load->database('instyle', TRUE);
	}
	public function add($table,$data){
		$this->DB->insert($table,$data);
		if($this->DB->insert_id() > 0)
			return $this->DB->insert_id();
		return false;
	}
	public function getAll($table,$where=null){
		$this->DB->select()->from($table);
		if($where !=null){
			$this->DB->where($where);
		}
		$query=$this->DB->get();
		if($query->num_rows() > 0)
			return $query->result();
		return false;
	}
	public function getById($table,$where=null){
		$query=$this->DB->select()->from($table)->where($where)->get();
		if($query->num_rows() > 0)
			return $query->row();
		return false;
	}
	
	public function delete($table,$where=null){
		if($this->DB->where($where)->delete($table))
			return true;
		return false;
	}
	public function getOne($table,$where=null){
		$query=$this->DB->select()->from($table)->where($where)->get();
		if($query->num_rows() > 0)
			return $query->row();
		return false;
	}
	public function update($table,$where,$data){
		if($this->DB->set($data)->where($where)->update($table))
			return true;
		return false;
	}
	public function universal($query=null){
		if($query!=null)
			return $this->DB->query($query);
	}
}