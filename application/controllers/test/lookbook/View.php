<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 *
 *
 */
class View extends MY_Controller
{
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();
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
			//echo 'An order ID# is needed...';
			//exit;
		}

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');
		$this->load->library('orders/order_details');
		$this->load->library('products/size_names');
		$this->load->library('categories/categories_tree');
		$this->load->library('image_lib');
		$this->load->library('lookbook/m_pdf_lookbook');

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

		// other data
		$this->data['view_params'] = 'invoice_pdf';
		$this->data['status'] = $this->order_details->status_text;
		//$this->data['order_items'] = $this->order_details->items();

		/* *
		$i = 1;
		foreach ($this->order_details->items() as $designer => $items)
		{
			// set the order items
			$this->data['order_items'] = $items;

			// we need to get the size mode and size names array
			foreach ($items as $item)
			{
				$des_options = json_decode($item->webspace_options, TRUE);
				break;
			}
			$this->data['size_mode'] = $des_options['size_mode'];
			$this->data['size_names'] = $this->size_names->get_size_names($des_options['size_mode']);
			$this->data['designer'] = $designer;

			// load the view
			$html = $this->load->view('templates/lookbook', $this->data, TRUE);

			if ($i > 1)
			{
				$this->m_pdf->pdf->WriteHTML('<pagebreak>');
			}

			// generate pdf
			$this->m_pdf->pdf->WriteHTML($html);

			// set filename and file path
			$pdf_file_path = 'assets/pdf/pdf_invoice_'.$designer.'.pdf';

			$i++;
		}
		// */

		//$this->m_pdf->pdf->showImageErrors = true;

		$lookbook_temp_dir = 'uploads/lookbook_temp/';

		// and, create folder where necessary
		if ( ! file_exists($lookbook_temp_dir))
		{
			$old = umask(0);
			if ( ! mkdir($lookbook_temp_dir, 0777, TRUE))
			{
				$error_message = 'ERROR: Unable to create "'.$lookbook_temp_dir.'" folder.';

				// nothing more to do...
				echo $error_message;
				exit;
			}
			umask($old);
		}

		// array of items
		$items_array = array(
			//'D1242LR_BLAC1',
			//'D1241LR_NAVYNUDE1'
			//'D7806L_BLACSILV1',
			//'9566V_BLAC1'
			'D9998L_RED1' => array('RED', 'evening_dresses')
			//'D9979L_PEACO1'
			//'ZW17062_GREY1'
		);

		$i = 2;
		$html = '';
		foreach ($items_array as $item => $options)
		{
			// get product details
			$exp = explode('_', $item);
			$product = $this->product_details->initialize(
				array(
					'tbl_product.prod_no' => $exp[0],
					'color_code' => $exp[1]
				)
			);

			if ( ! $product)
			{
				// nothing more to do...
				echo 'ERROR: Product does not exists - '.$item;
				exit;
			}

			$style_no = $item;
			$prod_no = $exp[0];
			$color_code = $exp[1];
			$color_name = $this->product_details->get_color_name($color_code);
			$price = ''; // @$options[2] ?: $product->wholesale_price;
			$category = $this->categories_tree->get_name($options[1]) ?: 'Elegant Fully Covered Dresses';

			// get available sizes
			$size_names = $this->size_names->get_size_names($product->size_mode);
			$available_sizes = array();
			foreach ($size_names as $size_label => $s)
			{
				// do not show zero stock sizes
				if ($product->$size_label === '0') continue;

				// create available sizes with stocks array
				$available_sizes[$s] = $product->$size_label;
			}

			/**
			// get logo and set it on lookbook_temp folder
			*/
			if ( ! file_exists($product->designer_logo))
			{
				// get default logo folder
				$source_designer_logo = 'assets/images/logo/logo-'.$product->designer_slug.'.png';
				$logo_image_file = 'logo-'.$product->designer_slug.'.png';
				//echo 'not exists<br />';
			}
			else
			{
				$source_designer_logo = $product->designer_logo;
				$exp1 = explode('/', $source_designer_logo);
				$logo_image_file = $exp1[count($exp1) - 1];
			}

			//echo $source_designer_logo;
			//echo '<br />';
			//echo '<img src="'.base_url().$source_designer_logo.'" />';
			//die();

			$config['image_library']	= 'gd2';
			$config['quality']			= '100%';
			$config['source_image'] 	= $source_designer_logo;
			$config['new_image'] 		= $lookbook_temp_dir.$logo_image_file;
			$config['maintain_ratio'] 	= TRUE;
			$config['width']         	= 292;
			$config['height']       	= 47;
			$this->load->library('image_lib');
			$this->image_lib->initialize($config);
			if ( ! $this->image_lib->resize())
			{
				// nothing more to do...
				echo 'ERROR: Logo regeneration error.<br />';
				echo $source_designer_logo;
				echo $this->image_lib->display_errors();
				exit;
			}
			$this->image_lib->clear();

			/**
			// create lookbook
			*/
			$this->load->helper('create_linesheet');
			$create = create_lookbook(
				$i,
				$prod_no,
				$color_name,
				$price,
				$lookbook_temp_dir,
				$product->media_path,
				$product->media_name,
				$lookbook_temp_dir.$logo_image_file,
				$category,
				$available_sizes
			);

			if ( ! $create)
			{
				// nothing more to do...
				echo 'Error in creating lookbook.';
				exit;
			}
			// */

			if ($i > 2) $html.= '<pagebreak>';

			$html.= '<img src="'.$create.'" />';

			$i  = $i + 2;
		}

		// generate image
		//$this->m_pdf->pdf->Image('uploads/products/basixblacklabel/womens_apparel/dresses/evening_dresses/D9776L_BLAC1_f.jpg', 0, 0, 800, 1200, 'jpg', '', '', false);
		//$this->m_pdf->pdf->Image('uploads/products/basixblacklabel/womens_apparel/dresses/evening_dresses/D9776L_BLAC1_f.jpg', 0, 0);

		//$html = '<img src="uploads/products/basixblacklabel/womens_apparel/dresses/evening_dresses/D9776L_BLAC1_f.jpg" />';
		//$html.= '<img src="uploads/products/basixblacklabel/womens_apparel/dresses/evening_dresses/D9776L_BLAC1_b.jpg" />';

		// generate pdf
		$this->m_pdf_lookbook->pdf->WriteHTML($html);

		// set filename and file path
		$pdf_file_path = 'assets/pdf/pdf_lookbook.pdf';

		// download it "D" - download, "I" - inline, "F" - local file, "S" - string
		$this->m_pdf_lookbook->pdf->Output(); // output to browser
		//$this->m_pdf_lookbook->pdf->Output($pdf_file_path, "F");

		/* *
		// The location of the PDF file
		// on the server
		$filename = $pdf_file_path;

		// Header content type
		header("Content-type: application/pdf");

		header("Content-Length: " . filesize($filename));

		// Send the file to the browser.
		readfile($filename);
		// */
	}

	// --------------------------------------------------------------------

}
