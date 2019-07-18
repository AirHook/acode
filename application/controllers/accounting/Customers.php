<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Controller{

	function __construct(){

		parent::__construct();

		if(!$this->isLoggedIn()){

			redirect('auth');

		}

		$this->load->model('common_model');

		$this->load->model('customer_model');

	}

	public function index($type=null){

		if($type=='ng'){

			$data['allUsers']=$this->customer_model->getAll('tbl_mcustomers',array('company_id'=>$this->session->userdata('company_id')));

			echo json_encode($data['allUsers']);exit();

		}else{

			$data['active']='Customer';

			$data['module']='accounting';

			$data['allUsers']=$this->customer_model->getAll('tbl_mcustomers',array('company_id'=>$this->session->userdata('company_id')));

			$this->displayView('accounting/customers/customer_view_list',$data,array(),array(

					'js'=>array(),

					'css'=>array(),

				));

		}

	}

	public function addCustomer($id=null,$type=null){

		if($this->isLoggedIn()){

				if($type=='ng'){



				}else{

					$data['active']='Customer';

					$data['module']='accounting';

					if($this->input->server('REQUEST_METHOD') === 'POST'){

						$formData=$this->input->post();

						unset($formData['submit']);

						$formData['company_id']=$this->session->userdata('company_id');

						if(isset($formData['id']) && !empty($formData['id'])){

							$update=$this->customer_model->update('tbl_mcustomers',array('id'=>$formData['id']),$formData);

							$email=$formData['email'];

							$openingBalanceForLedger=$formData['opening_balance'];
							if(isset($formData['crOrDr']))
							    $creditDebit = $formData['crOrDr'];
							else
								$creditDebit='';

							unset($formData);

							$update_ledger=$this->customer_model->update('tbl_accountledger',array('email'=>$email),array('openingBalance'=>$openingBalanceForLedger, 'crOrDr' => $creditDebit, 'editable' => 0));

							if($update > 0 && $update_ledger > 0){

								$this->session->set_flashdata('success', con_lang('mass_record_updated_successfully'));

								redirect($_SERVER['HTTP_REFERER']);

							}else{

								$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));

								redirect($_SERVER['HTTP_REFERER']);

							}

						}else{

							$result=$this->customer_model->getOne('tbl_mcustomers',array('email'=>$formData['email']));

							$result2=$this->customer_model->getOne(' tbl_accountledger',array('email'=>$formData['email']));

							if(!empty($result->email) && !empty($result2->email)){

								$this->session->set_flashdata('error',con_lang('mass_email_already_exist'));

								$data['model']=$this->input->post();

							}else{

								$saved=$this->customer_model->add('tbl_mcustomers',$formData);

								$formData['accountGroupId']=26;
								$formData['customer_id'] = $saved;
								$formData['openingBalance']=$formData['opening_balance'];

								unset($formData['opening_balance']);

								unset($formData['customerCode']);

								$formData['ledgerName']=$formData['customerName'];

								unset($formData['customerName']);
								$formData['editable'] = 0;
								$saved1=$this->customer_model->add('tbl_accountledger',$formData);

								if($saved > 0 && $saved1 > 0){

									$this->session->set_flashdata('success',con_lang('mass_record_added_successfully'));

									redirect($_SERVER['HTTP_REFERER']);

								}else{

									$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));

									redirect($_SERVER['HTTP_REFERER']);

								}

							}

						}

					}

					if(isset($id) && $id!=null){

						$data['model']=(array)$this->customer_model->getById('tbl_mcustomers',decode_uri($id));

						

					}
					$max_row = $this->common_model->getMaximumRow('tbl_mcustomers');
					$code = 1;
					if(isset($max_row->id)) {
						$code = (int)$max_row->id + 1;
					}
					$data['customer_code'] = sprintf('%05d', $code);

					$this->displayView('accounting/customers/add_customer',$data,array(),array(

							'js'=>array(),

							'css'=>array(),

						));

			  }

		}else{

			redirect('auth');

		}

	}

	public function importExcel($type=null){

		if($this->isLoggedIn()){

			if($type == 'ng'){



			}else{

					//Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)	 

				         $configUpload['upload_path'] = FCPATH.'uploads/excel/';

				         $configUpload['allowed_types'] = 'xls|xlsx|csv';

				         $configUpload['max_size'] = '5000';

				         $this->load->library('upload', $configUpload);

				         $this->upload->do_upload('userfile');	

				         $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.

				         $file_name = $upload_data['file_name']; //uploded file name

						 $extension=$upload_data['file_ext'];    // uploded file extension

						

				//$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 

				 $objReader= PHPExcel_IOFactory::createReader('Excel2007');	// For excel 2007 	  

				          //Set to read only

				          $objReader->setReadDataOnly(true); 		  

				        //Load excel file

						 $objPHPExcel=$objReader->load(FCPATH.'uploads/excel/'.$file_name);		 

				         $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel      	 

				         $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);                

				          //loop from first data untill last data

				          for($i=2;$i<=$totalrows;$i++)

				          {

				              $FirstName= $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();			

				              $LastName= $objWorksheet->getCellByColumnAndRow(1,$i)->getValue(); //Excel Column 1

							  $Email= $objWorksheet->getCellByColumnAndRow(2,$i)->getValue(); //Excel Column 2

							  $Mobile=$objWorksheet->getCellByColumnAndRow(3,$i)->getValue(); //Excel Column 3

							  $Address=$objWorksheet->getCellByColumnAndRow(4,$i)->getValue(); //Excel Column 4

							  $data_user=array('FirstName'=>$FirstName, 'LastName'=>$LastName ,'Email'=>$Email ,'Mobile'=>$Mobile , 'Address'=>$Address);

							  $this->excel_data_insert_model->Add_User($data_user);

				              

										  

				          }

				             unlink('././uploads/excel/'.$file_name); //File Deleted After uploading in database .			 

				             redirect(base_url() . "put link were you want to redirect");

					           

				       

				     }

					

				}else{

			      redirect('auth');

		    }

	   }

}