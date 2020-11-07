<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Create Google Image Helper
 *
 * @package		CodeIgniter
 * @subpackage	Custom Helpers
 * @category	Images, Linesheet
 * @author		WebGuy
 * @link
 */

// ------------------------------------------------------------------------

/**
 * Create Google Image
 *
 * Create Google Image for use as link to Google Merchant Center
 *
 * Parameters:
 *			$img_info -> @GetImageSize of the image in concner
 *			$prod_no -> product number
 *			$img_path -> relative path to image
 *						 'product_assets/'.$prod['c_folder'].'/'.$prod['d_folder'].'/'.$prod['sc_folder'].'/';
 *			$img_name -> filename portion of the image file
 *			$des_logo -> respective designer logo (with relative path) - MUST be PNG
 *
 * @access	public
 * @param	strings
 * @return	boolean
 */
	if ( ! function_exists('create_google_images'))
	{
		function create_google_images(
			$img_info = '',
            $src_image = '',
            $new_image = ''
		)
		{
			if (
				! $img_info
                OR ! $src_image
                OR ! $new_image
			)
			{
				// nothing more to help with...
				return FALSE;
			}

			$CI =& get_instance();
			$CI->load->library('image_lib');

			$w = $img_info[0];
			$h = $img_info[1];
			
			$config['image_library']	= 'gd2';
			$config['quality']			= '100%';
			$config['source_image'] 	= $src_image;
			$config['new_image'] 		= $new_image;
			$config['maintain_ratio'] 	= TRUE;
			$config['width']         	= $w;
			$config['height']       	= $h;
			$CI->image_lib->initialize($config);
			if ( ! $CI->image_lib->resize())
			{
				// catch errors
				$error_message = 'An error occurred resampling image.';

				// nothing more to do...
				return FALSE;
			}
			$CI->image_lib->clear();

			return TRUE;
		}
	}

// ------------------------------------------------------------------------

/* End of file Create_google_image_helper.php */
/* Location: ./application/helpers/Create_google_image_helper.php */
