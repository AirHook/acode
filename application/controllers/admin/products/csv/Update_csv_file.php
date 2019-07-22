<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_csv_file extends MY_Controller {

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
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function index()
	{
		// update csv file
		$this->csv();

		// set flash data
		$this->session->set_userdata('success', 'csv_update');
		$this->session->mark_as_flash('success');

		// return user
		redirect($this->session->flashdata('csv_uri_string'), 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function csv()
	{
		// load pertinent library/model/helpers
		$this->load->library('products/products_list_csv');
		$this->load->library('categories/categories_tree');
		$this->load->library('designers/designers_list');

		// get some data
		$designers = $this->designers_list->select();
		$categories = $this->categories_tree->treelist(array('with_products'=>TRUE));

		// this class is called within the product csv listing page
		// thus, we use the csv_uri_string to get designer and category reference
		// otherwise, we return to the same page with an error notice
		if ( ! $this->session->flashdata('csv_uri_string'))
		{
			// nothing more to do...
			$this->session->set_flashdata('error', 'no_id_passed');

			// return user
			redirect($this->config->slash_item('admin_folder').'products/csv', 'location');
		}

		// let's grab the uri segments for processiong
		$url_segs = explode('/', $this->session->flashdata('csv_uri_string'));

		// let's remove the following segments from the resulting array
		array_shift($url_segs); // admin
		array_shift($url_segs); // products
		array_shift($url_segs); // csv
		array_shift($url_segs); // index
		$active_designer = $url_segs[0];
		$active_category = $url_segs[count($url_segs) - 1];

		// some other defaults
		$size_mode = $this->webspace_details->get_size_mode(array('webspace_slug'=>$active_designer));

		// initiate categories via select
		$this->categories_tree->select(array('d_url_structure LIKE'=>'%'.$active_designer.'%'));

		// get csv data
		// get respective active category ID for use on product list where condition
		$category_id = $this->categories_tree->get_id($this->session->active_category);

		// set product list where condition
		if ($active_designer !== FALSE)
		{
			if ($category_id)
			{
				$where = array(
					'designer.url_structure' => $active_designer,
					'tbl_product.categories LIKE' => $category_id // last segment of category
				);
			}
			else $where = array('designer.url_structure' => $active_designer);
		}
		else $where = array('tbl_product.categories LIKE' => $category_id);

		// finally, get the product list...
		$products = $this->products_list_csv->select($where);
		$products_count = $this->products_list_csv->row_count;

		// set the filename for the csv file for downloading
		// using designer and categories as reference
		// get vital info for path purposes
		$path = './csv/products/';
		$filename = 'products_'.$active_designer.'_'.$active_category;
		$file = $path.$filename.'.csv';

		// craete directory where necessary
		if ( ! file_exists($path))
		{
			$old = umask(0);
			if ( ! mkdir($path, 0777, TRUE))
			{
				echo 'Unable to create "'.$path.'" folder.<br />';
				exit;
			}
			umask($old);
		}

		if ($products_count > 0)
		{
			// set headers to the csv file
			// (note the page break '\r\n' at the end is important!)
			// user below carriage returned list to compare and count info
			/*
				Prod ID,
				Prod No,
				Prod Name,
				Prod Desc,
				Prod Date,
				Seque,
				Public,
				Publish,
				Publish Date,
				Size Mode,
					Cat ID,
				Cat,
					Subcat ID,
				Subcat,
				Retail Price,
				Sale Price,
				Wholesale Price,
				Wholesale Clearance Price,
					Designer ID,
				Designer Slug,
					Vendor ID,
				Vendor Name,
				Vendor Code,
				Vendor Type,
				Styles Facet,
				Events Facet,
				Materials Facet,
				Trends Facet,
				Colors Facet,
				Clearance,
				Stock ID,
				Color Name,
					Color Code,
				Color Publish,
				Primary Color,
				Stock Date,
				Size 0,Size 2,Size 4,Size 6,Size 8,Size 10,Size 12,Size 14,Size 16,Size 18,Size 20,Size 22
				Size S, Size M, Size L, Size XL, Size XXL, Size XL1, Size XL2

			*/
			$headers = "Prod ID,Prod No,Prod Name,Prod Desc,Prod Date,Seque,Public,Publish,Publish Date,Size Mode,Cat ID,Cat,Subcat ID,Subcat,Retail Price,Sale Price,Wholesale Price,Wholesale Clearance Price,Designer ID,Designer Slug,Vendor ID,Vendor Name,Vendor Code,Vendor Type,Styles Facet,Events Facet,Materials Facet,Trends Facet,Colors Facet,Clearance,Stock ID,Color Name,Color Code,Color Publish,Primary Color,Stock Date,";
			if ($size_mode == '1')
			{
				$headers.= "Size 0,Size 2,Size 4,Size 6,Size 8,Size 10,Size 12,Size 14,Size 16,Size 18,Size 20,Size 22\r\n";
			}
			if ($size_mode == '0')
			{
				$headers.= "Size S, Size M, Size L, Size XL, Size XXL, Size XL1, Size XL2\r\n";

			}

			// write the contents to the end of the file
			$file_handle = @fopen($file, 'wb');
			fwrite($file_handle, $headers);
			fclose($file_handle);

			foreach ($products as $product)
			{

				// set content and append to the csv file
				// we need to convert the object to array

				$content = array(
					$product->prod_id,
					$product->prod_no,
					$product->prod_name,
					$product->prod_desc,
					$product->prod_date,
					$product->seque,
					$product->public,
					$product->publish,
					$product->publish_date,
					$product->size_mode,
					$product->cat_id,
					$product->c_url_structure,
					$product->subcat_id,
					$product->sc_url_structure,
					$product->less_discount,
					$product->catalogue_price,
					$product->wholesale_price,
					$product->wholesale_price_clearance,
					$product->designer,
					$product->d_url_structure,
					$product->vendor_id,
					$product->vendor_name,
					$product->vendor_code,
					$product->type,
					$product->styles,
					$product->events,
					$product->materials,
					$product->trends,
					$product->color_facets,
					$product->clearance,
					$product->st_id,
					$product->color_name,
					$product->color_code,
					$product->new_color_publish,
					$product->primary_color,
					$product->stock_date
				);
				if ($size_mode == '1')
				{
					array_push($content, $product->size_0);
					array_push($content, $product->size_2);
					array_push($content, $product->size_4);
					array_push($content, $product->size_6);
					array_push($content, $product->size_8);
					array_push($content, $product->size_10);
					array_push($content, $product->size_12);
					array_push($content, $product->size_14);
					array_push($content, $product->size_16);
					array_push($content, $product->size_18);
					array_push($content, $product->size_20);
					array_push($content, $product->size_22);
				}
				if ($size_mode == '0')
				{
					array_push($content, $product->size_ss);
					array_push($content, $product->size_sm);
					array_push($content, $product->size_sl);
					array_push($content, $product->size_sxl);
					array_push($content, $product->size_sxxl);
					array_push($content, $product->size_sxl1);
					array_push($content, $product->size_sxl2);
				}

				// write the contents to the end of the file
				$file_handle = @fopen($file, 'a');
				fputcsv($file_handle, $content);
			}
		}

		fclose($file_handle);

		// we now create the php file to be able to download the csv file
		// get vital info for path purposes
		$filename2 = 'products_'.$active_designer.$cav_filename_suffix;
		$file2 = $path.$filename2.'.php';

		$php_contents = "<?php
header('Content-disposition: attachment; filename=".$filename.".csv');
header('Content-type: text/plain');
readfile('".$filename.".csv');";

		// write the contents to the end of the file
		$file_handle2 = @fopen($file2, 'wb');
		fwrite($file_handle2, $php_contents);
		fclose($file_handle2);
	}

	// ----------------------------------------------------------------------

}
