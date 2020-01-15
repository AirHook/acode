<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_available_colors extends Sales_user_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index($prod_no = '', $color_code = '')
	{
		if ($prod_no == '')
		{
			die(header("HTTP/1.0 404 Not Found")); //Throw an error on failure
		}

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');

		// intialize class
		$params =
			$color_code != ''
			? array('tbl_product.prod_no'=>$prod_no, 'color_code'=>$color_code)
			: array('tbl_product.prod_no'=>$prod_no)
		;
		$this->product_details->initialize($params);

		// get available colors in array
		$colors = $this->product_details->available_colors();

		if ($colors)
		{
			$available_colors = '<label>Color</label><select class="bs-select form-control color_code" name="color_code[]" data-live-search="true" data-size="8">';

			if (count($colors) > 1)
			{
				$available_colors.= '<option value="" data-content="<em>Select...</em>"></option>';
			}

			foreach ($colors as $color)
			{
				$available_colors.= '<option value="'.$color->color_code.'" data-color_name="'.$color->color_name.'" data-subtext="<em class=\'small\'>'.$color->color_code.'</em>">'.$color->color_name.'</option>';
			}

			$available_colors.= '</select>';
		}
		else $available_colors = '';

		echo $available_colors;
		exit;
	}

	// ----------------------------------------------------------------------

}
