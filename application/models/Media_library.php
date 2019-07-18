<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media_library extends CI_Model {

	/**
	 * DB Object
	 *
	 * @return	object
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

		// connect to database for use by model
		$this->DB = $this->load->database('instyle', TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Get Products Media Library
	 *
	 * @return	object/boolean false
	 */
	function get_media($param = 'media_library_products')
	{
		if ( ! $param)
		{
			// nothing more to do...
			return FALSE;
		}

		$this->DB->select($param.'.*');
		$this->DB->select('tbl_product.prod_id');
		$this->DB->join('tbl_stock', 'tbl_stock.image_url_path = '.$param.'.media_id', 'left');
		$this->DB->join('tbl_product', 'tbl_product.prod_no = tbl_stock.prod_no', 'left');
		$this->DB->order_by('timestamp', 'DESC');
		$q1 = $this->DB->get($param);

		if ($q1->num_rows() > 0)
		{
			return $q1->result();
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Products Media Library
	 *
	 * @return	object/boolean false
	 */
	function get_media_details($params = array())
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}

		$this->DB->where($params);
		$q1 = $this->DB->get('media_library_products');

		if ($q1->num_rows() > 0)
		{
			return $q1->row();
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Insert Product to Media Library
	 *
	 * @return	object/boolean false
	 */
	function insert_products(array $data)
	{
		if (empty($data))
		{
			// nothing more to do...
			return FALSE;
		}

		$q1 = $this->DB->insert('media_library_products', $data);

		return $this->DB->insert_id();
	}

	// --------------------------------------------------------------------

	/**
	 * Insert Product to Media Library
	 *
	 * @return	object/boolean false
	 */
	function udpate_media_details(array $data, $media_id)
	{
		if (empty($data) OR ! $media_id)
		{
			// nothing more to do...
			return FALSE;
		}

		$this->DB->where('media_id', $media_id);
		$q1 = $this->DB->update('media_library_products', $data);

		return;
	}

	// --------------------------------------------------------------------

	/**
	 * Insert Product to Media Library
	 *
	 * @return	object/boolean false
	 */
	function update_attached_to($prod_id, $media_id)
	{
		if ($prod_id == '' OR $media_id == '')
		{
			// nothing more to do...
			return FALSE;
		}

		$this->DB->set('attached_to', $prod_id);
		$this->DB->where('media_id', $media_id);
		$q1 = $this->DB->update('media_library_products');

		return $q1;
	}

	// --------------------------------------------------------------------

	/**
	 * Insert Product to Media Library
	 *
	 * @return	object/boolean false
	 */
	function remove_attached_to($prod_id, $media_id)
	{
		if ($prod_id == '' OR $media_id == '')
		{
			// nothing more to do...
			return FALSE;
		}

		$this->DB->set('attached_to', '');
		$this->DB->where('media_id', $media_id);
		$q1 = $this->DB->update('media_library_products');

		return $q1;
	}

	// --------------------------------------------------------------------

	/**
	 * Insert Product to Media Library
	 *
	 * @return	object/boolean false
	 */
	function remove_and_update_attached_to($prod_id, $media_id, $media_name)
	{
		if ($prod_id == '' OR $media_id == '' OR $media_name == '')
		{
			// nothing more to do...
			return FALSE;
		}

		$this->DB->set('attached_to', '');
		$this->DB->where('attached_to', $prod_id);
		$this->DB->where('media_name', $media_name);
		$q1 = $this->DB->update('media_library_products');

		if ($q1)
		{
			$this->update_attached_to($prod_id, $media_id);

			return $q1;
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

}
