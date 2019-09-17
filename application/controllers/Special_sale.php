<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
*    Class Used for Unsubscribe from Special Sale Mailing List
*    Read query string parameters ut, ue and td. ut is convension for "User Type" and having two values
*    at the moment like 'cu'  for Consumer User and 'wu' for Wholesale user.
*    Once User Type is confirmed. Read Other params ue and td from query string and make Subscription *    Key (Concat ue and td). 
*    Get subscription_key from Userdata Options field of 'tbluser_data' table.
*    If subscription_key is matched then add new Key  'unsubsribe_special_sale' added to UserData   *    options and remove subscription_key from UserData. 
* 
*/
class Special_sale extends CI_Controller {
	private $ut,$ue,$td,$subscription_key,$DB;
	public $data;
	function __Construct()
	{
		parent::__Construct();
		$this->DB = $this->load->database('instyle', TRUE); 
	}
	public function unsubscribe(){
		$this->ut = $this->input->get('ut', TRUE);
		//$this->wu = $this->input->get('wu', TRUE);
		$this->ue = $this->input->get('ue', TRUE);
		$this->td = $this->input->get('td', TRUE);
		if(isset($this->ut) && $this->ut == 'cu'){ 
			$this->subscription_key = $this->ue.$this->td;
			$this->load->library('users/consumer_users_list');
			$this->load->library('users/consumer_user_details');
			$query_string = "SELECT tbluser_data.* from tbluser_data where tbluser_data.options like '%\"subscription_key\":\"".$this->subscription_key."\"%'";
			$query = $this->DB->query($query_string); 
			$row = $query->row();
			// return object or FALSE on failure
			if (isset($row))
			{	
				$this->consumer_user_details->initialize(array('user_id'=>$row->user_id));
				$this->DB->set('is_active', '0');
				$this->DB->where('user_id', $row->user_id);
				$query = $this->DB->update('tbluser_data');
				$params['subscription_key'] = "";
				//Adding Special Sale Unsubscribe Key
				$params['unsubsribe_special_sale'] = true;
				$this->consumer_user_details->update_options($params);
				if($query){
					echo "You are sussfully unsubscribed from mailing list.";
				}
			}else{
				echo "You are already unsubscribed from mailing list.";	
			}	
			
		}
		if(isset($this->ut) && $this->ut == 'wu'){
			//TO DO
		}
	}
}
?>