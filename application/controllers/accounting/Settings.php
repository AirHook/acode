<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Settings extends MY_Controller{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('auth');
		}
		$this->load->model('company_model');
		$this->load->model('settings_model');
	}
	public function general($type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='General Settings';
					$data['module']='accounting';
					$data['timezones'] = $this->generate_timezone_list();
					$data['model'] = $this->common_model->getOne('tbl_company', array('companyId' => $this->company_id));
					$this->displayView('accounting/settings/general',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			redirect('auth');
		}
	}
	public function save() {
		if($this->input->post('submit')) {
			$formData = $this->input->post();
			unset($formData['submit']);
			
			if(isset($_FILES['company_logo']['tmp_name']) && $_FILES['company_logo']['tmp_name'] != '') {
				$path = 'assets/uploads/company_logo_'.$_FILES['company_logo']['name'];
				if(file_exists($path)){
					unlink($path);
				}
				if(move_uploaded_file($_FILES['company_logo']['tmp_name'], $path))
					$formData['company_logo'] = $path;
				else
					unset($formData['company_logo']);
			} else {
				if(!isset($formData['has_img']) || $formData['has_img'] == '0') {
					$formData['company_logo'] = '';
				} else {
					unset($formData['company_logo']);
				}
			}
			unset($formData['has_img']);
			if($this->common_model->update('tbl_company', array('companyId' => $this->company_id), $formData)) {
				$this->session->set_flashdata('success', 'Settings saved successfully!');
			} else {
				$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later!'));
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function email($type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Email Settings';
					$data['module']='accounting';
					$this->displayView('accounting/settings/email',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			redirect('auth');
		}
	}
	public function bankAccount($type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Bank Account';
					$data['module']='accounting';
					if($this->input->server('REQUEST_METHOD') === 'POST'){
						$formData=$this->input->post();
						$formData['company_id']=$this->company_id;
						$formData['from_date']=date('Y-m-d',strtotime($formData['from_date']));
						$formData['to_date']=date('Y-m-d',strtotime($formData['to_date']));						unset($formData['submit']);
						    	if(isset($formData['id']) && !empty($formData['id'])){
									$update=$this->settings_model->update('tbl_bankaccount',array('id'=>$formData['id']),$formData);
									if($update){
										$this->session->set_flashdata('success', con_lang('mass_bank_account_updated_successfully'));
										redirect($_SERVER['HTTP_REFERER']);
									}else{
										$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later!'));
										redirect($_SERVER['HTTP_REFERER']);
									}
							}else{
									$saved=$this->settings_model->add('tbl_bankaccount',$formData);
									if($saved){
										$this->session->set_flashdata('success',con_lang('mass_bank_account_created_successfully'));
										redirect($_SERVER['HTTP_REFERER']);
									}else{
										$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later!'));
										redirect($_SERVER['HTTP_REFERER']);
									}
								
							}
					}
					if(isset($id) && $id!=null){
						$data['model']=(array)$this->settings_model->getById('tbl_bankaccount',decode_uri($id));
					}
					$this->displayView('accounting/settings/bank_account',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			redirect('auth');
		}
	}
	public function financialYear($type = null) {
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Financial Year';
					$data['module']='accounting';
					$data['allData']=$this->settings_model->getAll('tbl_financialyear',array('company_id'=>$this->company_id));
					$this->displayView('accounting/settings/financialYear',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			redirect('auth');
		}
	}
	public function countries($type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Countries';
				$data['module']='accounting';
				$data['allData']=$this->settings_model->getAll('tbl_country',array('company_id'=>$this->company_id));
				$this->displayView('accounting/settings/countries_list',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function addCountry(){
				$country['country_name']=$this->input->post('country_name');
				$country['company_id']=$this->company_id;
				$country_id=$this->input->post('country_id');
				$results=$this->settings_model->getOne('tbl_country',array('country_name'=>$country['country_name'],'company_id'=>$country['company_id']));
				if(!empty($results)){
						$result['message']=con_lang("mass_this_country_is_already_exist");
						$result['response']=0;
						echo json_encode($result);exit();
				}else{
						if(isset($country_id) && $country_id!=''){
							$update=$this->settings_model->update('tbl_country',array('id'=>$country_id),$country);
							if($update){
									$result['message']=con_lang("mass_country_updated_successfully");
									$result['response']=1;
							}else{
								$result['message']=con_lang("mass_error_occurred");
								$result['response']=0;
								
							}
						}else{
							$saved=$this->settings_model->add('tbl_country',$country);
							if($saved){
									$result['message']=con_lang("mass_country_added_successfully");
									$result['response']=1;
							}else{
								$result['message']=con_lang("mass_error_occurred");
								$result['response']=0;
								
								}
						}
					}
				echo json_encode($result);exit();
	}
	public function addFinancialYear($type=null){
		if($this->isLoggedIn()){
				if($type == 'ng'){
				}else{
					$formData=$this->input->post();
					$formData['company_id']=$this->company_id;
					unset($formData['submit']);
					$formData['fromDate']=date("Y-m-d",strtotime($formData['fromDate']));
					$formData['toDate']=date("Y-m-d",strtotime($formData['toDate']));
					$formData['isActive']=1;
					$result=$this->settings_model->getOne('tbl_financialyear',array('fromDate'=>$formData['fromDate'],'toDate'=>$formData['toDate'],'company_id'=>$this->company_id));
					if(!empty($result)){
							$this->session->set_flashdata('error',con_lang("mass_this_financial_year_already_exist_and_currently_active"));
							redirect($_SERVER['HTTP_REFERER']);
					}else{
						$update=$this->settings_model->update('tbl_financialyear',array('isActive'=>1, 'company_id' => $this->company_id),array('isActive'=>0));
						if($update){
							$saved=$this->settings_model->add('tbl_financialyear',$formData);
							if($saved){
								$this->session->set_flashdata('success',con_lang("mass_add_successfully"));
								redirect($_SERVER['HTTP_REFERER']);
							}else{
								$this->session->set_flashdata('error',con_lang("mass_error_occurrs_try_later"));
								redirect($_SERVER['HTTP_REFERER']);
							}
						}
					}
				}
		}else{
			 redirect('auth');
		}
	}
	public function updateFinancialYearStatus($yearId=null,$type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				if($yearId !=null){
					$yearId=decode_uri($yearId);
						$update1=$this->settings_model->update('tbl_financialyear',array('company_id'=>$this->company_id),array('isActive'=>0));
						if($update1){
							$update=$this->settings_model->update('tbl_financialyear',array('id'=>$yearId),array('isActive'=>1));
							if($update){
									$this->session->set_flashdata('success',con_lang("mass_financial_year_active_successfully"));
									redirect($_SERVER['HTTP_REFERER']);
								}else{
									$this->session->set_flashdata('error',con_lang("mass_error_occurrs_try_later"));
									redirect($_SERVER['HTTP_REFERER']);
								}
						}
					
					
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function import_export($type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
				
			}else{
				$data['active']='Import/Export Tables';
				$data['module']='accounting';
				if($this->input->post('import')){
					$table_name=$this->input->post('table_name');
					if($table_name == 'Suppliers'){
						if(isset($_FILES['file']['name'])){
							$filename = $_FILES['file']['name'];
							$extension=explode('.',$filename);
							$extension=array_reverse($extension)[0];
							if(isset($extension) && ($extension == 'xlsx' || $extension == 'Xlsx' || 'csv')){
								$excel = time().'_'.$filename;
								$path = 'assets/uploads/'.$excel;
								if(file_exists($path)){
									unlink($path);
								}
								if(move_uploaded_file($_FILES['file']['tmp_name'], $path) === false){
									unset($excel);
								}
								$file_name=$excel;
							}else{
								$this->session->set_flashdata('error','You can only import file with extension xlsx or csv');
								redirect($_SERVER['HTTP_REFERER']);
							}
							$this->import_suppliers($file_name,$extension);
						}
					}else if($table_name == 'Customers'){
						if(isset($_FILES['file']['name'])){
							$filename = $_FILES['file']['name'];
							$extension=explode('.',$filename);
							$extension=array_reverse($extension)[0];
							if(isset($extension) && ($extension == 'xlsx' || $extension == 'Xlsx' || 'csv')){
								$excel = time().'_'.$filename;
								$path = 'assets/uploads/'.$excel;
								if(file_exists($path)){
									unlink($path);
								}
								if(move_uploaded_file($_FILES['file']['tmp_name'], $path) === false){
									unset($excel);
								}
								$file_name=$excel;
							}else{
								$this->session->set_flashdata('error','You can only import file with extension xlsx or csv');
								redirect($_SERVER['HTTP_REFERER']);
							}
							$this->import_cutomers($file_name,$extension);
						}
					}else if($table_name == 'Products'){
						if(isset($_FILES['file']['name'])){
							$filename = $_FILES['file']['name'];
							$extension=explode('.',$filename);
							$extension=array_reverse($extension)[0];
							if(isset($extension) && ($extension == 'xlsx' || $extension == 'Xlsx' || 'csv')){
								$excel = time().'_'.$filename;
								$path = 'assets/uploads/'.$excel;
								if(file_exists($path)){
									unlink($path);
								}
								if(move_uploaded_file($_FILES['file']['tmp_name'], $path) === false){
									unset($excel);
								}
								$file_name=$excel;
							}else{
								$this->session->set_flashdata('error','You can only import file with extension xlsx or csv');
								redirect($_SERVER['HTTP_REFERER']);
							}
							$this->import_products($file_name,$extension);
						}
					}
				}
				if($this->input->post('export')){
					$table_name=$this->input->post('table_name');
					if($table_name == 'Suppliers'){
						$this->export_suppliers();
					}else if($table_name == 'Customers'){
						$this->export_cutomers();
					}else if($table_name == 'Products'){
						$this->export_products();
					}
				}
				$this->displayView('accounting/settings/import_export',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{	
			redirect('auth');
		}
	}
	public function export_suppliers(){
		$data = $this->common_model->getAll('tbl_suppliers',array('company_id'=>$this->company_id));
		$this->load->library('phpspreadsheet');
        $columnName=array('Supplier Code','Supplier Name','Email','Mailing Name','Phone Number','Mobile Number','Opening Balance','Address','Narration','Creation Date');
        $excel=$this->phpspreadsheet->getInstance();
        $sizeofArray=sizeof($columnName);
        $letters=range('A','Z');
        $i=0;
        foreach($letters as $key => $value){
       		$number='1';
       		if($key < $sizeofArray){
				$excel->getColumnDimension($value)->setAutoSize(true);
	       		$this->phpspreadsheet->setCellValue($value.''.$number,$columnName[$key]);
	            $this->phpspreadsheet->textAlign($value.''.$number);
       		}
        }
        if(!empty($data)){
         $row=2;
        foreach($data as $key => $value){
                $this->phpspreadsheet->setCellValue('A'.$row  , $value->supplierCode);
                $this->phpspreadsheet->setCellValue('B'.$row  , $value->supplierName);    
                $this->phpspreadsheet->setCellValue('C'.$row  , $value->email);
                $this->phpspreadsheet->setCellValue('D'.$row  , $value->mailingName);
                $this->phpspreadsheet->setCellValue('E'.$row  , $value->phone);
                $this->phpspreadsheet->setCellValue('F'.$row  , $value->mobile);
                $this->phpspreadsheet->setCellValue('G'.$row  , $value->opening_balance);
                $this->phpspreadsheet->setCellValue('H'.$row  , $value->address);
                $this->phpspreadsheet->setCellValue('I'.$row  , $value->narration);
                $this->phpspreadsheet->setCellValue('J'.$row  , date('M d Y',strtotime($value->created_on)));
                $row++;
            } 
        }
        $this->phpspreadsheet->default_style();
        $path=FCPATH."suppliers.xlsx";
        $this->phpspreadsheet->saveFileXml($path);
        unlink($path);
	}
	public function export_cutomers(){
		$data = $this->common_model->getAll('tbl_mcustomers',array('company_id'=>$this->company_id));
		$this->load->library('phpspreadsheet');
        $columnName=array('Customer Code','Customer Name','Email','Mailing Name','Phone Number','Mobile Number','Opening Balance','Address','Narration','Creation Date');
        $excel=$this->phpspreadsheet->getInstance();
        $sizeofArray=sizeof($columnName);
        $letters=range('A','Z');
        $i=0;
        foreach($letters as $key => $value){
       		$number='1';
       		if($key < $sizeofArray){
				$excel->getColumnDimension($value)->setAutoSize(true);
	       		$this->phpspreadsheet->setCellValue($value.''.$number,$columnName[$key]);
	            $this->phpspreadsheet->textAlign($value.''.$number);
       		}
        }
        if(!empty($data)){
         $row=2;
        foreach($data as $key => $value){
                $this->phpspreadsheet->setCellValue('A'.$row  , $value->customerCode);
                $this->phpspreadsheet->setCellValue('B'.$row  , $value->customerName);    
                $this->phpspreadsheet->setCellValue('C'.$row  , $value->email);
                $this->phpspreadsheet->setCellValue('D'.$row  , $value->mailingName);
                $this->phpspreadsheet->setCellValue('E'.$row  , $value->phone);
                $this->phpspreadsheet->setCellValue('F'.$row  , $value->mobile);
                $this->phpspreadsheet->setCellValue('G'.$row  , $value->opening_balance);
                $this->phpspreadsheet->setCellValue('H'.$row  , $value->address);
                $this->phpspreadsheet->setCellValue('I'.$row  , $value->narration);
                $this->phpspreadsheet->setCellValue('J'.$row  , date('M d Y',strtotime($value->created_on)));
                $row++;
            } 
        }
        $this->phpspreadsheet->default_style();
        $path=FCPATH."customers.xlsx";
        $this->phpspreadsheet->saveFileXml($path);
        unlink($path);
	}
	public function export_products(){
		$data = $this->common_model->getAll('tbl_product',array('company_id'=>$this->company_id));
		foreach($data as $key => &$value) {
			if(isset($value->groupId)){
				$group_data=$this->common_model->getById('tbl_productgroup',array('id'=>$value->groupId));
				$value->group_name=isset($group_data->groupName) ? $group_data->groupName :'';
			}
			if(isset($value->brandId)){
				$brand_data=$this->common_model->getById('tbl_brand',array('id'=>$value->brandId));
				$value->brand_name=isset($brand_data->brandName) ? $brand_data->brandName :'';
			}
		}
		$this->load->library('phpspreadsheet');
        $columnName=array('Product Code','Barcode','Product Name','Group Name','Brand Name','Reorder Level');
        $excel=$this->phpspreadsheet->getInstance();
        $sizeofArray=sizeof($columnName);
        $letters=range('A','Z');
        $i=0;
        foreach($letters as $key => $value){
       		$number='1';
       		if($key < $sizeofArray){
				$excel->getColumnDimension($value)->setAutoSize(true);
	       		$this->phpspreadsheet->setCellValue($value.''.$number,$columnName[$key]);
	            $this->phpspreadsheet->textAlign($value.''.$number);
       		}
        }
        if(!empty($data)){
		 $row=2;
        foreach($data as $key => $value){
                $this->phpspreadsheet->setCellValue('A'.$row  , $value->productCode);
                $this->phpspreadsheet->setCellValue('B'.$row  , $value->barcode);
                $this->phpspreadsheet->setCellValue('C'.$row  , $value->productName);    
                $this->phpspreadsheet->setCellValue('D'.$row  , $value->group_name);
                $this->phpspreadsheet->setCellValue('E'.$row  , $value->brand_name);
                $this->phpspreadsheet->setCellValue('F'.$row  , $value->reorder_level);
                $row++;
            } 
        }
        $this->phpspreadsheet->default_style();
        $path=FCPATH."products.xlsx";
        $this->phpspreadsheet->saveFileXml($path);
        unlink($path);
	}
	public function import_suppliers($file=null,$extension=null){
		if($file!=null && $extension!=null){
			$file = FCPATH.'assets/uploads/'.$file;
			$this->load->library('phpspreadsheet');
			$data=$this->phpspreadsheet->readExcel($file,$extension);
			$worksheet = $data->getActiveSheet();
			$rows = [];
			$index = 0;
			foreach ($worksheet->getRowIterator() AS $row) {
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
				$cells = [];
				foreach ($cellIterator as $cell) {
					$cells[] = $cell->getValue();
				}
				$rows[] = $cells;
			}
			unset($rows[0]);
			$file_data=[];
			$supplier_fields = array('supplierCode','supplierName','Email','mailingName','phone','mobile','opening_balance','address','narration');
			$sizeofArray=count($supplier_fields);
			$saved=0;
			$saved1=0;
			foreach($rows as $key => $values){
				$flag = false;
				foreach ($values as $key1 => $value) {
					if($key1 < $sizeofArray){
						if($key1 == 2 && isset($value)){
							$checkEmail=$this->settings_model->getOne('tbl_suppliers',array('email'=>$value));
							if(!empty($checkEmail)){
								$flag = true;
								break;
							}
						}
						$file_data[$supplier_fields[$key1]]=isset($value) ? $value:'';
					}
				}
				if($flag)
					continue;
				$file_data['company_id']=$this->company_id;
				$saved=$this->settings_model->add('tbl_suppliers',$file_data);
				$account_ledger['accountGroupId']=22;
				$account_ledger['supplier_id'] = $saved;
				$account_ledger['openingBalance']=$file_data['opening_balance'];
				$account_ledger['ledgerName']=$file_data['supplierName'];
				$account_ledger['editable'] = 0;
				$account_ledger['company_id']=$file_data['company_id'];
				$saved1=$this->settings_model->add('tbl_accountledger',$account_ledger);
			}
			if($saved > 0 && $saved1 > 0){
				$this->session->set_flashdata('success','Suppliers added successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Email Already Exist');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}
	public function import_cutomers($file=null,$extension=null){
		if($file!=null && $extension!=null){
			$file = FCPATH.'assets/uploads/'.$file;
			$this->load->library('phpspreadsheet');
			$data=$this->phpspreadsheet->readExcel($file,$extension);
			$worksheet = $data->getActiveSheet();
			$rows = [];
			$index = 0;
			foreach ($worksheet->getRowIterator() AS $row) {
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
				$cells = [];
				foreach ($cellIterator as $cell) {
					$cells[] = $cell->getValue();
				}
				$rows[] = $cells;
			}
			unset($rows[0]);
			$file_data=[];
			$fields = array('customerCode','customerName','Email','mailingName','phone','mobile','opening_balance','address','narration');
			$sizeofArray=count($fields);
			$saved=0;
			$saved1=0;
			foreach($rows as $key => $values){
				$flag = false;
				foreach ($values as $key1 => $value) {
					if($key1 < $sizeofArray){
						if($key1 == 2 && isset($value)){
							$checkEmail=$this->settings_model->getOne('tbl_mcustomers',array('email'=>$value));
							if(!empty($checkEmail)){
								$flag = true;
								break;
							}
						}
						$file_data[$fields[$key1]]=isset($value) ? $value:'';
					}
				}
				if($flag)
					continue;
				$file_data['company_id']=$this->company_id;
				$saved=$this->settings_model->add('tbl_mcustomers',$file_data);
				$account_ledger['accountGroupId']=26;
				$account_ledger['customer_id'] = $saved;
				$account_ledger['openingBalance']=$file_data['opening_balance'];
				$account_ledger['ledgerName']=$file_data['customerName'];
				$account_ledger['editable'] = 0;
				$account_ledger['company_id']=$file_data['company_id'];
				$saved1=$this->settings_model->add('tbl_accountledger',$account_ledger);
			}
			if($saved > 0 && $saved1 > 0){
				$this->session->set_flashdata('success','Customers added successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Email Already Exist');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}
	public function import_products($file=null,$extension=null){
		if($file!=null && $extension!=null){
			$file = FCPATH.'assets/uploads/'.$file;
			$this->load->library('phpspreadsheet');
			$data=$this->phpspreadsheet->readExcel($file,$extension);
			$worksheet = $data->getActiveSheet();
			$rows = [];
			$index = 0;
			foreach ($worksheet->getRowIterator() AS $row) {
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
				$cells = [];
				foreach ($cellIterator as $cell) {
					$cells[] = $cell->getValue();
				}
				$rows[] = $cells;
			}
			unset($rows[0]);
			$file_data=[];
			$fields = array('productCode','barcode','productName','groupId','brandId','reorder_level');
			$sizeofArray=count($fields);
			foreach($rows as $key => $values){
				foreach ($values as $key1 => $value) {
					if($key1 < $sizeofArray){
						$group_id='';
						$brand_id='';
						if($key1 == 3 && isset($value)){
							$value=strtolower($value);
							$check_group=$this->settings_model->getOne('tbl_productgroup',array('groupName'=>$value));
							if(empty($check_group)){
								$saved=$this->settings_model->add('tbl_productgroup',array('company_id'=>$this->company_id,'groupName'=>$value));
								$group_id=$saved;
							}else{
								$group_id=isset($check_group->id) ? $check_group->id :'';
							}
							$value=isset($group_id) ? $group_id :'';
						}
						if($key1 == 4 && isset($value)){
							$value=strtolower($value);
							$check_brand=$this->settings_model->getOne('tbl_brand',array('brandName'=>$value));
							if(empty($check_brand)){
								$saved=$this->settings_model->add('tbl_brand',array('company_id'=>$this->company_id,'brandName'=>$value));
								$brand_id=$saved;
							}else{
								$brand_id=isset($check_brand->id) ? $check_brand->id :'';
							}
							$value=isset($brand_id) ? $brand_id :'';
						}
						$file_data[$fields[$key1]]=isset($value) ? $value:'';
					}
				}
				$file_data['company_id']=$this->company_id;
				$saved=$this->settings_model->add('tbl_product',$file_data);
			}
			if($saved){
				$this->session->set_flashdata('success','Product added successfully');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error','Error occurrred try later!');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}
}