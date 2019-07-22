<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

	/**
	 * Some properteis
	 *
	 * @return	void
	 */
	public $d_url_structure;
	public $c_url_structure;
	public $sc_url_structure;


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
		// set params
		$this->d_url_structure = 'basixblacklabel';
		$this->c_url_structure = 'apparel';
		
		// for each subcat
		$subcats = array('cocktail-dresses', 'evening-dresses', 'skirts', 'shorts', 'tops', 'jumpsuits', 'bridal_dresses');
		
		foreach ($subcats as $subcat)
		{
			$this->sc_url_structure = $subcat;
			$this->gen_csv();
		}
		
		echo 'Done!<br />';
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function gen_csv()
	{
		// get vital info for path purposes
		$path = './csv/';
		$filename = 'odoo_products_'.$this->d_url_structure.'_'.$this->sc_url_structure;
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
		
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		
		// get the products list based on designer and category
		$params['with_stocks'] = FALSE; // show regardless of stock qty
		$params['show_private'] = TRUE; // show public & private items
		$this->load->library('products/products_list', $params);
		$this->products = $this->products_list->select(
			array( // where conditions
				'designer.url_structure' => $this->d_url_structure,
				'c1.category_slug' => $this->c_url_structure,
				'c2.category_slug' => $this->sc_url_structure
			),
			array( // order conditions
			)
		);
		
		if ($this->products_list->row_count > 0)
		{
			// set headers to the csv file
			// (note the page break '\r\n' at the end is important!)
			$content = "Prod No,Prod Name,Prod Desc,Prod Date,Retail Price,Sale Price,Wholesale Price,Wholesale Clearance Price,Designer,Designer Slug,Vendor Name,Vendor Code,Vendor Type,Category,Sub Category,Color Name,Color Code,Primary Color,Public,Publish,Stock ID,Size 0,Size 2,Size 4,Size 6,Size 8,Size 10,Size 12,Size 14,Size 16,Size 18,Size 20,Size 22\r\n";
			
			// write the contents to the end of the file
			$file_handle = @fopen($file, 'wb');
			fwrite($file_handle, $content);
			fclose($file_handle);
			
			foreach ($this->products as $product)
			{
				// set content and append to the csv file
				// we need to convert the object to array
				$content = array($product->prod_no, $product->prod_name, $product->prod_desc, $product->prod_date, $product->less_discount, $product->catalogue_price, $product->wholesale_price, $product->wholesale_price_clearance, $product->designer, $product->d_url_structure, $product->vendor_name, $product->vendor_code, $product->type, $product->c_url_structure, $product->sc_url_structure, $product->color_name, $product->color_code, $product->primary_color, $product->public, $product->publish, $product->st_id, $product->size_0, $product->size_2, $product->size_4, $product->size_6, $product->size_8, $product->size_10, $product->size_12, $product->size_14, $product->size_16, $product->size_18, $product->size_20, $product->size_22);
				
				// write the contents to the end of the file
				$file_handle = @fopen($file, 'a');
				fputcsv($file_handle, $content);
			}
		}
		
		fclose($file_handle);
	}
	
	// ----------------------------------------------------------------------
	
}
