<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Product Image 'src' helper
 *
 * Helper to get the link to the product raw image or the crunched thumbs
 * images
 *
 * @package		CodeIgniter
 * @subpackage	Custom Helpers
 * @category	Product Links
 * @author		WebGuy
 * @link		
 */
 
// ------------------------------------------------------------------------

/**
 * SRC Link URL
 *
 * @access	public
 * @param	string
 * @return	url string
 */
	if ( ! function_exists('src_link'))
	{
		function src_link($prod_no = '')
		{
			if ( ! $prod_no)
			{
				// nothing more to do...
				return FALSE;
			}
			
			// set instances
			$CI =& get_instance();
			$DB = $CI->load->database('instyle', TRUE);
			
			// let's get necessary fields
			$DB->select('
				(CASE 
					WHEN categories.category_slug = "apparel" THEN "WMANSAPREL"
					ELSE categories.category_slug 
				END) AS cat_folder
			');
			$DB->select('
				(CASE 
					WHEN designer.url_structure = "basix-black-label" THEN "basixblacklabel"
					ELSE designer.url_structure
				END) AS d_folder
			');
			$DB->select('
				(CASE 
					WHEN c2.category_slug = "cocktail-dresses" THEN "cocktail"
					WHEN c2.category_slug = "evening-dresses" THEN "evening"
					ELSE c2.category_slug 
				END) AS subcat_folder
			');
			$DB->where('tbl_product.prod_no', $prod_no);
			$DB->join('designer', 'designer.des_id = tbl_product.designer', 'left');
			$DB->join('categories', 'categories.category_id = tbl_product.cat_id', 'left');
			$DB->join('categories AS c2', 'c2.category_id = tbl_product.subcat_id', 'left');
			
			// get records
			$query = $DB->get('tbl_product');
			
			//echo '<pre>'; echo $DB->last_query(); die();
			
			if ($query->num_rows() == 0)
			{
				// since there is no record, return false...
				return FALSE;
			}
			else
			{
				$row = $query->row();
				
				// nothing to do...
				return $CI->config->item('PROD_IMG_URL').'product_assets/'.$row->cat_folder.'/'.$row->d_folder.'/'.$row->subcat_folder.'/product_front/';
			}
		}
	}

// ------------------------------------------------------------------------

/**
 * SRC to crunched thumbs
 *
 * @access	public
 * @param	string
 * @return	url string
 */
	if ( ! function_exists('src_to_thumbs'))
	{
		function src_to_thumbs($style_no = '', $size = '3')
		{
			if ( ! $style_no)
			{
				// nothing more to do...
				return FALSE;
			}
			
			$exp = explode('_', $style_no);
			$prod_no = $exp[0];
			$color_code = $exp[1];
			
			return src_link($prod_no).'thumbs/'.$style_no.'_'.$size.'.jpg';
		}
	}

// ------------------------------------------------------------------------

/**
 * SRC to crunched thumbs
 *
 * @access	public
 * @param	string
 * @return	url string
 */
	if ( ! function_exists('src_to_raw_image'))
	{
		function src_to_raw_image($style_no = '')
		{
			if ( ! $style_no)
			{
				// nothing more to do...
				return FALSE;
			}
			
			$exp = explode('_', $style_no);
			$prod_no = $exp[0];
			$color_code = $exp[1];
			
			return src_link($prod_no).$style_no.'.jpg';
		}
	}

// ------------------------------------------------------------------------

/**
 * Link to Product Details Page
 *
 * @access	public
 * @param	string
 * @return	url string
 */
	if ( ! function_exists('link_to_product_details'))
	{
		function link_to_product_details($params = '')
		{
			if ($params == '')
			{
				// nothing more to do...
				return FALSE;
			}
			
			$exp = explode('_', $params);
			$prod_no = $exp[0];
			$color_code = (isset($exp[1]) && ! empty($exp[1])) ? $exp[1] : '';
			
			// set instances
			$CI =& get_instance();
			$DB = $CI->load->database('instyle', TRUE);
			
			// let's get necessary fields
			$DB->select('tbl_product.prod_no');
			$DB->select('tbl_product.prod_name');
			$DB->select('tblcolor.color_name');
			$DB->select('
				(CASE 
					WHEN designer.url_structure = "basix-black-label" THEN "basixblacklabel"
					ELSE designer.url_structure
				END) AS d_url_struture
			');
			$DB->where('tbl_product.prod_no', $prod_no);
			if ($color_code != '') $DB->where('tblcolor.color_code', $color_code);
			$DB->join('designer', 'designer.des_id = tbl_product.designer', 'left');
			$DB->join('categories', 'categories.category_id = tbl_product.cat_id', 'left');
			$DB->join('categories AS c2', 'c2.category_id = tbl_product.subcat_id', 'left');
			$DB->join('tbl_stock', 'tbl_stock.prod_no = tbl_product.prod_no', 'left');
			if ($color_code != '')
			{
				$DB->join('tblcolor', 'tblcolor.color_name = tbl_stock.color_name', 'left');
			}
			else
			{
				$DB->join('tblcolor', 'tblcolor.color_code = tbl_product.primary_img_id', 'left');
			}
			
			// get records
			$query = $DB->get('tbl_product');
			
			//echo '<pre>'; echo $DB->last_query(); die();
			
			if ($query->num_rows() == 0)
			{
				// since there is no record, return false...
				return FALSE;
			}
			else
			{
				$row = $query->row();
				
				// nothing to do...
				return $row->d_url_struture.'/'.$row->prod_no.'/'.str_replace(' ','-',strtolower(trim($row->color_name))).'/'.str_replace(' ','-',strtolower(trim($row->prod_name)));
			}
		}
	}


/* End of file Sate_country_helper.php */
/* Location: ./application/helpers/Sate_country_helper.php */