<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 *
 *
 */
class split_order extends Admin_Controller
{
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
	function __Construct()
	{
		parent::__Construct();

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Primary method - index
	 *
	 * @return	void
	 */
	function index($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/orders', 'location');
		}

		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('products/product_details');
		$this->load->library('orders/order_details');

		// get order details
		$this->data['order_details'] =
			$this->order_details->initialize(
				array(
					'tbl_order_log.order_log_id'=>$order_id
				)
			)
		;

		$totalItems = count($this->data['order_details']->order_items);
		//print_r($this->data['order_details']);die();
		if ($totalItems>1)
		{
			$max_order_no = $this->order_details->max_order_number();

			$log_data = array(
				'order_log_id'	=>	$max_order_no+1,
				'user_id'			=> $this->order_details->user_id,
				'c'					=> $this->order_details->c,
				'date_ordered'		=> date_format(date_create($this->order_details->date_ordered),'d, F Y - h:i'),
				'order_date'		=> strtotime($this->order_details->order_date),

				'courier'			=> $this->order_details->courier,
				'shipping_fee'		=> $this->order_details->shipping_fee,
				'amount'			=> $this->order_details->order_amount,

				'firstname'			=> $this->order_details->firstname,
				'lastname'			=> $this->order_details->lastname,
				'email'				=> $this->order_details->email,
				'telephone'			=> $this->order_details->telephone,
				'store_name'		=> $this->order_details->store_name,
				'remarks'		=> $this->order_details->remarks,
				'ship_address1'		=> $this->order_details->ship_address1,
				'ship_address2'		=> $this->order_details->ship_address2,
				'ship_country'		=> $this->order_details->ship_country,
				'ship_state'		=> $this->order_details->ship_state,
				'ship_city'			=> $this->order_details->ship_city,
				'ship_zipcode'		=> $this->order_details->ship_zipcode,
				'webspace_id'		=> $this->order_details->webspace_id,
				'agree_policy'		=> $this->order_details->agree_policy,
				'options'			=> json_encode(array('split_from'=>$order_id))
			);
			$this->DB->insert('tbl_order_log', $log_data);
			$new_order_id	= $this->DB->insert_id();

			$split_from = $this->order_details->options;
			array_push($split_from, array('split_from'=>$new_order_id));
			$this->DB->set('rev', $this->order_details->rev+1);
			$this->DB->set('options', json_encode($split_from));
			$this->DB->where('order_log_id', $order_id);
			$this->DB->update('tbl_order_log');
			
			//echo $this->data['order_details']->order_items[0]->order_log_detail_id;
			//die();

		$totalItems = count($this->data['order_details']->order_items);
		$i=1;
			foreach ($this->data['order_details']->order_items as $items)
			{
				$this->DB->set('order_log_id', $new_order_id);
				$this->DB->where('order_log_detail_id', $items->order_log_detail_id);
				$this->DB->update('tbl_order_log_details');
				$i=$i+1;
				if ($i>=$totalItems/2)
					break;
			}
		 }

		// set flash data
		$this->session->set_flashdata('success', 'order_split');

		// redirect user
		redirect('admin/orders/details/index/'.$order_id, 'location');
		//redirect($this->config->slash_item('admin_folder').'orders');
	}

	// --------------------------------------------------------------------

}
