<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * MPDF Class
 *
 * mPDF is a PHP library which generates PDF files from UTF-8 encoded HTML.
 * Link: https://mpdf.github.io/
 *
 * 1.0  Download and extract mPDF
 * 2.0  Create a new file in the CodeIgniter's application/libraries folder
 *		a class library (M_pdf.php - example) and add the following code:

include_once APPPATH.'/third_party/mpdf/mpdf.php';

class M_pdf {

   public $param;
   public $pdf;

   public function __construct($param = '"en-GB-x","A4","","",10,10,10,10,6,3')
   {
	   $this->param =$param;
	   $this->pdf = new mPDF($this->param);
   }
}

 * 3.0  To use on the controller classes, simply load the library, generate the
 *		pdf, and output it accordingly
 *
 * Reference link to above tuts:
 * https://arjunphp.com/generating-a-pdf-in-codeigniter-using-mpdf/
 * Another helpful link:
 * https://arjunphp.com/create-pdf-using-mpdf-codeigniter-3/
 *
 * @package		CodeIgniter
 * @subpackage	Third Party Library
 * @category	mpdf
 * @author		WebGuy
 * @link
 */

require_once(APPPATH."third_party/erp/helpers/vendor/mpdf/mpdf/mpdf.php");

class M_pdf_lookbook
{
	/**
	 * This Class database object holder
	 *
	 * @var	string
	 */
	public $param = '';

	/**
	 * This Class database object holder
	 *
	 * @var	object
	 */
	public $pdf = '';

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @param	array	$param	Initialization parameter - the item id
	 *
	 * @return	void
	 */
	public function __construct()
	{
		// http://www.smaizys.com/php/mpdf-html-to-pdf-introduction/
		$this->pdf = new mPDF("en-GB-x",array("350","260"),"","",10,10,10,10,6,3);
	}

	// --------------------------------------------------------------------

}
