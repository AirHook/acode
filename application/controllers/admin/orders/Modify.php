<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modify extends Admin_Controller {

	/**
	 * DB Object
	 *
	 * @var	object
	 */
	protected $DB;

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);

		// load pertinent library/model/helpers
		$this->load->model('shipping_methods');
		$this->load->helper('state_country_helper');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('products/product_details');
		$this->load->library('orders/order_details');
		$this->load->library('products/size_names');
		$this->load->library('barcodes/upc_barcodes');
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply shows order details
	 *
	 * @return	void
	 */
	public function index($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/orders', 'location');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// get order details
		$this->data['order_details'] =
			$this->order_details->initialize(
				array(
					'tbl_order_log.order_log_id'=>$order_id
				)
			)
		;

		// based on order details, get user details
		if ($this->data['order_details']->c == 'ws')
		{
			$this->data['user_details'] =
				$this->wholesale_user_details->initialize(
					array(
						'user_id' => $this->data['order_details']->user_id
					)
				)
			;
		}
		else
		{
			$this->data['user_details'] =
				$this->consumer_user_details->initialize(
					array(
						'user_id' => $this->data['order_details']->user_id
					)
				)
			;
		}

		unset($_SESSION['Modify-Order']);

		// other data
		$this->data['status'] = $this->order_details->status_text;

		// set data variables...
		$this->data['role'] = 'admin';
		$this->data['file'] = 'orders_modify';
		$this->data['page_title'] = 'Modify Order';
		$this->data['page_description'] = 'Edit order details';

		// load views...
		$this->load->view('admin/metronic/template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * PUBLIC - Update all orders info in session _noel(20210619)
	 *
	 * @return	void
	 */
	public function update_order($order_id = '')
	{
			if ( ! $order_id)
			{
				// nothing more to do...
				// set flash data
				$this->session->set_flashdata('error', 'no_id_passed');

				// redirect user
				redirect('admin/orders/modify/index/'.$order_id, 'location');
			}

			if (isset($_SESSION['Modify-Order']['User_Details'])) {
				// grab session data
				$post_ary = array_filter($_SESSION['Modify-Order']['User_Details'], 'strlen');
				$user_id = $post_ary['user_id'];
				// unset items
				unset($post_ary['user_id']);

				// update records
				$this->DB->set($post_ary);
				$this->DB->where('user_id', $user_id);
				$this->DB->update('tbluser_data');
			}

			if (isset($_SESSION['Modify-Order']['Store_Details'])) {
				// grab session data
				$post_ary = array_filter($_SESSION['Modify-Order']['Store_Details'], 'strlen');
				$user_id = $post_ary['user_id'];
				// unset items
				unset($post_ary['user_id']);

				// update records
				$this->DB->set($post_ary);
				$this->DB->where('user_id', $user_id);
				$this->DB->update('tbluser_data_wholesale');
			}

			if (isset($_SESSION['Modify-Order']['Ship_To'])) {
				// grab session data
				$post_ary = array_filter($_SESSION['Modify-Order']['Ship_To'], 'strlen');

				// update records
				$this->DB->set($post_ary);
				$this->DB->where('order_log_id', $order_id);
				$this->DB->update('tbl_order_log');

				// get order details
				$this->data['order_details'] =
					$this->order_details->initialize(
						array(
							'tbl_order_log.order_log_id'=>$order_id
						)
					)
				;

				// based on order details, get user details
				if ($this->data['order_details']->c == 'ws')
				{
					$this->data['user_details'] =
						$this->wholesale_user_details->initialize(
							array(
								'user_id' => $this->data['order_details']->user_id
							)
						)
					;
				}
				else
				{
					$this->data['user_details'] =
						$this->consumer_user_details->initialize(
							array(
								'user_id' => $this->data['order_details']->user_id
							)
						)
					;
				}

				$addresses = $this->data['user_details']->alt_address;

				//look for if record exists - _noel(20210526)
				$address_exists = false;
				for ($i = 2; $i < count($addresses); $i++)
				{
					if (($addresses[$i]['address1']==$this->data['order_details']->ship_address1) &&
							($addresses[$i]['address2']==$this->data['order_details']->ship_address2) &&
								($addresses[$i]['city']==$this->data['order_details']->ship_city) &&
									($addresses[$i]['state']==$this->data['order_details']->ship_state) &&
										($addresses[$i]['country']==$this->data['order_details']->ship_country) &&
											($addresses[$i]['zipcode']==$this->data['order_details']->ship_zipcode))
					{
						$addresses[$i]['firstname'] = $this->data['order_details']->firstname;
						$addresses[$i]['lastname'] = $this->data['order_details']->lastname;
						$addresses[$i]['store_name'] = $this->data['order_details']->store_name;
						$addresses[$i]['telephone'] = $this->data['order_details']->telephone;
						$addresses[$i]['address1'] = $this->data['order_details']->ship_address1;
						$addresses[$i]['address2'] = $this->data['order_details']->ship_address2;
						$addresses[$i]['city'] = $this->data['order_details']->ship_city;
						$addresses[$i]['state'] = $this->data['order_details']->ship_state;
						$addresses[$i]['country'] = $this->data['order_details']->ship_country;
						$addresses[$i]['zipcode'] = $this->data['order_details']->ship_zipcode;
						$address_exists = true;
						break;
					}
				}

				//look for available slot - _noel(20210526)
				if ($address_exists==false)
				{
					$slot_found=false;
					$i=2;
					do
					{
						if (($addresses[$i]['address1']=="") &&
								($addresses[$i]['address2']=="") &&
									($addresses[$i]['city']=="") &&
										($addresses[$i]['state']=="") &&
											($addresses[$i]['country']=="") &&
												($addresses[$i]['zipcode']==""))
						{
							$addresses[$i]['firstname'] = $this->data['order_details']->firstname;
							$addresses[$i]['lastname'] = $this->data['order_details']->lastname;
							$addresses[$i]['store_name'] = $this->data['order_details']->store_name;
							$addresses[$i]['telephone'] = $this->data['order_details']->telephone;
							$addresses[$i]['address1'] = $this->data['order_details']->ship_address1;
							$addresses[$i]['address2'] = $this->data['order_details']->ship_address2;
							$addresses[$i]['city'] = $this->data['order_details']->ship_city;
							$addresses[$i]['state'] = $this->data['order_details']->ship_state;
							$addresses[$i]['country'] = $this->data['order_details']->ship_country;
							$addresses[$i]['zipcode'] = $this->data['order_details']->ship_zipcode;
							$slot_found=true;
						}
						$i++;
					} while ($slot_found==false);
				}
				//update also tbluser_data_wholesale for alt_address - _noel(20210526)
				$this->DB->set('alt_address',json_encode($addresses));
				$this->DB->where('user_id',  $this->data['order_details']->user_id);
				$this->DB->update('tbluser_data_wholesale');
			}

			if (isset($_SESSION['Modify-Order']['Remarks'])) {
				// grab session data
				$post_ary = array_filter($_SESSION['Modify-Order']['Remarks'], 'strlen');

				// update records
				$this->DB->set('remarks', $post_ary['remarks']);
				$this->DB->where('order_log_id', $order_id);
				$this->DB->update('tbl_order_log');
			}

			if (isset($_SESSION['Modify-Order']['Discount'])) {
				// grab session data
				$post_ary = array_filter($_SESSION['Modify-Order']['Discount'], 'strlen');

				// get order details
				$order_details =
					$this->order_details->initialize(
						array(
							'tbl_order_log.order_log_id'=>$order_id
						)
					)
				;

				// get order options
				$options = $order_details->options;

				// add/edit/remove options for discount
				if ($post_ary['discount'] === '0')
				{
					unset($options['discount']);
				}
				else
				{
					$options['discount'] = $post_ary['discount'];
				}

				// update records
				$this->DB->set('options', json_encode($options));
				$this->DB->where('order_log_id', $order_id);
				$this->DB->update('tbl_order_log');
			}

			if (isset($_SESSION['Modify-Order']['Shipping_Fee'])) {
				// grab session data
				$post_ary = array_filter($_SESSION['Modify-Order']['Shipping_Fee'], 'strlen');

				// update records
				$this->DB->set('shipping_fee', $post_ary['shipping_fee']);
				$this->DB->where('order_log_id', $order_id);
				$this->DB->update('tbl_order_log');
			}

			if (isset($_SESSION['Modify-Order']['Quantity'])) {
				// grab session data
				$post_ary = array_filter($_SESSION['Modify-Order']['Quantity'], 'strlen');

				// update records
				foreach ($post_ary as $order_log_detail_id => $qty) {
					$this->DB->set('qty', $qty);
					$this->DB->where('order_log_detail_id', $order_log_detail_id);
					$this->DB->update('tbl_order_log_details');
				}
			}

			if (isset($_SESSION['Modify-Order']['Price'])) {
				// grab session data
				$post_ary = array_filter($_SESSION['Modify-Order']['Price'], 'strlen');

				// update records
				foreach ($post_ary as $order_log_detail_id => $price) {
					$this->DB->set('unit_price', $price);
					$this->DB->where('order_log_detail_id', $order_log_detail_id);
					$this->DB->update('tbl_order_log_details');
				}
			}

			if (isset($_SESSION['Modify-Order']['Remove'])) {
				// grab session data
				$post_ary = array_filter($_SESSION['Modify-Order']['Remove'], 'strlen');

				// update records
				foreach ($post_ary as $order_log_detail_id => $value) {
					//Update stocks
					$this->DB->select('tbl_order_log_details.*');
					$this->DB->where('order_log_detail_id', $order_log_detail_id);
					$query = $this->DB->get('tbl_order_log_details');
					$item = $query->row();
					if (isset($item)) {
						$item_options = json_decode($item->options, TRUE);
						$this->load->library('inventory/update_stocks');
						$config['prod_sku'] = $item->prod_sku;
						$config['size'] = $item->size;
						$config['qty'] = $item->qty;
						$config['order_id'] = $order_id;
						if (array_key_exists('admin_stocks_only',$item_options))
						 	$config['admin_stocks'] = $item_options['admin_stocks_only'];						
						$this->update_stocks->initialize($config);
						$this->update_stocks->return();
					}

					$this->DB->where('order_log_detail_id', $order_log_detail_id);
					$this->DB->delete('tbl_order_log_details');
				}
			}

			// set revision # added by _noel(20210521)
			$rev = @$this->input->post('revision') ? $this->input->post('revision') : 0;
			$this->DB->set('rev', $rev + 1);
			$this->DB->set('last_modified', time());
			$this->DB->where('order_log_id', $order_id);
			$this->DB->update('tbl_order_log');

			// set flash data
			$this->session->set_flashdata('success', 'edit');

			// return to modify order page
			redirect('admin/orders/modify/index/'.$order_id, 'location');
	}

	/**
	 * PRIVATE - Create Plugin Scripts and CSS for the page
	 *
	 * @return	void
	 */
	private function _create_plugin_scripts()
	{
		$assets_url = base_url('assets/metronic');

		/****************
		 * page styles plugins inserted at <head>
		 * after global mandatory styles, before theme global styles
		 */
		$this->data['page_level_styles_plugins'] = '';

			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
			';
			// summernote wysiwyg
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '
		';

		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';

			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// summernote wysiwyg
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
			';
			// form validation
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
		 */
		$this->data['page_level_scripts'] = '';

			// handle bootstrap select - make select class '.bs-select' a boostrap select picker
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// handle datatable
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/admin-orders-modify.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
